<div class="footer">
    <div class="footer-inner">
        <div class="footer-content">
            <span class="bigger-120">
                <span class="blue bolder"><?php ?></span>
                Sistema Gerenciamento Web &copy; 2017
            </span>

            &nbsp; &nbsp;

        </div>
    </div>
</div>

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>
</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->
<script src="../assets/js/jquery.2.1.1.min.js"></script>

<!-- <![endif]-->

<!--[if IE]>
<script src="assets/js/jquery.1.11.1.min.js"></script>
<![endif]-->

<!--[if !IE]> -->
<script type="text/javascript">
    window.jQuery || document.write("<script src='../assets/js/jquery.min.js'>" + "<" + "/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
window.jQuery || document.write("<script src='assets/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
<script type="text/javascript">
    if ('ontouchstart' in document.documentElement)
        document.write("<script src='../assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
</script>

<!--<script src="../assets/js/bootstrap.min.js"></script>-->





<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/jquery.maskedinput.min.js"></script>


<!--CADASTRA UM NOVO PRODUTO NA NFE-->

<script type="text/javascript">
    $('#novoprodutoitemnfe').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id_pedido') // Extract info from data-* attributes
        var id_produto = button.data('id_produto')
        var produto_nome = button.data('produto_nome')
        var produto_preco = button.data('produto_preco')

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID NF-e: ' + id)
        modal.find('#id_pedido').val(id)
        modal.find('#id_produto').val(id_produto)
        modal.find('#produto_nome').val(produto_nome)
        modal.find('#produto_preco').val(produto_preco)

    })
</script>








<!--LIBERA OS PRODUTOS PARA A ENTRADA DO ESTOQUE DA NFE.-->
<script type="text/javascript">
    $('#liberaproduto').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('entrada_id')
        var entrada_id = button.data('entrada_id')
        var entrada_id2 = button.data('entrada_id')
        var entrada_xnome_emit = button.data('entrada_xnome_emit')
        var entrada_xnome_emit2 = button.data('entrada_xnome_emit')

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Entrada: ' + id)
        modal.find('#entrada_id').val(entrada_id)
        modal.find('#entrada_id2').val(entrada_id2)
        modal.find('#entrada_xnome_emit').val(entrada_xnome_emit)
        modal.find('#entrada_xnome_emit2').val(entrada_xnome_emit2)

    })
</script>

<!--VINCULA OS PRODUTOS PARA A ENTRADA COM PRODUTOS INTERNOS.-->
<script type="text/javascript">
    $('#vincular').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
       
        var id = button.data('entrada_produto_id')
        var entrada_produto_id = button.data('entrada_produto_id')
        var entrada_produto_id2 = button.data('entrada_produto_id')
        var fornecedor_id = button.data('fornecedor_id')
        var entrada_produto_cprod = button.data('entrada_produto_cprod')
        var entrada_produto_ean = button.data('entrada_produto_ean')
        var entrada_produto_xprod = button.data('entrada_produto_xprod')
        var entrada_produto_ucom = button.data('entrada_produto_ucom')
       

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Entrada Produto: ' + id)
        modal.find('#entrada_produto_id').val(entrada_produto_id)
        modal.find('#entrada_produto_id2').val(entrada_produto_id2)
        modal.find('#id_fornecedor').val(fornecedor_id)
        modal.find('#entrada_produto_cprod').val(entrada_produto_cprod)
        modal.find('#entrada_produto_ean').val(entrada_produto_ean)
        modal.find('#entrada_produto_xprod').val(entrada_produto_xprod)
        modal.find('#entrada_produto_ucom').val(entrada_produto_ucom)


    })
</script>


<!--FAZ O DOWNLOALD DA NFE E VERIFICA O FORNECEDOR JA CADASTRADO PARA A IMPORTACAO-->

<script type="text/javascript">
    $('#downloald-nfe').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var entrada_nota_id = button.data('entrada_nota_id') // Extract info from data-* attributes
        var downloald_chave = button.data('downloald_chave') // Extract info from data-* attributes
        var downloald_cnpj = button.data('downloald_cnpj') // Extract info from data-* attributes

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Nota: ' + downloald_chave)
        modal.find('#entrada_nota_id').val(entrada_nota_id)
        modal.find('#downloald_chave').val(downloald_chave)
        modal.find('#downloald_cnpj').val(downloald_cnpj)
        modal.find('#downloald_cnpj1').val(downloald_cnpj)

    })
</script>
<!--
=====>>>PEDIDOS<<<<============
EDITA ITENS DO PEDIDO 
-->
<script type="text/javascript">
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('pedido_itens_id') // Extract info from data-* attributes
        var id_produto = button.data('id_produto')
        var produto_nome = button.data('produto_nome')
        var pedido_itens_valor = button.data('pedido_itens_valor')
        var pedido_itens_qtd = button.data('pedido_itens_qtd')
        var pedido_itens_id_st = button.data('pedido_itens_id_st')
        var pedido_itens_id_tes = button.data('pedido_itens_id_tes')
        var pedido_itens_valor_frete = button.data('pedido_itens_valor_frete')
        var pedido_itens_valor_seguro = button.data('pedido_itens_valor_seguro')
        var pedido_itens_valor_desconto = button.data('pedido_itens_valor_desconto')
        var pedido_itens_outras_despesas = button.data('pedido_itens_outras_despesas')
        var pedido_itens_descricao = button.data('pedido_itens_descricao')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Ped. Itens: ' + id)
        modal.find('#id_pedido_item').val(id)
        modal.find('#recipient-name').val(id_produto)
        modal.find('#produto_nome').val(produto_nome)
        modal.find('#pedido_qtd').val(pedido_itens_qtd)
        modal.find('#detalhes-text').val(pedido_itens_valor)
        modal.find('#pedido_itens_id_st').val(pedido_itens_id_st)
        modal.find('#pedido_itens_id_tes').val(pedido_itens_id_tes)
        modal.find('#pedido_itens_valor_frete').val(pedido_itens_valor_frete)
        modal.find('#pedido_itens_valor_seguro').val(pedido_itens_valor_seguro)
        modal.find('#pedido_itens_valor_desconto').val(pedido_itens_valor_desconto)
        modal.find('#pedido_itens_outras_despesas').val(pedido_itens_outras_despesas)
        modal.find('#pedido_itens_descricao').val(pedido_itens_descricao)
    })
</script>
<!--EXCLUI OS ITENS DO PEDIDO-->
<script type="text/javascript">
    $('#excluirproduto').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('pedido_itens_id') // Extract info from data-* attributes

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Excluir: ' + id)
        modal.find('#pedido_itens_id').val(id)

    })
