<?php

namespace NFePHP\EFD\Elements\Contribuicoes;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

class C400 extends Element implements ElementInterface
{
    const REG = 'C400';
    const LEVEL = 5;
    const PARENT = 'C001';

    protected $parameters = [
        'COD_MOD' => [
            'type' => 'string',
            'regex' => '^(02|2D)$',
            'required' => false,
            'info' => 'Código do modelo do documento fiscal, conforme a Tabela 4.1.1',
            'format' => ''
        ],
        'ECF_MOD' => [
            'type' => 'string',
            'regex' => '^.{0,20}$',
            'required' => false,
            'info' => 'Modelo do equipamento',
            'format' => ''
        ],
        'ECF_FAB' => [
            'type' => 'string',
            'regex' => '^.{0,21}$',
            'required' => false,
            'info' => 'Número de série de fabricação do ECF',
            'format' => ''
        ],
        'ECF_CX' => [
            'type' => 'numeric',
            'regex' => '^(\d{0,3})$',
            'required' => false,
            'info' => 'Número do caixa atribuído ao ECF',
            'format' => ''
        ],
        'CST_COFINS' => [
            'type' => 'numeric',
            'regex' => '^(\d{2})$',
            'required' => false,
            'info' => 'Código da Situação Tributária referente a COFINS.',
            'format' => ''
        ],
        'VL_ITEM' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor total dos itens',
            'format' => '15v2'
        ],
        'VL_BC_COFINS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da base de cálculo da COFINS',
            'format' => '15v2'
        ],
        'ALIQ_COFINS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Alíquota da COFINS (em percentual)',
            'format' => '8v4'
        ],
        'QUANT_BC_COFINS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Quantidade – Base de cálculo da COFINS',
            'format' => '15v3'
        ],
        'ALIQ_COFINS_QUANT' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Alíquota da COFINS (em reais)',
            'format' => '15v4'
        ],
        'VL_COFINS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da COFINS',
            'format' => '15v2'
        ],
        'COD_ITEM' => [
            'type' => 'string',
            'regex' => '^.{0,60}$',
            'required' => false,
            'info' => 'Código do item (campo 02 do Registro 0200)',
            'format' => ''
        ],
        'COD_CTA' => [
            'type' => 'string',
            'regex' => '^.{0,255}$',
            'required' => false,
            'info' => 'Código da conta analítica contábil debitada/creditada',
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
        $multiplicacao = $this->values->vl_bc_cofins * $this->values->aliq_cofins;
        if ($this->values->quant_bc_cofins > 0) {
            $multiplicacao = $this->values->quant_bc_cofins * $this->values->aliq_cofins_quant;
        }

        if (number_format($this->values->vl_cofins, 2) != number_format($multiplicacao, 2)) {
            $this->errors[] = "[" . self::REG . "] " .
                "O campo VL_COFINS deve de ser o calculo da multiplicacao " .
                "da base de calculo do cofins com a aliquota do cofins";
        }
    }
}
