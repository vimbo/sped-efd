<?php

namespace NFePHP\EFD\Elements\ICMSIPI;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

class E520 extends Element implements ElementInterface
{
    const REG = 'E520';
    const LEVEL = 3;
    const PARENT = 'E500';

    protected $parameters = [
        'VL_SD_ANT_IPI' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Saldo credor do IPI transferido do período anterior',
            'format'   => '15v2'
        ],
        'VL_DEB_IPI' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor total dos débitos por "Saídas com débito do imposto"',
            'format'   => '15v2'
        ],
        'VL_CRED_IPI' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor total dos créditos por "Entradas e aquisições com crédito do imposto"',
            'format'   => '15v2'
        ],
        'VL_OD_IPI' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor de "Outros débitos" do IPI (inclusive estornos de crédito)',
            'format'   => '15v2'
        ],
        'VL_OC_IPI' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor de "Outros créditos" do IPI (inclusive estornos de débitos)',
            'format'   => '15v2'
        ],
        'VL_SC_IPI' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor do saldo credor do IPI a transportar para o período seguinte',
            'format'   => '15v2'
        ],
        'VL_SD_IPI' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor do saldo devedor do IPI a recolher',
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
        $this->postValidation();
    }

    public function postValidation()
    {
        /*
         * Campo 07 (VL_SC_IPI) Validação: Se a soma dos campos VL_DEB_IPI e VL_OD_IPI menos a soma dos campos
         * VL_SD_ANT_IPI, VL_CRED_IPI e VL_OC_IPI for menor que “0” (zero), então o campo VL_SC_IPI deve ser
         * igual ao valor absoluto da expressão, e o valor do campo VL_SD_IPI deve ser igual a “0” (zero).
         */
        $somatorio = $this->values->vl_deb_ipi
                    + $this->values->vl_od_ipi
                    - $this->values->vl_sd_ant_ipi
                    - $this->values->vl_cred_ipi
                    - $this->values->vl_oc_ipi;
        if ($somatorio < 0 && $this->values->vl_sc_ipi == 0 && $this->values->vl_sd_ipi != 0) {
            $this->errors[] = "[" . self::REG . "] Se a soma dos campos VL_DEB_IPI e VL_OD_IPI "
            . "menos a soma dos campos VL_SD_ANT_IPI, VL_CRED_IPI e VL_OC_IPI for menor que “0” (zero), então o campo "
            . "VL_SC_IPI deve ser igual ao valor absoluto da expressão, e o valor do campo VL_SD_IPI deve ser igual a "
            . "“0” (zero).";
        }

        /*
         * Campo 08 (VL_SD_IPI) Validação: Se a soma dos campos VL_DEB_IPI e VL_OD_IPI menos a soma dos campos
         * VL_SD_ANT_IPI, VL_CRED_IPI e VL_OC_IPI for maior ou igual a “0” (zero), então o campo 08 (VL_SD_IPI)
         * deve ser igual ao resultado da expressão, e o valor do campo VL_SC_IPI deve ser igual a “0” (zero).
         */
        $somatorio = $this->values->vl_deb_ipi
                    + $this->values->vl_od_ipi
                    - $this->values->vl_sd_ant_ipi
                    - $this->values->vl_cred_ipi
                    - $this->values->vl_oc_ipi;
        if ($somatorio >= 0 && $this->values->vl_sd_ipi != $somatorio && $this->values->vl_sc_ipi != 0) {
            $this->errors[] = "[" . self::REG . "] Se a soma dos campos VL_DEB_IPI e VL_OD_IPI "
            . "menos a soma dos campos VL_SD_ANT_IPI, VL_CRED_IPI e VL_OC_IPI for maior ou igual a “0” (zero), então "
            . "o campo 08 (VL_SD_IPI) deve ser igual ao resultado da expressão, e o valor do campo VL_SC_IPI deve ser "
            . "igual a “0” (zero).";
        }
    }
}
