<?php

namespace Endereco\Model;

/**
 * Modelo Cidade
 */
class Cidade extends \Db\Model
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
     * Sigla
     * @var string
     */
    protected $sigla;

    /**
     * Latitude
     * @var float
     */
    protected $latitude;

    /**
     * Longitude
     * @var float
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
     * return \Endereco\Model\Cidade
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
     * return \Endereco\Model\Cidade
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
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
     * return \Endereco\Model\Cidade
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
        return $this;
    }

    /**
     * Retorna o latitude
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Define o latitude
     * @param float latitude
     * return \Endereco\Model\Cidade
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * Retorna o longitude
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Define o longitude
     * @param float longitude
     * return \Endereco\Model\Cidade
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Retorna o estado relativo a esta cidade
     *
     * @return \Endereco\Model\Uf
     */
    public function getUf()
    {
        return \Endereco\Model\Uf::findOneBySigla($this->sigla);
    }

    public static function getTableName()
    {
        return 'enderecoCidade';
    }

    public static function getLabel()
    {
        return 'Cidade';
    }

    /**
     * Localiza a cidade pelo nome/uf/cep
     * @param type $nomeCidade
     * @param type $uf
     * @param type $cep
     * @return type
     */
    public static function localizaCidade($nomeCidade = NULL, $uf = NULL, $cep = NULL)
    {
        //procura por cidade e uf
        if (trim($nomeCidade) && $uf)
        {
            //tira acentos e espaço
            $nomeCidade = \Type\Text::get($nomeCidade)->toASCII()->trim();

            $filters = null;
            $filters[] = new \Db\Where('toAscii(trim(nome))', $nomeCidade);
            $filters[] = new \Db\Where('sigla', $uf);

            $cidade = \Endereco\Model\Cidade::findOne($filters);

            if ($cidade instanceof \Endereco\Model\Cidade)
            {
                return $cidade;
            }
        }

        //caso não tenha encontrado por nome, procura por cep
        $idCidade = \Endereco\Model\Cep::obterPorCep($cep)->getIdCidade();

        if ($idCidade)
        {
            return \Endereco\Model\Cidade::findOneByPk($idCidade);
        }

        return NULL;
    }

    /**
     * Definição de colunas
     */
    public static function defineColumns()
    {
        //TODO searchcolumn de id da uf e rever todo o código que usa getUf para criar um objeto ser ir no banco
        $columns = array();
        $columns['id'] = new \Db\Column('Código', 'id', \Db\Column::TYPE_INTEGER, NULL, FALSE, TRUE, NULL, \Db\Column::EXTRA_AUTO_INCREMENT);

        $columns['codigo'] = new \Db\SearchColumn('Código', 'codigo', \Db\Column::TYPE_INTEGER, 'id');
        $columns['nome'] = new \Db\Column('Nome', 'nome', \Db\Column::TYPE_VARCHAR, 255, FALSE, FALSE, NULL, NULL);
        $columns['sigla'] = new \Db\Column('Sigla', 'sigla', \Db\Column::TYPE_CHAR, 50, FALSE, FALSE, NULL, NULL);

        $columns['idUf'] = new \Db\Column('Uf', 'idUf', \Db\Column::TYPE_INTEGER, 11, FALSE, FALSE, NULL, NULL);
        $columns['idUf']->setReferenceTable('endereco\model\uf', 'id', 'descricao', 'FK_enderecoCidade_enderecoUf');

        $columns['latitude'] = new \Db\Column('Latitude', 'latitude', \Db\Column::TYPE_DECIMAL, '10,4', TRUE, FALSE, NULL, NULL);
        $columns['longitude'] = new \Db\Column('Longitude', 'longitude', \Db\Column::TYPE_DECIMAL, '10,4', TRUE, FALSE, NULL, NULL);

        return $columns;
    }

}
