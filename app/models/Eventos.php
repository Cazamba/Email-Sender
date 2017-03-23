<?php

use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di;

class Eventos extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $token;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $nome;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $vars;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id_campanha;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('id_campanha', 'Campanhas', 'id', array('alias' => 'Campanha'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'eventos';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Eventos[]|Eventos
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Eventos
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function insert($eventos,$campanha){

        $config = Di::getDefault()->get('config');

        $config = [
            'host'     => $config->database->host,
            'dbname'   => $config->database->dbname,
            'port'     => $config->database->port,
            'username' => $config->database->username,
            'password' => $config->database->password
        ];

        $connection = new Mysql($config);

        $connection->begin();

        $ids_retorno = [];

        foreach ($eventos as $evento) {

            //Inserção do evento
            $success = $connection->insert(
                "eventos",
                array(NULL,$evento['token'], $evento['nome'], $evento['vars'], $campanha)
            );

            if(!$success){
                var_dump($success);
                $connection->rollback();
                return false;
            }

            $id = $connection->lastInsertId();
            array_push($ids_retorno, $id);

        }

        $connection->commit();
        $connection->close();

        return $ids_retorno;

    }

    public static function deletar($ids){

        $config = Di::getDefault()->get('config');

        $config = [
            'host'     => $config->database->host,
            'dbname'   => $config->database->dbname,
            'port'     => $config->database->port,
            'username' => $config->database->username,
            'password' => $config->database->password
        ];

        $connection = new Mysql($config);

        $connection->begin();

        foreach ($ids as $id) {
            $success = $connection->delete(
                "eventos",
                "id = ?",
                [
                    $id
                ]
            );
        }

        $connection->commit();
        $connection->close();

        Eventos::resetAutoIncrement();
    }

    public static function resetAutoIncrement(){

        $lastId = Eventos::maximum(
            [
                "column" => "id",
            ]
        );

        $config = Di::getDefault()->get('config');

        $config = [
            'host'     => $config->database->host,
            'dbname'   => $config->database->dbname,
            'port'     => $config->database->port,
            'username' => $config->database->username,
            'password' => $config->database->password
        ];

        $connection = new Mysql($config);

        $data = $connection->query("ALTER TABLE `eventos` AUTO_INCREMENT=" . ($lastId + 1) );

        $connection->close();

    }

}
