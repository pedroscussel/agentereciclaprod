<?php

class VendaList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'mini_erp';
    private static $activeRecord = 'Venda';
    private static $primaryKey = 'id';
    private static $formName = 'formList_Venda';
    private $showMethods = ['onReload', 'onSearch', 'onRefresh', 'onClearFilters'];
    private $limit = 20;

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param = null)
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Listagem de vendas");
        $this->limit = 20;

        $criteria_estado_venda_id = new TCriteria();
        $criteria_cliente_id = new TCriteria();
        $criteria_vendedor_id = new TCriteria();

        $filterVar = Grupo::clientes;
        $criteria_cliente_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_id in  (SELECT id FROM grupo WHERE id = '{$filterVar}') )")); 
        $filterVar = Grupo::vendedores;
        $criteria_vendedor_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_id in  (SELECT id FROM grupo WHERE id = '{$filterVar}') )")); 

        $id = new TEntry('id');
        $estado_venda_id = new TDBCombo('estado_venda_id', 'mini_erp', 'EstadoVenda', 'id', '{nome}','nome asc' , $criteria_estado_venda_id );
        $cliente_id = new TDBUniqueSearch('cliente_id', 'mini_erp', 'Pessoa', 'id', 'nome','nome asc' , $criteria_cliente_id );
        $vendedor_id = new TDBCombo('vendedor_id', 'mini_erp', 'Pessoa', 'id', '{nome}','nome asc' , $criteria_vendedor_id );
        $dt_venda = new TDate('dt_venda');
        $data_final = new TDate('data_final');


        $cliente_id->setMinLength(2);
        $dt_venda->setDatabaseMask('yyyy-mm-dd');
        $data_final->setDatabaseMask('yyyy-mm-dd');

        $cliente_id->setMask('{nome}');
        $dt_venda->setMask('dd/mm/yyyy');
        $data_final->setMask('dd/mm/yyyy');

        $id->setSize(100);
        $dt_venda->setSize(150);
        $data_final->setSize(150);
        $cliente_id->setSize('100%');
        $vendedor_id->setSize('100%');
        $estado_venda_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id],[new TLabel("Estado da venda:", null, '14px', null)],[$estado_venda_id]);
        $row2 = $this->form->addFields([new TLabel("Cliente:", null, '14px', null)],[$cliente_id],[new TLabel("Vendedor:", null, '14px', null)],[$vendedor_id]);
        $row3 = $this->form->addFields([new TLabel("Data da venda (de):", null, '14px', null)],[$dt_venda],[new TLabel("Data da venda (até):", null, '14px', null)],[$data_final]);

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $this->btn_onsearch = $btn_onsearch;
        $btn_onsearch->addStyleClass('btn-primary'); 

        $btn_onexportcsv = $this->form->addAction("Exportar como CSV", new TAction([$this, 'onExportCsv']), 'far:file-alt #000000');
        $this->btn_onexportcsv = $btn_onexportcsv;

        $btn_onshow = $this->form->addAction("Cadastrar", new TAction(['VendaForm', 'onShow']), 'fas:plus #69aa46');
        $this->btn_onshow = $btn_onshow;

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $filterVar = TSession::getValue("userunitid");
        $this->filter_criteria->add(new TFilter('system_unit_id', '=', $filterVar));

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_id = new TDataGridColumn('id', "Id", 'left' , '86px');
        $column_cliente_nome = new TDataGridColumn('cliente->nome', "Cliente", 'left');
        $column_vendedor_nome = new TDataGridColumn('vendedor->nome', "Vendedor", 'left');
        $column_dt_venda_transformed = new TDataGridColumn('dt_venda', "Data", 'left');
        $column_frete_transformed = new TDataGridColumn('frete', "Frete", 'left');
        $column_valor_total_transformed = new TDataGridColumn('valor_total', "Valor total", 'left');
        $column_estado_venda_nome = new TDataGridColumn('estado_venda->nome', "Estado venda", 'left');

        $column_dt_venda_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!empty(trim($value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });

        $column_frete_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_valor_total_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_cliente_nome);
        $this->datagrid->addColumn($column_vendedor_nome);
        $this->datagrid->addColumn($column_dt_venda_transformed);
        $this->datagrid->addColumn($column_frete_transformed);
        $this->datagrid->addColumn($column_valor_total_transformed);
        $this->datagrid->addColumn($column_estado_venda_nome);

        $action_group = new TDataGridActionGroup("", 'fas:cog');
        $action_group->addHeader('');

        $action_onShow = new TDataGridAction(array('VendaFormView', 'onShow'));
        $action_onShow->setUseButton(TRUE);
        $action_onShow->setButtonClass('btn btn-default');
        $action_onShow->setLabel("Visualizar");
        $action_onShow->setImage('fas:search-plus #478fca');
        $action_onShow->setField(self::$primaryKey);

        $action_group->addAction($action_onShow);

        $action_onDelete = new TDataGridAction(array('VendaList', 'onDelete'));
        $action_onDelete->setUseButton(TRUE);
        $action_onDelete->setButtonClass('btn btn-default');
        $action_onDelete->setLabel("Deletar");
        $action_onDelete->setImage('far:trash-alt #dd5a43');
        $action_onDelete->setField(self::$primaryKey);

        $action_group->addAction($action_onDelete);

        $action_onCancelarVenda = new TDataGridAction(array('VendaList', 'onCancelarVenda'));
        $action_onCancelarVenda->setUseButton(TRUE);
        $action_onCancelarVenda->setButtonClass('btn btn-default');
        $action_onCancelarVenda->setLabel("Cancelar venda");
        $action_onCancelarVenda->setImage('fas:times #e82222');
        $action_onCancelarVenda->setField(self::$primaryKey);
        $action_onCancelarVenda->setDisplayCondition('VendaList::onShowCancelarVenda');

        $action_group->addAction($action_onCancelarVenda);

        $action_onFecharVenda = new TDataGridAction(array('VendaList', 'onFecharVenda'));
        $action_onFecharVenda->setUseButton(TRUE);
        $action_onFecharVenda->setButtonClass('btn btn-default');
        $action_onFecharVenda->setLabel("Fechar venda");
        $action_onFecharVenda->setImage('fas:flag-checkered #000000');
        $action_onFecharVenda->setField(self::$primaryKey);
        $action_onFecharVenda->setDisplayCondition('VendaList::onShowFecharVenda');

        $action_group->addAction($action_onFecharVenda);

        $action_onGenerate = new TDataGridAction(array('VendaDocument', 'onGenerate'));
        $action_onGenerate->setUseButton(TRUE);
        $action_onGenerate->setButtonClass('btn btn-default');
        $action_onGenerate->setLabel("Gerar documento");
        $action_onGenerate->setImage('far:file-alt #000000');
        $action_onGenerate->setField(self::$primaryKey);

        $action_group->addAction($action_onGenerate);

        $this->datagrid->addActionGroup($action_group);    

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup();
        $panel->datagrid = 'datagrid-container';
        $this->datagridPanel = $panel;
        $this->datagrid_form->add($this->datagrid);
        $panel->add($this->datagrid_form);

        $panel->addFooter($this->pageNavigation);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        }
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

    }

    public function onDelete($param = null) 
    { 
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                // get the paramseter $key
                $key=$param['key'];
                // open a transaction with database
                TTransaction::open(self::$database);

                $class = self::$activeRecord;

                // instantiates object
                $object = new $class($key, FALSE);

                // deletes the object from the database
                $object->delete();

                // close the transaction
                TTransaction::close();

                // reload the listing
                $this->onReload( $param );
                // shows the success message
                new TMessage('info', AdiantiCoreTranslator::translate('Record deleted'));
            }
            catch (Exception $e) // in case of exception
            {
                // shows the exception error message
                new TMessage('error', $e->getMessage());
                // undo all pending operations
                TTransaction::rollback();
            }
        }
        else
        {
            // define the delete action
            $action = new TAction(array($this, 'onDelete'));
            $action->setParameters($param); // pass the key paramseter ahead
            $action->setParameter('delete', 1);
            // shows a dialog to the user
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
        }
    }
    public function onCancelarVenda($param = null) 
    {
        try 
        {
            // Código gerado pelo snippet: "Questionamento"
            new TQuestion("Você tem certeza que deseja cancelar a venda ?", new TAction([$this, 'onCancelarVendaOnYes'], $param), new TAction([$this, 'onCancelarVendaOnNo'], $param));
            // -----

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onCancelarVendaOnYes($param = null)
    {
        // Código gerado pelo snippet: "Questionamento"
        try
        {
            TTransaction::open('mini_erp');

            $venda = new Venda((int)$param['key']);

            if($venda->estado_venda_id != EstadoVenda::finalizada)
            {
                $venda->estado_venda_id = EstadoVenda::cancelada;
                $venda->store();

                new TMessage('info', 'Venda cancelada com sucesso', new TAction(['VendaList', 'onReload']));
            }
            else
            {
                new TMessage('info', 'Essa venda não pode ser cancelada pois ela já foi finalizada');
            }

            TTransaction::close();
        }
        catch(Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public static function onCancelarVendaOnNo($param = null)
    {
        // Código gerado pelo snippet: "Questionamento"
        try
        {

        }
        catch(Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    public static function onShowCancelarVenda($object)
    {
        try 
        {
            if($object->estado_venda_id == EstadoVenda::nova )
            {
                return true;
            }

            return false;
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onFecharVenda($param = null) 
    {
        try 
        {
            // Código gerado pelo snippet: "Questionamento"
            new TQuestion("Você tem certeza que deseja fechar a venda ?", new TAction([$this, 'onFecharVendaOnYes'], $param), new TAction([$this, 'onFecharVendaOnNo'], $param));
            // -----
            //code here

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onFecharVendaOnYes($param = null)
    {
        // Código gerado pelo snippet: "Questionamento"
        try
        {
            TTransaction::open('mini_erp');
            $venda = new Venda((int)$param['key']);

            if($venda->estado_venda_id == EstadoVenda::finalizada)
            {
                throw new Exception("A venda já está fechada");
            }
            elseif($venda->estado_venda_id == EstadoVenda::cancelada)
            {
                throw new Exception("A venda está cancelada");
            }

            $itens = $venda->getVendaItems();

            if($itens)
            {
                foreach($itens as $item)
                {
                    $produto = $item->produto;
                    if($produto->qtde_estoque > $produto->estoque_minimo  && $produto->qtde_estoque > $item->quantidade)
                    {
                        $produto->qtde_estoque = $produto->qtde_estoque - $item->quantidade; 
                        $produto->store();
                    }
                    else
                    {
                        throw new Exception("Verifique o estoque do produto: {$produto->nome}, pois ele não possui o estoque necessário para realizar a baixa dos item da venda.");
                    }
                }
            }

            $venda->estado_venda_id = EstadoVenda::finalizada;
            $venda->store();

            TTransaction::close();
            // -----
            new TMessage('info', "Venda fechada com sucesso!", new TAction([__CLASS__, 'onReload']));
        }
        catch(Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public static function onFecharVendaOnNo($param = null)
    {
        // Código gerado pelo snippet: "Questionamento"
        try
        {

        }
        catch(Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    public static function onShowFecharVenda($object)
    {
        try 
        {
           if($object->estado_venda_id == EstadoVenda::nova)
           {
                return true;
           }        
           return false;
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onExportCsv($param = null) 
    {
        try
        {
            $this->onSearch();

            TTransaction::open(self::$database); // open a transaction
            $repository = new TRepository(self::$activeRecord); // creates a repository for Customer
            $criteria = new TCriteria; // creates a criteria

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            $records = $repository->load($criteria); // load the objects according to criteria
            if ($records)
            {
                $file = 'tmp/'.uniqid().'.csv';
                $handle = fopen($file, 'w');
                $columns = $this->datagrid->getColumns();

                $csvColumns = [];
                foreach($columns as $column)
                {
                    $csvColumns[] = $column->getLabel();
                }
                fputcsv($handle, $csvColumns, ';');

                foreach ($records as $record)
                {
                    $csvColumns = [];
                    foreach($columns as $column)
                    {
                        $name = $column->getName();
                        $csvColumns[] = $record->{$name};
                    }
                    fputcsv($handle, $csvColumns, ';');
                }
                fclose($handle);

                TPage::openFile($file);
            }
            else
            {
                new TMessage('info', _t('No records found'));       
            }

            TTransaction::close(); // close the transaction
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Register the filter in the session
     */
    public function onSearch($param = null)
    {
        $data = $this->form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->id) AND ( (is_scalar($data->id) AND $data->id !== '') OR (is_array($data->id) AND (!empty($data->id)) )) )
        {

            $filters[] = new TFilter('id', '=', $data->id);// create the filter 
        }

        if (isset($data->estado_venda_id) AND ( (is_scalar($data->estado_venda_id) AND $data->estado_venda_id !== '') OR (is_array($data->estado_venda_id) AND (!empty($data->estado_venda_id)) )) )
        {

            $filters[] = new TFilter('estado_venda_id', '=', $data->estado_venda_id);// create the filter 
        }

        if (isset($data->cliente_id) AND ( (is_scalar($data->cliente_id) AND $data->cliente_id !== '') OR (is_array($data->cliente_id) AND (!empty($data->cliente_id)) )) )
        {

            $filters[] = new TFilter('cliente_id', '=', $data->cliente_id);// create the filter 
        }

        if (isset($data->vendedor_id) AND ( (is_scalar($data->vendedor_id) AND $data->vendedor_id !== '') OR (is_array($data->vendedor_id) AND (!empty($data->vendedor_id)) )) )
        {

            $filters[] = new TFilter('vendedor_id', '=', $data->vendedor_id);// create the filter 
        }

        if (isset($data->dt_venda) AND ( (is_scalar($data->dt_venda) AND $data->dt_venda !== '') OR (is_array($data->dt_venda) AND (!empty($data->dt_venda)) )) )
        {

            $filters[] = new TFilter('dt_venda', '>=', $data->dt_venda);// create the filter 
        }

        if (isset($data->data_final) AND ( (is_scalar($data->data_final) AND $data->data_final !== '') OR (is_array($data->data_final) AND (!empty($data->data_final)) )) )
        {

            $filters[] = new TFilter('dt_venda', '<=', $data->data_final);// create the filter 
        }

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        $this->onReload(['offset' => 0, 'first_page' => 1]);
    }

    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'mini_erp'
            TTransaction::open(self::$database);

            // creates a repository for Venda
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $this->limit);

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->id}";

                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($this->limit); // limit

            // close the transaction
            TTransaction::close();
            $this->loaded = true;

            return $objects;
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    public function onShow($param = null)
    {

    }

    /**
     * method show()
     * Shows the page
     */
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  $this->showMethods))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
        }
        parent::show();
    }

    public static function manageRow($id)
    {
        $list = new self([]);

        $openTransaction = TTransaction::getDatabase() != self::$database ? true : false;

        if($openTransaction)
        {
            TTransaction::open(self::$database);    
        }

        $object = new Venda($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->id}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

