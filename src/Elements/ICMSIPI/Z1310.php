<?php

namespace NFePHP\EFD\Elements\ICMSIPI;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

class Z1310 extends Element implements ElementInterface
{
    const REG = '1310';
    const LEVEL = 3;
    const PARENT = '1300';

    protected $parameters = [
        'NUM_TANQUE' => [
            'type'     => 'string',
            'regex'    => '^.{1,3}$',
            'required' => true,
            'info'     => 'Tanque que armazena o combustível.',
            'format'   => ''
        ],
        'ESTQ_ABERT' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Estoque no inicio do dia, em litros',
            'format'   => '15v3'
        ],
        'VOL_ENTR' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Volume Recebido no dia (em litros)',
            'format'   => '15v3'
        ],
        'VOL_DISP' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Volume Disponível (03 + 04), em litros',
            'format'   => '15v3'
        ],
        'VOL_SAIDAS' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Volume Total das Saídas, em litros',
            'format'   => '15v3'
        ],
        'ESTQ_ESCR' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Estoque Escritural(05 – 06), litros',
            'format'   => '15v3'
        ],
        'VAL_AJ_PERDA' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor da Perda, em litros',
            'format'   => '15v3'
        ],
        'VAL_AJ_GANHO' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor do ganho, em litros',
            'format'   => '15v3'
        ],
        'FECH_FISICO' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Volume aferido no tanque, em litros. Estoque de fechamento físico do tanque.',
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
        $this->postValidation();
    }

    public function postValidation()
    {
        /*
         * Campo 05 (VOL_DISP) Preenchimento: informar o volume disponível, que corresponde
         * à soma dos campos ESTQ_ABERT e VOL_ENTR, para o tanque especificado no campo NUM_TANQUE.
         */
        $somatorio = $this->values->estq_abert + $this->values->vol_entr;
        if ($this->values->vol_disp != $somatorio) {
            $this->errors[] = "[" . self::REG . "] Informar o volume disponível, "
            . "que corresponde à soma dos campos ESTQ_ABERT e VOL_ENTR, para o tanque especificado "
            . "no campo NUM_TANQUE";
        }

        /*
         * Campo 07 (ESTQ_ESCR) Preenchimento: informar o estoque escritural, que corresponde ao valor
         * constante no campo VOL_DISP menos o valor constante no campo VOL_SAIDAS, para o tanque
         * especificado no campo NUM_TANQUE.
         */
        $diferenca = $this->values->vol_disp - $this->values->vol_saidas;
        if ($this->values->estq_escr != $diferenca) {
            $this->errors[] = "[" . self::REG . "] Informar o estoque escritural, "
            . "que corresponde ao valor constante no campo VOL_DISP menos o valor constante no campo "
            . "VOL_SAIDAS, para o tanque especificado no campo NUM_TANQUE.";
        }
    }
}
