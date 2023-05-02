<?php

namespace NFePHP\EFD\Elements\Contribuicoes;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

class M100 extends Element implements ElementInterface
{
    const REG = 'M100';
    const LEVEL = 3;
    const PARENT = 'M001';

    protected $parameters = [
        'COD_CRED' => [
            'type' => 'string',
            'regex' => '^.{3}$',
            'required' => false,
            'info' => 'Código de Tipo de Crédito apurado no período, conforme a Tabela 4.3.6. ',
            'format' => ''
        ],
        'IND_CRED_ORI' => [
            'type' => 'numeric',
            'regex' => '^(0|1)$',
            'required' => false,
            'info' => 'Indicador de Crédito Oriundo de ' .
                ' 0 – Operações próprias 1 – Evento de incorporação, cisão ou fusão ',
            'format' => ''
        ],
        'VL_BC_PIS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da Base de Cálculo do Crédito ',
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
        'VL_CRED' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor total do crédito apurado no período ',
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
        'VL_CRED_DIF' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor total do crédito diferido no período ',
            'format' => '15v2'
        ],
        'VL_CRED_DISP' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor Total do Crédito Disponível relativo ao Período (08 + 09 – 10 – 11) ',
            'format' => '15v2'
        ],
        'IND_DESC_CRED' => [
            'type' => 'string',
            'regex' => '^(0|1)$',
            'required' => false,
            'info' => 'Indicador de opção de utilização do crédito disponível no período ' .
                ' 0 – Utilização do valor total para desconto da contribuição apurada no período, no ' .
                'Registro M200 ' .
                ' 1 – Utilização de valor parcial para desconto da contribuição apurada no período, ' .
                'no Registro M200. ',
            'format' => ''
        ],
        'VL_CRED_DESC' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor do Crédito disponível, descontado da contribuição apurada no próprio período. ' .
                'Se IND_DESC_CRED=0, informar o valor total do Campo 12 ' .
                ' ',
            'format' => '15v2'
        ],
        'SLD_CRED' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Saldo de créditos a utilizar em períodos futuros (12 – 14) ',
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

    public function postValidation()
    {
        $calculo = $this->values->vl_cred+$this->values->vl_ajus_cred;
        $calculo = $calculo-$this->values->vl_ajus_reduc;
        if ($this->values->vl_cred_dif>$calculo) {
            $this->errors[] = "[" . self::REG . "] " .
                "O campo VL_CRED_DIF não deve de ser maior do que  " .
                "não pode ser maior que VL_CRED + VL_AJUS_ACRES - VL_AJUS_REDUC";
        }
    }
}
