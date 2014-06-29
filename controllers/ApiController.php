<?php
/**
 * ApiController.php
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
        array_push($this->sidebar1, Api::getCommunicationMap());
        array_push($this->sidebar1, array('label' => "All Modules", "key"=>"modules","iconClass"=>"fa fa-th", "menuOnly"=>true,
                                            "children"=>PH::buildMenuChildren("applications") ));
        
        return Api::buildActionMap($this->sidebar1);
    }
}