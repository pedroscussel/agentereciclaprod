<?php

class VendaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'mini_erp';
    private static $activeRecord = 'Venda';
    private static $primaryKey = 'id';
    private static $formName = 'form_Venda';

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
        $this->form->setFormTitle("Cadastro de venda");

        $criteria_vendedor_id = new TCriteria();
        $criteria_cliente_id = new TCriteria();
        $criteria_venda_item_venda_produto_id = new TCriteria();

        $filterVar = Grupo::vendedores;
        $criteria_vendedor_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_id in  (SELECT id FROM grupo WHERE id = '{$filterVar}') )")); 
        $filterVar = TSession::getValue("userid");
        $criteria_vendedor_id->add(new TFilter('system_user_id', '=', $filterVar)); 
        $filterVar = Grupo::clientes;
        $criteria_cliente_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_id in  (SELECT id FROM grupo WHERE id = '{$filterVar}') )")); 

        $id = new TEntry('id');
        $dt_venda = new TDateTime('dt_venda');
        $vendedor_id = new TDBCombo('vendedor_id', 'mini_erp', 'Pessoa', 'id', '{nome}','nome asc' , $criteria_vendedor_id );
        $cliente_id = new TDBUniqueSearch('cliente_id', 'mini_erp', 'Pessoa', 'id', 'nome','nome asc' , $criteria_cliente_id );
        $frete = new TNumeric('frete', '2', ',', '.' );
        $obs = new TText('obs');
        $venda_item_venda_produto_id = new TDBCombo('venda_item_venda_produto_id', 'mini_erp', 'Produto', 'id', '{nome}','id asc' , $criteria_venda_item_venda_produto_id );
        $venda_item_venda_valor = new TNumeric('venda_item_venda_valor', '2', ',', '.' );
        $venda_item_venda_quantidade = new TNumeric('venda_item_venda_quantidade', '2', ',', '.' );
        $venda_item_venda_desconto = new TNumeric('venda_item_venda_desconto', '2', ',', '.' );
        $venda_item_venda_id = new THidden('venda_item_venda_id');

        $venda_item_venda_produto_id->setChangeAction(new TAction([$this,'onChangeProduto']));

        $vendedor_id->addValidation("Vendedor", new TRequiredValidator()); 
        $cliente_id->addValidation("Cliente", new TRequiredValidator()); 

        $id->setEditable(false);
        $dt_venda->setValue(date('d/m/Y h:i'));
        $dt_venda->setDatabaseMask('yyyy-mm-dd hh:ii');
        $cliente_id->setMinLength(2);
        $cliente_id->setMask('{nome}');
        $dt_venda->setMask('dd/mm/yyyy hh:ii');

        $id->setSize(100);
        $dt_venda->setSize(150);
        $frete->setSize('100%');
        $obs->setSize('100%', 90);
        $cliente_id->setSize('100%');
        $vendedor_id->setSize('100%');
        $venda_item_venda_valor->setSize('100%');
        $venda_item_venda_desconto->setSize('100%');
        $venda_item_venda_produto_id->setSize('100%');
        $venda_item_venda_quantidade->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id],[new TLabel("Data da venda:", null, '14px', null)],[$dt_venda]);
        $row2 = $this->form->addFields([new TLabel("Vendedor:", '#ff0000', '14px', null)],[$vendedor_id],[new TLabel("Cliente:", '#ff0000', '14px', null)],[$cliente_id]);
        $row3 = $this->form->addFields([new TLabel("Valor do frete:", null, '14px', null)],[$frete],[new TLabel("Observação:", null, '14px', null)],[$obs]);
        $row4 = $this->form->addContent([new TFormSeparator("Produtos", '#333333', '18', '#eeeeee')]);
        $row5 = $this->form->addFields([new TLabel("Produto:", '#ff0000', '14px', null)],[$venda_item_venda_produto_id],[new TLabel("Valor:", '#ff0000', '14px', null)],[$venda_item_venda_valor]);
        $row6 = $this->form->addFields([new TLabel("Quantidade:", '#ff0000', '14px', null)],[$venda_item_venda_quantidade],[new TLabel("Desconto:", null, '14px', null)],[$venda_item_venda_desconto]);
        $row7 = $this->form->addFields([$venda_item_venda_id]);         
        $add_venda_item_venda = new TButton('add_venda_item_venda');

        $action_venda_item_venda = new TAction(array($this, 'onAddVendaItemVenda'));

        $add_venda_item_venda->setAction($action_venda_item_venda, "Adicionar");
        $add_venda_item_venda->setImage('fas:plus #000000');

        $this->form->addFields([$add_venda_item_venda]);

        $detailDatagrid = new TQuickGrid;
        $detailDatagrid->disableHtmlConversion();
        $this->venda_item_venda_list = new BootstrapDatagridWrapper($detailDatagrid);
        $this->venda_item_venda_list->style = 'width:100%';
        $this->venda_item_venda_list->class .= ' table-bordered';
        $this->venda_item_venda_list->disableDefaultClick();
        $this->venda_item_venda_list->addQuickColumn('', 'edit', 'left', 50);
        $this->venda_item_venda_list->addQuickColumn('', 'delete', 'left', 50);

        $column_venda_item_venda_produto_id = $this->venda_item_venda_list->addQuickColumn("Produto", 'venda_item_venda_produto_id', 'left');
        $column_venda_item_venda_quantidade_transformed = $this->venda_item_venda_list->addQuickColumn("Quantidade", 'venda_item_venda_quantidade', 'left');
        $column_venda_item_venda_valor_transformed = $this->venda_item_venda_list->addQuickColumn("Valor", 'venda_item_venda_valor', 'left');
        $column_venda_item_venda_desconto_transformed = $this->venda_item_venda_list->addQuickColumn("Desconto", 'venda_item_venda_desconto', 'left');
        $column_calculated_2 = $this->venda_item_venda_list->addQuickColumn("Valor total", '=( {venda_item_venda_quantidade} * ( {venda_item_venda_valor} - {venda_item_venda_desconto} )  )', 'left');

        $this->venda_item_venda_list->createModel();
        $this->form->addContent([$this->venda_item_venda_list]);

        $column_venda_item_venda_quantidade_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });

        $column_venda_item_venda_valor_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });

        $column_venda_item_venda_desconto_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });

        $column_calculated_2->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });

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
            $container->add(TBreadCrumb::create(["Operações","Cadastro de venda"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onChangeProduto($param = null) 
    {
        try 
        {
            if($param['key'])
            {
                TTransaction::open('mini_erp');
                $produto = new Produto($param['key']);
                TTransaction::close();

                if($produto)
                {
                    $object = new stdClass();
                    $object->venda_item_venda_valor = number_format($produto->preco_venda, 2 , ',', '.');

                    TForm::sendData(self::$formName, $object);    
                }
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

            $object = new Venda(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            if(!$data->id)
            {
                $object->estado_venda_id = EstadoVenda::nova;
                $object->system_unit_id = TSession::getValue('userunitid');
            }

            $object->store(); // save the object 

            $messageAction = new TAction(['VendaList', 'onShow']);   

            if(!empty($param['target_container']))
            {
                $messageAction->setParameter('target_container', $param['target_container']);
            }

            $object->valor_total = 0; 
            $venda_item_venda_items = $this->storeItems('VendaItem', 'venda_id', $object, 'venda_item_venda', function($masterObject, $detailObject){ 

                $masterObject->valor_total += ($detailObject->quantidade * ($detailObject->valor - $detailObject->desconto));

            }); 

            $object->store();

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
            if(isset($param['orcamento_id']))
            {
                TTransaction::open('mini_erp');
                $orcamento = new Orcamento($param['orcamento_id']);

                $venda_item_venda_items = $this->loadItems('OrcamentoItem', 'orcamento_id', $orcamento, 'venda_item_venda', function($masterObject, $detailObject, $objectItems){
                    unset($detailObject->venda_id);
                    $detailObject->id = uniqid();
                });
                TTransaction::close();

                unset($orcamento->id);

                $this->form->setData($orcamento);
                $this->onReload();
            }
            elseif (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Venda($key); // instantiates the Active Record 

                $venda_item_venda_items = $this->loadItems('VendaItem', 'venda_id', $object, 'venda_item_venda', function($masterObject, $detailObject){ 

                    //code here

                }); 

                $this->form->setData($object); // fill the form 

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

        TSession::setValue('venda_item_venda_items', null);

        $this->onReload();
    }

    public function onAddVendaItemVenda( $param )
    {
        try
        {
            $data = $this->form->getData();

            if(!$data->venda_item_venda_produto_id)
            {
                throw new Exception(AdiantiCoreTranslator::translate('The field ^1 is required', "Produto"));
            }             
            if(!$data->venda_item_venda_valor)
            {
                throw new Exception(AdiantiCoreTranslator::translate('The field ^1 is required', "Valor"));
            }             
            if(!$data->venda_item_venda_quantidade)
            {
                throw new Exception(AdiantiCoreTranslator::translate('The field ^1 is required', "Quantidade"));
            }             

            $venda_item_venda_items = TSession::getValue('venda_item_venda_items');
            $key = isset($data->venda_item_venda_id) && $data->venda_item_venda_id ? $data->venda_item_venda_id : 'b'.uniqid();
            $fields = []; 

            $fields['venda_item_venda_produto_id'] = $data->venda_item_venda_produto_id;
            $fields['venda_item_venda_valor'] = $data->venda_item_venda_valor;
            $fields['venda_item_venda_quantidade'] = $data->venda_item_venda_quantidade;
            $fields['venda_item_venda_desconto'] = $data->venda_item_venda_desconto;
            $venda_item_venda_items[ $key ] = $fields;

            TSession::setValue('venda_item_venda_items', $venda_item_venda_items);

            $data->venda_item_venda_id = '';
            $data->venda_item_venda_produto_id = '';
            $data->venda_item_venda_valor = '';
            $data->venda_item_venda_quantidade = '';
            $data->venda_item_venda_desconto = '';

            $this->form->setData($data);

            $this->onReload( $param );
        }
        catch (Exception $e)
        {
            $this->form->setData( $this->form->getData());

            new TMessage('error', $e->getMessage());
        }
    }

    public function onEditVendaItemVenda( $param )
    {
        $data = $this->form->getData();

        // read session items
        $items = TSession::getValue('venda_item_venda_items');

        // get the session item
        $item = $items[$param['venda_item_venda_id_row_id']];

        $data->venda_item_venda_produto_id = $item['venda_item_venda_produto_id'];
        $data->venda_item_venda_valor = $item['venda_item_venda_valor'];
        $data->venda_item_venda_quantidade = $item['venda_item_venda_quantidade'];
        $data->venda_item_venda_desconto = $item['venda_item_venda_desconto'];

        $data->venda_item_venda_id = $param['venda_item_venda_id_row_id'];

        // fill product fields
        $this->form->setData( $data );

        $this->onReload( $param );

    }

    public function onDeleteVendaItemVenda( $param )
    {
        $data = $this->form->getData();

        $data->venda_item_venda_produto_id = '';
        $data->venda_item_venda_valor = '';
        $data->venda_item_venda_quantidade = '';
        $data->venda_item_venda_desconto = '';

        // clear form data
        $this->form->setData( $data );

        // read session items
        $items = TSession::getValue('venda_item_venda_items');

        // delete the item from session
        unset($items[$param['venda_item_venda_id_row_id']]);
        TSession::setValue('venda_item_venda_items', $items);

        // reload sale items
        $this->onReload( $param );

    }

    public function onReloadVendaItemVenda( $param )
    {
        $items = TSession::getValue('venda_item_venda_items'); 

        $this->venda_item_venda_list->clear(); 

        if($items) 
        { 
            $cont = 1; 
            foreach ($items as $key => $item) 
            {
                $rowItem = new StdClass;

                $action_del = new TAction(array($this, 'onDeleteVendaItemVenda')); 
                $action_del->setParameter('venda_item_venda_id_row_id', $key);
                $action_del->setParameter('row_data', base64_encode(serialize($item)));
                $action_del->setParameter('key', $key);

                $action_edi = new TAction(array($this, 'onEditVendaItemVenda'));  
                $action_edi->setParameter('venda_item_venda_id_row_id', $key);  
                $action_edi->setParameter('row_data', base64_encode(serialize($item)));
                $action_edi->setParameter('key', $key);

                $button_del = new TButton('delete_venda_item_venda'.$cont);
                $button_del->setAction($action_del, '');
                $button_del->setFormName($this->form->getName());
                $button_del->class = 'btn btn-link btn-sm';
                $button_del->title = '';
                $button_del->setImage('far:trash-alt #dd5a43');

                $rowItem->delete = $button_del;

                $button_edi = new TButton('edit_venda_item_venda'.$cont);
                $button_edi->setAction($action_edi, '');
                $button_edi->setFormName($this->form->getName());
                $button_edi->class = 'btn btn-link btn-sm';
                $button_edi->title = '';
                $button_edi->setImage('far:edit #478fca');

                $rowItem->edit = $button_edi;

                $rowItem->venda_item_venda_produto_id = '';
                if(isset($item['venda_item_venda_produto_id']) && $item['venda_item_venda_produto_id'])
                {
                    TTransaction::open('mini_erp');
                    $produto = Produto::find($item['venda_item_venda_produto_id']);
                    if($produto)
                    {
                        $rowItem->venda_item_venda_produto_id = $produto->render('{nome}');
                    }
                    TTransaction::close();
                }

                $rowItem->venda_item_venda_valor = isset($item['venda_item_venda_valor']) ? $item['venda_item_venda_valor'] : '';
                $rowItem->venda_item_venda_quantidade = isset($item['venda_item_venda_quantidade']) ? $item['venda_item_venda_quantidade'] : '';
                $rowItem->venda_item_venda_desconto = isset($item['venda_item_venda_desconto']) ? $item['venda_item_venda_desconto'] : '';

                $row = $this->venda_item_venda_list->addItem($rowItem);

                $cont++;
            } 
        } 
    } 

    public function onShow($param = null)
    {

        TSession::setValue('venda_item_venda_items', null);

        $this->onReload();

    } 

    public function onReload($params = null)
    {
        $this->loaded = TRUE;

        $this->onReloadVendaItemVenda($params);
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

