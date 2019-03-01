<?php

namespace Endereco\Component\Combo;

class Bairro extends \Component\Combo
{

    public function onCreate()
    {
        $content = parent::onCreate();
        $this->hideValue();
        return $content;
    }

    public function getDataSource()
    {
        $datasource = new \DataSource\Model(new \Endereco\Model\Bairro());

        //filtra pela id cidade caso possível
        $idCidade = \DataHandle\Request::get('idCidade');

        if ($idCidade)
        {
            $cond = new \Db\Cond('idCidade = ?', $idCidade);
            $datasource->addExtraFilter($cond);
        }

        $columns[] = new \Component\Grid\PkColumn('id', 'Código');
        $columns[] = new \Component\Grid\Column('nome', 'Nome', \Component\Grid\Column::ALIGN_LEFT, \Db\Column::TYPE_VARCHAR);
        $datasource->setColumns($columns);

        return $datasource;
    }

}
