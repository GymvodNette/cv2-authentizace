<?php

namespace Gymvod\Auth;

use Nette\Security\Identity;

// configure authenticator in app/config.ini
class Authenticator extends \Nette\Object implements \Nette\Security\IAuthenticator {

    public function authenticate(array $credentials) {

		$user = AuthService::authenticate($credentials[self::USERNAME], $credentials[self::PASSWORD]);

		if (!$user) {
			throw new \Nette\Security\AuthenticationException('Not authorized user', self::INVALID_CREDENTIAL);
		}

		$data = array(
			'login' => $user->login,
		);

        return new Identity($user->id, array(), $data);
    }

}