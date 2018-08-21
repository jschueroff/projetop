<?php
require_once 'st_config.php';
require_once '../pagina/menu.php';

$stmt = $auth_user->runQuery("SELECT * FROM icms ORDER BY icms_id ASC");
$stmt->execute();

$stmt_estado = $auth_user->runQuery("SELECT * FROM estado");
$stmt_estado->execute();

$stmt_icms = $auth_user->runQuery("SELECT * FROM icms");
$stmt_icms->execute();

$stmt_pis = $auth_user->runQuery("SELECT * FROM pis");
$stmt_pis->execute();

$stmt_cofins = $auth_user->runQuery("SELECT * FROM cofins");
$stmt_cofins->execute();
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
                <form  method="post"> 
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-xs-12">
                                    <legend>Nova Situação Tributária</legend>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" id="st_nome" required=""  name="st_nome" class="form-control" />
                                        </div> 
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>UF Origem</label>
                                            <select id="st_uf" name="st_uf" class="form-control">
                                            <?php
                                            while ($row = $stmt_estado->fetch(PDO::FETCH_ASSOC)) {
                                                if ($row['estado_id'] == 24) {
                                                    ?>
                                                        <option value="<?php echo $row['estado_id']; ?>" selected=""><?php echo $row['estado_sigla']; ?></option>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <option value="<?php echo $row['estado_id']; ?>"><?php echo $row['estado_sigla']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label >Tipo</label>
                                            <div id="estado">
                                                <select id="cmbEstado" name="st_tipo" class="form-control">
                                                    <option selected="">Selecione</option>
                                                    <option value="0">Entrada</option>
                                                    <option value="1">Saida</option>
                                                </select>
                                            </div>
                                        </div> 
                                    </div>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                            <div class="tabbable tabs-left">
                                <ul class="nav nav-tabs" id="myTab3">
                                    <li class="active">
                                        <a data-toggle="tab" href="#pis">
                                            PIS
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#ipi">
                                            IPI
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#cofins">
                                            COFINS
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">

                                    <!-- PIS CADASTRO -->
                                    <div id="pis" class="tab-pane in active">
                                        <legend>PIS</legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label >Situação Tributária</label>
                                                    <div id="pis">
                                                        <select id="cmbpis" name="id_pis" class="form-control">
                                                            <option>Selecione</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Reg. de Apu.</label>
                                                    <select name="st_pis_regime_apuracao" class="form-control">
                                                        <option selected="" value="">Não Tem</option>
                                                        <option value="1">Cumulativo</option>
                                                        <option value="2">Não Cumulativo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Aliquota</label>
                                                    <input type="text" id="st_pis_aliquota"  name="st_pis_aliquota" class="form-control" />
                                                </div>
                                            </div>
                                             <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Tipo Calculo</label>
                                                    <select name="st_pis_tipo_calculo" class="form-control">
                                                        <option selected=""></option>
                                                        <option value="1">Valor da Unidade</option>
                                                        <option value="2">Aliquota</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <legend>PIS Substituição Tributária</legend>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Tipo Calculo ST</label>
                                                    <select name="st_pis_tipo_calculo_st" class="form-control">
                                                        <option selected=""></option>
                                                        <option value="1">Valor da Unidade</option>
                                                        <option value="2">Aliquota</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Aliquota</label>
                                                    <input type="text" id="st_pis_aliquota_st"  name="st_pis_aliquota_st" class="form-control" />
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!-- IPI CADASTRO -->
                                    <div id="ipi" class="tab-pane">
                                        <legend>IPI</legend>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Situação Tributária</label>
                                                    <div id="pis">
                                                        <select id="cmbipi" name="id_ipi" class="form-control">
                                                            <option>Selecione</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label >Classe Enq.</label>
                                                    <input type="text" id="st_ipi_classe"  name="st_ipi_classe" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label >Código Enq.</label>
                                                    <input type="text" id="st_ipi_cod"  name="st_ipi_cod" class="form-control" />
                                                </div> 
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Tipo Calculo</label>
                                                    <select name="st_ipi_tipo_calculo" class="form-control">
                                                        <option value="0">Nao Calcula</option>
                                                        <option value="1">Valor Unidade</option>
                                                        <option value="2">Aliquota</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Aliquota</label>
                                                    <input type="text" id="st_ipi_aliquota"  name="st_ipi_aliquota" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- COFINS CADASTRO -->
                                    <div id="cofins" class="tab-pane">
                                        <legend>COFINS</legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Situação Tributária</label>
                                                    <div id="cofins">
                                                        <select id="cmbcofins" name="id_cofins" class="form-control">
                                                            <option>Selecione</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Reg. de Apu.</label>
                                                    <select name="st_cofins_regime_apuracao" class="form-control">
                                                        <option selected="" value="">Não Tem</option>
                                                        <option value="1">Cumulativo</option>
                                                        <option value="2">Não Cumulativo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Aliquota</label>
                                                    <input type="text" id="st_cofins_aliquota"  name="st_cofins_aliquota" class="form-control" />
                                                </div>
                                            </div>
                                             <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Tipo Calculo</label>
                                                    <select name="st_cofins_tipo_calculo" class="form-control">
                                                        <option selected=""></option>
                                                        <option value="1">Valor da Unidade</option>
                                                        <option value="2">Aliquota</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <legend>COFINS Substituição Tributária</legend>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Tipo Calculo ST</label>
                                                    <select name="st_cofins_tipo_calculo_st" class="form-control">
                                                        <option selected=""></option>
                                                        <option value="1">Valor da Unidade</option>
                                                        <option value="2">Aliquota</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Aliquota</label>
                                                    <input type="text" id="st_cofins_aliquota_st"  name="st_cofins_aliquota_st" class="form-control" />
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-10 col-md-9">
                                    <button type="submit" name="btn-cadastro" class="btn btn-info btn-sm">
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



<script type="text/javascript">
$(document).ready(function(){
		
	<!-- Carrega os Estados -->
	$('#cmbPais').change(function(e){
		var pais = $('#cmbEstado').val();
		$('#mensagem').html('<span class="mensagem">Aguarde, carregando ...</span>');  
		
		$.getJSON('consulta.php?opcao=estado&valor='+pais, function (dados){ 
		
		   if (dados.length > 0){	
			  var option = '<option>Selecione</option>';
			  $.each(dados, function(i, obj){
				  option += '<option value="'+obj.icms_codigo+'">'+obj.icms_descricao+'</option>';
			  })
			  $('#mensagem').html('<span class="mensagem">Total de estados encontrados.: '+dados.length+'</span>'); 
		   }else{
			  Reset();
			  $('#mensagem').html('<span class="mensagem">Não foram encontrados estados para esse país!</span>');  
		   }
		   $('#cmbEstado').html(option).show(); 
		})
	})
	
	<!-- Carrega as Cidades -->
	$('#cmbEstado').change(function(e){
		var estado = $('#cmbEstado').val();
		$('#mensagem').html('<span class="mensagem">Aguarde, carregando ...</span>');  
		
		$.getJSON('consulta.php?opcao=cidade&valor='+estado, function (dados){
			
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
        
           <!-- Carrega as COFINS -->
	$('#cmbEstado').change(function(e){
		var estado = $('#cmbEstado').val();
		$('#mensagem').html('<span class="mensagem">Aguarde, carregando ...</span>');  
		
		$.getJSON('consulta.php?opcao=cofins&valor='+estado, function (dados){
			
			if (dados.length > 0){ 	
				var option = '<option>Selecione o COFINS</option>';
				$.each(dados, function(i, obj){
					option += '<option value="'+obj.cofins_id+'">'+obj.cofins_descricao+'</option>';
				})
				$('#mensagem').html('<span class="mensagem">Total de cidades encontradas.: '+dados.length+'</span>');
			}else{
				Reset();
				$('#mensagem').html('<span class="mensagem">Não foram encontradas cidades para esse estado!</span>');  
			}
			$('#cmbcofins').html(option).show();
		})
	})
	<!-- Resetar Selects -->
	function Reset(){
		
		$('#cmbPais').empty().append('<option>Carregar Tipo</option>>');
		$('#cmbCidade').empty().append('<option>Carregar ICMS</option>');
                $('#cmbpis').empty().append('<option>Carregar PIS</option>');
                $('#cmbipi').empty().append('<option>Carregar IPI</option>');
                $('#cmbcofins').empty().append('<option>Carregar COFINS</option>');
                $('#carregaestado').empty().append('<option>Carregar ICMS de ENTRADA OU SAIDA</option>');
                
	}
});
</script>
<?php
require_once '../pagina/footer.php';
?>