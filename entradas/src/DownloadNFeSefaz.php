<?php
namespace DownloadNFeSefaz;
/*
 * API Para download de XML da NF-e direto pelo site da secretária da fazenda
 */
/**
 * Description of DownloadNFeSefaz
 *
 * @author Edimário Gomes <edi.gomes00@gmail.com>
 * @license GPL
 */
class DownloadNFeSefaz {
    
    /**
     * CNPJ da empresa emitente 
     * @var String
     */
    private $CNPJ;
    
    /**
     * Pasta onde se encontram os arquivos .pem
     * {CNPJ}_priKEY.pem
     * {CNPJ}_certKEY.pem
     * {CNPJ}_pubKEY.pem
     * do certificado A1 (pasta certs do nfe php)
     * ($this->aConfig['pathCertsFiles'])
     * @var type String
     */
    private $pathCertsFiles;
    
    /**
     * Senha do certificado
     * @var type 
     */
    private $certPass;
    
    /**
     * Faz o download da NF-e no site da sefaz usando o certificado digital do cliente
     * @param type $txtCaptcha Captcha fornecedo por getDownloadXMLCaptcha
     * @param type $chNFe Chave de acesso da NF-e
     * @return String XML da NF-e
     */
    public function downloadXmlSefaz($txtCaptcha, $chNFe, $CNPJ, $pathCertsFiles, $certPass) {
        
        // TODO: Validar CNPJ
        $this->CNPJ = $CNPJ;
        // TODO: Validar se existe a pasta e os arquivos .pem
        $this->pathCertsFiles = $pathCertsFiles;
        // TODO: Validar senha do certificado
        $this->certPass = $certPass;
        
        // TODO: validar chNFe 44 digitos
        
        //session_start();
        // URL onde a sefaz fornece o botão de download
        $url = "http://www.nfe.fazenda.gov.br/portal/consulta.aspx?tipoConsulta=completa&tipoConteudo=XbSeqxE8pl8=";
        // Arquivo de coockie para armazenar a session
        $cookie  = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'cookies1.txt';
        // Simula um browser pelo curl
        $useragent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36';
        /* Start Login process */
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_COOKIEJAR , $cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
        //curl_setopt($ch, CURLOPT_STDERR, $f);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        // Collecting all POST fields
        $postfields = array();
        $postfields['__EVENTTARGET'] = "";
        $postfields['__EVENTARGUMENT'] = "";
        $postfields['__VIEWSTATE'] = $_SESSION['viewstate'];
        $postfields['__VIEWSTATEGENERATOR'] = $_SESSION['stategen'];
        $postfields['__EVENTVALIDATION'] = $_SESSION['eventValidation'];
        
        $postfields['ctl00$txtPalavraChave'] = "";
        
        $postfields['ctl00$ContentPlaceHolder1$txtChaveAcessoCompleta'] = $chNFe;
        $postfields['ctl00$ContentPlaceHolder1$txtCaptcha'] = $txtCaptcha;
        $postfields['ctl00$ContentPlaceHolder1$btnConsultar'] = 'Continuar';
        $postfields['ctl00$ContentPlaceHolder1$token'] = $_SESSION['token'];
        $postfields['hiddenInputToUpdateATBuffer_CommonToolkitScripts'] = '1';
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        $html = curl_exec($ch); // Get result after login page.
        curl_close($ch);
        
        //echo $html;
        
        /* ENTRA NA INFO DA NFE */
        $ch = curl_init();
        $url_det_nfe = 'http://www.nfe.fazenda.gov.br/portal/consultaCompleta.aspx?tipoConteudo=XbSeqxE8pl8=';
        
        curl_setopt($ch, CURLOPT_URL, $url_det_nfe);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_COOKIEJAR , $cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
        //curl_setopt($ch, CURLOPT_STDERR, $f);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        //curl_setopt($ch, CURLOPT_POST, 1);
        
        $html = curl_exec($ch); // Get result after login page.
        curl_close($ch);
        /****/
        
        preg_match('~Chave de Acesso~', $html, $tagTeste);
        preg_match('~<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="(.*?)" />~', $html, $viewstate);
        preg_match('~<input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="(.*?)" />~', $html, $stategen);
        preg_match('~<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="(.*?)" />~', $html, $eventValidation);
        $stategen = $stategen[1];
        $viewstate = $viewstate[1];
        $eventValidation = $eventValidation[1];
        
        try {
            $tagDownload = $tagTeste[0];
        } catch (\Exception $e) {
            throw new \Exception('Não foi possível fazer o download do XML, por favor atualize o captcha e tente novamente (sessão expirada)');
        }
        
        // Parãmetro teste para saber se a página veio corretamente
        if ($tagDownload == "Chave de Acesso") {
        
            // URL onde a sefaz fornece o download do xml
            $url_download = "http://www.nfe.fazenda.gov.br/portal/consultaCompleta.aspx?tipoConteudo=XbSeqxE8pl8=";
            // Verifica se o certificado existe na pasta
            if (!file_exists($this->pathCertsFiles . $this->CNPJ .'_priKEY.pem') ||
                !file_exists($this->pathCertsFiles . $this->CNPJ .'_priKEY.pem') ||
                !file_exists($this->pathCertsFiles . $this->CNPJ .'_priKEY.pem')) {
                throw new \Exception('Certificado digital não encontrado na pasta: ' . $this->pathCertsFiles . '!');
            }
            
            /**
            Download xml
            */
            $ch_download = curl_init();
            curl_setopt($ch_download, CURLOPT_URL, $url_download);
            curl_setopt($ch_download, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch_download, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch_download, CURLOPT_COOKIEJAR , $cookie);
            curl_setopt($ch_download, CURLOPT_COOKIEFILE, $cookie);
            curl_setopt($ch_download, CURLOPT_HEADER, TRUE);
            // this with CURLOPT_SSLKEYPASSWD 
            curl_setopt($ch_download, CURLOPT_SSLKEY, $this->pathCertsFiles . $this->CNPJ .'_priKEY.pem');
            // The --cacert option
            curl_setopt($ch_download, CURLOPT_CAINFO, $this->pathCertsFiles . $this->CNPJ .'_certKEY.pem');
            // The --cert option
            curl_setopt($ch_download, CURLOPT_SSLCERT, $this->pathCertsFiles . $this->CNPJ .'_pubKEY.pem');
            // Cert pass
            curl_setopt($ch_download, CURLOPT_SSLCERTPASSWD, $this->certPass);
            curl_setopt($ch_download, CURLOPT_FOLLOWLOCATION, FALSE);
            curl_setopt($ch_download, CURLOPT_REFERER, $url_download);
            //curl_setopt($ch_download, CURLOPT_VERBOSE, 1);
            
            curl_setopt($ch_download, CURLOPT_CONNECTTIMEOUT, 50); 
            curl_setopt($ch_download, CURLOPT_TIMEOUT, 400); //timeout in seconds
            
            // Log
            //curl_setopt($ch_download, CURLOPT_STDERR, fopen("dump", "wb"));
            curl_setopt($ch_download, CURLOPT_USERAGENT, $useragent);
            // Collecting all POST fields
            $postfields_download = array();
            $postfields_download['__EVENTTARGET'] = "";
            $postfields_download['__EVENTARGUMENT'] = "";
            $postfields_download['__VIEWSTATE'] = $viewstate;
            $postfields_download['__VIEWSTATEGENERATOR'] = $stategen;
            $postfields_download['__EVENTVALIDATION'] = $eventValidation;
            $postfields_download['ctl00$txtPalavraChave'] = '';
            $postfields_download['ctl00$ContentPlaceHolder1$btnDownload'] = 'Download do documento*';
            $postfields_download['ctl00$ContentPlaceHolder1$abaSelecionada'] = '';
            $postfields_download['hiddenInputToUpdateATBuffer_CommonToolkitScripts'] = 1;
            
            curl_setopt($ch_download, CURLOPT_POST, 1);
            curl_setopt($ch_download, CURLOPT_POSTFIELDS, $postfields_download);
            
            $response = curl_exec($ch_download); // Get result after login page.
            
            $download_link_arr = array();
            
            //echo($response);
            
            //dd($download_link);
            
            $header_size = curl_getinfo($ch_download, CURLINFO_HEADER_SIZE);
            $header = substr($response, 0, $header_size);
            //$body = substr($response, $header_size);
            
            curl_close($ch_download);
            
            // Pega o link para download na header
            preg_match_all('/Location: (.*?)\r\n/sm', $header, $download_link_arr);
            $download_link_ = $download_link_arr[1];
            
            // VALIDA
            $download_link = $download_link_[0];
            
            //dd($download_link);
            
            /** DOWNLOAD XML 2 **/
            
            /**
            Download xml
            */
            $ch_download = curl_init();
            curl_setopt($ch_download, CURLOPT_URL, $download_link);
            curl_setopt($ch_download, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch_download, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch_download, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch_download, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch_download, CURLOPT_COOKIEJAR , $cookie);
            curl_setopt($ch_download, CURLOPT_COOKIEFILE, $cookie);
            
            // this with CURLOPT_SSLKEYPASSWD 
            curl_setopt($ch_download, CURLOPT_SSLKEY, $this->pathCertsFiles . $this->CNPJ .'_priKEY.pem');
            // The --cacert option
            curl_setopt($ch_download, CURLOPT_CAINFO, $this->pathCertsFiles . $this->CNPJ .'_certKEY.pem');
            // The --cert option
            curl_setopt($ch_download, CURLOPT_SSLCERT, $this->pathCertsFiles . $this->CNPJ .'_pubKEY.pem');
            // Cert pass
            curl_setopt($ch_download, CURLOPT_SSLCERTPASSWD, $this->certPass);
            //curl_setopt($ch_download, CURLOPT_VERBOSE, 1);
            curl_setopt($ch_download, CURLOPT_CONNECTTIMEOUT, 50);
            
            $response_xml = curl_exec($ch_download); // Get result after login page.
            
            curl_close($ch_download);
            
            return $response_xml;
            
        } else {
            throw new \Exception('Não foi possível fazer o download do XML, por favor tente novamente (Verifique o Captcha)');
        }
        
    }
    
