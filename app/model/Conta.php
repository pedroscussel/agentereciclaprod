<?php

class Conta extends TRecord
{
    const TABLENAME  = 'conta';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $natureza;
    private $cliente;
    private $tipo_conta;
    private $system_unit;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('tipo_conta_id');
        parent::addAttribute('cliente_id');
        parent::addAttribute('natureza_id');
        parent::addAttribute('system_unit_id');
        parent::addAttribute('dt_emissao');
        parent::addAttribute('dt_vencimento');
        parent::addAttribute('valor');
        parent::addAttribute('desconto');
        parent::addAttribute('juros');
        parent::addAttribute('multa');
        parent::addAttribute('obs');
        parent::addAttribute('quitada');
            
    }

    /**
     * Method set_natureza
     * Sample of usage: $var->natureza = $object;
     * @param $object Instance of Natureza
     */
    public function set_natureza(Natureza $object)
    {
        $this->natureza = $object;
        $this->natureza_id = $object->id;
    }

    /**
     * Method get_natureza
     * Sample of usage: $var->natureza->attribute;
     * @returns Natureza instance
     */
    public function get_natureza()
    {
    
        // loads the associated object
        if (empty($this->natureza))
            $this->natureza = new Natureza($this->natureza_id);
    
        // returns the associated object
        return $this->natureza;
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
     * Method set_tipo_conta
     * Sample of usage: $var->tipo_conta = $object;
     * @param $object Instance of TipoConta
     */
    public function set_tipo_conta(TipoConta $object)
    {
        $this->tipo_conta = $object;
        $this->tipo_conta_id = $object->id;
    }

    /**
     * Method get_tipo_conta
     * Sample of usage: $var->tipo_conta->attribute;
     * @returns TipoConta instance
     */
    public function get_tipo_conta()
    {
    
        // loads the associated object
        if (empty($this->tipo_conta))
            $this->tipo_conta = new TipoConta($this->tipo_conta_id);
    
        // returns the associated object
        return $this->tipo_conta;
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

    
}

