<!DOCTYPE html>
<html><head>
 <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <link rel="icon" type="image/ico" href="images/icons/zaz.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
   <title>GIIA - Projeto de Mestrado - Carregando imagens</title>
     <script>
	  var openFile = function(event) {
		var input = event.target;
		var reader = new FileReader();
		reader.onload = function(){
		  var dataURL = reader.result;
		  var output = document.getElementById('output');
		  output.src = dataURL;
		};
		reader.readAsDataURL(input.files[0]);
	  };
	  
	  
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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="w3-sidebar w3-bar-block w3-green w3-xxlarge" style="width:70px">
  <a href="principal.php" title="Home"class="w3-bar-item w3-button"><i class="fa fa-home"></i></a> 
  <a href="principal.php" title="Back" class="w3-bar-item w3-button"><i class="fa fa-arrow-circle-left"></i></a>  
  <a href="logout.php" title="Exit" class="w3-bar-item w3-button"><i class="fa fa-power-off"></i></a> 
</div>
<div style="margin-left:70px">
<div class="w3-container">
<h2>GIIA - 
Select a saved image on your computer:</h2>
<form action='processa_t_automatico.php'  method='post' encType="multipart/form-data">    
    <div class="input-group">
         <div class="custom-file">
            <input type="file" name="imagem" class="custom-file-input" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" accept='image/*' onchange='openFile(event)'>
            <label class="custom-file-label" for="inputGroupFile04">Click here to select an image</label>
         </div>
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04">Submit</button>
          </div>
	</div>
  <!-- <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" /> -->
    </form>    
    
   
    
    <div class="text-center">
    <img id='output' width="50%" height="50%" class="img-fluid img-thumbnail">
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
        <h5 class="modal-title" id="exampleModalLabel">Configuração do Threshold</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form name="threshold" method="#">
      <div class="modal-body">
       
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Valor atual do THRESHOLD:</label>
            <input type="text" class="form-control" id="recipient-name" name="valor_threshold" value="<?php echo $_SESSION['threshold'];?>">
          </div>
         
        
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" s class="btn btn-success">Salvar mudanças</button>
      </div>
    </div>
    </form>
  </div>
</div>
<!-- FIM Modal -->


</body>
</html>