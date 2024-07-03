<?php

class PessoaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'mini_erp';
    private static $activeRecord = 'Pessoa';
    private static $primaryKey = 'id';
    private static $formName = 'form_Pessoa';

    use Adianti\Base\AdiantiMasterDetailTrait;

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
        $this->form->setFormTitle("Cadastro de pessoa");

        $criteria_system_user_id = new TCriteria();
        $criteria_grupo_id = new TCriteria();
        $criteria_cidade_estado_id = new TCriteria();

        $id = new TEntry('id');
        $system_user_id = new TDBCombo('system_user_id', 'permission', 'SystemUsers', 'id', '{name}','name asc' , $criteria_system_user_id );
        $dt_ativacao = new TDate('dt_ativacao');
        $dt_desativacao = new TDate('dt_desativacao');
        $grupo_id = new TDBCheckGroup('grupo_id', 'mini_erp', 'Grupo', 'id', '{nome}','nome asc' , $criteria_grupo_id );
        $nome = new TEntry('nome');
        $documento = new TEntry('documento');
        $fone = new TEntry('fone');
        $email = new TEntry('email');
        $obs = new TText('obs');
        $cidade_estado_id = new TDBCombo('cidade_estado_id', 'mini_erp', 'Estado', 'id', '{nome}','nome asc' , $criteria_cidade_estado_id );
        $cidade_id = new TCombo('cidade_id');
        $bairro = new TEntry('bairro');
        $rua = new TEntry('rua');
        $numero = new TEntry('numero');
        $complemento = new TEntry('complemento');
        $cep = new TEntry('cep');
        $contato_pessoa_email = new TEntry('contato_pessoa_email');
        $contato_pessoa_nome = new TEntry('contato_pessoa_nome');
        $contato_pessoa_telefone = new TEntry('contato_pessoa_telefone');
        $contato_pessoa_obs = new TEntry('contato_pessoa_obs');
        $contato_pessoa_id = new THidden('contato_pessoa_id');

        $cidade_estado_id->setChangeAction(new TAction([$this,'onChangecidade_estado_id']));

        $dt_ativacao->addValidation("Data de ativação", new TRequiredValidator()); 
        $nome->addValidation("Nome", new TRequiredValidator()); 
        $documento->addValidation("Documento", new TRequiredValidator()); 
        $cidade_id->addValidation("Cidade", new TRequiredValidator()); 

        $id->setEditable(false);
        $system_user_id->enableSearch();
        $dt_ativacao->setValue(date('d/m/Y'));
        $grupo_id->setLayout('horizontal');
        $dt_ativacao->setDatabaseMask('yyyy-mm-dd');
        $dt_desativacao->setDatabaseMask('yyyy-mm-dd');

        $cep->setMask('99999-999');
        $dt_ativacao->setMask('dd/mm/yyyy');
        $dt_desativacao->setMask('dd/mm/yyyy');

        $id->setSize(150);
        $rua->setSize('100%');
        $cep->setSize('100%');
        $nome->setSize('100%');
        $fone->setSize('100%');
        $grupo_id->setSize(180);
        $email->setSize('100%');
        $bairro->setSize('100%');
        $numero->setSize('100%');
        $dt_ativacao->setSize(150);
        $obs->setSize('100%', 100);
        $documento->setSize('100%');
        $cidade_id->setSize('100%');
        $dt_desativacao->setSize(150);
        $complemento->setSize('100%');
        $system_user_id->setSize('100%');
        $cidade_estado_id->setSize('100%');
        $contato_pessoa_obs->setSize('100%');
        $contato_pessoa_nome->setSize('100%');
        $contato_pessoa_email->setSize('100%');
        $contato_pessoa_telefone->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id],[new TLabel("Usuário do sistema:", null, '14px', null)],[$system_user_id]);
        $row2 = $this->form->addFields([new TLabel("Data de ativação:", '#ff0000', '14px', null)],[$dt_ativacao],[new TLabel("Data de desativação:", null, '14px', null)],[$dt_desativacao]);
        $row3 = $this->form->addFields([new TLabel("Grupo:", null, '14px', null)],[$grupo_id]);
        $row4 = $this->form->addContent([new TFormSeparator("Dados pessoais", '#333333', '18', '#eeeeee')]);
        $row5 = $this->form->addFields([new TLabel("Nome:", '#ff0000', '14px', null)],[$nome],[new TLabel("Documento:", '#ff0000', '14px', null)],[$documento]);
        $row6 = $this->form->addFields([new TLabel("Telefone:", null, '14px', null)],[$fone],[new TLabel("Email:", null, '14px', null)],[$email]);
        $row7 = $this->form->addFields([new TLabel("Observação:", null, '14px', null)],[$obs]);
        $row8 = $this->form->addContent([new TFormSeparator("Localização", '#333333', '18', '#eeeeee')]);
        $row9 = $this->form->addFields([new TLabel("Estado:", '#ff0000', '14px', null)],[$cidade_estado_id],[new TLabel("Cidade:", '#ff0000', '14px', null)],[$cidade_id]);
        $row10 = $this->form->addFields([new TLabel("Bairro:", null, '14px', null)],[$bairro],[new TLabel("Rua:", null, '14px', null)],[$rua]);
        $row11 = $this->form->addFields([new TLabel("Número:", null, '14px', null)],[$numero],[new TLabel("Complemento:", null, '14px', null)],[$complemento]);
        $row12 = $this->form->addFields([new TLabel("CEP:", null, '14px', null)],[$cep],[],[]);
        $row13 = $this->form->addContent([new TFormSeparator("Contato", '#333333', '18', '#eeeeee')]);
        $row14 = $this->form->addFields([new TLabel("Email:", '#ff0000', '14px', null)],[$contato_pessoa_email],[new TLabel("Nome:", '#ff0000', '14px', null)],[$contato_pessoa_nome]);
        $row15 = $this->form->addFields([new TLabel("Tefone:", null, '14px', null)],[$contato_pessoa_telefone],[new TLabel("Observação:", null, '14px', null)],[$contato_pessoa_obs]);
        $row16 = $this->form->addFields([$contato_pessoa_id]);         
        $add_contato_pessoa = new TButton('add_contato_pessoa');

        $action_contato_pessoa = new TAction(array($this, 'onAddContatoPessoa'));

        $add_contato_pessoa->setAction($action_contato_pessoa, "Adicionar");
        $add_contato_pessoa->setImage('fas:plus #000000');

        $this->form->addFields([$add_contato_pessoa]);

        $detailDatagrid = new TQuickGrid;
        $detailDatagrid->disableHtmlConversion();
        $this->contato_pessoa_list = new BootstrapDatagridWrapper($detailDatagrid);
        $this->contato_pessoa_list->style = 'width:100%';
        $this->contato_pessoa_list->class .= ' table-bordered';
        $this->contato_pessoa_list->disableDefaultClick();
        $this->contato_pessoa_list->addQuickColumn('', 'edit', 'left', 50);
        $this->contato_pessoa_list->addQuickColumn('', 'delete', 'left', 50);

        $column_contato_pessoa_email = $this->contato_pessoa_list->addQuickColumn("Email", 'contato_pessoa_email', 'left');
        $column_contato_pessoa_nome = $this->contato_pessoa_list->addQuickColumn("Nome", 'contato_pessoa_nome', 'left');
        $column_contato_pessoa_telefone = $this->contato_pessoa_list->addQuickColumn("Tefone", 'contato_pessoa_telefone', 'left');
        $column_contato_pessoa_obs = $this->contato_pessoa_list->addQuickColumn("Observação", 'contato_pessoa_obs', 'left');

        $this->contato_pessoa_list->createModel();
        $this->form->addContent([$this->contato_pessoa_list]);

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

    public static function onChangecidade_estado_id($param)
    {
        try
        {

            if (isset($param['cidade_estado_id']) && $param['cidade_estado_id'])
            { 
                $criteria = TCriteria::create(['estado_id' => $param['cidade_estado_id']]);
                TDBCombo::reloadFromModel(self::$formName, 'cidade_id', 'mini_erp', 'Cidade', 'id', '{nome}', 'nome asc', $criteria, TRUE); 
            } 
            else 
            { 
                TCombo::clearField(self::$formName, 'cidade_id'); 
            }  

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
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

            $object = new Pessoa(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $this->fireEvents($object);

            $repository = PessoaGrupo::where('pessoa_id', '=', $object->id);
            $repository->delete(); 

            if ($data->grupo_id) 
            {
                foreach ($data->grupo_id as $grupo_id_value) 
                {
                    $pessoa_grupo = new PessoaGrupo;

                    $pessoa_grupo->grupo_id = $grupo_id_value;
                    $pessoa_grupo->pessoa_id = $object->id;
                    $pessoa_grupo->store();
                }
            }

            $messageAction = new TAction(['PessoaList', 'onShow']);   

            if(!empty($param['target_container']))
            {
                $messageAction->setParameter('target_container', $param['target_container']);
            }

            $contato_pessoa_items = $this->storeItems('Contato', 'pessoa_id', $object, 'contato_pessoa', function($masterObject, $detailObject){ 

                //code here

            }); 

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

                $object = new Pessoa($key); // instantiates the Active Record 

                                $object->cidade_estado_id = $object->cidade->estado_id;

                    $object->grupo_id = PessoaGrupo::where('pessoa_id', '=', $object->id)->getIndexedArray('grupo_id', 'grupo_id');

                $contato_pessoa_items = $this->loadItems('Contato', 'pessoa_id', $object, 'contato_pessoa', function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }); 

                $this->form->setData($object); // fill the form 

                    $this->fireEvents($object);
                    $this->onReload();

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

        TSession::setValue('contato_pessoa_items', null);

        $this->onReload();
    }

    public function onAddContatoPessoa( $param )
    {
        try
        {
            $data = $this->form->getData();

            if(!$data->contato_pessoa_email)
            {
                throw new Exception(AdiantiCoreTranslator::translate('The field ^1 is required', "Email"));
            }             
            if(!$data->contato_pessoa_nome)
            {
                throw new Exception(AdiantiCoreTranslator::translate('The field ^1 is required', "Nome"));
            }             

            $contato_pessoa_items = TSession::getValue('contato_pessoa_items');
            $key = isset($data->contato_pessoa_id) && $data->contato_pessoa_id ? $data->contato_pessoa_id : 'b'.uniqid();
            $fields = []; 

            $fields['contato_pessoa_email'] = $data->contato_pessoa_email;
            $fields['contato_pessoa_nome'] = $data->contato_pessoa_nome;
            $fields['contato_pessoa_telefone'] = $data->contato_pessoa_telefone;
            $fields['contato_pessoa_obs'] = $data->contato_pessoa_obs;
            $contato_pessoa_items[ $key ] = $fields;

            TSession::setValue('contato_pessoa_items', $contato_pessoa_items);

            $data->contato_pessoa_id = '';
            $data->contato_pessoa_email = '';
            $data->contato_pessoa_nome = '';
            $data->contato_pessoa_telefone = '';
            $data->contato_pessoa_obs = '';

            $this->form->setData($data);
            $this->fireEvents($data);
            $this->onReload( $param );
        }
        catch (Exception $e)
        {
            $this->form->setData( $this->form->getData());
            $this->fireEvents($data);
            new TMessage('error', $e->getMessage());
        }
    }

    public function onEditContatoPessoa( $param )
    {
        $data = $this->form->getData();

        // read session items
        $items = TSession::getValue('contato_pessoa_items');

        // get the session item
        $item = $items[$param['contato_pessoa_id_row_id']];

        $data->contato_pessoa_email = $item['contato_pessoa_email'];
        $data->contato_pessoa_nome = $item['contato_pessoa_nome'];
        $data->contato_pessoa_telefone = $item['contato_pessoa_telefone'];
        $data->contato_pessoa_obs = $item['contato_pessoa_obs'];

        $data->contato_pessoa_id = $param['contato_pessoa_id_row_id'];

        // fill product fields
        $this->form->setData( $data );

        $this->fireEvents($data);

        $this->onReload( $param );

    }

    public function onDeleteContatoPessoa( $param )
    {
        $data = $this->form->getData();

        $data->contato_pessoa_email = '';
        $data->contato_pessoa_nome = '';
        $data->contato_pessoa_telefone = '';
        $data->contato_pessoa_obs = '';

        // clear form data
        $this->form->setData( $data );

        // read session items
        $items = TSession::getValue('contato_pessoa_items');

        // delete the item from session
        unset($items[$param['contato_pessoa_id_row_id']]);
        TSession::setValue('contato_pessoa_items', $items);

        $this->fireEvents($data);

        // reload sale items
        $this->onReload( $param );

    }

    public function onReloadContatoPessoa( $param )
    {
        $items = TSession::getValue('contato_pessoa_items'); 

        $this->contato_pessoa_list->clear(); 

        if($items) 
        { 
            $cont = 1; 
            foreach ($items as $key => $item) 
            {
                $rowItem = new StdClass;

                $action_del = new TAction(array($this, 'onDeleteContatoPessoa')); 
                $action_del->setParameter('contato_pessoa_id_row_id', $key);
                $action_del->setParameter('row_data', base64_encode(serialize($item)));
                $action_del->setParameter('key', $key);

                $action_edi = new TAction(array($this, 'onEditContatoPessoa'));  
                $action_edi->setParameter('contato_pessoa_id_row_id', $key);  
                $action_edi->setParameter('row_data', base64_encode(serialize($item)));
                $action_edi->setParameter('key', $key);

                $button_del = new TButton('delete_contato_pessoa'.$cont);
                $button_del->setAction($action_del, '');
                $button_del->setFormName($this->form->getName());
                $button_del->class = 'btn btn-link btn-sm';
                $button_del->title = '';
                $button_del->setImage('far:trash-alt #dd5a43');

                $rowItem->delete = $button_del;

                $button_edi = new TButton('edit_contato_pessoa'.$cont);
                $button_edi->setAction($action_edi, '');
                $button_edi->setFormName($this->form->getName());
                $button_edi->class = 'btn btn-link btn-sm';
                $button_edi->title = '';
                $button_edi->setImage('far:edit #478fca');

                $rowItem->edit = $button_edi;

                $rowItem->contato_pessoa_email = isset($item['contato_pessoa_email']) ? $item['contato_pessoa_email'] : '';
                $rowItem->contato_pessoa_nome = isset($item['contato_pessoa_nome']) ? $item['contato_pessoa_nome'] : '';
                $rowItem->contato_pessoa_telefone = isset($item['contato_pessoa_telefone']) ? $item['contato_pessoa_telefone'] : '';
                $rowItem->contato_pessoa_obs = isset($item['contato_pessoa_obs']) ? $item['contato_pessoa_obs'] : '';

                $row = $this->contato_pessoa_list->addItem($rowItem);

                $cont++;
            } 
        } 
    } 

    public function onShow($param = null)
    {

        TSession::setValue('contato_pessoa_items', null);

        $this->onReload();

    } 

    public function fireEvents( $object )
    {
        $obj = new stdClass;
        if(is_object($object) && get_class($object) == 'stdClass')
        {
            if(isset($object->cidade_estado_id))
            {
                $value = $object->cidade_estado_id;

                $obj->cidade_estado_id = $value;
            }
            if(isset($object->cidade_id))
            {
                $value = $object->cidade_id;

                $obj->cidade_id = $value;
            }
        }
        elseif(is_object($object))
        {
            if(isset($object->cidade->estado_id))
            {
                $value = $object->cidade->estado_id;

                $obj->cidade_estado_id = $value;
            }
            if(isset($object->cidade_id))
            {
                $value = $object->cidade_id;

                $obj->cidade_id = $value;
            }
        }
        TForm::sendData(self::$formName, $obj);
    }  

    public function onReload($params = null)
    {
        $this->loaded = TRUE;

        $this->onReloadContatoPessoa($params);
    }

    public function show() 
    { 
        if (!$this->loaded AND (!isset($_GET['method']) OR $_GET['method'] !== 'onReload') ) 
        { 
            $this->onReload( func_get_arg(0) );
        }
        parent::show();
    }

    public static function getFormName()
    {
        return self::$formName;
    }

}

