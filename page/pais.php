<?php

namespace Endereco\Page;

class Pais extends \Page\Crud
{

    public function __construct($model = NULL, $activeDropzone = FALSE)
    {
        $this->setIcon('map-marker');
        parent::__construct(new \Endereco\Model\Pais(), $activeDropzone);
    }

}
