<?php
//CLASSE DE SESSAO E DO USUARIO DO SISTEMA
//require_once("../class/session.php");
require_once("../class/class.user.php");
require_once 'entradas_config.php';

// CLASSES PARA O DOWNLOALD DA NFE.
require './vendor/autoload.php';

// Namespace
use DownloadNFeSefaz\DownloadNFeSefaz;

if ($_GET['status'] == 1) {
/// Iniciando a classe
$downloadXml = new DownloadNFeSefaz();

// CNPJ do certificado digital
$CNPJ = '11169963000130';

// Pasta onde se encontram os arquivos .pem
// {CNPJ}_priKEY.pem
// {CNPJ}_certKEY.pem
// {CNPJ}_pubKEY.pem
//$path_cert = '\pasta_do_certificado\\';
$path_cert ='C:/xampp/htdocs/nota/certs/';

// Senha do certificado
$senha_cert = '2010';

// Sabendo o captcha é só fazer o download do XML informando o mesmo e a chave de acesso da NF-e
//$captcha = '{captcha}';
//$captcha = 'PH38jp';
$captcha = $_GET['captcha'];


// Chave de acesso
//$chave_acesso = '42170117524772000125550010000001151805901062';
$chave_acesso = $_GET['chave'];

$xml = $downloadXml->downloadXmlSefaz($captcha, $chave_acesso, $CNPJ, $path_cert, $senha_cert);

echo $xml;

//$xml = simplexml_load_string($xml);
}

if ($_GET['status'] == 0) {
    $chave_texto = $_GET['chave_texto'];

    $arquivo = "arquivos/" . $chave_texto . ".xml";

    if (file_exists($arquivo)) {
// $arquivo = $arquivo;
        $xml = simplexml_load_file($arquivo);
// imprime os atributos do objeto criado

        if (empty($xml->protNFe->infProt->nProt)) {
            echo "<h4>Arquivo sem dados de autorização!</h4>";
            exit;
        }
        $chave = $xml->NFe->infNFe->attributes()->Id;
        $chave = strtr(strtoupper($chave), array("NFE" => NULL));
    }
}


// Iniciando a classe
//$downloadXml = new DownloadNFeSefaz();

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
                <li class="active">Carregar dados XML</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">
<?php
require_once '../principal/principal_config.php';
?>
            <div class="row">
                <div class="col-xs-12">
                    <form  method="post"> 
                        <fieldset>
                            <!--                            ******** DADOS DA NFE *******-->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="widget-box">
                                        <div class="widget-header widget-header-flat">
                                            <h4 class="widget-title smaller">
                                                Dados da NF-e

<?php
$emit_CPF = $xml->NFe->infNFe->emit->CPF;
$emit_CNPJ = $xml->NFe->infNFe->emit->CNPJ;
$chave = $xml->NFe->infNFe->attributes()->Id;
$chave = strtr(strtoupper($chave), array("NFE" => NULL));
//===============================================================================================================================================		
//<ide>
$cUF = $xml->NFe->infNFe->ide->cUF;          //<cUF>41</cUF>  C�digo do Estado do Fator gerador
$cNF = $xml->NFe->infNFe->ide->cNF;            //<cNF>21284519</cNF>   C�digo n�mero da nfe
$natOp = $xml->NFe->infNFe->ide->natOp;         //<natOp>V E N D A</natOp>  Resumo da Natureza de opera��o
$indPag = $xml->NFe->infNFe->ide->indPag;      //<indPag>2</indPag> 0 � pagamento � vista; 1 � pagamento � prazo; 2 - outros
$mod = $xml->NFe->infNFe->ide->mod;            //<mod>55</mod> Modelo do documento Fiscal
$serie = $xml->NFe->infNFe->ide->serie;        //<serie>2</serie> 
$nNF = $xml->NFe->infNFe->ide->nNF;           //<nNF>19685</nNF> N�mero da Nota Fiscal
$dEmi = $xml->NFe->infNFe->ide->dhEmi;          //<dEmi>2011-09-06</dEmi> Data de emiss�o da Nota Fiscal
//$dEmi = explode('-', $dEmi);
//  $dEmi = $dEmi[2] . "/" . $dEmi[1] . "/" . $dEmi[0];
$dSaiEnt = $xml->NFe->infNFe->ide->dhSaiEnt;    //<dSaiEnt>2011-09-06</dSaiEnt> Data de entrada ou saida da Nota Fiscal
//$dSaiEnt = explode('-', $dSaiEnt);
//  $dSaiEnt = $dSaiEnt[2] . "/" . $dSaiEnt[1] . "/" . $dSaiEnt[0];
$tpNF = $xml->NFe->infNFe->ide->tpNF;         //<tpNF>1</tpNF>  0-entrada / 1-saida
$cMunFG = $xml->NFe->infNFe->ide->cMunFG;     //<cMunFG>4106407</cMunFG> C�digo do municipio Tabela do IBGE
$tpImp = $xml->NFe->infNFe->ide->tpImp;       //<tpImp>1</tpImp> 
$tpEmis = $xml->NFe->infNFe->ide->tpEmis;     //<tpEmis>1</tpEmis>
$cDV = $xml->NFe->infNFe->ide->cDV;           //<cDV>0</cDV>
$tpAmb = $xml->NFe->infNFe->ide->tpAmb;       //<tpAmb>1</tpAmb>

