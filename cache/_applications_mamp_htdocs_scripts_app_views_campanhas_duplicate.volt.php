<style type="text/css">
	.table > tbody > tr{
		cursor: pointer;
	}
	.table > tbody > tr:hover{
		background-color: #cccccc;
	}
</style>

<div class="logout-box">
	<button id="logout-btn" type="button" class="btn btn-danger dimiss-after" data-dismiss="modal">Logout</button>
	<a href="/menu"><button id="voltar-btn" type="button" class="btn btn-warning" data-dismiss="modal">Voltar</button></a>
</div>

<div class="logo-div">
	<img src="/images/czmb-logo-black.svg">
</div>

<div class="page-header">
    <h1>
        Duplicar Campanha
    </h1>
</div>

<?= $this->getContent() ?>

<label for="type">Selecione a campanha a ser duplicada</label>
<br>
<table class='table'>
	<thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
        </tr>
    </thead>
     <tbody>
    <?php foreach ($campanhas as $campanha) { ?>
	    <tr>
	        <td><?= $campanha->id ?></td>
	        <td><?= $campanha->nome ?></td>
	    </tr>
	<?php } ?>
	</tbody>
</table>
<br>

<div class="row">
	<div class="col-md-6 col-md-offset-5">
		<button type="button" class="btn btn-success" id="seeall">Visualizar Todas</button>
	</div>
</div>

<!-- Modal -->


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" id="myModalLabel">Duplicar campanha <span id="campanha_id"></span></h4>
      </div>
      <div class="modal-body">
      	<div id="loader" class="loader"></div>
      	<div id="campaign_info">
      		<div class="row campaign_info">
		      	<div class='col-md-5'>
		      		<h4 class="modal-title modal-label-margin-bottom">Resumo</h4>
			      	<p>Id: <span class="campaign_data" id="campanha_id_2"></span></p>
			      	<p>Anunciante: <span class="campaign_data" id="campanha_anunciante"></span></p>
			      	<p>Tipo dee Remuneração: <span class="campaign_data" id="campanha_tipo_remuneracao"></span></p>
			      	<p>Quantidade de Banners: <span class="campaign_data" id="campanha_qtd_banners"></span></p>
			      	<p>Campanha Ativa: <span class="campaign_data" id="campanha_ativa"></span></p>
			      	<p>Campanha Encerrada: <span class="campaign_data" id="campanha_encerrada"></span></p>
				</div>
	      	</div>

	      	<h4 class="modal-title" id="myModalLabel">Período de Veiculação</h4>
	      	<br>
	        <div class="row">
			    <div class='col-md-5'>
			        <div class="form-group">
			        	<label>Inicio</label>
			            <div class='input-group date' id='datetimepickerstart'>
			                <input type='text' class="form-control" id="datetimepickerstart-input"/>
			                <span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
			            </div>
			        </div>
			    </div>
			    <div class='col-md-5'>
			        <div class="form-group">
				        <label>Fim</label>
			            <div class='input-group date' id='datetimepickerfinal'>
			                <input type='text' class="form-control" id="datetimepickerfinal-input"/>
			                <span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
			            </div>
			        </div>
			    </div>
			</div>
	        <div class="panel panel-default" id="error-box">
			  <div class="panel-body">
			    <span id="error-text"></span>
			  </div>
		  	</div>
	      </div>
	      <div class="modal-footer">
	      	<button id="fechar-btn" type="button" class="btn btn-success">Fechar</button>
	        <button type="button" class="btn btn-danger dimiss-after" data-dismiss="modal">Cancelar</button>
	        <button type="button" class="btn btn-primary dimiss-after" id="btn-duplicar">Duplicar</button>
	      </div>
      	</div>
    </div>
  </div>
</div>

