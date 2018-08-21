<?php
// Autoload
require './vendor/autoload.php';

require_once("../class/session.php");
require_once("../class/class.user.php");

// Namespace
use DownloadNFeSefaz\DownloadNFeSefaz;

// Iniciando a classe
$downloadXml = new DownloadNFeSefaz();

// Capturando o captcha em formato base64 (png)
$captcha = $downloadXml->getDownloadXmlCaptcha();


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
            ?>

            <?php
            echo '<pre>';
            ?>
            <form action="download_xml1.php?status=1" method="GET">
                <?php
                echo "<img src=\"$captcha\">";
                ?>
                <input name="captcha" type="text"><br>
                <input name="chave"  value="<?php echo $_GET['chave'] ?>" size="60"><br>
                <input name="status"  type="hidden" value="<?php echo "1" ?>" size="60"><br>
<!--                <input name="status" type="hidden" value="1">-->
                <button name="button" value="" type="submit">Acessar</button>

            </form>

        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<?php
require_once '../pagina/footer.php';
?>



