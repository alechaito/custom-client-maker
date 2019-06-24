<?php 
ob_start(); 
include_once("versions/libclient.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChaitoSoft - Custom Client</title>
    <link rel="shortcut icon" href="images/icons/favicon.png" />
    <link href='http://fonts.googleapis.com/css?family=Hind:400,300,600,500,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    <!-- Bootstrap & Styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link href="css/block_grid_bootstrap.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet" />
    <link href="css/jquery.circliful.css" rel="stylesheet" />
    <link href="css/slicknav.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <!-- Breadcrumps -->
    <div class="breadcrumbs">
        <div class="row">
            <div class="col-sm-12">
                <h1>Fabrica de Client - Atualizado e testado em: 18/06/19</h1>
            </div>
        </div>
    </div>

    <!-- End of Breadcrumps -->


     <!-- Formulario de Criacao -->
     <section class="shared-features">
        <div class="row-center">
            <div class="col-sm-4">
                <center>
                <p>Bem vindo a fábrica de <b>client próprio</b>, somente <b>Windows</b>, nosso sistema altera apenas o IP do servidor mantendo as imagens do client padrao de fundo.<p></br>
                </br>
				<p><b>Aviso:</b> O arquivo baixado e apenas o executavel, voce precisa baixar a versao de tibia correspondente e adicionar o arquivo baixado na 
				devida pasta.</br></br>
				<a href="https://i.imgur.com/nbOgl1E.png" target="_blank">Clique aqui para ver um exemplo de pasta</a>
				</p>
				</br>
				<p>
					O client 11.44 e compativel com o projeto 
					<a href="https://github.com/opentibiabr/OTServBR-Global/tree/master/" target="_blank">
						OTServBR-Global
					</a>
				</p>
                </center>
            </div>
            <div class="col-sm-4" style="background-color:#CCCCCC; border:1px solid #454545;">
                <center>
				</br>
                <form method="post">
                    <label>Endereço IP (max. 17 caracteres)</label></br>
                    <input type="text" name="ip_address"></br></br>
                    <label>Versao</label></br>
                    <select name="version_client">
						<option value="854">8.54</option>
                        <option value="860">8.60</option>
                        <option value="1096">10.96</option>
                        <option value="1098">10.98</option>
                        <option value="1144">11.44</option>
                    </select></br></br>
                    <input type="submit" value="Fabricar Cliente" name="create_client">
                </form>
				</br>
				Fale com nossos especialistas no Whatsapp: <b>(13) 99125-0550</b>
				</center>
            </div>
            <div class="col-sm-4">
                    <center>
					<h2>Apoiado por:</h2>
                    <a href="http://otmanager.com.br/" target="_blank">
					<img style="margin-top:20px;" src="http://i.imgur.com/tCnfAin.gif"/>
					</a>
                    </center>
            </div>
        </div>
    </section>
    

    <!-- FOOTER -->

    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    <script src="js/jquery.min.js"></script>
    <script src="js/hoverIntent.js"></script>
    <script src="js/superfish.min.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/jquery.circliful.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.responsiveTabs.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script src="js/retina.min.js"></script>
    <script src="js/custom.js"></script>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip(); 
        });
    </script>


</body>

</html>

<?php
    //-------------//
    if(isset($_POST['create_client'])) {
        //declaracao de variaveis
        $ip  = $_POST['ip_address'];
        $version = $_POST['version_client'];
        $error = 0;

        //verificando valores nulos nos campos
        if (!empty($_POST) && (empty($ip) || empty($version))) {
            echo "[ERRO] insira algum valor nos campos.</br>";
            $error = 1;
        }
        //verificando tamanho do post
        if (strlen($ip) >= 18) {
            echo "[ERRO] limite maximo de caracteres excedidos.</br>";
            $error = 1;
        }
        if ($error == 0) {
            if($version == '1144') {
                gen_new_files($ip);
            }
            else {
                gen_old_files($version, $ip);
            }
        }
    }

    
?>