</script>


<!--CADASTRA OUTRAS INFORMAÇÕES NO PEDIDO-->

<script type="text/javascript">
    $('#novoinfadicionais').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id_pedido') // Extract info from data-* attributes
        var id_pedido = button.data('id_pedido') // Extract info from data-* attributes
        var id_transportador = button.data('id_transportador') // Extract info from data-* attributes
        var pedido_valor_frete = button.data('pedido_valor_frete') // Extract info from data-* attributes

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Editar Outras Informações: ' + id)
        modal.find('#id_pedido').val(id_pedido)
        modal.find('#id_transportador').val(id_transportador)
        modal.find('#pedido_valor_frete').val(pedido_valor_frete)

    })
</script>


<!--CADASTRA/EDITA DADOS NFE NO PEDIDO-->

<script type="text/javascript">
    $('#novodadosnfe').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id_pedido') // Extract info from data-* attributes
        var id_pedido = button.data('id_pedido') // Extract info from data-* attributes
        var pedido_peso_liquido = button.data('pedido_peso_liquido')
        var pedido_peso_bruto = button.data('pedido_peso_bruto')
        var pedido_quantidade = button.data('pedido_quantidade')
        var pedido_especie = button.data('pedido_especie')
        var pedido_marca = button.data('pedido_marca')
        var pedido_inf_nfe = button.data('pedido_inf_nfe')
        var pedido_inf_comp = button.data('pedido_inf_comp')
        var pedido_referencia = button.data('pedido_referencia')

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Editar Dados NF-e: ' + id)
        modal.find('#id_pedido').val(id_pedido)
        modal.find('#pedido_peso_liquido').val(pedido_peso_liquido)
        modal.find('#pedido_peso_bruto').val(pedido_peso_bruto)
        modal.find('#pedido_quantidade').val(pedido_quantidade)
        modal.find('#pedido_especie').val(pedido_especie)
        modal.find('#pedido_marca').val(pedido_marca)
        modal.find('#pedido_inf_nfe').val(pedido_inf_nfe)
        modal.find('#pedido_inf_comp').val(pedido_inf_comp)
        modal.find('#pedido_referencia').val(pedido_referencia)

    })
</script>


<!--CADASTRA UM NOVO PRODUTO NO PEDIDO-->

<script type="text/javascript">
    $('#novoprodutoitem').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id_pedido') // Extract info from data-* attributes
        var id_produto = button.data('id_produto')
        var produto_nome = button.data('produto_nome')
        var produto_preco = button.data('produto_preco')

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Ped: ' + id)
        modal.find('#id_pedido').val(id)
        modal.find('#id_produto').val(id_produto)
        modal.find('#produto_nome').val(produto_nome)
        modal.find('#produto_preco').val(produto_preco)

    })
</script>

