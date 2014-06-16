
<div class="modal fade" id="proposerloiForm" tabindex="-1" role="dialog" aria-labelledby="proposerloiFormLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="proposerloiFormLabel" >Faites une Proposition :</h3>
      </div>
      <div class="modal-body">
      	<p> blah blah.
        Use #HashTags in text and @tags for people
        These will be automatically converted
        Surligner le texte qui va dans le titre
        </p>
        title 
        <br/>
        <form id="saveEntryForm" action="">
        <input type="text" name="nameaddEntry" id="nameaddEntry" maxlength=100 value="" placeholder="100 caract. max." />
        <br/><br/>
        message
        <textarea id="message" style="width:100%;height:30px;vertical-align: middle" onkeyup="AutoGrowTextArea(this);$('#message1').val($('#message').val())"></textarea>
        </form>
        <div style="clear:both"></div>
      </div>
       <div class="modal-footer">
          
          <a class="btn btn-warning " href="javascript:;" onclick="$('#saveEntryForm').submit();return false;"  >Enregistrer</a>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
initT['proposerloiModalsInit'] = function(){
    $("#saveEntryForm").submit( function(event){
      //log($(this).serialize());
      event.preventDefault();
      $("#proposerloiForm").modal('hide');
      //toggleSpinner();
      var hashtagList = getHashTagList( $("#message").val() );
      log(hashtagList.hashtags);
      //log(hashtagList.people);

      params = { "survey" : "<?php echo (string)$survey['_id']?>", 
               "email" : "<?php echo Yii::app()->session['userEmail']?>" , 
               "name" : $("#nameaddEntry").val() , 
               "tags" : hashtagList.hashtags ,
               "message":$("#message").val(),
               "cp" : "<?php echo $survey['cp']?>" , 
               "type" : "entry"};

     $.ajax({
        type: "POST",
        url: '<?php echo Yii::app()->createUrl($this->module->id."/api/saveSession")?>',
        data: params,
        success: function(data){
          if(data.result){
              window.location.reload();
          }
          else {
                $("#flashInfo .modal-body").html(data.msg);
                $("#flashInfo").modal('show');
          }
          //toggleSpinner();
        },
        dataType: "json"
      });
    
    });
  
    
};

function getHashTagList(mystr){
  var strT = mystr.split(" ");
  hashtags = "";
  people = "";
  $.each(strT,function(i,v){
    if(v.indexOf("#")==0 && v != "#"){
      //log(v);
      if(hashtags != "" )
        hashtags += ",";
      hashtags += v.substring(1,v.length);
    }
    if(v.indexOf("@")==0 && v != "@"){
      //log(v);
      if(people != "" )
        people += ",";
      people += v.substring(1,v.length);
    }
  });
  log(hashtags)
  log(people);

  return {"hashtags":hashtags,"people":people};
}

</script>