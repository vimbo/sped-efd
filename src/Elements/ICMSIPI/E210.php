<?php

namespace NFePHP\EFD\Elements\ICMSIPI;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

class E210 extends Element implements ElementInterface
{
    const REG = 'E210';
    const LEVEL = 3;
    const PARENT = 'E200';

    protected $parameters = [
        'IND_MOV_ST' => [
            'type'     => 'integer',
            'regex'    => '^[0-1]{1}$',
            'required' => true,
            'info'     => 'Indicador de movimento: 0 – Sem operações com ST 1 – Com operações de ST',
            'format'   => ''
        ],
        'VL_SLD_CRED_ANT_ST' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor do "Saldo credor de período anterior – Substituição Tributária"',
            'format'   => '15v2'
        ],
        'VL_DEVOL_ST' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor total do ICMS ST de devolução de mercadorias',
            'format'   => '15v2'
        ],
        'VL_RESSARC_ST' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor total do ICMS ST de ressarcimentos',
            'format'   => '15v2'
        ],
        'VL_OUT_CRED_ST' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor total de Ajustes "Outros créditos ST" e “Estorno de débitos ST”',
            'format'   => '15v2'
        ],
        'VL_AJ_CREDITOS_ST' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor total dos ajustes a crédito de ICMS ST, provenientes de ajustes do documento fiscal.',
            'format'   => '15v2'
        ],
        'VL_RETENCAO_ST' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor Total do ICMS retido por Substituição Tributária',
            'format'   => '15v2'
        ],
        'VL_OUT_DEB_ST' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor Total dos ajustes "Outros débitos ST" " e “Estorno de créditos ST”',
            'format'   => '15v2'
        ],
        'VL_AJ_DEBITOS_ST' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor total dos ajustes a débito de ICMS ST, provenientes de ajustes do documento fiscal.',
            'format'   => '15v2'
        ],
        'VL_SLD_DEV_ANT_ST' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor total de Saldo devedor antes das deduções',
            'format'   => '15v2'
        ],
        'VL_DEDUCOES_ST' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor total dos ajustes "Deduções ST"',
            'format'   => '15v2'
        ],
        'VL_ICMS_RECOL_ST' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Imposto a recolher ST (11-12)',
            'format'   => '15v2'
        ],
        'VL_SLD_CRED_ST_TRANSPORTAR' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Saldo credor de ST a transportar para o período '
            .'seguinte [(03+04+05+06+07+12)– (08+09+10)].',
            'format'   => '15v2'
        ],
        'DEB_ESP_ST' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valores recolhidos ou a recolher, extra- apuração.',
            'format'   => '15v2'
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
        //TODO: essa validação posterior está incorreta
        //$this->postValidation();
    }

    public function postValidation()
    {
        /*
         * Campo 11 (VL_SLD_DEV_ANT_ST) Validação: o valor informado deve ser preenchido com base na
         * expressão: soma do total de retenção por ST, campo VL_RETENCAO_ST, com total de outros
         * débitos por ST, campo VL_OUT_DEB_ST, com total de ajustes de débito por ST, campo
         * VL_AJ_DEBITOS_ST, menos a soma do saldo credor do período anterior por ST, campo
         * VL_SLD_CRED_ANT_ST, com total de devolução por ST, campo VL_DEVOL_ST, com total de
         * ressarcimento por ST, campo VL_RESSARC_ST, com o total de outros créditos por ST, campo
         * VL_OUT_CRED_ST, com o total de ajustes de crédito por ST, campo VL_AJ_CREDITOS_ST. Se o
         * valor da expressão for maior ou igual a “0” (zero), então este valor deve ser informado
         * neste campo. Se o valor da expressão for menor que “0” (zero), então este campo deve ser
         * preenchido com “0” (zero).
         */
        $somatorio = $this->values->vl_retencao_st
                    + $this->values->vl_out_deb_st
                    + $this->values->vl_aj_debitos_st
                    - $this->values->vl_sld_cred_ant_st
                    - $this->values->vl_devol_st
                    - $this->values->vl_ressarc_st
                    - $this->values->vl_out_cred_st
                    - $this->values->vl_aj_creditos_st;

        if (($somatorio >= 0 && $this->values->vl_sld_dev_ant_st == 0)
        || ($somatorio < 0 && $this->values->vl_sld_dev_ant_st != 0)) {
            $this->errors[] = "[" . self::REG . "] O valor informado deve ser preenchido com base na "
            . "expressão: soma do total de retenção por ST, campo VL_RETENCAO_ST, com total de outros "
            . "débitos por ST, campo VL_OUT_DEB_ST, com total de ajustes de débito por ST, campo "
            . "VL_AJ_DEBITOS_ST, menos a soma do saldo credor do período anterior por ST, campo "
            . "VL_SLD_CRED_ANT_ST, com total de devolução por ST, campo VL_DEVOL_ST, com total de "
            . "ressarcimento por ST, campo VL_RESSARC_ST, com o total de outros créditos por ST, campo "
            . "VL_OUT_CRED_ST, com o total de ajustes de crédito por ST, campo VL_AJ_CREDITOS_ST. Se o "
            . "valor da expressão for maior ou igual a “0” (zero), então este valor deve ser informado "
            . "neste campo. Se o valor da expressão for menor que “0” (zero), então este campo deve ser "
            . "preenchido com “0” (zero).";
        }

        /*
         * Campo 13 (VL_ICMS_RECOL_ST) Validação: o valor informado deve corresponder à diferença entre
         * o campo VL_SLD_DEV_ANT_ST e o campo VL_DEDUCOES_ST.
         */
        $diferenca = $this->values->vl_sld_dev_ant_st - $this->values->vl_deducoes_st;
        if (number_format($this->values->vl_icms_recol_st, 2, ',', '') != number_format($diferenca, 2, ',', '')) {
            $this->errors[] = "[" . self::REG . "] O valor informado no campo VL_ICMS_RECOL_ST deve "
            . "corresponder à diferença entre o campo VL_SLD_DEV_ANT_ST e o campo VL_DEDUCOES_ST.";
        }

        /*
         * Campo 14 (VL_SLD_CRED_ST_TRANSPORTAR) Validação: se o valor da expressão: soma do total de retenção
         * por ST, campo VL_RETENCAO_ST, com total de outros débitos por ST, campo VL_OUT_DEB_ST, com total de
         * ajustes de débito por ST, campo VL_AJ_DEBITOS_ST, menos a soma do saldo credor do período anterior
         * por ST, campo VL_SLD_CRED_ANT_ST, com total de devolução por ST, campo VL_DEVOL_ST, com total de
         * ressarcimento por ST, campo VL_RESSARC_ST, com o total de outros créditos por ST, campo VL_OUT_CRED_ST,
         * com o total de ajustes de crédito por ST, campo VL_AJ_CREDITOS_ST, com o total dos ajustes de deduções
         * ST, campo VL_DEDUÇÕES_ST, for maior ou igual a “0” (zero), este campo deve ser preenchido com “0” (zero).
         * Se for menor que “0” (zero), o valor absoluto do resultado deve ser informado.
         */
        $somatorio = $this->values->vl_retencao_st
                    + $this->values->vl_out_deb_st
                    + $this->values->vl_aj_debitos_st
                    - $this->values->vl_sld_cred_ant_st
                    - $this->values->vl_devol_st
                    - $this->values->vl_ressarc_st
                    - $this->values->vl_out_cred_st
                    - $this->values->vl_aj_creditos_st
                    - $this->values->vl_deducoes_st;

        if (($somatorio >= 0 && $this->values->vl_sld_cred_st_transportar != 0)
        || ($somatorio < 0 && $this->values->vl_sld_cred_st_transportar == 0)) {
            $this->errors[] = "[" . self::REG . "] Se o valor da expressão: soma do total "
            . "de retenção por ST, campo VL_RETENCAO_ST, com total de outros débitos por ST, campo VL_OUT_DEB_ST, "
            . "com total de ajustes de débito por ST, campo VL_AJ_DEBITOS_ST, menos a soma do saldo credor do "
            . "período anterior por ST, campo VL_SLD_CRED_ANT_ST, com total de devolução por ST, campo VL_DEVOL_ST, "
            . "com total de ressarcimento por ST, campo VL_RESSARC_ST, com o total de outros créditos por ST, "
            . "campo VL_OUT_CRED_ST, com o total de ajustes de crédito por ST, campo VL_AJ_CREDITOS_ST, com o "
            . "total dos ajustes de deduções ST, campo VL_DEDUÇÕES_ST, for maior ou igual a “0” (zero), este "
            . "campo deve ser preenchido com “0” (zero). Se for menor que “0” (zero), o valor absoluto do "
            . "resultado deve ser informado.";
        }
    }
}
