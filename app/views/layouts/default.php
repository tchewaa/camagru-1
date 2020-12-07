<?php
use Core\Session;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?=$this->siteTitle(); ?></title>
    <link type="text/css" rel="stylesheet" href="<?=PROOT?>css/bootstrap.min.css" media="screen" title="no title" charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="<?=PROOT?>css/custom.css" media="screen" title="no title" charset="UTF-8">
    <!-- TODO delete this, this the PDF states that no javascript framework are allowed   -->
    <script type="text/javascript" src="<?=PROOT?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=PROOT?>js/jQuery-2.2.4.min.js"></script>
    <?= $this->content('head'); ?>
</head>
<body>
    <?php include( 'main_menu.php'); ?>
    <div class="container-fluid" style="min-height:cal(100% - 125px);" >
        <?= Session::displayMessage()?>
        <div id="load-spinner"></div>
        <?= $this->content('body'); ?>
    </div>
    <?php include('footer.php'); ?>
</body>
<script type="text/javascript" src="<?=PROOT?>js/custom.js"></script>
</html>