<?php

namespace Endereco\Page;

class Cep extends \Page\Crud
{

    public function __construct($model = NULL, $activeDropzone = FALSE)
    {
        $this->setIcon('map-marker');
        parent::__construct(new \Endereco\Model\Cep(), $activeDropzone);
    }

    public function adjustFields()
    {
        $fields = parent::adjustFields();

        $this->byId('contain_id')->show();

        return $fields;
    }

    public function adicionar()
    {
        $campos = parent::adicionar();

        $this->byId('id')->setReadOnly(false);

        return $campos;
    }

    public function setDefaultGrid()
    {
        $grid = parent::setDefaultGrid();
        $columns = $grid->getColumns();

        $grid->setColumns($columns);
        return $grid;
    }

}
