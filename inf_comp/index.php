<?php
require_once 'inf_comp_config.php';
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
                <li class="active">Informações Complementares</li>
            </ul><!-- /.breadcrumb -->


        </div>

        <div class="page-content">
            <?php
            require_once('../principal/principal_config.php');
            ?>


            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="row">
                            <form class="form-horizontal" method="post">                            
                                <div class="col-xs-7">
                                    <input type="text" name="inf_comp_pesquisa" class="col-xs-6" placeholder="Informação Complementar"/>
                                    <button class="btn btn-info2 btn-sm" name="btn-pesquisar" type="submit">
                                        <i class="ace-icon fa fa-filter bigger-100 green"></i>
                                        Pesquisar
                                    </button>
                                </div>                            
                            </form>
                            <p>
                                <a href="inf_comp_cadastrar.php">
                                    <button class="btn btn-success btn-sm" name="btn-cadastrar" type="submit">
                                        <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                        Novo
                                    </button>
                                </a>
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <table id="simple-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="hidden-480">Des. Resumida</th>
                                            <th class="hidden-480">Apelido</th>
                                            <th class="hidden-480">Interesse</th>
                                            <th class="hidden-480">Cód. Exportação</th>
                                            <th class="hidden-480">Status</th>
                                            <th class="hidden-480 center">Configurar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <tr>
                                                <th><?php echo $row['inf_comp_id'] ?></th>
                                                <th class="hidden-480"><?php echo $row['inf_comp_descricao_resumida']; ?></th>
                                                <th class="hidden-480"><?php echo $row['inf_comp_apelido']; ?></th>
                                                <th class="hidden-480"><?php echo $row['inf_comp_interesse']; ?></th>
                                                <th class="hidden-480"><?php echo $row['inf_comp_exportacao']; ?></th>
                                                <th class="hidden-480"><?php
                                                    if ($row['inf_comp_status'] == 0) {
                                                        echo "I";
                                                    } else {
                                                        echo "A";
                                                    }
                                                    ?></th>

                                                <th class="hidden-480 center">
                                                    <!-- CHAMADA ESTA NO FOOTER VERIFICAR LA ISSO SE PRECISAR MUDAR LINHA 60 -->
                                                    <button type="button" class="btn btn-xs btn-warning" 
                                                            data-toggle="modal" data-target="#editarinfo" 
                                                            data-inf_comp_id="<?php echo $row['inf_comp_id']; ?>"
                                                            data-inf_comp_descricao_resumida="<?php echo $row['inf_comp_descricao_resumida']; ?>"
                                                            data-inf_comp_apelido="<?php echo $row['inf_comp_apelido']; ?>"
                                                            data-inf_comp_interesse="<?php echo $row['inf_comp_interesse']; ?>"
                                                            data-inf_comp_descricao="<?php echo $row['inf_comp_descricao']; ?>"
                                                            data-inf_comp_exportacao="<?php echo $row['inf_comp_exportacao']; ?>"
                                                            >Editar</button>
                                                    <?php
                                                    if($row['inf_comp_status'] == 1){
                                                    ?>
                                                    <button type="button" class="btn btn-xs btn-danger" 
                                                            data-toggle="modal" data-target="#inativarinfo" 
                                                            data-inf_comp_id="<?php echo $row['inf_comp_id']; ?>"
                                                            >Inativar</button>
                                                    <?php
                                                    }
                                                    if($row['inf_comp_status'] == 0){
                                                    ?>
                                                    <button type="button" class="btn btn-xs btn-alert" 
                                                            data-toggle="modal" data-target="#ativarinfo" 
                                                            data-inf_comp_id="<?php echo $row['inf_comp_id']; ?>"
                                                            >Ativar</button>
                                                    <?php 
                                                    }
                                                    ?>


                                                </th>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div><!-- /.span -->
                        </div><!-- /.row -->
                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->
</div>

<!--

A CHAMADA DO JAVASCRIP ESTA NO FOOTER VERIFCAR LA ISSO E ABAIXO MOSTRA OS DADOS NO FOOTER
-->
<!--INATIVAR INFORMAÇÕES COMPLEMENTARES-->
<div class="modal fade" id="inativarinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Informações Complementares</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <form method="POST" enctype="multipart/form-data">
                            <fieldset>
                                <legend>Inativar Informações Complementares</legend>

                                <input name="inf_comp_id" class="form-control" type="hidden" id="inf_comp_id">
                                <div class="clearfix form-actions">
                                    <div class="col-md-offset-10 col-md-9">
                                        <button type="submit" name="btn-inativar" class="btn btn-danger btn-sm">
                                            Salvar
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>			  
        </div>
    </div>
</div>
<!--ATIVAR INFORMAÇÕES COMPLEMENTARES-->
<div class="modal fade" id="ativarinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Informações Complementares</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <form method="POST" enctype="multipart/form-data">
                            <fieldset>
                                <legend>Ativar Informações Complementares</legend>

                                <input name="inf_comp_id" class="form-control" type="hidden" id="inf_comp_id">
                                <div class="clearfix form-actions">
                                    <div class="col-md-offset-10 col-md-9">
                                        <button type="submit" name="btn-ativar" class="btn btn-alert btn-sm">
                                            Salvar
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>			  
        </div>
    </div>
</div>



<div class="modal fade" id="editarinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Informações Complementares</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <form method="POST" enctype="multipart/form-data">
                            <fieldset>
                                <legend>Editar Informações Complementares</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label  class="control-label">Desc. Resumida</label>
                                            <input name="inf_comp_descricao_resumida" class="form-control" id="inf_comp_descricao_resumida">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label  class="control-label">Apelido</label>
                                            <input name="inf_comp_apelido" class="form-control" id="inf_comp_apelido">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label  class="control-label">Interesse</label>
                                            <select name="inf_comp_interesse" class="form-control" id="inf_comp_interesse">
                                                <option value="C">Contribuinte</option>
                                                <option value="F">Fisco</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label  class="control-label">Descrição</label>
                                            <textarea name="inf_comp_descricao" class="form-control" id="inf_comp_descricao"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label  class="control-label">Cód Exp.</label>
                                            <input name="inf_comp_exportacao" class="form-control" id="inf_comp_exportacao">
                                        </div>
                                    </div>
                                </div>
                                <input name="inf_comp_id" class="form-control" type="hidden" id="inf_comp_id">
                                <div class="clearfix form-actions">
                                    <div class="col-md-offset-10 col-md-9">
                                        <button type="submit" name="btn-salvar" class="btn btn-success btn-sm">
                                            Salvar
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <!--                <form method="POST" enctype="multipart/form-data">
                                    <div class="row">
                
                
                                        <div class="form-group">
                                            <input name="inf_comp_id" type="hidden" class="form-control" id="inf_comp_id">
                                        </div>
                                        <legend>Editar Inf. Complementares</legend>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label  class="control-label">Descrição Resumida</label>
                                                <input name="inf_comp_descricao_resumida" type="text" class="form-control" id="inf_comp_descricao_resumida">
                                            </div>
                                        </div>
                                    </div>
                
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" name="btn-emite" class="btn btn-xs btn-success">Emitir NF-e</button>
                                    </div>
                                </form>-->
            </div>			  
        </div>
    </div>
</div>



<?php
require_once '../pagina/footer.php';
?>