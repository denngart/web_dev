<!doctype html>
<html>
	<head>
		<title>Fetch records from MySQL Database with Vue.js and PHP</title>


		<script src="https://unpkg.com/vuejs-datepicker"></script>
		<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
        <script src='https://unpkg.com/axios/dist/axios.min.js'></script>
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
			
			<input type='button' @click='recordsearch()' value='Abschicken'>
			<input type='button' @click='load_lastfilter()' value='Filter laden'>
			<input type='button' @click='clear()' value='clear'>
			<br> test {{speicher}} <br>
						<!-- List records -->

			<table border='1' width='80%' style='border-collapse: collapse;'>
				<tr>
					<th>Username</th>
					<th>Name</th>
					<th>Email</th>
				</tr>

				<tr v-for='user in users'>
					<td>{{ user.username }}</td>
					<td>{{ user.name }}</td>
					<td>{{ user.email }}</td>
					
				</tr>
			</table>
			
		</div>
		<!-- Script -->
		<script>
			var app = new Vue({
				el: '#myapp',
				
				data: {
					users: "",
					userid: "",
					username: "",
					name:"",
					email:"",
					speicher:"",
					load:""
				},				
				methods: {
					allRecords: function(){
						
						axios.get('get_database.php')
						.then(function (response) {
						    app.users = response.data;
							
						})
						.catch(function (error) {
						    console.log(error);
						});
					},
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
					clear: function(){
						this.username ="";
						this.name ="";
						this.email ="";
						app.users = "";
					},
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
							app.users = "";	
						}
						
					}
				}
			})

		</script>
		
	</body>
</html>