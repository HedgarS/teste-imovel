		
function gravar_imovel(){
	
	var url_site = $('#URL_SITE').val();
	var msg				 = [];
	var err_campo		 = 0;
		
	var campos = {
		DEN_ENDERECO 	: '',
		FLOAT_PRECO		: 0,
	}
	
	var dados = { 
		ID					: $('input[name="ID_IMOVEL"]').val(),
		DEN_ENDERECO		: $('input[name="DEN_ENDERECO"]').val(),
		FLOAT_PRECO 		: $('input[name="FLOAT_PRECO"]').val(),
		FLAG_STATUS 		: $('input[name=FLAG_STATUS]:checked').val(),
		FLAG_TIPO 			: $('input[name=FLAG_TIPO]:checked').val(),
		
	}

	$.each( campos, function( chave, valor ) {
		$('input[name="'+chave+'"]').css('border-color', '#E5E5E5');
		$('input[name="'+chave+'"]').css('border-width', '1px');
		if( $.trim($('input[name="'+chave+'"]').val()) == valor ) {
			err_campo++;
			$('input[name="'+chave+'"]').css('border-color', '#c00');
			$('input[name="'+chave+'"]').css('border-width', '1px');
			if(err_campo == 1 ){
				msg.push('- Preencha os campos destacados em vermelho \n');
			}
			
		}
	});
	
	if(err_campo > 0) {
			msg_erro('Preencha os campos destacados em vermelho');
	}else {
		$.ajax({
				type: 'post',
				data:{
					dados	: dados,
					acao	: 'I',
				},
				dataType: 'json',
				url: url_site+'model_imoveis.php',
				success: function(json){
					if(json.classe == 'success'){
						Swal.fire({
							timer: 2500,
							icon: 'success',
							timerProgressBar: true,
							text: json.msg,
							showConfirmButton: false,
						}).then((result) => {
							
							if(json.func == 'I'){
								limpar_campos();
							}else if( json.func == 'A'){
								location.href = url_site+'lista_registros.php';
							}
						});
					
					}else{
						msg_erro(json.msg);
					}
				}
		});
	}
}



function limpar_campos(){
	$('input[name="DEN_ENDERECO"]').val('');
	$('input[name="FLOAT_PRECO"]').val('');
	$("input[name=FLAG_STATUS][value='D']").prop("checked",true);
	$("input[name=FLAG_TIPO][value='C']").prop("checked",true);
}

function msg_erro(msg){
	Swal.fire({
		  icon:  'error',
		  title: 'Erro',
		  text:  msg,
		  showConfirmButton: false,
		  timer: 1500
	});
}
