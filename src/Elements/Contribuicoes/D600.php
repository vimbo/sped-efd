<?php

namespace NFePHP\EFD\Elements\Contribuicoes;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;

class D600 extends Element implements ElementInterface
{
    const REG = 'D600';
    const LEVEL = 3;
    const PARENT = 'D001';

    protected $parameters = [
        'COD_MOD' => [
            'type' => 'string',
            'regex' => '^(21|22)$',
            'required' => false,
            'info' => 'Código do modelo do documento fiscal, conforme a Tabela 4.1.1. ',
            'format' => ''
        ],
        'COD_MUN' => [
            'type' => 'numeric',
            'regex' => '^(\d{7})$',
            'required' => false,
            'info' => 'Código do município dos terminais faturados, conforme a tabela IBGE ',
            'format' => ''
        ],
        'SER' => [
            'type' => 'string',
            'regex' => '^.{0,4}$',
            'required' => false,
            'info' => 'Série do documento fiscal ',
            'format' => ''
        ],
        'SUB' => [
            'type' => 'numeric',
            'regex' => '^(\d{0,3})$',
            'required' => false,
            'info' => 'Subsérie do documento fiscal ',
            'format' => ''
        ],
        'IND_REC' => [
            'type' => 'numeric',
            'regex' => '^\d$',
            'required' => false,
            'info' => 'Indicador do tipo de receita ' .
                ' 0- Receita própria - serviços prestados ' .
                ' 1- Receita própria - cobrança de débitos ' .
                ' 2- Receita própria - venda de serviço pré-pago – faturamento de períodos anteriores ' .
                ' 3- Receita própria - venda de serviço pré-pago – ',
            'format' => ''
        ],
        'QTD_CONS' => [
            'type' => 'numeric',
            'regex' => '^([0-9]+)$',
            'required' => false,
            'info' => 'Quantidade de documentos consolidados neste registro ',
            'format' => ''
        ],
        'DT_DOC_INI' => [
            'type' => 'string',
            'regex' => '^(0[1-9]|[1-2][0-9]|31(?!(?:0[2469]|11))|30(?!02))(0[1-9]|1[0-2])([12]\d{3})$',
            'required' => false,
            'info' => 'Data Inicial dos documentos consolidados no período ',
            'format' => ''
        ],
        'DT_DOC_FIN' => [
            'type' => 'string',
            'regex' => '^(0[1-9]|[1-2][0-9]|31(?!(?:0[2469]|11))|30(?!02))(0[1-9]|1[0-2])([12]\d{3})$',
            'required' => false,
            'info' => 'Data Final dos documentos consolidados no período ',
            'format' => ''
        ],
        'VL_DOC' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor total acumulado dos documentos fiscais ',
            'format' => '15v2'
        ],
        'VL_DESC' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor acumulado dos descontos ',
            'format' => '15v2'
        ],
        'VL_SERV' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor acumulado das prestações de serviços tributados pelo ICMS ',
            'format' => '15v2'
        ],
        'VL_SERV_NT' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor acumulado dos serviços não-tributados pelo ICMS ',
            'format' => '15v2'
        ],
        'VL_TERC' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valores cobrados em nome de terceiros ',
            'format' => '15v2'
        ],
        'VL_DA' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor acumulado das despesas acessórias ',
            'format' => '15v2'
        ],
        'VL_BC_ICMS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor acumulado da base de cálculo do ICMS ',
            'format' => '15v2'
        ],
        'VL_ICMS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor acumulado do ICMS ',
            'format' => '15v2'
        ],
        'VL_PIS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor do PIS/PASEP ',
            'format' => '15v2'
        ],
        'VL_COFINS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da COFINS ',
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
        if ($this->values->vl_doc <= 0) {
            $this->errors[] = "[" . self::REG . "] " .
                "O campo VL_DOC deve ser maior do que 0";
        }
    }
}
