<?php 
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($this->module->assetsUrl. '/css/mixitup/reset.css');
$cs->registerCssFile($this->module->assetsUrl. '/css/mixitup/style.css');
$cs->registerScriptFile($this->module->assetsUrl.'/js/jquery.sparkline.min.js' , CClientScript::POS_END);
$cs->registerScriptFile('http://code.highcharts.com/highcharts.js' , CClientScript::POS_END);
$cs->registerScriptFile('http://code.highcharts.com/modules/exporting.js' , CClientScript::POS_END);
$cs->registerScriptFile('http://cdn.jsdelivr.net/jquery.mixitup/latest/jquery.mixitup.min.js?v=2.1.5' , CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/api.js' , CClientScript::POS_END);
$this->pageTitle=$this::moduleTitle;

$commentActive = true;
?>

<style type="text/css">
  body {background: url("<?php echo Yii::app()->theme->baseUrl;?>/img/cloud.jpg") repeat;}
  .connect{border-radius: 8px; opacity: 0.9;background-color: #182129; margin-bottom: 10px;border:1px solid #3399FF;width: 100%;padding: 10px }
  button.filter,button.sort{color:#000;}
  a.btn{margin:3px;}
  .mix{border-radius: 8px;}

  /*.infolink{border-top:1px solid #fff}*/
  .leftlinks{float: left}
  .rightlinks{float: right}
  .leftlinks a.btn{background-color: yellow;border: 1px solid yellow;}
  /*.rightlinks a.btn{background-color: beige;border: 1px solid beige;}*/
  a.btn.alertlink{background-color:red;color:white;border: 1px solid red;}
  a.btn.golink{background-color:green;color:white;border: 1px solid green;}
  a.btn.voteUp{background-color: #93C22C;border: 1px solid green;}
  a.btn.voteUnclear{background-color: yellow;border: 1px solid yellow;}
  a.btn.voteMoreInfo{background-color: #789289;border: 1px solid #789289;}
  a.btn.voteAbstain{background-color: white;border: 1px solid white;}
  a.btn.voteDown{background-color: #db254e;border: 1px solid #db254e;}
  .step{ background-color: #182129;  opacity: 0.9;}
</style>
<section class="mt80 stepContainer">
  <div class=" home ">
  <div class="connect" >
    <div style="color:#3399FF;float:left;font-size: x-large;font-weight: bold">
      <?php echo "<a href='".Yii::app()->createUrl($this->module->id)."'>".$this::moduleTitle."</a> : <a href='".Yii::app()->createUrl($this->module->id)."'>".$title."</a>";
       if(isset($_GET["cp"])) echo " ".$_GET["cp"]?>
       <div style="font-size:x-small;font-weight: normal;color:white;">Nombres de votants inscrit : <?php echo $uniqueVoters?></div>
    </div>
    <div style="float:right;">
    <?php if( isset( Yii::app()->session["userId"])){?>
      <a href="#participer" class="btn" role="button" data-toggle="modal" title="mon compte" ><i class="icon-cog-1"></i><?php echo  $user["email"];?> <?php if($where["type"]=="entry" && $isModerator){ ?><span class="badge badge-info">ADMIN</span><?php } ?></a>
      <a href="<?php echo Yii::app()->createUrl('/site/logout')?>" class="btn " role="button" data-toggle="modal" title="deconnexion" ><i class="fa fa-signout"></i>Logout</a>
    <?php } else {?>
      <a href="#loginForm" class="btn " role="button" data-toggle="modal" title="connexion" ><i class="fa fa-signin"></i>Se Connecter pour voter</a>
    <?php } ?>
    </div>
    <div style="clear: both;"></div>
  </div>

<?php if( isset( Yii::app()->session["userId"]) && $where["type"]=="entry"){ ?>
  <div class="connect" style="margin-right: 50px;">
    <a href="#proposerloiForm" class="btn " role="button" data-toggle="modal" title="proposer une loi" ><i class="fa fa-signout"></i>Proposer</a>
    <textarea id="message1" style="width:45%;height:30px;vertical-align: middle" onkeyup="AutoGrowTextArea(this);$('#message').val($('#message1').val());"></textarea>
    <a href="#proposerloiForm" class="btn " role="button" data-toggle="modal" title="proposer une loi" title="envoyer" >Envoyer</a>
  </div>
<?php } ?>

<div class="controls" style="border-radius: 8px;">
  <?php
  if($where["type"]=="entry" && isset( Yii::app()->session["userId"])){?>
  <a href="#voterloiDescForm" class="btn " role="button" data-toggle="modal" title="proposer une loi" ><i class="fa fa-signout"></i>Voter les propositions</a>
  <?php }
    $alltags = array(); 
    $blocks = "";
    $tagBlock = "";
    $cpBlock = "";
    $cps = array();
    foreach ($list as $key => $value) 
    {
      $name = $value["name"];
      $email =  (isset($value["email"])) ? $value["email"] : "";
      if( !isset($_GET["cp"]) && $value["type"]=="survey" )
      {
        if(!in_array($value["cp"], $cps)){
          $cpBlock .= ' <button class="filter " data-filter=".'.$value["cp"].'">'.$value["cp"].'</button>';
          array_push($cps, $value["cp"]);
        }
      }

      $tags = "";
      if(isset($value["tags"]))
      {
        foreach ($value["tags"] as $t) 
        {
          if(!empty($t) && !in_array($t, $alltags))
          {
            array_push($alltags, $t);
            $tagBlock .= ' <button class="filter " data-filter=".'.$t.'">'.$t.'</button>';
          }
          $tags .= $t.' ';
        }
      }

      $cp = ($value["type"]=="survey") ? $value["cp"] : "" ; 
      $count = Yii::app()->mongodb->surveys->count ( array("type"=>"entry","survey"=>(string)$value["_id"]) );
      $link = $name;
      
      //check if I wrote this law
      $meslois = (isset( Yii::app()->session["userId"]) && Yii::app()->session["userEmail"] && $value['email'] == Yii::app()->session["userEmail"]) ? "myentries" : "";
      
      //checks if the user is a follower of the entry
      $followingEntry = (isset( Yii::app()->session["userId"]) 
                        && isset($value[ActionType::ACTION_FOLLOW]) 
                        && is_array($value[ActionType::ACTION_FOLLOW]) 
                        && in_array(Yii::app()->session["userId"], $value[ActionType::ACTION_FOLLOW])) ? "myentries":"";
      

      if ($value["type"]=="survey" && $count)
        $link = '<a class="titleMix '.$meslois.'" href="'.Yii::app()->createUrl("/".$this->module->id."/default/entries/surveyId/".(string)$value["_id"]).'">'.$name.' ('.$count.')</a>' ;
      else if ($value["type"]=="entry")
        $link = '<a class="titleMix '.$meslois.'" onclick="entryDetail(\''.Yii::app()->createUrl("/".$this->module->id."/default/entry/surveyId/".(string)$value["_id"]).'\')" href="javascript:;">'.$name.'</a>' ;
      
      //$infoslink bring visual detail about the entry
      $infoslink = "";
      $infoslink .= (!empty($followingEntry)) ? "<i class='fa fa-rss infolink' ></i>" :"";
      $infoslink .= (!empty($meslois)) ? "<i class='fa fa-user infolink' ></i>" :"";

      
      //has loged user voted on this entry 
      //vote UPS
      $voteUpActive = ( isset( Yii::app()->session["userId"]) 
                     && isset($value[ActionType::ACTION_VOTE_UP])
                     && is_array($value[ActionType::ACTION_VOTE_UP]) 
                     && in_array( Yii::app()->session["userId"] , $value[ActionType::ACTION_VOTE_UP] )) ? "active":"";
      $voteUpCount = (isset($value[ActionType::ACTION_VOTE_UP."Count"])) ? $value[ActionType::ACTION_VOTE_UP."Count"] : 0 ;
      $hrefUp = (isset( Yii::app()->session["userId"]) && empty($voteUpActive)) ? "javascript:addaction('".$value["_id"]."','".ActionType::ACTION_VOTE_UP."')" : "";
      $classUp = $voteUpActive." ".ActionType::ACTION_VOTE_UP." ".$value["_id"].ActionType::ACTION_VOTE_UP;
      $iconUp = 'fa-thumbs-up';

      //vote ABSTAIN 
      $voteAbstainActive = (isset( Yii::app()->session["userId"]) 
                        && isset($value[ActionType::ACTION_VOTE_ABSTAIN])
                        && is_array($value[ActionType::ACTION_VOTE_ABSTAIN])
                        && in_array(Yii::app()->session["userId"], $value[ActionType::ACTION_VOTE_ABSTAIN])) ? "active":"";
      $voteAbstainCount = (isset($value[ActionType::ACTION_VOTE_ABSTAIN."Count"])) ? $value[ActionType::ACTION_VOTE_ABSTAIN."Count"] : 0 ;
      $hrefAbstain = (isset( Yii::app()->session["userId"]) && empty($voteAbstainActive)) ? "javascript:addaction('".(string)$value["_id"]."','".ActionType::ACTION_VOTE_ABSTAIN."')" : "";
      $classAbstain = $voteAbstainActive." ".ActionType::ACTION_VOTE_ABSTAIN." ".$value["_id"].ActionType::ACTION_VOTE_ABSTAIN;
      $iconAbstain = 'fa-circle';

      //vote UNCLEAR
      $voteUnclearActive = ( isset( Yii::app()->session["userId"]) 
                     && isset($value[ActionType::ACTION_VOTE_UNCLEAR])
                     && is_array($value[ActionType::ACTION_VOTE_UNCLEAR]) 
                     && in_array( Yii::app()->session["userId"] , $value[ActionType::ACTION_VOTE_UNCLEAR] )) ? "active":"";
      $voteUnclearCount = (isset($value[ActionType::ACTION_VOTE_UNCLEAR."Count"])) ? $value[ActionType::ACTION_VOTE_UNCLEAR."Count"] : 0 ;
      $hrefUnclear = (isset( Yii::app()->session["userId"]) && empty($voteUnclearCount)) ? "javascript:addaction('".$value["_id"]."','".ActionType::ACTION_VOTE_UNCLEAR."')" : "";
      $classUnclear = $voteUnclearActive." ".ActionType::ACTION_VOTE_UNCLEAR." ".$value["_id"].ActionType::ACTION_VOTE_UNCLEAR;
      $iconUnclear = "fa-pencil";

      //vote MORE INFO
      $voteMoreInfoActive = ( isset( Yii::app()->session["userId"]) 
                     && isset($value[ActionType::ACTION_VOTE_MOREINFO])
                     && is_array($value[ActionType::ACTION_VOTE_MOREINFO]) 
                     && in_array( Yii::app()->session["userId"] , $value[ActionType::ACTION_VOTE_MOREINFO] )) ? "active":"";
      $voteMoreInfoCount = (isset($value[ActionType::ACTION_VOTE_MOREINFO."Count"])) ? $value[ActionType::ACTION_VOTE_MOREINFO."Count"] : 0 ;
      $hrefMoreInfo = (isset( Yii::app()->session["userId"]) && empty($voteMoreInfoCount)) ? "javascript:addaction('".$value["_id"]."','".ActionType::ACTION_VOTE_MOREINFO."')" : "";
      $classMoreInfo = $voteMoreInfoActive." ".ActionType::ACTION_VOTE_MOREINFO." ".$value["_id"].ActionType::ACTION_VOTE_MOREINFO;
      $iconMoreInfo = "fa-question-circle";

      //vote DOWN 
      $voteDownActive = (isset( Yii::app()->session["userId"]) 
                        && isset($value[ActionType::ACTION_VOTE_DOWN]) 
                        && is_array($value[ActionType::ACTION_VOTE_DOWN]) 
                        && in_array(Yii::app()->session["userId"], $value[ActionType::ACTION_VOTE_DOWN])) ? "active":"";
      $voteDownCount = (isset($value[ActionType::ACTION_VOTE_DOWN."Count"])) ? $value[ActionType::ACTION_VOTE_DOWN."Count"] : 0 ;
      $hrefDown = (isset( Yii::app()->session["userId"]) && empty($voteDownActive)) ? "javascript:addaction('".(string)$value["_id"]."','".ActionType::ACTION_VOTE_DOWN."')" : "";
      $classDown = $voteDownActive." ".ActionType::ACTION_VOTE_DOWN." ".$value["_id"].ActionType::ACTION_VOTE_DOWN;
      $iconDown = "fa-thumbs-down";

      //votes cannot be changed, link become spans
      $avoter = "mesvotes";
      if( !empty($voteUpActive) || !empty($voteAbstainActive) || !empty($voteDownActive) || !empty($voteUnclearActive) || !empty($voteMoreInfoActive)){
        $linkVoteUp = (isset( Yii::app()->session["userId"]) && !empty($voteUpActive) ) ? "<span class='".$classUp."' ><i class='fa $iconUp' ></i></span>" : "";
        $linkVoteAbstain = (isset( Yii::app()->session["userId"]) && !empty($voteAbstainActive)) ? "<span class='".$classAbstain."'><i class='fa $iconAbstain'></i></span>" : "";
        $linkVoteUnclear = (isset( Yii::app()->session["userId"]) && !empty($voteUnclearActive)) ? "<span class='".$classUnclear."'><i class='fa  $iconUnclear'></i></span>" : "";
        $linkVoteMoreInfo = (isset( Yii::app()->session["userId"]) && !empty($voteMoreInfoActive)) ? "<span class='".$classMoreInfo."'><i class='fa  $iconMoreInfo'></i></span>" : "";
        $linkVoteDown = (isset( Yii::app()->session["userId"]) && !empty($voteDownActive)) ? "<span class='".$classDown."' ><i class='fa $iconDown'></i></span>" : "";
      }else{
        $avoter = "avoter";
        $linkVoteUp = (isset( Yii::app()->session["userId"])  ) ? "<a class='btn ".$classUp."' href=\" ".$hrefUp." \" title='".$voteUpCount." Pour'><i class='fa $iconUp' ></i></a>" : "";
        $linkVoteAbstain = (isset( Yii::app()->session["userId"]) ) ? "<a class='btn ".$classAbstain."' href=\"".$hrefAbstain."\" title=' ".$voteAbstainCount." Abstention'><i class='fa $iconAbstain'></i></a>" : "";
        $linkVoteUnclear = (isset( Yii::app()->session["userId"]) ) ? "<a class='btn ".$classUnclear."' href=\"".$hrefUnclear."\" title=' ".$voteUnclearCount." Pas Clair Rerédiger'><i class='fa $iconUnclear'></i></a>" : "";
        $linkVoteMoreInfo = (isset( Yii::app()->session["userId"]) ) ? "<a class='btn ".$classMoreInfo."' href=\"".$hrefMoreInfo."\" title=' ".$voteMoreInfoCount." Necessite plus dinformations'><i class='fa $iconMoreInfo'></i></a>" : "";
        $linkVoteDown = (isset( Yii::app()->session["userId"])) ? "<a class='btn ".$classDown."' href=\"".$hrefDown."\" title='".$voteDownCount." Contre'><i class='fa $iconDown'></i></a>" : "";
      }
      $hrefComment = "#commentsForm";
      $commentCount = 0;
      $linkComment = (isset( Yii::app()->session["userId"]) && $commentActive) ? "<a class='btn ".$value["_id"].ActionType::ACTION_COMMENT."' role='button' data-toggle='modal' href=\"".$hrefComment."\" title='".$commentCount." Commentaire'><i class='fa fa-comments '></i></a>" : "";
      $totalVote = $voteUpCount+$voteAbstainCount+$voteDownCount+$voteUnclearCount+$voteMoreInfoCount;
      $info = ($totalVote) ? '<span class="info">'.$totalVote.' sur <span class="info voterTotal">'.$uniqueVoters.'</span> voteur(s)</span><br/>':'<span class="info"></span><br/>';

      $content = ($value["type"]=="entry") ? "".$value["message"]:"";?>
    <?php
      $leftLinks = ($value["type"]=="entry") ? "<div class='leftlinks'>".$linkVoteUp." ".$linkVoteUnclear." ".$linkVoteAbstain." ".$linkVoteMoreInfo." ".$linkVoteDown."</div>" : "";
      $graphLink = ($totalVote) ?' <a class="btn" onclick="entryDetail(\''.Yii::app()->createUrl("/".$this->module->id."/default/graph/surveyId/".(string)$value["_id"]).'\',\'graph\')" href="javascript:;"><i class="fa fa-th-large"></i></a> ' : '';
      $moderatelink = (  $where["type"]=="entry" && $isModerator && isset( $value["applications"][$this->module->id]["cleared"] ) && $value["applications"][$this->module->id]["cleared"] == false ) ? "<a class='btn golink' href='javascript:moderateEntry(\"".$value["_id"]."\",1)'><i class='fa fa-plus ' ></i></a><a class='btn alertlink' href='javascript:moderateEntry(\"".$value["_id"]."\",0)'><i class='fa fa-minus ' ></i></a>" :"";
      $rightLinks = (  isset( $value["applications"][$this->module->id]["cleared"] ) && $value["applications"][$this->module->id]["cleared"] == false ) ? $moderatelink : $graphLink.$infoslink ;
      $rightLinks = ($value["type"]=="entry") ? "<div class='rightlinks'>".$rightLinks."</div>" : "";
      $ordre = $voteUpCount+$voteDownCount;
      $created = (isset($value["created"])) ? $value["created"] : 0; 
      $blocks .= ' <div class="mix '.$avoter.' '.$meslois.' '.$followingEntry.' '.$tags.' '.$cp.'" data-vote="'.$ordre.'"  data-time="'.$created.'" style="display:inline-blocks"">'.
                    $link.'<br/>'.
                    $info.
                    //$tags.
                    //$content.
                    '<br/>'.
                    $leftLinks.
                    $rightLinks.
                    '</div>';
    }
    ?>

  <label>Classement:</label>
  <button class="sort " data-sort="vote:asc">Asc</button>
  <button class="sort " data-sort="vote:desc">Desc</button>
  <label>Chronos:</label>
  <button class="sort " data-sort="time:asc">Asc</button>
  <button class="sort " data-sort="time:desc">Desc</button>
  <label>Affichage:</label>
  <button id="ChangeLayout"><i class="fa fa-reorder"></i></button>
  
  <?php if(!isset($_GET["cp"]) && $where["type"]=="survey")
      {?>
  <label>Commune:</label>
  <?php echo $cpBlock; }?>

  <br/>
  <label>Filtre:</label>

  <?php if( isset( Yii::app()->session["userId"]) && $where["type"]=="entry"){?>
  <a class="filter btn" data-filter=".avoter">A voter</a>
  <a class="filter btn" data-filter=".mesvotes">Mes votes</a>
  <a class="filter btn" data-filter=".myentries">Mes lois</a>
  <?php } ?>
  <button class="filter " data-filter="all">Tout</button>
  <?php echo $tagBlock?>

</div>
<div id="mixcontainer" class="mixcontainer">
  <?php echo $blocks?>
</div>
</div>

<div class="step why hidden">
  <div class="fr">
        <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/bdb.png" style="width:120px;float:right;">
      </div>
  Because We're happy<br><br><br><br><br><br>
  </div>

  <div class="step what hidden">
    <div class="fr">
        <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/bdb.png" style="width:120px;float:right;">
      </div>
  Come and have fun<br><br><br><br><br><br>
  </div>

  <div class="step how hidden">
    <div class="fr">
        <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/bdb.png" style="width:120px;float:right;">
      </div>
  Come and get some<br><br><br><br><br><br>
  </div>

  <div class="step who hidden">
    <div class="fr">
        <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/bdb.png" style="width:120px;float:right;">
      </div>
  All night long<br><br><br><br><br><br>
  </div>

  <div class="step when hidden">
    <div class="fr">
        <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/bdb.png" style="width:120px;float:right;">
      </div>
  Get up Stand up<br><br><br><br><br><br>
  </div>

</section>

<script type="text/javascript">
var layout = 'grid', // Store the current layout as a variable
$container = $('#mixcontainer'), // Cache the MixItUp container
$changeLayout = $('#ChangeLayout'); // Cache the changeLayout button

  $(function(){

    $container.mixItUp({
        load: {sort: 'vote:desc'},
        animation: {
          animateChangeLayout: true, // Animate the positions of targets as the layout changes
          animateResizeTargets: true, // Animate the width/height of targets as the layout changes
          effects: 'fade rotateX(-40deg) translateZ(-100px)'
        },
        layout: {
          containerClass: 'grid' // Add the class 'list' to the container on load
        }
      });

    //$('.inlinebar').sparkline('html', {type: 'pie'} );
});

  $changeLayout.on('click', function(){
    
    // If the current layout is a list, change to grid:
    
    if(layout == 'list'){
      layout = 'grid';
      $changeLayout.html('<i class="fa fa-reorder"></i>'); // Update the button text
      $container.mixItUp('changeLayout', {
        containerClass: layout // change the container class to "grid"
      });
      
    // Else if the current layout is a grid, change to list:  
    
    } else {
      layout = 'list';
      $changeLayout.html('<i class="fa fa-th"></i>'); // Update the button text
      $container.mixItUp('changeLayout', {
        containerClass: layout // Change the container class to 'list'
      });
    }
  });

  function entryDetail(url,type=null){
    testitget( null , url , function(data){
      if(type == "edit") {
        $("#flashInfo").modal('hide');
        $("#proposerloiFormLabel").html(data.title);
        $("#nameaddEntry").val(data.title);
        $("#message").val(data.contentBrut);
        $("#proposerloiForm").modal('show');
        AutoGrowTextArea($("message"));
      } else {
        $("#flashInfoContent").html(data.content);
        $("#flashInfoLabel").html(data.title);
        $("#flashInfo").modal('show');
        if(type=="graph")
          setUpGraph();
      }
    } );
  }
  function addaction(id,action){
      if(confirm("Vous êtes sûr ?")){
        params = { 
             "email" : '<?php echo Yii::app()->session["userEmail"]?>' , 
             "id" : id ,
             "collection":"surveys",
             "action" : action 
             };
        testitpost(null,'<?php echo Yii::app()->createUrl($this->module->id."/api/addaction")?>',params,function(data){
        window.location.reload();
        });
    }
    }
    function dejaVote(){
      alert("Vous ne pouvez pas votez 2 fois, ni changer de vote.");
    }
    function AutoGrowTextArea(textField)
    {
      if (textField.clientHeight < textField.scrollHeight)
      {
        textField.style.height = textField.scrollHeight + "px";
        if (textField.clientHeight < textField.scrollHeight)
        {
          textField.style.height = 
            (textField.scrollHeight * 2 - textField.clientHeight) + "px";
        }
      }
    }

    function moderateEntry(id,action)
    {
      params = { "survey" : id , 
            "action" : action , 
              "app" : "survey"};
      testitpost("moderateEntryResult",'<?php echo Yii::app()->createUrl($this->module->id."/api/moderateentry")?>',params,function(){
        window.location.reload();
      });
    }
    activeView = ".home";
    function hideShow(ids,parent=".step")
    {
      $(activeView).addClass("hidden");
      $(ids).removeClass("hidden");
      activeView = ids;
    }
</script>
<?php
if($where["type"]=="entry"){
  $this->renderPartial(Yii::app()->params["modulePath"].$this->module->id.'.views.default.modals.proposerloi',array("survey"=>$where["survey"]));
  $this->renderPartial(Yii::app()->params["modulePath"].$this->module->id.'.views.default.modals.voterloiDesc');
  if($commentActive)
    $this->renderPartial(Yii::app()->params["modulePath"].$this->module->id.'.views.default.modals.comments');
}
?>