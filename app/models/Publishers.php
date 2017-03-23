<?php

use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di;

class Publishers extends \Phalcon\Mvc\Model
{

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'publishers';
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
        $config = Di::getDefault()->get('config');

        $config = [
            'host'     => $config->database->host,
            'dbname'   => $config->database->dbname,
            'port'     => $config->database->port,
            'username' => $config->database->username,
            'password' => $config->database->password,
        ];

        $connection = new Mysql($config);

        $data = $connection->fetchAll("SELECT publishers.*  FROM publishers LEFT JOIN usuarios_publishers ON publishers.id = usuarios_publishers.id_publisher WHERE usuarios_publishers.id IS NULL ORDER BY id DESC", Phalcon\Db::FETCH_ASSOC);

        return $data;
    }

    public static function createUser()
    {
        return 1;
    }

}