<script type="text/javascript">
window.onload = function(){
	function getQueryStringValue (key) {  
		return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));  
	}  

	if(getQueryStringValue("all") == 1){
		$("#seeall").hide();		
	}

	var data = {
		"id" : null,
		"start" : null,
		"final" : null
	};

	$("#seeall").click(function(){
		window.location.href = window.location+"?all=1";
	});

	$('#datetimepickerstart').datepicker({
	    maxViewMode: 0,
	    language: "pt-BR",
	    todayHighlight: true,
	    toggleActive: true,
	    startDate: new Date(),
	});

	$('#datetimepickerfinal').datepicker({
	    maxViewMode: 0,
	    language: "pt-BR",
	    todayHighlight: true,
	    toggleActive: true,
	    startDate: new Date(),
	});

	$("#datetimepickerstart").datepicker('update', new Date());

	$("#datetimepickerfinal").datepicker('update', new Date());


	$("#datetimepickerstart-input").change(function() {	
	  $('#datetimepickerfinal-input').val('');

	  if($(this).val() == ''){
	  	$('#datetimepickerfinal-input').prop('disabled', true);
	  }else{
	  	$('#datetimepickerfinal').datepicker('remove');
	  	$('#datetimepickerfinal').datepicker({
		    maxViewMode: 0,
		    language: "pt-BR",
		    toggleActive: true,
		    startDate: $(this).val(),
		});
		$("#datetimepickerfinal").datepicker('update', $(this).val());

	  	$('#datetimepickerfinal-input').prop('disabled', false);

	  }
	});

	//Inicialização dos componentes do modal como hidden elements
   	$('#loader').hide();
   	$('#campaign_info').hide();
   	$('#fechar-btn').hide();

	$("table > tbody > tr").click(function(){
		$("#datetimepickerstart").datepicker('update', new Date());
		
		data.id = $(this).children().html();

		$('#loader').hide();
   		$('#campaign_info').hide();
   		$('#error-box').hide();
		
		$('#myModal').modal({backdrop: 'static', keyboard: false});
		
		$('#loader').show();

		$.ajax({
			method: "GET",
			url: "get/" + data.id,
		}).done(function(msg) {
			$('#loader').hide();
		   	$('#campaign_info').show();

			$('#campanha_id').text(data.id);
			$('#campanha_id_2').text(data.id);
			$('#campanha_anunciante').text(msg['anunciante']);
			$('#campanha_tipo_remuneracao').text(msg['tipo_remuneracao']);
			$('#campanha_qtd_banners').text(msg['total_banners']);

			if(msg['ativo'] == 1){
				$('#campanha_ativa').text('Sim');
				$('#campanha_ativa').removeClass('red_text');
				$('#campanha_ativa').addClass('green_text');
			}else{
				$('#campanha_ativa').text('Não');
				$('#campanha_ativa').removeClass('green_text');
				$('#campanha_ativa').addClass('red_text');
			}

			if(msg['encerrada'] == 1){
				$('#campanha_encerrada').text('Sim');
				$('#campanha_encerrada').removeClass('red_text');
				$('#campanha_encerrada').addClass('green_text');
			}else{
				$('#campanha_encerrada').text('Não');
				$('#campanha_encerrada').removeClass('green_text');
				$('#campanha_encerrada').addClass('red_text');
			}			

			
		});
	});

	$("#btn-duplicar").click(function(){
		data.start = $('#datetimepickerstart-input').val();
		data.final = $('#datetimepickerfinal-input').val();

		$('#campaign_info').hide();
		$('.modal-footer').hide();
		$('.close').hide();
		$('#loader').show();

		$.ajax({
			method: "POST",
			url: "duplicate",
			data: data
		}).done(function(msg) {
			$('#error-box').text(msg['message']);
			
			if (msg['success'] == 'true') {
				$('#error-box').removeClass('red-box');
				$('#error-box').addClass('green-box');
			}else{
				$('#error-box').removeClass('green-box');
				$('#error-box').addClass('red-box');
			}	

			$('#loader').fadeOut('slow');
   			$('#campaign_info').delay(600).fadeIn('slow');

   			$('#fechar-btn').show();
   			$('.dimiss-after').hide();

   			$('.modal-footer').delay(600).fadeIn();

   			$('#error-box').delay(800).slideDown('slow');
		});
	});

	$('#fechar-btn').click(function(){
		location.reload();
	});

	$('#logout-btn').click(function(){
		$.ajax({
			method: "POST",
			url: "../campanhas/reset",
			data: data
		}).done(function(msg) {
			window.location.replace("../login");
		});
	});
};

</script>