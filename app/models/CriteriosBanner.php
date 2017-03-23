<?php

use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di;

class CriteriosBanner extends \Phalcon\Mvc\Model
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
     * @Column(type="integer", length=11, nullable=true)
     */
    public $id_banner;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $tipo;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $valor;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('id_banner', 'Banners', 'id', array('alias' => 'Banner'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'criterios_banner';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return CriteriosBanner[]|CriteriosBanner
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return CriteriosBanner
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function insert($criteriosBanners,$chaves_ids){
        
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

        foreach ($criteriosBanners as $criteriosBanner) {
            $criteriosBanner['new_id_banner'] = $chaves_ids[$criteriosBanner['id_banner']];

            //Inserção do banner
            $success = $connection->insert(
                "criterios_banner",
                array(NULL,$criteriosBanner['new_id_banner'],$criteriosBanner['tipo'],$criteriosBanner['valor'])
            );

            if(!$success){
                $connection->rollback();
                return false;
            }

            //$id = $connection->lastInsertId();
            $id = $connection->lastInsertId();
            array_push($ids_retorno, $id);

        }

        //$connection->commit();
        $connection->commit();
        $connection->close();

        return $ids_retorno;
    }

    public static function deletar($ids_array){

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

        foreach ($ids_array as $ids) {    
            if($ids != false){
                foreach ($ids as $id) {
                    $success = $connection->delete(
                        "criterios_banner",
                        "id = ?",
                        [
                            $id
                        ]
                    );
                }  
            }
        }

        $connection->commit();
        $connection->close();

        CriteriosBanner::resetAutoIncrement();

    }

    public static function resetAutoIncrement(){

        $lastId = CriteriosBanner::maximum(
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

        $data = $connection->query("ALTER TABLE `criterios_banner` AUTO_INCREMENT=" . ($lastId + 1) );

        $connection->close();

    }


}
