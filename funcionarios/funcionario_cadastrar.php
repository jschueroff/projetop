<?php
require_once 'funcionario_config.php';

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
                                <input type="text" id="funcionario_nome"  name="funcionario_nome" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">CPF</label>

                            <div class="col-sm-9">
                                <div class="inline">
                                    <input type="text" name="funcionario_cpf" id="funcionario_nome"  />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">E-mail</label>

                            <div class="col-sm-9">
                                <input type="text" id="funcionario_email" name="funcionario_email" class="form-control" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Senha</label>

                            <div class="col-sm-4">
                                <input type="password" id="funcionario_senha" name="funcionario_senha" class="form-control" />
                            </div>
                        </div>

                       
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Endereço</label>

                            <div class="col-sm-9">
                                <input type="text" id="funcionario_endereco" name="funcionario_endereco"   class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Nasc.</label>

                            <div class="col-sm-9">
                                <input type="text" id="funcionario_data_nascimento" name="funcionario_data_nascimento" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Cidade</label>

                            <div class="col-sm-9">
                                <input type="text" id="funcionario_cidade" name="funcionario_cidade" class="form-control" />
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
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->




<?php
require_once '../pagina/footer.php';
?>