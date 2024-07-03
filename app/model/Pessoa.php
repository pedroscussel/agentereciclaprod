<?php

class Pessoa extends TRecord
{
    const TABLENAME  = 'pessoa';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $cidade;
    private $system_user;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('system_user_id');
        parent::addAttribute('nome');
        parent::addAttribute('documento');
        parent::addAttribute('obs');
        parent::addAttribute('fone');
        parent::addAttribute('email');
        parent::addAttribute('cidade_id');
        parent::addAttribute('rua');
        parent::addAttribute('numero');
        parent::addAttribute('bairro');
        parent::addAttribute('complemento');
        parent::addAttribute('cep');
        parent::addAttribute('dt_ativacao');
        parent::addAttribute('dt_desativacao');
            
    }

    /**
     * Method set_cidade
     * Sample of usage: $var->cidade = $object;
     * @param $object Instance of Cidade
     */
    public function set_cidade(Cidade $object)
    {
        $this->cidade = $object;
        $this->cidade_id = $object->id;
    }

    /**
     * Method get_cidade
     * Sample of usage: $var->cidade->attribute;
     * @returns Cidade instance
     */
    public function get_cidade()
    {
    
        // loads the associated object
        if (empty($this->cidade))
            $this->cidade = new Cidade($this->cidade_id);
    
        // returns the associated object
        return $this->cidade;
    }
    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_system_user(SystemUsers $object)
    {
        $this->system_user = $object;
        $this->system_user_id = $object->id;
    }

    /**
     * Method get_system_user
     * Sample of usage: $var->system_user->attribute;
     * @returns SystemUsers instance
     */
    public function get_system_user()
    {
        TTransaction::open('permission');
        // loads the associated object
        if (empty($this->system_user))
            $this->system_user = new SystemUsers($this->system_user_id);
        TTransaction::close();
        // returns the associated object
        return $this->system_user;
    }

    /**
     * Method getContas
     */
    public function getContas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_id', '=', $this->id));
        return Conta::getObjects( $criteria );
    }
    /**
     * Method getContatos
     */
    public function getContatos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('pessoa_id', '=', $this->id));
        return Contato::getObjects( $criteria );
    }
    /**
     * Method getNegociacaos
     */
    public function getNegociacaosByVendedors()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('vendedor_id', '=', $this->id));
        return Negociacao::getObjects( $criteria );
    }
    /**
     * Method getNegociacaos
     */
    public function getNegociacaosByClientes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_id', '=', $this->id));
        return Negociacao::getObjects( $criteria );
    }
    /**
     * Method getOrcamentos
     */
    public function getOrcamentosByVendedors()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('vendedor_id', '=', $this->id));
        return Orcamento::getObjects( $criteria );
    }
    /**
     * Method getOrcamentos
     */
    public function getOrcamentosByClientes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_id', '=', $this->id));
        return Orcamento::getObjects( $criteria );
    }
    /**
     * Method getPessoaGrupos
     */
    public function getPessoaGrupos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('pessoa_id', '=', $this->id));
        return PessoaGrupo::getObjects( $criteria );
    }
    /**
     * Method getProdutos
     */
    public function getProdutos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('fornecedor_id', '=', $this->id));
        return Produto::getObjects( $criteria );
    }
    /**
     * Method getProspeccaos
     */
    public function getProspeccaosByVendedors()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('vendedor_id', '=', $this->id));
        return Prospeccao::getObjects( $criteria );
    }
    /**
     * Method getProspeccaos
     */
    public function getProspeccaosByClientes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_id', '=', $this->id));
        return Prospeccao::getObjects( $criteria );
    }
    /**
     * Method getVendas
     */
    public function getVendasByVendedors()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('vendedor_id', '=', $this->id));
        return Venda::getObjects( $criteria );
    }
    /**
     * Method getVendas
     */
    public function getVendasByClientes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_id', '=', $this->id));
        return Venda::getObjects( $criteria );
    }

    public function set_conta_tipo_conta_to_string($conta_tipo_conta_to_string)
    {
        if(is_array($conta_tipo_conta_to_string))
        {
            $values = TipoConta::where('id', 'in', $conta_tipo_conta_to_string)->getIndexedArray('nome', 'nome');
            $this->conta_tipo_conta_to_string = implode(', ', $values);
        }
        else
        {
            $this->conta_tipo_conta_to_string = $conta_tipo_conta_to_string;
        }

        $this->vdata['conta_tipo_conta_to_string'] = $this->conta_tipo_conta_to_string;
    }

    public function get_conta_tipo_conta_to_string()
    {
        if(!empty($this->conta_tipo_conta_to_string))
        {
            return $this->conta_tipo_conta_to_string;
        }
    
        $values = Conta::where('cliente_id', '=', $this->id)->getIndexedArray('tipo_conta_id','{tipo_conta->nome}');
        return implode(', ', $values);
    }

    public function set_conta_cliente_to_string($conta_cliente_to_string)
    {
        if(is_array($conta_cliente_to_string))
        {
            $values = Pessoa::where('id', 'in', $conta_cliente_to_string)->getIndexedArray('nome', 'nome');
            $this->conta_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->conta_cliente_to_string = $conta_cliente_to_string;
        }

        $this->vdata['conta_cliente_to_string'] = $this->conta_cliente_to_string;
    }

    public function get_conta_cliente_to_string()
    {
        if(!empty($this->conta_cliente_to_string))
        {
            return $this->conta_cliente_to_string;
        }
    
        $values = Conta::where('cliente_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
        return implode(', ', $values);
    }

    public function set_conta_natureza_to_string($conta_natureza_to_string)
    {
        if(is_array($conta_natureza_to_string))
        {
            $values = Natureza::where('id', 'in', $conta_natureza_to_string)->getIndexedArray('nome', 'nome');
            $this->conta_natureza_to_string = implode(', ', $values);
        }
        else
        {
            $this->conta_natureza_to_string = $conta_natureza_to_string;
        }

        $this->vdata['conta_natureza_to_string'] = $this->conta_natureza_to_string;
    }

    public function get_conta_natureza_to_string()
    {
        if(!empty($this->conta_natureza_to_string))
        {
            return $this->conta_natureza_to_string;
        }
    
        $values = Conta::where('cliente_id', '=', $this->id)->getIndexedArray('natureza_id','{natureza->nome}');
        return implode(', ', $values);
    }

    public function set_contato_pessoa_to_string($contato_pessoa_to_string)
    {
        if(is_array($contato_pessoa_to_string))
        {
            $values = Pessoa::where('id', 'in', $contato_pessoa_to_string)->getIndexedArray('nome', 'nome');
            $this->contato_pessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->contato_pessoa_to_string = $contato_pessoa_to_string;
        }

        $this->vdata['contato_pessoa_to_string'] = $this->contato_pessoa_to_string;
    }

    public function get_contato_pessoa_to_string()
    {
        if(!empty($this->contato_pessoa_to_string))
        {
            return $this->contato_pessoa_to_string;
        }
    
        $values = Contato::where('pessoa_id', '=', $this->id)->getIndexedArray('pessoa_id','{pessoa->nome}');
        return implode(', ', $values);
    }

    public function set_negociacao_cliente_to_string($negociacao_cliente_to_string)
    {
        if(is_array($negociacao_cliente_to_string))
        {
            $values = Pessoa::where('id', 'in', $negociacao_cliente_to_string)->getIndexedArray('nome', 'nome');
            $this->negociacao_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_cliente_to_string = $negociacao_cliente_to_string;
        }

        $this->vdata['negociacao_cliente_to_string'] = $this->negociacao_cliente_to_string;
    }

    public function get_negociacao_cliente_to_string()
    {
        if(!empty($this->negociacao_cliente_to_string))
        {
            return $this->negociacao_cliente_to_string;
        }
    
        $values = Negociacao::where('cliente_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
        return implode(', ', $values);
    }

    public function set_negociacao_vendedor_to_string($negociacao_vendedor_to_string)
    {
        if(is_array($negociacao_vendedor_to_string))
        {
            $values = Pessoa::where('id', 'in', $negociacao_vendedor_to_string)->getIndexedArray('nome', 'nome');
            $this->negociacao_vendedor_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_vendedor_to_string = $negociacao_vendedor_to_string;
        }

        $this->vdata['negociacao_vendedor_to_string'] = $this->negociacao_vendedor_to_string;
    }

    public function get_negociacao_vendedor_to_string()
    {
        if(!empty($this->negociacao_vendedor_to_string))
        {
            return $this->negociacao_vendedor_to_string;
        }
    
        $values = Negociacao::where('cliente_id', '=', $this->id)->getIndexedArray('vendedor_id','{vendedor->nome}');
        return implode(', ', $values);
    }

    public function set_negociacao_origem_negociacao_to_string($negociacao_origem_negociacao_to_string)
    {
        if(is_array($negociacao_origem_negociacao_to_string))
        {
            $values = OrigemNegociacao::where('id', 'in', $negociacao_origem_negociacao_to_string)->getIndexedArray('nome', 'nome');
            $this->negociacao_origem_negociacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_origem_negociacao_to_string = $negociacao_origem_negociacao_to_string;
        }

        $this->vdata['negociacao_origem_negociacao_to_string'] = $this->negociacao_origem_negociacao_to_string;
    }

    public function get_negociacao_origem_negociacao_to_string()
    {
        if(!empty($this->negociacao_origem_negociacao_to_string))
        {
            return $this->negociacao_origem_negociacao_to_string;
        }
    
        $values = Negociacao::where('cliente_id', '=', $this->id)->getIndexedArray('origem_negociacao_id','{origem_negociacao->nome}');
        return implode(', ', $values);
    }

    public function set_negociacao_tipo_negociacao_to_string($negociacao_tipo_negociacao_to_string)
    {
        if(is_array($negociacao_tipo_negociacao_to_string))
        {
            $values = TipoNegociacao::where('id', 'in', $negociacao_tipo_negociacao_to_string)->getIndexedArray('nome', 'nome');
            $this->negociacao_tipo_negociacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_tipo_negociacao_to_string = $negociacao_tipo_negociacao_to_string;
        }

        $this->vdata['negociacao_tipo_negociacao_to_string'] = $this->negociacao_tipo_negociacao_to_string;
    }

    public function get_negociacao_tipo_negociacao_to_string()
    {
        if(!empty($this->negociacao_tipo_negociacao_to_string))
        {
            return $this->negociacao_tipo_negociacao_to_string;
        }
    
        $values = Negociacao::where('cliente_id', '=', $this->id)->getIndexedArray('tipo_negociacao_id','{tipo_negociacao->nome}');
        return implode(', ', $values);
    }

    public function set_negociacao_estado_negociacao_to_string($negociacao_estado_negociacao_to_string)
    {
        if(is_array($negociacao_estado_negociacao_to_string))
        {
            $values = EstadoNegociacao::where('id', 'in', $negociacao_estado_negociacao_to_string)->getIndexedArray('nome', 'nome');
            $this->negociacao_estado_negociacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_estado_negociacao_to_string = $negociacao_estado_negociacao_to_string;
        }

        $this->vdata['negociacao_estado_negociacao_to_string'] = $this->negociacao_estado_negociacao_to_string;
    }

    public function get_negociacao_estado_negociacao_to_string()
    {
        if(!empty($this->negociacao_estado_negociacao_to_string))
        {
            return $this->negociacao_estado_negociacao_to_string;
        }
    
        $values = Negociacao::where('cliente_id', '=', $this->id)->getIndexedArray('estado_negociacao_id','{estado_negociacao->nome}');
        return implode(', ', $values);
    }

    public function set_orcamento_cliente_to_string($orcamento_cliente_to_string)
    {
        if(is_array($orcamento_cliente_to_string))
        {
            $values = Pessoa::where('id', 'in', $orcamento_cliente_to_string)->getIndexedArray('nome', 'nome');
            $this->orcamento_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->orcamento_cliente_to_string = $orcamento_cliente_to_string;
        }

        $this->vdata['orcamento_cliente_to_string'] = $this->orcamento_cliente_to_string;
    }

    public function get_orcamento_cliente_to_string()
    {
        if(!empty($this->orcamento_cliente_to_string))
        {
            return $this->orcamento_cliente_to_string;
        }
    
        $values = Orcamento::where('cliente_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
        return implode(', ', $values);
    }

    public function set_orcamento_vendedor_to_string($orcamento_vendedor_to_string)
    {
        if(is_array($orcamento_vendedor_to_string))
        {
            $values = Pessoa::where('id', 'in', $orcamento_vendedor_to_string)->getIndexedArray('nome', 'nome');
            $this->orcamento_vendedor_to_string = implode(', ', $values);
        }
        else
        {
            $this->orcamento_vendedor_to_string = $orcamento_vendedor_to_string;
        }

        $this->vdata['orcamento_vendedor_to_string'] = $this->orcamento_vendedor_to_string;
    }

    public function get_orcamento_vendedor_to_string()
    {
        if(!empty($this->orcamento_vendedor_to_string))
        {
            return $this->orcamento_vendedor_to_string;
        }
    
        $values = Orcamento::where('cliente_id', '=', $this->id)->getIndexedArray('vendedor_id','{vendedor->nome}');
        return implode(', ', $values);
    }

    public function set_orcamento_estado_orcamento_to_string($orcamento_estado_orcamento_to_string)
    {
        if(is_array($orcamento_estado_orcamento_to_string))
        {
            $values = EstadoOrcamento::where('id', 'in', $orcamento_estado_orcamento_to_string)->getIndexedArray('nome', 'nome');
            $this->orcamento_estado_orcamento_to_string = implode(', ', $values);
        }
        else
        {
            $this->orcamento_estado_orcamento_to_string = $orcamento_estado_orcamento_to_string;
        }

        $this->vdata['orcamento_estado_orcamento_to_string'] = $this->orcamento_estado_orcamento_to_string;
    }

    public function get_orcamento_estado_orcamento_to_string()
    {
        if(!empty($this->orcamento_estado_orcamento_to_string))
        {
            return $this->orcamento_estado_orcamento_to_string;
        }
    
        $values = Orcamento::where('cliente_id', '=', $this->id)->getIndexedArray('estado_orcamento_id','{estado_orcamento->nome}');
        return implode(', ', $values);
    }

    public function set_pessoa_grupo_grupo_to_string($pessoa_grupo_grupo_to_string)
    {
        if(is_array($pessoa_grupo_grupo_to_string))
        {
            $values = Grupo::where('id', 'in', $pessoa_grupo_grupo_to_string)->getIndexedArray('nome', 'nome');
            $this->pessoa_grupo_grupo_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoa_grupo_grupo_to_string = $pessoa_grupo_grupo_to_string;
        }

        $this->vdata['pessoa_grupo_grupo_to_string'] = $this->pessoa_grupo_grupo_to_string;
    }

    public function get_pessoa_grupo_grupo_to_string()
    {
        if(!empty($this->pessoa_grupo_grupo_to_string))
        {
            return $this->pessoa_grupo_grupo_to_string;
        }
    
        $values = PessoaGrupo::where('pessoa_id', '=', $this->id)->getIndexedArray('grupo_id','{grupo->nome}');
        return implode(', ', $values);
    }

    public function set_pessoa_grupo_pessoa_to_string($pessoa_grupo_pessoa_to_string)
    {
        if(is_array($pessoa_grupo_pessoa_to_string))
        {
            $values = Pessoa::where('id', 'in', $pessoa_grupo_pessoa_to_string)->getIndexedArray('nome', 'nome');
            $this->pessoa_grupo_pessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoa_grupo_pessoa_to_string = $pessoa_grupo_pessoa_to_string;
        }

        $this->vdata['pessoa_grupo_pessoa_to_string'] = $this->pessoa_grupo_pessoa_to_string;
    }

    public function get_pessoa_grupo_pessoa_to_string()
    {
        if(!empty($this->pessoa_grupo_pessoa_to_string))
        {
            return $this->pessoa_grupo_pessoa_to_string;
        }
    
        $values = PessoaGrupo::where('pessoa_id', '=', $this->id)->getIndexedArray('pessoa_id','{pessoa->nome}');
        return implode(', ', $values);
    }

    public function set_produto_unidade_to_string($produto_unidade_to_string)
    {
        if(is_array($produto_unidade_to_string))
        {
            $values = Unidade::where('id', 'in', $produto_unidade_to_string)->getIndexedArray('id', 'id');
            $this->produto_unidade_to_string = implode(', ', $values);
        }
        else
        {
            $this->produto_unidade_to_string = $produto_unidade_to_string;
        }

        $this->vdata['produto_unidade_to_string'] = $this->produto_unidade_to_string;
    }

    public function get_produto_unidade_to_string()
    {
        if(!empty($this->produto_unidade_to_string))
        {
            return $this->produto_unidade_to_string;
        }
    
        $values = Produto::where('fornecedor_id', '=', $this->id)->getIndexedArray('unidade_id','{unidade->id}');
        return implode(', ', $values);
    }

    public function set_produto_tipo_produto_to_string($produto_tipo_produto_to_string)
    {
        if(is_array($produto_tipo_produto_to_string))
        {
            $values = TipoProduto::where('id', 'in', $produto_tipo_produto_to_string)->getIndexedArray('nome', 'nome');
            $this->produto_tipo_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->produto_tipo_produto_to_string = $produto_tipo_produto_to_string;
        }

        $this->vdata['produto_tipo_produto_to_string'] = $this->produto_tipo_produto_to_string;
    }

    public function get_produto_tipo_produto_to_string()
    {
        if(!empty($this->produto_tipo_produto_to_string))
        {
            return $this->produto_tipo_produto_to_string;
        }
    
        $values = Produto::where('fornecedor_id', '=', $this->id)->getIndexedArray('tipo_produto_id','{tipo_produto->nome}');
        return implode(', ', $values);
    }

    public function set_produto_fornecedor_to_string($produto_fornecedor_to_string)
    {
        if(is_array($produto_fornecedor_to_string))
        {
            $values = Pessoa::where('id', 'in', $produto_fornecedor_to_string)->getIndexedArray('nome', 'nome');
            $this->produto_fornecedor_to_string = implode(', ', $values);
        }
        else
        {
            $this->produto_fornecedor_to_string = $produto_fornecedor_to_string;
        }

        $this->vdata['produto_fornecedor_to_string'] = $this->produto_fornecedor_to_string;
    }

    public function get_produto_fornecedor_to_string()
    {
        if(!empty($this->produto_fornecedor_to_string))
        {
            return $this->produto_fornecedor_to_string;
        }
    
        $values = Produto::where('fornecedor_id', '=', $this->id)->getIndexedArray('fornecedor_id','{fornecedor->nome}');
        return implode(', ', $values);
    }

    public function set_prospeccao_vendedor_to_string($prospeccao_vendedor_to_string)
    {
        if(is_array($prospeccao_vendedor_to_string))
        {
            $values = Pessoa::where('id', 'in', $prospeccao_vendedor_to_string)->getIndexedArray('nome', 'nome');
            $this->prospeccao_vendedor_to_string = implode(', ', $values);
        }
        else
        {
            $this->prospeccao_vendedor_to_string = $prospeccao_vendedor_to_string;
        }

        $this->vdata['prospeccao_vendedor_to_string'] = $this->prospeccao_vendedor_to_string;
    }

    public function get_prospeccao_vendedor_to_string()
    {
        if(!empty($this->prospeccao_vendedor_to_string))
        {
            return $this->prospeccao_vendedor_to_string;
        }
    
        $values = Prospeccao::where('cliente_id', '=', $this->id)->getIndexedArray('vendedor_id','{vendedor->nome}');
        return implode(', ', $values);
    }

    public function set_prospeccao_cliente_to_string($prospeccao_cliente_to_string)
    {
        if(is_array($prospeccao_cliente_to_string))
        {
            $values = Pessoa::where('id', 'in', $prospeccao_cliente_to_string)->getIndexedArray('nome', 'nome');
            $this->prospeccao_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->prospeccao_cliente_to_string = $prospeccao_cliente_to_string;
        }

        $this->vdata['prospeccao_cliente_to_string'] = $this->prospeccao_cliente_to_string;
    }

    public function get_prospeccao_cliente_to_string()
    {
        if(!empty($this->prospeccao_cliente_to_string))
        {
            return $this->prospeccao_cliente_to_string;
        }
    
        $values = Prospeccao::where('cliente_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
        return implode(', ', $values);
    }

    public function set_venda_cliente_to_string($venda_cliente_to_string)
    {
        if(is_array($venda_cliente_to_string))
        {
            $values = Pessoa::where('id', 'in', $venda_cliente_to_string)->getIndexedArray('nome', 'nome');
            $this->venda_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->venda_cliente_to_string = $venda_cliente_to_string;
        }

        $this->vdata['venda_cliente_to_string'] = $this->venda_cliente_to_string;
    }

    public function get_venda_cliente_to_string()
    {
        if(!empty($this->venda_cliente_to_string))
        {
            return $this->venda_cliente_to_string;
        }
    
        $values = Venda::where('cliente_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
        return implode(', ', $values);
    }

    public function set_venda_vendedor_to_string($venda_vendedor_to_string)
    {
        if(is_array($venda_vendedor_to_string))
        {
            $values = Pessoa::where('id', 'in', $venda_vendedor_to_string)->getIndexedArray('nome', 'nome');
            $this->venda_vendedor_to_string = implode(', ', $values);
        }
        else
        {
            $this->venda_vendedor_to_string = $venda_vendedor_to_string;
        }

        $this->vdata['venda_vendedor_to_string'] = $this->venda_vendedor_to_string;
    }

    public function get_venda_vendedor_to_string()
    {
        if(!empty($this->venda_vendedor_to_string))
        {
            return $this->venda_vendedor_to_string;
        }
    
        $values = Venda::where('cliente_id', '=', $this->id)->getIndexedArray('vendedor_id','{vendedor->nome}');
        return implode(', ', $values);
    }

    public function set_venda_estado_venda_to_string($venda_estado_venda_to_string)
    {
        if(is_array($venda_estado_venda_to_string))
        {
            $values = EstadoVenda::where('id', 'in', $venda_estado_venda_to_string)->getIndexedArray('nome', 'nome');
            $this->venda_estado_venda_to_string = implode(', ', $values);
        }
        else
        {
            $this->venda_estado_venda_to_string = $venda_estado_venda_to_string;
        }

        $this->vdata['venda_estado_venda_to_string'] = $this->venda_estado_venda_to_string;
    }

    public function get_venda_estado_venda_to_string()
    {
        if(!empty($this->venda_estado_venda_to_string))
        {
            return $this->venda_estado_venda_to_string;
        }
    
        $values = Venda::where('cliente_id', '=', $this->id)->getIndexedArray('estado_venda_id','{estado_venda->nome}');
        return implode(', ', $values);
    }

    
}

