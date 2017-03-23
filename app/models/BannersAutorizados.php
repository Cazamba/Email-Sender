<?php
    
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di;

class BannersAutorizados extends \Phalcon\Mvc\Model
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
    public $id_publisher;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $id_banner;

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
        return 'banners_autorizados';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return BannersAutorizados[]|BannersAutorizados
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return BannersAutorizados
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function insert($bannersAutorizados, $chaves_ids){

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

        foreach ($bannersAutorizados as $bannerAutorizado) {
            $bannerAutorizado['new_id_banner'] = $chaves_ids[$bannerAutorizado['id_banner']];

            //Inserção do banner
            $success = $connection->insert(
                "banners_autorizados",
                array(NULL,$bannerAutorizado['id_publisher'],$bannerAutorizado['new_id_banner'])
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
                        "banners_autorizados",
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

        BannersAutorizados::resetAutoIncrement();

    }

    public static function resetAutoIncrement(){

        $lastId = BannersAutorizados::maximum(
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

        $data = $connection->query("ALTER TABLE `banners_autorizados` AUTO_INCREMENT=" . ($lastId + 1) );

        $connection->close();

    }
}
