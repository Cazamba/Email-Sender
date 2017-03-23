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
        Relatório por estado
    </h1>
</div>

<?= $this->getContent() ?>

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
        <h3 class="modal-title" id="myModalLabel">Gerar relatório por estado <span id="campanha_id"></span></h4>
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
	      	<hr>
	      	<div class="form-group">
		      <label for="sel-tipo">Selectione o parâmetro para o relatório</label>
		      <select class="form-control" id="sel-tipo">
		        <option value="click">Click</option>
		        <option value="interaction">Interação</option>
		        <option value="print">Prints</option>
		      </select>	      		 
	      	</div>
			</div>
	        <div class="panel panel-default" id="result-box">
		  	</div>
	      </div>
	      <div class="modal-footer">
	      	<button id="fechar-btn" type="button" class="btn btn-success">Fechar</button>
	        <button type="button" class="btn btn-danger dimiss-after" data-dismiss="modal">Cancelar</button>
	        <button type="button" class="btn btn-primary dimiss-after" id="btn-relatorio">Ver Relatório</button>

	       	<form action="../banners/export" id="export-form" method="POST"> 
    			<input id="export-input" type="hidden" name="table" value="">
    			<input class="btn btn-success" type="submit" value="Exportar em xls">
    		</form>

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
		"tipo" : null,
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

	//Inicialização dos componentes do modal como hidden elements
   	$('#loader').hide();
   	$('#campaign_info').hide();
   	$('#fechar-btn').hide();

	$("table > tbody > tr").click(function(){
		
		data.id = $(this).children().html();

		//botoes de exportacao
		$("#export-form").hide();
		$("#btn").hide();


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

	$("#btn-relatorio").click(function(){
		$("#result-box").hide();
		$("#result-box").html("");
	
		data.tipo = $("#sel-tipo").val();

		swal({
		  title: "Gerar relatório baseado em " + data.tipo,
		  type: "warning",
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Gerar relatório!",
	 	  cancelButtonText: "Não, cancelar!",

		  showCancelButton: true,
		  closeOnConfirm: false,
		  showLoaderOnConfirm: true,
		},	
		function(){
			$.ajax({
				method: "POST",
				url: "../campanhas/relatorio",
				data: data
			}).done(function(msg) {
				if(msg['success'] == 'false'){
					swal("Erro!", msg['message'] , "error");
				}else{	
				  	swal({title:"", timer:1});
				  	//Criar tabela com dados

				  	var str = '<table id="headerTable" class="table table-hover">';
						str += '<thead>';
						str += '<th>Estado</th>';
						str += '<th>Valor</th>';
						str += '</thead>';

						$.map(msg['retorno'], function(value, index) {
							str += '<tr>';
							str += '<td>' + index +'</td>';
							str += '<td>' + value +'</td>';
							str += '</tr>';
						});

						str += '</table>';

					$("#result-box").html(str);
					$("#export-input").val(str);
					$("#result-box").show("slow");
					$("#export-btn").show("slow");
					$("#export-form").show("slow");
				}	
			});

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