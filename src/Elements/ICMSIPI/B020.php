<?php

namespace NFePHP\EFD\Elements\ICMSIPI;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

class B020 extends Element implements ElementInterface
{
    const REG = 'B020';
    const LEVEL = 2;
    const PARENT = 'B001';

    protected $parameters = [
        'IND_OPER' => [
            'type'     => 'string',
            'regex'    => '^[0|1]$',
            'required' => true,
            'info'     => 'Indicador do tipo de operação: '
            .'0- Aquisição; '
            .'1- Prestação',
            'format'   => ''
        ],
        'IND_EMIT' => [
            'type'     => 'string',
            'regex'    => '^[0|1]$',
            'required' => true,
            'info'     => 'Indicador do emitente do documento fiscal: '
            .'0- Emissão própria; '
            .'1- Terceiros',
            'format'   => ''
        ],
        'COD_PART' => [
            'type'     => 'string',
            'regex'    => '^.{1,60}$',
            'required' => true,
            'info'     => 'Código do participante (campo 02 do Registro 0150): '
            .'do prestador, no caso de declarante na condição de tomador; '
            .'do tomador, no caso de declarante na condição de prestador',
            'format'   => ''
        ],
        'COD_MOD' => [
            'type'     => 'string',
            'regex'    => '^.[01|03|3B|04|08|55|65]$',
            'required' => true,
            'info'     => 'Código do modelo do documento fiscal, conforme a Tabela 4.1.3',
            'format'   => ''
        ],
        'COD_SIT' => [
            'type'     => 'integer',
            'regex'    => '^.[00|01|02|03|04|05|06|07]$',
            'required' => true,
            'info'     => 'Código da situação do documento conforme tabela 4.1.2',
            'format'   => ''
        ],
        'SER' => [
            'type'     => 'string',
            'regex'    => '^.{1,3}$',
            'required' => false,
            'info'     => 'Série do documento fiscal',
            'format'   => ''
        ],
        'NUM_DOC' => [
            'type'     => 'integer',
            'regex'    => '^([1-9])([0-9]{1,8}|)$',
            'required' => true,
            'info'     => 'Número do documento fiscal',
            'format'   => ''
        ],
        'CHV_NFE' => [
            'type'     => 'numeric',
            'regex'    => '^([0-9]{44})?$',
            'required' => false,
            'info'     => 'Chave da Nota Fiscal Eletrônica',
            'format'   => ''
        ],
        'DT_DOC' => [
            'type'     => 'integer',
            'regex'    => '^(0[1-9]|[1-2][0-9]|31(?!(?:0[2469]|11))|30(?!02))(0[1-9]|1[0-2])([12]\d{3})$',
            'required' => true,
            'info'     => 'Data da emissão do documento fiscal',
            'format'   => ''
        ],
        'COD_MUN_SERV' => [
            'type'     => 'string',
            'regex'    => '^.{7}$',
            'required' => true,
            'info'     => 'Código do município onde o serviço foi prestado, conforme a tabela IBGE.',
            'format'   => ''
        ],
        'VL_CONT' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor contábil (valor total do documento)',
            'format'   => '15v2'
        ],
        'VL_MAT_TERC' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor do material fornecido por terceiros na prestação do serviço',
            'format'   => '15v2'
        ],
        'VL_SUB' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor da subempreitada',
            'format'   => '15v2'
        ],
        'VL_ISNT_ISS' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'V alor das operações isentas ou não- tributadas pelo ISS',
            'format'   => '15v2'
        ],
        'VL_DED_BC' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor da dedução da base de cálculo',
            'format'   => '15v2'
        ],
        'VL_BC_ISS' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor da base de cálculo do ISS',
            'format'   => '15v2'
        ],
        'VL_BC_ISS_RT' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor da base de cálculo de retenção do ISS',
            'format'   => '15v2'
        ],
        'VL_ISS_RT' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor do ISS retido pelo tomador',
            'format'   => '15v2'
        ],
        'VL_ISS' => [
            'type'     => 'numeric',
            'regex'    => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info'     => 'Valor do ISS destacado',
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
         * Campo 03 (IND_EMIT) Validação: se este campo tiver valor igual a “1” (um),
         * o campo IND_OPER deve ser igual a “0” (zero).
         */
        if ($this->std->ind_emit == '1' && $this->std->ind_oper != 0) {
            $this->errors[] = "[" . self::REG . "] Se o campo IND_EMIT tiver valor igual a “1” (um), "
            ."o campo IND_OPER deve ser igual a “0” (zero).";
        }

        /*
         * Campo 05 (COD_MOD) Preenchimento: O modelo “65” só pode ser informado no caso
         * de prestação de serviço, ou seja, campo “IND_OPER” preenchido com “1”.
         */
        if ($this->std->cod_mod == '65' && $this->std->ind_oper != '1') {
            $this->errors[] = "[" . self::REG . "] O modelo “65” só pode ser informado "
            ."no caso de prestação de serviço.";
        }

        /*
         * Campo 09 (CHV_NFE) Preenchimento: Este campo é de preenchimento obrigatório
         * para COD_MOD igual a “55” e “65”.
         */
        if (in_array($this->std->cod_mod, array('55', '65')) && empty($this->std->chv_nfe)) {
            $this->errors[] = "[" . self::REG . "] Este campo é de preenchimento obrigatório "
            ."para COD_MOD igual a “55” e “65”.";
        }
    }
}
