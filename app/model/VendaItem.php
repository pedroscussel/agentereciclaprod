<?php

class VendaItem extends TRecord
{
    const TABLENAME  = 'venda_item';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $venda;
    private $produto;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('produto_id');
        parent::addAttribute('venda_id');
        parent::addAttribute('quantidade');
        parent::addAttribute('valor');
        parent::addAttribute('desconto');
            
    }

    /**
     * Method set_venda
     * Sample of usage: $var->venda = $object;
     * @param $object Instance of Venda
     */
    public function set_venda(Venda $object)
    {
        $this->venda = $object;
        $this->venda_id = $object->id;
    }

    /**
     * Method get_venda
     * Sample of usage: $var->venda->attribute;
     * @returns Venda instance
     */
    public function get_venda()
    {
    
        // loads the associated object
        if (empty($this->venda))
            $this->venda = new Venda($this->venda_id);
    
        // returns the associated object
        return $this->venda;
    }
    /**
     * Method set_produto
     * Sample of usage: $var->produto = $object;
     * @param $object Instance of Produto
     */
    public function set_produto(Produto $object)
    {
        $this->produto = $object;
        $this->produto_id = $object->id;
    }

    /**
     * Method get_produto
     * Sample of usage: $var->produto->attribute;
     * @returns Produto instance
     */
    public function get_produto()
    {
    
        // loads the associated object
        if (empty($this->produto))
            $this->produto = new Produto($this->produto_id);
    
        // returns the associated object
        return $this->produto;
    }

    
}

