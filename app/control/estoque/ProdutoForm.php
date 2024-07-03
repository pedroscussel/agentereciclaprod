<?php

class ProdutoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'mini_erp';
    private static $activeRecord = 'Produto';
    private static $primaryKey = 'id';
    private static $formName = 'form_Produto';

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
        $this->form->setFormTitle("Cadastro de produto");

        $criteria_tipo_produto_id = new TCriteria();
        $criteria_fornecedor_id = new TCriteria();
        $criteria_unidade_id = new TCriteria();

        $filterVar = Grupo::fornecedores;
        $criteria_fornecedor_id->add(new TFilter('id', 'in', "(SELECT pessoa_id FROM pessoa_grupo WHERE grupo_id in  (SELECT id FROM grupo WHERE id = '{$filterVar}') )")); 

        $id = new TEntry('id');
        $dt_cadastro = new TDate('dt_cadastro');
        $nome = new TEntry('nome');
        $tipo_produto_id = new TDBCombo('tipo_produto_id', 'mini_erp', 'TipoProduto', 'id', '{nome}','nome asc' , $criteria_tipo_produto_id );
        $fornecedor_id = new TDBCombo('fornecedor_id', 'mini_erp', 'Pessoa', 'id', '{nome}','nome asc' , $criteria_fornecedor_id );
        $cod_barras = new TEntry('cod_barras');
        $unidade_id = new TDBCombo('unidade_id', 'mini_erp', 'Unidade', 'id', '{nome}','id asc' , $criteria_unidade_id );
        $peso_liquido = new TNumeric('peso_liquido', '2', ',', '.' );
        $peso_bruto = new TNumeric('peso_bruto', '2', ',', '.' );
        $preco_custo = new TNumeric('preco_custo', '2', ',', '.' );
        $preco_venda = new TNumeric('preco_venda', '2', ',', '.' );
        $estoque_minimo = new TNumeric('estoque_minimo', '2', ',', '.' );
        $estoque_maximo = new TNumeric('estoque_maximo', '2', ',', '.' );
        $qtde_estoque = new TNumeric('qtde_estoque', '2', ',', '.' );
        $obs = new TText('obs');

        $dt_cadastro->addValidation("Data de cadastro", new TRequiredValidator()); 
        $nome->addValidation("Nome", new TRequiredValidator()); 
        $tipo_produto_id->addValidation("Tipo do produto", new TRequiredValidator()); 
        $fornecedor_id->addValidation("Fornecedor", new TRequiredValidator()); 
        $unidade_id->addValidation("Unidade de medida", new TRequiredValidator()); 
        $peso_liquido->addValidation("Peso líquido", new TRequiredValidator()); 
        $peso_bruto->addValidation("Peso bruto", new TRequiredValidator()); 
        $preco_custo->addValidation("Preço de custo", new TRequiredValidator()); 
        $preco_venda->addValidation("Preço de venda", new TRequiredValidator()); 
        $estoque_minimo->addValidation("Estoque mínimo", new TRequiredValidator()); 
        $estoque_maximo->addValidation("Estoque máximo", new TRequiredValidator()); 
        $qtde_estoque->addValidation("Estoque atual", new TRequiredValidator()); 

        $id->setEditable(false);
        $dt_cadastro->setMask('dd/mm/yyyy');
        $dt_cadastro->setValue(date('d/m/Y'));
        $dt_cadastro->setDatabaseMask('yyyy-mm-dd');
        $unidade_id->enableSearch();
        $fornecedor_id->enableSearch();
        $tipo_produto_id->enableSearch();

        $id->setSize(100);
        $nome->setSize('100%');
        $obs->setSize('100%', 80);
        $dt_cadastro->setSize(150);
        $cod_barras->setSize('100%');
        $unidade_id->setSize('100%');
        $peso_bruto->setSize('100%');
        $preco_custo->setSize('100%');
        $preco_venda->setSize('100%');
        $peso_liquido->setSize('100%');
        $qtde_estoque->setSize('100%');
        $fornecedor_id->setSize('100%');
        $estoque_minimo->setSize('100%');
        $estoque_maximo->setSize('100%');
        $tipo_produto_id->setSize('100%');


        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id],[new TLabel("Data de cadastro:", '#ff0000', '14px', null)],[$dt_cadastro]);
        $row2 = $this->form->addContent([new TFormSeparator("Informações gerais", '#333333', '18', '#eeeeee')]);
        $row3 = $this->form->addFields([new TLabel("Nome:", '#ff0000', '14px', null)],[$nome],[new TLabel("Tipo do produto:", '#ff0000', '14px', null)],[$tipo_produto_id]);
        $row4 = $this->form->addFields([new TLabel("Fornecedor:", '#ff0000', '14px', null)],[$fornecedor_id],[new TLabel("Código de barras:", null, '14px', null)],[$cod_barras]);
        $row5 = $this->form->addContent([new TFormSeparator("Preços e pesos", '#333333', '18', '#eeeeee')]);
        $row6 = $this->form->addFields([new TLabel("Unidade de medida:", '#ff0000', '14px', null)],[$unidade_id],[],[]);
        $row7 = $this->form->addFields([new TLabel("Peso líquido:", '#ff0000', '14px', null)],[$peso_liquido],[new TLabel("Peso bruto:", '#ff0000', '14px', null)],[$peso_bruto]);
        $row8 = $this->form->addFields([new TLabel("Preço de custo:", '#ff0000', '14px', null)],[$preco_custo],[new TLabel("Preço de venda:", '#ff0000', '14px', null)],[$preco_venda]);
        $row9 = $this->form->addContent([new TFormSeparator("Informações do estoque", '#333333', '18', '#eeeeee')]);
        $row10 = $this->form->addFields([new TLabel("Estoque mínimo:", '#ff0000', '14px', null)],[$estoque_minimo],[new TLabel("Estoque máximo:", '#ff0000', '14px', null)],[$estoque_maximo]);
        $row11 = $this->form->addFields([new TLabel("Estoque atual:", '#ff0000', '14px', null)],[$qtde_estoque],[new TLabel("Observação:", null, '14px', null)],[$obs]);

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

            $object = new Produto(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $messageAction = new TAction(['ProdutoList', 'onShow']);   

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

                $object = new Produto($key); // instantiates the Active Record 

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

