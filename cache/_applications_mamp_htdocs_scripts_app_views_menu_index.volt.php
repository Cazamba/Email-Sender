<style>
.button {
  border-radius: 4px;
  background-color: #767777;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 22px;
  padding: 10px;
  width: 100%;
  transition: all 0.5s;
  cursor: no-drop;
  margin: 5px;
  min-height: 51px;
}

.active-btn{
    background-color: #eb7c0f;
    cursor: pointer;
}

.active-btn span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.active-btn span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.active-btn:hover span {
  padding-right: 25px;
}

.active-btn:hover span:after {
  opacity: 1;
  right: 0;
}
</style>


<div class="logout-box">
    <button id="logout-btn" type="button" class="btn btn-danger dimiss-after" data-dismiss="modal">Logout</button>
</div>

<div class="logo-div">
    <img src="/images/czmb-logo-black.svg">
</div>

<div class="page-header">
    <h1>
        Menu de ações
    </h1>
</div>

<a href="/campanhas/duplicate"><button class="button active-btn"><span>Duplicar campanhas</span></button></a>

<a href="/publishers"><button class="button active-btn"><span>Cadastrar usuário de publisher</span></button></a>

<a href="/campanhas/remove"><button class="button active-btn"><span>Remover campanhas</span></button></a>

<a href="/campanhas/encerrar"><button class="button active-btn"><span>Encerrar campanhas</span></button></a>

<a href="/campanhas/relatorio"><button class="button active-btn"><span>Relatório de campanha por estado</span></button></a>

<a href="/banners/relatorio"><button class="button active-btn"><span>Relatório de banner por estado</span></button></a>

<button class="button"><span> </span></button>


<script type="text/javascript">

window.onload = function(){
    $('#logout-btn').click(function(){
        $.ajax({
            method: "GET",
            url: "/menu/reset",
        }).done(function(msg) {
            window.location.replace("/login");
        });
    });
};

</script>