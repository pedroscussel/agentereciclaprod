PRAGMA foreign_keys=OFF; 

CREATE TABLE cidade( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
      estado_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(estado_id) REFERENCES estado(id)) ; 

CREATE TABLE conta( 
      id  INTEGER    NOT NULL  , 
      tipo_conta_id int   NOT NULL  , 
      cliente_id int   NOT NULL  , 
      natureza_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
      dt_emissao date   NOT NULL  , 
      dt_vencimento date   NOT NULL  , 
      valor double   NOT NULL  , 
      desconto double   , 
      juros double   , 
      multa double   , 
      obs text   , 
      quitada char  (1)   NOT NULL    DEFAULT 'f', 
 PRIMARY KEY (id),
FOREIGN KEY(natureza_id) REFERENCES natureza(id),
FOREIGN KEY(cliente_id) REFERENCES pessoa(id),
FOREIGN KEY(tipo_conta_id) REFERENCES tipo_conta(id)) ; 

CREATE TABLE contato( 
      id  INTEGER    NOT NULL  , 
      pessoa_id int   NOT NULL  , 
      email text   NOT NULL  , 
      nome text   NOT NULL  , 
      telefone text   , 
      obs text   , 
 PRIMARY KEY (id),
FOREIGN KEY(pessoa_id) REFERENCES pessoa(id)) ; 

