<?php
/**
 * Communect Module
 *
 * @author Tibor Katelbach <oceatoon@mail.com>
 * @version 0.0.3
 *
*/

class PppmModule extends CWebModule
{
    

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'pppm.models.*',
			'pppm.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	private $_assetsUrl;

	public function getAssetsUrl()
	{
	    if ($this->_assetsUrl === null)
	        $this->_assetsUrl = Yii::app()->getAssetManager()->publish(
	            Yii::getPathOfAlias('pppm.assets') );
	    return $this->_assetsUrl;
	}
}