$finNFe = $xml->NFe->infNFe->ide->finNFe;     //<finNFe>1</finNFe>
$indFinal = $xml->NFe->infNFe->ide->indFinal;     //<finNFe>1</finNFe>
$indPres = $xml->NFe->infNFe->ide->indPres;     //<finNFe>1</finNFe>
$procEmi = $xml->NFe->infNFe->ide->procEmi;   //<procEmi>0</procEmi>
$verProc = $xml->NFe->infNFe->ide->verProc;   //<verProc>2.0.0</verProc>
//</ide>
$xMotivo = $xml->protNFe->infProt->xMotivo;
$nProt = $xml->protNFe->infProt->nProt;

$stmt_busca_cnpj = $auth_user->runQuery("SELECT * FROM fornecedor WHERE fornecedor_cnpj ={$emit_CNPJ}");
$stmt_busca_cnpj->execute();
$achou_cnpj = $stmt_busca_cnpj->fetch(PDO::FETCH_ASSOC);

$stmt_nfe_sistema = $auth_user->runQuery("SELECT * FROM entrada WHERE entrada_numero ={$nNF} AND "
        . "entrada_chave ={$chave}");
$stmt_nfe_sistema->execute();
$nfe_sis = $stmt_nfe_sistema->fetch(PDO::FETCH_ASSOC);

if (!$achou_cnpj) {
    ?>
                                                    <form  method="post">
                                                        <button class="btn btn-primary btn-sm" name="btn-importe-fornecedor" type="submit">

                                                            Importar For./NF-e.
                                                        </button>
                                                    </form>
                                                    <?php
                                                }

                                                if ($achou_cnpj) {
                                                    if (!$nfe_sis) {
                                                        ?>
                                                        <button class="btn btn-default btn-sm" name="btn-importe-nfe" type="submit">

                                                            Importar NF-e

                                                        </button>
                                                        <?php
                                                    }
                                                }

                                                if (empty($xml->protNFe->infProt->nProt)) {
                                                    echo "<h4>Arquivo sem dados de autorização!</h4>";
                                                    exit;
                                                }
                                                ?>


                                            </h4>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class='row'>
                                                            <input type="hidden" name="cUF" value="<?php echo $cUF; ?>">
                                                            <input type="hidden" name="cNF" value="<?php echo $cNF; ?>">
                                                            <input type="hidden" name="natOp" value="<?php echo $natOp; ?>">
                                                            <input type="hidden" name="indPag" value="<?php echo $indPag; ?>">
                                                            <input type="hidden" name="mod" value="<?php echo $mod; ?>">
                                                            <div class='col-sm-5'>    
                                                                <div class='form-group'>
                                                                    <label>Chave</label>
                                                                    <input type="text" class="form-control" disabled=""  value="<?php echo $chave ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="chave"  value="<?php echo $chave ?>"/>                                 

                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >Protocolo</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $nProt ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="nProt"  value="<?php echo $nProt ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >Nota</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $nNF ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="nNF" value="<?php echo $nNF ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >Série</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $serie ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="serie" value="<?php echo $serie ?>"/>                                 
                                                                </div>
                                                            </div> 
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >tpNF</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $tpNF ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="tpNF" value="<?php echo $tpNF ?>"/>  

                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >Dt. Emi.</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $dEmi ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dEmi" value="<?php echo $dEmi ?>"/>                                 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >Dt. Sai.</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $dSaiEnt ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dSaiEnt" value="<?php echo $dSaiEnt ?>"/>                                 
                                                                </div>
                                                            </div>

                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >cMunFG</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $cMunFG ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="cMunFG" value="<?php echo $cMunFG ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >tpImp</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $tpImp ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="tpImp" value="<?php echo $tpImp ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >tpEmis</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $tpEmis ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="tpEmis" value="<?php echo $tpEmis ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >cDV</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $cDV ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="cDV" value="<?php echo $cDV ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >tpAmb</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $tpAmb ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="tpAmb" value="<?php echo $tpAmb ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >finNFe</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $finNFe ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="finNFe" value="<?php echo $finNFe ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >indFinal</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $indFinal ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="indFinal" value="<?php echo $indFinal ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >indPres</label>
                                                                    <input type="text" class="form-control" disabled value="<?php echo $indPres ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="indPres" value="<?php echo $indPres ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >procEmi</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $procEmi ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="procEmi" value="<?php echo $procEmi ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >verProc</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $verProc ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="verProc" value="<?php echo $verProc ?>"/>                                 
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
                            <!--                           ******* DADOS DA EMITENTE ******** -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="widget-box">
                                        <div class="widget-header widget-header-flat">
                                            <h4 class="widget-title smaller">
                                                Dados Emitente
                                            </h4>

                                        </div>

