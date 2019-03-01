<?php

namespace Endereco\Migration;

class V00010001 extends \Db\Migration\Version
{

    public function execute()
    {
        $manager = $this->getMigration();

        $manager->diffModel('Endereco\Model\Pais');
        $manager->diffModel('Endereco\Model\Uf');
        $manager->diffModel('Endereco\Model\Cidade');
        $manager->diffModel('Endereco\Model\Bairro');
        $manager->diffModel('Endereco\Model\Cep');
    }

}
