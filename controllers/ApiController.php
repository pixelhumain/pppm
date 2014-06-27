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
        array_push($this->sidebar1, array('label' => "Scenario", "key"=>"scenario","onclick"=>"toggle('scenario')","hide"=>true, "iconClass"=>"fa fa-list","generate"=>true));
        array_push($this->sidebar1, Api::$userMap);
        array_push($this->sidebar1, Api::$surveyMap);
        array_push($this->sidebar1, Api::$adminMap);
        array_push($this->sidebar1, Api::$adminPHMap);
        array_push($this->sidebar1, Api::$communicatoinMap);
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