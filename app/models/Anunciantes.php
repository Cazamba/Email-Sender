<?php

class Anunciantes extends \Phalcon\Mvc\Model
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
     * @Column(type="string", length=255, nullable=false)
     */
    public $nome;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $tipo;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $razao_social;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $cnpj;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $endereco;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $numero;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $complemento;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $bairro;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $cidade;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $estado;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $cep;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $contato;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $email;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $telefone;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $informacoes_adicionais;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Campanhas', 'id_anunciante', array('alias' => 'Campanhas'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'anunciantes';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Anunciantes[]|Anunciantes
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Anunciantes
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
