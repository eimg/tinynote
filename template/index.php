<!DOCTYPE html>
<html>
<head lang="en-US">
	<meta charset="utf-8">
	<title>TinyNote - Take note on the go</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">

	<?= include_css("bootstrap.css") ?>
	<?= include_css("bootstrap-wysihtml5.css") ?>
	<?= include_css("style.css") ?>

	<?= "<script>var PATH = '{$config["path"]}';</script>" ?>
</head>
<body>
	<div class="container-narrow">

		<div class="masthead">
			<? if(is_auth()): ?>
			<ul class="nav nav-pills pull-right">
				<li class="<?= $controller=="home"?"active":"" ?>">
					<?= link_to("home", "Home") ?>
				</li>
				<li class="<?= $controller=="user"?"active":"" ?>">
					<?= link_to("user/account", "Account") ?>
				</li>
				<li><?= link_to("user/signout", "Sign out") ?></li>
			</ul>
			<? endif; ?>
			<h1 class="project muted">TinyNote</h1>
		</div>

		<hr>

		<? include $template ?>

		<hr>

		<div class="footer">
			<p class="muted">
				&copy; 2012 TinyNote. An example app created with
				<a href="https://github.com/eimg/tinymvc">TinyMVC</a>.
			</p>
		</div>

	</div> <!-- /container -->

	<?= include_js("jquery.js") ?>
	<?= include_js("jquery.validate.js") ?>
	<?= include_js("jquery.glow.js") ?>

	<?= include_js("bootstrap.js") ?>
	<?= include_js("wysihtml5.js") ?>
	<?= include_js("bootstrap-wysihtml5.js") ?>

	<?= include_js("app.js") ?>
</body>
</html>