<!--
=====>>>NOTA<<<<============
EDITA OS DADOS DA NOTA ITENS 
-->
<script type="text/javascript">
    $('#exampleModal2').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_itens_id') // Extract info from data-* attributes
        //var id_produto = button.data('id_produto')
        var nota_itens_produto = button.data('nota_itens_produto')
        var nota_itens_valor = button.data('nota_itens_valor')
        var nota_itens_qtd = button.data('nota_itens_qtd')
        var nota_itens_total = button.data('nota_itens_total')
        var nota_itens_id_st = button.data('nota_itens_id_st')
        var nota_itens_id_tes = button.data('nota_itens_id_tes')
        var nota_itens_valor_frete = button.data('nota_itens_valor_frete')
        var nota_itens_valor_seguro = button.data('nota_itens_valor_seguro')
        var nota_itens_valor_desconto = button.data('nota_itens_valor_desconto')
        var nota_itens_outras_despesas = button.data('nota_itens_outras_despesas')
        var nota_itens_idtot = button.data('nota_itens_idtot')
        var nota_itens_numero_compra = button.data('nota_itens_numero_compra')
        var nota_itens_item_compra = button.data('nota_itens_item_compra')
        var nota_itens_numero_nfci = button.data('nota_itens_numero_nfci')
        var nota_itens_descricao = button.data('nota_itens_descricao')
        var nota_itens_ncm = button.data('nota_itens_ncm')
        var nota_itens_cst = button.data('nota_itens_cst')
        var nota_itens_cest = button.data('nota_itens_cest')
        var nota_itens_origem = button.data('nota_itens_origem')
        var nota_itens_modalidade_calculo_icms = button.data('nota_itens_modalidade_calculo_icms')
        var nota_itens_reducao_calculo_icms = button.data('nota_itens_reducao_calculo_icms')
        var nota_itens_base_calculo_icms = button.data('nota_itens_base_calculo_icms')
        var nota_itens_valor_icms_op = button.data('nota_itens_valor_icms_op')
        var nota_itens_perc_dif = button.data('nota_itens_perc_dif')
        var nota_itens_valor_perc_dif = button.data('nota_itens_valor_perc_dif')
        var nota_itens_aliquota = button.data('nota_itens_aliquota')
        var nota_itens_valor_icms = button.data('nota_itens_valor_icms')

        var nota_itens_st_comportamento = button.data('nota_itens_st_comportamento')
        var nota_itens_st_modalidade_calculo = button.data('nota_itens_st_modalidade_calculo')
        var nota_itens_st_mva = button.data('nota_itens_st_mva')
        var nota_itens_st_reducao_calculo = button.data('nota_itens_st_reducao_calculo')
        var nota_itens_st_aliquota = button.data('nota_itens_st_aliquota')
        var nota_itens_st_valor = button.data('nota_itens_st_valor')

        var nota_itens_par_pobreza = button.data('nota_itens_par_pobreza')
        var nota_itens_par_destino = button.data('nota_itens_par_destino')
        var nota_itens_par_origem = button.data('nota_itens_par_origem')
        var nota_itens_mensagem_nfe = button.data('nota_itens_mensagem_nfe')

        var nota_itens_id_ipi = button.data('nota_itens_id_ipi')
        var nota_itens_ipi_classe = button.data('nota_itens_ipi_classe')
        var nota_itens_ipi_cod = button.data('nota_itens_ipi_cod')
        var nota_itens_ipi_tipo_calculo = button.data('nota_itens_ipi_tipo_calculo')
        var nota_itens_ipi_aliquota = button.data('nota_itens_ipi_aliquota')
        var nota_itens_ipi_valor = button.data('nota_itens_ipi_valor')

        var nota_itens_id_pis = button.data('nota_itens_id_pis')
        var nota_itens_pis_tipo_calculo = button.data('nota_itens_pis_tipo_calculo')
        var nota_itens_pis_base_calculo = button.data('nota_itens_pis_base_calculo')
        var nota_itens_pis_aliquota = button.data('nota_itens_pis_aliquota')
        var nota_itens_pis_valor = button.data('nota_itens_pis_valor')
        var nota_itens_pis_st_tipo_calculo = button.data('nota_itens_pis_st_tipo_calculo')
        var nota_itens_pis_st_aliquota = button.data('nota_itens_pis_st_aliquota')

        var nota_itens_id_cofins = button.data('nota_itens_id_cofins')
        var nota_itens_cofins_tipo_calculo = button.data('nota_itens_cofins_tipo_calculo')
        var nota_itens_cofins_base_calculo = button.data('nota_itens_cofins_base_calculo')
        var nota_itens_cofins_aliquota = button.data('nota_itens_cofins_aliquota')
        var nota_itens_cofins_valor = button.data('nota_itens_cofins_valor')
        
        var nota_itens_aliquota_cred_icms = button.data('nota_itens_aliquota_cred_icms')
        var nota_itens_valor_cred_icms = button.data('nota_itens_valor_cred_icms')

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Itens: ' + id)
        modal.find('#nota_itens_id').val(id)
        modal.find('#nota_itens_produto').val(nota_itens_produto)
        // modal.find('#recipient-name').val(id_produto)
        modal.find('#nota_itens_qtd').val(nota_itens_qtd)
        modal.find('#nota_itens_valor').val(nota_itens_valor)
        modal.find('#nota_itens_total').val(nota_itens_total)
        modal.find('#nota_itens_id_st').val(nota_itens_id_st)
        modal.find('#nota_itens_id_tes').val(nota_itens_id_tes)
        modal.find('#nota_itens_valor_frete').val(nota_itens_valor_frete)
        modal.find('#nota_itens_valor_seguro').val(nota_itens_valor_seguro)
        modal.find('#nota_itens_valor_desconto').val(nota_itens_valor_desconto)
        modal.find('#nota_itens_outras_despesas').val(nota_itens_outras_despesas)
        modal.find('#nota_itens_idtot').val(nota_itens_idtot)
        modal.find('#nota_itens_numero_compra').val(nota_itens_numero_compra)
        modal.find('#nota_itens_item_compra').val(nota_itens_item_compra)
        modal.find('#nota_itens_numero_nfci').val(nota_itens_numero_nfci)
        modal.find('#nota_itens_descricao').val(nota_itens_descricao)
        modal.find('#nota_itens_ncm').val(nota_itens_ncm)
        modal.find('#nota_itens_cst').val(nota_itens_cst)
        modal.find('#nota_itens_cest').val(nota_itens_cest)
        modal.find('#nota_itens_origem').val(nota_itens_origem)
        modal.find('#nota_itens_modalidade_calculo_icms').val(nota_itens_modalidade_calculo_icms)
        modal.find('#nota_itens_reducao_calculo_icms').val(nota_itens_reducao_calculo_icms)
        modal.find('#nota_itens_base_calculo_icms').val(nota_itens_base_calculo_icms)
        modal.find('#nota_itens_valor_icms_op').val(nota_itens_valor_icms_op)
        modal.find('#nota_itens_perc_dif').val(nota_itens_perc_dif)
        modal.find('#nota_itens_valor_perc_dif').val(nota_itens_valor_perc_dif)
        modal.find('#nota_itens_aliquota').val(nota_itens_aliquota)
        modal.find('#nota_itens_valor_icms').val(nota_itens_valor_icms)

        modal.find('#nota_itens_st_comportamento').val(nota_itens_st_comportamento)
        modal.find('#nota_itens_st_modalidade_calculo').val(nota_itens_st_modalidade_calculo)
        modal.find('#nota_itens_st_mva').val(nota_itens_st_mva)
        modal.find('#nota_itens_st_reducao_calculo').val(nota_itens_st_reducao_calculo)
        modal.find('#nota_itens_st_aliquota').val(nota_itens_st_aliquota)
        modal.find('#nota_itens_st_valor').val(nota_itens_st_valor)

        modal.find('#nota_itens_par_pobreza').val(nota_itens_par_pobreza)
        modal.find('#nota_itens_par_destino').val(nota_itens_par_destino)
        modal.find('#nota_itens_par_origem').val(nota_itens_par_origem)
        modal.find('#nota_itens_mensagem_nfe').val(nota_itens_mensagem_nfe)

        modal.find('#nota_itens_id_ipi').val(nota_itens_id_ipi)
        modal.find('#nota_itens_ipi_classe').val(nota_itens_ipi_classe)
        modal.find('#nota_itens_ipi_cod').val(nota_itens_ipi_cod)
        modal.find('#nota_itens_ipi_tipo_claculo').val(nota_itens_ipi_tipo_calculo)
        modal.find('#nota_itens_ipi_aliquota').val(nota_itens_ipi_aliquota)
        modal.find('#nota_itens_ipi_valor').val(nota_itens_ipi_valor)

        modal.find('#nota_itens_id_pis').val(nota_itens_id_pis)
        modal.find('#nota_itens_pis_tipo_calculo').val(nota_itens_pis_tipo_calculo)
        modal.find('#nota_itens_pis_base_calculo').val(nota_itens_pis_base_calculo)
        modal.find('#nota_itens_pis_aliquota').val(nota_itens_pis_aliquota)
        modal.find('#nota_itens_pis_valor').val(nota_itens_pis_valor)
        modal.find('#nota_itens_pis_st_tipo_calculo').val(nota_itens_pis_st_tipo_calculo)
        modal.find('#nota_itens_pis_st_aliquota').val(nota_itens_pis_st_aliquota)

        modal.find('#nota_itens_id_cofins').val(nota_itens_id_cofins)
        modal.find('#nota_itens_cofins_tipo_calculo').val(nota_itens_cofins_tipo_calculo)
        modal.find('#nota_itens_cofins_base_calculo').val(nota_itens_cofins_base_calculo)
        modal.find('#nota_itens_cofins_aliquota').val(nota_itens_cofins_aliquota)
        modal.find('#nota_itens_cofins_valor').val(nota_itens_cofins_valor)
        
        modal.find('#nota_itens_aliquota_cred_icms').val(nota_itens_aliquota_cred_icms)
        modal.find('#nota_itens_valor_cred_icms').val(nota_itens_valor_cred_icms)

    })
</script>

<!--=====>>>>INFORMAÇÕES COMPLEMENTARES<<<<========

DADOS PARA A EDICAO DA INFORMAÇÕES COMPLEMENTARES-->

