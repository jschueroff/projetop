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
                <li class="active">Empresa</li>
            </ul><!-- /.breadcrumb -->

            <div class="nav-search" id="nav-search">
                <form class="form-search">
                    <span class="input-icon">
                        <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                    </span>
                </form>
            </div><!-- /.nav-search -->
        </div>

        <div class="page-content">
            <?php
            require_once '../principal/principal_config.php';
            ?>

            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="row">
                        <form class="form-horizontal form-control-sm" method="post">                          
                                <div class="col-sm-10">
                                    <input type="text" id="empresa_pesquisa" name="empresa_pesquisa" class="col-xs-3 col-sm-9" placeholder="Nome ou E-mail"/>
                                    <button class="btn btn-sm btn-primary" name="btn-pesquisar" type="submit">
                                        <i class="ace-icon fa fa-filter bigger-120 blue"></i>
                                        Pesquisar
                                    </button>
                                </div>
                            
                        </form>
                        <p>
                            <a href="empresa_cadastrar.php">
                                <button class="btn btn-sm btn-success" name="btn-cadastrar" type="submit">
                                    <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                    Novo
                                </button>
                            </a>
                        </p>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <table id="simple-table" class="table table-striped table-responsive table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="hidden-480">Empresa</th>
                                            <th class="hidden-480">Email</th>
                                            <th class="hidden-480">Telefone</th>
                                            <th class="hidden-480 center" colspan="2" >Configurar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $id = 1;
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $valor[$id] = $row['empresa_id'];
                                            ?>
                                        <form method="post" id="login-form">
                                            <tr>
                                                <td><?php echo $row['empresa_id']; ?></td>
                                                <td class="hidden-480"><?php echo $row['empresa_nome']; ?></td>
                                                <td class="hidden-480"><?php echo $row['empresa_email']; ?></td>
                                                <td class="hidden-480"><?php echo $row['empresa_telefone']; ?></td>

                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">
                                                        <button class="btn btn-sm btn-warning" name="btn-editar" type="submit">
                                                            <i class="ace-icon fa glyphicon-pencil bigger-80 blue"></i>
                                                            <input type="hidden" name="empresa_id" value="<?php echo $valor[$id]; ?>">
                                                            Editar
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">

                                                        <button class="btn btn-sm btn-danger" name="btn-inativar" type="submit">
                                                            <i class="ace-icon fa fa-ban bigger-80 blue"></i>
                                                            <input type="hidden" name="empresa_id" value="<?php echo $valor[$id]; ?>">
                                                            Inativar
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
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->

    <?php
    require_once '../pagina/footer.php';
    ?>