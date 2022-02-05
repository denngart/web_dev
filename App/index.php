<!doctype html>
<html>
	<head>
		<title>Fetch records from MySQL Database with Vue.js and PHP</title>
		<script src="https://unpkg.com/vuejs-datepicker"></script>
		<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
        <script src='https://unpkg.com/axios/dist/axios.min.js'></script>
		<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div id='myapp'>
			<!-- Select All records -->
			<input type='button' @click='allRecords()'@keyup.enter="enterClicked()" value='Select All users'>
			<br><br>
			<!-- Eingabe Suche  -->
			<input type='text' v-model='username' placeholder="Login">
			<input type='text' v-model='name' placeholder="Vollständiger Name">
			<input type='text' v-model='email' placeholder="E-mail">
			<!-- Butons für Bedingung -->
			<input type='submit' class="glyphicon glyphicon-search" @click='recordsearch()' value='Suche'>
			<input type='button' class="btn btn-info" @click='load_lastfilter()' value='Filter laden'>
			<input type='button' class="btn btn-info" @click='clear()' value='clear'>
			<br>   <br>
						<!-- List records -->

			<table class="table table-striped">
			<thead>
				<tr>		
					<th @click="sort('username')">Username</th>
					<th @click="sort('name')">Name</th>
					<th @click="sort('email')">Email</th>
				</tr>
				</thead>
				<!-- Durchlauf des array user welches durch die Methoden allRecords() und recordsearch() aus der DB abgerufen wird -->
				<tbody>
			
				<tr v-for='user in sortedUser'>
					<td>{{ user.username }}</td>
					<td>{{ user.name }}</td>
					<td>{{ user.email }}</td>
					
				</tr>
				
			</table>
			debug: sort={{currentSort}}, dir={{currentSortDir}}
		</div>
		<!-- Script -->
		<script>
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
			

		</script>
		
	</body>
</html>