<script type="text/javascript">
    $('#editarinfo').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('inf_comp_id') // Extract info from data-* attributes
        var inf_comp_id = button.data('inf_comp_id')
        var inf_comp_descricao_resumida = button.data('inf_comp_descricao_resumida')
        var inf_comp_apelido = button.data('inf_comp_apelido')
        var inf_comp_interesse = button.data('inf_comp_interesse')
        var inf_comp_descricao = button.data('inf_comp_descricao')
        var inf_comp_exportacao = button.data('inf_comp_exportacao')
        // var pedido_itens_valor = button.data('pedido_itens_valor')
        // var pedido_itens_qtd = button.data('pedido_itens_qtd')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Inf.: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#inf_comp_id').val(inf_comp_id)
        modal.find('#inf_comp_descricao_resumida').val(inf_comp_descricao_resumida)
        modal.find('#inf_comp_apelido').val(inf_comp_apelido)
        modal.find('#inf_comp_interesse').val(inf_comp_interesse)
        modal.find('#inf_comp_descricao').val(inf_comp_descricao)
        modal.find('#inf_comp_exportacao').val(inf_comp_exportacao)
        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>
<!--INATIVAR AS INFORMAÇÕES COMPLEMENTARES-->
<script type="text/javascript">
    $('#inativarinfo').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('inf_comp_id') // Extract info from data-* attributes
        var inf_comp_id = button.data('inf_comp_id')
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Inf.: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#inf_comp_id').val(inf_comp_id)

        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>

<!--ATIVAR AS INFORMAÇÕES COMPLEMENTARES-->
<script type="text/javascript">
    $('#ativarinfo').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('inf_comp_id') // Extract info from data-* attributes
        var inf_comp_id = button.data('inf_comp_id')
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Inf.: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#inf_comp_id').val(inf_comp_id)

        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>

<!--

=====>>>>NOTAS<<<<========

AQUI SAO OS DADOS PARA A GERACAO DA NF-E
-->
<script type="text/javascript">
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('pedido_id') // Extract info from data-* attributes
        var pedido_id = button.data('pedido_id')
        var pedido_cliente = button.data('pedido_cliente')
        var id_transportador = button.data('id_transportador')
        // var pedido_itens_valor = button.data('pedido_itens_valor')
        // var pedido_itens_qtd = button.data('pedido_itens_qtd')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Ped.: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#pedido_id').val(pedido_id)
        modal.find('#pedido_cliente').val(pedido_cliente)
        modal.find('#id_transportador').val(id_transportador)
        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>
<!--AQUI SAO OS DADOS PARA O ENVIO DA SEFAZ-->
<script type="text/javascript">
    $('#myModal2').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_id') // Extract info from data-* attributes
        var nota_id = button.data('nota_id')
        var nota_cliente = button.data('nota_cliente')
        var nota_chave = button.data('nota_chave')
        var nota_ambiente = button.data('nota_ambiente')
        var nota_numero_nf = button.data('nota_numero_nf')
        // var pedido_itens_valor = button.data('pedido_itens_valor')
        // var pedido_itens_qtd = button.data('pedido_itens_qtd')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Nota.: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#nota_id').val(nota_id)
        modal.find('#nota_cliente').val(nota_cliente)
        modal.find('#nota_chave').val(nota_chave)
        modal.find('#nota_ambiente').val(nota_ambiente)
        modal.find('#nota_numero_nf').val(nota_numero_nf)
        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>
<!--GERAÇÃO/EMISSAO DO PDF-->
<script type="text/javascript">
    $('#myModal3').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_id') // Extract info from data-* attributes
        var nota_id = button.data('nota_id')
        var nota_cliente = button.data('nota_cliente')
        var nota_chave = button.data('nota_chave')

        // var pedido_itens_valor = button.data('pedido_itens_valor')
        // var pedido_itens_qtd = button.data('pedido_itens_qtd')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Nota.: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#nota_id').val(nota_id)
        modal.find('#nota_cliente').val(nota_cliente)
        modal.find('#nota_chave').val(nota_chave)

        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>
<!--ENVIO DO E-MAIL COM O XML/PDF PARA O CLIENTE-->
<script type="text/javascript">
    $('#myModal4').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_id') // Extract info from data-* attributes
        var nota_id = button.data('nota_id')
        var nota_cliente = button.data('nota_cliente')
        var nota_chave = button.data('nota_chave')

        // var pedido_itens_valor = button.data('pedido_itens_valor')
        // var pedido_itens_qtd = button.data('pedido_itens_qtd')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Nota.: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#nota_id').val(nota_id)
        modal.find('#nota_cliente').val(nota_cliente)
        modal.find('#nota_chave').val(nota_chave)

        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>
<!--VISUALIZAR A NF-E ANTES DA EMISSAO-->
<script type="text/javascript">
    $('#myModal5').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_id') // Extract info from data-* attributes
        var nota_id = button.data('nota_id')
        var nota_cliente = button.data('nota_cliente')
        var nota_chave = button.data('nota_chave')

        // var pedido_itens_valor = button.data('pedido_itens_valor')
        // var pedido_itens_qtd = button.data('pedido_itens_qtd')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Nota.: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#nota_id').val(nota_id)
        modal.find('#nota_cliente').val(nota_cliente)
        modal.find('#nota_chave').val(nota_chave)

        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>
<!--ENVIO DO E-MAIL COM O XML/PDF PARA O CLIENTE-->
<script type="text/javascript">
    $('#myModal9').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_id') // Extract info from data-* attributes
        var nota_id = button.data('nota_id')
        var nota_cliente = button.data('nota_cliente')
        var nota_chave = button.data('nota_chave')
        var nota_ambiente = button.data('nota_ambiente')
        var nota_numero_nf = button.data('nota_numero_nf')
        // var pedido_itens_valor = button.data('pedido_itens_valor')
        // var pedido_itens_qtd = button.data('pedido_itens_qtd')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Nota.: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#nota_id').val(nota_id)
        modal.find('#nota_cliente').val(nota_cliente)
        modal.find('#nota_chave').val(nota_chave)
        modal.find('#nota_ambiente').val(nota_ambiente)
        modal.find('#nota_numero_nf').val(nota_numero_nf)
        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>
<!--VISUALIZAR A CARTA DE CORRECAO PARA IMPRIMIR-->
<script type="text/javascript">
    $('#myModal11').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_id') // Extract info from data-* attributes
        var nota_id = button.data('nota_id')
        var nota_nseqevento = button.data('nota_nseqevento')
        var nota_chave = button.data('nota_chave')

        // var pedido_itens_valor = button.data('pedido_itens_valor')
        // var pedido_itens_qtd = button.data('pedido_itens_qtd')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Carta de Correção: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#nota_id').val(nota_id)
        modal.find('#nota_nseqevento').val(nota_nseqevento)
        modal.find('#nota_chave').val(nota_chave)

        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>
