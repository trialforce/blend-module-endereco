<?php

namespace Service;

class ConsultaCep
{

    /**
     * Consulta CEP
     *
     * @param string $cep
     * @return \Endereco\Model\Cep
     */
    public static function execute($cep)
    {
        if (!$cep)
        {
            return;
        }

        $cep = \Validator\Validator::unmask($cep);

        //busca o cep no cache do banco levando em conta 3 dias de cache
        $filters = null;
        $filters[] = new \Db\Where('cep', $cep);
        $filters[] = new \Db\Where('alteracao', '>', \Type\DateTime::now()->addDay(-3)->toDb());
        $cepObj = \Endereco\Model\Cep::findOne($filters);
        $cepObj instanceof \Endereco\Model\Cep;

        //caso não tenha achado no cache busca no correio
        if (!$cepObj instanceof \Endereco\Model\Cep)
        {
            try
            {
                //busca no correio
                throw new \Exception('Ainda preciso incluir essa classe!');
                $resultado = \Service\Correio\ConsultaCep3::consultar($cep);

                if (!$resultado)
                {
                    return;
                }

                $nomeCidade = $resultado->return->cidade;
                $uf = $resultado->return->uf;

                $idCidade = null;
                $cidade = \Endereco\Model\Cidade::localizaCidade($nomeCidade, $uf, $cep);

                if ($cidade instanceof \Endereco\Model\Cidade)
                {
                    $idCidade = $cidade->getId();
                }

                //retorno algo do webservice
                if (isset($resultado->return))
                {
                    $bairro = \Endereco\Model\Bairro::localizaBairro($resultado->return->bairro, $idCidade);

                    $idBairro = null;
                    $logradouro = $resultado->return->end;

                    if ($bairro instanceof \Endereco\Model\Bairro)
                    {
                        $idBairro = $bairro->getId();
                    }

                    //reaproveita um cadastro de cep que esteja sem cep, usado para funcionar na Dinapoli Lajeado
                    $cepObj = self::obterCepPorOutros($idCidade, $idBairro, $logradouro);

                    $cepObj->setBairro($resultado->return->bairro);
                    $cepObj->setIdBairro($idBairro);
                    $cepObj->setCidade($nomeCidade);
                    $cepObj->setCep($cep);
                    $cepObj->setIdCidade($idCidade);
                    $cepObj->setLogradouro($logradouro);
                    $cepObj->setComplemento($resultado->return->complemento2);
                    $cepObj->setNumero($resultado->return->numero);
                    $cepObj->setUfSigla(strtoupper($uf));
                    $cepObj->save();
                }
            }
            catch (\Exception $exc)
            {
                \Log::debug($exc->getMessage());
                //caso não tenha conseguido encontrar cep do correio cadastra um vazio para fazer cache
                $cepObj = new \Endereco\Model\Cep();
                $cepObj->setCep($cep);
                $cepObj->save();
            }
        }

        if ($cepObj instanceof \Endereco\Model\Cep && $cepObj->getBairro())
        {
            $bairroCorreio = $cepObj->getBairro();
            $bairroObj = $cepObj->getBairroObj();

            if ($bairroObj instanceof \Endereco\Model\Bairro)
            {
                $bairroNome = $bairroObj->getNome();

                //caso o nome do bairro no sistema seja diferente do correio, arruma
                //considerando o correio, para ajustar os acentos e etc
                //isso serve para arrumar Sao Cristovao para São Cristóvão, por exemplo
                if ($bairroCorreio != $bairroNome)
                {
                    $bairroObj->setNome($bairroCorreio);
                    $bairroObj->save();
                }
            }
        }

        return $cepObj;
    }

}
