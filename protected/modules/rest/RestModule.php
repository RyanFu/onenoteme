<?php
define('REST_DEBUG', true);

class RestModule extends CWebModule
{
	public function init()
	{
		// import the module-level models and components
		$this->setImport(array(
			'rest.models.*',
			'rest.components.*',
			'rest.extensions.*',
		));
		
		app()->errorHandler->errorAction = 'rest/default/error';
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action)) {
			return true;
		}
		else
			return false;
	}
    
}



