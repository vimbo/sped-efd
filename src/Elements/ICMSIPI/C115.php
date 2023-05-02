<?php

namespace NFePHP\EFD\Elements\ICMSIPI;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

class C115 extends Element implements ElementInterface
{
    const REG = 'C115';
    const LEVEL = 4;
    const PARENT = 'C110';

    protected $parameters = [
        'IND_CARGA' => [
            'type' => 'numeric',
            'regex' => '^(0|1|2|3|4|5|9)+$',
            'required' => true,
            'info' => 'Indicador do tipo de transporte',
            'format' => ''
        ],
        'CNPJ_COL' => [
            'type' => 'string',
            'regex' => '^[0-9]{14}$',
            'required' => false,
            'info' => 'Número do CNPJ do contribuinte do local de coleta',
            'format' => ''
        ],
        'IE_COL' => [
            'type' => 'string',
            'regex' => '^[0-9]{2,14}$',
            'required' => false,
            'info' => 'Inscrição Estadual do contribuinte do local de coleta',
            'format' => ''
        ],
        'CPF_COL' => [
            'type' => 'string',
            'regex' => '^[0-9]{11}$',
            'required' => true,
            'info' => 'CPF do contribuinte do local de coleta das mercadorias',
            'format' => ''
        ],
        'COD_MUN_COL' => [
            'type' => 'numeric',
            'regex' => '^([0-9]{7})$',
            'required' => true,
            'info' => 'Código do Município do local de coleta',
            'format' => ''
        ],
        'CNPJ_ENTG' => [
            'type' => 'string',
            'regex' => '^[0-9]{14}$',
            'required' => false,
            'info' => 'Número do CNPJ do contribuinte do local de entrega',
            'format' => ''
        ],
        'IE_ENTG' => [
            'type' => 'string',
            'regex' => '^[0-9]{2,14}$',
            'required' => false,
            'info' => 'Inscrição Estadual do contribuinte do local de entrega',
            'format' => ''
        ],
        'CPF_ENTG' => [
            'type' => 'string',
            'regex' => '^[0-9]{11}$',
            'required' => true,
            'info' => 'Cpf do contribuinte do local de entrega',
            'format' => ''
        ],
        'COD_MUN_ENTG' => [
            'type' => 'numeric',
            'regex' => '^([0-9]{7})$',
            'required' => true,
            'info' => 'Código do Município do local de entrega',
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


    /**
     * Aqui são colocadas validações adicionais que requerem mais logica
     * e processamento
     * Deve ser usado apenas quando necessário
     * @throws \InvalidArgumentException
     */
    public function postValidation()
    {
        if (!$this->std->cnpj_entg xor $this->std->cpf_entg) {
            $this->errors[] = "[" . self::REG . "] " .
                "Deve ser informado apenas o CNPJ (CNPJ_ENTG) ou o CPF (CPF_ENTG)";
        }
    }
}
