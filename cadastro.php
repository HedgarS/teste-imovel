<?php 
 require_once('config.php');
 $tittle =  'Cadastrar novo Cliente';
 
 $id = isset($_GET['id']) ? $_GET['id'] : 0 ;
 
 $tittle = $id <= 0 ? 'Cadastrar novo imóvel' : 'Editar imóvel #'.$id;
 
 

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<?php require_once('includes/head.php');?>
	</head>
		
    <body>
		<style>
			.col-5{
				margin-bottom:15px;
			}
		
		</style>
		<header>
			<?php require_once('includes/menu.php');?>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>

			<script type="text/javascript">
				$(function() {
					$("#cep").mask("99.999-999");
					$("#DATA_NASCIMENTO").mask("99/99/9999");
					$('.decimal2').mask("###.###.###,##", {reverse: true});

					limpar_campos();
					
					get_imovel();
					
				});
				
				
				function get_imovel(){
						var url_site = $('#URL_SITE').val();
						var id		 = $('#ID_IMOVEL').val();
						$.ajax({
							type: 'post',
							data:{
								acao	: 'A',
								id		: id,
							},
							dataType: 'json',
							url: url_site+'model_imoveis.php',
							success: function(dados){
								$("input[name=FLAG_TIPO][value='"+dados['FLAG_TIPO']+"']").prop("checked",true);
								$("input[name=FLAG_STATUS][value='"+dados['FLAG_STATUS']+"']").prop("checked",true);
								$("input[name=DEN_ENDERECO]").val(dados['DEN_ENDERECO']);
								$("input[name=FLOAT_PRECO]").val(dados['FLOAT_PRECO']);
							}
						});
				}
				
			</script>
        </header>
		<main class="conteudo">
					
			<div class="topo_pagina">
				<h1 align="center"><?php echo $tittle;?></h1>
			</div>
			<div class="col-10" style="max-width:100%" align="center">
			<div class="container_conteudo" style="">
				<?php	if( $id > 0 ){ ?>
						<div class="col-5">
							<a style="float:right;" class="btn badge-primary" href="<?php echo URL_SITE;?>lista_registros.php">&nbsp; Voltar</a>
							<br clear="both">
						</div>
				<?php	} ?>
			
			
				<div class="formularios">
					<input type="hidden" id="URL_SITE"	value="<?php echo URL_SITE;?>"/>
					<input type="hidden" id="ID_IMOVEL" name="ID_IMOVEL"	value="<?php echo $id;?>"/>
					<form id="form-cadastro-menu" enctype="multipart/form-data"  method="post">
						
						<div class="col-5">
							<div class="row justify-content-start">
								<label class="custom-control-label">Status</label>
							</div>
							<div class="row justify-content-start" >
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="FLAG_STATUS" value="D" /> 
									<label class="form-check-label" for="FLAG_STATUS">Disponivel</label>
								</div>
								
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="FLAG_STATUS" value="A" /> 
									<label class="form-check-label" for="FLAG_STATUS">Alugado</label>
								</div>
								
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="FLAG_STATUS" value="V" /> 
									<label class="form-check-label" for="FLAG_STATUS">Vendido</label>
								</div>
							</div>
						</div>
						<div class="col-5">
							<div class="row justify-content-start">
								<label class="custom-control-label">Tipo</label>
							</div>
							
							<div class="row justify-content-start">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="FLAG_TIPO" value="C" /> 
									<label class="form-check-label" for="FLAG_TIPO">Casa</label>
								</div>
						
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="FLAG_TIPO" value="A" /> 
									<label class="form-check-label" for="FLAG_TIPO">Apartamento</label>
								</div>
								
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="FLAG_TIPO" value="T" /> 
									<label class="form-check-label" for="FLAG_TIPO">Terreno</label>
								</div>
							</div>
							
						</div>
						
						<div class="col-5">
							<div class="row justify-content-start">
								<label class="custom-control-label">Endereço</label>
							</div>
							<div class="row justify-content-start">
								<input class="custom-control" id="DEN_ENDERECO" type="text" name="DEN_ENDERECO" value="" />
							</div>
						</div>
						
						<div class="col-5">
							<div class="row justify-content-start">
								<label class="custom-control-label">Preço</label>
							</div>
							<div class="row justify-content-start">
								<input class="custom-control decimal2" type="text" id="FLOAT_PRECO" name="FLOAT_PRECO" value="" />
							</div>
						</div>
						<div class="clear"></div>
						
					</form>
				</div>
				<div align="center" style="margin-top:10px;" class="col-5">
					<a class="btn badge-primary" onclick="gravar_imovel();"> <i class="fa fa-check-circle"></i>&nbsp; gravar</a>
				</div>
				
			</div>
			</div>
        </main>
    </body>
</html>

