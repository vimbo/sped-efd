<?php

namespace NFePHP\EFD\Elements\ICMSIPI;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

class C470 extends Element implements ElementInterface
{
    const REG = 'C470';
    const LEVEL = 5;
    const PARENT = 'C400';

    protected $parameters = [
        'COD_ITEM' => [
            'type' => 'string',
            'regex' => '^.{1,60}$',
            'required' => true,
            'info' => 'Código do item (campo 02 do Registro 0200)',
            'format' => ''
        ],
        'QTD' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info' => 'Quantidade do item',
            'format' => '15v3'
        ],
        'QTD_CANC' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Quantidade cancelada, no caso de cancelamento parcial de item',
            'format' => '15v3'
        ],
        'UNID' => [
            'type' => 'string',
            'regex' => '^.{1,6}$',
            'required' => true,
            'info' => 'Unidade do item (Campo 02 do registro 0190)',
            'format' => ''
        ],
        'VL_ITEM' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info' => 'Valor total do item',
            'format' => '15v2'
        ],
        'CST_ICMS' => [
            'type' => 'numeric',
            'regex' => '^(\d{3})$',
            'required' => true,
            'info' => 'Código da Situação Tributária',
            'format' => ''
        ],
        'CFOP' => [
            'type' => 'numeric',
            'regex' => '^(\d{4})$',
            'required' => true,
            'info' => 'Código Fiscal de Operação e Prestação',
            'format' => ''
        ],
        'ALIQ_ICMS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Alíquota do ICMS – Carga tributária efetiva em percentual',
            'format' => '6v2'
        ],
        'VL_PIS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor do PIS',
            'format' => '15v2'
        ],
        'VL_COFINS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da COFINS',
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
        $this->postValidation();
    }

    public function postValidation()
    {
        if ($this->values->vl_item <= 0) {
            $this->errors[] = "[" . self::REG . "] "
                . " O Valor total do item"
                . "(VL_ITEM) deve ser maior que 0";
        }
        if ($this->values->qtd <= 0) {
            $this->errors[] = "[" . self::REG . "] "
                . " Quantidade total do item"
                . "(QTD) deve ser maior que 0";
        }
    }
}
