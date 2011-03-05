<?php

/**
 * My Application
 *
 * @copyright  Copyright (c) 2010 John Doe
 * @package    MyApplication
 */

use Nette\Application\AppForm;

/**
 * Homepage presenter.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class LoginPresenter extends BasePresenter
{

	protected function startup()
	{
		parent::startup();
		
		// we don't want authenticated users see the login form again
		if ($this->getUser()->isLoggedIn()) { 
			$this->redirect('HomePage:');
		}
	}
	

	////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////

	protected function createComponentLoginForm()
	{
		$form = new AppForm();
		$form->addText('username', 'Username');
		$form->addPassword('password', 'Password');
		$form->addSubmit('submit');

		$form->onSubmit[] = callback($this, 'submitLoginForm');

		return $form;
	}
	
	public function submitLoginForm(AppForm $form)
	{
		$data = $form->getValues();
		$user = $this->getUser();
	
		try {
			$user->login($data['username'], $data['password']);
			$this->redirect('HomePage:');
		} catch (\Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
		}
	}
	
	////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////

	public function renderDefault()
	{
		
	}

}
