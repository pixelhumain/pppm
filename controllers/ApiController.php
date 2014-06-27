<?php
/**
 * DefaultController.php
 *
 * API REST pour géré l'application PPPM
 *
 * @author: Tibor Katelbach <tibor@pixelhumain.com>
 * Date: 01/06/2014
 */
class ApiController extends Controller {

    const moduleTitle = "API Sondage";
    public static $moduleKey = "pppm";
    public $percent = 60; //TODO link it to unit test
    
    public function actions()
    {
        //build api context
        array_push($this->sidebar1, Api::getUserMap());
        array_push($this->sidebar1, Api::getSurveyMap());
        array_push($this->sidebar1, Api::getAdminMap());
        array_push($this->sidebar1, Api::getAdminPHMap());
        array_push($this->sidebar1, Api::getCommunicatoinMap());
        array_push($this->sidebar1, array('label' => "All Modules", "key"=>"modules","iconClass"=>"fa fa-th", "menuOnly"=>true,"children"=>PH::buildMenuChildren("applications") ));
        
        $actions = array(
            'index' => 'application.components.api.controllers.IndexAction',
            );
        //the context is buildin the sidemenu1 object and can contain a map of needed action controllers
        foreach ($this->sidebar1 as  $e) 
        { 
            if(isset($e["children"]))
            {
                foreach ($e["children"] as $key => $child) 
                {
                    if( isset($child["actions"]) )
                    {
                        foreach ($child["actions"] as $k => $v) 
                        {
                            $actions[$k] = $v;
                        }
                    }
                }
            }
        }
        return $actions;
    }
}