<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>D&J </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/fontawesome-free-6.1.1-web/css/all.min.css">
    <!-- CSS Files -->
    <link href="templetes/light-bootstrap-dashboard/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="templetes/light-bootstrap-dashboard/assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="templetes/light-bootstrap-dashboard/assets/css/demo.css" rel="stylesheet" />
    <link href="css/sweet-alert/sweetalert2.min.css"rel="stylesheet" />
    <script src="js/sweet-alert/sweetalert2.min.js" defer></script>
    <script src="js/sweet-alert/sweetalert.Customized.js" defer></script>
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        .button {
            padding: 7px 10px;
            color: white;
            border-radius: 10px;
        }

        .editar {
            background: var(--cor-prim);
        }

        .apagar {
            background: red;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar" data-image="templetes/light-bootstrap-dashboard/assets/img/sidebar-5.jpg">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="dashboard.php"" class="simple-text">
                        <div id="logo"></div>
                    </a>
                </div>
                <ul class="nav">
                    <li>
                        <a class="nav-link" href="dashboard.php">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Cadastrar Cliente</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./listas.php">
                            <i class="nc-icon nc-notes"></i>
                            <p>Lista de Cliente</p>
                        </a>
                    </li>
                    
                    <li>
                        <a class="nav-link" href="./user.php">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Gerênciar Usuário</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>