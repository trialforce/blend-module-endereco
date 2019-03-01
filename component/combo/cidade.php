<?php

namespace Endereco\Component\Combo;

use DataHandle\Request;

class Cidade extends \Component\Combo
{

    public function __construct($id = null)
    {
        parent::__construct($id);
    }

    public function onCreate()
    {
        $content = parent::onCreate();
        $this->hideValue();
        return $content;
    }

    public function getDataSource()
    {
        $datasource = new \DataSource\Model(new \Endereco\Model\Cidade());

        $idUf = Request::get('idUf');

        if ($idUf)
        {
            $datasource->addExtraFilter(new \Db\Cond('sigla = (SELECT sigla FROM uf WHere uf.id = ?)', $idUf));
        }

        $columns[] = new \Component\Grid\PkColumn('id', 'Código');
        $columns[] = new \Component\Grid\Column('nome', 'Nome', \Component\Grid\Column::ALIGN_LEFT, \Db\Column::TYPE_VARCHAR);
        $columns[] = new \Component\Grid\Column('sigla', 'Sigla', \Component\Grid\Column::ALIGN_LEFT, \Db\Column::TYPE_VARCHAR);

        $datasource->setColumns($columns);

        return $datasource;
    }

}
