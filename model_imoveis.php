<?php
	require_once('config.php');
		
	switch($_POST['acao']){
		
		case 'L':
			
			 $sql = "select ID,
							FLAG_TIPO,
							FLAG_STATUS,
							DEN_ENDERECO,
							FLOAT_PRECO
					from tbimovel where ID > 0";
			 $qry = $cnx->prepare(utf8_decode($sql));
			 $sucess = $qry->execute();
			 
			 $tpl = $qry->fetchAll(PDO::FETCH_ASSOC);
			 
			 $tipo 		= array('A' => 'Apartamento', 'C'	=> 'Casa', 		'T'	=> 'Terreno' );
			 $status 	= array('D' => 'Disponivel',  'A'	=> 'Alugado', 	'V'	=> 'Vendido' );
			 $ret 		= array();
			 foreach($tpl as $dados ){
				
				$ret[] = array( 
				 'ID'			=> $dados['ID'],
				 'DEN_ENDERECO'	=> $dados['DEN_ENDERECO'],
				 'FLOAT_PRECO'	=> numero($dados['FLOAT_PRECO'], 'br'),
				 'TIPO'			=> $tipo[$dados['FLAG_TIPO']],
				 'STATUS'		=> $status[$dados['FLAG_STATUS']],
				 );
			 }
			 
			echo json_encode($ret);
			
		break;
	
		case 'A':
			$id = $_POST['id'];
			
			 $sql = "select ID,
							FLAG_TIPO,
							FLAG_STATUS,
							DEN_ENDERECO,
							FLOAT_PRECO
					from tbimovel where ID = ".$id."";
			 $qry = $cnx->prepare(utf8_decode($sql));
			 $sucess = $qry->execute();
			 
			 $tpl = $qry->fetchAll(PDO::FETCH_ASSOC);
			 
			 $tipo 		= array('A' => 'Apartamento', 'C'	=> 'Casa', 		'T'	=> 'Terreno' );
			 $status 	= array('D' => 'Disponivel',  'A'	=> 'Alugado', 	'V'	=> 'Vendido' );
			 $ret 		= array();
			 foreach($tpl as $dados ){
				
				$ret = array( 
				 'ID'			=> $dados['ID'],
				 'DEN_ENDERECO'	=> $dados['DEN_ENDERECO'],
				 'FLOAT_PRECO'	=> numero($dados['FLOAT_PRECO'], 'br'),
				 'FLAG_TIPO'	=> $dados['FLAG_TIPO'],
				 // 'TIPO'		=> $tipo[$dados['FLAG_TIPO']],
				 // 'STATUS'	=> $status[$dados['FLAG_STATUS']],
				 'FLAG_STATUS'	=> $dados['FLAG_STATUS'],
				 );
			 }
			 
			echo json_encode($ret);
			
		break;
		
		case 'I':
			$flag_tipo  		= $_POST['dados']['FLAG_TIPO'];	
			$falg_status  		= $_POST['dados']['FLAG_STATUS'];			
			$den_endereco   	= utf8_encode($_POST['dados']['DEN_ENDERECO']);
			$float_preco  		= numero($_POST['dados']['FLOAT_PRECO'], 'en');				
			$id					= $_POST['dados']['ID'];
			
			if( $id == 0 ) {
				$sql = "insert into tbimovel(
							FLAG_TIPO,
							FLAG_STATUS,
							DEN_ENDERECO,
							FLOAT_PRECO
						)values(
						   '".$flag_tipo."',
						   '".$falg_status."',
						   '".$den_endereco."',
						   ".floatval($float_preco)."
						)";
				 $qry = $cnx->prepare(utf8_decode($sql));
				 $sucess = $qry->execute();
			
				 if( $sucess == 1 ){	
					$ret = array('classe' => 'success', 'msg' 	=> 'Cadastro realizado com sucesso','func' =>  'I');

				 }else{
					$ret = array('classe' => 'errror', 'msg' 	=> 'Erro ao realizar cadastro');
				 }
				
			}else{
				$sql = "UPDATE  tbimovel SET
							FLAG_TIPO		= '".$flag_tipo."',
				            FLAG_STATUS		= '".$falg_status."',
				            DEN_ENDERECO	= '".$den_endereco."',
				            FLOAT_PRECO		= ".$float_preco."
						WHERE ID = ".$id." ";
	
				 $qry = $cnx->prepare(utf8_decode($sql));
				 $sucess = $qry->execute();
			
				 if( $sucess == 1 ){	
				 	$ret = array('classe' => 'success', 'msg' 	=> 'Imovel #'.$id.' realizado com sucesso', 'func' =>  'A');

				 }else{
					$ret = array('classe' => 'errror', 'msg' 	=> 'Erro ao realizar alteração no imovel #'.$id	);
				 }
			}
			
			 echo json_encode($ret);die();

		break;
		
		case 'E':
			
			$sql = "delete from tbimovel where ID = '".$_POST['id']."'";
			
			$qry = $cnx->prepare(utf8_decode($sql));
			$sucess = $qry->execute();
			
			if($sucess == 1) {
				$ret = array(
					'msg' => 'Imóvel excluído com sucesso', 'classe'	=> 'success', 'ico'	=> 'check-circle' 
				);
				
			}else {
				$ret = array(
					'msg'	=> 'Ocorreu um erro ao excluir o Imóvel, tente novamente!', 'classe'	=> 'danger', 'ico'	=> 'times-circle-o'
				);
			}
			
			echo json_encode($ret);die();
		break;
	}
	
		
	function numero($num_base, $lang = 'br', $dec = 2) {
		$num = trim($num_base);
		
		if($lang == 'br') {
			$ret = (is_numeric($num)) ? number_format ($num, $dec, ',', '.') : '0,00';
		}
		
		if($lang == 'en') {
			$num = str_replace(',', '.', str_replace('.', '', $num));
			$ret = is_numeric($num) ? number_format ( $num, $dec, '.' , '') : 0;
		}

		return ($ret);
	}
	
		


?>