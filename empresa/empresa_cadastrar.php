<?php
require_once 'empresa_config.php';

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
            <div class="ace-settings-container" id="ace-settings-container">
                <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                    <i class="ace-icon fa fa-cog bigger-130"></i>
                </div>
                <div class="ace-settings-box clearfix" id="ace-settings-box">
                    <div class="pull-left width-50">
                        <div class="ace-settings-item">
                            <div class="pull-left">
                                <select id="skin-colorpicker" class="hide">
                                    <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                                    <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                    <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                    <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                </select>
                            </div>
                            <span>&nbsp; Choose Skin</span>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                            <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                            <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                            <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                            <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                            <label class="lbl" for="ace-settings-add-container">
                                Inside
                                <b>.container</b>
                            </label>
                        </div>
                    </div><!-- /.pull-left -->

                    <div class="pull-left width-50">
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
                            <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
                            <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
                            <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                        </div>
                    </div><!-- /.pull-left -->
                </div><!-- /.ace-settings-box -->
            </div><!-- /.ace-settings-container -->

            <div class="row">
                <div class="col-xs-12">
                    <form class="form-horizontal" method="post">
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Nome</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_nome"  name="empresa_nome" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Fantasia</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_fantasia"  name="empresa_fantasia" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">CNPJ</label>
                            <div class="col-sm-9">
                                <div class="inline">
                                    <input type="text" name="empresa_cnpj" id="empresa_cnpj"  />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">Ins. Es.</label>
                            <div class="col-sm-9">
                                <div class="inline">
                                    <input type="text" name="empresa_ie" id="empresa_ie"  />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">Ins. Mu</label>
                            <div class="col-sm-9">
                                <div class="inline">
                                    <input type="text" name="empresa_im" id="empresa_im"  />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">CNAE</label>
                            <div class="col-sm-9">
                                <div class="inline">
                                    <input type="text" name="empresa_cnae" id="empresa_cnae"  />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">Reg. Trib.</label>
                            <div class="col-sm-9">
                                <div class="inline">
                                    <input type="text" name="empresa_crt" id="empresa_crt"  />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">E-mail</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_email" name="empresa_email" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">E-mail NF</label>
                            <div class="col-sm-4">
                                <input type="text" id="empresa_email_nfe" name="empresa_email_nfe" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Telefone</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_telefone" name="empresa_telefone"   class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Logradouro</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_logradouro" name="empresa_logradouro" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">N°</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_numero" name="empresa_numero" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Compl.</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_complemento" name="empresa_complemento" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Bairro</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_bairro" name="empresa_bairro" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">CEP</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_cep" name="empresa_cep" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Estado</label>
                            <div class="col-sm-9">
                                <select class="col-sm-4" id="id_estado" name="id_estado">
                                    <option value="1">AC</option>
                                    <option value="2">AL</option>
                                    <option value="3">AM</option>
                                    <option value="4">AP</option>
                                    <option value="5">BA</option>
                                    <option value="6">CE</option>
                                    <option value="7">DF</option>
                                    <option value="8">ES</option>
                                    <option value="9">GO</option>
                                    <option value="10">MA</option>
                                    <option value="11">MG</option>
                                    <option value="12">MS</option>
                                    <option value="13">MT</option>
                                    <option value="14">PA</option>
                                    <option value="15">PB</option>
                                    <option value="16">PE</option>
                                    <option value="17">PI</option>
                                    <option value="18">PR</option>
                                    <option value="19">RJ</option>
                                    <option value="20">RN</option>
                                    <option value="21">RO</option>
                                    <option value="22">RR</option>
                                    <option value="23">RS</option>
                                    <option value="24" selected="">SC</option>
                                    <option value="25">SE</option>                                                                        
                                    <option value="26">SP</option>                                                                        
                                    <option value="27">TO</option>                                                                        
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Municipio</label>
                            <div class="col-sm-9">
                                <select class="col-sm-4" id="id_municipio" name="id_municipio">
                                    <?php
                                    while ($row_mun = $stmt_municipio->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        ?>
                                        <option value="<?php echo $row_mun['municipio_id'] ?>"><?php echo $row_mun['municipio_nome'] . "-" . $row_mun['municipio_sigla']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" name="btn-cadastro" class="btn btn-info btn-xs">
                                    Cadastrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<?php
require_once '../pagina/footer.php';
?>