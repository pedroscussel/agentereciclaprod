<?php

class EstadoVenda extends TRecord
{
    const TABLENAME  = 'estado_venda';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const nova = '1';
    const finalizada = '2';
    const cancelada = '3';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
            
    }

    /**
     * Method getVendas
     */
    public function getVendas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('estado_venda_id', '=', $this->id));
        return Venda::getObjects( $criteria );
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
    
        $values = Venda::where('estado_venda_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
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
    
        $values = Venda::where('estado_venda_id', '=', $this->id)->getIndexedArray('vendedor_id','{vendedor->nome}');
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
    
        $values = Venda::where('estado_venda_id', '=', $this->id)->getIndexedArray('estado_venda_id','{estado_venda->nome}');
        return implode(', ', $values);
    }

    
}

