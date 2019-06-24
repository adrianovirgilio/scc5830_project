<?php error_reporting(0);
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
     <link rel="icon" type="image/ico" href="images/icons/zaz.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Final Project scc5830</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
 $('#exampleModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Botão que acionou o modal
		  var recipient = button.data('whatever') // Extrai informação dos atributos data-*
		  // Se necessário, você pode iniciar uma requisição AJAX aqui e, então, fazer a atualização em um callback.
		  // Atualiza o conteúdo do modal. Nós vamos usar jQuery, aqui. No entanto, você poderia usar uma biblioteca de data binding ou outros métodos.
		  var modal = $(this)
		  modal.find('.modal-title').text('Nova mensagem para ' + recipient)
		  modal.find('.modal-body input').val(recipient)
	})
	  
</script>
  </head>
  <body>
  <div class="w3-sidebar w3-bar-block w3-green w3-xxlarge" style="width:70px">
			<a href="index.html"  title="Home"class="w3-bar-item w3-button"><i class="fa fa-home"></i></a> 
			<a href="gerar_excel.php" title="Generate and download excel file" class="w3-bar-item w3-button"><i class="fa fa-table"></i></a>  
			<a href="carregar_imagem_t_automatico.php" title="Back" class="w3-bar-item w3-button"><i class="fa fa-arrow-circle-left"></i></a> 
			<a href="logout.php" title="Exit" class="w3-bar-item w3-button"><i class="fa fa-power-off"></i></a> 
  </div>
 <div style="margin-left:70px">
 <div class="w3-container" style="position:relative:float:left;" >
 <h2>GIIA - Result:</h2>
