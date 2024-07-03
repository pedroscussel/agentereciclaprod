<?php

class Produto extends TRecord
{
    const TABLENAME  = 'produto';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $fornecedor;
    private $tipo_produto;
    private $unidade;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('unidade_id');
        parent::addAttribute('tipo_produto_id');
        parent::addAttribute('fornecedor_id');
        parent::addAttribute('nome');
        parent::addAttribute('dt_cadastro');
        parent::addAttribute('cod_barras');
        parent::addAttribute('preco_custo');
        parent::addAttribute('preco_venda');
        parent::addAttribute('peso_liquido');
        parent::addAttribute('peso_bruto');
        parent::addAttribute('estoque_minimo');
        parent::addAttribute('estoque_maximo');
        parent::addAttribute('qtde_estoque');
        parent::addAttribute('obs');
            
    }

    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_fornecedor(Pessoa $object)
    {
        $this->fornecedor = $object;
        $this->fornecedor_id = $object->id;
    }

    /**
     * Method get_fornecedor
     * Sample of usage: $var->fornecedor->attribute;
     * @returns Pessoa instance
     */
    public function get_fornecedor()
    {
    
        // loads the associated object
        if (empty($this->fornecedor))
            $this->fornecedor = new Pessoa($this->fornecedor_id);
    
        // returns the associated object
        return $this->fornecedor;
    }
    /**
     * Method set_tipo_produto
     * Sample of usage: $var->tipo_produto = $object;
     * @param $object Instance of TipoProduto
     */
    public function set_tipo_produto(TipoProduto $object)
    {
        $this->tipo_produto = $object;
        $this->tipo_produto_id = $object->id;
    }

    /**
     * Method get_tipo_produto
     * Sample of usage: $var->tipo_produto->attribute;
     * @returns TipoProduto instance
     */
    public function get_tipo_produto()
    {
    
        // loads the associated object
        if (empty($this->tipo_produto))
            $this->tipo_produto = new TipoProduto($this->tipo_produto_id);
    
        // returns the associated object
        return $this->tipo_produto;
    }
    /**
     * Method set_unidade
     * Sample of usage: $var->unidade = $object;
     * @param $object Instance of Unidade
     */
    public function set_unidade(Unidade $object)
    {
        $this->unidade = $object;
        $this->unidade_id = $object->id;
    }

    /**
     * Method get_unidade
     * Sample of usage: $var->unidade->attribute;
     * @returns Unidade instance
     */
    public function get_unidade()
    {
    
        // loads the associated object
        if (empty($this->unidade))
            $this->unidade = new Unidade($this->unidade_id);
    
        // returns the associated object
        return $this->unidade;
    }

    /**
     * Method getNegociacaoProdutos
     */
    public function getNegociacaoProdutos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('produto_id', '=', $this->id));
        return NegociacaoProduto::getObjects( $criteria );
    }
    /**
     * Method getOrcamentoItems
     */
    public function getOrcamentoItems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('produto_id', '=', $this->id));
        return OrcamentoItem::getObjects( $criteria );
    }
    /**
     * Method getVendaItems
     */
    public function getVendaItems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('produto_id', '=', $this->id));
        return VendaItem::getObjects( $criteria );
    }

    public function set_negociacao_produto_produto_to_string($negociacao_produto_produto_to_string)
    {
        if(is_array($negociacao_produto_produto_to_string))
        {
            $values = Produto::where('id', 'in', $negociacao_produto_produto_to_string)->getIndexedArray('nome', 'nome');
            $this->negociacao_produto_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_produto_produto_to_string = $negociacao_produto_produto_to_string;
        }

        $this->vdata['negociacao_produto_produto_to_string'] = $this->negociacao_produto_produto_to_string;
    }

    public function get_negociacao_produto_produto_to_string()
    {
        if(!empty($this->negociacao_produto_produto_to_string))
        {
            return $this->negociacao_produto_produto_to_string;
        }
    
        $values = NegociacaoProduto::where('produto_id', '=', $this->id)->getIndexedArray('produto_id','{produto->nome}');
        return implode(', ', $values);
    }

    public function set_negociacao_produto_negociacao_to_string($negociacao_produto_negociacao_to_string)
    {
        if(is_array($negociacao_produto_negociacao_to_string))
        {
            $values = Negociacao::where('id', 'in', $negociacao_produto_negociacao_to_string)->getIndexedArray('descricao', 'descricao');
            $this->negociacao_produto_negociacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->negociacao_produto_negociacao_to_string = $negociacao_produto_negociacao_to_string;
        }

        $this->vdata['negociacao_produto_negociacao_to_string'] = $this->negociacao_produto_negociacao_to_string;
    }

    public function get_negociacao_produto_negociacao_to_string()
    {
        if(!empty($this->negociacao_produto_negociacao_to_string))
        {
            return $this->negociacao_produto_negociacao_to_string;
        }
    
        $values = NegociacaoProduto::where('produto_id', '=', $this->id)->getIndexedArray('negociacao_id','{negociacao->descricao}');
        return implode(', ', $values);
    }

    public function set_orcamento_item_orcamento_to_string($orcamento_item_orcamento_to_string)
    {
        if(is_array($orcamento_item_orcamento_to_string))
        {
            $values = Orcamento::where('id', 'in', $orcamento_item_orcamento_to_string)->getIndexedArray('id', 'id');
            $this->orcamento_item_orcamento_to_string = implode(', ', $values);
        }
        else
        {
            $this->orcamento_item_orcamento_to_string = $orcamento_item_orcamento_to_string;
        }

        $this->vdata['orcamento_item_orcamento_to_string'] = $this->orcamento_item_orcamento_to_string;
    }

    public function get_orcamento_item_orcamento_to_string()
    {
        if(!empty($this->orcamento_item_orcamento_to_string))
        {
            return $this->orcamento_item_orcamento_to_string;
        }
    
        $values = OrcamentoItem::where('produto_id', '=', $this->id)->getIndexedArray('orcamento_id','{orcamento->id}');
        return implode(', ', $values);
    }

    public function set_orcamento_item_produto_to_string($orcamento_item_produto_to_string)
    {
        if(is_array($orcamento_item_produto_to_string))
        {
            $values = Produto::where('id', 'in', $orcamento_item_produto_to_string)->getIndexedArray('nome', 'nome');
            $this->orcamento_item_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->orcamento_item_produto_to_string = $orcamento_item_produto_to_string;
        }

        $this->vdata['orcamento_item_produto_to_string'] = $this->orcamento_item_produto_to_string;
    }

    public function get_orcamento_item_produto_to_string()
    {
        if(!empty($this->orcamento_item_produto_to_string))
        {
            return $this->orcamento_item_produto_to_string;
        }
    
        $values = OrcamentoItem::where('produto_id', '=', $this->id)->getIndexedArray('produto_id','{produto->nome}');
        return implode(', ', $values);
    }

    public function set_venda_item_produto_to_string($venda_item_produto_to_string)
    {
        if(is_array($venda_item_produto_to_string))
        {
            $values = Produto::where('id', 'in', $venda_item_produto_to_string)->getIndexedArray('nome', 'nome');
            $this->venda_item_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->venda_item_produto_to_string = $venda_item_produto_to_string;
        }

        $this->vdata['venda_item_produto_to_string'] = $this->venda_item_produto_to_string;
    }

    public function get_venda_item_produto_to_string()
    {
        if(!empty($this->venda_item_produto_to_string))
        {
            return $this->venda_item_produto_to_string;
        }
    
        $values = VendaItem::where('produto_id', '=', $this->id)->getIndexedArray('produto_id','{produto->nome}');
        return implode(', ', $values);
    }

    public function set_venda_item_venda_to_string($venda_item_venda_to_string)
    {
        if(is_array($venda_item_venda_to_string))
        {
            $values = Venda::where('id', 'in', $venda_item_venda_to_string)->getIndexedArray('id', 'id');
            $this->venda_item_venda_to_string = implode(', ', $values);
        }
        else
        {
            $this->venda_item_venda_to_string = $venda_item_venda_to_string;
        }

        $this->vdata['venda_item_venda_to_string'] = $this->venda_item_venda_to_string;
    }

    public function get_venda_item_venda_to_string()
    {
        if(!empty($this->venda_item_venda_to_string))
        {
            return $this->venda_item_venda_to_string;
        }
    
        $values = VendaItem::where('produto_id', '=', $this->id)->getIndexedArray('venda_id','{venda->id}');
        return implode(', ', $values);
    }

    
}

