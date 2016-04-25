<?php echo <<<EOF
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="" />
	<meta name="subject" content="" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="language" content="pt-br" />
	<meta name="copyright" content="" />
	<meta name="distribution" content="Global" />
	<meta name="robots" content="All" />

	<title><?php echo \$this->title ?></title>

	<?php
		\$this->addCSS('bootstrap.min.css');
		\$this->addCss('bootstrap-theme.min.css');
		\$this->addCss('font-awesome.min.css');
		\$this->addCss('framework.css');
		\$this->addCss('css.css');
		echo \$this->getCss();
	?>
</head>
<body>
	<div id="page">
		<div class="navbar navbar-default" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="<?php echo UrlMaker::toAction( 'index' ) ?>"><?php echo \$this->_app->getAppName() ?></a>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="col-md-3">
				<ul class="nav nav-pills nav-stacked">

EOF;

foreach ( $modules as $module ) {
	$moduleName = new String( $module );
	$moduleName->humanize();
	echo "\t\t\t\t\t<li><a href=\"<?php echo UrlMaker::toAction( '$module' ) ?>\">$moduleName</a>\n";
}

echo <<<EOF
				</ul>
			</div>

			<div class="col-md-9">

				<?php echo \$this->content; ?>

			</div>
		</div>

		<div id="footer">
			<div class="container">
				<p class="text-muted"><?php echo \$this->_app->getAppName() ?> v<?php echo \$this->_app->getAppVersion() ?> &copy; All rights reserved</p>
			</div>
		</div>
	</div>

	<?php
		\$this->addJs('jquery.js');
		\$this->addJs('jquery.cookie.js');
		\$this->addJs('jquery.validate.js');
		\$this->addJs('jquery.mask.js');
		\$this->addJs('jquery.form.js');
		\$this->addJs('jquery.modalwindow.js');
		\$this->addJs('bootstrap.min.js');
		\$this->addJs('grid.js');
		\$this->addJs('framework.js');
		echo \$this->getJs();
	?>
</body>
</html>
EOF;
?>