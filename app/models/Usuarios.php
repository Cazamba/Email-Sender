<?php

use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di;

class Usuarios extends \Phalcon\Mvc\Model
{

	public static function login($usuario, $senha){
	
        $user = Usuarios::findFirst(
		    [
		        'columns'    => '*',
		        'conditions' => 'login = ?1 AND senha = ?2',
		        'bind'       => [
		            1 => $usuario,
		            2 => md5($senha),
		        ]
		    ]
		);

        return $user;

	}
}