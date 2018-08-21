<?php
require_once 'tes_config.php';
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
                <li class="active">Tipo E/S</li>
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
                                    <input type="text" id="tes_pesquisa" name="tes_pesquisa" class="col-xs-6" placeholder="DESCRIÇÃO"/>
                                    <button class="btn btn-sm btn-primary" name="btn-pesquisar" type="submit">
                                        <i class="ace-icon fa fa-filter bigger-100 green"></i>
                                        Pesquisar
                                    </button>
                                </div>                            
                            </form>
                            <p>

                                <button type="button" class="btn btn-sm btn-success" 
                                        data-toggle="modal" data-target="#novotes" 
                                        >Novo</button>
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <table id="simple-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="hidden-480">TES</th>
                                            <th class="hidden-480">Tipo</th>
                                            <th class="hidden-480">CF.</th>
                                            <th class="hidden-480">ICMS</th>
                                            <th class="hidden-480">IPI</th>
                                            <th class="hidden-480">PIS/CONFIS</th>
                                            <th class="hidden-480">CFOP</th>
                                            <th class="hidden-480 center" colspan="2" >Configurar</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $id = 1;
                                        while ($row = $stmt_tes->fetch(PDO::FETCH_ASSOC)) {
                                            $valor[$id] = $row['tes_id'];
                                            ?>
                                        <form method="post" id="login-form">
                                            <tr>
                                                <td><?php echo $row['tes_id']; ?></td>
                                                <td class="hidden-480"><?php echo $row['tes_descricao']; ?></td>


                                                <td class="hidden-480"><?php
                                                    if ($row['tes_tipo'] == 0) {
                                                        echo "E";
                                                    }
                                                    if ($row['tes_tipo'] == 1) {
                                                        echo "S";
                                                    }
                                                    ?>
                                                </td>


                                                <td class="hidden-480"><?php
                                                    if ($row['tes_consumidor_final'] == 1) {
                                                        echo "S";
                                                    } else {
                                                        echo "N";
                                                    }
                                                    ?>

                                                </td>
                                                <td class="hidden-480"><?php
                                                    if ($row['tes_icms'] == 1) {
                                                        echo "S";
                                                    } else {
                                                        echo "N";
                                                    }
                                                    ?></td>

                                                <td class="hidden-480"><?php
                                                    if ($row['tes_ipi'] == 1) {
                                                        echo "S";
                                                    } else {
                                                        echo "N";
                                                    }
                                                    ?></td>
                                                <td class="hidden-480">
                                                    <?php
                                                    if ($row['tes_pis_confis'] == 1) {
                                                        echo "S";
                                                    } else {
                                                        echo "N";
                                                    }
                                                    ?></td>

                                                <td class="hidden-480"><?php echo $row['tes_cfop']; ?></td>


                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">
                                                        <button class="btn btn-xs btn-warning" name="btn-editar" type="submit">
                                                            <i class="ace-icon fa glyphicon-pencil bigger-80 blue"></i>
                                                            <input type="hidden" name="tes_id" value="<?php echo $valor[$id]; ?>">
                                                            Editar
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="hidden-480" align="center">
                                                    <div class="form-group">
                                                        <?php
                                                        if ($row['tes_status'] == 1) {
                                                            ?>

                                                            <button class="btn btn-xs btn-danger" name="btn-inativar" type="submit">

                                                                <i class="ace-icon fa fa-ban bigger-80 blue"></i>

                                                                <input type="hidden" name="tes_id" value="<?php echo $valor[$id]; ?>">
                                                                Inativar
                                                            </button>
                                                            <?php
                                                        }
                                                        if ($row['tes_status'] == 0) {
                                                            ?>
                                                            <button class="btn btn-xs btn-inverse" name="btn-ativar" type="submit">
                                                                <i class="ace-icon fa fa-check bigger-80 blue"></i>
                                                                <input type="hidden" name="tes_id" value="<?php echo $valor[$id]; ?>">
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



<div class="modal fade" id="novotes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descrição</label>
                                <input type="text" id="tes_descricao" required=""  name="tes_descricao" class="form-control" />
                            </div> 
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tipo</label>
                                <select name="tes_tipo" class="form-control">
                                    <option value="0">0- ENTRADA</option>
                                    <option value="1">1- SAIDA</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Natureza</label>
                                <select name="tes_natureza" class="form-control">
                                    <option value="1">1- Normal</option>
                                    <option value="2">2- Devolução</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>CFOP</label>
                                <input type="text" id="tes_cfop" required=""  name="tes_cfop" class="form-control" />
                            </div> 
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Consumidor Final</label>
                                <select name="tes_consumidor_final" class="form-control">
                                    <option value="0">0 - NÃO</option>
                                    <option value="1">1 - SIM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Calcula ICMS</label>
                                <select name="tes_icms" class="form-control">
                                    <option value="0">0 - NÃO</option>
                                    <option value="1">1 - SIM</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Calcula IPI</label>
                                <select name="tes_ipi" class="form-control">
                                    <option value="0">0 - NÃO</option>
                                    <option value="1">1 - SIM</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Calcula PIS/CONFIS</label>
                                <select name="tes_pis_confis" class="form-control">
                                    <option value="0">0 - NÃO</option>
                                    <option value="1">1 - SIM</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Controla Estoque</label>
                                <select name="tes_estoque" class="form-control">
                                    <option value="0">0 - NÃO</option>
                                    <option value="1">1 - SIM</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-cadastro" class="btn btn-xs btn-success">Cadastrar</button>
                    </div>
                </form>
            </div>			  
        </div>
    </div>
</div>

<?php
require_once '../pagina/footer.php';
?>