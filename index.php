<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Gerenciador de Corridas</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="icon" type="image/png" href="images/favicon.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container container-fluid col-md-10 col-md-offset-1 col-xs-12">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar1">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="./" style="padding:10px;"><img src="images/brand.png" width="30px" height="30px"></a>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar1">
                        <ul class="nav navbar-nav">
                            <li id="motoristas"><a href="./?page=motoristas">Motoristas</a></li>
                            <li id="passageiros"><a href="./?page=passageiros">Passageiros</a></li>
                            <li id="corridas"><a href="./?page=corridas">Corridas</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container col-xs-12" id="content">
                <?php                    
                    require_once("php_scripts/setup.php");
                    $db = new mysqli(DB_HOST, DB_LOGIN, DB_PASSWD, DB_NAME);                    
                    $db->query("SET NAMES 'utf8'");
                    if (isset($_GET["page"])) {
                        $page = $_GET["page"];
                        if ($page == "motoristas") {
                            include("pages/motoristas.php");
                        } else if ($page == "passageiros") {
                            include("pages/passageiros.php");
                        } else if ($page == "corridas") {
                            include("pages/corridas.php");
                        } else {
                            include("pages/error.php");
                        }
                    } else {
                        include("pages/main.php");
                    }
                ?>
            </div>
        </div>
    </body>
</html>