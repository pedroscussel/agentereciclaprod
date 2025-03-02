<?php

class Prospeccao extends TRecord
{
    const TABLENAME  = 'prospeccao';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $vendedor;
    private $cliente;
    private $system_unit;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('vendedor_id');
        parent::addAttribute('cliente_id');
        parent::addAttribute('system_unit_id');
        parent::addAttribute('horario_inicial');
        parent::addAttribute('horario_final');
        parent::addAttribute('titulo');
        parent::addAttribute('cor');
        parent::addAttribute('observacao');
            
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

    
}

