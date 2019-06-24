<?php
    
    function str_replac(array $replace, $subject) { 
        return str_replace(array_keys($replace), array_values($replace), $subject);    
    }

    function null_insert($ip_address) {
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


    function anti_injection($sql) {
        $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"), "" ,$sql);
        $sql = trim($sql);
        $sql = strip_tags($sql);
        $sql = (get_magic_quotes_gpc()) ? $sql : addslashes($sql);
        return $sql;
    }

    function get_data($data, $version) {
        $new_rsa = '109120132967399429278860960508995541528237502902798129123468757937266291492576446330739696001110603907230888610072655818825358503429057592827629436413108566029093628212635953836686562675849720620786279431090218017681061521755056710823876476444260558147179707119674283982419152118103759076030616683978566631413';
        $rsa860 = '124710459426827943004376449897985582167801707960697037164044904862948569380850421396904597686953877022394604239428185498284169068581802277612081027966724336319448537811441719076484340922854929273517308661370727105382899118999403808045846444647284499123164879035103627004668521005328367415259939915284902061793';
        
		$rsa1098 = '132127743205872284062295099082293384952776326496165507967876361843343953435544496682053323833394351797728954155097012103928360786959821132214473291575712138800495033169914814069637740318278150290733684032524174782740134357629699062987023311132821016569775488792221429527047321331896351555606801473202394175817';
        $rsa = $rsa1098;
        if($version == '860' or $version == '854') {
            $rsa = $rsa860;
        }
        $info_client = array(
            //sites
            'tibia01.cipsoft.com' => $data[1],
            'tibia02.cipsoft.com' => $data[1],
            'tibia03.cipsoft.com' => $data[1],
            'tibia04.cipsoft.com' => $data[1],
            'tibia05.cipsoft.com' => $data[1],
            //ips
            'login01.tibia.com' =>  $data[0],
            'login02.tibia.com' =>  $data[0],
            'login03.tibia.com' =>  $data[0],
            'login04.tibia.com' =>  $data[0],
            'login05.tibia.com' =>  $data[0],

            //RSA MODULOS  
            $rsa => $new_rsa,
        );
        return $info_client;
    }

    function gen_new_files($ip) {
        $url = "loginWebService=http://".$ip."/login.php";
        $orig_url = "loginWebService=http://127.0.0.1/login.php";
        $ip_size = strlen($url);
        $orig_size = strlen($orig_url);
        // Completando 53 caracteres com valores NULOS
        echo $ip_size."</br>";
		echo $orig_size;
		
		$client_full = file_get_contents('/home/chaitosoft/customclient.chaitosoft.com/versions/1144.exe');
		echo "</br>";
		echo strlen($client_full);
		echo "</br>";
		#echo strpos($client_full, "XXXXXX");
		$result = $ip_size - $orig_size;
		

		if($result < 0) { #COMPLETAR CARACTERES
			$i = 6;
			for($x=0; $x < abs($result)+$i; $x++) {
				$string .= chr('00');
			}
			str_replace("XXXXXX", $string, $client_full);
			str_replace($orig_url, $url, $client_full);
		}
		else if($result < 6) { //REMOVER CARACTERES
			for($i=0; $i < abs($result); $i++) {
				$string .= chr('00');
			}
			str_replace("XXXXXX", $string, $client_full);
			str_replace($orig_url, $url, $client_full);
		}
		
		$new_file = @fopen('/home/chaitosoft/customclient.chaitosoft.com/versions/tibia-'.$ip.'.exe', 'a+');
		fwrite($new_file, $client_full);
		fclose($new_file);
		download_file('/home/chaitosoft/customclient.chaitosoft.com/versions/tibia-'.$ip.'.exe');
    }
	
	function gen_old_files($version, $ip) {
		$info_client = get_data(null_insert($ip), $version);
		#var_dump($info_client);
		#echo getcwd();
		// Creating new client
		$client_full = file_get_contents('/home/chaitosoft/customclient.chaitosoft.com/versions/'.$version.'.exe');
		#echo strlen($client_full);
		$data = str_replac($info_client, $client_full);
		$new_file = @fopen('/home/chaitosoft/customclient.chaitosoft.com/versions/tibia-'.$ip.'.exe', 'a+');
		fwrite($new_file, $data);
		fclose($new_file);
		// Path to new file
		$DIR = '/home/chaitosoft/customclient.chaitosoft.com/versions/tibia-'.$ip.'.exe';
		// Opening download with client browser
		download_file($DIR);
	}
	
	// FUNCTION DOWNLOAD
    function download_file($dir_file) {
        if (!file_exists($dir_file)) {
            echo "[ERRO] falha na geração de arquivo, tente novamente.";
            exit;
        }
        // Configuramos os headers que serão enviados para o browser
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="Tibia.exe"');
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($dir_file));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Expires: 0');
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        ob_flush();
        // Envia o arquivo para o cliente
        readfile($dir_file);
        //deleta o arquivo do servidor
        unlink($dir_file);
    }



?>

