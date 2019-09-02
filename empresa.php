<?php
if (can_access(['L00000120170808160000'], 'S')) {
	//Define o número de itens por página.
	$itens_por_pagina = 10;

	//Pegar a página atual.
	if (isset($_REQUEST["pagina"])) {
		$pagina = intval($_REQUEST["pagina"]);
	} else {
		$pagina = 1;
	}

	//Calcular o início da visualização
	$inicio = ($itens_por_pagina * $pagina) - $itens_por_pagina;?>
	<br>
	<div class="panel panel-primary">
		<div class="panel-heading" >
			<h3 class="panel-title"><strong>Empresas</strong></h3>
		</div>
		<div class="panel-body">          
			<?php
			if (isset($_REQUEST["desativar"])){
				$sql = "UPDATE tbl_empresa SET ativo = 'N' WHERE chave = '".$_REQUEST["desativar"]."'";
				$qry = user_update($sql);
				$titulo = "Ativar";
				$param_titulo = "ativar";
				$cor = "color:red;";
				$class_ativ_desat = "fa fa-thumbs-o-up fa-fw";
			}
			else if (isset($_REQUEST["ativar"])){
				$sql = "UPDATE tbl_empresa SET ativo = 'S' WHERE chave = '".$_REQUEST["ativar"]."'";
				$qry = user_update($sql);
				$titulo = "Desativar";
				$param_titulo = "desativar";
				$cor = "color:#337ab7;";
				$class_ativ_desat = "fa fa-thumbs-o-down fa-fw";
			}

			if (isset($_REQUEST["filtrar"])) $filtrar = $_REQUEST["filtrar"]; else $filtrar = "";
			if (isset($_REQUEST["pesquisar_empresa"])){
				$pesquisar = $_REQUEST["pesquisar_empresa"];
				$filtrou = $filtrar;
				$filtrar = "";
			}
			else $pesquisar = "";

			form_inicio('formulario', 'get', 'index.php?pg=empresa','');?>
			<div class="col-md-12">
				<?php
				form_input_hidden('pg', 'empresa');
				form_select("Filtrar por", "filtrar", $filtrar, "", ",Selecione:nome,Nome:cnpj,CNPJ", "2",'1');
				form_input_text_autocomplete('Pesquisar','pesquisar_empresa',$pesquisar,'50','3','','','');?>
				<div style="margin-top: 25px;">
					<?php form_btn_submit("Buscar");
					if ( (($_SESSION['acessar_modulos']["L00000120170808160001"]) == "S") ||
							(($_SESSION['acessar_modulos']["L00000120170808160001"]) == "G") ){?>
					<a id="addLinhaPit" class="btn btn-large btn-success" href="index.php?pg=empresaCadastra"> 
						Adicionar Empresa
					</a>
					<?php
					}?>
				</div>
			</div>
			<?php
			if (isset($_REQUEST["pesquisar_empresa"])){?>
				<br>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Resultado da Busca</h3>
							</div>
							<div class="panel-body table-responsive">
								<?php
								if ( (($_REQUEST["filtrar"]) != "") && ($_REQUEST["pesquisar_empresa"] == "")){
									msg('4','Favor preencher o campo Pequisar e clique em Buscar novamente.','','','','');
								}
								else{?>
								<table class="table table-striped" id="tbl_empresa">
									<thead>
										<tr>
											<th class="sorting"><b>Razão Social/Nome</b></th>
											<th class="sorting"><b>Nome Fantasia</b></th>
											<th class="sorting" style="width: 160px"><b>CNPJ</b></th>
											<th class="sorting" style="width: 15%"><b>Cidade-UF</b></th>
											<?php
											if ( (($_SESSION['acessar_modulos']["L00000120170808160001"]) == "S") ||
													(($_SESSION['acessar_modulos']["L00000120170808160001"]) == "G") ){
												echo "<th colspan='2' width='10%' style='text-align: center'><b>Ações</b></th>";
											}?>
										</tr>
									</thead>
									<tbody>
										<?php
										//Seleciona todos os registros ta tabela
										$sql = "SELECT chave, tipo_cliente, nome_razaosocial, nome_fantasia, cnpj, cidade, uf, ativo
												FROM tbl_empresa
												WHERE nome_fantasia LIKE '%{$_REQUEST['pesquisar_empresa']}%'";
										
										$qry = mysqli_query($con,$sql);
										$num_total = mysqli_num_rows($qry);
										
										//Seleciona os registros da tabela a serem mostrados na página.
										$sql .= " LIMIT $inicio,$itens_por_pagina";
										$qry = mysqli_query($con,$sql);
										
										//Calcula o número de páginas
										$num_paginas = ceil($num_total/$itens_por_pagina);
										if (mysqli_num_rows($qry) > 0){
											while($res = mysqli_fetch_array($qry)){?>
											<tr>
												<td><?php echo $res["nome_razaosocial"]?></td>
												<td><?php echo $res["nome_fantasia"]?></td>
												<td><?php 
													if ($res["cnpj"] != "") : ?>
														<a title="<?php echo "CNPJ"?>" href="index.php?pg=empresaCadastra&visualizar=<?php echo $res["chave"];?>&filtrar=<?php echo $filtrou;?>&pesquisar_empresa=<?php echo $pesquisar;?>"><?php echo $res["cnpj"]?></a>
													<?php endif; ?>
												</td>
												<td><?php echo $res["cidade"]."-".$res["uf"]?></td>
												<?php
												if (can_access(['L00000120170808160001'], 'SG')){ ?>
													<td id="editar_empresa"><a title="Editar" href="index.php?pg=empresaCadastra&editar=<?php echo $res["chave"];?>&filtrar=<?php echo $filtrou;?>&pesquisar_empresa=<?php echo $pesquisar;?>"><i class="fa fa-edit fa-fw"></i></a></td>
													<td id="excluir_empresa"><a title="Excluir" onclick="apaga_empresa('<?php echo utf8_encode($res["nome_razaosocial"])?>','<?php echo $res["chave"]?>');"><i class="fa fa-trash fa-fw"></i></a></td>
													<?php
													if ($res["ativo"] == "S"){
														$titulo = "Desativar";
														$param_titulo = "desativar";
														$cor = "color:#337ab7;";
														$class_ativ_desat = "fa fa-thumbs-o-up fa-fw";
													}
													else{
														$titulo = "Ativar";
														$param_titulo = "ativar";
														$cor = "color:red;";
														$class_ativ_desat = "fa fa-thumbs-o-down fa-fw";
													}
													?>
													<td><a title="<?php echo $titulo;?>" href="index.php?pg=empresa&filtrar=<?php echo $_REQUEST["filtrar"]?>&pesquisar_empresa=<?php echo $_REQUEST["pesquisar_empresa"]?>&<?php echo $param_titulo?>=<?php echo $res["chave"];?>" style="<?php echo $cor;?>"><i class="<?php echo $class_ativ_desat?>"></i></a></td>
												<?php
												}?>
											</tr>
											<?php
											}
										}
										else
											msg('4','Informação inexistente.','','','','');
										?>
									</tbody>
									<tfoot>
										<?php
										//Verificar a pagina anterior e posterior
										$pagina_anterior = $pagina - 1;
										$pagina_posterior = $pagina + 1;
										?>
										<tr>
											<td colspan="9">
												<div class="dataTables_paginate paging_bootstrap" style="text-align: center;">
													<ul class="pagination">
														<?php
														if ($pagina_anterior != 0){?>
															<li><a href="index.php?pg=clienteEmpresa&pagina=<?php echo $pagina_anterior;?>&filtrar=<?php echo $filtrou;?>&pesquisar_empresa=<?php echo $pesquisar;?>">← Anterior</a></li>
														<?php
														}else{?>
															<li class="prev disabled"><a>← Anterior</a></li>
														<?php
														} 
														for ($i=1;$i<=$num_paginas;$i++){
															$estilo = "";
															if ($pagina == $i)  $estilo = "class=\"active\"";?>
																<li <?php echo $estilo;?> ><a href="index.php?pg=clienteEmpresa&pagina=<?php echo $i;?>&filtrar=<?php echo $filtrou;?>&pesquisar_empresa=<?php echo $pesquisar;?>"><?php echo $i;?></a></li>
														<?php
														}?>
														<?php
														if($pagina_posterior <= $num_paginas){ ?>
															<li class="next"><a href="index.php?pg=clienteEmpresa&pagina=<?php echo $pagina_posterior;?>&filtrar=<?php echo $filtrou;?>&pesquisar_empresa=<?php echo $pesquisar;?>">Próximo → </a></li>
														<?php }else{ ?>
															<li class="prev disabled"><a>Próximo → </a></li>
														<?php
														}?>
													</ul>
												</div>
											</td>
										</tr>
									</tfoot>
								</table>
								<?php
								}?>
							</div>
						</div>
					</div>	  
				</div>
			<?php
			}
			?>

		<?php
		form_fim();
		?>
		</div>
	</div>
<?php
} else {
	echo '<br>';
	msg('4','Acesso não autorizado. Redirecionamento para a tela de login.','1','5','login.php','');
}
?>