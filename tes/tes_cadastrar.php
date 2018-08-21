<?php
require_once 'tes_config.php';
require_once '../pagina/menu.php';

$stmt = $auth_user->runQuery("SELECT * FROM icms ORDER BY icms_id ASC");
$stmt->execute();

$stmt_estado = $auth_user->runQuery("SELECT * FROM estado");
$stmt_estado->execute();

$stmt_icms = $auth_user->runQuery("SELECT * FROM icms");
$stmt_icms->execute();

$stmt_pis = $auth_user->runQuery("SELECT * FROM pis");
$stmt_pis->execute();
?>

<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try {
                ace.settings.check('breadcrumbs', 'fixed')
                } catch (e) {
                }
            </script>
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="../principal/index.php">Home</a>
                </li>
                <li class="active">Cadastro</li>
            </ul><!-- /.breadcrumb -->
        </div>
        <div class="page-content">
<?php
require_once '../principal/principal_config.php';
?>

            <div class="col-sm-12">

                <form class="form-horizontal" method="post"> 
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Descrição</label>
                                        <div class="col-sm-9">
                                            <div>
                                                <input type="text" id="tes_descricao" required=""  name="tes_descricao" class="form-control" />
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Tipo</label>
                                        <div class="col-sm-9">
                                            <div>
                                                <select name="tes_tipo" class="form-control">
                                                    <option value="0">0 - ENTRADA</option>
                                                    <option value="1">1 - SAIDA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Natureza</label>
                                        <div class="col-sm-9">
                                            <div>
                                                <select name="tes_tipo" class="form-control">
                                                    <option value="1">1- Normal</option>
                                                    <option value="2">2- Devolução</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">CFOP</label>
                                        <div class="col-sm-9">
                                            <div>
                                                <input type="text" id="tes_cfop" required=""  name="tes_cfop" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">CF.</label>
                                        <div class="col-sm-9">
                                            <div>
                                                <input type="text" id="tes_consumidor_final" required=""  name="tes_consumidor_final" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">ICMS</label>
                                        <div class="col-sm-9">
                                            <div>
                                                <input type="text" id="tes_icms" required=""  name="tes_icms" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">IPI</label>
                                        <div class="col-sm-9">
                                            <div>
                                                <input type="text" id="tes_ipi" required=""  name="tes_ipi" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Controla Estoque</label>
                                        <div class="col-sm-9">
                                            <div>
                                                <input type="text" id="tes_estoque" required=""  name="tes_estoque" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">PIS/CONFIS</label>
                                        <div class="col-sm-9">
                                            <div>
                                                <input type="text" id="tes_pis_confis" required=""  name="tes_pis_confis" class="form-control" />
                                            </div>
                                        </div>
                                    </div>



                                </div><!-- /.col -->
                            </div><!-- /.row -->
                            <div class="tabbable tabs-right">
                                <ul class="nav nav-tabs" id="myTab3">
                                    <li class="active">
                                        <a data-toggle="tab" href="#icms">
                                            ICMS
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#pis">
                                            PIS
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#ipi">
                                            IPI
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <!-- ICMS CADASTRO -->
                                    <div id="icms" class="tab-pane in active">
                                        <p>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">Tipo </label>
                                            <div class="col-sm-9">
                                                <label>Simples </label>
                                                <button type="button" class="btn btn-xs btn-success" 
                                                        data-toggle="modal" data-target="#novost" 
                                                        data-st_id="<?php echo $row['st_id']; ?>"

                                                        >Novo</button>
                                            </div>                                            
                                        </div>


                                        </p> 
                                    </div>
                                    <!-- PIS CADASTRO -->
                                    <div id="pis" class="tab-pane">
                                        <p>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">PIS</label>
                                            <div class="col-sm-9">
                                                <div id="pis">

                                                    <select id="cmbpis" name="id_pis">
                                                        <option>Selecione</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        </p>
                                    </div>
                                    <!-- IPI CADASTRO -->
                                    <div id="ipi" class="tab-pane">
                                        <p>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">Sit. Tri.</label>
                                            <div class="col-sm-9">
                                                <div id="pis">

                                                    <select id="cmbipi" name="id_ipi">
                                                        <option>Selecione</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        </p> 
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Classe Enq.</label>
                                            <div class="col-sm-2">
                                                <div>
                                                    <input type="text" id="st_ipi_classe"  name="st_ipi_classe" class="form-control" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Código Enq.</label>
                                            <div class="col-sm-2">
                                                <div>
                                                    <input type="text" id="st_ipi_cod"  name="st_ipi_cod" class="form-control" />
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Tipo Calculo</label>
                                            <div class="col-sm-2">
                                                <!-- <div>
                                                     <input type="text" id="st_ipi_tipo_calculo"  name="st_ipi_tipo_calculo" class="form-control" />
                                                 </div> -->
                                                <select name="st_ipi_tipo_calculo">
                                                    <option value="0">Nao Calcula</option>
                                                    <option value="1">Valor Unidade</option>
                                                    <option value="2">Aliquota</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Aliquota</label>
                                            <div class="col-sm-2">
                                                <div>
                                                    <input type="text" id="st_ipi_aliquota"  name="st_ipi_aliquota" class="form-control" />
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" name="btn-cadastro" class="btn btn-success btn-xs">
                                        Cadastrar
                                    </button>
                                </div>
                            </div>
                        </div><!-- /.col -->
                    </div>

                </form>
            </div>
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->


