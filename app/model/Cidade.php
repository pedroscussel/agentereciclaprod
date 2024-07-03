<?php

class Cidade extends TRecord
{
    const TABLENAME  = 'cidade';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $estado;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('estado_id');
            
    }

    /**
     * Method set_estado
     * Sample of usage: $var->estado = $object;
     * @param $object Instance of Estado
     */
    public function set_estado(Estado $object)
    {
        $this->estado = $object;
        $this->estado_id = $object->id;
    }

    /**
     * Method get_estado
     * Sample of usage: $var->estado->attribute;
     * @returns Estado instance
     */
    public function get_estado()
    {
    
        // loads the associated object
        if (empty($this->estado))
            $this->estado = new Estado($this->estado_id);
    
        // returns the associated object
        return $this->estado;
    }

    /**
     * Method getPessoas
     */
    public function getPessoas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cidade_id', '=', $this->id));
        return Pessoa::getObjects( $criteria );
    }

    public function set_pessoa_cidade_to_string($pessoa_cidade_to_string)
    {
        if(is_array($pessoa_cidade_to_string))
        {
            $values = Cidade::where('id', 'in', $pessoa_cidade_to_string)->getIndexedArray('nome', 'nome');
            $this->pessoa_cidade_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoa_cidade_to_string = $pessoa_cidade_to_string;
        }

        $this->vdata['pessoa_cidade_to_string'] = $this->pessoa_cidade_to_string;
    }

    public function get_pessoa_cidade_to_string()
    {
        if(!empty($this->pessoa_cidade_to_string))
        {
            return $this->pessoa_cidade_to_string;
        }
    
        $values = Pessoa::where('cidade_id', '=', $this->id)->getIndexedArray('cidade_id','{cidade->nome}');
        return implode(', ', $values);
    }

    
}

