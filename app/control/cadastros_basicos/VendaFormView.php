<?php

class VendaFormView extends TPage
{
    protected $form; // form
    private static $database = 'mini_erp';
    private static $activeRecord = 'Venda';
    private static $primaryKey = 'id';
    private static $formName = 'formView_Venda';

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

        TTransaction::open(self::$database);
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        $this->form->setTagName('div');

        $venda = new Venda($param['key']);
        // define the form title
        $this->form->setFormTitle("Venda");

        $label1 = new TLabel("Id:", '', '12px', '');
        $text1 = new TTextDisplay($venda->id, '', '12px', '');
        $label23 = new TLabel("Estado da venda:", '', '12px', '');
        $text4 = new TTextDisplay($venda->estado_venda->nome, '', '12px', '');
        $label2 = new TLabel("Cliente:", '', '12px', '');
        $text2 = new TTextDisplay($venda->cliente->nome, '', '12px', '');
        $label44 = new TLabel("Vendedor:", '', '12px', '');
        $text3 = new TTextDisplay($venda->vendedor->nome, '', '12px', '');
        $label5 = new TLabel("Data da venda:", '', '12px', '');
        $text5 = new TTextDisplay(TDateTime::convertToMask($venda->dt_venda, 'yyyy-mm-dd hh:ii', 'dd/mm/yyyy hh:ii'), '', '12px', '');
        $label6 = new TLabel("Observação:", '', '12px', '');
        $text6 = new TTextDisplay($venda->obs, '', '12px', '');
        $label7 = new TLabel("Valor do frete:", '', '12px', '');
        $text7 = new TTextDisplay(number_format((double)$venda->frete, '2', ',', '.'), '', '12px', '');
        $label8 = new TLabel("Valor total:", '', '12px', '');
        $text8 = new TTextDisplay(number_format((double)$venda->valor_total, '2', ',', '.'), '', '12px', '');

        $row1 = $this->form->addFields([$label1],[$text1],[$label23],[$text4]);
        $row2 = $this->form->addFields([$label2],[$text2],[$label44],[$text3]);
        $row3 = $this->form->addFields([$label5],[$text5],[$label6],[$text6]);
        $row4 = $this->form->addFields([$label7],[$text7],[$label8],[$text8]);

        $this->venda_item_venda_id_list = new TQuickGrid;
        $this->venda_item_venda_id_list->disableHtmlConversion();
        $this->venda_item_venda_id_list->style = 'width:100%';
        $this->venda_item_venda_id_list->disableDefaultClick();

        $column_id = $this->venda_item_venda_id_list->addQuickColumn("Id", 'id', 'left');
        $column_venda_id = $this->venda_item_venda_id_list->addQuickColumn("Código da venda", 'venda_id', 'left');
        $column_produto_id = $this->venda_item_venda_id_list->addQuickColumn("Produto", 'produto_id', 'left');
        $column_quantidade_transformed = $this->venda_item_venda_id_list->addQuickColumn("Quantidade", 'quantidade', 'left');
        $column_desconto_transformed = $this->venda_item_venda_id_list->addQuickColumn("Desconto", 'desconto', 'left');
        $column_valor_transformed = $this->venda_item_venda_id_list->addQuickColumn("Valor", 'valor', 'left');
        $column_calculated_4 = $this->venda_item_venda_id_list->addQuickColumn("Valor total", '=( ( {valor} - {desconto} ) * {quantidade}  )', 'left');

        $column_quantidade_transformed->setTotalFunction( function($values) { 
            return array_sum((array) $values); 
        }); 

        $column_desconto_transformed->setTotalFunction( function($values) { 
            return array_sum((array) $values); 
        }); 

        $column_valor_transformed->setTotalFunction( function($values) { 
            return array_sum((array) $values); 
        }); 

        $column_calculated_4->setTotalFunction( function($values) { 
            return array_sum((array) $values); 
        }); 

        $column_quantidade_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_desconto_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_valor_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_calculated_4->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $this->venda_item_venda_id_list->createModel();

        $criteria_venda_item_venda_id = new TCriteria();
        $criteria_venda_item_venda_id->add(new TFilter('venda_id', '=', $venda->id));

        $venda_item_venda_id_items = VendaItem::getObjects($criteria_venda_item_venda_id);

        $this->venda_item_venda_id_list->addItems($venda_item_venda_id_items);

        $icon = new TImage('fas:cubes #000000');
        $title = new TTextDisplay("{$icon} Itens da venda", '#333333', '15px', '{$fontStyle}');

        $panel = new TPanelGroup($title, '#f5f5f5');
        $panel->class = 'panel panel-default formView-detail';
        $panel->add(new BootstrapDatagridWrapper($this->venda_item_venda_id_list));

        $this->form->addContent([$panel]);

        $btnVendaFormOnEditAction = new TAction(['VendaForm', 'onEdit'],['key'=>$venda->id]);
        $btnVendaFormOnEditLabel = new TLabel("Editar");

        $btnVendaFormOnEdit = $this->form->addHeaderAction($btnVendaFormOnEditLabel, $btnVendaFormOnEditAction, 'far:edit #000000'); 
        $btnVendaFormOnEditLabel->setFontSize('12px'); 
        $btnVendaFormOnEditLabel->setFontColor('#333333'); 

        $btnVendaFormOnShowAction = new TAction(['VendaForm', 'onShow']);
        $btnVendaFormOnShowLabel = new TLabel("Nova");

        $btnVendaFormOnShow = $this->form->addHeaderAction($btnVendaFormOnShowLabel, $btnVendaFormOnShowAction, 'fas:plus #000000'); 
        $btnVendaFormOnShowLabel->setFontSize('12px'); 
        $btnVendaFormOnShowLabel->setFontColor('#333333'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        }
        $container->add($this->form);

        TTransaction::close();
        parent::add($container);

    }

    public function onShow($param = null)
    {     

    }

}

