<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Marcus A. G. Maia" />
		<meta name="subject" content="" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="language" content="pt-br" />
		<meta name="copyright" content="" />
		<meta name="distribution" content="Global" />
		<meta name="robots" content="All" />

		<title><?php echo $this->title ?></title>

		<?php
			$this->addCSS('bootstrap.green.min.css');
			//$this->addCss('bootstrap-theme.min.css');
			$this->addCss('icons.css');
			$this->addCss('framework.css');
			$this->addCss('css.css');
			echo $this->getCss();
		?>
		<!-- Just for debugging purposes. Don't actually copy this line! -->
		<!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Framework Tools</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li><a href="<?php echo UrlMaker::toAction('index') ?>"><span class="ftools-desktop"></span> Servers</a></li>
						<li><a href="<?php echo UrlMaker::toAction('projects') ?>"><span class="ftools-code"></span> Projects</a></li>
						<li><a href="<?php echo UrlMaker::toAction('update') ?>"><span class="ftools-update"></span> Update</a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right">
						<li><a href="<?php echo UrlMaker::toAction('backup') ?>"><span class="ftools-help"></span> Help</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="container">
			<?php echo $this->content; ?>
		</div>

		<?php
			$this->addJs('jquery.js');
			$this->addJs('jquery.cookie.js');
			$this->addJs('jquery.validate.js');
			$this->addJs('jquery.mask.js');
			$this->addJs('jquery.form.js');
			$this->addJs('jquery.modalwindow.js');
			$this->addJs('bootstrap.min.js');
			$this->addJs('framework.js');
			$this->addJs('tools.js');
			echo $this->getJs();
		?>
	</body>
</html>