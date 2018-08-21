<?php
require_once 'grupo_config.php';
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
                <li class="active">GRUPO/SUBGRUPO</li>
            </ul><!-- /.breadcrumb -->


        </div>

        <div class="page-content">
            <?php
            require_once '../principal/principal_config.php';
            ?>


            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="row">
                            <form class="form-horizontal" method="post">                            
                                <div class="col-xs-7">
                                    <input type="text" id="ncm_id" name="grupo_pesquisa" autofocus="" class="col-xs-6" placeholder="Grupo ou Descrição"/>
                                    <button class="btn btn-white btn-info btn-bold col-xs-3" name="btn-pesquisar" type="submit">
                                        <i class="ace-icon fa fa-filter bigger-100 green"></i>
                                        Pesquisar
                                    </button>
                                </div>                            
                            </form>
                            <p>
                                <a href="grupo_cadastrar.php">
                                    <button class="btn btn-white btn-info btn-bold" name="btn-cadastrar" type="submit">
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
                                            <th class="hidden-480">Nome</th>

                                            <th class="hidden-480">Descriçao</th>
                                            <th class="hidden-480">Tipo</th>
                                            <th class="hidden-480 center" colspan="2" >Configurar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $id = 1;
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $valor[$id] = $row['grupo_id'];
                                            ?>
                                        <form method="post" id="login-form">
                                            <tr>
                                                <td><?php echo $row['grupo_id']; ?></td>
                                                <td class="hidden-480"><?php echo $row['grupo_nome']; ?></td>

                                                <td class="hidden-480"><?php echo $row['grupo_descricao']; ?></td>
                                                <td class="hidden-480"><?php
                                                    if ($row['grupo_tipo'] == 1) {
                                                        echo "Grupo";
                                                    } else {
                                                        echo "Sub-Grupo";
                                                    }
                                                    ?></td>


                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">
                                                        <button class="btn btn-white btn-info btn-bold" name="btn-editar" type="submit">
                                                            <i class="ace-icon fa glyphicon-pencil bigger-80 blue"></i>
                                                            <input type="hidden" name="grupo_id" value="<?php echo $valor[$id]; ?>">
                                                            Editar
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">

                                                        <button class="btn btn-white btn-info btn-bold" name="btn-inativar" type="submit">
                                                            <i class="ace-icon fa fa-ban bigger-80 blue"></i>
                                                            <input type="hidden" name="grupo_id" value="<?php echo $valor[$id]; ?>">
                                                            Excluir
                                                        </button>

                                                    </div>
                                                </td>
                                            </tr>
                                        </form>
                                        <?php
                                        $id++;
                                    }
                                    ?>
                                    </tbody>
                                </table>

                            </div><!-- /.span -->
                        </div><!-- /.row -->


                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<?php
require_once '../pagina/footer.php';
?>