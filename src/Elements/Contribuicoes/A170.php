<?php

namespace NFePHP\EFD\Elements\Contribuicoes;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

class A170 extends Element implements ElementInterface
{
    const REG = 'A170';
    const LEVEL = 4;
    const PARENT = 'A100';

    protected $parameters = [
        'NUM_ITEM' => [
            'type' => 'numeric',
            'regex' => '^([1-9]{1})(\d{0,3})$',
            'required' => false,
            'info' => 'Número seqüencial do item no documento fiscal',
            'format' => ''
        ],
        'COD_ITEM' => [
            'type' => 'string',
            'regex' => '^.{0,60}$',
            'required' => false,
            'info' => 'Código do item (campo 02 do Registro 0200)',
            'format' => ''
        ],
        'DESCR_COMPL' => [
            'type' => 'string',
            'regex' => '^(.*)$',
            'required' => false,
            'info' => 'Descrição complementar do item como adotado no documento fiscal',
            'format' => ''
        ],
        'VL_ITEM' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor total do item (mercadorias ou serviços)',
            'format' => '15v2'
        ],
        'VL_DESC' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor do desconto comercial / exclusão da base de cálculo do PIS/PASEP e da COFINS',
            'format' => '15v2'
        ],
        'NAT_BC_CRED' => [
            'type' => 'string',
            'regex' => '^.{2}$',
            'required' => false,
            'info' => 'Código da base de cálculo do crédito, conforme a Tabela indicada no item 4.3.7,
            caso seja informado código representativo de crédito no Campo 09 (CST_PIS)
            ou no Campo 13 (CST_COFINS).',
            'format' => ''
        ],
        'IND_ORIG_CRED' => [
            'type' => 'string',
            'regex' => '^(0|1)$',
            'required' => false,
            'info' => 'Indicador da origem do crédito: 0 – Operação no Mercado Interno',
            'format' => ''
        ],
        'CST_PIS' => [
            'type' => 'numeric',
            'regex' => '^(\d{2})$',
            'required' => false,
            'info' => 'Código da Situação Tributária referente ao PIS/PASEP – Tabela 4.3.3.',
            'format' => ''
        ],
        'VL_BC_PIS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da base de cálculo do PIS/PASEP.',
            'format' => '15v2'
        ],
        'ALIQ_PIS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Alíquota do PIS/PASEP (em percentual)',
            'format' => '15v2'
        ],
        'VL_PIS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor do PIS/PASEP',
            'format' => '15v2'
        ],
        'CST_COFINS' => [
            'type' => 'numeric',
            'regex' => '^(\d{2})$',
            'required' => false,
            'info' => 'Código da Situação Tributária referente ao COFINS – Tabela 4.3.4.',
            'format' => ''
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
            'info' => 'Alíquota do COFINS (em percentual)',
            'format' => '6v2'
        ],
        'VL_COFINS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da COFINS',
            'format' => '15v2'
        ],
        'COD_CTA' => [
            'type' => 'string',
            'regex' => '^.{0,255}$',
            'required' => false,
            'info' => 'Código da conta analítica contábil debitada/creditada',
            'format' => ''
        ],
        'COD_CCUS' => [
            'type' => 'string',
            'regex' => '^.{0,255}$',
            'required' => false,
            'info' => 'Código do centro de custos',
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

    /**
     * Arre
     * @param float $valor
     * @return float|int
     */
    private function roundFloat($valor)
    {
        return (float)number_format($valor, 2);
    }

    public function postValidation()
    {
        if ($this->roundFloat($this->values->vl_pis) !=
            $this->roundFloat(($this->values->vl_bc_pis * $this->values->aliq_pis) / 100)) {
            $this->errors[] = "[" . self::REG . "] " .
                "valor do campo “VL_PIS” deve corresponder ao valor da base de cálculo (VL_BC_PIS) multiplicado " .
                "pela alíquota aplicável ao item (ALIQ_PIS). No caso de aplicação da alíquota " .
                "do campo 07, o resultado deverá ser dividido pelo valor “100”.";
        }

        if ($this->roundFloat($this->values->vl_cofins) !=
            $this->roundFloat(($this->values->vl_bc_cofins * $this->values->aliq_cofins) / 100)) {
            $this->errors[] = "[" . self::REG . "] " .
                "o valor do campo “VL_COFINS” deve corresponder ao valor da base de cálculo (VL_BC_COFINS) " .
                "multiplicado pela alíquota aplicável ao item (ALIQ_COFINS). No caso de aplicação da alíquota " .
                "do campo 07, o resultado deverá ser dividido pelo valor “100”.";
        }
    }
}
