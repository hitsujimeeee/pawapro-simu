<?php
$urlPadding = '../';
if(basename(realpath("./")) === 'pawapro') {
	$urlPadding = './';
}

$url = 'http://pawapro-simu.com/';
if(basename(realpath("./")) === 'php') {
	$url .= 'php/' . basename($_SERVER['REQUEST_URI']);
}

?>

<meta charset="UTF-8">
<meta name="author" content="Yukihiro Hitsujikai">
<meta name="robots" content="noindex">
<meta name="description" content="<?php echo $description ?>">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=yes">
<title><?php echo $title ?></title>
<link rel="canonical" href="<?= $url ?>">
<link rel="shortcut icon" href="<?php echo $urlPadding ?>img/icon.ico" type="image/vnd.microsoft.icon">
<link rel="stylesheet" href="<?php echo $urlPadding ?>css/lib/jquery-ui.min.css?ver20171016">
<link rel="stylesheet" href="<?php echo $urlPadding ?>css/lib/jquery.ui.labeledslider.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $urlPadding ?>css/lib/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $urlPadding ?>css/lib/remodal.css">
<link rel="stylesheet" href="<?php echo $urlPadding ?>css/lib/remodal-default-theme.css">
<link rel="stylesheet" href="<?php echo $urlPadding ?>css/common.css?ver20170917">
<link rel="stylesheet" href="<?php echo $urlPadding ?>css/optionMenu.css">
<link rel="stylesheet" href="<?php echo $urlPadding ?>css/bootstrap_custom.css">
<script src="<?php echo $urlPadding ?>js/plugin/jquery-3.1.1.min.js"></script>
<script src="<?php echo $urlPadding ?>js/plugin/jquery-ui.min.js?ver20171016"></script>
<script src="<?php echo $urlPadding ?>js/plugin/jquery.ui.labeledslider.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="<?php echo $urlPadding ?>js/plugin/remodal.min.js"></script>
<script src="<?php echo $urlPadding ?>js/plugin/jquery.blockUI.js"></script>
<script src="<?php echo $urlPadding ?>js/optionMenu.js"></script>
