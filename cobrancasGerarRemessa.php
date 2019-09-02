<?php
if (can_access(["L00000120170808160001"], '^N')) {
	//Define o número de itens por página.
	$itens_por_pagina = 10;

	//Pegar a página atual.
	if (isset($_REQUEST["pagina"]))     $pagina = intval($_REQUEST["pagina"]);
	else    $pagina = 1;

	//Calcular o início da visualização
	$inicio = ($itens_por_pagina * $pagina) - $itens_por_pagina;?>
	<br>
	<div class="panel panel-primary">
		<div class="panel-heading" >
			<h3 class="panel-title"><strong>Gerar Remessa</strong></h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<?php
					form_inicio('formulario', 'get', '','');
					form_input_hidden('pg', 'cobrancasGerarRemessa');
					form_input_data('Data de início', 'start', validate($_GET['start'], ''), 3, true);
					form_input_data('Data de fim', 'end', validate($_GET['end'], ''), 3, true);
					?>
					<div class="col-md-6" style="margin-top: 25px">
						<?php form_btn_submit('Buscar') ?>
						<button id="gerar_remessa" type="button" class="btn btn-large btn-success" style="float:right"> 
							Gerar Remessa
						</button>
					</div>
					<?php form_fim() ?>
				</div>
			</div>
			<?php if (isset($_GET['start'])) : ?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel-body table-responsive">
						<form id="remessa" action="cobrancasGerarCsv.php" method="post">
						<table class="table table-striped" id="tbl_remessa_cob">
							<thead>
								<tr>
									<th class="sorting" style="width: 10%"><input type="checkbox" id="seleciona_tudo"></th>
									<th class="sorting" style="width: 20%"><b>Cliente</b></th>
									<th class="sorting" style="width: 20%"><b>Data Emissão</b></th>
									<th class="sorting" style="width: 20%"><b>Valor Emissao</b></th>
									<th class="sorting" style="width: 20%"><b>Data Vencimento</b></th>
									<th class="sorting" style="width: 10%" align="center"><b>Impressão</b></th>
								</tr>
							</thead>
							<tbody>
								<?php

								$start = date_br2usa($_GET['start']);
								$end = date_br2usa($_GET['end']);

								//Seleciona os registros da tabela a serem mostrados na página.
								$sql = "SELECT tc.chave, tce.nome_fantasia, tc.dt_emissao, tc.dt_vencimento, tc.vl_emissao, tipo_impressao
										FROM tbl_cobranca AS tc
										INNER JOIN tbl_cliente_empresa AS tce ON tc.chave_cliente = tce.chave
										WHERE tc.chave_empresa = '{$_SESSION['chave_empresa']}'
											AND tc.dt_emissao BETWEEN '$start' AND '$end'
											AND tc.dt_vencimento > CURDATE()
											AND tce.cnpj <> ''
											AND tce.ativo = 'S'
											AND (tipo_baixa = '' OR tipo_baixa IS NULL)
											AND (tipo_impressao = 'R' OR tipo_impressao IS NULL)
										UNION
										SELECT tc.chave, tce.nome_razaosocial, tc.dt_emissao, tc.dt_vencimento, tc.vl_emissao, tipo_impressao
										FROM tbl_cobranca AS tc
										INNER JOIN tbl_cliente_empresa AS tce ON tc.chave_cliente = tce.chave
										WHERE tc.chave_empresa = '{$_SESSION['chave_empresa']}'
											AND tc.dt_emissao BETWEEN '$start' AND '$end'
											AND tc.dt_vencimento > CURDATE()
											AND tce.cpf <> ''
											AND tce.ativo = 'S'
											AND (tipo_baixa = '' OR tipo_baixa IS NULL)
											AND (tipo_impressao <> 'L' OR tipo_impressao IS NULL)";
								// echo $sql;
								// $sql = "SELECT * FROM `tbl_cobranca` WHERE tipo_impressao = NULL OR tipo_impressao = '' OR tipo_impressao = 'R'";
								$qry = mysqli_query($con,$sql);
								while ($res = mysqli_fetch_array($qry)) : ?>
									<tr>
										<td><?php form_checkbox_semformat('cobrancas[]', $res['chave'],'','N','')?></td>
										<td><?=$res["nome_fantasia"]?></td>
										<td><?=format_date($res['dt_emissao'])?></td>
										<td><?=format_money($res['vl_emissao'])?></td>
										<td><?=format_date($res['dt_vencimento'])?></td>
										<td><?=validate($res["tipo_impressao"], '-')?></td>
									</tr>
								<?php endwhile ?>
							</tbody>
						</table>
						</form>
					</div>
				</div>	  
			</div>
			<?php endif; ?>
		</div>
	</div>
<?php
}else{?>
	<br>
	<?php 
	msg('4','Acesso não autorizado. Redirecionamento para a tela de login.','1','5','login.php','');
}?>