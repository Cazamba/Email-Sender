<?php

use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di;

class Campanhas extends \Phalcon\Mvc\Model
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
    public $id_anunciante;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $nome;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $produto;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $descricao;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $inicio;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $final;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $segmentacao_planner;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $condicoes_financeiras;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $dados_report;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $blogs;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $tipo_remuneracao;

    /**
     *
     * @var double
     * @Column(type="double", length=5, nullable=true)
     */
    public $valor_base;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $is_rm;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $is_ssp;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $is_mobile;

    /**
     *
     * @var string
     * @Column(type="string", length=25, nullable=true)
     */
    public $tipo_meta;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $valor_meta;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $ativo;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $encerrada;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('id_anunciante', 'Anunciantes', 'id', array('alias' => 'Anunciante'));
        $this->hasMany('id', 'Banners', 'id_campanha', array('alias' => 'Banners'));
        $this->hasMany('id', 'Eventos', 'id_campanha', array('alias' => 'Eventos'));
        $this->hasMany('id', 'FinanceiroCustom', 'id_campanha', array('alias' => 'FinanceirosCustom'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'campanhas';
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

    public static function insert($data){

        $campanhas = new Campanhas();
        $data['inicio'] = str_replace('/','-',$data['inicio']);
        $data['inicio'] = strtotime($data['inicio']);

        $data['final'] = str_replace('/','-',$data['final']);
        $data['final'] = strtotime($data['final']);

        $data['ativo'] = 0;
        $data['encerrada'] = 0;
        $data['dados_report'] = '';
        $data['id_anunciante'] = 1;

        $data['id_anunciante'] = (int) $data['id_anunciante'];
        $data['is_rm'] = (int) $data['is_rm'];
        $data['is_ssp'] = (int) $data['is_ssp'];
        $data['is_mobile'] = (int) $data['is_mobile'];
        $data['valor_meta'] = (int) $data['valor_meta'];

        if(empty($data['tipo_meta'])){
            $data['tipo_meta'] = ' ';
        }

        if(empty($data['produto'])){
            $data['produto'] = ' ';
        }

        $data['valor_base'] = (double) $data['valor_base'];

        if($data['descricao'] == ''){
            $data['descricao'] = ' ';
        }

        $result = $campanhas->save($data);

        if ($result) {
            $id = $campanhas->id;
        }else{
            return false;
        }

        return $id;
    }

    public static function deletar($id){

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

        $success = $connection->delete(
            "campanhas",
            "id = ?",
            [
                $id,
            ]
        );

        $connection->commit();
        $connection->close();

        Campanhas::resetAutoIncrement();
    }


    public static function deleteAll($id,$banners,$banners_autorizados,$criterios_banner,$eventos,$financeiro_custom){

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

        //Deletar Campanha

        $success = $connection->delete(
            "campanhas",
            "id = ?",
            [
                $id,
            ]
        );

        foreach ($banners as $banner) {
            $success = $connection->delete(
                "banners",
                "id = ?",
                [
                    $banner['id'] ,
                ]
            );
        }

        foreach ($banners_autorizados as $banner_autorizado) {
            $success = $connection->delete(
                "banners_autorizados",
                "id = ?",
                [
                    $banner_autorizado,
                ]
            );
        }

        foreach ($criterios_banner as $criterio_banner) {
            $success = $connection->delete(
                "criterios_banner",
                "id = ?",
                [
                    $criterio_banner,
                ]
            );
        }

        foreach ($eventos as $evento) {
            $success = $connection->delete(
                "eventos",
                "id = ?",
                [
                    $evento['id'] ,
                ]
            );
        }

        foreach ($financeiro_custom as $financeiro_custom_unity) {
            $success = $connection->delete(
                "financeiro_custom",
                "id = ?",
                [
                    $financeiro_custom_unity['id'] ,
                ]
            );
        }


        $retorno = $connection->commit();

        if(!$retorno){
            $connection->rollback();
            $connection->close();
            return false;
        }

        Campanhas::resetAutoIncrement();
        Banners::resetAutoIncrement();
        BannersAutorizados::resetAutoIncrement();
        CriteriosBanner::resetAutoIncrement();
        Eventos::resetAutoIncrement();
        FinanceiroCustom::resetAutoIncrement();

        $connection->close();
        return true;
    }

    public static function encerrarCampanha($id){

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

         $success = $connection->update(
             "campanhas",
             array("encerrada"),
             array("1"),
             "id = " . $id
         );

        $success = $connection->commit();
        $connection->close();

        return $success;
    }

    public static function resetAutoIncrement(){

        
        $config = Di::getDefault()->get('config');

        $config = [
            'host'     => $config->database->host,
            'dbname'   => $config->database->dbname,
            'port'     => $config->database->port,
            'username' => $config->database->username,
            'password' => $config->database->password
        ];

        $connection = new Mysql($config);

        $data = $connection->query("ALTER TABLE `campanhas` AUTO_INCREMENT=" . ($lastId + 1) );

        $connection->close();

    }

    public static function gerarRelatorio($id, $tipo){
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

            $sql = "select sum(valor) as valor from tailtarget_tracker where id_campanha = " . $id . " and tipo = '" . $tipo . "' and id_categoria in (select id from tailtarget_clusters where cluster_key = 'LC' and name like '%\/ " . substr($estado['name'], -2) . "')";

            $valor = $connection->fetchAll($sql)[0]['valor'];

            $result[substr($estado['name'], -2)] = $valor != NULL ? $valor : 0;
        }
    
        $connection->close();

        return $result;
    }

}
