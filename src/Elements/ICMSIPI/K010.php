<?php

namespace NFePHP\EFD\Elements\ICMSIPI;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

/**
 * REGISTRO K010: INFORMAÇÃO SOBRE O TIPO DE LEIAUTE (SIMPLIFICADO/COMPLETO)
 * Este registro deve ser gerado, indicando o tipo de layout informado
 */
class K010 extends Element implements ElementInterface
{
    const REG = 'K010';
    const LEVEL = 1;
    const PARENT = '';

    protected $parameters = [
        'ind_tp_leiaute' => [
            'type'     => 'numeric',
            'regex'    => '^[0-2]{1}$',
            'required' => true,
            'info'     => 'Indicador de tipo de leiaute adotado: 0-Leiaute simplificado, '
                . '1-Leiaute completo, 2-Leiaute restrito aos saldos de estoque',
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
    }
}
