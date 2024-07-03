<?php

class ProdutoReport extends TPage
{
    private $form; // form
    private $loaded;
    private static $database = 'mini_erp';
    private static $activeRecord = 'Produto';
    private static $primaryKey = 'id';
    private static $formName = 'formReport_Produto';

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Relatório de produtos");

        $criteria_tipo_produto_id = new TCriteria();
        $criteria_fornecedor_id = new TCriteria();
        $criteria_unidade_id = new TCriteria();

        $filterVar = Grupo::fornecedores;
        $criteria_fornecedor_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_id in  (SELECT id FROM grupo WHERE id = '{$filterVar}') )")); 

        $id = new TEntry('id');
        $tipo_produto_id = new TDBCombo('tipo_produto_id', 'mini_erp', 'TipoProduto', 'id', '{nome}','nome asc' , $criteria_tipo_produto_id );
        $nome = new TEntry('nome');
        $fornecedor_id = new TDBCombo('fornecedor_id', 'mini_erp', 'Pessoa', 'id', '{nome}','nome asc' , $criteria_fornecedor_id );
        $unidade_id = new TDBCombo('unidade_id', 'mini_erp', 'Unidade', 'id', '{nome}','nome asc' , $criteria_unidade_id );
        $cod_barras = new TEntry('cod_barras');
        $qtde_estoque = new TNumeric('qtde_estoque', '2', ',', '.' );
        $estoque_menor = new TNumeric('estoque_menor', '2', ',', '.' );
        $dt_cadastro = new TDate('dt_cadastro');
        $data_final = new TDate('data_final');

        $data_final->setMask('dd/mm/yyyy');
        $dt_cadastro->setMask('dd/mm/yyyy');

        $data_final->setDatabaseMask('yyyy-mm-dd');
        $dt_cadastro->setDatabaseMask('yyyy-mm-dd');

        $id->setSize(100);
        $nome->setSize('100%');
        $data_final->setSize(150);
        $dt_cadastro->setSize(150);
        $unidade_id->setSize('100%');
        $cod_barras->setSize('100%');
        $qtde_estoque->setSize('100%');
        $fornecedor_id->setSize('100%');
        $estoque_menor->setSize('100%');
        $tipo_produto_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id],[new TLabel("Tipo do produto:", null, '14px', null)],[$tipo_produto_id]);
        $row2 = $this->form->addFields([new TLabel("Nome:", null, '14px', null)],[$nome],[new TLabel("Fornecedor:", null, '14px', null)],[$fornecedor_id]);
        $row3 = $this->form->addFields([new TLabel("Unidade de medida:", null, '14px', null)],[$unidade_id],[new TLabel("Código de barras:", null, '14px', null)],[$cod_barras]);
        $row4 = $this->form->addFields([new TLabel("Estoque maior de:", null, '14px', null)],[$qtde_estoque],[new TLabel("Estoque menor de:", null, '14px', null)],[$estoque_menor]);
        $row5 = $this->form->addFields([new TLabel("Data cadastro (de):", null, '14px', null)],[$dt_cadastro],[new TLabel("Data cadastro (até):", null, '14px', null)],[$data_final]);

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_ongeneratehtml = $this->form->addAction("Gerar HTML", new TAction([$this, 'onGenerateHtml']), 'fas:code #ffffff');
        $this->btn_ongeneratehtml = $btn_ongeneratehtml;
        $btn_ongeneratehtml->addStyleClass('btn-primary'); 

        $btn_ongeneratepdf = $this->form->addAction("Gerar PDF", new TAction([$this, 'onGeneratePdf']), 'far:file-pdf #d44734');
        $this->btn_ongeneratepdf = $btn_ongeneratepdf;

        $btn_ongeneratertf = $this->form->addAction("Gerar RTF", new TAction([$this, 'onGenerateRtf']), 'far:file-alt #324bcc');
        $this->btn_ongeneratertf = $btn_ongeneratertf;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        $container->add(TBreadCrumb::create(["Relatórios","Produtos"]));
        $container->add($this->form);

        parent::add($container);

    }

    public function onGenerateHtml($param = null) 
    {
        $this->onGenerate('html');
    }

    public function onGeneratePdf($param = null) 
    {
        $this->onGenerate('pdf');
    }

    public function onGenerateRtf($param = null) 
    {
        $this->onGenerate('rtf');
    }

    /**
     * Register the filter in the session
     */
    public function getFilters()
    {
        // get the search form data
        $data = $this->form->getData();

        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->id) AND ( (is_scalar($data->id) AND $data->id !== '') OR (is_array($data->id) AND (!empty($data->id)) )) )
        {

            $filters[] = new TFilter('id', '=', $data->id);// create the filter 
        }
        if (isset($data->tipo_produto_id) AND ( (is_scalar($data->tipo_produto_id) AND $data->tipo_produto_id !== '') OR (is_array($data->tipo_produto_id) AND (!empty($data->tipo_produto_id)) )) )
        {

            $filters[] = new TFilter('tipo_produto_id', '=', $data->tipo_produto_id);// create the filter 
        }
        if (isset($data->nome) AND ( (is_scalar($data->nome) AND $data->nome !== '') OR (is_array($data->nome) AND (!empty($data->nome)) )) )
        {

            $filters[] = new TFilter('nome', 'like', "%{$data->nome}%");// create the filter 
        }
        if (isset($data->fornecedor_id) AND ( (is_scalar($data->fornecedor_id) AND $data->fornecedor_id !== '') OR (is_array($data->fornecedor_id) AND (!empty($data->fornecedor_id)) )) )
        {

            $filters[] = new TFilter('fornecedor_id', '=', $data->fornecedor_id);// create the filter 
        }
        if (isset($data->unidade_id) AND ( (is_scalar($data->unidade_id) AND $data->unidade_id !== '') OR (is_array($data->unidade_id) AND (!empty($data->unidade_id)) )) )
        {

            $filters[] = new TFilter('unidade_id', '=', $data->unidade_id);// create the filter 
        }
        if (isset($data->cod_barras) AND ( (is_scalar($data->cod_barras) AND $data->cod_barras !== '') OR (is_array($data->cod_barras) AND (!empty($data->cod_barras)) )) )
        {

            $filters[] = new TFilter('cod_barras', 'like', "%{$data->cod_barras}%");// create the filter 
        }
        if (isset($data->qtde_estoque) AND ( (is_scalar($data->qtde_estoque) AND $data->qtde_estoque !== '') OR (is_array($data->qtde_estoque) AND (!empty($data->qtde_estoque)) )) )
        {

            $filters[] = new TFilter('qtde_estoque', '=', $data->qtde_estoque);// create the filter 
        }
        if (isset($data->estoque_menor) AND ( (is_scalar($data->estoque_menor) AND $data->estoque_menor !== '') OR (is_array($data->estoque_menor) AND (!empty($data->estoque_menor)) )) )
        {

            $filters[] = new TFilter('qtde_estoque', '<=', $data->estoque_menor);// create the filter 
        }
        if (isset($data->dt_cadastro) AND ( (is_scalar($data->dt_cadastro) AND $data->dt_cadastro !== '') OR (is_array($data->dt_cadastro) AND (!empty($data->dt_cadastro)) )) )
        {

            $filters[] = new TFilter('dt_cadastro', '>=', $data->dt_cadastro);// create the filter 
        }
        if (isset($data->data_final) AND ( (is_scalar($data->data_final) AND $data->data_final !== '') OR (is_array($data->data_final) AND (!empty($data->data_final)) )) )
        {

            $filters[] = new TFilter('dt_cadastro', '<=', $data->data_final);// create the filter 
        }

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);

        return $filters;
    }

    public function onGenerate($format)
    {
        try
        {
            $filters = $this->getFilters();
            // open a transaction with database 'mini_erp'
            TTransaction::open(self::$database);
            $param = [];
            // creates a repository for Produto
            $repository = new TRepository(self::$activeRecord);
            // creates a criteria
            $criteria = new TCriteria;

            $criteria->setProperties($param);

            if ($filters)
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            if ($objects)
            {
                $widths = array(200,200,200,200,200,200,200,200,200,200,200,200,200,200,200);
                $reportExtension = 'pdf';
                switch ($format)
                {
                    case 'html':
                        $tr = new TTableWriterHTML($widths);
                        $reportExtension = 'html';
                        break;
                    case 'xls':
                        $tr = new TTableWriterXLS($widths);
                        $reportExtension = 'xls';
                        break;
                    case 'pdf':
                        $tr = new TTableWriterPDF($widths, 'L', 'A4');
                        $reportExtension = 'pdf';
                        break;
                    case 'htmlPdf':
                        $reportExtension = 'pdf';
                        $tr = new BTableWriterHtmlPDF($widths, 'L', 'A4');
                        break;
                    case 'rtf':
                        if (!class_exists('PHPRtfLite_Autoloader'))
                        {
                            PHPRtfLite::registerAutoloader();
                        }
                        $reportExtension = 'rtf';
                        $tr = new TTableWriterRTF($widths, 'L', 'A4');
                        break;
                }

                if (!empty($tr))
                {
                    // create the document styles
                    $tr->addStyle('title', 'Helvetica', '10', 'B',   '#000000', '#dbdbdb');
                    $tr->addStyle('datap', 'Arial', '10', '',    '#333333', '#f0f0f0');
                    $tr->addStyle('datai', 'Arial', '10', '',    '#333333', '#ffffff');
                    $tr->addStyle('header', 'Helvetica', '16', 'B',   '#5a5a5a', '#6B6B6B');
                    $tr->addStyle('footer', 'Helvetica', '10', 'B',  '#5a5a5a', '#A3A3A3');
                    $tr->addStyle('break', 'Helvetica', '10', 'B',  '#ffffff', '#9a9a9a');
                    $tr->addStyle('total', 'Helvetica', '10', 'I',  '#000000', '#c7c7c7');
                    $tr->addStyle('breakTotal', 'Helvetica', '10', 'I',  '#000000', '#c6c8d0');

                    // add titles row
                    $tr->addRow();
                    $tr->addCell("Id", 'left', 'title');
                    $tr->addCell("Unidade de medida", 'left', 'title');
                    $tr->addCell("Tipo", 'left', 'title');
                    $tr->addCell("Fornecedor", 'left', 'title');
                    $tr->addCell("Nome", 'left', 'title');
                    $tr->addCell("Data de cadastro", 'left', 'title');
                    $tr->addCell("Código de barras", 'left', 'title');
                    $tr->addCell("Preço de custo", 'left', 'title');
                    $tr->addCell("Preço de venda", 'left', 'title');
                    $tr->addCell("Peso líquido", 'left', 'title');
                    $tr->addCell("Peso bruto", 'left', 'title');
                    $tr->addCell("Estoque mínimo", 'left', 'title');
                    $tr->addCell("Estoque máximo", 'left', 'title');
                    $tr->addCell("Estoque atual", 'left', 'title');
                    $tr->addCell("Nova coluna", 'left', 'title');

                    $grandTotal = [];
                    $breakTotal = [];
                    $breakValue = null;
                    $firstRow = true;

                    // controls the background filling
                    $colour = false;                
                    foreach ($objects as $object)
                    {
                        $style = $colour ? 'datap' : 'datai';

                        $firstRow = false;

                        $object->dt_cadastro = call_user_func(function($value, $object, $row) 
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
                        }, $object->dt_cadastro, $object, null);

                        $object->preco_custo = call_user_func(function($value, $object, $row) 
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
                        }, $object->preco_custo, $object, null);

                        $object->preco_venda = call_user_func(function($value, $object, $row) 
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
                        }, $object->preco_venda, $object, null);

                        $tr->addRow();

                        $tr->addCell($object->id, 'left', $style);
                        $tr->addCell($object->unidade->nome, 'left', $style);
                        $tr->addCell($object->tipo_produto->nome, 'left', $style);
                        $tr->addCell($object->fornecedor->nome, 'left', $style);
                        $tr->addCell($object->nome, 'left', $style);
                        $tr->addCell($object->dt_cadastro, 'left', $style);
                        $tr->addCell($object->cod_barras, 'left', $style);
                        $tr->addCell($object->preco_custo, 'left', $style);
                        $tr->addCell($object->preco_venda, 'left', $style);
                        $tr->addCell($object->peso_liquido, 'left', $style);
                        $tr->addCell($object->peso_bruto, 'left', $style);
                        $tr->addCell($object->estoque_minimo, 'left', $style);
                        $tr->addCell($object->estoque_maximo, 'left', $style);
                        $tr->addCell($object->qtde_estoque, 'left', $style);
                        $tr->addCell($object->id, 'left', $style);

                        $colour = !$colour;

                    }

                    $file = 'report_'.uniqid().".{$reportExtension}";
                    // stores the file
                    if (!file_exists("app/output/{$file}") || is_writable("app/output/{$file}"))
                    {
                        $tr->save("app/output/{$file}");
                    }
                    else
                    {
                        throw new Exception(_t('Permission denied') . ': ' . "app/output/{$file}");
                    }

                    parent::openFile("app/output/{$file}");

                    // shows the success message
                    new TMessage('info', _t('Report generated. Please, enable popups'));
                }
            }
            else
            {
                new TMessage('error', _t('No records found'));
            }

            // close the transaction
            TTransaction::close();
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


}

