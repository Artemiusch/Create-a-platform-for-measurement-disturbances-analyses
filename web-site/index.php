<?php
function getConfig(){
    $fp = fopen ('config.txt',"r");
    $rows = [];
    while ($data = fgetcsv($fp, 262144, "\n", '"') ) {
        $rows[]=$data[0];
    }
    fclose ($fp);   
    return $rows;
}
function setConfig($rows){
    $fp = fopen ('config.txt',"w");
    $str = '';
    foreach ($rows as $row) {
        $str .= trim($row)."\n";
    }
    fwrite($fp, $str);
    fclose ($fp);   
}
ini_set('max_execution_time', '0');
?>
<!DOCTYPE html>
<html>
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>Opracowanie płatformy symulacyjnej do analizowania zakłóceń pomiarowych</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="images/favicon.ico">

        <!-- Stylesheets -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/styles.css">

        <!-- JQuery JavaScript -->
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <!-- Boostrap JavaScript -->
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
    </head>
    <body class="page-home">
        <section class="page-wrap">
            <header class="header-sec">
                <div class="navbar navbar-expand-lg navbar-light">
                    <div class="container d-flex justify-content-between">
                        <a class="navbar-brand" href="index.php">
                            <img src="images/logo.png">
                        </a>

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myNavbar" aria-controls="myNavbar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="myNavbar">
                            <ul class="navbar-nav ml-lg-auto">
                                <li class="nav-item">
                                    <a class="nav-link <?php if($_GET['p'] == '') { echo 'active'; }?>" href="index.php">Główna</a>
                                </li>     
                                <li class="nav-item">
                                    <a class="nav-link <?php if($_GET['p'] == '1') { echo 'active'; }?>" href="index.php?p=1">Teoria</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($_GET['p'] == '2') { echo 'active'; }?>" href="index.php?p=2">Symulacja</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($_GET['p'] == '3') { echo 'active'; }?>" href="index.php?p=3">Pomiary rzeczywiste</a>
                                </li>   
                                <li class="nav-item">
                                    <a class="nav-link <?php if($_GET['p'] == '4') { echo 'active'; }?>" href="index.php?p=4">Ustawienia</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>
            <main role="main" class="<?php echo $span; ?> container py-4">
                <div class="row">
                    <div class="title-col col-12 text-center mb-2">
                        <?php if ($_GET['p'] == '') { ?>
                            <h2>Opracowanie płatformy symulacyjnej do analizowania zakłóceń pomiarowych</h2>
                        <?php } else if ($_GET['p'] == '1') {?>
                            <h2>Teoria</h2>
                        <?php } else if ($_GET['p'] == '2') {?>
                            <h2>Symulacja</h2>
                        <?php } else if ($_GET['p'] == '3') {?>
                            <h2>Pomiary rzeczywiste</h2>
                        <?php } else {?>
                            <h2>Ustawienia</h2>
                        <?php } ?>
                        
                    </div>
                </div>

                <div class="row">
                    <div class="content-col col-12 py-2">
                        <?php $p=(isset($_GET['p']))?$_GET['p']:''; include dirname(__FILE__)."/page".$p.'.php'; ?>
                    </div>
                </div>
            </main>
            <footer class="footer-sec">
                <div class="container">
                    <p class="text-center text-dark my-2">
                        Artem Melnyk &copy; <?php echo date('Y'); ?> 
                    </p>
                </div>
            </footer>
        </section>

    </body>
</html>
