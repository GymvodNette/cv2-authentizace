<?php

/**
 * My Application
 *
 * @copyright  Copyright (c) 2010 John Doe
 * @package    MyApplication
 */

use Gymvod\Auth\AuthService;

use Nette\Application\AppForm;

/**
 * Homepage presenter.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class AuthPresenter extends BasePresenter
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
		
		// TODO  - add validation rules

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

	public function renderDefault()
	{
		
	}

	////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////

	protected function createComponentRegisterForm()
	{
		$form = new AppForm();
		$form->addText('login', 'Username');
		$form->addPassword('password', 'Password');
		$form->addSubmit('submit');

		$form->onSubmit[] = callback($this, 'submitRegisterForm');

		return $form;
	}

	public function submitRegisterForm(AppForm $form)
	{
		$data = $form->getValues();

		AuthService::register($data['login'], $data['password']);
		$this->flashMessage('Successfully registered');
		$this->redirect('default');
	}

	public function renderRegister()
	{
		
	}

}
