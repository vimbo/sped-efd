<?php

namespace NFePHP\EFD\Elements\ICMSIPI;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

/**
 * REGISTRO C880: INFORMAÇÕES COMPLEMENTARES DAS OPERAÇÕES DE SAÍDA DE MERCADORIAS SUJEITAS À
 * SUBSTITUIÇÃO TRIBUTÁRIA (CF-E-SAT) (CÓDIGO 59)
 * @package NFePHP\EFD\Elements\ICMSIPI
 */
class C880 extends Element implements ElementInterface
{
    const REG = 'C880';
    const LEVEL = 4;
    const PARENT = 'C870';

    protected $parameters = [
        'COD_MOT_REST_COMPL' => [
            'type'     => 'string',
            'regex'    => '^[0-9]{5}$',
            'required' => true,
            'info'     => 'Código do motivo da restituição ou complementação conforme Tabela 5.7',
            'format'   => ''
        ],
        'QUANT_CONV' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Quantidade do item',
            'format'   => '15v6'
        ],
        'UNID' => [
            'type'     => 'string',
            'regex'    => '^[0-9]{0}$',
            'required' => true,
            'info'     => 'Unidade adotada para informar o campo QUANT_CONV.',
            'format'   => ''
        ],
        'VL_UNIT_ICMS_NA_OPERACAO_CONV' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor unitário para o ICMS na operação, caso não houvesse a ST, considerando unidade '
            .'utilizada para informar o campo QUANT_CONV, aplicando-se a mesma redução da base de cálculo do '
            .'ICMS ST na tributação, se houver.',
            'format'   => '15v3'
        ],
        'VL_UNIT_ICMS_OP_CONV' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor unitário correspondente ao ICMS OP utilizado no cálculo do ressarcimento / '
            .'restituição, no desfazimento da substituição tributária, calculado conforme a legislação de cada UF, '
            .'considerando a unidade utilizada para informar o campo QUANT_CONV.',
            'format'   => '15v3'
        ],
        'VL_UNIT_ICMS_OP_ESTOQUE_CONV' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor médio unitário do ICMS que o contribuinte teria se creditado referente à operação de '
            .'entrada das mercadorias em estoque caso estivesse submetida ao regime comum de tributação, calculado '
            .'conforme a legislação de cada UF, considerando a unidade utilizada para informar o campo QUANT_CONV',
            'format'   => '15v3'
        ],
        'VL_UNIT_ICMS_ST_ESTOQUE_CONV' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor médio unitário do ICMS/ST, incluindo FCP ST, das mercadorias em estoque, considerando '
            .'unidade utilizada para informar o campo QUANT_CONV.',
            'format'   => '15v3'
        ],
        'VL_UNIT_FCP_ICMS_ST_ESTOQUE_CONV' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor médio unitário do FCP ST agregado ao ICMS das mercadorias em estoque, considerando '
            .'unidade utilizada para informar o campo QUANT_CONV.',
            'format'   => '15v3'
        ],
        'VL_UNIT_ICMS_ST_CONV_REST' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor unitário do total do ICMS/ST, incluindo FCP ST, a ser restituído/ressarcido, '
            .'calculado conforme a legislação de cada UF, considerando a unidade utilizada para informar o campo '
            .'QUANT_CONV.',
            'format'   => '15v3'
        ],
        'VL_UNIT_FCP_ST_CONV_REST' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor unitário correspondente à parcela de ICMS FCP ST que compõe o campo '
            .'VL_UNIT_ICMS_ST_CONV_REST, considerando a unidade utilizada para informar o campo QUANT_CONV.',
            'format'   => '15v3'
        ],
        'VL_UNIT_ICMS_ST_CONV_COMPL' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor unitário do complemento do ICMS, incluindo FCP ST, considerando a unidade utilizada '
            .'para informar o campo QUANT_CONV.',
            'format'   => '15v3'
        ],
        'VL_UNIT_FCP_ST_CONV_COMPL' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor unitário correspondente à parcela de ICMS FCP ST que compõe o campo '
            .'VL_UNIT_ICMS_ST_CONV_COMPL, considerando unidade utilizada para informar o campo QUANT_CONV.',
            'format'   => '15v3'
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
    }
}
