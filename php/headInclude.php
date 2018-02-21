<?php
$urlPadding = './';
if(basename(realpath("./")) === 'php') {
	$urlPadding = '../';
}
$absoluteURL = 'http://pawapro-simu.com/' . (basename(realpath("./")) === 'php' ? 'php/' . basename($_SERVER['PHP_SELF']) : '');
?>

<meta charset="UTF-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=yes">
<meta name="author" content="Yukihiro Hitsujikai">
<meta name="description" content="<?= $description ?>">
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@hitsujiPawapro" />
<meta name="og:url" content="<?= $absoluteURL ?>" />
<meta name="og:title" content="<?= $title ?>" />
<meta name="og:description" content="<?= $description ?>" />
<meta name="og:image" content="http://pawapro-simu.com/img/thumbnail.jpg" />
<title><?= $title ?></title>
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
<!-- Google Analytics -->
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
							})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-89444607-2', 'auto');
	ga('send', 'pageview');
</script>
<!-- End Google Analytics -->
