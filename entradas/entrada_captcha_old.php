<?php
// Autoload
require './vendor/autoload.php';

// Namespace
use DownloadNFeSefaz\DownloadNFeSefaz;

// Iniciando a classe
$downloadXml = new DownloadNFeSefaz();

// Capturando o captcha em formato base64 (png)
$captcha = $downloadXml->getDownloadXmlCaptcha();

// Exibindo em html
?>



<?php
require_once("../class/session.php");
require_once("../class/class.user.php");

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
                    <a href="#">Home</a>
                </li>
                <li class="active">Dashboard</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">
            <?php
            require_once '../principal/principal_config.php';
            echo "<img src=\"$captcha\">";
            ?>

            <form action="entrada_down_xml.php" method="post" >

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Repita Captcha</label>
                            <input type="text" name="captcha" placeholder="captcha" class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Chave</label>
                            <input type="text" name="chave" placeholder="chave" value="<?php echo $_GET['chave'] ?>" class="form-control">
                        </div>
                    </div>
                </div>


                <!--                <button type="submit" name="Down">Down</button>-->
                <div class="modal-footer">
                  

                    <button type="submit" name="btn-downloald" class="btn btn-xs btn-success">Confirmar</button>
                </div>

        </div>
        </form>
    </div><!-- /.page-content -->
</div>
</div><!-- /.main-content -->

<?php
require_once '../pagina/footer.php';
?>
