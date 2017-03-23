<?php

use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di;

class Banners extends \Phalcon\Mvc\Model
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
    public $id_campanha;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id_tipo_banner;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $nome;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $codigo;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $css;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $url_codigo_teste;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $url_codigo;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $dados;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $meta_print;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $pixel_print;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $pixel_interaction;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $pixel_click;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $prioridade;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $frequency_capping;

    /**
     *
     * @var double
     * @Column(type="double", length=5, nullable=false)
     */
    public $cpm;

    /**
     *
     * @var double
     * @Column(type="double", length=5, nullable=false)
     */
    public $cpc;

    /**
     *
     * @var string
     * @Column(type="string", length=11, nullable=true)
     */
    public $tipo_contratacao;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $volume_contratado;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $https;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    public $limite_tipo;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $limite_dia;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $has_video;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $ativo;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('id_campanha', 'Campanhas', 'id', array('alias' => 'Campanha'));
        $this->hasMany('id', 'CriteriosBanner', 'id_banner', array('alias' => 'CriteriosBanner'));
        $this->hasMany('id', 'BannersAutorizados', 'id_banner', array('alias' => 'BannersAutorizados'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'banners';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Banners[]|Banners
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Banners
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function insert($banners, $campanha)
    {

        $id_banners = []; //Armazenar o ID de todos os banners duplicados e retornar estes valores

        $insert = false;
        $old_id = null;

        $config = Di::getDefault()->get('config');

        $config = [
            'host'     => $config->database->host,
            'dbname'   => $config->database->dbname,
            'port'     => $config->database->port,
            'username' => $config->database->username,
            'password' => $config->database->password,
        ];

        $connection = new Mysql($config);

        $connection->begin();

        foreach ($banners as $banner) {

            if (empty($banner['nome'])) {
                $banner['nome'] = ' ';
            }

            if (empty($banner['codigo'])) {
                $banner['codigo'] = ' ';
            }

            if (empty($banner['css'])) {
                $banner['css'] = ' ';
            }

            if (empty($banner['url_codigo_teste'])) {
                $banner['url_codigo_teste'] = ' ';
            }

            if (empty($banner['url_codigo'])) {
                $banner['url_codigo'] = ' ';
            }

            if (empty($banner['dados'])) {
                $banner['dados'] = ' ';
            }

            if (empty($banner['meta_print'])) {
                $banner['meta_print'] = ' ';
            }

            if (empty($banner['pixel_print'])) {
                $banner['pixel_print'] = ' ';
            }

            if (empty($banner['pixel_interaction'])) {
                $banner['pixel_interaction'] = ' ';
            }

            if (empty($banner['pixel_click'])) {
                $banner['pixel_click'] = ' ';
            }

            if (empty($banner['prioridade'])) {
                $banner['prioridade'] = ' ';
            }

            if (empty($banner['frequency_capping'])) {
                $banner['frequency_capping'] = ' ';
            }

            if (empty($banner['cpm'])) {
                $banner['cpm'] = ' ';
            }

            if (empty($banner['cpc'])) {
                $banner['cpc'] = ' ';
            }

            if (empty($banner['tipo_contratacao'])) {
                $banner['tipo_contratacao'] = ' ';
            }

            if (empty($banner['volume_contratado'])) {
                $banner['volume_contratado'] = ' ';
            }

            if (empty($banner['https'])) {
                $banner['https'] = ' ';
            }

            if (empty($banner['limite_tipo'])) {
                $banner['limite_tipo'] = ' ';
            }

            if (empty($banner['limite_dia'])) {
                $banner['limite_dia'] = ' ';
            }

            if (empty($banner['has_video'])) {
                $banner['has_video'] = ' ';
            }

            $old_id                = $banner['id'];
            $banner['id']          = null;
            $banner['id_campanha'] = $campanha;
            $banner['ativo']       = 0;

            //Inserção do banner
            $success = $connection->insert(
                "banners",
                $banner
            );

            //Pegar o Id gerado
            $id                  = $connection->lastInsertId();
            $id_banners[$old_id] = $id;

            //Rollback caso exista erro na inserção
            if (!isset($id)) {
                $connection->rollback();
                return false;
            }

        }
        //$connection->commit();
        $connection->commit();
        $connection->close();
        return $id_banners;
    }

    public static function deletar($campanha)
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

        $connection->begin();

        $success = $connection->delete(
            "banners",
            "id_campanha = ?",
            [
                $campanha,
            ]
        );

        $connection->commit();
        $connection->close();

        Banners::resetAutoIncrement();
    }

    public static function resetAutoIncrement()
    {

        $lastId = Banners::maximum(
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
            'password' => $config->database->password,
        ];

        $connection = new Mysql($config);

        $data = $connection->query("ALTER TABLE `banners` AUTO_INCREMENT=" . ($lastId + 1));

        $connection->close();
    }

    
    public static function gerarRelatorio($id, $id_campanha, $tipo){
        $config = Di::getDefault()->get('config');

        $config = [
            'host'     => $config->database->host,
            'dbname'   => $config->database->dbname,
            'port'     => $config->database->port,
            'username' => $config->database->username,
            'password' => $config->database->password
        ];

        $connection = new Mysql($config);

        $result = [];

        $sql = "select DISTINCT right(name, 2) as name from tailtarget_clusters where cluster_key = 'LC'";

        $estados = $connection->fetchAll($sql);

        foreach ($estados as $estado) {

            $sql = "select sum(valor) as valor from tailtarget_tracker where id_banner = " . $id . " and id_campanha = " . $id_campanha . " and tipo = '" . $tipo . "' and id_categoria in (select id from tailtarget_clusters where cluster_key = 'LC' and name like '%\/ " . substr($estado['name'], -2) . "')";

            $valor = $connection->fetchAll($sql)[0]['valor'];

            $result[substr($estado['name'], -2)] = $valor != NULL ? $valor : 0;
        }
    
        $connection->close();

        return $result;
    }


}
