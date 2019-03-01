<?php

namespace Endereco\Model;

use \Db\Column as Column;

/**
 * Model Pais
 */
class Pais extends \Db\Model
{

    /**
     * Código
     * @var int
     */
    protected $id;

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

    public function getOptionLabel()
    {
        return $this->nome;
    }

    public static function getTableName()
    {
        return 'enderecoPais';
    }

    public static function getLabel()
    {
        return 'país';
    }

    public static function getLabelPlural()
    {
        return 'países';
    }

    /**
     * Column definition
     */
    public static function defineColumns()
    {
        $columns = array();
        $columns['id'] = new Column('Código', 'id', Column::TYPE_INTEGER, NULL, FALSE, TRUE, NULL);
        //para grid
        $columns['codigo'] = new \Db\SearchColumn('Código', 'codigo', Column::TYPE_INTEGER, 'id');
        $columns['nome'] = new Column('Nome', 'nome', Column::TYPE_VARCHAR, 50, FALSE, FALSE, NULL, NULL);

        return $columns;
    }

}