<div class="modal fade" id="novost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Itens</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">ID Produto:</label>
                        <input name="id_produto" type="text" class="form-control" id="recipient-name">
                    </div>

                    <div class="form-group">
                        <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">ICMS</label>
                        <div class="col-sm-9">
                            <div id="cidade">
                                <select id="cmbCidade" name="id_icms">
                                    <option>Selecione</option>
                                </select>
                            </div>
                        </div>                                            
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-altera" class="btn btn-xs btn-warning">Alterar</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>



<script type="text/javascript">
                $(document).ready(function(){

                        < !-- Carrega os Estados -- >
                        $( '#cmbPais').change(functi on(e){
                var pais = $('#cmbEstado').val();
                $('#mensagem'). ht ml('<span class="mensagem">Aguarde, carregando ...</span>');                 $.getJSON('consulta.php?opcao=estado&valor=' + pais, function (dados){

                    if (dados.length > 0){
                    var option = '<option>Selecione</opti  o  n>';                    $.each(dados, function(i, obj){
                    option += '<option value="' + obj.icms_codigo + '">' + obj.icms_descricao + '</option>';
                        })
                    $('#mensagem').html('<span class="mens a gem" > Total de e s ta d o s    encontrados.: ' +     dados.length + '</span>');
                            } else{
                                Reset( );
                                $ ( '# m ensagem') .  h tml('<spanclass="mensagem">Não  f oram encontrados estados para esse país!</span>');
                                    }
                                    $('#cmbEstado').html(option).show();
                                    })
                                    })

                                            <  !-- Carrega as Cidades -- >
                                            $('#cmbEstado').change(function(e){
                                    var estado = $('#cmbEstado').val();
                                    $('#mensagem').html('<span class="mensagem">Aguarde, carregando ...</span>');
                                        $.getJSON('consulta.php?opcao=cidade&valor=' + estado, function (dados){

                                        if (dados.length > 0){
                                        var option = '<option>Selecione</option>';
                                        $.each(dados, function(i, obj){
                                      option += '<option value="'+obj.icms_id+'">'+obj.icms_descricao+'</option>';
                                })
                                $('#mensagem').html('<span class="mensagem">Total de cidades encontradas.: '+dados.length+'</span>');
                        }else{
                                Reset();
                                $('#mensagem').html('<span class="mensagem">Não foram encontradas cidades para esse estado!</span>');  
                        }
                        $('#cmbCidade').html(option).show();
                })
        })
        
//         

        
        <!-- Carrega as PIS -->
        $('#cmbEstado').change(function(e){
                var estado = $('#cmbEstado').val();
                $('#mensagem').html('<span class="mensagem">Aguarde, carregando ...</span>');  
		
                $.getJSON('consulta.php?opcao=pis&valor='+estado, function (dados){
			
                        if (dados.length > 0){ 	
                                var option = '<option>Selecione o PIS</option>';
                                $.each(dados, function(i, obj){
                                        option += '<option value="'+obj.pis_id+'">'+obj.pis_descricao+'</option>';
                                })
                                $('#mensagem').html('<span class="mensagem">Total de cidades encontradas.: '+dados.length+'</span>');
                        }else{
                                Reset();
                                $('#mensagem').html('<span class="mensagem">Não foram encontradas cidades para esse estado!</span>');  
                        }
                        $('#cmbpis').html(option).show();
                })
        })
        
         <!-- Carrega as IPI -->
        $('#cmbEstado').change(function(e){
                var estado = $('#cmbEstado').val();
                $('#mensagem').html('<span class="mensagem">Aguarde, carregando ...</span>');  
		
                $.getJSON('consulta.php?opcao=ipi&valor='+estado, function (dados){
			
                        if (dados.length > 0){ 	
                                var option = '<option>Selecione o IPI</option>';
                                $.each(dados, function(i, obj){
                                        option += '<option value="'+obj.ipi_id+'">'+obj.ipi_descricao+'</option>';
                                })
                                $('#mensagem').html('<span class="mensagem">Total de cidades encontradas.: '+dados.length+'</span>');
                        }else{
                                Reset();
                                $('#mensagem').html('<span class="mensagem">Não foram encontradas cidades para esse estado!</span>');  
                        }
                        $('#cmbipi').html(option).show();
                })
        })
	
        <!-- Resetar Selects -->
        function Reset(){
		
                $('#cmbPais').empty().append('<option>Carregar Tipo</option>>');
                $('#cmbCidade').empty().append('<option>Carregar ICMS</option>');
                $('#cmbpis').empty().append('<option>Carregar PIS</option>');
                $('#cmbipi').empty().append('<option>Carregar IPI</option>');
                $('#carregaestado').empty().append('<option>Carregar ICMS de ENTRADA OU SAIDA</option>');
                
        }
});
</script>
<?php
require_once '../pagina/footer.php';
?>