CREATE TABLE estado( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_negociacao( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
      cor text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_orcamento( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_venda( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE historico_negociacao( 
      id  INTEGER    NOT NULL  , 
      negociacao_id int   NOT NULL  , 
      tipo_contato_id int   NOT NULL  , 
      dt_contato datetime   NOT NULL  , 
      descricao text   , 
 PRIMARY KEY (id),
FOREIGN KEY(tipo_contato_id) REFERENCES tipo_contato(id),
FOREIGN KEY(negociacao_id) REFERENCES negociacao(id)) ; 

CREATE TABLE natureza( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao( 
      id  INTEGER    NOT NULL  , 
      cliente_id int   NOT NULL  , 
      vendedor_id int   NOT NULL  , 
      origem_negociacao_id int   NOT NULL  , 
      tipo_negociacao_id int   NOT NULL  , 
      estado_negociacao_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
      dt_inicio_negociacao datetime   NOT NULL  , 
      dt_fim_negociacao datetime   , 
      descricao text   NOT NULL  , 
      obs text   , 
 PRIMARY KEY (id),
FOREIGN KEY(tipo_negociacao_id) REFERENCES tipo_negociacao(id),
FOREIGN KEY(origem_negociacao_id) REFERENCES origem_negociacao(id),
FOREIGN KEY(vendedor_id) REFERENCES pessoa(id),
FOREIGN KEY(cliente_id) REFERENCES pessoa(id),
FOREIGN KEY(estado_negociacao_id) REFERENCES estado_negociacao(id)) ; 

CREATE TABLE negociacao_produto( 
      id  INTEGER    NOT NULL  , 
      produto_id int   NOT NULL  , 
      negociacao_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(negociacao_id) REFERENCES negociacao(id),
FOREIGN KEY(produto_id) REFERENCES produto(id)) ; 

CREATE TABLE orcamento( 
      id  INTEGER    NOT NULL  , 
      cliente_id int   NOT NULL  , 
      vendedor_id int   NOT NULL  , 
      estado_orcamento_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
      dt_orcamento datetime   NOT NULL  , 
      obs text   , 
      frete double   , 
      valor_total double   , 
 PRIMARY KEY (id),
FOREIGN KEY(vendedor_id) REFERENCES pessoa(id),
FOREIGN KEY(estado_orcamento_id) REFERENCES estado_orcamento(id),
FOREIGN KEY(cliente_id) REFERENCES pessoa(id)) ; 

CREATE TABLE orcamento_item( 
      id  INTEGER    NOT NULL  , 
      orcamento_id int   NOT NULL  , 
      produto_id int   NOT NULL  , 
      quantidade double   NOT NULL  , 
      valor double   NOT NULL  , 
      desconto double   , 
 PRIMARY KEY (id),
FOREIGN KEY(produto_id) REFERENCES produto(id),
FOREIGN KEY(orcamento_id) REFERENCES orcamento(id)) ; 

CREATE TABLE origem_negociacao( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa( 
      id  INTEGER    NOT NULL  , 
      system_user_id int   , 
      nome text   NOT NULL  , 
      documento text   NOT NULL  , 
      obs text   , 
      fone text   , 
      email text   , 
      cidade_id int   NOT NULL  , 
      rua text   , 
      numero text   , 
      bairro text   , 
      complemento text   , 
      cep text   , 
      dt_ativacao date   NOT NULL  , 
      dt_desativacao date   , 
 PRIMARY KEY (id),
FOREIGN KEY(cidade_id) REFERENCES cidade(id)) ; 

CREATE TABLE pessoa_grupo( 
      id  INTEGER    NOT NULL  , 
      grupo_id int   NOT NULL  , 
      pessoa_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(pessoa_id) REFERENCES pessoa(id),
FOREIGN KEY(grupo_id) REFERENCES grupo(id)) ; 

CREATE TABLE produto( 
      id  INTEGER    NOT NULL  , 
      unidade_id int   NOT NULL  , 
      tipo_produto_id int   NOT NULL  , 
      fornecedor_id int   NOT NULL  , 
      nome text   NOT NULL  , 
      dt_cadastro date   NOT NULL  , 
      cod_barras text   , 
      preco_custo double   NOT NULL  , 
      preco_venda double   NOT NULL  , 
      peso_liquido double   NOT NULL  , 
      peso_bruto double   NOT NULL  , 
      estoque_minimo double   NOT NULL  , 
      estoque_maximo double   NOT NULL  , 
      qtde_estoque double   NOT NULL  , 
      obs text   , 
 PRIMARY KEY (id),
FOREIGN KEY(fornecedor_id) REFERENCES pessoa(id),
FOREIGN KEY(tipo_produto_id) REFERENCES tipo_produto(id),
FOREIGN KEY(unidade_id) REFERENCES unidade(id)) ; 

CREATE TABLE prospeccao( 
      id  INTEGER    NOT NULL  , 
      vendedor_id int   NOT NULL  , 
      cliente_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
      horario_inicial datetime   NOT NULL  , 
      horario_final datetime   NOT NULL  , 
      titulo text   , 
      cor text   , 
      observacao text   , 
 PRIMARY KEY (id),
FOREIGN KEY(vendedor_id) REFERENCES pessoa(id),
FOREIGN KEY(cliente_id) REFERENCES pessoa(id)) ; 

CREATE TABLE tipo_conta( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_contato( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_negociacao( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_produto( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE unidade( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE venda( 
      id  INTEGER    NOT NULL  , 
      cliente_id int   NOT NULL  , 
      vendedor_id int   NOT NULL  , 
      estado_venda_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
      dt_venda datetime   NOT NULL  , 
      obs text   , 
      frete double   , 
      valor_total double   , 
 PRIMARY KEY (id),
FOREIGN KEY(vendedor_id) REFERENCES pessoa(id),
FOREIGN KEY(estado_venda_id) REFERENCES estado_venda(id),
FOREIGN KEY(cliente_id) REFERENCES pessoa(id)) ; 

CREATE TABLE venda_item( 
      id  INTEGER    NOT NULL  , 
      produto_id int   NOT NULL  , 
      venda_id int   NOT NULL  , 
      quantidade double   NOT NULL  , 
      valor double   NOT NULL  , 
      desconto double   , 
 PRIMARY KEY (id),
FOREIGN KEY(venda_id) REFERENCES venda(id),
FOREIGN KEY(produto_id) REFERENCES produto(id)) ; 

 
 