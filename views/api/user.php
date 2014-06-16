<ul>
	<li class="block" id="blockCommunect">
		<a href="/ph/<?php echo $this->module->id?>/api/communect">se Comunecter</a><br/>
		<div class="fss">
			se communecter c'est juste suivre l'activité d'un CP <br/>
			Il suffit d'un email et d'un CP<br/>
			method type : POST <br/>
		</div>
		<div class="apiForm communect">
			email : <input type="text" name="emailCommunect" id="emailCommunect" value="<?php echo $this->module->id?>@<?php echo $this->module->id?>.com" /><br/>
			code postal  : <input type="text" name="cpCommunect" id="cpCommunect" value="97421" /><br/>
			<a href="javascript:communect()">Communect</a><br/>
			<div id="communectResult" class="result fss"></div>
			<script>
				function communect(){
					params = { "email" : $("#emailCommunect").val() , 
					    	   "cp" : $("#cpCommunect").val()
					    	};
					testitpost("communectResult",baseUrl+'/<?php echo $this->module->id?>/api/communect',params);
				}
			</script>
			
		</div>
	</li>

	<li class="block" id="blockLogin">
		<a href="/ph/<?php echo $this->module->id?>/api/login">Login</a><br/>
		<a href="/ph/site/logout">Logout</a><br/>
		<div class="fss">
			Il faut etre loguer par email, cp, et mot de passe<br/>
			method type : POST <br/>
		</div>
		<div class="apiForm login">
			email : <input type="text" name="emailLogin" id="emailLogin" value="<?php echo $this->module->id?>@<?php echo $this->module->id?>.com" /><br/>
			pwd : <input type="password" name="pwdLogin" id="pwdLogin" value="1234" /><br/>
			<a href="javascript:login()">Test it</a><br/>
			<div id="loginResult" class="result fss"></div>
			<script>
				function login(){
					params = { "email" : $("#emailLogin").val() , 
					    	   "pwd" : $("#pwdLogin").val(),
					    	   "loginRegister" :1,
					    	   "app":"<?php echo $this->module->id?>"
					    	};
					testitpost("loginResult",baseUrl+'/<?php echo $this->module->id?>/api/login',params);
					
				}
			</script>
			
		</div>
	</li>

	<li class="block"><a href="/ph/<?php echo $this->module->id?>/api/saveUser"  id="blockSaveUser">Create/Update user</a><br/>
		<div class="fss">
			url : /ph/<?php echo $this->module->id?>/api/saveUser<br/>
			method type : POST <br/>
			Form inputs : email,postalcode,pwd,phoneNumber(is optional)<br/>
			return json object {"result":true || false}
		</div>
		<div class="apiForm createUser">
			name : <input type="text" name="nameSaveUser" id="nameSaveUser" value="<?php echo $this->module->id?> User" /><br/>
			email* : <input type="text" name="emailSaveUser" id="emailSaveUser" value="<?php echo $this->module->id?>@<?php echo $this->module->id?>.com" /><br/>
			cp* : <input type="text" name="postalcodeSaveUser" id="postalcodeSaveUser" value="97421" /><br/>
			pwd* : <input type="text" name="pwdSaveUser" id="pwdSaveUser" value="1234" /><br/>
			phoneNumber : <input type="text" name="phoneNumberSaveUser" id="phoneNumberSaveUser" value="1234" />(for SMS)<br/>
			
			<a href="javascript:addUser()">Test it</a><br/>
			<div id="createUserResult" class="result fss"></div>
			<script>
				function addUser(){
					params = { "email" : $("#emailSaveUser").val() , 
					    	   "name" : $("#nameSaveUser").val() , 
					    	   "cp" : $("#postalcodeSaveUser").val() ,
					    	   "pwd":$("#pwdSaveUser").val() ,
					    	   "phoneNumber" : $("#phoneNumberSaveUser").val(),
					    		"app" : "<?php echo $this->module->id?>"};
					testitpost("createUserResult",baseUrl+'/<?php echo $this->module->id?>/api/saveUser',params);
				}
			</script>
		</div>
	</li>
	
	<li class="block"><a href="/ph/<?php echo $this->module->id?>/api/getUser/email/<?php echo $this->module->id?>@<?php echo $this->module->id?>.com"  id="blockGetUser">Get User</a><br/>
		<div class="fss">
			url : /ph/<?php echo $this->module->id?>/api/getUser/email/oceatoon@gmail.com<br/>
			method type : GET <br/>
			param : email<br/>
			email : <input type="text" name="getUseremail" id="getUseremail" value="<?php echo $this->module->id?>@<?php echo $this->module->id?>.com" /><br/>
			<a href="javascript:getUser()">Test it</a><br/>
			<div id="getUserResult" class="result fss"></div>
			<script>
				function getUser(){
					testitget("getUserResult",baseUrl+'/<?php echo $this->module->id?>/api/getUser/email/'+$("#getUseremail").val());
				}
				
			</script>
		</div>
	</li>


	<li class="block"><a href="/ph/<?php echo $this->module->id?>/api/getpeopleby"  id="blockgetPeople">Get People by codepostal </a><br/>
		<div class="fss">
			url : /ph/<?php echo $this->module->id?>/api/getpeopleby<br/>
			method type : POST <br/>
			cp* : <input type="text" name="postalcodegetPeople" id="postalcodegetPeople" value="97421" /><br/>
			<a href="javascript:getpeopleby()">Test it</a><br/>
			<a href="javascript:countpeopleby()">Count it</a><br/>
			<div id="getPeopleResult" class="result fss"></div>
			<script>
				function getpeopleby(){
					params = { "cp" : $("#postalcodegetPeople").val() };
					testitpost("getPeopleResult",baseUrl+'/<?php echo $this->module->id?>/api/getpeopleby',params);
				}
				function countpeopleby(){
					params = { "cp" : $("#postalcodegetPeople").val() };
					testitpost("getPeopleResult",baseUrl+'/<?php echo $this->module->id?>/api/getpeopleby/count/1',params);
				}
			</script>
		</div>

	</li>

	<li class="block"><a href="/ph/<?php echo $this->module->id?>/api/inviteUser"  id="blockinviteUser">Invite User</a><br/>
		<div class="fss">
			url : /ph/<?php echo $this->module->id?>/api/inviteUser<br/>
			method type : POST <br/>
			param : email<br/>
			email : <input type="text" name="inviteUseremail" id="inviteUseremail" value="<?php echo $this->module->id?>@<?php echo $this->module->id?>.com" /><br/>
			<a href="javascript:inviteUser()">Test it</a><br/>
			<div id="inviteUserResult" class="result fss"></div>
			<script>
				function inviteUser(){
					params = { "email" : $("#inviteUseremail").val() };
					testitpost("inviteUserResult",baseUrl+'/<?php echo $this->module->id?>/api/inviteUser',params);
				}
				
			</script>
		</div>
	</li>

	<li class="block"><a href="/ph/<?php echo $this->module->id?>/api/getnodeby"  id="blockgetnodeby">Get content of a Node (friends, ...)</a><br/>
		<div class="fss">
			url : /ph/<?php echo $this->module->id?>/api/getnodeby<br/>
			method type : GET <br/>
			type : <input type="text" name="getnodebyType" id="getnodebyType" value="friends" /><br/>
			<a href="javascript:getnodeby()">Test it</a><br/>
			<a href="javascript:countgetnodeby()">Count it</a><br/>
			<div id="getnodebyResult" class="result fss"></div>
			<script>
				function getnodeby(){
					testitget("getnodebyResult",baseUrl+'/<?php echo $this->module->id?>/api/getnodeby/type/'+$("#getnodebyType").val());
				}
				function countgetnodeby(){
					testitget("getnodebyResult",baseUrl+'/<?php echo $this->module->id?>/api/getnodeby/type/'+$("#getnodebyType").val()+'/count/1');
				}
			</script>
		</div>

	</li>
</ul>	