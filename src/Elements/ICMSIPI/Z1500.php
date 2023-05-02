<?php

namespace NFePHP\EFD\Elements\ICMSIPI;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

class Z1500 extends Element implements ElementInterface
{
    const REG = '1500';
    const LEVEL = 2;
    const PARENT = '1001';

    protected $parameters = [
        'IND_OPER' => [
            'type'     => 'string',
            'regex'    => '^.{1}$',
            'required' => true,
            'info'     => 'Indicador do tipo de operação: '
            .'1- Saída',
            'format'   => ''
        ],
        'IND_EMIT' => [
            'type'     => 'string',
            'regex'    => '^.{1}$',
            'required' => true,
            'info'     => 'Indicador do emitente do documento fiscal: '
            .'0- Emissão própria;',
            'format'   => ''
        ],
        'COD_PART' => [
            'type'     => 'string',
            'regex'    => '^.{1,60}$',
            'required' => true,
            'info'     => 'Código do participante (campo 02 do Registro 0150): - do adquirente, no caso das saídas.',
            'format'   => ''
        ],
        'COD_MOD' => [
            'type'     => 'string',
            'regex'    => '^.{2}$',
            'required' => true,
            'info'     => 'Código do modelo do documento fiscal, conforme a Tabela 4.1.1',
            'format'   => ''
        ],
        'COD_SIT' => [
            'type'     => 'string',
            'regex'    => '^0[0|1|6|7|8]$',
            'required' => true,
            'info'     => 'Código da situação do documento fiscal, conforme a Tabela 4.1.2',
            'format'   => ''
        ],
        'SER' => [
            'type'     => 'string',
            'regex'    => '^.{1,4}$',
            'required' => false,
            'info'     => 'Série do documento fiscal',
            'format'   => ''
        ],
        'SUB' => [
            'type'     => 'integer',
            'regex'    => '^\d{1,3}$',
            'required' => false,
            'info'     => 'Subsérie do documento fiscal',
            'format'   => ''
        ],
        'COD_CONS' => [
            'type'     => 'string',
            'regex'    => '^0[1|2|3|4|5|6|7|8]$',
            'required' => true,
            'info'     => 'Código de classe de consumo de energia elétrica: '
            .'01 - Comercial '
            .'02 - Consumo Próprio '
            .'03 - Iluminação Pública '
            .'04 - Industrial '
            .'05 - Poder Público '
            .'06 - Residencial '
            .'07 - Rural '
            .'08 -Serviço Público',
            'format'   => ''
        ],
        'NUM_DOC' => [
            'type'     => 'integer',
            'regex'    => '^\d{1,9}$',
            'required' => true,
            'info'     => 'Número do documento fiscal',
            'format'   => ''
        ],
        'DT_DOC' => [
            'type'     => 'integer',
            'regex'    => '^(0[1-9]|[1-2][0-9]|31(?!(?:0[2469]|11))|30(?!02))(0[1-9]|1[0-2])([12]\d{3})$',
            'required' => true,
            'info'     => 'Data da emissão do documento fiscal',
            'format'   => ''
        ],
        'DT_E_S' => [
            'type'     => 'integer',
            'regex'    => '^(0[1-9]|[1-2][0-9]|31(?!(?:0[2469]|11))|30(?!02))(0[1-9]|1[0-2])([12]\d{3})$',
            'required' => true,
            'info'     => 'Data da entrada ou da saída',
            'format'   => ''
        ],
        'VL_DOC' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor total do documento fiscal',
            'format'   => '15v2'
        ],
        'VL_DESC' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info'     => 'Valor total do desconto',
            'format'   => '15v2'
        ],
        'VL_FORN' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor total fornecido/consumido',
            'format'   => '15v2'
        ],
        'VL_SERV_NT' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info'     => 'Valor total dos serviços não-tributados pelo ICMS',
            'format'   => '15v2'
        ],
        'VL_TERC' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info'     => 'Valor total cobrado em nome de terceiros',
            'format'   => '15v2'
        ],
        'VL_DA' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info'     => 'Valor total de despesas acessórias indicadas no documento fiscal',
            'format'   => '15v2'
        ],
        'VL_BC_ICMS' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info'     => 'Valor acumulado da base de cálculo do ICMS',
            'format'   => '15v2'
        ],
        'VL_ICMS' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info'     => 'Valor acumulado do ICMS',
            'format'   => '15v2'
        ],
        'VL_BC_ICMS_ST' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info'     => 'Valor acumulado da base de cálculo do ICMS substituição tributária',
            'format'   => '15v2'
        ],
        'VL_ICMS_ST' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info'     => 'Valor acumulado do ICMS retido por substituição tributária',
            'format'   => '15v2'
        ],
        'COD_INF' => [
            'type'     => 'string',
            'regex'    => '^.{1,6}$',
            'required' => false,
            'info'     => 'Código da informação complementar do documento fiscal (campo 02 do Registro 0450)',
            'format'   => ''
        ],
        'VL_PIS' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info'     => 'Valor do PIS',
            'format'   => '15v2'
        ],
        'VL_COFINS' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info'     => 'Valor da COFINS',
            'format'   => '15v2'
        ],
        'TP_LIGACAO' => [
            'type'     => 'integer',
            'regex'    => '^[1|2|3]$',
            'required' => false,
            'info'     => 'Código de tipo de Ligação '
            .'1 - Monofásico '
            .'2 - Bifásico '
            .'3 - Trifásico',
            'format'   => ''
        ],
        'COD_GRUPO_TENSAO' => [
            'type'     => 'string',
            'regex'    => '^0[1-9]|1[0-4]$',
            'required' => false,
            'info'     => 'Código de grupo de tensão: '
            .'01 - A1 - Alta Tensão (230kV ou mais) '
            .'02 - A2 - Alta Tensão (88 a 138kV) '
            .'03 - A3 - Alta Tensão (69kV) '
            .'04 - A3a - Alta Tensão (30kV a 44kV) '
            .'05 - A4 - Alta Tensão (2,3kV a 25kV) '
            .'06 - AS - Alta Tensão Subterrâneo 06 '
            .'07 - B1 - Residencial 07 '
            .'08 - B1 - Residencial Baixa Renda 08 '
            .'09 - B2 - Rural 09 '
            .'10 - B2 - Cooperativa de Eletrificação Rural '
            .'11 - B2 - Serviço Público de Irrigação '
            .'12 - B3 - Demais Classes '
            .'13 - B4a - Iluminação Pública - rede de distribuição '
            .'14 - B4b - Iluminação Pública - bulbo de lâmpada',
            'format'   => ''
        ]
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
        /*
         * Campo 10 (NUM_DOC) Validação: o valor informado no campo deve ser maior que “0” (zero).
         */
        if ($this->std->num_doc <= 0) {
            $this->errors[] = "[" . self::REG . "] O valor informado no campo "
            ."NUM_DOC deve ser maior que “0” (zero).";
        }

        /*
         * Campo 13 (VL_DOC) Validação: o valor informado no campo deve ser maior que “0” (zero).
         */
        if ($this->std->vl_doc <= 0) {
            $this->errors[] = "[" . self::REG . "] O valor informado no campo "
            ."VL_DOC deve ser maior que “0” (zero).";
        }

        /*
         * Campo 15 (VL_FORN) Validação: o valor informado no campo deve ser maior que “0” (zero).
         */
        if ($this->std->vl_forn <= 0) {
            $this->errors[] = "[" . self::REG . "] O valor informado no campo "
            ."VL_FORN deve ser maior que “0” (zero).";
        }
    }
}
