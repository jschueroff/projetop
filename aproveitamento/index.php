<?php
require_once 'aproveitamento_config.php';
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
                <li class="active">Aproveitamento ICMS</li>
            </ul><!-- /.breadcrumb -->

        </div>

        <div class="page-content">

            <?php
            include '../principal/principal_config.php';
            ?>


            <div class="row">
                <div class="col-xs-12">

                    <fieldset>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="widget-box">
                                    <div class="widget-header widget-header-flat">
                                        <h4 class="widget-title smaller">
                                            Pesquisar
                                        </h4>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class='row'>
                                                        <form  method="post">
                                                            <div class='col-sm-6'>    
                                                                <div class='form-group'>
                                                                    <input type="text"  name="aproveitamento_pesquisa" class="form-control" placeholder="Mes/Ano"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">

                                                                    <button class="btn btn-primary btn-sm" name="btn-pesquisar" type="submit">
                                                                        <i class="ace-icon fa fa-filter bigger-100 green"></i>
                                                                        Pesquisar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <a href="aproveitamento_cadastrar.php">
                                                                    <button class="btn btn-sm btn-success" name="btn-cadastrar" type="submit">
                                                                        <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                                                        Novo
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>





            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">

                        <div class="row">
                            <div class="col-xs-12">
                                <table  class="table table-responsive table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="hidden-480">Aliquota</th>
                                            <th class="hidden-480">Mes</th>
                                            <th class="hidden-480">Ano</th>
                                       
                                            <th class="hidden-480 center" colspan="2" >Configurar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $id = 1;
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $valor[$id] = $row['aproveitamento_id'];
                                            ?>
                                        <form method="post" id="login-form">
                                            <tr>
                                                <td><?php echo $row['aproveitamento_id']; ?></td>
                                                <td class="hidden-480"><?php echo $row['aproveitamento_aliquota']; ?></td>
                                                <td class="hidden-480"><?php echo $row['aproveitamento_mes']; ?></td>
                                                <td class="hidden-480"><?php echo $row['aproveitamento_ano']; ?></td>

                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">
<!--                                                        <button class="btn btn-default btn-xs" name="btn-percentual" type="submit">
                                                            <input type="hidden" name="forma_pagamento_id" value="<?php echo $valor[$id]; ?>">
                                                            Percentual
                                                        </button>-->
                                                        <button class="btn btn-warning btn-xs" name="btn-editar" type="submit">
                                                            <i class="ace-icon fa glyphicon-pencil bigger-80"></i>
                                                            <input type="hidden" name="aproveitamento_id" value="<?php echo $valor[$id]; ?>">
                                                            Editar
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
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->

    <?php
    require_once '../pagina/footer.php';
    ?>