<?php
/**
 * DefaultController.php
 *
 * API REST pour géré l'application EGPC
 *
 * @author: Tibor Katelbach <tibor@pixelhumain.com>
 * Date: 14/03/2014
 */
class ApiController extends Controller {

    const moduleTitle = "API Sondage";
    public static $moduleKey = "pppm";
    
    public $sidebar1 = array(
            array('label' => "Scenario", "key"=>"scenario","onclick"=>"toggle('scenario')","hide"=>true, "iconClass"=>"fa fa-list","generate"=>true),
            array('label' => "User", "key"=>"user", "iconClass"=>"fa fa-user","generate"=>true,
                "children"=> array(
                    array( "label"=>"se Communecter", "key"=>"communect"),
                    array( "label"=>"Login", "key"=>"login"),
                    array( "label"=>"Save User", "key"=>"saveUser"),
                    array( "label"=>"Get User", "key"=>"getUser"),
                    array( "label"=>"ConfirmUserRegistration"),
                    array( "label"=>"GetPeople","key"=>"getPeople"),
                    array( "label"=>"InvitePeople", "key"=>"inviteUser")
                )),
            array('label' => "Survey", "key"=>"survey", "iconClass"=>"fa fa-thumbs-up", 
                "children"=> array(
                    array( "label"=>"Create Session", "desc"=>"a session is a container will contain entries and be linked to people",
                        "href"=>"javascript:;","onclick"=>"scrollTo('#blocksaveSession')"),
                    array( "label"=>"Add Entry","desc"=>"an entry, is a text, law, idea, things to vote on",
                        "href"=>"javascript:;","onclick"=>"scrollTo('#blockaddEntry')"),
                    array( "label"=>"Vote on an Entry","desc"=>"votes help decision making and give orientations",
                        "href"=>"javascript:;","onclick"=>"scrollTo('#blockvoteEntry')"),
                    array( "label"=>"Admin confirm Entry","desc"=>"session can be moderated if specified",
                        "href"=>"javascript:;","onclick"=>"scrollTo('#blockadminConfirmFeed')"),
                )),
            array('label' => "Administration", "key"=>"admin", "iconClass"=>"fa fa-cog", 
                "children"=> array(
                    array( "label"=>"Moderation Settings","href"=>"javascript:;","onclick"=>"scrollTo('#blockModerationSettings')"),
                    array( "label"=>"Add an admin","href"=>"javascript:;","onclick"=>"scrollTo('#blockaddAdmin')"),
                    array( "label"=>"Moderate an entry","href"=>"javascript:;","onclick"=>"scrollTo('#blockModerate')"),
                    array( "label"=>"Delete a Survey","href"=>"javascript:;","onclick"=>"scrollTo('#blockdeleteSurvey')"),
                    array( "label"=>"Delete a Entry","href"=>"javascript:;","onclick"=>"scrollTo('#blockdeleteEntry')"),
                    array( "label"=>"Delete a User","href"=>"javascript:;","onclick"=>"scrollTo('#blockdeleteUser')"),
                )),
            array('label' => "Administration PH", "key"=>"adminPH", "iconClass"=>"fa fa-cogs", 
                "children"=> array(
                    array( "label"=>"Set Admin Quartier","href"=>"javascript:;","onclick"=>"scrollTo('#blockadminQuartier')"),
                )),
            array('label' => "Communication", "key"=>"communications", "iconClass"=>"fa fa-bullhorn", 
                "children"=> array(
                    array( "label"=>"sendMessage","href"=>"javascript:;","onclick"=>"scrollTo('#blocksendMessage')")
                )),
           
        );
    public $percent = 60; //TODO link it to unit test
    protected function beforeAction($action)
    {
        array_push($this->sidebar1, array('label' => "All Modules", "key"=>"modules","iconClass"=>"fa fa-th", "menuOnly"=>true,"children"=>PH::buildMenuChildren("applications") ));
        return parent::beforeAction($action);
    }

    public function actions()
    {
        return array(
            'index'             => 'application.components.api.controllers.IndexAction',
            'login'             => 'application.controllers.user.LoginAction',
            'sendemailpwd'      => 'application.controllers.user.SendEmailPwdAction',
            'saveuser'          => 'application.controllers.user.SaveUserAction',
            'communect'         => 'application.controllers.user.CommunectAction',
            'getuser'           => 'application.controllers.user.GetUserAction',
            'getpeopleby'       => 'application.controllers.user.GetPeopleByAction',
            'inviteuser'        => 'application.controllers.user.InviteUserAction',
            'addaction'         => 'application.controllers.action.AddActionAction',
            "getactionvalue"    => 'application.controllers.generic.GetFromCollectionAction',

            'savesession'       => 'application.controllers.survey.SaveSessionAction',  
            'moderateentry'     => 'application.controllers.survey.ModerateAction',  
            'deletesurvey'     => 'application.controllers.survey.DeleteAction',  

            'getby'             => 'application.controllers.generic.GetByAction',  
            'sendmessage'       => 'application.controllers.messages.SendMessageAction',  

            'addappadmin'       => 'application.controllers.applications.AddAppAdminAction',  
        );
    }
}