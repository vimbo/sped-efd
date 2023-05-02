<?php

namespace NFePHP\EFD\Elements\ICMSIPI;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

class B350 extends Element implements ElementInterface
{
    const REG = 'B350';
    const LEVEL = 2;
    const PARENT = 'B001';

    protected $parameters = [
        'COD_CTD' => [
            'type'     => 'string',
            'regex'    => '^.*$',
            'required' => true,
            'info'     => 'Código da conta do plano de contas',
            'format'   => ''
        ],
        'CTA_ISS' => [
            'type'     => 'string',
            'regex'    => '^.*$',
            'required' => true,
            'info'     => 'Descrição da conta no plano de contas',
            'format'   => ''
        ],
        'CTA_COSIF' => [
            'type'     => 'integer',
            'regex'    => '^\d{8}$',
            'required' => true,
            'info'     => 'Código COSIF a que está subordinada a conta do ISS das instituições financeiras',
            'format'   => ''
        ],
        'QTD_OCOR' => [
            'type'     => 'integer',
            'regex'    => '^\d+$',
            'required' => true,
            'info'     => 'Quantidade de ocorrências na conta',
            'format'   => ''
        ],
        'COD_SERV' => [
            'type'     => 'integer',
            'regex'    => '^\d{4}$',
            'required' => true,
            'info'     => 'Item da lista de serviços, conforme Tabela 4.6.3.',
            'format'   => ''
        ],
        'VL_CONT' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor contábil',
            'format'   => '15v2'
        ],
        'VL_BC_ISS' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor da base de cálculo do ISS',
            'format'   => '15v2'
        ],
        'ALIQ_ISS' => [
            'type'     => 'integer',
            'regex'    => '^[0-5]{1}$',
            'required' => true,
            'info'     => 'Alíquota do ISS',
            'format'   => ''
        ],
        'VL_ISS' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor do ISS',
            'format'   => '15v2'
        ],
        'COD_INF_OBS' => [
            'type'     => 'string',
            'regex'    => '^.{1,60}$',
            'required' => false,
            'info'     => 'Código da observação do lançamento fiscal (campo 02 do Registro 0460)',
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
         * Campo 10 (VL_ISS) Validação: O valor deve ser igual ao produto da
         * base de cálculo “VL_BC_ISS” pela alíquota “ALIQ_ISS”
         */
        $vl_iss = ($this->values->vl_bc_iss/100) * $this->std->aliq_iss;
        $vl_iss = (float) number_format((float) $vl_iss, 2, '.', '');

        if ($this->values->vl_iss != $vl_iss) {
            $this->errors[] = "[" . self::REG . "] O valor deve ser igual ao produto "
            ."da base de cálculo “VL_BC_ISS” pela alíquota “ALIQ_ISS”";
        }
    }
}
