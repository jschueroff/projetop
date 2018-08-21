<?php
require_once 'st_config.php';
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
                <li class="active">Situação Tributária</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">
            <?php
            require_once '../principal/principal_config.php';
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                         <legend>Situação Tributária</legend>
                        <div class="row">
                           
                            <form class="form-horizontal" method="post">                            
                                <div class="col-xs-7">
                                    <input type="text" id="ncm_id" name="st_pesquisa" class="col-xs-6" placeholder="Situação Tributária"/>
                                    <button class="btn btn-sm btn-primary" name="btn-pesquisar" type="submit">
                                        <i class="ace-icon fa fa-filter bigger-100 green"></i>
                                        Pesquisar
                                    </button>
                                </div>                            
                            </form>
                            <p>
                                <a href="st_cadastrar.php">
                                    <button class="btn btn-sm btn-success" name="btn-cadastrar" type="submit">
                                        <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                        Nova
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
                                            <th class="hidden-480">ST</th>

                                            <th class="hidden-480">UF Emi.</th>
                                            <th class="hidden-480"> Tipo</th>
                                            <th class="hidden-480">Status</th>
                                            <th class="hidden-480 center" colspan="2" >Configurar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $id = 1;
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $valor[$id] = $row['st_id'];
                                            ?>
                                        <form method="post" id="login-form">
                                            <tr>
                                                <td><?php echo $row['st_id']; ?></td>
                                                <td class="hidden-480"><?php echo $row['st_nome']; ?></td>

                                                <td class="hidden-480"><?php
                                                    echo $row['estado_sigla'];
                                                    ?>
                                                </td>
                                                <td class="hidden-480"><?php
                                                    if ($row['st_tipo'] == 0) {
                                                        echo "E";
                                                    }
                                                    if ($row['st_tipo'] == 1) {
                                                        echo "S";
                                                    }
                                                    ?>
                                                </td>

                                                <td class="hidden-480">
                                                    <?php
                                                    if ($row['st_status'] == 1) {
                                                        echo "A";
                                                    } else {
                                                        echo "I";
                                                    }
                                                    ?></td>


                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">
                                                        <button class="btn btn-xs btn-warning" name="btn-editar" type="submit">
                                                            <i class="ace-icon fa glyphicon-pencil bigger-80 blue"></i>
                                                            <input type="hidden" name="st_id" value="<?php echo $valor[$id]; ?>">
                                                            Editar
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">
                                                        <?php
                                                        if ($row['st_status'] == 1) {
                                                            ?>

                                                            <button class="btn btn-xs btn-danger" name="btn-inativar" type="submit">
                                                                <i class="ace-icon fa fa-ban bigger-80 blue"></i>

                                                                <input type="hidden" name="st_id" value="<?php echo $valor[$id]; ?>">
                                                                Inativar
                                                            </button>
                                                            <?php
                                                        }
                                                         if ($row['st_status'] == 0) {
                                                            ?>
                                                            <button class="btn btn-xs btn-inverse" name="btn-ativar" type="submit">
                                                                <i class="ace-icon fa fa-check bigger-80 blue"></i>
                                                                <input type="hidden" name="st_id" value="<?php echo $valor[$id]; ?>">
                                                                Ativar
                                                            </button>

                                                            <?php
                                                        }
                                                        ?>
                                                        


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



                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<?php
require_once '../pagina/footer.php';
?>