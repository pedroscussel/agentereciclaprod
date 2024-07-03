<?php

class ProdutoBarCode extends TPage
{
    private static $database = 'mini_erp';
    private static $activeRecord = 'Produto';
    private static $primaryKey = 'id';
    private static $formName = 'formBarcode_Produto';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct($param = null)
    {
        parent::__construct();

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Geração de etiquetas de código de barras de produtos");

        $criteria_tipo_produto_id = new TCriteria();
        $criteria_unidade_id = new TCriteria();
        $criteria_fornecedor_id = new TCriteria();

        $filterVar = Grupo::fornecedores;
        $criteria_fornecedor_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_id in  (SELECT id FROM grupo WHERE id = '{$filterVar}') )")); 

        $id = new TEntry('id');
        $cod_barras = new TEntry('cod_barras');
        $nome = new TEntry('nome');
        $tipo_produto_id = new TDBCombo('tipo_produto_id', 'mini_erp', 'TipoProduto', 'id', '{nome}','nome asc' , $criteria_tipo_produto_id );
        $unidade_id = new TDBCombo('unidade_id', 'mini_erp', 'Unidade', 'id', '{nome}','nome asc' , $criteria_unidade_id );
        $fornecedor_id = new TDBCombo('fornecedor_id', 'mini_erp', 'Pessoa', 'id', '{nome}','nome asc' , $criteria_fornecedor_id );

        $id->setSize(100);
        $nome->setSize('100%');
        $cod_barras->setSize('100%');
        $unidade_id->setSize('100%');
        $fornecedor_id->setSize('100%');
        $tipo_produto_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id],[new TLabel("Código de barras:", null, '14px', null)],[$cod_barras]);
        $row2 = $this->form->addFields([new TLabel("Nome:", null, '14px', null)],[$nome],[new TLabel("Tipo do produto:", null, '14px', null)],[$tipo_produto_id]);
        $row3 = $this->form->addFields([new TLabel("Unidade de medida:", null, '14px', null)],[$unidade_id],[new TLabel("Fornecedor:", null, '14px', null)],[$fornecedor_id]);

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_ongenerate = $this->form->addAction("Gerar", new TAction([$this, 'onGenerate']), 'fas:cog #ffffff');
        $this->btn_ongenerate = $btn_ongenerate;
        $btn_ongenerate->addStyleClass('btn-primary'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);

        parent::add($container);

    }

    public function onGenerate($param)
    {
        try 
        {
            TTransaction::open(self::$database);

            $data = $this->form->getData();
            $criteria = new TCriteria();

            if (isset($data->id) AND ( (is_scalar($data->id) AND $data->id !== '') OR (is_array($data->id) AND (!empty($data->id)) )) ) 
            {

                $criteria->add(new TFilter('id', '=', $data->id));
            }
            if (isset($data->cod_barras) AND ( (is_scalar($data->cod_barras) AND $data->cod_barras !== '') OR (is_array($data->cod_barras) AND (!empty($data->cod_barras)) )) ) 
            {

                $criteria->add(new TFilter('cod_barras', 'like', "%{$data->cod_barras}%"));
            }
            if (isset($data->nome) AND ( (is_scalar($data->nome) AND $data->nome !== '') OR (is_array($data->nome) AND (!empty($data->nome)) )) ) 
            {

                $criteria->add(new TFilter('nome', 'like', "%{$data->nome}%"));
            }
            if (isset($data->tipo_produto_id) AND ( (is_scalar($data->tipo_produto_id) AND $data->tipo_produto_id !== '') OR (is_array($data->tipo_produto_id) AND (!empty($data->tipo_produto_id)) )) ) 
            {

                $criteria->add(new TFilter('tipo_produto_id', '=', $data->tipo_produto_id));
            }
            if (isset($data->unidade_id) AND ( (is_scalar($data->unidade_id) AND $data->unidade_id !== '') OR (is_array($data->unidade_id) AND (!empty($data->unidade_id)) )) ) 
            {

                $criteria->add(new TFilter('unidade_id', '=', $data->unidade_id));
            }
            if (isset($data->fornecedor_id) AND ( (is_scalar($data->fornecedor_id) AND $data->fornecedor_id !== '') OR (is_array($data->fornecedor_id) AND (!empty($data->fornecedor_id)) )) ) 
            {

                $criteria->add(new TFilter('fornecedor_id', '=', $data->fornecedor_id));
            }

            TSession::setValue(__CLASS__.'_filter_data', $data);

            $properties = [];

            $properties['leftMargin']    = 10; // Left margin
            $properties['topMargin']     = 10; // Top margin
            $properties['labelWidth']    = 64; // Label width in mm
            $properties['labelHeight']   = 28; // Label height in mm
            $properties['spaceBetween']  = 4;  // Space between labels
            $properties['rowsPerPage']   = 10;  // Label rows per page
            $properties['colsPerPage']   = 3;  // Label cols per page
            $properties['fontSize']      = 12; // Text font size
            $properties['barcodeHeight'] = 9; // Barcode Height
            $properties['imageMargin']   = 0;
            $properties['barcodeMethod'] = 'EAN13';

            $label  = "<b>{nome} </b>
R$ {preco_venda}
#barcode# ";

            $bcgen = new AdiantiBarcodeDocumentGenerator('p', 'A4');
            $bcgen->setProperties($properties);
            $bcgen->setLabelTemplate($label);

            $class = self::$activeRecord;

            $objects = $class::getObjects($criteria);

            if ($objects)
            {
                foreach ($objects as $object)
                {

                    $bcgen->addObject($object);
                }

                $filename = 'tmp/barcode_'.uniqid().'.pdf';

                $bcgen->setBarcodeContent('{cod_barras}');
                $bcgen->generate();
                $bcgen->save($filename);

                parent::openFile($filename);
                new TMessage('info', _t('Barcodes successfully generated'));
            }
            else
            {
                new TMessage('info', _t('No records found'));   
            }

            TTransaction::close();

            $this->form->setData($data);

        } 
        catch (Exception $e) 
        {
            $this->form->setData($data);

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

