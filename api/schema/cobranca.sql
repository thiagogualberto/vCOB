SELECT tc.chave, cd_cobranca as id, tce.cd_cliente_empresa as id_cliente, tc.chave_empresa, dt_emissao, IF(cnpj = '', nome_razaosocial, nome_fantasia) as cliente, dt_vencimento, dt_pagamento, vl_emissao, vl_pago, num_referencia, mensagem, linha, tipo_baixa
FROM tbl_cobranca as tc
INNER JOIN tbl_cliente_empresa as tce ON tc.chave_cliente = tce.chave