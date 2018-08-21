<?php
// Aqui começa outro código

require_once("../class/session.php");
require_once("../class/class.user.php");
require_once ("notas_config.php");
$auth_user = new USER();

$user_id = $_SESSION['user_session'];
$stmt = $auth_user->runQuery("SELECT * FROM funcionarios WHERE funcionario_id=:user_id");
$stmt->execute(array(":user_id" => $user_id));
$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

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
                <li class="active">Status NF-e</li>
            </ul><!-- /.breadcrumb -->


        </div>

        <div class="page-content">
            <?php
            require_once '../principal/principal_config.php';

            $aResposta = array();
            $siglaUF = 'SC';
            $tpAmb = '2';
            $retorno = $nfe->sefazStatus($siglaUF, $tpAmb, $aResposta);

            $timestamp = $nfe->getTimestampCert();
            ?>

            <div class="row">
                <div class="col-xs-12">
                    <form  method="post"> 
                        <fieldset>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="widget-box">
                                        <div class="widget-header widget-header-flat">
                                            <h4 class="widget-title smaller">
                                               Certificado/Status NF-e
                                            </h4>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class='row'>
                                                            <div class='col-sm-4'>    
                                                                <div class='form-group'>
                                                                    <label>Tipo</label>
                                                                    <input type="text" class="form-control" value="<?php
                                                                    if ($tpAmb == 2) {
                                                                        echo 'HOMOLOGAÇÂO';
                                                                    }
                                                                    if ($tpAmb == 1) {
                                                                        echo 'PRODUÇÂO';
                                                                    }
                                                                    ?>" disabled="">                            
                                                                    <!--                                                                    <form role="form">
                                                                    
                                                                    
                                                                    
                                                                                                                                            <div class="form-group">
                                                                                                                                                <label >Cod. Estado</label>
                                                                                                                                                <input type="text" class="form-control" value="<?php echo $aResposta['cUF']; ?>" disabled="">
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group">
                                                                                                                                                <label >Status</label>
                                                                                                                                                <input type="text" class="form-control" value="<?php echo $aResposta['cStat']; ?>" disabled="">
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group">
                                                                                                                                                <label >Motivo</label>
                                                                                                                                                <input type="text" class="form-control" value="<?php echo $aResposta['xMotivo']; ?>" disabled="">
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group">
                                                                                                                                                <label >Versão</label>
                                                                                                                                                <input type="text" class="form-control" value="<?php echo $aResposta['versao']; ?>" disabled="">
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group">
                                                                                                                                                <label >Data/Hora</label>
                                                                                                                                                <input type="text" class="form-control" value="<?php echo $aResposta['dhRecbto']; ?>" disabled="">
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group">
                                                                                                                                                <label >Ambiente</label>
                                                                                                                                                <input type="text" class="form-control" value="<?php echo $aResposta['tpAmb']; ?>" disabled="">
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group">
                                                                                                                                                <label >Versão Aplic.</label>
                                                                                                                                                <input type="text" class="form-control" value="<?php echo $aResposta['verAplic']; ?>" disabled="">
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group">
                                                                                                                                                <label >TMed</label>
                                                                                                                                                <input type="text" class="form-control" value="<?php echo $aResposta['tMed']; ?>" disabled="">
                                                                                                                                            </div>
                                                                                                                                            <div class="form-group">
                                                                                                                                                <label >Observação</label>
                                                                                                                                                <input type="text" class="form-control" value="<?php echo $aResposta['xObs']; ?>" disabled="">
                                                                                                                                            </div>
                                                                    
                                                                                                                                        </form>-->
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Cód. Estado</label>
                                                                    <input type="text" class="form-control" value="<?php echo $aResposta['cUF']; ?>" disabled="">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Status</label>
                                                                    <input type="text" class="form-control" value="<?php echo $aResposta['cStat']; ?>" disabled="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Motivo</label>
                                                                    <input type="text" class="form-control" value="<?php echo $aResposta['xMotivo']; ?>" disabled="">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Versão</label>
                                                                    <input type="text" class="form-control" value="<?php echo $aResposta['versao']; ?>" disabled="">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Data/Hora</label>
                                                                    <input type="text" class="form-control" value="<?php echo $aResposta['dhRecbto']; ?>" disabled="">
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Ambiente</label>
                                                                    <input type="text" class="form-control" value="<?php echo $aResposta['tpAmb']; ?>" disabled="">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Versão Aplic</label>
                                                                    <input type="text" class="form-control" value="<?php echo $aResposta['verAplic']; ?>" disabled="">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label >TMed</label>
                                                                    <input type="text" class="form-control" value="<?php echo $aResposta['tMed']; ?>" disabled="">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label >Observação</label>
                                                                    <input type="text" class="form-control" value="<?php echo $aResposta['xObs']; ?>" disabled="">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-group">
                                                                        <label >Validade Certificado</label>
                                                                        <input type="text" class="form-control" value="<?php echo date('d/m/Y H:i:s', $timestamp); ?>" disabled="">

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
                    </form>
                </div>
            </div>
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->


<?php
require_once '../pagina/footer.php';
?>
