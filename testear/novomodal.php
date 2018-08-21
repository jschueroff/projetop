
<script type="text/javascript">
$(document).ready(function () {
    $('#openBtn').click(function () {
        $('#myModal').modal()
    });

    $('.modal')
        .on({
            'show.bs.modal': function() {
                var idx = $('.modal:visible').length;
              
                $(this).css('z-index', 1040 + (10 * idx));
                 var url = $(this).find('[data-url]').data('url');
                 if (url != undefined && url != '') {
                       var id = $(this).attr('id');
                      $('#'+id+' .modal-body').load(url);
                  }
            },
            'shown.bs.modal': function() {
                var idx = ($('.modal:visible').length) - 1; // raise backdrop after animation.
                $('.modal-backdrop').not('.stacked')
                .css('z-index', 1039 + (10 * idx))
                .addClass('stacked');
            },
            'hidden.bs.modal': function() {
                if ($('.modal:visible').length > 0) {
                    // restore the modal-open class to the body element, so that scrolling works
                    // properly after de-stacking a modal.
                    setTimeout(function() {
                        $(document.body).addClass('modal-open');
                    }, 0);
                }
            }
        });
}); 
</script>



<h2>Exemplo de modal dentro de modal dentro de modal...</h2>

 <a data-toggle="modal" href="#myModal" class="btn btn-primary">Abrir modal 1</a>

<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                	<h4 class="modal-title">Modal 1</h4>

            </div>
            <div class="container"></div>
            <div class="modal-body">
            <p><br><br>Começando a abrir os modais, clica no botão aí...</p> 
	<a data-toggle="modal" href="#myModal2" class="btn btn-primary">Abrir modal 2</a>

            </div>
            <div class="modal-footer">	<a href="#" data-dismiss="modal" class="btn btn-default">Fechar</a>
	<a href="#" class="btn btn-primary">Finalizar</a>

            </div>
        </div>
    </div>
</div>
<div class="modal fade rotate" id="myModal2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                	<h4 class="modal-title">Modal 2</h4>

            </div>
            <div class="container"></div>
            <div class="modal-body">
             <p><br><br>Então, entendeu que aqui entra o conteúdo do modal 2?</p> 
               	<a data-toggle="modal" href="#myModal3" class="btn btn-primary">Abrir modal 3</a>

            </div>
            <div class="modal-footer">	<a href="#" data-dismiss="modal" class="btn btn-default">Fechar</a>
	<a href="#" class="btn btn-primary">Finalizar</a>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal3">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                	<h4 class="modal-title">Modal 3</h4>

            </div>
            <div class="container"></div>
            <div class="modal-body"> <p><br><br>E aqui do Modal 3 sacou?</p> 
                <br>
                <br>
                <br>
                <br>
                <br>	<a data-toggle="modal" href="#myModal4" class="btn btn-primary">Abrir modal 4</a>

            </div>
            <div class="modal-footer">	<a href="#" data-dismiss="modal" class="btn btn-default">Fechar</a>
	<a href="#" class="btn btn-primary">Finalizar</a>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal4">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                	<h4 class="modal-title">Modal 4</h4>

            </div>
            <div class="container"></div>
            <div class="modal-body">Pronto, acabou, chega de abrir modal... humm.</div>
            <div class="modal-footer">	<a href="#" data-dismiss="modal" class="btn btn-default">Fechar</a>
	<a data-toggle="modal" href="#myModal5" class="btn btn-primary">Só mais um modalzinho</a>

            </div>
        </div>
    </div>
</div>

<div class="modal fade rotate" id="myModal5">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                	<h4 class="modal-title">Modal 5 - final</h4>

            </div>
            <div class="container"></div>
            <div class="modal-body">Continuando... então vamos abrir na modal 2 uma página externa<br>
            <a data-toggle="modal" data-url="http://fiddle.jshell.net/user/login/" class="btn btn-primary">Abrir modal 2 com conteúdo externo</a>
            </div>
            <div class="modal-footer">	<a href="#" data-dismiss="modal" class="btn btn-default">Fechar aí</a>

            </div>
        </div>
    </div>
</div>