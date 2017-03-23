<?php

use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di;

class UsuariosPublishers extends \Phalcon\Mvc\Model
{

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'usuarios_publishers';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Campanhas[]|Campanhas
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Campanhas
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function getPublishers($parameters = null)
    {
        return parent::find($parameters);
    }

    public static function insert($data){
        $data['admin'] = 0;

        $data['id_publisher'] = $data['id'];
        unset($data['id']);

        $usuarios_publishers = new UsuariosPublishers();

        $result = $usuarios_publishers->save($data);

        return $result;
    }

    public static function fetchByEmail($email){

        $user = UsuariosPublishers::findFirst(
            [
                'columns'    => '*',
                'conditions' => 'login = ?1',
                'bind'       => [
                    1 => $email,
                ]
            ]
        );

        return $user;
    }



}