<?php
//===============================================================================================================================================	
// <emit> Emitente

$emit_xNome = $xml->NFe->infNFe->emit->xNome;
$emit_xFant = $xml->NFe->infNFe->emit->xFant;
//<enderEmit>
$emit_xLgr = $xml->NFe->infNFe->emit->enderEmit->xLgr;  //<xLgr>AV. AGOSTINHO DUCCI , 409</xLgr>
$emit_nro = $xml->NFe->infNFe->emit->enderEmit->nro;    //<nro>.</nro>
$emit_xCpl = $xml->NFe->infNFe->emit->enderEmit->xCpl;    //<nro>.</nro>
$emit_xBairro = $xml->NFe->infNFe->emit->enderEmit->xBairro; //<xBairro>PARQUE INDUSTRIAL</xBairro>
$emit_cMun = $xml->NFe->infNFe->emit->enderEmit->cMun;   //<cMun>4106407</cMun>
$emit_xMun = $xml->NFe->infNFe->emit->enderEmit->xMun;   //<xMun>CORNELIO PROCOPIO</xMun>
$emit_UF = $xml->NFe->infNFe->emit->enderEmit->UF;    //<UF>PR</UF>
$emit_CEP = $xml->NFe->infNFe->emit->enderEmit->CEP;   //<CEP>86300000</CEP>
$emit_cPais = $xml->NFe->infNFe->emit->enderEmit->cPais;  //<cPais>1058</cPais>
$emit_xPais = $xml->NFe->infNFe->emit->enderEmit->xPais;  //<xPais>BRASIL</xPais>
$emit_fone = $xml->NFe->infNFe->emit->enderEmit->fone;   //<fone>4335242165</fone>
//</enderEmit>
$emit_IE = $xml->NFe->infNFe->emit->IE;        //<IE>9014134104</IE>
$emit_IEST = $xml->NFe->infNFe->emit->IEST;        //<IE>9014134104</IE>
$emit_IM = $xml->NFe->infNFe->emit->IM;        //<IM>8636</IM>
$emit_CNAE = $xml->NFe->infNFe->emit->CNAE;       //<CNAE>4789099</CNAE>
$emit_CRT = $xml->NFe->infNFe->emit->CRT; //<CRT>3</CRT>
//
//
//</emit>
?>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class='row'>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label>CNPJ</label>
                                                                    <input type="text" class="form-control" name="fornecedor_cnpj" disabled="" value="<?php echo $emit_CNPJ ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_cnpj"  value="<?php echo $emit_CNPJ ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label>CPF</label>
                                                                    <input type="text" class="form-control" name="fornecedor_cpf" disabled value="<?php echo $emit_CPF ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_cpf"  value="<?php echo $emit_CPF ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-6'>    
                                                                <div class='form-group'>
                                                                    <label >Nome</label>
                                                                    <input type="text" class="form-control" name="fornecedor_nome" disabled value="<?php echo $emit_xNome ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_nome" value="<?php echo $emit_xNome ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >Fantasia</label>
                                                                    <input type="text" class="form-control" name="fornecedor_fantasia" disabled="" value="<?php echo $emit_xFant ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_fantasia"  value="<?php echo $emit_xFant ?>"/>                                 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class='col-sm-4'>    
                                                                <div class='form-group'>
                                                                    <label >Endereco</label>
                                                                    <input type="text" class="form-control" disabled="" name="fornecedor_logradouro" value="<?php echo $emit_xLgr ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_logradouro"  value="<?php echo $emit_xLgr ?>"/>                                 
                                                                </div>
                                                            </div> <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >Numero</label>
                                                                    <input type="text" class="form-control" disabled="" name="fornecedor_numero" value="<?php echo $emit_nro ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_numero" value="<?php echo $emit_nro ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >Compl.</label>
                                                                    <input type="text" class="form-control" disabled="" name="fornecedor_complemento"  value="<?php echo $emit_xCpl ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_complemento" value="<?php echo $emit_xCpl ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-3'>    
                                                                <div class='form-group'>
                                                                    <label >Bairro</label>
                                                                    <input type="text" class="form-control" disabled="" name="fornecedor_bairro"  value="<?php echo $emit_xBairro ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_bairro" value="<?php echo $emit_xBairro ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >cMun</label>
                                                                    <input type="text" class="form-control" disabled="" name="fornecedor_cod_municipio" value="<?php echo $emit_cMun ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_cod_municipio" value="<?php echo $emit_cMun ?>"/>                                 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">

                                                            <div class='col-sm-3'>    
                                                                <div class='form-group'>
                                                                    <label >Municipio</label>
                                                                    <input type="text" class="form-control" disabled="" name="fornecedor_nome_municipio" value="<?php echo $emit_xMun ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_nome_municipio" value="<?php echo $emit_xMun ?>"/>                                 
                                                                </div>
                                                            </div>

                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >UF</label>
                                                                    <input type="text" class="form-control" disabled="" name="fornecedor_uf" value="<?php echo $emit_UF ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_uf" value="<?php echo $emit_UF ?>"/>                                 
                                                                </div>
                                                            </div>

                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >CEP</label>
                                                                    <input type="text" class="form-control" disabled="" name="fornecedor_cep"value="<?php echo $emit_CEP ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_cep" value="<?php echo $emit_CEP ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >cPais</label>
                                                                    <input type="text" class="form-control" disabled="" name="fornecedor_cod_pais" value="<?php echo $emit_cPais ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_cod_pais" value="<?php echo $emit_cPais ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >Pais</label>
                                                                    <input type="text" class="form-control" disabled="" name="fornecedor_nome_pais" value="<?php echo $emit_xPais ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_nome_pais" value="<?php echo $emit_xPais ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >Fone</label>
                                                                    <input type="text" class="form-control" disabled="" name="fornecedor_fone" value="<?php echo $emit_fone ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_fone" value="<?php echo $emit_fone ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >I.E.</label>
                                                                    <input type="text" class="form-control" disabled="" name="fornecedor_ie"  value="<?php echo $emit_IE ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_ie" value="<?php echo $emit_IE ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >I.E. ST</label>
                                                                    <input type="text" class="form-control" disabled="" name="fornecedor_iest" value="<?php echo $emit_IEST ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_iest" value="<?php echo $emit_IEST ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >CRT</label>
                                                                    <input type="text" class="form-control" disabled="" name="fornecedor_crt" value="<?php echo $emit_CRT ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="fornecedor_crt" value="<?php echo $emit_CRT ?>"/>                                 
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
                            <!--                           ******* DADOS DO DESTINATARIO ******** -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="widget-box">
                                        <div class="widget-header widget-header-flat">
                                            <h4 class="widget-title smaller">
                                                Dados Destinatário
                                            </h4>
                                        </div>

