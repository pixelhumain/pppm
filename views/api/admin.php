

<li class="block" id="blockaddAdmin">
	Add an admin
	<div class="apiForm addAdminEntry">
		<select id="citizenaddAdmin">
			<option></option>
			<?php 
			
				$users = PHDB::find( PHType::TYPE_CITOYEN, array( "applications.".$this->module->id => array('$exists'=>true) ) );
				foreach ($users as $u) {
					echo '<option value="'.$u["_id"].'">'.(( isset( $u["email"] ) ) ? $u["email"] : $u["_id"])." ".'</option>';
				}
			?>
		</select><br/>
		<select id="rightaddAdmin">
			<option></option>
			<option value="admin">admin</option>
		</select><br/>
		<a href="javascript:addAdminEntry()">Test it</a><br/>
		<div id="addAdminEntryResult" class="result fss"></div>
		<script>
			function addAdminEntry(){
				params = {  "id" : $("#citizenaddAdminEntry").val() , 
				    		"app" : "<?php echo $this->module->id?>"};
				testitpost("addAdminEntryResult",baseUrl+'/<?php echo $this::$moduleKey?>/api/addappadmin',params);
			}
			
		</script>
	</div>
</li>

<li class="block" id="blockModerationSettings">
	Delete a Users
</li>

<li class="block" id="blockdeleteSurvey">
	Delete a Survey
	<div class="apiForm deleteSurvey">
		<select id="sessiondeleteSurvey">
			<option></option>
			<?php 
				$surveys = PHDB::find( PHType::TYPE_SURVEYS, array("type"=>Survey::TYPE_SURVEY));
				foreach ($surveys as $value) {
					echo '<option value="'.$value["_id"].'">'.$value["name"]." ".'</option>';
				}
			?>
		</select><br/>
		<a href="javascript:deleteSurvey()">Test it</a><br/>
		<div id="deleteSurveyResult" class="result fss"></div>
		<script>
			function deleteSurvey() {
				params = { "survey" : $("#sessiondeleteSurvey").val() , 
				    		"app" : "<?php echo $this->module->id?>"};
				testitpost("deleteSurveyResult",baseUrl+'/<?php echo $this::$moduleKey?>/api/deletesurvey',params);
			}
		</script>
	</div>
</li>

<li class="block" id="blockdeleteEntry">
	Delete an Entry
	<div class="apiForm deleteEntry">
		<select id="sessiondeleteEntry">
			<option></option>
			<?php 
				$surveys = PHDB::find( PHType::TYPE_SURVEYS, array("type"=>Survey::TYPE_ENTRY));
				foreach ($surveys as $value) {
					echo '<option value="'.$value["_id"].'">'.$value["name"].' - '.$value["survey"].'</option>';
				}
			?>
		</select><br/>
		<a href="javascript:deleteEntry()">Test it</a><br/>
		<div id="deleteEntryResult" class="result fss"></div>
		<script>
			function deleteEntry() {
				params = { "survey" : $("#sessiondeleteEntry").val() , 
				    		"app" : "<?php echo $this->module->id?>"};
				testitpost("deleteEntryResult",baseUrl+'/<?php echo $this::$moduleKey?>/api/deletesurvey',params);
			}
		</script>
	</div>
</li>

<li class="block" id="blockModerationSettings">
	Moderation Settings
</li>

<li class="block" id="blockModerate">
	Moderate an Entry
	<div class="apiForm moderateEntry">
		<select id="sessionmoderateEntry">
			<option></option>
			<?php 
				$Surveys = PHDB::find( PHType::TYPE_SURVEYS, array("type"=>"entry",'$or'=>array( array( "applications.survey.cleared"=>false),array("applications.survey.cleared"=>"refused"))));
				foreach ($Surveys as $value) {
					echo '<option value="'.$value["_id"].'">'.$value["name"]." ".'</option>';
				}
			?>
		</select><br/>
		<select id="moderateAction">
			<option></option>
			<option value=1>accept</option>
			<option value=0>refuse</option>
		</select><br/>
		<a href="javascript:moderateEntry()">Moderate it</a><br/>
		<a href="javascript:getEntry()">Get it</a><br/>
		<div id="moderateEntryResult" class="result fss"></div>
		<script>
			function moderateEntry(){
				params = { "survey" : $("#sessionmoderateEntry").val() , 
							"action" : $("#moderateAction").val() , 
				    		"app" : "<?php echo $this->module->id?>"};
				testitpost("moderateEntryResult",baseUrl+'/<?php echo $this::$moduleKey?>/api/moderateentry',params);
			}
			function getEntry(){
				params = { "where" : { 
							   "email" : $("#emailmoderateEntry").val() , 
				    	   	   "name" : $("#namemoderateEntry").val() , 
					    	   "type" : "entry"
				    	   	},
				    	   	"collection":"surveys"
				    	};
				testitpost("moderateEntryResult",baseUrl+'/<?php echo $this::$moduleKey?>/api/getby',params);
			}
		</script>
	</div>
</li>