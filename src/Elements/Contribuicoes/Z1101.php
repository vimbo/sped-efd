<?php

namespace NFePHP\EFD\Elements\Contribuicoes;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;
use NFePHP\Common\Keys;

class Z1101 extends Element implements ElementInterface
{
    const REG = '1101';
    const LEVEL = 3;
    const PARENT = '1100';

    protected $parameters = [
        'COD_PART' => [
            'type' => 'string',
            'regex' => '^.{0,60}$',
            'required' => false,
            'info' => 'Código do participante (Campo 02 do Registro 0150) ',
            'format' => ''
        ],
        'COD_ITEM' => [
            'type' => 'string',
            'regex' => '^.{0,60}$',
            'required' => false,
            'info' => 'Código do item (campo 02 do Registro 0200) ',
            'format' => ''
        ],
        'COD_MOD' => [
            'type' => 'string',
            'regex' => '^.{2}$',
            'required' => false,
            'info' => 'Código do modelo do documento fiscal, conforme a Tabela 4.1.1. ',
            'format' => ''
        ],
        'SER' => [
            'type' => 'string',
            'regex' => '^.{0,4}$',
            'required' => false,
            'info' => 'Série do documento fiscal ',
            'format' => ''
        ],
        'SUB_SER' => [
            'type' => 'string',
            'regex' => '^.{0,3}$',
            'required' => false,
            'info' => 'Subsérie do documento fiscal ',
            'format' => ''
        ],
        'NUM_DOC' => [
            'type' => 'numeric',
            'regex' => '^(\d{0,9})$',
            'required' => false,
            'info' => 'Número do documento fiscal ',
            'format' => ''
        ],
        'DT_OPER' => [
            'type' => 'string',
            'regex' => '^(0[1-9]|[1-2][0-9]|31(?!(?:0[2469]|11))|30(?!02))(0[1-9]|1[0-2])([12]\d{3})$',
            'required' => false,
            'info' => 'Data da Operação (ddmmaaaa) ',
            'format' => ''
        ],
        'CHV_NFE' => [
            'type' => 'numeric',
            'regex' => '^([0-9]{44})?$',
            'required' => false,
            'info' => 'Chave da Nota Fiscal Eletrônica ',
            'format' => ''
        ],
        'VL_OPER' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor da Operação ',
            'format' => '15v2'
        ],
        'CFOP' => [
            'type' => 'numeric',
            'regex' => '^(\d{4})$',
            'required' => false,
            'info' => 'Código fiscal de operação e prestação ',
            'format' => ''
        ],
        'NAT_BC_CRED' => [
            'type' => 'string',
            'regex' => '^.{2}$',
            'required' => false,
            'info' => 'Código da Base de Cálculo do Crédito, conforme a Tabela indicada no item 4.3.7. ',
            'format' => ''
        ],
        'IND_ORIG_CRED' => [
            'type' => 'string',
            'regex' => '^(0|1)$',
            'required' => false,
            'info' => 'Indicador da origem do crédito ' .
                ' 0 – Operação no Mercado Interno 1 – Operação de Importação ',
            'format' => ''
        ],
        'CST_PIS' => [
            'type' => 'string',
            'regex' => '^((0[1-9])|49|99)$',
            'required' => false,
            'info' => 'Código da Situação Tributária referente ao PIS/PASEP, conforme a Tabela indicada no ' .
                'item 4.3.3. ',
            'format' => ''
        ],
        'VL_BC_PIS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Base de Cálculo do Crédito de PIS/PASEP (em valor ou em quantidade). ',
            'format' => '15v2'
        ],
        'ALIQ_PIS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Alíquota do PIS/PASEP (em percentual ou em reais). ',
            'format' => '15v4'
        ],
        'VL_PIS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor do Crédito de PIS/PASEP. ',
            'format' => '15v2'
        ],
        'COD_CTA' => [
            'type' => 'string',
            'regex' => '^.{0,255}$',
            'required' => false,
            'info' => 'Código da conta analítica contábil debitada/creditada. ',
            'format' => ''
        ],
        'COD_CCUS' => [
            'type' => 'string',
            'regex' => '^.{0,255}$',
            'required' => false,
            'info' => 'Código do Centro de Custos. ',
            'format' => ''
        ],
        'DESC_COMPL' => [
            'type' => 'string',
            'regex' => '^(.*)$',
            'required' => false,
            'info' => 'Descrição complementar do Documento/Operação. ',
            'format' => ''
        ],
        'PER_ESCRIT' => [
            'type' => 'numeric',
            'regex' => '^(\d{6})$',
            'required' => false,
            'info' => 'Mês/Ano da Escrituração em que foi registrado o documento/operação (Crédito pelo ' .
                'método da Apropriação Direta). ',
            'format' => ''
        ],
        'CNPJ' => [
            'type' => 'string',
            'regex' => '^[0-9]{14}$',
            'required' => false,
            'info' => 'CNPJ do estabelecimento gerador do crédito extemporâneo (Campo 04 do Registro 0140) ',
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
        if (!empty($this->std->chv_nfe) and !Keys::isValid($this->std->chv_nfe)) {
            $this->errors[] = "[" . self::REG . "] " .
                " Dígito verificador incorreto no campo chave do " .
                " campo CHV_NFE";
        }

        $multiplicacao = $this->values->vl_bc_pis * $this->values->aliq_pis;
        if (number_format($this->values->vl_pis, 2) != number_format($multiplicacao/100, 2)) {
            $this->errors[] = "[" . self::REG . "] " .
            "O campo VL_PIS deve de ser o calculo da multiplicacao " .
            "da base de calculo do PIS com a aliquota do PIS, o resultado dividido por 100";
        }
    }
}
