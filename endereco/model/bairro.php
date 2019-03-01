<?php

namespace Endereco\Model;

use \Db\Column as Column;

/**
 * Model Bairro
 */
class Bairro extends \Db\Model
{

    /**
     * Código
     * @var int
     */
    protected $id;

    /**
     * Cidade
     * @var int
     */
    protected $idCidade;

    /**
     * Nome
     * @var string
     */
    protected $nome;

    /**
     * Retorna o código
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Define o código
     * @param int id
     * return \Model\Pais
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Retorna o nome
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Define o nome
     * @param string nome
     * return \Model\Pais
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function getIdCidade()
    {
        return $this->idCidade;
    }

    public function setIdCidade($idCidade)
    {
        $this->idCidade = $idCidade;
        return $this;
    }

    public function getOptionLabel()
    {
        return $this->nome;
    }

    public static function getTableName()
    {
        return 'enderecoBairro';
    }

    public static function getLabel()
    {
        return 'Bairro';
    }

    /**
     * Localiza o bairro por nome na cidade
     *
     * @return \Endereco\Model\Bairro
     */
    public static function localizaBairro($nomeBairro, $idCidade)
    {
        //procura por cidade e bairro
        if (trim($nomeBairro) && $idCidade)
        {
            $filters = null;
            //tira acentos e espaço
            $filters[] = new \Db\Where('toAscii(trim(nome))', \Type\Text::get($nomeBairro)->toASCII()->trim());
            $filters[] = new \Db\Where('idCidade', $idCidade);

            $bairro = \Endereco\Model\Bairro::findOne($filters);

            //caso o retorno não encontre bairro, cria um na base
            if (!$bairro instanceof \Endereco\Model\Bairro)
            {
                $bairro = new \Endereco\Model\Bairro();
                $bairro->setIdCidade($idCidade);
                $bairro->setNome($nomeBairro);
                $bairro->save();
            }

            return $bairro;
        }

        return null;
    }

    /**
     * Column definition
     */
    public static function defineColumns()
    {
        $columns = array();
        $columns['id'] = new Column('Código', 'id', Column::TYPE_INTEGER, NULL, FALSE, TRUE, NULL, Column::EXTRA_AUTO_INCREMENT);

        $columns['idCidade'] = new \Db\Column('Cidade', 'idCidade', \Db\Column::TYPE_INTEGER, NULL, FALSE, FALSE, NULL, NULL);
        $columns['idCidade']
                ->setReferenceTable('endereco\model\cidade', 'id', "concat(nome, ' - ', sigla)")
                ->setClass('\Endereco\Component\Combo\Cidade');

        $columns['nome'] = new Column('Nome', 'nome', Column::TYPE_VARCHAR, 50, FALSE, FALSE, NULL, NULL);

        return $columns;
    }

}