<?php
//===============================================================================================================================================		
//<dest>
$dest_cnpj = $xml->NFe->infNFe->dest->CNPJ;                 //<CNPJ>01153928000179</CNPJ>
$dest_cpf = $xml->NFe->infNFe->dest->CPF;
//<CPF></CPF>
$dest_xNome = $xml->NFe->infNFe->dest->xNome;               //<xNome>AGROVENETO S.A.- INDUSTRIA DE ALIMENTOS  -002825</xNome>
//***********************************************************************************************************************************************	
//<enderDest>
$dest_xLgr = $xml->NFe->infNFe->dest->enderDest->xLgr;            //<xLgr>ALFREDO PESSI, 2.000</xLgr>
$dest_nro = $xml->NFe->infNFe->dest->enderDest->nro;         //<nro>.</nro>
$dest_xCpl = $xml->NFe->infNFe->dest->enderDest->xCpl;         //<nro>.</nro>
$dest_xBairro = $xml->NFe->infNFe->dest->enderDest->xBairro;      //<xBairro>PARQUE INDUSTRIAL</xBairro>
$dest_cMun = $xml->NFe->infNFe->dest->enderDest->cMun;            //<cMun>4211603</cMun>
$dest_xMun = $xml->NFe->infNFe->dest->enderDest->xMun;            //<xMun>NOVA VENEZA</xMun>
$dest_UF = $xml->NFe->infNFe->dest->enderDest->UF;                //<UF>SC</UF>
$dest_CEP = $xml->NFe->infNFe->dest->enderDest->CEP;              //<CEP>88865000</CEP>
$dest_cPais = $xml->NFe->infNFe->dest->enderDest->cPais;          //<cPais>1058</cPais>
$dest_xPais = $xml->NFe->infNFe->dest->enderDest->xPais;          //<xPais>BRASIL</xPais>
$dest_fone = $xml->NFe->infNFe->dest->enderDest->fone;          //<xPais>BRASIL</xPais>
//</enderDest>
$dest_IE = $xml->NFe->infNFe->dest->IE;                           //<IE>253323029</IE>
$dest_email = $xml->NFe->infNFe->dest->email;                           //<IE>253323029</IE>
//
?>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class='row'>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label>CNPJ</label>
                                                                    <input type="text" class="form-control"   value="<?php echo $dest_cnpj ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dest_cnpj"  value="<?php echo $dest_cnpj ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label>CPF</label>
                                                                    <input type="text" class="form-control"   value="<?php echo $dest_cpf ?>"/>                                 
                                                                    <input type="hidden" class="form-control"  name="dest_cpf"  value="<?php echo $dest_cpf ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-6'>    
                                                                <div class='form-group'>
                                                                    <label >Nome</label>
                                                                    <input type="text" class="form-control"  value="<?php echo $dest_xNome ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dest_xNome"  value="<?php echo $dest_xNome ?>"/>                                 
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class='col-sm-4'>    
                                                                <div class='form-group'>
                                                                    <label >Endereco</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $dest_xLgr ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dest_xLgr" value="<?php echo $dest_xLgr ?>"/>                                 
                                                                </div>
                                                            </div> 
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >Numero</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $dest_nro ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dest_nro" value="<?php echo $dest_nro ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >Cpl.</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $dest_xCpl ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dest_xCpl" value="<?php echo $dest_xCpl ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-3'>    
                                                                <div class='form-group'>
                                                                    <label >Bairro</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $dest_xBairro ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dest_xBairro" value="<?php echo $dest_xBairro ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >cMun</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $dest_cMun ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dest_cMun" value="<?php echo $dest_cMun ?>"/>                                 
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class='col-sm-3'>    
                                                                <div class='form-group'>
                                                                    <label >Municipio</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $dest_xMun ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dest_xMun" value="<?php echo $dest_xMun ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >UF</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $dest_UF ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dest_UF" value="<?php echo $dest_UF ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >CEP</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $dest_CEP ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dest_CEP" value="<?php echo $dest_CEP ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-1'>    
                                                                <div class='form-group'>
                                                                    <label >cPais</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $dest_cPais ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dest_cPais" value="<?php echo $dest_cPais ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >Pais</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $dest_xPais ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dest_xPais" value="<?php echo $dest_xPais ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >Fone</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $dest_fone ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dest_fone" value="<?php echo $dest_fone ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >I.E.</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $dest_IE ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dest_IE" value="<?php echo $dest_IE ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-6'>    
                                                                <div class='form-group'>
                                                                    <label >E-mail</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $dest_email ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="dest_email" value="<?php echo $dest_email ?>"/>                                 
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
                            <!--                           ******* PRODUTOS/SERVIÇOS *********   -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="widget-box">
                                        <div class="widget-header widget-header-flat">
                                            <h4 class="widget-title smaller">
                                                Produtos/Serviços
                                            </h4>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">

                                                        <table id="simple-table" class="table table-striped table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th class="hidden-480">Seq</th>                                           
                                                                    <th class="hidden-480">cProd</th>                                           
                                                                    <th class="hidden-480">xProd</th>
                                                                    <th class="hidden-480">NCM</th>
                                                                    <th class="hidden-480">CFOP</th>
                                                                    <th class="hidden-480">UN</th>
                                                                    <th class="hidden-480">QTD</th>
                                                                    <th class="hidden-480">Preço</th>
                                                                    <th class="hidden-480">Total</th>

                                                                    <td class="hidden-480">BC ICMS</td>
                                                                    <td class="hidden-480">Vl ICMS</td>
                                                                    <td class="hidden-480">Vl IPI</td>
                                                                    <td class="hidden-480">% ICMS</td>
                                                                    <td class="hidden-480">% IPI</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                            <form method="post" id="login-form">