<!--VISUALIZAR A O CANCELAMENTO DA NF-E-->
<script type="text/javascript">
    $('#myModal12').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_id') // Extract info from data-* attributes
        var nota_id = button.data('nota_id')
        var nota_cliente = button.data('nota_cliente')
        var nota_chave = button.data('nota_chave')
        var nota_prot = button.data('nota_prot')
        var nota_ambiente = button.data('nota_ambiente')
        // var pedido_itens_valor = button.data('pedido_itens_valor')
        // var pedido_itens_qtd = button.data('pedido_itens_qtd')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Cancelamento: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#nota_id').val(nota_id)
        modal.find('#nota_cliente').val(nota_cliente)
        modal.find('#nota_chave').val(nota_chave)
        modal.find('#nota_prot').val(nota_prot)
        modal.find('#nota_ambiente').val(nota_ambiente)

        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>
<!--ENVIO DO E-MAIL COM O XML/PDF PARA O CLIENTE-->
<script type="text/javascript">
    $('#myModal98').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_id') // Extract info from data-* attributes
        var nota_id = button.data('nota_id')
        var nota_cliente = button.data('nota_cliente')
        var nota_chave = button.data('nota_chave')
      
        

        // var pedido_itens_valor = button.data('pedido_itens_valor')
        // var pedido_itens_qtd = button.data('pedido_itens_qtd')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Nota para Edicao/Consulta: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#nota_id').val(nota_id)
        modal.find('#nota_cliente').val(nota_cliente)
        modal.find('#nota_chave').val(nota_chave)
       


        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>
<!-- ....::: REFERENCIA NFE EDITA/EXCLUI :::....-->

<!--EDITA O REFERENCIA DA NFE-->
<script type="text/javascript">
    $('#editarreferencia').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_referencia_id') // Extract info from data-* attributes
        var nota_referencia_id = button.data('nota_referencia_id')
        var nota_referencia_chave = button.data('nota_referencia_chave')
        var nota_referencia_cod_uf = button.data('nota_referencia_cod_uf')
        var nota_referencia_data = button.data('nota_referencia_data')
        var nota_referencia_cnpj = button.data('nota_referencia_cnpj')
        var nota_referencia_modelo = button.data('nota_referencia_modelo')
        var nota_referencia_serie = button.data('nota_referencia_serie')
        var nota_referencia_numero_nfe = button.data('nota_referencia_numero_nfe')

        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID REF.: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#nota_referencia_id').val(nota_referencia_id)
        modal.find('#nota_referencia_chave').val(nota_referencia_chave)
        modal.find('#nota_referencia_cod_uf').val(nota_referencia_cod_uf)
        modal.find('#nota_referencia_data').val(nota_referencia_data)
        modal.find('#nota_referencia_cnpj').val(nota_referencia_cnpj)
        modal.find('#nota_referencia_modelo').val(nota_referencia_modelo)
        modal.find('#nota_referencia_serie').val(nota_referencia_serie)
        modal.find('#nota_referencia_numero_nfe').val(nota_referencia_numero_nfe)



        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>
<!--EXCLUI A REFERENCIA DA NFE-->
<script type="text/javascript">
    $('#excluirreferencia').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_referencia_id') // Extract info from data-* attributes
        var nota_referencia_id = button.data('nota_referencia_id')

        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Referencia: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#nota_referencia_id').val(nota_referencia_id)



        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>


<!-- ....::: INFORMAÇÕES COMPLEMENTARES EDITA/EXCLUI :::....-->

<!--EDITA O INF COMPLEMENTAR DA EDICAO DA NFE-->
<script type="text/javascript">
    $('#inf_comp_editar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_inf_comp_id') // Extract info from data-* attributes
        var nota_inf_comp_id = button.data('nota_inf_comp_id')
        var nota_inf_comp_apelido = button.data('nota_inf_comp_apelido')
        var nota_inf_comp_descricao = button.data('nota_inf_comp_descricao')
        var nota_inf_comp_complemento = button.data('nota_inf_comp_complemento')

        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID INF COMP: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#nota_inf_comp_id').val(nota_inf_comp_id)
        modal.find('#nota_inf_comp_apelido').val(nota_inf_comp_apelido)
        modal.find('#nota_inf_comp_descricao').val(nota_inf_comp_descricao)
        modal.find('#nota_inf_comp_complemento').val(nota_inf_comp_complemento)



        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>
<!--EXCLUI O INF COMPLEMENTAR DA NFE-->
<script type="text/javascript">
    $('#inf_comp_excluir').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_inf_comp_id') // Extract info from data-* attributes
        var nota_inf_comp_id = button.data('nota_inf_comp_id')

        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID INF. COMP: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#nota_inf_comp_id').val(nota_inf_comp_id)



        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>


<!-- ....::: VEICULO EDITA/EXCLUI :::....-->

<!--EDITA O VEICULO DA EDICAO DA NFE-->
<script type="text/javascript">
    $('#veiculoeditar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_veiculo_id') // Extract info from data-* attributes
        var nota_veiculo_id = button.data('nota_veiculo_id')
        var nota_veiculo_tipo = button.data('nota_veiculo_tipo')
        var nota_veiculo_placa = button.data('nota_veiculo_placa')
        var nota_veiculo_uf = button.data('nota_veiculo_uf')
        var nota_veiculo_rntc = button.data('nota_veiculo_rntc')
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Veiculo: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#nota_veiculo_id').val(nota_veiculo_id)
        modal.find('#nota_veiculo_tipo').val(nota_veiculo_tipo)
        modal.find('#nota_veiculo_placa').val(nota_veiculo_placa)
        modal.find('#nota_veiculo_uf').val(nota_veiculo_uf)
        modal.find('#nota_veiculo_rntc').val(nota_veiculo_rntc)


        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>
<!--EXCLUI O VEICULO DA NFE-->
<script type="text/javascript">
    $('#veiculoexcluir').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_veiculo_id') // Extract info from data-* attributes
        var nota_veiculo_id = button.data('nota_veiculo_id')

        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Veiculo: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#nota_veiculo_id').val(nota_veiculo_id)



        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>

<!-- ....::: VOLUME EDITA/EXCLUI :::....-->

