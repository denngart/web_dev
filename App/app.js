var app = new Vue({
    el: '#myapp',
    
    data: {
        users:[],
        userid: "",
        username: "",
        name:"",
        email:"",
        speicher:"",
        load:"",
        currentSort:'name',
        currentSortDir:'asc'
    },				
    methods: {
        //all Datensätze abrufen

        sort:function(s) {
            //if s == current sort, reverse
            if(s === this.currentSort) {
              this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
            }
            this.currentSort = s;
          }
        ,
        allRecords: function(){
            
            axios.get('get_database.php')
            .then(function (response) {
                app.users = response.data;
                
            })
            .catch(function (error) {
                console.log(error);
            });
        },
// Letzer Filter aus CSV Datei laden 
        load_lastfilter: function(){	
                axios.get('loadfilter.php', {
                    params: {		
                    }	
                })
                  .then(function (response) {
                    app.username = response.data[0][0];
                    app.name = response.data[0][1];
                    app.email = response.data[0][2];
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },
            //Neue Suche beginnen 
        clear: function(){
            this.username ="";
            this.name ="";
            this.email ="";
            app.users = [];
        },
        //Suche Starten wenn alle Felder nicht leer sind sonst Tabelle = "" setzen 
        recordsearch: function(){
            
            if(this.username != "" || this.name != "" || this.email != "" ){
                axios.get('get_database.php', {
                    params: {
                        username:this.username,
                        name:this.name,
                        email:this.email							
                    }	
                })
                  .then(function (response) {
                    app.users = response.data;					
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            }
            else
            {
                app.users = [];	
            }
            
        }
    },
        computed:{
            sortedUser:function() {
              return this.users.sort((a,b) => {
                let modifier = 1;
                if(this.currentSortDir === 'desc') modifier = -1;
                if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                return 0;
              });
            }
          }
    })