    /**
     * Retorna o captcha da sefaz para download do XML
     * no formato base64 (png)
     * @return String base64 png
     */
    public function getDownloadXmlCaptcha() {
       // session_start();
        
        // Passo 1
        $url = "http://www.nfe.fazenda.gov.br/portal/consulta.aspx?tipoConsulta=completa&tipoConteudo=XbSeqxE8pl8=";
        $cookie  = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'cookies1.txt';
        $useragent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.2 (KHTML, like Gecko) Chrome/5.0.342.3 Safari/533.2';
        /* Get __VIEWSTATE & __EVENTVALIDATION */
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_COOKIEJAR , $cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        $html = curl_exec($ch);
        curl_close($ch);
        
        $_viewstate = array();
        $_stategen = array();
        $_eventValidation = array();
        $_sstoken = array();
        $_captcha = array();
        
        preg_match('~<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="(.*?)" />~', $html, $_viewstate);
        preg_match('~<input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="(.*?)" />~', $html, $_stategen);
        preg_match('~<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="(.*?)" />~', $html, $_eventValidation);
        preg_match('~<input type="hidden" name="ctl00\$ContentPlaceHolder1\$token" id="ctl00_ContentPlaceHolder1_token" value="(.*?)" />~', $html, $_sstoken);
        preg_match('~<img id=\"ctl00_ContentPlaceHolder1_imgCaptcha\" src=\"(.*)\" style~', $html, $_captcha);
        
        // TODO: Verificar se a página do captcha foi carregada
        $stategen = $_stategen[1];
        $_SESSION['stategen'] = $stategen;
        
        $token = $_sstoken[1];
        $_SESSION['token'] = $token;
        
        $viewstate = $_viewstate[1];
        $_SESSION['viewstate'] = $viewstate;
        
        $eventValidation = $_eventValidation[1];
        $_SESSION['eventValidation'] = $eventValidation;
        
        $captcha = $_captcha[1];
        return $captcha;
        
    }
    
}