<?php

namespace NFePHP\EFD\Elements\Contribuicoes;

use NFePHP\Common\Keys;
use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

class C100 extends Element implements ElementInterface
{
    const REG = 'C100';
    const LEVEL = 3;
    const PARENT = 'C001';

    protected $parameters = [
        'IND_OPER' => [
            'type' => 'string',
            'regex' => '^(0|1)$',
            'required' => false,
            'info' => 'Indicador do tipo de operação: 0- Entrada; 1- Saída',
            'format' => ''
        ],
        'IND_EMIT' => [
            'type' => 'string',
            'regex' => '^(0|1)$',
            'required' => false,
            'info' => 'Indicador do emitente do documento fiscal: 0- Emissão própria; 1- Terceiros',
            'format' => ''
        ],
        'COD_PART' => [
            'type' => 'string',
            'regex' => '^.{0,60}$',
            'required' => false,
            'info' => 'Código do participante (campo 02 do Registro 0150): - do emitente do documento ou
            do remetente das mercadorias, no caso de entradas; - do adquirente, no caso de saídas',
            'format' => ''
        ],
        'COD_MOD' => [
            'type' => 'string',
            'regex' => '^.{2}$',
            'required' => false,
            'info' => 'Código do modelo do documento fiscal, conforme a Tabela 4.1.1',
            'format' => ''
        ],
        'COD_SIT' => [
            'type' => 'numeric',
            'regex' => '^(00|01|02|03|04|05|06|07|08)$',
            'required' => false,
            'info' => 'Código da situação do documento fiscal, conforme a Tabela 4.1.2',
            'format' => ''
        ],
        'SER' => [
            'type' => 'string',
            'regex' => '^.{0,3}$',
            'required' => false,
            'info' => 'Série do documento fiscal',
            'format' => ''
        ],
        'NUM_DOC' => [
            'type' => 'numeric',
            'regex' => '^([1-9]{1})(\d{0,8})?$',
            'required' => false,
            'info' => 'Número do documento fiscal',
            'format' => ''
        ],
        'CHV_NFE' => [
            'type' => 'numeric',
            'regex' => '^([0-9]{44})?$',
            'required' => false,
            'info' => 'Chave da Nota Fiscal Eletrônica ou da NFC-e',
            'format' => ''
        ],
        'DT_DOC' => [
            'type' => 'string',
            'regex' => '^(0[1-9]|[1-2][0-9]|31(?!(?:0[2469]|11))|30(?!02))(0[1-9]|1[0-2])([12]\d{3})$',
            'required' => false,
            'info' => 'Data da emissão do documento fiscal',
            'format' => ''
        ],
        'DT_E_S' => [
            'type' => 'string',
            'regex' => '^(0[1-9]|[1-2][0-9]|31(?!(?:0[2469]|11))|30(?!02))(0[1-9]|1[0-2])([12]\d{3})$',
            'required' => false,
            'info' => 'Data da entrada ou da saída',
            'format' => ''
        ],
        'VL_DOC' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor total do documento fiscal',
            'format' => '15v2'
        ],
        'IND_PGTO' => [
            'type' => 'string',
            'regex' => '^(0|1|2|9)$',
            'required' => false,
            'info' => 'Indicador do tipo de pagamento: 0- À vista; 1- A prazo; 9- Sem pagamento.',
            'format' => ''
        ],
        'VL_DESC' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor total do desconto',
            'format' => '15v2'
        ],
        'VL_ABAT_NT' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Abatimento não tributado e não comercial Ex. desconto ICMS nas remessas para ZFM.',
            'format' => '15v2'
        ],
        'VL_MERC' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor total das mercadorias e serviços',
            'format' => '15v2'
        ],
        'IND_FRT' => [
            'type' => 'string',
            'regex' => '^(0|1|2|3|4|9)$',
            'required' => false,
            'info' => 'Indicador do tipo do frete:
            0- Por conta de terceiros;
            1- Por conta do emitente;
            2- Por conta do destinatário;
            9- Sem cobrança de frete.',
            'format' => ''
        ],
        'VL_FRT' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor do frete indicado no documento fiscal',
            'format' => '15v2'
        ],
        'VL_SEG' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor do seguro indicado no documento fiscal',
            'format' => '15v2'
        ],
        'VL_OUT_DA' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor de outras despesas acessórias',
            'format' => '15v2'
        ],
        'VL_BC_ICMS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da base de cálculo do ICMS',
            'format' => '15v2'
        ],
        'VL_ICMS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor do ICMS',
            'format' => '15v2'
        ],
        'VL_BC_ICMS_ST' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da base de cálculo do ICMS substituição tributária',
            'format' => '15v2'
        ],
        'VL_ICMS_ST' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor do ICMS retido por substituição tributária',
            'format' => '15v2'
        ],
        'VL_IPI' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor total do IPI',
            'format' => '15v2'
        ],
        'VL_PIS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor total do PIS',
            'format' => '15v2'
        ],
        'VL_COFINS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor total da COFINS',
            'format' => '15v2'
        ],
        'VL_PIS_ST' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor total do PIS retido por substituição tributária',
            'format' => '15v2'
        ],
        'VL_COFINS_ST' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor total da COFINS retido por substituição tributária',
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
        if (!empty($this->std->chv_nfe) and !Keys::isValid($this->std->chv_nfe)) {
            $this->errors[] = "[" . self::REG . "] " .
                " Dígito verificador incorreto no campo campo chave da " .
                "nota fiscal eletronica (CHV_NFE)";
        }
    }
}
