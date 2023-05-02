<?php

namespace NFePHP\EFD\Elements\ICMSIPI;

use NFePHP\EFD\Common\Element;
use NFePHP\EFD\Common\ElementInterface;
use \stdClass;

/**
 * Elemento 0150 do Bloco 0
 * REGISTRO 0150: TABELA DE CADASTRO DO PARTICIPANTE
 * Registro utilizado para informações cadastrais das pessoas físicas ou
 * jurídicas envolvidas nas transações comerciais com o estabelecimento,
 * no período. Participantes sem movimentação no período não devem ser
 * informados neste registro.
 * Obs.: Não  devem  ser  informados  como participantes  os CNPJ  e CPF apenas
 * citados  nos registros  C350 –  Nota Fiscal  de Venda  ao  Consumidor,
 * C460  –  Documento  Fiscal  emitido  por  ECF
 * e no  C100,  quando  se  tratar  de NFC-e -  Nota Fiscal Eletrônica ao
 * Consumidor Final - modelo 65.
 * O  código  a ser utilizado  é de livre  atribuição  pelo  contribuinte e
 * possui validade  para o  arquivo  informado.
 * Este código deve ser único para o participante, não havendo necessidade,
 * sempre que possível, de se criar um código para cada período.
 * Não podem ser informados dois ou mais registros com o mesmo Código de Participante.
 * Para o caso de participante pessoa física com mais de um endereço,
 * podem ser fornecidos mais de um registro, com o mesmo NOME e CPF.
 * Neste caso, deve ser usado um COD_PART para cada registro, alterando os demais dados.
 * As  informações  deste registro  representam  os  dados  atualizados  no  
 * último  evento  fiscal  (emissão/recebimento  de documento fiscal) da EFD-ICMS/IPI.
 *
 * NOTA: usada a letra Z no nome da Classe pois os nomes não podem ser exclusivamente
 * numeréricos e também para não confundir os com elementos do bloco B
 */
class Z0150 extends Element implements ElementInterface
{
    const REG = '0150';
    const LEVEL = 2;
    const PARENT = '0100';

    protected $parameters = [
        'COD_PART' => [
            'type'     => 'string',
            'regex'    => '^.{1,60}$',
            'required' => true,
            'info'     => 'Código de identificação do participante no arquivo.',
            'format'   => ''
        ],
        'NOME' => [
            'type'     => 'string',
            'regex'    => '^.{1,100}$',
            'required' => true,
            'info'     => 'Nome pessoal ou empresarial do participante.',
            'format'   => ''
        ],
        'COD_PAIS' => [
            'type'     => 'integer',
            'regex'    => '^[0-9]{4,5}$',
            'required' => true,
            'info'     => 'Código do país do participante, conforme a tabela '
            . 'indicada no item 3.2.1',
            'format'   => ''
        ],
        'CNPJ' => [
            'type'     => 'string',
            'regex'    => '^[0-9]{14}$',
            'required' => false,
            'info'     => 'CNPJ do participante.',
            'format'   => ''
        ],
        'CPF' => [
            'type'     => 'string',
            'regex'    => '^[0-9]{11}$',
            'required' => false,
            'info'     => 'CPF do participante.',
            'format'   => ''
        ],
        'IE' => [
            'type'     => 'string',
            'regex'    => '^[0-9]{2,14}$',
            'required' => false,
            'info'     => 'Inscrição Estadual do participante.',
            'format'   => ''
        ],
        'COD_MUN' => [
            'type'     => 'integer',
            'regex'    => '^[0-9]{7}$',
            'required' => false,
            'info'     => 'Código do município, conforme a tabela IBGE',
            'format'   => ''
        ],
        'SUFRAMA' => [
            'type'     => 'string',
            'regex'    => '^[0-9]{8,9}$',
            'required' => false,
            'info'     => 'Número de inscrição do participante na SUFRAMA.',
            'format'   => ''
        ],
        'END' => [
            'type'     => 'string',
            'regex'    => '^.{1,60}$',
            'required' => true,
            'info'     => 'Logradouro e endereço do imóvel',
            'format'   => ''
        ],
        'NUM' => [
            'type'     => 'string',
            'regex'    => '^.{1,10}$',
            'required' => false,
            'info'     => 'Número do imóvel',
            'format'   => ''
        ],
        'COMPL' => [
            'type'     => 'string',
            'regex'    => '^.{1,60}$',
            'required' => false,
            'info'     => 'Dados complementares do endereço',
            'format'   => ''
        ],
        'BAIRRO' => [
            'type'     => 'string',
            'regex'    => '^.{1,60}$',
            'required' => false,
            'info'     => 'Bairro em que o imóvel está situado',
            'format'   => ''
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
        if ($this->std->cod_pais == '1058' || $this->std->cod_pais == '01058') {
            if (!$this->std->cnpj xor $this->std->cpf) {
                $this->errors[] = "[" . self::REG . "] Deve ser informado apenas o CNPJ ou o CPF";
            }
        }
    }
}
