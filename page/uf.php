<?php

namespace Endereco\Page;

class Uf extends \Page\Crud
{

    public function __construct($model = NULL, $activeDropzone = FALSE)
    {
        $this->setIcon('map-marker');
        parent::__construct(new \Endereco\Model\Uf(), $activeDropzone);
    }

}
