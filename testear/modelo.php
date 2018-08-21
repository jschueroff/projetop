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
<link href="../assets/css/minhacss.css" rel="stylesheet">
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

            <a data-toggle="modal" href="#myModal" class="btn btn-primary">Launch modal</a>

            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Modal 1</h4>
                        </div><div class="container"></div>
                        <div class="modal-body">
                            Content for the dialog / modal goes here.
                            <br>
                            <br>
                            <br>
                            <p>more content</p>
                            <br>
                            <br>
                            <br>
                            <a data-toggle="modal" href="#myModal2" class="btn btn-primary">Launch modal</a>
                        </div>
                        <div class="modal-footer">
                            <a href="#" data-dismiss="modal" class="btn">Close</a>
                            <a href="#" class="btn btn-primary">Save changes</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="myModal2">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Modal 2</h4>
                        </div><div class="container"></div>
                        <div class="modal-body">
                            Content for the dialog / modal goes here.
                            <br>
                            <br>
                            <p>come content</p>
                            <br>
                            <br>
                            <br>
                            <a data-toggle="modal" href="#myModal3" class="btn btn-primary">Launch modal</a>
                        </div>
                        <div class="modal-footer">
                            <a href="#" data-dismiss="modal" class="btn">Close</a>
                            <a href="#" class="btn btn-primary">Save changes</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="myModal3">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Modal 3</h4>
                        </div><div class="container"></div>
                        <div class="modal-body">
                            Content for the dialog / modal goes here.
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <a data-toggle="modal" href="#myModal4" class="btn btn-primary">Launch modal</a>
                        </div>
                        <div class="modal-footer">
                            <a href="#" data-dismiss="modal" class="btn">Close</a>
                            <a href="#" class="btn btn-primary">Save changes</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="myModal4" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Modal 4</h4>
                        </div><div class="container"></div>
                        <div class="modal-body">
                            Content for the dialog / modal goes here.
                        </div>
                        <div class="modal-footer">
                            <a href="#" data-dismiss="modal" class="btn">Close</a>
                            <a href="#" class="btn btn-primary">Save changes</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            echo '<pre>';


            $valor = 100.19999999; //Para um resultado correto deve-se considerar o limite de 11 casas após a vírgula na dízima) 
            echo $valor . "\n";
            $valor = intval(strval($valor * 100)) / 100;
            echo $valor; //Exibe "100.19" (String)
            ?>
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


<script type='text/javascript' src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>




<!-- JavaScript jQuery code from Bootply.com editor -->

<script type='text/javascript'>

        $(document).ready(function () {

            $('#openBtn').click(function () {
                $('#myModal').modal({show: true})
            });


            $('.modal').on('hidden.bs.modal', function (event) {
                $(this).removeClass('fv-modal-stack');
                $('body').data('fv_open_modals', $('body').data('fv_open_modals') - 1);
            });


            $('.modal').on('shown.bs.modal', function (event) {

                // keep track of the number of open modals

                if (typeof ($('body').data('fv_open_modals')) == 'undefined')
                {
                    $('body').data('fv_open_modals', 0);
                }


                // if the z-index of this modal has been set, ignore.

                if ($(this).hasClass('fv-modal-stack'))
                {
                    return;
                }

                $(this).addClass('fv-modal-stack');

                $('body').data('fv_open_modals', $('body').data('fv_open_modals') + 1);

                $(this).css('z-index', 1040 + (10 * $('body').data('fv_open_modals')));

                $('.modal-backdrop').not('.fv-modal-stack')
                        .css('z-index', 1039 + (10 * $('body').data('fv_open_modals')));


                $('.modal-backdrop').not('fv-modal-stack')
                        .addClass('fv-modal-stack');

            });


        });

</script>

<?php
require_once '../pagina/footer.php';
?>














</body>
</html>