<!--EDITA O VOLUME DA EDICAO DA NFE-->
<script type="text/javascript">
    $('#volumeeditar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_volume_id') // Extract info from data-* attributes
        var nota_volume_id = button.data('nota_volume_id')
        var nota_volume_qtd = button.data('nota_volume_qtd')
        var nota_volume_especie = button.data('nota_volume_especie')
        var nota_volume_peso_bruto = button.data('nota_volume_peso_bruto')
        var nota_volume_peso_liquido = button.data('nota_volume_peso_liquido')
        var nota_volume_marca = button.data('nota_volume_marca')
        var nota_volume_numero_volume = button.data('nota_volume_numero_volume')
        var nota_volume_lacre = button.data('nota_volume_lacre')

        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Volume: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#nota_volume_id').val(nota_volume_id)
        modal.find('#nota_volume_qtd').val(nota_volume_qtd)
        modal.find('#nota_volume_especie').val(nota_volume_especie)
        modal.find('#nota_volume_peso_bruto').val(nota_volume_peso_bruto)
        modal.find('#nota_volume_peso_liquido').val(nota_volume_peso_liquido)
        modal.find('#nota_volume_marca').val(nota_volume_marca)
        modal.find('#nota_volume_numero_volume').val(nota_volume_numero_volume)
        modal.find('#nota_volume_lacre').val(nota_volume_lacre)



        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>
<!--EXCLUI O VOLUME DA NFE-->
<script type="text/javascript">
    $('#volumeexcluir').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('nota_volume_id') // Extract info from data-* attributes
        var nota_volume_id = button.data('nota_volume_id')

        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Volume: ' + id)
        //modal.find('#id_pedido_item').val(id)
        modal.find('#nota_volume_id').val(nota_volume_id)



        // modal.find('#pedido_qtd').val(pedido_itens_qtd)
        // modal.find('#detalhes-text').val(pedido_itens_valor)
    })
</script>


<!--=====>>>CONTAS A RECEBER<<<<============
ACESSA O BOLETO PARA A VISUALIZAÇÃO-->
<script type="text/javascript">
    $('#myModalgeraboleto').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('contas_receber_id') // Extract info from data-* attributes
        var contas_receber_numero = button.data('contas_receber_numero')

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID Contas Receber ' + id)
        modal.find('#contas_receber_id').val(id)
        modal.find('#contas_receber_numero').val(contas_receber_numero)

    })
</script>
<!--EDITA OS DADOS NO CONTAS A RECEBER PARA A EMISSAO DOS BOLETOS-->
<script type="text/javascript">
    $('#myModaleditarboleto').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('contas_receber_id') // Extract info from data-* attributes
        var contas_receber_valor = button.data('contas_receber_valor')
        var contas_receber_numero = button.data('contas_receber_numero')
        var contas_receber_data = button.data('contas_receber_data')
        var contas_receber_vencimento = button.data('contas_receber_vencimento')
        var contas_receber_juros = button.data('contas_receber_juros')
        var contas_receber_obs = button.data('contas_receber_obs')

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Contas Receber: ' + id)
        modal.find('#contas_receber_id').val(id)
        modal.find('#contas_receber_valor').val(contas_receber_valor)
        modal.find('#contas_receber_numero').val(contas_receber_numero)
        modal.find('#contas_receber_data').val(contas_receber_data)
        modal.find('#contas_receber_vencimento').val(contas_receber_vencimento)
        modal.find('#contas_receber_juros').val(contas_receber_juros)
        modal.find('#contas_receber_obs').val(contas_receber_obs)
    })
</script>
<!--EXCLUI OS DADOS DO CONTAS A RECEBER-->
<script type="text/javascript">
    $('#myModalexcluircontas').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('contas_receber_id') // Extract info from data-* attributes
        var contas_receber_valor = button.data('contas_receber_valor')
        var contas_receber_numero = button.data('contas_receber_numero')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Contas Receber: ' + id)
        modal.find('#contas_receber_id').val(id)
        modal.find('#contas_receber_valor').val(contas_receber_valor)
        modal.find('#contas_receber_numero').val(contas_receber_numero)

    })
</script>
<!--VISUALIZA OS RECEBIMENTOS DO CONTAS A RECEBER-->
<script type="text/javascript">
    $('#myModalrecebimento').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('contas_receber_id') // Extract info from data-* attributes
        var contas_receber_numero = button.data('contas_receber_numero')

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Recebimentos:' + id)
        modal.find('#contas_receber_id').val(id)
        modal.find('#contas_receber_numero').val(contas_receber_numero)

    })
</script>

<!--=======>>>>RECEBIMENTOS DE CONTAS A RECEBER<<<<============
<!--EDITA OS DADOS NO CONTAS A RECEBER PARA A EMISSAO DOS BOLETOS-->
<script type="text/javascript">
    $('#myModaleditarrecebimento').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('recebimento_id') // Extract info from data-* attributes
        var id_contas_receber = button.data('id_contas_receber')
        var recebimento_data_pagamento = button.data('recebimento_data_pagamento')

        var recebimento_valor = button.data('recebimento_valor')
        var recebimento_forma = button.data('recebimento_forma')
        var recebimento_obs = button.data('recebimento_obs')
        var recebimento_desconto = button.data('recebimento_desconto')
        var recebimento_banco = button.data('recebimento_banco')


        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Recebimento: ' + id)
        modal.find('#recebimento_id').val(id)
        modal.find('#id_contas_receber').val(id_contas_receber)
        modal.find('#recebimento_data_pagamento').val(recebimento_data_pagamento)
        modal.find('#recebimento_valor').val(recebimento_valor)
        modal.find('#recebimento_forma').val(recebimento_forma)
        modal.find('#recebimento_obs').val(recebimento_obs)
        modal.find('#recebimento_desconto').val(recebimento_desconto)
        modal.find('#recebimento_banco').val(recebimento_banco)
    })
</script>
<!--CADASTRA UM NOVO RECEBIMENTO -->
<script type="text/javascript">
    $('#modalrecebimento').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('contas_receber_id') // Extract info from data-* attributes
        var recebimento_data_pagamento = button.data('recebimento_data_pagamento')
        var recebimento_data_vencimento = button.data('recebimento_data_vencimento')
        var recebimento_valor = button.data('recebimento_valor')
        var recebimento_forma = button.data('recebimento_forma')
        var recebimento_obs = button.data('recebimento_obs')
        var recebimento_tarifa = button.data('recebimento_tarifa')
        var recebimento_desconto = button.data('recebimento_desconto')


        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Id Contas Receber: ' + id)
        modal.find('#contas_receber_id').val(id)
        modal.find('#recebimento_data_pagamento').val(recebimento_data_pagamento)
        modal.find('#recebimento_data_vencimento').val(recebimento_data_vencimento)
        modal.find('#recebimento_valor').val(recebimento_valor)
        modal.find('#recebimento_forma').val(recebimento_forma)
        modal.find('#recebimento_obs').val(recebimento_obs)
        modal.find('#recebimento_tarifa').val(recebimento_tarifa)
        modal.find('#recebimento_desconto').val(recebimento_desconto)

    })
