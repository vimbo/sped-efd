<?php

namespace NFePHP\EFD\Elements\ICMSIPI;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

class C590 extends Element implements ElementInterface
{
    const REG = 'C590';
    const LEVEL = 3;
    const PARENT = 'C500';

    protected $parameters = [
        'CST_ICMS' => [
            'type' => 'numeric',
            'regex' => '^(\d{3})$',
            'required' => true,
            'info' => 'Código da Situação Tributária, conforme a Tabela indicada no item 4.3.1.',
            'format' => ''
        ],
        'CFOP' => [
            'type' => 'numeric',
            'regex' => '^(\d{4})$',
            'required' => true,
            'info' => 'Código Fiscal de agrupamento de itens',
            'format' => ''
        ],
        'ALIQ_ICMS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Alíquota do ICMS',
            'format' => '6v2'
        ],
        'VL_OPR' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info' => 'Valor da operação correspondente à combinação de CST_ICMS, CFOP, e alíquota do ICMS.',
            'format' => '15v2'
        ],
        'VL_BC_ICMS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Parcela correspondente ao "Valor da base de cálculo do ICMS"
            referente à combinação de CST_ICMS, CFOP e alíquota do ICMS.',
            'format' => '15v2'
        ],
        'VL_ICMS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Parcela correspondente ao "Valor do ICMS" referente à combinação
            de CST_ICMS, CFOP e alíquota do ICMS.',
            'format' => '15v2'
        ],
        'VL_BC_ICMS_ST' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Parcela correspondente ao "Valor da base de cálculo do ICMS" da substituição
            tributária referente à combinação de CST_ICMS, CFOP e alíquota do ICMS.',
            'format' => '15v2'
        ],
        'VL_ICMS_ST'  => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Parcela correspondente ao valor creditado/debitado do ICMS '
            . 'da substituição tributária, referente à combinação de CST_ICMS, '
            . 'CFOP, e alíquota do ICMS',
            'format' => '15v2'
        ],
        'VL_RED_BC' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor não tributado em função da redução da base de cálculo do ICMS,
            referente à combinação de CST_ICMS, CFOP e alíquota do ICMS.',
            'format' => '15v2'
        ],
        'COD_OBS' => [
            'type' => 'string',
            'regex' => '^.{0,6}$',
            'required' => false,
            'info' => 'Código da observação do lançamento fiscal (campo 02 do Registro 0460)',
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
    }

    public function postValidation()
    {
        //pega o fim da string do CST_ICMS e faz a verificacao
        $cstIcmsLast = (int) substr($this->std-> cst_icms, -2);
        if (in_array($cstIcmsLast, [30, 40, 41, 50, 60])) {
            if ($this->values->vl_bc_icms != 0) {
                $this->errors[] = "[" . self::REG . "] "
                    . " O do campo VL_BC_ICMS deve ser Igual 0";
            }
            if ($this->values->aliq_icms != 0) {
                $this->errors[] = "[" . self::REG . "] "
                    . " O do campo VL_ICMS deve ser Igual 0";
            }
            if ($this->values->vl_icms != 0) {
                $this->errors[] = "[" . self::REG . "] "
                    . " O do campo ALIQ_ICMS deve ser Igual 0";
            }
        } elseif (!in_array($cstIcmsLast, [51, 90])) {
            if ($this->values->vl_bc_icms <= 0) {
                $this->errors[] = "[" . self::REG . "] "
                    . " O do campo VL_BC_ICMS deve ser maior do que 0";
            }
            if ($this->values->aliq_icms <= 0) {
                $this->errors[] = "[" . self::REG . "] "
                    . " O do campo ALIQ_ICMS deve ser maior do que 0";
            }
            if ($this->values->vl_icms <= 0) {
                $this->errors[] = "[" . self::REG . "] "
                    . " O do campo VL_ICMS deve ser maior do que 0";
            }
        }
    }
}
