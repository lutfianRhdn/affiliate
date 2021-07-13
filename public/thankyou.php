<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Thanks | Affiliate</title>
    <link rel="apple-touch-icon" sizes="76x76" href="/material/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/material/img/favicon.png">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="/material/css/material-font-icon.css" />
    <!-- CSS Files -->
    <link href="/material/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />


</head>

<body class="off-canvas-sidebar">
    <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('img/background.png'); background-size: cover; background-position: top center;align-items: center;" data-color="purple">
        <div class="container">
            <div class="row align-items-center  my-auto justify-content-center" style="height:100vh">
                <div class="col-md-9  text-center ">
                    <?php
                    if (isset($_GET['st'])) {
                        if ($_GET['st'] == 0) {
                    ?>
                            <h1><span class="text-primary">Thank</span> You</h1>
                            <h3><?= isset($_GET['res']) ?$_GET['res'] :'' ?></h3>
                        <?php
                        } elseif ($_GET['st'] == 1) {
                        ?>
                            <h1><span class="text-primary">Activation</span> Failed</h1>
                            <h3><?= isset($_GET['res']) ?$_GET['res'] :'' ?></h3>
                            <?php
                        }else{
                            echo 'status invalid';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>