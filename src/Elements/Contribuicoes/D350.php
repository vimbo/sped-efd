<?php

namespace NFePHP\EFD\Elements\Contribuicoes;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;

class D350 extends Element implements ElementInterface
{
    const REG = 'D350';
    const LEVEL = 3;
    const PARENT = 'D300';

    protected $parameters = [
        'COD_MOD' => [
            'type' => 'string',
            'regex' => '^(2E|13|14|15|16)$',
            'required' => false,
            'info' => 'Código do modelo do documento fiscal, conforme a Tabela 4.1.1 ',
            'format' => ''
        ],
        'ECF_MOD' => [
            'type' => 'string',
            'regex' => '^.{0,20}$',
            'required' => false,
            'info' => 'Modelo do equipamento ',
            'format' => ''
        ],
        'ECF_FAB' => [
            'type' => 'string',
            'regex' => '^.{0,21}$',
            'required' => false,
            'info' => 'Número de série de fabricação do ECF ',
            'format' => ''
        ],
        'DT_DOC' => [
            'type' => 'string',
            'regex' => '^(0[1-9]|[1-2][0-9]|31(?!(?:0[2469]|11))|30(?!02))(0[1-9]|1[0-2])([12]\d{3})$',
            'required' => false,
            'info' => 'Data do movimento a que se refere a Redução Z ',
            'format' => ''
        ],
        'CRO' => [
            'type' => 'numeric',
            'regex' => '^([1-9]{1})(\d{0,2})$',
            'required' => false,
            'info' => 'Posição do Contador de Reinício de Operação ',
            'format' => ''
        ],
        'CRZ' => [
            'type' => 'numeric',
            'regex' => '^([1-9]{1})(\d{0,5})$',
            'required' => false,
            'info' => 'Posição do Contador de Redução Z ',
            'format' => ''
        ],
        'NUM_COO_FIN' => [
            'type' => 'numeric',
            'regex' => '^([1-9]{1})(\d{0,5})$',
            'required' => false,
            'info' => 'Número do Contador de Ordem de Operação do último documento emitido no dia. (Número ' .
                'do COO na Redução Z) ',
            'format' => ''
        ],
        'GT_FIN' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor do Grande Total final ',
            'format' => '15v2'
        ],
        'VL_BRT' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da venda bruta ',
            'format' => '15v2'
        ],
        'CST_PIS' => [
            'type' => 'string',
            'regex' => '^((0[1-9])|49|99)$',
            'required' => false,
            'info' => 'Código da Situação Tributária referente ao PIS/PASEP ',
            'format' => ''
        ],
        'VL_BC_PIS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da base de cálculo do PIS/PASEP ',
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
            'info' => 'Quantidade – Base de cálculo PIS/PASEP ',
            'format' => '15v3'
        ],
        'ALIQ_PIS_QUANT' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Alíquota do PIS/PASEP (em reais) ',
            'format' => '15v4'
        ],
        'VL_PIS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor do PIS/PASEP ',
            'format' => '15v2'
        ],
        'CST_COFINS' => [
            'type' => 'string',
            'regex' => '^((5[0-6])|(6[0-6])|(7[0-5])|98|99)$',
            'required' => false,
            'info' => 'Código da Situação Tributária referente a COFINS ',
            'format' => ''
        ],
        'VL_BC_COFINS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da base de cálculo da COFINS ',
            'format' => '15v2'
        ],
        'ALIQ_COFINS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Alíquota da COFINS (em percentual) ',
            'format' => '8v4'
        ],
        'QUANT_BC_COFINS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Quantidade – Base de cálculo da COFINS ',
            'format' => '15v3'
        ],
        'ALIQ_COFINS_QUANT' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Alíquota da COFINS (em reais) ',
            'format' => '15v4'
        ],
        'VL_COFINS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da COFINS ',
            'format' => '15v2'
        ],
        'COD_CTA' => [
            'type' => 'string',
            'regex' => '^.{0,255}$',
            'required' => false,
            'info' => 'Código da conta analítica contábil debitada/creditada ',
            'format' => ''
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
        $this->postValidation();
    }

    public function postValidation()
    {
        $multiplicacao = $this->values->vl_bc_pis * $this->values->aliq_pis;
        if (number_format($this->values->vl_pis, 2) != number_format($multiplicacao / 100, 2)) {
            $this->errors[] = "[" . self::REG . "] " .
                "O campo VL_PIS deve de ser o calculo da multiplicacao " .
                "da base de calculo do PIS com a aliquota do PIS, o resultado dividido por 100";
        }

        $multiplicacao = $this->values->vl_bc_cofins * $this->values->aliq_cofins;
        if (number_format($this->values->vl_cofins, 2) != number_format($multiplicacao / 100, 2)) {
            $this->errors[] = "[" . self::REG . "] " .
                "O campo VL_COFINS deve de ser o calculo da multiplicacao " .
                "da base de calculo do cofins com a aliquota do cofins, o resultado dividido por 100";
        }
    }
}
