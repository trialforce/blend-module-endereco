<?php

namespace Endereco\Model;

/**
 * Modelo Unidade federativa
 */
class Uf extends \Db\Model
{

    /**
     * Código
     * @var int
     */
    protected $id;

    /**
     * Sigla
     * @var string
     */
    protected $sigla;

    /**
     * Descrição
     * @var string
     */
    protected $descricao;

    /**
     * Latitude
     * @var string
     */
    protected $latitude;

    /**
     * Longitude
     * @var string
     */
    protected $longitude;

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
     * return \Endereco\Model\Uf
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Retorna o sigla
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Define o sigla
     * @param string sigla
     * return \Endereco\Model\Uf
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
        return $this;
    }

    /**
     * Retorna o descrição
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Define o descrição
     * @param string descricao
     * return \Endereco\Model\Uf
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Retorna o latitude
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Define o latitude
     * @param string latitude
     * return \Endereco\Model\Uf
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * Retorna o longitude
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Define o longitude
     * @param string longitude
     * return \Endereco\Model\Uf
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getOptionLabel()
    {
        return $this->sigla;
    }

    /**
     * Retorna um estado pela sigla
     *
     * @param string $sigla
     * @return \Endereco\Model\Uf
     */
    public static function findOneBySigla($sigla)
    {
        $sigla = strtoupper($sigla);
        $filters[] = new \Db\Where('sigla', $sigla);
        return \Endereco\Model\Uf::findOne($filters);
    }

    public static function getLabel()
    {
        return 'Estado';
    }

    public static function getTableName()
    {
        return 'enderecoUf';
    }

    /**
     * Definição de colunas
     */
    public static function defineColumns()
    {
        $columns = array();
        $columns['id'] = new \Db\Column('Código', 'id', \Db\Column::TYPE_INTEGER, NULL, FALSE, TRUE, NULL, \Db\Column::EXTRA_AUTO_INCREMENT);
        //para grid
        $columns['codigo'] = new \Db\SearchColumn('Código', 'codigo', \Db\Column::TYPE_INTEGER, 'id');

        $columns['sigla'] = new \Db\Column('Sigla', 'sigla', \Db\Column::TYPE_CHAR, 2, FALSE, FALSE, NULL, NULL);
        $columns['descricao'] = new \Db\Column('Descrição', 'descricao', \Db\Column::TYPE_VARCHAR, 255, FALSE, FALSE, NULL, NULL);
        $columns['latitude'] = new \Db\Column('Latitude', 'latitude', \Db\Column::TYPE_VARCHAR, 255, FALSE, FALSE, NULL, NULL);
        $columns['longitude'] = new \Db\Column('Longitude', 'longitude', \Db\Column::TYPE_VARCHAR, 255, FALSE, FALSE, NULL, NULL);

        return $columns;
    }

}
