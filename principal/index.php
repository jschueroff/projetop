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
                <li class="active">Principal</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">
            <?php
            require_once 'principal_config.php';
            ?>

            <?php
            echo '<pre>';
            

            $valor = 100.19999999; //Para um resultado correto deve-se considerar o limite de 11 casas após a vírgula na dízima) 
            echo $valor."\n";
            $valor = intval(strval($valor * 100)) / 100;
            echo $valor; //Exibe "100.19" (String)
            ?>
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<?php
require_once '../pagina/footer.php';
?>