</script>
<!--EXCLUI UM RECEBIMENTO -->
<script type="text/javascript">
    $('#myModalexcluirrecebimentos').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('recebimento_id') // Extract info from data-* attributes
        var id_contas_receber = button.data('id_contas_receber') // Extract info from data-* attributes

        var modal = $(this)
        modal.find('.modal-title').text('Id Recebimento: ' + id)
        modal.find('#recebimento_id').val(id)
        modal.find('#id_contas_receber').val(id_contas_receber)
    })
</script>

<!--==========>>>SITUAÇÃO TRIBUTARIA <<<<=========-->
<!--EDITA O ICMS DA ST-->
<script type="text/javascript">
    $('#editarsticms').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('sticms_id')
        var id_st = button.data('id_st')
        var sticms_uf = button.data('sticms_uf')
        var sticms_tipo_pessoa = button.data('sticms_tipo_pessoa')
        var sticms_st_especifica = button.data('sticms_st_especifica')
        var sticms_st = button.data('sticms_st')
        var sticms_cso = button.data('sticms_cso')
        var sticms_modalidade_base_calculo = button.data('sticms_modalidade_base_calculo')
        var sticms_reducao_base_calculo = button.data('sticms_reducao_base_calculo')
        var sticms_base_calculo = button.data('sticms_base_calculo')
        var sticms_aliquota = button.data('sticms_aliquota')
        var sticms_perc_diferimento = button.data('sticms_perc_diferimento')
        var sticms_st_comportamento = button.data('sticms_st_comportamento')
        var sticms_st_modalidade_calculo = button.data('sticms_st_modalidade_calculo')
        var sticms_st_mva = button.data('sticms_st_mva')
        var sticms_st_reducao_calculo = button.data('sticms_st_reducao_calculo')
        var sticms_st_aliquota = button.data('sticms_st_aliquota')
        var sticms_par_pobreza = button.data('sticms_par_pobreza')
        var sticms_par_destino = button.data('sticms_par_destino')
        var sticms_par_origem = button.data('sticms_par_origem')
        var sticms_mensagem_nfe = button.data('sticms_mensagem_nfe')


        var modal = $(this)
        modal.find('.modal-title').text('ID STICMS: ' + id)
        modal.find('#sticms_id').val(id)
        modal.find('#id_st').val(id_st)
        modal.find('#sticms_uf').val(sticms_uf)
        modal.find('#sticms_tipo_pessoa').val(sticms_tipo_pessoa)
        modal.find('#sticms_st_especifica').val(sticms_st_especifica)
        modal.find('#sticms_st').val(sticms_st)
        modal.find('#sticms_cso').val(sticms_cso)
        modal.find('#sticms_modalidade_base_calculo').val(sticms_modalidade_base_calculo)
        modal.find('#sticms_reducao_base_calculo').val(sticms_reducao_base_calculo)
        modal.find('#sticms_base_calculo').val(sticms_base_calculo)
        modal.find('#sticms_aliquota').val(sticms_aliquota)
        modal.find('#sticms_perc_diferimento').val(sticms_perc_diferimento)
        modal.find('#sticms_st_comportamento').val(sticms_st_comportamento)
        modal.find('#sticms_st_modalidade_calculo').val(sticms_st_modalidade_calculo)
        modal.find('#sticms_st_mva').val(sticms_st_mva)
        modal.find('#sticms_st_reducao_calculo').val(sticms_st_reducao_calculo)
        modal.find('#sticms_st_aliquota').val(sticms_st_aliquota)
        modal.find('#sticms_par_pobreza').val(sticms_par_pobreza)
        modal.find('#sticms_par_origem').val(sticms_par_origem)
        modal.find('#sticms_par_destino').val(sticms_par_destino)
        modal.find('#sticms_mensagem_nfe').val(sticms_mensagem_nfe)

    })
</script>

<!--EXCLUI UMA LINHA STICMS -->
<script type="text/javascript">
    $('#excluirsticms').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('sticms_id') // Extract info from data-* attributes
        var id_st = button.data('id_st') // Extract info from data-* attributes

        var modal = $(this)
        modal.find('.modal-title').text('ID ST: ' + id)
        modal.find('#sticms_id').val(id)
        modal.find('#id_st').val(id_st)

    })
</script>

<!--==========>>>TIPO DE ENTRADA E SAIDA<<<<=========-->
<!--EDITA TES ITENS-->
<script type="text/javascript">
    $('#editartesitens').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('tes_itens_id')
        var id_tes = button.data('id_tes')
        var tes_itens_cfop = button.data('tes_itens_cfop')
        var tes_itens_origem = button.data('tes_itens_origem')
        var tes_itens_contribuinte = button.data('tes_itens_contribuinte')
        var tes_itens_tipo_produto = button.data('tes_itens_tipo_produto')
        var tes_itens_cst_icms = button.data('tes_itens_cst_icms')

        var modal = $(this)
        modal.find('.modal-title').text('ID TES ITENS: ' + id)
        modal.find('#tes_itens_id').val(id)
        modal.find('#id_tes').val(id_tes)
        modal.find('#tes_itens_cfop').val(tes_itens_cfop)
        modal.find('#tes_itens_origem').val(tes_itens_origem)
        modal.find('#tes_itens_contribuinte').val(tes_itens_contribuinte)
        modal.find('#tes_itens_tipo_produto').val(tes_itens_tipo_produto)
        modal.find('#tes_itens_cst_icms').val(tes_itens_cst_icms)

    })
</script>

<!--EXCLUI UMA LINHA TES ITENS -->
<script type="text/javascript">
    $('#excluirtesitens').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('tes_itens_id') // Extract info from data-* attributes
        var id_tes = button.data('id_tes') // Extract info from data-* attributes

        var modal = $(this)
        modal.find('.modal-title').text('ID TES ITENS: ' + id)
        modal.find('#tes_itens_id').val(id)
        modal.find('#id_tes').val(id_tes)

    })
</script>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
  <script src="assets/js/excanvas.min.js"></script>
<![endif]-->
<script src="../assets/js/jquery-ui.custom.min.js"></script>
<script src="../assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="../assets/js/jquery.easypiechart.min.js"></script>
<script src="../assets/js/jquery.sparkline.min.js"></script>
<script src="../assets/js/jquery.flot.min.js"></script>
<script src="../assets/js/jquery.flot.pie.min.js"></script>
<script src="../assets/js/jquery.flot.resize.min.js"></script>
<script src="../assets/js/jquery.maskedinput.min.js"></script>

