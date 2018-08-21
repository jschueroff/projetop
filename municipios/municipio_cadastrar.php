<?php
require_once 'municipio_config.php';
require_once '../pagina/menu.php';
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
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12">
                            <form class="form-horizontal" method="post">

                                <div class="form-group">
                                    <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Cod. IBGE</label>
                                    <div class="col-sm-3">
                                        <input type="text" id="municipio_cod_ibge"  name="municipio_cod_ibge"  class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Nome</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="municipio_nome"  name="municipio_nome"  class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Estado</label>
                                    <div class="col-sm-9">
                                        <select class="col-sm-4" id="id_estado" name="id_estado">
                                            <option value="28"  >EXTERIOR</option> 
                                            <option value="1" >AC</option>
                                            <option value="2"  >AL</option>
                                            <option value="3"  >AM</option>
                                            <option value="4"  >AP</option>
                                            <option value="5"  >BA</option>
                                            <option value="6"  >CE</option>
                                            <option value="7"  >DF</option>
                                            <option value="8"  >ES</option>
                                            <option value="9"  >GO</option>
                                            <option value="10"  >MA</option>
                                            <option value="11"  >MG</option>
                                            <option value="12"  >MS</option>
                                            <option value="13"  >MT</option>
                                            <option value="14"  >PA</option>
                                            <option value="15"  >PB</option>
                                            <option value="16"  >PE</option>
                                            <option value="17"  >PI</option>
                                            <option value="18"  >PR</option>
                                            <option value="19"  >RJ</option>
                                            <option value="20"  >RN</option>
                                            <option value="21"  >RO</option>
                                            <option value="22"  >RR</option>
                                            <option value="23"  >RS</option>
                                            <option value="24"  >SC</option>
                                            <option value="25"  >SE</option>                                                                        
                                            <option value="26"  >SP</option>                                                                        
                                            <option value="27"  >TO</option> 
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="clearfix form-actions">
                                    <div class="col-md-offset-3 col-md-9">

                                        <button type="submit" name="btn-cadastro" class="btn btn-info">
                                            Cadastrar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<?php
require_once '../pagina/footer.php';
?>