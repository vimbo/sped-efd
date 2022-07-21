<?php

namespace NFePHP\EFD\Elements\Contribuicoes;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

class M210 extends Element implements ElementInterface
{
    const REG = 'M210';
    const LEVEL = 3;
    const PARENT = 'M200';

    protected $parameters = [
        'COD_CONT' => [
            'type' => 'string',
            'regex' => '^.{2}$',
            'required' => false,
            'info' => 'Código da contribuição social apurada no período, conforme a Tabela 4.3.5. ',
            'format' => ''
        ],
        'VL_REC_BRT' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da Receita Bruta ',
            'format' => '15v2'
        ],
        'VL_BC_CONT' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da Base de Cálculo da Contribuição ',
            'format' => '15v2'
        ],
        'VL_AJUS_ACRES_BC_PIS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor do total dos ajustes de acréscimo da base de cálculo '
                .'da contribuição a que se refere o Campo 04 ',
            'format' => '15v2'
        ],
        'VL_AJUS_REDUC_BC_PIS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor do total dos ajustes de redução da base de '
                . 'cálculo da contribuição a que se refere o Campo 04',
            'format' => '15v2'
        ],
        'VL_BC_CONT_AJUS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da Base de Cálculo da Contribuição, após os '
                . 'ajustes. (Campo 07 = Campo 04 + Campo 05 - Campo 06)',
            'format' => '15v2'
        ],
        'ALIQ_PIS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Alíquota do PIS/PASEP (em percentual) ',
            'format' => '8v4'
        ],
        'QUANT_BC_PIS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Quantidade – Base de cálculo PIS ',
            'format' => '15v3'
        ],
        'ALIQ_PIS_QUANT' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Alíquota do PIS (em reais) ',
            'format' => '15v4'
        ],
        'VL_CONT_APUR' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor total da contribuição social apurada ',
            'format' => '15v2'
        ],
        'VL_AJUS_ACRES' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor total dos ajustes de acréscimo ',
            'format' => '15v2'
        ],
        'VL_AJUS_REDUC' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor total dos ajustes de redução ',
            'format' => '15v2'
        ],
        'VL_CONT_DIFER' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da contribuição a diferir no período ',
            'format' => '15v2'
        ],
        'VL_CONT_DIFER_ANT' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da contribuição diferida em períodos anteriores ',
            'format' => '15v2'
        ],
        'VL_CONT_PER' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor Total da Contribuição do Período (08 + 09 – 10 – 11+12) ',
            'format' => '15v2'
        ],

    ];

    /**
     * Constructor
     * @param \stdClass $std
     */
    public function __construct(\stdClass $std)
    {
        parent::__construct(self::REG);
        $this->std = $this->standarize($std);
    }
}
