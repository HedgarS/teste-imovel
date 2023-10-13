<?php 
	require_once('config.php');
	
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<?php require_once('includes/head.php');?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
		<script type="text/javascript">
				$(function() {
					lista_imoveis();
					
				});
				
		
			function lista_imoveis(){
				var url_site = $('#URL_SITE').val();
				$.ajax({
					type: 'post',
					data:{
						acao	: 'L',
					},
					dataType: 'json',
					url: url_site+'model_imoveis.php',
					success: function(json){
						
						$('#lista_imoveis > tbody').empty();
						if (json.length === 0) {
							$('#lista_imoveis > tbody').html('<tr><td align="center" colspan="6">Nenhum imóvel cadastrado</td></tr>');
							
						}else{
							$.each( json, function( id, dados ) {
								var	lin = '<tr id="tr_'+dados['ID']+'">';
								lin += '<td align="center">'+dados['ID']+'</td>';
								lin += '<td> '+dados['DEN_ENDERECO']+'</td>';
								lin += '<td> '+dados['FLOAT_PRECO']+'</td>';
								lin += '<td> '+dados['STATUS']+'</td>';
								lin += '<td> '+dados['TIPO']+'</td>';
								lin += '<td align="center"><a  class="btn badge" href="'+url_site+'cadastro.php?id='+dados['ID']+'">editar</a></td>';
								lin += '<td align="center"><a href="javascript:void(0);" class="btn badge" onclick="delete_imovel('+dados['ID']+');">excluir</a></td>';
								lin += '</tr>';
								
								$('#lista_imoveis > tbody').append(lin);
							});
						}

					}
				});
			}
			
			function delete_imovel(id_imovel) {
				
				var url_site = $('#URL_SITE').val();
				
				Swal.fire({
				  title: 'Tem certeza?',
				  text: "deseja realmente excluir o registro?",
				  icon: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#66B3FF',
				  cancelButtonColor: '#FF6C6C',
				  confirmButtonText: 'Sim, Excluir!'
				}).then((result) => {
					
				  if (result.isConfirmed) {
					Swal.fire(
					  'Excluído!',
					  'Registro excluído com sucesso',
					  'success'
					);
					
					$.ajax({
						type: 'post',
						data:{
							id		: id_imovel,
							acao	: 'E'
						},
						dataType: 'json',
						url: url_site+'model_imoveis.php',
						success: function(json){
							if(json.classe == 'success'){
								$('#tr_'+id_imovel).hide();
							}
						}
					});
				  }
				});	
			}
		</script>
	</head>

    <body>
	
		<header>
			<?php require_once('includes/menu.php');?>
        </header>
		
		<main class="conteudo">
		<div style="max-width:100%;" class="col-10">
			<div class="topo_pagina">
				<h1 align="left">Registros</h1>
			</div>
			
			<div class="container_conteudo">
				<input type="hidden" id="URL_SITE" value="<?php echo URL_SITE;?>"/>
				<table id="lista_imoveis" class="table table-bordered">
					<thead>
					<tr>
						<th style="width:50px; text-align:center;">Cód</th>
						<th>Endereço</th>
						<th>Preço</th>
						<th>Status</th>
						<th>Tipo</th>
						<th colspan="2">&nbsp;</th>
					<tr/>
					<thead>
					<tbody></tbody>
				</table>
			</div>
			</div>
        </main>
    </body>
</html>