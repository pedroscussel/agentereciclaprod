<?php

class Venda extends TRecord
{
    const TABLENAME  = 'venda';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $vendedor;
    private $estado_venda;
    private $cliente;
    private $system_unit;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cliente_id');
        parent::addAttribute('vendedor_id');
        parent::addAttribute('estado_venda_id');
        parent::addAttribute('system_unit_id');
        parent::addAttribute('dt_venda');
        parent::addAttribute('obs');
        parent::addAttribute('frete');
        parent::addAttribute('valor_total');
            
    }

    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_vendedor(Pessoa $object)
    {
        $this->vendedor = $object;
        $this->vendedor_id = $object->id;
    }

    /**
     * Method get_vendedor
     * Sample of usage: $var->vendedor->attribute;
     * @returns Pessoa instance
     */
    public function get_vendedor()
    {
    
        // loads the associated object
        if (empty($this->vendedor))
            $this->vendedor = new Pessoa($this->vendedor_id);
    
        // returns the associated object
        return $this->vendedor;
    }
    /**
     * Method set_estado_venda
     * Sample of usage: $var->estado_venda = $object;
     * @param $object Instance of EstadoVenda
     */
    public function set_estado_venda(EstadoVenda $object)
    {
        $this->estado_venda = $object;
        $this->estado_venda_id = $object->id;
    }

    /**
     * Method get_estado_venda
     * Sample of usage: $var->estado_venda->attribute;
     * @returns EstadoVenda instance
     */
    public function get_estado_venda()
    {
    
        // loads the associated object
        if (empty($this->estado_venda))
            $this->estado_venda = new EstadoVenda($this->estado_venda_id);
    
        // returns the associated object
        return $this->estado_venda;
    }
    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_cliente(Pessoa $object)
    {
        $this->cliente = $object;
        $this->cliente_id = $object->id;
    }

    /**
     * Method get_cliente
     * Sample of usage: $var->cliente->attribute;
     * @returns Pessoa instance
     */
    public function get_cliente()
    {
    
        // loads the associated object
        if (empty($this->cliente))
            $this->cliente = new Pessoa($this->cliente_id);
    
        // returns the associated object
        return $this->cliente;
    }
    /**
     * Method set_system_unit
     * Sample of usage: $var->system_unit = $object;
     * @param $object Instance of SystemUnit
     */
    public function set_system_unit(SystemUnit $object)
    {
        $this->system_unit = $object;
        $this->system_unit_id = $object->id;
    }

    /**
     * Method get_system_unit
     * Sample of usage: $var->system_unit->attribute;
     * @returns SystemUnit instance
     */
    public function get_system_unit()
    {
        TTransaction::open('permission');
        // loads the associated object
        if (empty($this->system_unit))
            $this->system_unit = new SystemUnit($this->system_unit_id);
        TTransaction::close();
        // returns the associated object
        return $this->system_unit;
    }

    /**
     * Method getVendaItems
     */
    public function getVendaItems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('venda_id', '=', $this->id));
        return VendaItem::getObjects( $criteria );
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
    
        $values = VendaItem::where('venda_id', '=', $this->id)->getIndexedArray('produto_id','{produto->nome}');
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
    
        $values = VendaItem::where('venda_id', '=', $this->id)->getIndexedArray('venda_id','{venda->id}');
        return implode(', ', $values);
    }

    
}

