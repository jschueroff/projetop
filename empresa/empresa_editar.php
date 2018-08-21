<?php
require_once 'empresa_config.php';

$id = $_GET['id'];

$stmt2 = $auth_user->runQuery("SELECT * FROM empresa WHERE empresa_id =:id");
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
                <li class="active">Editar Empresa</li>
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
                                <input type="text" id="empresa_id" name="empresa_id"  value="<?php echo $lista['empresa_id']; ?>" class="col-xs-3 col-sm-2"/>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Nome</label>

                            <div class="col-sm-9">
                                <input type="text" id="empresa_nome"  name="empresa_nome" value="<?php echo $lista['empresa_nome']; ?>"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Fantasia</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_fantasia"  name="empresa_fantasia" value="<?php echo $lista['empresa_fantasia']; ?>"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">CNPJ</label>

                            <div class="col-sm-9">
                                <div class="inline">
                                    <input type="text" name="empresa_cnpj" id="empresa_cnpj" value="<?php echo $lista['empresa_cnpj'] ?>" />
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-tags">Ins. E.</label>
                            <div class="col-sm-9">
                                <div class="inline">
                                    <input type="text" name="empresa_ie" id="empresa_ie" value="<?php echo $lista['empresa_ie'] ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Ins. M.</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_im" name="empresa_im" value="<?php echo $lista['empresa_im']; ?>"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Tipo</label>
                            <div class="col-sm-9">
                                <select class="col-sm-4" id="empresa_tipo" name="empresa_tipo">
                                    <option value="1" <?= ($lista['empresa_tipo'] == '1') ? 'selected' : '' ?> >1- Contribuinte</option>
                                    <option value="2" <?= ($lista['empresa_tipo'] == '2') ? 'selected' : '' ?> >2- Teste</option>
                                    <option value="9" <?= ($lista['empresa_tipo'] == '9') ? 'selected' : '' ?> >9- Não Contribuinte</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">CNAE</label>

                            <div class="col-sm-9">
                                <input type="text" id="empresa_cnae" name="empresa_cnae" value="<?php echo $lista['empresa_cnae']; ?>"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Reg. Trib.</label>

                            <div class="col-sm-9">
                            
                             <select class="col-sm-4" id="empresa_tipo" name="empresa_crt">
                                    <option value="1" <?= ($lista['empresa_crt'] == '1') ? 'selected' : '' ?> >1 - Simples Nacional</option>
                                    <option value="2" <?= ($lista['empresa_crt'] == '2') ? 'selected' : '' ?> >2 - Simples Nacional - excesso de sublimite da receita bruta</option>
                                    <option value="3" <?= ($lista['empresa_crt'] == '3') ? 'selected' : '' ?> >3 - Regime Normal</option>
                                </select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">E-mail</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_email" name="empresa_email" value="<?php echo $lista['empresa_email']; ?>"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">E-mail NF</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_email_nfe" name="empresa_email_nfe" value="<?php echo $lista['empresa_email_nfe']; ?>"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Telefone</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_telefone" name="empresa_telefone" value="<?php echo $lista['empresa_telefone']; ?>"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Status</label>
                            <div class="col-sm-9">
                                <select class="col-sm-4" id="empresa_status" name="empresa_status">
                                    <option value="1" <?= ($lista['empresa_status'] == '1') ? 'selected' : '' ?> >1- Ativo</option>
                                    <option value="0" <?= ($lista['empresa_status'] == '0') ? 'selected' : '' ?> >0- Inativo</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Logradouro</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_logradouro" name="empresa_logradouro" value="<?php echo $lista['empresa_logradouro']; ?>"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">N°</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_numero" name="empresa_numero" value="<?php echo $lista['empresa_numero']; ?>"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Compl.</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_complemento" name="empresa_complemento" value="<?php echo $lista['empresa_complemento']; ?>"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Bairro  </label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_bairro" name="empresa_bairro" value="<?php echo $lista['empresa_bairro']; ?>"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">CEP </label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_cep" name="empresa_cep" value="<?php echo $lista['empresa_cep']; ?>"  class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Estado</label>
                            <div class="col-sm-9">
                                <select class="col-sm-4" id="id_estado" name="id_estado">
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



                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Municipio</label>
                            <div class="col-sm-9">
                                <select class="col-sm-4" id="id_municipio" name="id_municipio">
                                    <?php
                                    while ($row_mun = $stmt_municipio->fetch(PDO::FETCH_ASSOC)) {

                                        if ($lista['id_municipio'] == $row_mun['municipio_id']) {
                                            ?>

                                            <option value="<?php echo $row_mun['municipio_id'] ?>" selected=""><?php echo $row_mun['municipio_nome'] . "-" . $row_mun['municipio_sigla']; ?></option>
                                            <?php
                                        } else {
                                            ?>
                                            <option value="<?php echo $row_mun['municipio_id'] ?>"><?php echo $row_mun['municipio_nome'] . "-" . $row_mun['municipio_sigla']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">N° NF-e</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_numero_nfe" name="empresa_numero_nfe" value="<?php echo $lista['empresa_numero_nfe']; ?>"  class="form-control" />
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Amb. NF-e</label>
                            <div class="col-sm-9">
                                <select class="col-sm-4" id="empresa_ambiente_nfe" name="empresa_ambiente_nfe">
                                    <option value="1" <?= ($lista['empresa_ambiente_nfe'] == '1') ? 'selected' : '' ?> >PRODUÇÃO</option>
                                    <option value="2" <?= ($lista['empresa_ambiente_nfe'] == '2') ? 'selected' : '' ?> >HOMOLOGAÇÃO</option>
                                </select>
                            </div>
                         </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Série NF-e</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_serie_nfe" name="empresa_serie_nfe" value="<?php echo $lista['empresa_serie_nfe']; ?>"  class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label no-padding-right" for="form-field-1-1">Modelo NF-e</label>
                            <div class="col-sm-9">
                                <input type="text" id="empresa_modelo_nfe" name="empresa_modelo_nfe" value="<?php echo $lista['empresa_modelo_nfe']; ?>"  class="form-control" />
                            </div>
                        </div>

                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" name="btn-salvar" class="btn btn-warning btn-xs">
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