<?php
$seq = 0;
foreach ($xml->NFe->infNFe->det as $item) {
    $seq++;
    $codigo = $item->prod->cProd;
    $cEAN = $item->prod->cEAN;
    $xProd = $item->prod->xProd;
    $NCM = $item->prod->NCM;
    $CFOP = $item->prod->CFOP;
    $uCom = $item->prod->uCom;
    $qCom = $item->prod->qCom;
    //$qCom = number_format((double) $qCom, 2, ",", ".");
    $vUnCom = $item->prod->vUnCom;
    // $vUnCom = number_format((double) $vUnCom, 2, ".", ".");
    $vProd = $item->prod->vProd;
    //$vProd = number_format((double) $vProd, 2, ",", ".");

    $cEANTrib = $item->prod->cEANTrib;
    $uTrib = $item->prod->uTrib;
    $qTrib = $item->prod->qTrib;
    $vUnTrib = $item->prod->vUnTrib;

    $vUnTrib = number_format((double) $vUnTrib, 2, ",", ".");
    $indTot = $item->prod->indTot;
    $nItemPed = $item->prod->nItemPed;

    $vTotTrib = $item->imposto->vTotTrib;
    $vTotTrib = number_format((double) $vTotTrib, 2, ",", ".");



    $vBC_item = $item->imposto->ICMS->ICMS00->vBC;
    $icms00 = $item->imposto->ICMS->ICMS00;
    $icms10 = $item->imposto->ICMS->ICMS10;
    $icms20 = $item->imposto->ICMS->ICMS20;
    $icms30 = $item->imposto->ICMS->ICMS30;
    $icms40 = $item->imposto->ICMS->ICMS40;
    $icms50 = $item->imposto->ICMS->ICMS50;
    $icms51 = $item->imposto->ICMS->ICMS51;
    $icms60 = $item->imposto->ICMS->ICMS60;
    $ICMSSN102 = $item->imposto->ICMS->ICMSSN102;
    $ICMSSN101 = $item->imposto->ICMS->ICMSSN101;
    $ICMSSN500 = $item->imposto->ICMS->ICMSSN500;
    if (!empty($ICMSSN102)) {
        //AQUI VERIFICAR A ICMS DE CADA TIPO 
        $bc_icms = "0.00";
        $pICMS = "0	";
        $vlr_icms = "0.00";
    }
    if (!empty($ICMSSN101)) {
        $bc_icms = "0.00";
        $pICMS = "0	";
        $vlr_icms = "0.00";
    }
    if (!empty($ICMSSN500)) {
        $bc_icms = "0.00";
        $pICMS = "0	";
        $vlr_icms = "0.00";
    }


    if (!empty($icms00)) {
        $bc_icms = $item->imposto->ICMS->ICMS00->vBC;
        $bc_icms = number_format((double) $bc_icms, 2, ",", ".");
        $pICMS = $item->imposto->ICMS->ICMS00->pICMS;
        $pICMS = round($pICMS, 0);
        $vlr_icms = $item->imposto->ICMS->ICMS00->vICMS;
        $vlr_icms = number_format((double) $vlr_icms, 2, ",", ".");
    }
    if (!empty($icms20)) {
        $bc_icms = $item->imposto->ICMS->ICMS20->vBC;
        $bc_icms = number_format((double) $bc_icms, 2, ",", ".");
        $pICMS = $item->imposto->ICMS->ICMS20->pICMS;
        $pICMS = round($pICMS, 0);
        $vlr_icms = $item->imposto->ICMS->ICMS20->vICMS;
        $vlr_icms = number_format((double) $vlr_icms, 2, ",", ".");
    }
    if (!empty($icms30)) {
        $bc_icms = "0.00";
        $pICMS = "0	";
        $vlr_icms = "0.00";
    }
    if (!empty($icms40)) {
        $bc_icms = "0.00";
        $pICMS = "0	";
        $vlr_icms = "0.00";
    }
    if (!empty($icms50)) {
        $bc_icms = "0.00";
        $pICMS = "0	";
        $vlr_icms = "0.00";
    }
    if (!empty($icms51)) {
        $bc_icms = $item->imposto->ICMS->ICMS51->vBC;
        $pICMS = $item->imposto->ICMS->ICMS51->pICMS;
        $pICMS = round($pICMS, 0);
        $vlr_icms = $item->imposto->ICMS->ICMS51->vICMS;
    }
    if (!empty($icms60)) {
        $bc_icms = "0,00";
        $pICMS = "0	";
        $vlr_icms = "0,00";
    }
    $IPITrib = $item->imposto->IPI->IPITrib;
    if (!empty($IPITrib)) {
        $bc_ipi = $item->imposto->IPI->IPITrib->vBC;
        $bc_ipi = number_format((double) $bc_ipi, 2, ",", ".");
        $perc_ipi = $item->imposto->IPI->IPITrib->pIPI;
        $perc_ipi = round($perc_ipi, 0);
        $vlr_ipi = $item->imposto->IPI->IPITrib->vIPI;
        $vlr_ipi = number_format((double) $vlr_ipi, 2, ",", ".");
    }
    $IPINT = $item->imposto->IPI->IPINT;
    {
        $bc_ipi = "0,00";
        $perc_ipi = "0";
        $vlr_ipi = "0,00";
    }
    ?>
                                                                    <tr class="form-group">
                                                                        <td class="hidden-480"><?php echo $seq ?><input name="seq[]" type="hidden" value="<?php echo $seq ?>"></td>
                                                                        <td class="hidden-480"><?php echo $codigo ?><input name="codigo[]" type="hidden" value="<?php echo $codigo ?>"> </td>
                                                                    <input name="cEAN[]" type="hidden" value="<?php echo $cEAN ?>">
                                                                    <input name="cEANTrib[]" type="hidden" value="<?php echo $cEANTrib ?>">
                                                                    <input name="uTrib[]" type="hidden" value="<?php echo $uTrib ?>">
                                                                    <input name="qTrib[]" type="hidden" value="<?php echo $qTrib ?>">
                                                                    <input name="vUnTrib[]" type="hidden" value="<?php echo $vUnTrib ?>">
                                                                    <input name="indTot[]" type="hidden" value="<?php echo $indTot ?>">
                                                                    <input name="nItemPed[]" type="hidden" value="<?php echo $nItemPed ?>">
                                                                    <input name="vTotTrib[]" type="hidden" value="<?php echo $vTotTrib ?>">

                                                                    <input name="id_cnpj[]" type="hidden" value="<?php echo $achou_cnpj['fornecedor_id'] ?>">
                                                                    <td class="hidden-480"><?php echo $xProd ?><input name="xProd[]" type="hidden" value="<?php echo $xProd ?>"></td>
                                                                    <td class="hidden-480"><?php echo $NCM ?><input name="NCM[]" type="hidden" value="<?php echo $NCM ?>"></td>
                                                                    <td class="hidden-480"><?php echo $CFOP ?><input name="CFOP[]" type="hidden" value="<?php echo $CFOP ?>"></td>
                                                                    <td class="hidden-480"><?php echo $uCom ?><input name="uCom[]" type="hidden" value="<?php echo $uCom ?>"></td>
                                                                    <td class="hidden-480"><?php echo $qCom ?><input name="qCom[]" type="hidden" value="<?php echo $qCom ?>"></td>
                                                                    <td class="hidden-480"><?php echo $vUnCom ?><input name="vUnCom[]" type="hidden" value="<?php echo $vUnCom ?>"></td>
                                                                    <td class="hidden-480"><?php echo $vProd ?><input name="vProdu[]" type="hidden" value="<?php echo $vProd ?>"></td>
                                                                    <td class="hidden-480"><?php echo $bc_icms ?><input name="bc_icms[]" type="hidden" value="<?php echo $bc_icms ?>"> </td>
                                                                    <td class="hidden-480"><?php echo $vlr_icms ?><input name="vlr_icms[]" type="hidden" value="<?php echo $vlr_icms ?>"></td>
                                                                    <td class="hidden-480"><?php echo $vlr_ipi ?><input name="vlr_ipi[]" type="hidden" value="<?php echo $vlr_ipi ?>"></td>
                                                                    <td class="hidden-480"><?php echo $pICMS ?><input name="pICMS[]" type="hidden" value="<?php echo $pICMS ?>"></td>
                                                                    <td class="hidden-480"><?php echo $perc_ipi ?><input name="perc_ipi[]" type="hidden" value="<?php echo $perc_ipi ?>"></td>
                                                                    </tr>


    <?php
}
?>

                                                            </form>

                                                            </tbody>
                                                        </table>

                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--                           ******* TOTAIS DA NFE *********   -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="widget-box">
                                        <div class="widget-header widget-header-flat">
                                            <h4 class="widget-title smaller">
                                                Totais
                                            </h4>
                                        </div>

