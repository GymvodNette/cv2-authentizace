<?php

namespace Gymvod\Auth;

class AuthService extends \Nette\Object {

    public static function register($login, $password) {
		\dibi::query('INSERT INTO [cv2_user]', array( // TODO unique
			'login' => $login,
			'password' => self::hash($password, $login),
		));
    }

	public static function authenticate($login, $password) {
		return \dibi::fetch('
			SELECT *
			FROM [cv2_user]
			WHERE
				login = %s', $login, '
				AND
				password = %s', self::hash($password, $login));
	}
	
	public static function hash($password, $salt)
	{
		return hash_hmac('sha256', $password, $salt);
	}

}