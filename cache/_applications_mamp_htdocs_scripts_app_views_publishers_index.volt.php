<div class="container logout-box">
	<button id="logout-btn" type="button" class="btn btn-danger dimiss-after" data-dismiss="modal">Logout</button>
	<a href="/menu"><button id="voltar-btn" type="button" class="btn btn-warning" data-dismiss="modal">Voltar</button></a>
</div>

<div class="logo-div">
    <img src="/images/czmb-logo-black.svg">
</div>

<div class="page-header">
    <h1>
        Criar usuário de publisher
    </h1>
</div>


<div id="usuario-publisher">
  <div class="form-group">

  	<label>Publisher</label>
	<select id="publisher-id"  class="form-control"  name="publisher-id">
	  	<option value="">Selecione um publisher</option>
	  	<?php foreach ($publishers as $publisher) { ?>
	  		<option data-email="<?= $publisher['email'] ?>" value="<?= $publisher['id'] ?>"><?= $publisher['id'] ?>  - <?= $publisher['nome'] ?></option>
		<?php } ?>
	</select>

  </div>
  <div class="form-group">
	<label>Nome</label>
	<input id="nome" class="form-control" placeholder="Nome do usuário" type="text" name="nome">
  </div>

   <div class="form-group">
   		<label>Login (email)</label>
		<input id="login" class="form-control" type="email" name="login" placeholder="email@email.com">
   </div>

	<div class="panel panel-default" id="error-box">
		<div class="panel-body">
			<span id="error-text"></span>
		</div>
	</div>

  <button type="submit" id="create-btn" class="btn btn-primary">Criar Usuário</button>
</div>

<div class="layer">
	<div id="loader" class="loader"></div>
</div>




<script type="text/javascript">

jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + 
                                                $(window).scrollTop()) + "px");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + 
                                                $(window).scrollLeft()) + "px");
    return this;
}


window.onload = function(){

	$( "#publisher-id" ).change(function() {
		var email = $("#publisher-id").find(':selected').attr('data-email')
	  	$("#login").val(email);
	});

	$(".loader").center(true);

	var data = {
		"id" : null,
		"login" : null,
		"nome" : null
	};


    $('#logout-btn').click(function(){
        $.ajax({
            method: "GET",
            url: "/menu/reset",
        }).done(function(msg) {
            window.location.replace("/login");
        });
    });


    $('#create-btn').click(function(){

    	$(".layer").fadeIn();

    	data.id = $("#publisher-id").val();
    	data.login = $("#login").val();
    	data.nome = $("#nome").val();

    	$.ajax({
			method: "POST",
			url: "/publishers/user/",
			data: data
		}).done(function(msg) {
			if (msg['success'] == 'true') {
				$('#error-box').removeClass('red-box');
				$('#error-box').addClass('green-box');
				$("#publisher-id option[value='" + data.id + "']").remove();
				$('#login').val("");
				$('#nome').val("");
			}else{
				$('#error-box').removeClass('green-box');
				$('#error-box').addClass('red-box');
			}
			$(".layer").fadeOut();
			$('#error-box').delay(500).html(msg.message);
			$('#error-box').delay(1000).fadeIn();
			
		});
	});
};

</script>