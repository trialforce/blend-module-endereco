<?php

namespace Endereco\Model;

use \Db\Column as Column;

/**
 * Model Cep
 */
class Cep extends \Db\Model
{

    /**
     * Código
     * @var string
     */
    protected $id;

    /**
     * Cep
     * @var string
     */
    protected $cep;

    /**
     * Logradouro
     * @var string
     */
    protected $logradouro;

    /**
     * Complemento
     * @var string
     */
    protected $complemento;

    /**
     * Número
     * @var string
     */
    protected $numero;

    /**
     * Bairro
     * @var string
     */
    protected $bairro;

    /**
     * Bairro
     * @var int
     */
    protected $idBairro;

    /**
     * Cidade
     * @var string
     */
    protected $cidade;

    /**
     * Uf (Sigla)
     * @var string
     */
    protected $ufSigla;

    /**
     * Cidade
     * @var int
     */
    protected $idCidade;

    /**
     * Alteracao
     * @var timestamp
     */
    protected $alteracao;

    /**
     * Retorna o código
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Define o código
     * @param string id
     * return \Model\Cep
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function setCep($cep)
    {
        //sempre grava sem traço
        $this->cep = \Validator\Validator::unmask($cep);
        return $this;
    }

    /**
     * Retorna o logradouro
     * @return string
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * Define o logradouro
     * @param string logradouro
     * return \Model\Cep
     */
    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;
        return $this;
    }

    /**
     * Retorna o complemento
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Define o complemento
     * @param string complemento
     * return \Model\Cep
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * Retorna o número
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Define o número
     * @param string numero
     * return \Model\Cep
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * Retorna o bairro
     * @return string
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Define o bairro
     * @param string bairro
     * return \Model\Cep
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
        return $this;
    }

    public function getIdBairro()
    {
        return $this->idBairro;
    }

    public function setIdBairro($idBairro)
    {
        $this->idBairro = $idBairro;
        return $this;
    }

    /**
     * Retorna o cidade
     * @return string
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Define o cidade
     * @param string cidade
     * return \Model\Cep
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
        return $this;
    }

    /**
     * Retorna o uf (Sigla)
     * @return string
     */
    public function getUfSigla()
    {
        return $this->ufSigla;
    }

    /**
     * Define o uf (Sigla)
     * @param string ufSigla
     * return \Model\Cep
     */
    public function setUfSigla($ufSigla)
    {
        $this->ufSigla = $ufSigla;
        return $this;
    }

    /**
     * Retorna o cidade
     * @return int
     */
    public function getIdCidade()
    {
        return $this->idCidade;
    }

    /**
     * Define o cidade
     * @param int idCidade
     * return \Model\Cep
     */
    public function setIdCidade($idCidade)
    {
        $this->idCidade = $idCidade;
        return $this;
    }

    /**
     * Retorna o alteracao
     * @return timestamp
     */
    public function getAlteracao()
    {
        return $this->alteracao;
    }

    /**
     * Define o alteracao
     * @param timestamp alteracao
     * return \Model\Cep
     */
    public function setAlteracao($alteracao)
    {
        $this->alteracao = $alteracao;
        return $this;
    }

    /**
     * Retorna o objeto do bairro
     * @return \Endereco\Model\Bairro
     */
    public function getBairroObj()
    {
        return \Endereco\Model\Bairro::findOneByPk($this->getIdBairro());
    }

    /**
     * Retorna o objeto da cidade
     * @return \Endereco\Model\Cidade
     */
    public function getCiddadeObj()
    {
        return \Endereco\Model\Cidade::findOneByPk($this->getIdCidade());
    }

    public function validate()
    {
        $this->alteracao = \Type\DateTime::now();
        return parent::validate();
    }

    public function save($columns = NULL)
    {
        $this->alteracao = \Type\DateTime::now();

        //faz o complemento das informações
        if (!$this->bairro)
        {
            $bairroObj = $this->getBairroObj();

            if ($bairroObj instanceof \Endereco\Model\Bairro)
            {
                $this->setBairro($bairroObj->getNome());
            }
        }

        if (!$this->cidade)
        {
            $cidadeObj = $this->getCiddadeObj();

            if ($cidadeObj instanceof \Endereco\Model\Cidade)
            {
                $this->setCidade($cidadeObj->getNome());
                $this->setUfSigla($cidadeObj->getSigla());
            }
        }

        return parent::save($columns);
    }

    /**
     * Busca um cep pelos seus dados
     *
     * @param int $idCidade
     * @param int $idBairro
     * @param string $logradouro
     * @return \Endereco\Model\Cep
     */
    public static function obterCepPorOutros($idCidade = null, $idBairro = null, $logradouro = null)
    {
        //faz alguns ajustes para ser mais fácil de achar
        //facilita a busca, evitando acentos em ambos os lados
        if ($logradouro)
        {
            $logradouro = \Type\Text::get($logradouro)->toLower()->toASCII()->trim();
            $logradouro = str_replace(array('avenida', 'av.'), 'av%', $logradouro);
            //tira o prefixo de rua da busca, pois é o padrão
            $logradouro = str_replace(array('rua'), '', $logradouro);
            $logradouro = str_replace(' ', '%', $logradouro);
        }

        $filters = null;
        $filters[] = new \Db\Where('idCidade', $idCidade);

        if ($idBairro)
        {
            $filters[] = new \Db\Where('idBairro', $idBairro);
        }

        if ($logradouro)
        {
            $filters[] = new \Db\Where('toAscii(trim(logradouro))', 'like', $logradouro);
        }

        $result = \Endereco\Model\Cep::findOneOrCreate($filters);
        return $result;
    }

    /**
     * Encontra pelo cep
     *
     * @param string $cep
     * @return \Endereco\Model\Cep
     */
    public static function obterPorCep($cep = NULL)
    {
        $cep = \Validator\Validator::unmask($cep);

        if (!$cep)
        {
            return new \Endereco\Model\Cep();
        }

        return \Endereco\Model\Cep::findOneByPkOrCreate(new \Db\Where('cep', $cep));
    }

    public static function getTableName()
    {
        return 'enderecoCep';
    }

    /**
     * Column definition
     */
    public static function defineColumns()
    {
        $columns = array();
        $columns['id'] = new Column('Código', 'id', Column::TYPE_INTEGER, NULL, FALSE, TRUE, NULL, Column::EXTRA_AUTO_INCREMENT);

        //para grid
        $columns['cep'] = new Column('Cep', 'cep', Column::TYPE_VARCHAR, 10);

        $columns['logradouro'] = new Column('Logradouro', 'logradouro', Column::TYPE_VARCHAR, 255, TRUE, FALSE, NULL, NULL);
        $columns['complemento'] = new Column('Complemento', 'complemento', Column::TYPE_VARCHAR, 255, TRUE, FALSE, NULL, NULL);
        $columns['numero'] = new Column('Número', 'numero', Column::TYPE_VARCHAR, 255, TRUE, FALSE, NULL, NULL);

        $columns['idBairro'] = new Column('Bairro', 'idBairro', Column::TYPE_INTEGER, NULL, TRUE, FALSE, NULL, NULL);
        $columns['idBairro']->setReferenceTable('endereco\bairro', 'id', 'nome')->setClass('\Component\Combo\Bairro');

        $columns['bairro'] = new Column('Bairro', 'bairro', Column::TYPE_VARCHAR, 255, TRUE, FALSE, NULL, NULL);
        $columns['cidade'] = new Column('Cidade', 'cidade', Column::TYPE_VARCHAR, 255, TRUE, FALSE, NULL, NULL);

        $columns['ufSigla'] = new Column('Uf (Sigla)', 'ufSigla', Column::TYPE_CHAR, 2, FALSE, FALSE, NULL, NULL);

        $columns['idCidade'] = new Column('Cidade', 'idCidade', Column::TYPE_INTEGER, NULL, FALSE, FALSE, NULL, NULL);
        $columns['idCidade']->setReferenceTable('endereco\cidade', 'id', 'nome')->setClass('\Component\Combo\Cidade');

        $columns['alteracao'] = new Column('Alteracao', 'alteracao', Column::TYPE_TIMESTAMP, NULL, FALSE, FALSE, 'CURRENT_TIMESTAMP', NULL);

        return $columns;
    }

}
