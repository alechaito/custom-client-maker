<?php 
?>
    <form method="post">
        <label>IP (max. 17 caracteres)</label></br>
        <input type="text" name="ip_address"></br>
        <label>RSA Modulos (max. 309 caracteres) *info</label></br>
        <input type="text" name="rsa_modulos"></br>
        <label>Versao do Client</label></br>
        <select name="version_client">
            <option value="860">8.60</option>
            <option value="870">8.70</option>
            <option value="986">9.86</option>
            <option value="1090">10.90</option>
            <option value="1096">10.96</option>
            <option value="1097">10.97</option>
            <option value="1098">10.98</option>
        </select></br></br>
        <input type="submit" value="Criar" name="create_client"></br>
    </form>
<?php
    if(isset($_POST['create_client'])) {
        //declaracao de variaveis
        $ip  = anti_injection($_POST['ip_address']);
        $rsa = anti_injection($_POST['rsa_modulos']);
        $version = anti_injection($_POST['version_client']);
        $error = 0;
        nulInsert($ip);
        //verificando valores nulos nos campos
        if (!empty($_POST) && (empty($ip) || empty($rsa) || empty($version))) {
            echo "[ERRO] insira algum valor nos campos.</br>";
            $error = 1;
        }
        //verificando tamanho do post
        if (strlen($ip) >= 18 || strlen($rsa) >= 310) {
            echo "[ERRO] limite maximo de caracteres excedidos.</br>";
            $error = 1;
        }
        $words_nul = nulInsert($ip);
        if ($error == 0) {
            $array_words = array(
                //sites
                'tibia01.cipsoft.com' => $words_nul[1],
                'tibia02.cipsoft.com' => $words_nul[1],
                'tibia03.cipsoft.com' => $words_nul[1],
                'tibia04.cipsoft.com' => $words_nul[1],
                'tibia05.cipsoft.com' => $words_nul[1],
                //ips
                'login01.tibia.com' =>  $words_nul[0],
                'login02.tibia.com' =>  $words_nul[0],
                'login03.tibia.com' =>  $words_nul[0],
                'login04.tibia.com' =>  $words_nul[0],
                'login05.tibia.com' =>  $words_nul[0],
                //RSA MODULOS  
                '124710459426827943004376449897985582167801707960697037164044904862948569380850421396904597686953877022394604239428185498284169068581802277612081027966724336319448537811441719076484340922854929273517308661370727105382899118999403808045846444647284499123164879035103627004668521005328367415259939915284902061793' => $rsa,
            );
            $data = strReplaceAssoc($array_words, file_get_contents("".$version.".txt"));
            $new_file = @fopen('/var/www/hex/tibia-'.$ip.'.txt', 'a+');
            fwrite($new_file, $data);
            fclose($new_file);
            echo "[SUCESSO] Seu client proprio foi criado com sucesso..";
            downloadClient('tibia-'.$ip.'.txt');
        }
    }

    function strReplaceAssoc(array $replace, $subject) { 
        return str_replace(array_keys($replace), array_values($replace), $subject);    
    } 

    function nulInsert($ip_address) {
        $lenght_ip = strlen($ip_address);
        $nul_ip = '';
        $nul_site = '';
        for ($i = $lenght_ip; $i < 17; $i++) {
            //adicionando 1+ no IP pra completa 17 hex nul.
            $nul_ip .= chr('00');
        }
        for ($j = $lenght_ip; $j < 19; $j++) {
            // adicionando 1+ no site pra completa 19 hex nul.
            $nul_site .= chr('00');
        }
        return array($ip_address.$nul_ip, $ip_address.$nul_site); //like tibia01.cipsoft.com(19), login01.tibia.com(17)
    }

    function downloadClient($generatedlFile) {
        $dir_file = '/var/www/hex/'.$generatedlFile;
        if (!file_exists($dir_file)) {
            echo "[ERRO] falha na geração de arquivo, tente novamente.";
            exit;
        }
        // Configuramos os headers que serão enviados para o browser
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="Tibia.exe"');
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($generatedlFile));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Expires: 0');
        // Envia o arquivo para o cliente
        ob_end_clean(); 
        flush();
        readfile($generatedlFile);
        unlink($generatedlFile);
    }

    function anti_injection($sql){
        $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"), "" ,$sql);
        $sql = trim($sql);
        $sql = strip_tags($sql);
        $sql = (get_magic_quotes_gpc()) ? $sql : addslashes($sql);
        return $sql;
    }

?>