<?php

/**
 * My Application
 *
 * @copyright  Copyright (c) 2010 John Doe
 * @package    MyApplication
 */

use \Nette\Environment;

/**
 * Base class for all application presenters.
 *
 * @author     John Doe
 * @package    MyApplication
 */
abstract class BasePresenter extends Nette\Application\Presenter
{
	private $user;
	
	////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////
	
	protected function startup()
	{
		parent::startup();
		
		// all presenters secured, redirecting to login form
		if (!$this->getUser()->isLoggedIn() && $this->name != 'Login') { 
			$this->redirect('Login:');
		}
	}
	
	// before render is executed before every render method in all presenters which extend this one
	// (if the don't have their own beforeRender method, then they must call parent::beforeRender - they should anyway)
	public function beforeRender() 
	{
		$this->template->_user = $this->getUser();
	}
	
	////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////
	
	// signal which we can call from all of our presenters
	public function handleLogout()
	{
		$this->getUser()->logout();
		$this->redirect('this'); // reload
	}
	
	////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////

	public function getUser()
	{
		if (!$this->user) {
			$this->user = Environment::getUser();
		}
		
		return $this->user;
	}
	
	
	
}
