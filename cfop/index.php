<?php
require_once 'cfop_config.php';
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
                <li class="active">CFOP</li>
            </ul><!-- /.breadcrumb -->


        </div>

        <div class="page-content">
            <?php
            include_once '../principal/principal_config.php';
            ?>


            <div class="row">
                <div class="col-xs-12">

                    <fieldset>


                        <div class='row'>
                            <form  method="post"> 
                                <div class='col-sm-6'>    
                                    <div class='form-group'>
                                        <input type="text" name="cfop_pesquisa" id="cfop_pesquisa" class="form-control" placeholder="CFOP ou Descrição" autofocus=""/>                                 
                                    </div>
                                </div>
                                <div class="col-sm-2">

                                    <button class="btn btn-sm btn-info2" name="btn-pesquisar" type="submit">
                                        <i class="ace-icon fa fa-filter bigger-100 green"></i>
                                        Pesquisar
                                    </button>
                                </div>
                            </form>
                            <a href="cfop_cadastrar.php">
                                <button class="btn btn-sm btn-success" name="btn-cadastrar" type="submit">
                                    <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                    Novo
                                </button>
                            </a>


                        </div>
                    </fieldset>

                </div>
            </div>


            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12">
                                <table id="simple-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="hidden-480">CFOP</th>
                                            <th class="hidden-480">Descriçao</th>
                                            <th class="hidden-480 center" colspan="2" >Configurar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $id = 1;
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $valor[$id] = $row['cfop_id'];
                                            ?>
                                        <form method="post" id="login-form">
                                            <tr>
                                                <td><?php echo $row['cfop_id']; ?></td>
                                                <td class="hidden-480"><?php echo $row['cfop_codigo']; ?></td>

                                                <td class="hidden-480"><?php echo $row['cfop_descricao']; ?></td>

                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">
                                                        <button class="btn btn-xs btn-warning" name="btn-editar" type="submit">
                                                            <i class="ace-icon fa glyphicon-pencil bigger-80 blue"></i>
                                                            <input type="hidden" name="cfop_id" value="<?php echo $valor[$id]; ?>">
                                                            Editar
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">

                                                        <button class="btn btn-xs btn-danger" name="btn-inativar" type="submit">
                                                            <i class="ace-icon fa fa-ban bigger-80 blue"></i>
                                                            <input type="hidden" name="cfop_id" value="<?php echo $valor[$id]; ?>">
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
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->

    <?php
    require_once '../pagina/footer.php';
    ?>