<!-- ace scripts -->
<script src="../assets/js/ace-elements.min.js"></script>
<script src="../assets/js/ace.min.js"></script>
<!--JS DE MASCARA PARA USAR NOS CAMPOS PARA VALIDAÇÃO-->
<script src="../assets/js/jquery.maskedinput.min.js"></script>
<script src="../assets/js/bootstrap-tag.min.js"></script>




<!-- inline scripts related to this page -->
<script type="text/javascript">
    jQuery(function ($) {

        $.mask.definitions['+-'] = '[+-]';
        $('.input-mask-data').mask('99/99/9999');
        $('.input-mask-phone').mask('(999) 999-9999');
        $('.input-mask-eyescript').mask('~9.99 ~9.99 999');
        $(".input-mask-product").mask("a*-999-a999", {placeholder: " ", completed: function () {
                alert("You typed the following: " + this.val());
            }});



        $('.easy-pie-chart.percentage').each(function () {
            var $box = $(this).closest('.infobox');
            var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
            var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
            var size = parseInt($(this).data('size')) || 50;
            $(this).easyPieChart({
                barColor: barColor,
                trackColor: trackColor,
                scaleColor: false,
                lineCap: 'butt',
                lineWidth: parseInt(size / 10),
                animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
                size: size
            });
        })

        $('.sparkline').each(function () {
            var $box = $(this).closest('.infobox');
            var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
            $(this).sparkline('html',
                    {
                        tagValuesAttribute: 'data-values',
                        type: 'bar',
                        barColor: barColor,
                        chartRangeMin: $(this).data('min') || 0
                    });
        });


        //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
        //but sometimes it brings up errors with normal resize event handlers
        $.resize.throttleWindow = false;

        var placeholder = $('#piechart-placeholder').css({'width': '90%', 'min-height': '150px'});
        var data = [
            {label: "social networks", data: 38.7, color: "#68BC31"},
            {label: "search engines", data: 24.5, color: "#2091CF"},
            {label: "ad campaigns", data: 8.2, color: "#AF4E96"},
            {label: "direct traffic", data: 18.6, color: "#DA5430"},
            {label: "other", data: 10, color: "#FEE074"}
        ]
        function drawPieChart(placeholder, data, position) {
            $.plot(placeholder, data, {
                series: {
                    pie: {
                        show: true,
                        tilt: 0.8,
                        highlight: {
                            opacity: 0.25
                        },
                        stroke: {
                            color: '#fff',
                            width: 2
                        },
                        startAngle: 2
                    }
                },
                legend: {
                    show: true,
                    position: position || "ne",
                    labelBoxBorderColor: null,
                    margin: [-30, 15]
                }
                ,
                grid: {
                    hoverable: true,
                    clickable: true
                }
            })
        }
        drawPieChart(placeholder, data);

        /**
         we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
         so that's not needed actually.
         */
        placeholder.data('chart', data);
        placeholder.data('draw', drawPieChart);


        //pie chart tooltip example
        var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
        var previousPoint = null;

        placeholder.on('plothover', function (event, pos, item) {
            if (item) {
                if (previousPoint != item.seriesIndex) {
                    previousPoint = item.seriesIndex;
                    var tip = item.series['label'] + " : " + item.series['percent'] + '%';
                    $tooltip.show().children(0).text(tip);
                }
                $tooltip.css({top: pos.pageY + 10, left: pos.pageX + 10});
            } else {
                $tooltip.hide();
                previousPoint = null;
            }

        });

        /////////////////////////////////////
        $(document).one('ajaxloadstart.page', function (e) {
            $tooltip.remove();
        });




        var d1 = [];
        for (var i = 0; i < Math.PI * 2; i += 0.5) {
            d1.push([i, Math.sin(i)]);
        }

        var d2 = [];
        for (var i = 0; i < Math.PI * 2; i += 0.5) {
            d2.push([i, Math.cos(i)]);
        }

        var d3 = [];
        for (var i = 0; i < Math.PI * 2; i += 0.2) {
            d3.push([i, Math.tan(i)]);
        }


        var sales_charts = $('#sales-charts').css({'width': '100%', 'height': '220px'});
        $.plot("#sales-charts", [
            {label: "Domains", data: d1},
            {label: "Hosting", data: d2},
            {label: "Services", data: d3}
        ], {
            hoverable: true,
            shadowSize: 0,
            series: {
                lines: {show: true},
                points: {show: true}
            },
            xaxis: {
                tickLength: 0
            },
            yaxis: {
                ticks: 10,
                min: -2,
                max: 2,
                tickDecimals: 3
            },
            grid: {
                backgroundColor: {colors: ["#fff", "#fff"]},
                borderWidth: 1,
                borderColor: '#555'
            }
        });


        $('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('.tab-content')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            //var w2 = $source.width();

            if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2))
                return 'right';
            return 'left';
        }


        $('.dialogs,.comments').ace_scroll({
            size: 300
        });


        //Android's default browser somehow is confused when tapping on label which will lead to dragging the task
        //so disable dragging when clicking on label
        var agent = navigator.userAgent.toLowerCase();
        if ("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
            $('#tasks').on('touchstart', function (e) {
                var li = $(e.target).closest('#tasks li');
                if (li.length == 0)
                    return;
                var label = li.find('label.inline').get(0);
                if (label == e.target || $.contains(label, e.target))
                    e.stopImmediatePropagation();
            });

        $('#tasks').sortable({
            opacity: 0.8,
            revert: true,
            forceHelperSize: true,
            placeholder: 'draggable-placeholder',
            forcePlaceholderSize: true,
            tolerance: 'pointer',
            stop: function (event, ui) {
                //just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
                $(ui.item).css('z-index', 'auto');
            }
        }
        );
        $('#tasks').disableSelection();
        $('#tasks input:checkbox').removeAttr('checked').on('click', function () {
            if (this.checked)
                $(this).closest('li').addClass('selected');
            else
                $(this).closest('li').removeClass('selected');
        });


        //show the dropdowns on top or bottom depending on window height and menu position
        $('#task-tab .dropdown-hover').on('mouseenter', function (e) {
            var offset = $(this).offset();

            var $w = $(window)
            if (offset.top > $w.scrollTop() + $w.innerHeight() - 100)
                $(this).addClass('dropup');
            else
                $(this).removeClass('dropup');
        });

    })
</script>
</body>
</html>