<?php
	$excel = "RGB" ;
	require('ImageProcessing.php');
	$file = $_FILES['imagem']['name'];
	$diretorio =  'imagens/';	
	if(!move_uploaded_file($_FILES['imagem']['tmp_name'],$diretorio . $_FILES["imagem"]["name"]))
		{
		 print_r ($_FILES);
		}

		$input =  ImageProcessing::createImageFromFile($diretorio.$file);
		imagejpeg($input,$diretorio.$file);
		$newFile = implode('-bin.', explode('.', $file));		
		$output = ImageProcessing::autoThreshold($input);
		imagejpeg($output,'imagens/'.$newFile);	
		$imagemComFundoBranco = ImageProcessing::getBackgroundWhiteImage($input,$output);
		$newFileWhite = implode('-fundobranco.', explode('.', $file));	
		imagejpeg($imagemComFundoBranco, 'imagens/'.$newFileWhite);
		$html = '';
		$html .= '<table class="table table-hover table-bordered">';
		$html .= '<thead><tr class="table-success">';		
		$html .= '<th>Input image:</th>';
		$html .= '<th>Output (binarized image):</th>';
		$html .= '<th>Output (background image removed)</th>';
		$html .= '<th>R</th>';
		$html .= '<th>G</td>';
		$html .= '<th>B</th>';
		$html .= '<th>Gn</th>';
		$html .= '<th>V</th>';
		$html .= '<th>ExG</th>';
		$html .= '<th>ExGR</th>';
		$html .= '<th>MExG</th>';
		$html .= '<th>CIVE</th>';
		$html .= '<th>VEG</th>';
		$html .= '<th>COM</th>';
		//Fim da linha do cabeçalho
		$rgb = ImageProcessing::getAverageRGBFromImageWithBinary($input,$output);	
		$R = $rgb['r'];
		$G = $rgb['g'];
		$B = $rgb['b'];
		$hsv = ImageProcessing::convertRGBtoHSL($R,$G,$B);
		$H = $hsv['h'];
		$S = $hsv['s'];
		$V = $hsv['v'];
		$html .= '</tr></thead><tbody>';
		$html .= "<td><strong><a href='". $diretorio.$file ."' target='_blank' title='Clique aqui para visualizar a imagem de entrada...'>$file</a></strong></td>";
		$html .= "<td><strong><a href='". $diretorio.$newFile ."' target='_blank'title='Clique aqui para visualizar a imagem de saída'>$newFile</a></strong></td>";
		$html .= "<td><strong><a href='". $diretorio.$newFileWhite."' target='_blank'title='Clique aqui para visualizar a imagem de saída'>$newFileWhite</a></strong></td>";
		$html .= '<td>' . number_format($R,3,",",".") . '</td>';
		$html .= '<td>' . number_format($G,3,",",".") . '</td>';
		$html .= '<td>' . number_format($B,3,",",".") . '</td>';
		// Gn - G/(R+G+B) -  Yang et al. (2015) 
		$Gn = $G/($R+$G+$B);
		$html .= '<td>' . number_format($Gn,3,",",".") . '</td>';
		$Rn = $R/($R+$G+$B);
		$Bn = $B/($R+$G+$B);
		 //V (Brilho) - 	Maximo(RGB)/255 -  Wang et al. (2013)
		 $html .= '<td>' . number_format($V,3,",",".") . '</td>';
		//Excesso de Verde - ExG= (2*GN)−RN−BN - Guijarro et al. (2011) e Yang et al. (2015)
		$ExG = (2*$Gn)-$Rn-$Bn; // OK
		$html .= '<td>' . number_format($ExG,3,",",".") . '</td>';
		//Excesso de Vermelho - ExR= (1,4*RN)−GN - Guijarro et al. (2011) 
		$ExR= (1.4 * $Rn)-$Gn; //OK
		//Excess green minus excess red - ExGR = ExG – ExR  - Guijarro et al. (2011) e Yang et al. (2015)
		$ExGR = $ExG - $ExR; //OK
		$html .= '<td>' . number_format($ExGR,3,",",".") . '</td>';
		//  =1,262*I3-0,884*H3-0,311*J3  // (I3 = $G)  (H3 = $R) (J3 = $B) 
		$MExG =  1.262 * $G -0.884*$R -0.311*$B;
		$html .= '<td>' . number_format($MExG,3,",",".") . '</td>';
		//CIVE - CIVE = 0.441RN – 0.811GN + 0.385BN + 18.78745 - Guijarro et al. (2011) e Yang et al. (2015)
		$CIVE = (0.441 * $Rn) - (0.811 * $Gn) + (0.385 * $Bn) + 18.78745;
		$html .= '<td>' . number_format($CIVE,3,",",".") . '</td>';
		//VEG - VEG= GN/(RN0,667)*(BN*0,333) - Guijarro et al. (2011) e Yang et al. (2015)
		$VEG= $Gn/ (pow($Rn,0.667) * pow($Bn,0.333));
		$html .= '<td>' . number_format($VEG,3,",",".") . '</td>';
		//COM - 0,25ExG + 0,30ExGR + 0,33CIVE + 0,12VEG - Yang et al. (2015)
		$COM = (0.25 * $ExG) + (0.30 * $ExGR) + (0.33 * $CIVE) + (0.12 * $VEG);
		$html .= '<td>' . number_format($COM,3,",",".") . '</td>';
		$html .= '</tr>';
		$html .='</tbody></table>';
		$_SESSION['html'] = $html;
		$_SESSION['nome'] = $excel;
		echo $html;
?>
 <div class="text-center" style="position:relative:float:left;">
   	 <img src="<?php echo $diretorio .   $newFileWhite;?>" width="50%" height="50%" 
     		class="img-fluid img-thumbnail" data-toggle="modal" data-target="#modalExemplo"
            title="Clique para visualizar as imagens processadas.">
	</div>
    
</div>
	
  </div>
        

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
    <!-- Modal -->
<div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body" >
       <img src="<?php echo $diretorio .   $file;?>"  class="img-fluid img-thumbnail">
	   <img src="<?php echo $diretorio .   $newFile;?>"  class="img-fluid img-thumbnail" > 
	   <img src="<?php echo $diretorio .   $newFileWhite?>"  class="img-fluid img-thumbnail" >                     
      </div>
      
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
 
  </div>
</div>
<!-- FIM Modal -->
  </body>
</html>

