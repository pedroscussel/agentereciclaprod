SET IDENTITY_INSERT estado_venda ON; 

INSERT INTO estado_venda (id,nome) VALUES (1,'Nova'); 

INSERT INTO estado_venda (id,nome) VALUES (2,'Finalizada'); 

INSERT INTO estado_venda (id,nome) VALUES (3,'Cancelada'); 

SET IDENTITY_INSERT estado_venda OFF; 

SET IDENTITY_INSERT grupo ON; 

INSERT INTO grupo (id,nome) VALUES (1,'Vendedores'); 

INSERT INTO grupo (id,nome) VALUES (2,'Clientes'); 

INSERT INTO grupo (id,nome) VALUES (3,'Fornecedores'); 

INSERT INTO grupo (id,nome) VALUES (4,'Funcionários'); 

SET IDENTITY_INSERT grupo OFF; 

SET IDENTITY_INSERT natureza ON; 

INSERT INTO natureza (id,nome) VALUES (1,'Vendas'); 

INSERT INTO natureza (id,nome) VALUES (2,'Serviços'); 

INSERT INTO natureza (id,nome) VALUES (3,'Locações'); 

SET IDENTITY_INSERT natureza OFF; 

SET IDENTITY_INSERT tipo_conta ON; 

INSERT INTO tipo_conta (id,nome) VALUES (1,'Receber'); 

INSERT INTO tipo_conta (id,nome) VALUES (2,'Pagar'); 

SET IDENTITY_INSERT tipo_conta OFF; 
