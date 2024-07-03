<?php

class ContaReceberForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'mini_erp';
    private static $activeRecord = 'Conta';
    private static $primaryKey = 'id';
    private static $formName = 'form_Conta';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Cadastro de conta a receber");

        $criteria_cliente_id = new TCriteria();
        $criteria_natureza_id = new TCriteria();

        $filterVar = Grupo::clientes;
        $criteria_cliente_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_id in  (SELECT id FROM grupo WHERE id = '{$filterVar}') )")); 

        $id = new TEntry('id');
        $tipo_conta_id = new THidden('tipo_conta_id');
        $cliente_id = new TDBUniqueSearch('cliente_id', 'mini_erp', 'Pessoa', 'id', 'nome','nome asc' , $criteria_cliente_id );
        $natureza_id = new TDBCombo('natureza_id', 'mini_erp', 'Natureza', 'id', '{nome}','nome asc' , $criteria_natureza_id );
        $dt_emissao = new TDate('dt_emissao');
        $dt_vencimento = new TDate('dt_vencimento');
        $valor = new TNumeric('valor', '2', ',', '.' );
        $desconto = new TNumeric('desconto', '2', ',', '.' );
        $juros = new TNumeric('juros', '2', ',', '.' );
        $multa = new TNumeric('multa', '2', ',', '.' );
        $obs = new TText('obs');

        $cliente_id->addValidation("Cliente", new TRequiredValidator()); 
        $natureza_id->addValidation("Natureza", new TRequiredValidator()); 
        $dt_emissao->addValidation("Data de emissão", new TRequiredValidator()); 
        $dt_vencimento->addValidation("Data de vencimento", new TRequiredValidator()); 
        $valor->addValidation("Valor", new TRequiredValidator()); 

        $id->setEditable(false);
        $tipo_conta_id->setValue(TipoConta::receber);
        $cliente_id->setMinLength(2);
        $dt_emissao->setDatabaseMask('yyyy-mm-dd');
        $dt_vencimento->setDatabaseMask('yyyy-mm-dd');

        $cliente_id->setMask('{nome}');
        $dt_emissao->setMask('dd/mm/yyyy');
        $dt_vencimento->setMask('dd/mm/yyyy');

        $id->setSize(100);
        $valor->setSize('100%');
        $juros->setSize('100%');
        $multa->setSize('100%');
        $dt_emissao->setSize(100);
        $obs->setSize('100%', 68);
        $desconto->setSize('100%');
        $tipo_conta_id->setSize(200);
        $cliente_id->setSize('100%');
        $dt_vencimento->setSize(100);
        $natureza_id->setSize('100%');


        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id],[],[$tipo_conta_id]);
        $row2 = $this->form->addFields([new TLabel("Cliente:", '#ff0000', '14px', null)],[$cliente_id],[new TLabel("Natureza:", '#ff0000', '14px', null)],[$natureza_id]);
        $row3 = $this->form->addFields([new TLabel("Data de emissão:", '#ff0000', '14px', null)],[$dt_emissao],[new TLabel("Data de vencimento:", '#ff0000', '14px', null)],[$dt_vencimento]);
        $row4 = $this->form->addFields([new TLabel("Valor:", '#ff0000', '14px', null)],[$valor],[new TLabel("Desconto:", null, '14px', null)],[$desconto]);
        $row5 = $this->form->addFields([new TLabel("Juros:", null, '14px', null)],[$juros],[new TLabel("Multa:", null, '14px', null)],[$multa]);
        $row6 = $this->form->addFields([new TLabel("Obs:", null, '14px', null)],[$obs]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'far:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Novo", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            /**
            // Enable Debug logger for SQL operations inside the transaction
            TTransaction::setLogger(new TLoggerSTD); // standard output
            TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
            **/

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Conta(); // create an empty object 

            if(!$data->id)
            {
                $object->system_unit_id = TSession::getValue('userunitid');
            }

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $messageAction = new TAction(['ContaReceberList', 'onShow']);   

            if(!empty($param['target_container']))
            {
                $messageAction->setParameter('target_container', $param['target_container']);
            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            /**
            // To define an action to be executed on the message close event:
            $messageAction = new TAction(['className', 'methodName']);
            **/

            new TMessage('info', AdiantiCoreTranslator::translate('Record saved'), $messageAction);
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Conta($key); // instantiates the Active Record 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

