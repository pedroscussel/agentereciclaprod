CREATE TABLE cidade( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
      `estado_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE conta( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `tipo_conta_id` int   NOT NULL  , 
      `cliente_id` int   NOT NULL  , 
      `natureza_id` int   NOT NULL  , 
      `system_unit_id` int   NOT NULL  , 
      `dt_emissao` date   NOT NULL  , 
      `dt_vencimento` date   NOT NULL  , 
      `valor` double   NOT NULL  , 
      `desconto` double   , 
      `juros` double   , 
      `multa` double   , 
      `obs` text   , 
      `quitada` char  (1)   NOT NULL    DEFAULT 'f', 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE contato( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `pessoa_id` int   NOT NULL  , 
      `email` text   NOT NULL  , 
      `nome` text   NOT NULL  , 
      `telefone` text   , 
      `obs` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE estado( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE estado_negociacao( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
      `cor` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE estado_orcamento( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE estado_venda( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE grupo( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE historico_negociacao( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `negociacao_id` int   NOT NULL  , 
      `tipo_contato_id` int   NOT NULL  , 
      `dt_contato` datetime   NOT NULL  , 
      `descricao` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE natureza( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE negociacao( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `cliente_id` int   NOT NULL  , 
      `vendedor_id` int   NOT NULL  , 
      `origem_negociacao_id` int   NOT NULL  , 
      `tipo_negociacao_id` int   NOT NULL  , 
      `estado_negociacao_id` int   NOT NULL  , 
      `system_unit_id` int   NOT NULL  , 
      `dt_inicio_negociacao` datetime   NOT NULL  , 
      `dt_fim_negociacao` datetime   , 
      `descricao` text   NOT NULL  , 
      `obs` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE negociacao_produto( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `produto_id` int   NOT NULL  , 
      `negociacao_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE orcamento( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `cliente_id` int   NOT NULL  , 
      `vendedor_id` int   NOT NULL  , 
      `estado_orcamento_id` int   NOT NULL  , 
      `system_unit_id` int   NOT NULL  , 
      `dt_orcamento` datetime   NOT NULL  , 
      `obs` text   , 
      `frete` double   , 
      `valor_total` double   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE orcamento_item( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `orcamento_id` int   NOT NULL  , 
      `produto_id` int   NOT NULL  , 
      `quantidade` double   NOT NULL  , 
      `valor` double   NOT NULL  , 
      `desconto` double   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE origem_negociacao( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE pessoa( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `system_user_id` int   , 
      `nome` text   NOT NULL  , 
      `documento` text   NOT NULL  , 
      `obs` text   , 
      `fone` text   , 
      `email` text   , 
      `cidade_id` int   NOT NULL  , 
      `rua` text   , 
      `numero` text   , 
      `bairro` text   , 
      `complemento` text   , 
      `cep` text   , 
      `dt_ativacao` date   NOT NULL  , 
      `dt_desativacao` date   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE pessoa_grupo( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `grupo_id` int   NOT NULL  , 
      `pessoa_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE produto( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `unidade_id` int   NOT NULL  , 
      `tipo_produto_id` int   NOT NULL  , 
      `fornecedor_id` int   NOT NULL  , 
      `nome` text   NOT NULL  , 
      `dt_cadastro` date   NOT NULL  , 
      `cod_barras` text   , 
      `preco_custo` double   NOT NULL  , 
      `preco_venda` double   NOT NULL  , 
      `peso_liquido` double   NOT NULL  , 
      `peso_bruto` double   NOT NULL  , 
      `estoque_minimo` double   NOT NULL  , 
      `estoque_maximo` double   NOT NULL  , 
      `qtde_estoque` double   NOT NULL  , 
      `obs` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE prospeccao( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `vendedor_id` int   NOT NULL  , 
      `cliente_id` int   NOT NULL  , 
      `system_unit_id` int   NOT NULL  , 
      `horario_inicial` datetime   NOT NULL  , 
      `horario_final` datetime   NOT NULL  , 
      `titulo` text   , 
      `cor` text   , 
      `observacao` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE tipo_conta( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE tipo_contato( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE tipo_negociacao( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE tipo_produto( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE unidade( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE venda( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `cliente_id` int   NOT NULL  , 
      `vendedor_id` int   NOT NULL  , 
      `estado_venda_id` int   NOT NULL  , 
      `system_unit_id` int   NOT NULL  , 
      `dt_venda` datetime   NOT NULL  , 
      `obs` text   , 
      `frete` double   , 
      `valor_total` double   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE venda_item( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `produto_id` int   NOT NULL  , 
      `venda_id` int   NOT NULL  , 
      `quantidade` double   NOT NULL  , 
      `valor` double   NOT NULL  , 
      `desconto` double   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

 
  
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
