CREATE TABLE cidade( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
      estado_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE conta( 
      id number(10)    NOT NULL , 
      tipo_conta_id number(10)    NOT NULL , 
      cliente_id number(10)    NOT NULL , 
      natureza_id number(10)    NOT NULL , 
      system_unit_id number(10)    NOT NULL , 
      dt_emissao date    NOT NULL , 
      dt_vencimento date    NOT NULL , 
      valor binary_double    NOT NULL , 
      desconto binary_double   , 
      juros binary_double   , 
      multa binary_double   , 
      obs varchar(3000)   , 
      quitada char  (1)    DEFAULT 'f'  NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE contato( 
      id number(10)    NOT NULL , 
      pessoa_id number(10)    NOT NULL , 
      email varchar(3000)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
      telefone varchar(3000)   , 
      obs varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_negociacao( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
      cor varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_orcamento( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE estado_venda( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE grupo( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE historico_negociacao( 
      id number(10)    NOT NULL , 
      negociacao_id number(10)    NOT NULL , 
      tipo_contato_id number(10)    NOT NULL , 
      dt_contato timestamp(0)    NOT NULL , 
      descricao varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE natureza( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao( 
      id number(10)    NOT NULL , 
      cliente_id number(10)    NOT NULL , 
      vendedor_id number(10)    NOT NULL , 
      origem_negociacao_id number(10)    NOT NULL , 
      tipo_negociacao_id number(10)    NOT NULL , 
      estado_negociacao_id number(10)    NOT NULL , 
      system_unit_id number(10)    NOT NULL , 
      dt_inicio_negociacao timestamp(0)    NOT NULL , 
      dt_fim_negociacao timestamp(0)   , 
      descricao varchar(3000)    NOT NULL , 
      obs varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE negociacao_produto( 
      id number(10)    NOT NULL , 
      produto_id number(10)    NOT NULL , 
      negociacao_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE orcamento( 
      id number(10)    NOT NULL , 
      cliente_id number(10)    NOT NULL , 
      vendedor_id number(10)    NOT NULL , 
      estado_orcamento_id number(10)    NOT NULL , 
      system_unit_id number(10)    NOT NULL , 
      dt_orcamento timestamp(0)    NOT NULL , 
      obs varchar(3000)   , 
      frete binary_double   , 
      valor_total binary_double   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE orcamento_item( 
      id number(10)    NOT NULL , 
      orcamento_id number(10)    NOT NULL , 
      produto_id number(10)    NOT NULL , 
      quantidade binary_double    NOT NULL , 
      valor binary_double    NOT NULL , 
      desconto binary_double   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE origem_negociacao( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa( 
      id number(10)    NOT NULL , 
      system_user_id number(10)   , 
      nome varchar(3000)    NOT NULL , 
      documento varchar(3000)    NOT NULL , 
      obs varchar(3000)   , 
      fone varchar(3000)   , 
      email varchar(3000)   , 
      cidade_id number(10)    NOT NULL , 
      rua varchar(3000)   , 
      numero varchar(3000)   , 
      bairro varchar(3000)   , 
      complemento varchar(3000)   , 
      cep varchar(3000)   , 
      dt_ativacao date    NOT NULL , 
      dt_desativacao date   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pessoa_grupo( 
      id number(10)    NOT NULL , 
      grupo_id number(10)    NOT NULL , 
      pessoa_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE produto( 
      id number(10)    NOT NULL , 
      unidade_id number(10)    NOT NULL , 
      tipo_produto_id number(10)    NOT NULL , 
      fornecedor_id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
      dt_cadastro date    NOT NULL , 
      cod_barras varchar(3000)   , 
      preco_custo binary_double    NOT NULL , 
      preco_venda binary_double    NOT NULL , 
      peso_liquido binary_double    NOT NULL , 
      peso_bruto binary_double    NOT NULL , 
      estoque_minimo binary_double    NOT NULL , 
      estoque_maximo binary_double    NOT NULL , 
      qtde_estoque binary_double    NOT NULL , 
      obs varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE prospeccao( 
      id number(10)    NOT NULL , 
      vendedor_id number(10)    NOT NULL , 
      cliente_id number(10)    NOT NULL , 
      system_unit_id number(10)    NOT NULL , 
      horario_inicial timestamp(0)    NOT NULL , 
      horario_final timestamp(0)    NOT NULL , 
      titulo varchar(3000)   , 
      cor varchar(3000)   , 
      observacao varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_conta( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_contato( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_negociacao( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_produto( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE unidade( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE venda( 
      id number(10)    NOT NULL , 
      cliente_id number(10)    NOT NULL , 
      vendedor_id number(10)    NOT NULL , 
      estado_venda_id number(10)    NOT NULL , 
      system_unit_id number(10)    NOT NULL , 
      dt_venda timestamp(0)    NOT NULL , 
      obs varchar(3000)   , 
      frete binary_double   , 
      valor_total binary_double   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE venda_item( 
      id number(10)    NOT NULL , 
      produto_id number(10)    NOT NULL , 
      venda_id number(10)    NOT NULL , 
      quantidade binary_double    NOT NULL , 
      valor binary_double    NOT NULL , 
      desconto binary_double   , 
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
 CREATE SEQUENCE cidade_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER cidade_id_seq_tr 

BEFORE INSERT ON cidade FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT cidade_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE conta_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER conta_id_seq_tr 

BEFORE INSERT ON conta FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT conta_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE contato_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER contato_id_seq_tr 

BEFORE INSERT ON contato FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT contato_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE estado_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER estado_id_seq_tr 

BEFORE INSERT ON estado FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT estado_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE estado_negociacao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER estado_negociacao_id_seq_tr 

BEFORE INSERT ON estado_negociacao FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT estado_negociacao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE estado_orcamento_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER estado_orcamento_id_seq_tr 

BEFORE INSERT ON estado_orcamento FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT estado_orcamento_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE estado_venda_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER estado_venda_id_seq_tr 

BEFORE INSERT ON estado_venda FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT estado_venda_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE grupo_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER grupo_id_seq_tr 

BEFORE INSERT ON grupo FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT grupo_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE historico_negociacao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER historico_negociacao_id_seq_tr 

BEFORE INSERT ON historico_negociacao FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT historico_negociacao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE natureza_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER natureza_id_seq_tr 

BEFORE INSERT ON natureza FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT natureza_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE negociacao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER negociacao_id_seq_tr 

BEFORE INSERT ON negociacao FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT negociacao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE negociacao_produto_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER negociacao_produto_id_seq_tr 

BEFORE INSERT ON negociacao_produto FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT negociacao_produto_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE orcamento_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER orcamento_id_seq_tr 

BEFORE INSERT ON orcamento FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT orcamento_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE orcamento_item_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER orcamento_item_id_seq_tr 

BEFORE INSERT ON orcamento_item FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT orcamento_item_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE origem_negociacao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER origem_negociacao_id_seq_tr 

BEFORE INSERT ON origem_negociacao FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT origem_negociacao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE pessoa_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER pessoa_id_seq_tr 

BEFORE INSERT ON pessoa FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT pessoa_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE pessoa_grupo_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER pessoa_grupo_id_seq_tr 

BEFORE INSERT ON pessoa_grupo FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT pessoa_grupo_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE produto_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER produto_id_seq_tr 

BEFORE INSERT ON produto FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT produto_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE prospeccao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER prospeccao_id_seq_tr 

BEFORE INSERT ON prospeccao FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT prospeccao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_conta_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_conta_id_seq_tr 

BEFORE INSERT ON tipo_conta FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tipo_conta_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_contato_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_contato_id_seq_tr 

BEFORE INSERT ON tipo_contato FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tipo_contato_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_negociacao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_negociacao_id_seq_tr 

BEFORE INSERT ON tipo_negociacao FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tipo_negociacao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_produto_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_produto_id_seq_tr 

BEFORE INSERT ON tipo_produto FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tipo_produto_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE unidade_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER unidade_id_seq_tr 

BEFORE INSERT ON unidade FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT unidade_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE venda_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER venda_id_seq_tr 

BEFORE INSERT ON venda FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT venda_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE venda_item_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER venda_item_id_seq_tr 

BEFORE INSERT ON venda_item FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT venda_item_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 