<?php
//===============================================================================================================================================		
$vBC = $xml->NFe->infNFe->total->ICMSTot->vBC;
// $vBC = number_format((double) $vBC, 2, ",", ".");
$vICMS = $xml->NFe->infNFe->total->ICMSTot->vICMS;
//$vICMS = number_format((double) $vICMS, 2, ",", ".");
$vICMSDeson = $xml->NFe->infNFe->total->ICMSTot->vICMSDeson;
// $vICMSDeson = number_format((double) $vICMSDeson, 2, ",", ".");
$vBCST = $xml->NFe->infNFe->total->ICMSTot->vBCST;
// $vBCST = number_format((double) $vBCST, 2, ",", ".");
$vST = $xml->NFe->infNFe->total->ICMSTot->vST;
//$vST = number_format((double) $vST, 2, ",", ".");
$vProd = $xml->NFe->infNFe->total->ICMSTot->vProd;
//$vProd = number_format((double) $vProd, 2, ",", ".");
$vNF = $xml->NFe->infNFe->total->ICMSTot->vNF;
// $vNF = number_format((double) $vNF, 2, ",", ".");
$vFrete = number_format((double) $xml->NFe->infNFe->total->ICMSTot->vFrete, 2, ",", ".");
$vSeg = number_format((double) $xml->NFe->infNFe->total->ICMSTot->vSeg, 2, ",", ".");
$vDesc = number_format((double) $xml->NFe->infNFe->total->ICMSTot->vDesc, 2, ",", ".");
$vIPI = number_format((double) $xml->NFe->infNFe->total->ICMSTot->vIPI, 2, ",", ".");
?>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class='row'>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label>vBC</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $vBC ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="vBC" value="<?php echo $vBC ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label>vICMS</label>
                                                                    <input type="text" class="form-control"  disabled="" value="<?php echo $vICMS ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="vICMS"  value="<?php echo $vICMS ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label>vICMSDeson</label>
                                                                    <input type="text" class="form-control"  disabled="" value="<?php echo $vICMSDeson ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="vICMSDeson"  value="<?php echo $vICMSDeson ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >vBCST</label>
                                                                    <input type="text" class="form-control" disabled=""  value="<?php echo $vBCST ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="vBCST"  value="<?php echo $vBCST ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >vST</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $vST ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="vST" value="<?php echo $vST ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >vProd</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $vProd ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="vProd" value="<?php echo $vProd ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >vNF</label>
                                                                    <input type="text" class="form-control"  disabled="" value="<?php echo $vNF ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="vNF" value="<?php echo $vNF ?>"/>                                 
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >vFrete</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $vFrete ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="vFrete" value="<?php echo $vFrete ?>"/>                                 
                                                                </div>
                                                            </div> <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >vSeg</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $vSeg ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="vSeg" value="<?php echo $vSeg ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >vDesc</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $vDesc ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="vDesc" value="<?php echo $vDesc ?>"/>                                 
                                                                </div>
                                                            </div>
                                                            <div class='col-sm-2'>    
                                                                <div class='form-group'>
                                                                    <label >vIPI</label>
                                                                    <input type="text" class="form-control" disabled="" value="<?php echo $vIPI ?>"/>                                 
                                                                    <input type="hidden" class="form-control" name="vIPI" value="<?php echo $vIPI ?>"/>                                 
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
                            <!--                           ******* FATURAS/DUPLICATAS *********   -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="widget-box">
                                        <div class="widget-header widget-header-flat">
                                            <h4 class="widget-title smaller">
                                                Fatura/Duplicata
                                            </h4>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <table id="simple-table" class="table table-striped table-bordered table-hover">
                                                            <thead>


                                                                <tr>

                                                                    <th class="hidden-480">Fatura</th>                                           
                                                                    <th class="hidden-480">Total</th>                                           
                                                                    <th class="hidden-480">Titulo</th>
                                                                    <th class="hidden-480">Vencimento</th>
                                                                    <th class="hidden-480">Valor Parcial</th>


                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            <form method="post" id="login-form">

<?php
$id = 0;
if (!empty($xml->NFe->infNFe->cobr->dup)) {

    $numero_fat = $xml->NFe->infNFe->cobr->fat->nFat;
    $valor = $xml->NFe->infNFe->cobr->fat->vLiq;

    foreach ($xml->NFe->infNFe->cobr->dup as $dup) {
        $id++;
        $titulo = $dup->nDup;
        $vencimento = $dup->dVenc;
        $vencimento = explode('-', $vencimento);
        $vencimento = $vencimento[2] . "/" . $vencimento[1] . "/" . $vencimento[0];
        $vlr_parcela = number_format((double) $dup->vDup, 2, ",", ".");
        ?>
                                                                        <tr class="form-group">
                                                                            <td><?php echo $numero_fat ?></td>
                                                                            <td><?php echo $valor ?></td>
                                                                            <td><?php echo $titulo ?></td>
                                                                            <td><?php echo $vencimento ?></td>
                                                                            <td><?php echo $vlr_parcela ?></td>
                                                                        </tr>


        <?php
    }
}
?>






                                                            </form>

                                                            </tbody>
                                                        </table>

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









        </div>
    </div>
</div>

<?php
require_once '../pagina/footer.php';
?>