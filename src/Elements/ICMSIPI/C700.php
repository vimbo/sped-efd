<?php

namespace NFePHP\EFD\Elements\ICMSIPI;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

class C700 extends Element implements ElementInterface
{
    const REG = 'C700';
    const LEVEL = 2;
    const PARENT = 'C001';

    protected $parameters = [
        'COD_MOD' => [
            'type' => 'string',
            'regex' => '^(06|28)$',
            'required' => true,
            'info' => 'Código do modelo do documento fiscal',
            'format' => ''
        ],
        'SER' => [
            'type' => 'string',
            'regex' => '^.{0,4}$',
            'required' => false,
            'info' => 'Série do documento fiscal',
            'format' => ''
        ],
        'NRO_ORD_INI' => [
            'type' => 'numeric',
            'regex' => '^[1-9]\d{0,8}$',
            'required' => true,
            'info' => 'Número de ordem inicial',
            'format' => ''
        ],
        'NRO_ORD_FIN' => [
            'type' => 'numeric',
            'regex' => '^(\d{1,9})$',
            'required' => true,
            'info' => 'Número de ordem final',
            'format' => ''
        ],
        'DT_DOC_INI' => [
            'type' => 'string',
            'regex' => '^(0[1-9]|[1-2][0-9]|31(?!(?:0[2469]|11))|30(?!02))(0[1-9]|1[0-2])([12]\d{3})$',
            'required' => true,
            'info' => 'Data de emissão inicial dos documentos / Data inicial de vencimento da fatura',
            'format' => ''
        ],
        'DT_DOC_FIN' => [
            'type' => 'string',
            'regex' => '^(0[1-9]|[1-2][0-9]|31(?!(?:0[2469]|11))|30(?!02))(0[1-9]|1[0-2])([12]\d{3})$',
            'required' => true,
            'info' => 'Data de emissão final dos documentos / Data final do vencimento da fatura',
            'format' => ''
        ],
        'NOM_MEST' => [
            'type' => 'string',
            'regex' => '^.{1,33}$',
            'required' => true,
            'info' => 'Nome do arquivo Mestre de Documento Fiscal',
            'format' => ''
        ],
        'CHV_COD_DIG' => [
            'type' => 'numeric',
            'regex' => '^(.{32})?$',
            'required' => true,
            'info' => 'Chave de codificação digital do arquivo Mestre de Documento Fiscal',
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

    public function postValidation()
    {
        if ($this->std->nro_ord_ini > $this->std->nro_ord_fin) {
            $this->errors[] = "[" . self::REG . "] "
                . " O do campo NRO_ORD_INI deve ser menor ou igual ao campo "
                . "NRO_ORD_FIN";
        }
    }
}
