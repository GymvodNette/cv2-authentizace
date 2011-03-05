<?php

namespace Gymvod\Application;

use Nette\Object;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;

// configure authenticator in app/config.ini
class Authenticator extends Object implements IAuthenticator { 

    public function authenticate(array $credentials) {
	
		$allowed = array(
			'vasek' => 'heslo',
			'honza' => '123',
		);
		
		if (!isset($allowed[$credentials[self::USERNAME]])) {
			throw new \Nette\Security\AuthenticationException('Not authorized user', self::IDENTITY_NOT_FOUND);
		} elseif ($credentials[self::PASSWORD] != $allowed[$credentials[self::USERNAME]]) {
			throw new \Nette\Security\AuthenticationException('Invalid password', self::INVALID_CREDENTIAL);
		}

        return new Identity($credentials[self::USERNAME]);
    }

}