CREATE TABLE cidade( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
      estado_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE conta( 
      id  SERIAL    NOT NULL  , 
      tipo_conta_id integer   NOT NULL  , 
      cliente_id integer   NOT NULL  , 
      natureza_id integer   NOT NULL  , 
      system_unit_id integer   NOT NULL  , 
      dt_emissao date   NOT NULL  , 
      dt_vencimento date   NOT NULL  , 
      valor float   NOT NULL  , 
      desconto float   , 
      juros float   , 
      multa float   , 
      obs text   , 
      quitada char  (1)   NOT NULL    DEFAULT 'f', 
 PRIMARY KEY (id)) ; 

CREATE TABLE contato( 
      id  SERIAL    NOT NULL  , 
      pessoa_id integer   NOT NULL  , 
      email text   NOT NULL  , 
      nome text   NOT NULL  , 
      telefone text   , 
      obs text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_negociacao( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
      cor text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_orcamento( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_venda( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE historico_negociacao( 
      id  SERIAL    NOT NULL  , 
      negociacao_id integer   NOT NULL  , 
      tipo_contato_id integer   NOT NULL  , 
      dt_contato timestamp   NOT NULL  , 
      descricao text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE natureza( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao( 
      id  SERIAL    NOT NULL  , 
      cliente_id integer   NOT NULL  , 
      vendedor_id integer   NOT NULL  , 
      origem_negociacao_id integer   NOT NULL  , 
      tipo_negociacao_id integer   NOT NULL  , 
      estado_negociacao_id integer   NOT NULL  , 
      system_unit_id integer   NOT NULL  , 
      dt_inicio_negociacao timestamp   NOT NULL  , 
      dt_fim_negociacao timestamp   , 
      descricao text   NOT NULL  , 
      obs text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_produto( 
      id  SERIAL    NOT NULL  , 
      produto_id integer   NOT NULL  , 
      negociacao_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE orcamento( 
      id  SERIAL    NOT NULL  , 
      cliente_id integer   NOT NULL  , 
      vendedor_id integer   NOT NULL  , 
      estado_orcamento_id integer   NOT NULL  , 
      system_unit_id integer   NOT NULL  , 
      dt_orcamento timestamp   NOT NULL  , 
      obs text   , 
      frete float   , 
      valor_total float   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE orcamento_item( 
      id  SERIAL    NOT NULL  , 
      orcamento_id integer   NOT NULL  , 
      produto_id integer   NOT NULL  , 
      quantidade float   NOT NULL  , 
      valor float   NOT NULL  , 
      desconto float   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE origem_negociacao( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa( 
      id  SERIAL    NOT NULL  , 
      system_user_id integer   , 
      nome text   NOT NULL  , 
      documento text   NOT NULL  , 
      obs text   , 
      fone text   , 
      email text   , 
      cidade_id integer   NOT NULL  , 
      rua text   , 
      numero text   , 
      bairro text   , 
      complemento text   , 
      cep text   , 
      dt_ativacao date   NOT NULL  , 
      dt_desativacao date   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa_grupo( 
      id  SERIAL    NOT NULL  , 
      grupo_id integer   NOT NULL  , 
      pessoa_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE produto( 
      id  SERIAL    NOT NULL  , 
      unidade_id integer   NOT NULL  , 
      tipo_produto_id integer   NOT NULL  , 
      fornecedor_id integer   NOT NULL  , 
      nome text   NOT NULL  , 
      dt_cadastro date   NOT NULL  , 
      cod_barras text   , 
      preco_custo float   NOT NULL  , 
      preco_venda float   NOT NULL  , 
      peso_liquido float   NOT NULL  , 
      peso_bruto float   NOT NULL  , 
      estoque_minimo float   NOT NULL  , 
      estoque_maximo float   NOT NULL  , 
      qtde_estoque float   NOT NULL  , 
      obs text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE prospeccao( 
      id  SERIAL    NOT NULL  , 
      vendedor_id integer   NOT NULL  , 
      cliente_id integer   NOT NULL  , 
      system_unit_id integer   NOT NULL  , 
      horario_inicial timestamp   NOT NULL  , 
      horario_final timestamp   NOT NULL  , 
      titulo text   , 
      cor text   , 
      observacao text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_conta( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_contato( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_negociacao( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_produto( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE unidade( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE venda( 
      id  SERIAL    NOT NULL  , 
      cliente_id integer   NOT NULL  , 
      vendedor_id integer   NOT NULL  , 
      estado_venda_id integer   NOT NULL  , 
      system_unit_id integer   NOT NULL  , 
      dt_venda timestamp   NOT NULL  , 
      obs text   , 
      frete float   , 
      valor_total float   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE venda_item( 
      id  SERIAL    NOT NULL  , 
      produto_id integer   NOT NULL  , 
      venda_id integer   NOT NULL  , 
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
 
 CREATE index idx_cidade_estado_id on cidade(estado_id); 
CREATE index idx_conta_natureza_id on conta(natureza_id); 
CREATE index idx_conta_cliente_id on conta(cliente_id); 
CREATE index idx_conta_tipo_conta_id on conta(tipo_conta_id); 
CREATE index idx_contato_pessoa_id on contato(pessoa_id); 
CREATE index idx_historico_negociacao_tipo_contato_id on historico_negociacao(tipo_contato_id); 
CREATE index idx_historico_negociacao_negociacao_id on historico_negociacao(negociacao_id); 
CREATE index idx_negociacao_tipo_negociacao_id on negociacao(tipo_negociacao_id); 
CREATE index idx_negociacao_origem_negociacao_id on negociacao(origem_negociacao_id); 
CREATE index idx_negociacao_vendedor_id on negociacao(vendedor_id); 
CREATE index idx_negociacao_cliente_id on negociacao(cliente_id); 
CREATE index idx_negociacao_estado_negociacao_id on negociacao(estado_negociacao_id); 
CREATE index idx_negociacao_produto_negociacao_id on negociacao_produto(negociacao_id); 
CREATE index idx_negociacao_produto_produto_id on negociacao_produto(produto_id); 
CREATE index idx_orcamento_vendedor_id on orcamento(vendedor_id); 
CREATE index idx_orcamento_estado_orcamento_id on orcamento(estado_orcamento_id); 
CREATE index idx_orcamento_cliente_id on orcamento(cliente_id); 
CREATE index idx_orcamento_item_produto_id on orcamento_item(produto_id); 
CREATE index idx_orcamento_item_orcamento_id on orcamento_item(orcamento_id); 
CREATE index idx_pessoa_cidade_id on pessoa(cidade_id); 
CREATE index idx_pessoa_grupo_pessoa_id on pessoa_grupo(pessoa_id); 
CREATE index idx_pessoa_grupo_grupo_id on pessoa_grupo(grupo_id); 
CREATE index idx_produto_fornecedor_id on produto(fornecedor_id); 
CREATE index idx_produto_tipo_produto_id on produto(tipo_produto_id); 
CREATE index idx_produto_unidade_id on produto(unidade_id); 
CREATE index idx_prospeccao_vendedor_id on prospeccao(vendedor_id); 
CREATE index idx_prospeccao_cliente_id on prospeccao(cliente_id); 
CREATE index idx_venda_vendedor_id on venda(vendedor_id); 
CREATE index idx_venda_estado_venda_id on venda(estado_venda_id); 
CREATE index idx_venda_cliente_id on venda(cliente_id); 
CREATE index idx_venda_item_venda_id on venda_item(venda_id); 
CREATE index idx_venda_item_produto_id on venda_item(produto_id); 
