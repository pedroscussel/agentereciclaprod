CREATE TABLE cidade( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      estado_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE conta( 
      id  INT IDENTITY    NOT NULL  , 
      tipo_conta_id int   NOT NULL  , 
      cliente_id int   NOT NULL  , 
      natureza_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
      dt_emissao date   NOT NULL  , 
      dt_vencimento date   NOT NULL  , 
      valor float   NOT NULL  , 
      desconto float   , 
      juros float   , 
      multa float   , 
      obs nvarchar(max)   , 
      quitada char  (1)   NOT NULL    DEFAULT 'f', 
 PRIMARY KEY (id)) ; 

CREATE TABLE contato( 
      id  INT IDENTITY    NOT NULL  , 
      pessoa_id int   NOT NULL  , 
      email nvarchar(max)   NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      telefone nvarchar(max)   , 
      obs nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_negociacao( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      cor nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_orcamento( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_venda( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE historico_negociacao( 
      id  INT IDENTITY    NOT NULL  , 
      negociacao_id int   NOT NULL  , 
      tipo_contato_id int   NOT NULL  , 
      dt_contato datetime2   NOT NULL  , 
      descricao nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE natureza( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao( 
      id  INT IDENTITY    NOT NULL  , 
      cliente_id int   NOT NULL  , 
      vendedor_id int   NOT NULL  , 
      origem_negociacao_id int   NOT NULL  , 
      tipo_negociacao_id int   NOT NULL  , 
      estado_negociacao_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
      dt_inicio_negociacao datetime2   NOT NULL  , 
      dt_fim_negociacao datetime2   , 
      descricao nvarchar(max)   NOT NULL  , 
      obs nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_produto( 
      id  INT IDENTITY    NOT NULL  , 
      produto_id int   NOT NULL  , 
      negociacao_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE orcamento( 
      id  INT IDENTITY    NOT NULL  , 
      cliente_id int   NOT NULL  , 
      vendedor_id int   NOT NULL  , 
      estado_orcamento_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
      dt_orcamento datetime2   NOT NULL  , 
      obs nvarchar(max)   , 
      frete float   , 
      valor_total float   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE orcamento_item( 
      id  INT IDENTITY    NOT NULL  , 
      orcamento_id int   NOT NULL  , 
      produto_id int   NOT NULL  , 
      quantidade float   NOT NULL  , 
      valor float   NOT NULL  , 
      desconto float   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE origem_negociacao( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa( 
      id  INT IDENTITY    NOT NULL  , 
      system_user_id int   , 
      nome nvarchar(max)   NOT NULL  , 
      documento nvarchar(max)   NOT NULL  , 
      obs nvarchar(max)   , 
      fone nvarchar(max)   , 
      email nvarchar(max)   , 
      cidade_id int   NOT NULL  , 
      rua nvarchar(max)   , 
      numero nvarchar(max)   , 
      bairro nvarchar(max)   , 
      complemento nvarchar(max)   , 
      cep nvarchar(max)   , 
      dt_ativacao date   NOT NULL  , 
      dt_desativacao date   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa_grupo( 
      id  INT IDENTITY    NOT NULL  , 
      grupo_id int   NOT NULL  , 
      pessoa_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE produto( 
      id  INT IDENTITY    NOT NULL  , 
      unidade_id int   NOT NULL  , 
      tipo_produto_id int   NOT NULL  , 
      fornecedor_id int   NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      dt_cadastro date   NOT NULL  , 
      cod_barras nvarchar(max)   , 
      preco_custo float   NOT NULL  , 
      preco_venda float   NOT NULL  , 
      peso_liquido float   NOT NULL  , 
      peso_bruto float   NOT NULL  , 
      estoque_minimo float   NOT NULL  , 
      estoque_maximo float   NOT NULL  , 
      qtde_estoque float   NOT NULL  , 
      obs nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE prospeccao( 
      id  INT IDENTITY    NOT NULL  , 
      vendedor_id int   NOT NULL  , 
      cliente_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
      horario_inicial datetime2   NOT NULL  , 
      horario_final datetime2   NOT NULL  , 
      titulo nvarchar(max)   , 
      cor nvarchar(max)   , 
      observacao nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_conta( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_contato( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_negociacao( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_produto( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE unidade( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE venda( 
      id  INT IDENTITY    NOT NULL  , 
      cliente_id int   NOT NULL  , 
      vendedor_id int   NOT NULL  , 
      estado_venda_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
      dt_venda datetime2   NOT NULL  , 
      obs nvarchar(max)   , 
      frete float   , 
      valor_total float   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE venda_item( 
      id  INT IDENTITY    NOT NULL  , 
      produto_id int   NOT NULL  , 
      venda_id int   NOT NULL  , 
      quantidade float   NOT NULL  , 
      valor float   NOT NULL  , 
      desconto float   , 
 PRIMARY KEY (id)) ; 

 
  
 ALTER TABLE cidade ADD CONSTRAINT fk_cidade_1 FOREIGN KEY (estado_id) references estado(id); 
ALTER TABLE conta ADD CONSTRAINT fk_conta_3 FOREIGN KEY (natureza_id) references natureza(id); 
ALTER TABLE conta ADD CONSTRAINT fk_conta_2 FOREIGN KEY (cliente_id) references pessoa(id); 
ALTER TABLE conta ADD CONSTRAINT fk_conta_1 FOREIGN KEY (tipo_conta_id) references tipo_conta(id); 
ALTER TABLE contato ADD CONSTRAINT fk_contato_1 FOREIGN KEY (pessoa_id) references pessoa(id); 
ALTER TABLE historico_negociacao ADD CONSTRAINT fk_historico_negociacao_2 FOREIGN KEY (tipo_contato_id) references tipo_contato(id); 
ALTER TABLE historico_negociacao ADD CONSTRAINT fk_historico_negociacao_1 FOREIGN KEY (negociacao_id) references negociacao(id); 
ALTER TABLE negociacao ADD CONSTRAINT fk_negociacao_5 FOREIGN KEY (tipo_negociacao_id) references tipo_negociacao(id); 
ALTER TABLE negociacao ADD CONSTRAINT fk_negociacao_4 FOREIGN KEY (origem_negociacao_id) references origem_negociacao(id); 
ALTER TABLE negociacao ADD CONSTRAINT fk_negociacao_3 FOREIGN KEY (vendedor_id) references pessoa(id); 
ALTER TABLE negociacao ADD CONSTRAINT fk_negociacao_1 FOREIGN KEY (cliente_id) references pessoa(id); 
ALTER TABLE negociacao ADD CONSTRAINT fk_negociacao_6 FOREIGN KEY (estado_negociacao_id) references estado_negociacao(id); 
ALTER TABLE negociacao_produto ADD CONSTRAINT fk_negociacao_produto_2 FOREIGN KEY (negociacao_id) references negociacao(id); 
ALTER TABLE negociacao_produto ADD CONSTRAINT fk_negociacao_produto_1 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE orcamento ADD CONSTRAINT fk_orcamento_3 FOREIGN KEY (vendedor_id) references pessoa(id); 
ALTER TABLE orcamento ADD CONSTRAINT fk_orcamento_2 FOREIGN KEY (estado_orcamento_id) references estado_orcamento(id); 
ALTER TABLE orcamento ADD CONSTRAINT fk_orcamento_1 FOREIGN KEY (cliente_id) references pessoa(id); 
ALTER TABLE orcamento_item ADD CONSTRAINT fk_orcamento_item_2 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE orcamento_item ADD CONSTRAINT fk_orcamento_item_1 FOREIGN KEY (orcamento_id) references orcamento(id); 
ALTER TABLE pessoa ADD CONSTRAINT fk_pessoa_1 FOREIGN KEY (cidade_id) references cidade(id); 
ALTER TABLE pessoa_grupo ADD CONSTRAINT fk_pessoa_grupo_2 FOREIGN KEY (pessoa_id) references pessoa(id); 
ALTER TABLE pessoa_grupo ADD CONSTRAINT fk_pessoa_grupo_1 FOREIGN KEY (grupo_id) references grupo(id); 
ALTER TABLE produto ADD CONSTRAINT fk_produto_3 FOREIGN KEY (fornecedor_id) references pessoa(id); 
ALTER TABLE produto ADD CONSTRAINT fk_produto_2 FOREIGN KEY (tipo_produto_id) references tipo_produto(id); 
ALTER TABLE produto ADD CONSTRAINT fk_produto_1 FOREIGN KEY (unidade_id) references unidade(id); 
ALTER TABLE prospeccao ADD CONSTRAINT fk_prospeccao_2 FOREIGN KEY (vendedor_id) references pessoa(id); 
ALTER TABLE prospeccao ADD CONSTRAINT fk_prospeccao_1 FOREIGN KEY (cliente_id) references pessoa(id); 
ALTER TABLE venda ADD CONSTRAINT fk_venda_3 FOREIGN KEY (vendedor_id) references pessoa(id); 
ALTER TABLE venda ADD CONSTRAINT fk_venda_2 FOREIGN KEY (estado_venda_id) references estado_venda(id); 
ALTER TABLE venda ADD CONSTRAINT fk_venda_1 FOREIGN KEY (cliente_id) references pessoa(id); 
ALTER TABLE venda_item ADD CONSTRAINT fk_venda_item_2 FOREIGN KEY (venda_id) references venda(id); 
ALTER TABLE venda_item ADD CONSTRAINT fk_venda_item_1 FOREIGN KEY (produto_id) references produto(id); 
