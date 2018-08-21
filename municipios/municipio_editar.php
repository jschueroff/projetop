<?php
require_once 'municipio_config.php';

$id = $_GET['id'];
$stmt2 = $auth_user->runQuery("SELECT * FROM municipio, estado WHERE  municipio_id =:id");
$stmt2->execute(array(":id" => $id));
$lista = $stmt2->fetch(PDO::FETCH_ASSOC);

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
                <li class="active">Editar</li>
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
                            <label class="col-sm-1 control-label no-padding-right"> ID </label>
                            <div class="col-sm-9">
                                <input type="hidden" name="municipio_id" value="<?php echo $lista['municipio_id']; ?>">
                                <input type="text" id="municipio_id" name="municipio_id"  value="<?php echo $lista['municipio_id']; ?>" class="col-xs-3 col-sm-2" disabled=""/>                               
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Cod. IBGE</label>
                            <div class="col-sm-3">
                                <input type="text" id="municipio_cod_ibge"  name="municipio_cod_ibge" value="<?php echo $lista['municipio_cod_ibge']; ?>"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Nome</label>
                            <div class="col-sm-9">
                                <input type="text" id="municipio_nome"  name="municipio_nome" value="<?php echo $lista['municipio_nome']; ?>"  class="form-control" />
                            </div>
                        </div>
                    
                               <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Estado</label>
                            <div class="col-sm-9">
                                <select class="col-sm-4" id="id_estado" name="id_estado">
                                    <option value="28" <?= ($lista['id_estado'] == '28') ? 'selected' : '' ?> >EXTERIOR</option>  
                                    <option value="1" <?= ($lista['id_estado'] == '1') ? 'selected' : '' ?> >AC</option>
                                    <option value="2" <?= ($lista['id_estado'] == '2') ? 'selected' : '' ?> >AL</option>
                                    <option value="3" <?= ($lista['id_estado'] == '3') ? 'selected' : '' ?> >AM</option>
                                    <option value="4" <?= ($lista['id_estado'] == '4') ? 'selected' : '' ?> >AP</option>
                                    <option value="5" <?= ($lista['id_estado'] == '5') ? 'selected' : '' ?> >BA</option>
                                    <option value="6" <?= ($lista['id_estado'] == '6') ? 'selected' : '' ?> >CE</option>
                                    <option value="7" <?= ($lista['id_estado'] == '7') ? 'selected' : '' ?> >DF</option>
                                    <option value="8" <?= ($lista['id_estado'] == '8') ? 'selected' : '' ?> >ES</option>
                                    <option value="9" <?= ($lista['id_estado'] == '9') ? 'selected' : '' ?> >GO</option>
                                    <option value="10" <?= ($lista['id_estado'] == '10') ? 'selected' : '' ?> >MA</option>
                                    <option value="11" <?= ($lista['id_estado'] == '11') ? 'selected' : '' ?> >MG</option>
                                    <option value="12" <?= ($lista['id_estado'] == '12') ? 'selected' : '' ?> >MS</option>
                                    <option value="13" <?= ($lista['id_estado'] == '13') ? 'selected' : '' ?> >MT</option>
                                    <option value="14" <?= ($lista['id_estado'] == '14') ? 'selected' : '' ?> >PA</option>
                                    <option value="15" <?= ($lista['id_estado'] == '15') ? 'selected' : '' ?> >PB</option>
                                    <option value="16" <?= ($lista['id_estado'] == '16') ? 'selected' : '' ?> >PE</option>
                                    <option value="17" <?= ($lista['id_estado'] == '17') ? 'selected' : '' ?> >PI</option>
                                    <option value="18" <?= ($lista['id_estado'] == '18') ? 'selected' : '' ?> >PR</option>
                                    <option value="19" <?= ($lista['id_estado'] == '19') ? 'selected' : '' ?> >RJ</option>
                                    <option value="20" <?= ($lista['id_estado'] == '20') ? 'selected' : '' ?> >RN</option>
                                    <option value="21" <?= ($lista['id_estado'] == '21') ? 'selected' : '' ?> >RO</option>
                                    <option value="22" <?= ($lista['id_estado'] == '22') ? 'selected' : '' ?> >RR</option>
                                    <option value="23" <?= ($lista['id_estado'] == '23') ? 'selected' : '' ?> >RS</option>
                                    <option value="24" <?= ($lista['id_estado'] == '24') ? 'selected' : '' ?> >SC</option>
                                    <option value="25" <?= ($lista['id_estado'] == '25') ? 'selected' : '' ?> >SE</option>                                                                        
                                    <option value="26" <?= ($lista['id_estado'] == '26') ? 'selected' : '' ?> >SP</option>                                                                        
                                    <option value="27" <?= ($lista['id_estado'] == '27') ? 'selected' : '' ?> >TO</option>                                                                        
                                                                                                          
                                </select>
                            </div>
                        </div>
                         
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">

                                <button type="submit" name="btn-salvar" class="btn btn-info">
                                    Alterar
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