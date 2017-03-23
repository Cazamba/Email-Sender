<?php

use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di;

class FinanceiroCustom extends \Phalcon\Mvc\Model
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
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $start;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $end;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $id_publisher;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $tipo;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id_campanha;

    /**
     *
     * @var double
     * @Column(type="double", length=5, nullable=false)
     */
    public $valor;

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
        return 'financeiro_custom';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return FinanceiroCustom[]|FinanceiroCustom
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return FinanceiroCustom
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function insert($financeirosCustom, $campanha, $start, $end){

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


        foreach ($financeirosCustom as $financeiroCustom){

            //Inserção do Financeiro Custom
            $success = $connection->insert(
                "financeiro_custom",
                array(NULL,$start,$end,$financeiroCustom['id_publisher'],$financeiroCustom['tipo'],$campanha,$financeiroCustom['valor'])
            );

            if(!$success){
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

    public static function resetAutoIncrement(){

        $lastId = FinanceiroCustom::maximum(
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

        $data = $connection->query("ALTER TABLE `financeiro_custom` AUTO_INCREMENT=" . ($lastId + 1) );

        $connection->close();

    }

}
