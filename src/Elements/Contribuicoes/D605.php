<?php

namespace NFePHP\EFD\Elements\Contribuicoes;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;

class D605 extends Element implements ElementInterface
{
    const REG = 'D605';
    const LEVEL = 4;
    const PARENT = 'D600';

    protected $parameters = [
        'COD_CLASS' => [
            'type' => 'numeric',
            'regex' => '^(\d{4})$',
            'required' => false,
            'info' => 'Código de classificação do item do serviço de comunicação ou de telecomunicação, ' .
                'conforme a Tabela 4.4.1 ',
            'format' => ''
        ],
        'VL_ITEM' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor acumulado do item ',
            'format' => '15v2'
        ],
        'VL_DESC' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor acumulado dos descontos/exclusões da base de cálculo ',
            'format' => '15v2'
        ],
        'CST_COFINS' => [
            'type' => 'string',
            'regex' => '^((0[1-9])|49|99)$',
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
            'info' => 'Código da conta contábil debitada/creditada ',
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
        if (number_format($this->values->vl_cofins, 2) != number_format($multiplicacao / 100, 2)) {
            $this->errors[] = "[" . self::REG . "] " .
                "O campo VL_COFINS deve de ser o calculo da multiplicacao " .
                "da base de calculo do cofins com a aliquota do cofins, o resultado dividido por 100";
        }
    }
}
