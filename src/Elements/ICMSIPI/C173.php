<?php

namespace NFePHP\EFD\Elements\ICMSIPI;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

/**
 * REGISTRO C173: OPERAÇÕES COM MEDICAMENTOS (CÓDIGO 01 e 55).
 * Este registro deve ser apresentado pelas empresas do segmento farmacêutico (distribuidoras, indústrias,
 * revendedoras e importadoras), exceto comércio varejista.
 * A obrigatoriedade deriva do §26 do art. 19 do Convênio S/N de 1970
 * @package NFePHP\EFD\Elements\ICMSIPI
 */
class C173 extends Element implements ElementInterface
{
    const REG = 'C173';
    const LEVEL = 4;
    const PARENT = 'C';

    protected $parameters = [
        'LOTE_MED' => [
            'type' => 'string',
            'regex' => '^(.*)$',
            'required' => true,
            'info' => 'Número do lote de fabricação do medicamento',
            'format' => ''
        ],
        'QTD_ITEM' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info' => 'Quantidade de item por lote',
            'format' => '15v3'
        ],
        'DT_FAB' => [
            'type' => 'string',
            'regex' => '^(0[1-9]|[1-2][0-9]|31(?!(?:0[2469]|11))|30(?!02))(0[1-9]|1[0-2])([12]\d{3})$',
            'required' => true,
            'info' => 'Data de fabricação do medicamento',
            'format' => ''
        ],
        'DT_VAL' => [
            'type' => 'string',
            'regex' => '^(0[1-9]|[1-2][0-9]|31(?!(?:0[2469]|11))|30(?!02))(0[1-9]|1[0-2])([12]\d{3})$',
            'required' => true,
            'info' => 'Data de expiração da validade do medicamento',
            'format' => ''
        ],
        'IND_MED' => [
            'type' => 'string',
            'regex' => '^(0|1|2|3|4)$',
            'required' => true,
            'info' => 'Indicador de tipo de referência da base de cálculo do ICMS',
            'format' => ''
        ],
        'TP_PROD' => [
            'type' => 'string',
            'regex' => '^(0|1|2)$',
            'required' => true,
            'info' => 'Tipo de produto',
            'format' => ''
        ],
        'VL_TAB_MAX' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info' => 'Valor   do   preço   tabelado   ou   valor   do   preço máximo',
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
        if ((float)$this->std->qtd_item <= 0) {
            $this->errors[] = "[" . self::REG . "] " .
                " O valor do preco tabelado (VL_TAB_MAX) deve ser maior do que zero ";
        }
    }
}
