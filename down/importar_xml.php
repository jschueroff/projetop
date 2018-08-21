
<?php
require_once 'down_config.php';
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
                <li class="active">Entradas por XML</li>
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
                                            Importar XML
                                        </h4>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="row">
                                                <div id="error">

                                                </div>
                                                <div class="col-xs-12">
                                                    <div class='row'>
<!--                                                        <form  method="post">-->
                                                            <form enctype="multipart/form-data" method="POST">
                                                            <div class='col-sm-8'>    
                                                                <div class='form-group'>
                                                                    <input type="file" name="file" class="form-control"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">

                                                                    <button class="btn btn-primary btn-sm" name="submit" type="submit">
                                                                        <i class="ace-icon fa fa-filter bigger-100 green"></i>
                                                                        Importar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
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
        </div>
    </div>
</div>
<?php
require_once '../pagina/footer.php';
?>