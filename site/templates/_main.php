<?php

namespace ProcessWire;

// Optional main output file, called after rendering page’s template file. 
// This is defined by $config->appendTemplateFile in /site/config.php, and
// is typically used to define and output markup common among most pages.
// 	
// When the Markup Regions feature is used, template files can prepend, append,
// replace or delete any element defined here that has an "id" attribute. 
// https://processwire.com/docs/front-end/output/markup-regions/

/** @var Page $page */
/** @var Pages $pages */
/** @var Config $config */

$home = $pages->get('/');
/** @var HomePage $home */
// logout user when "?logout=1" in URL query string
if ($input->get('logout')) {
	$session->logout();
	// good to redirect somewhere else after a login or logout
	$session->redirect($home->url);
}
?>
<!DOCTYPE html>
<html lang="en">

<head id="html-head">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $page->title; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $config->urls->templates; ?>styles/main.css" />
	<script src="<?php echo $config->urls->templates; ?>scripts/main.js"></script>
	<!-- up to 10% speed up for external res -->
	<link rel="dns-prefetch" href="https://fonts.googleapis.com/">
	<link rel="dns-prefetch" href="https://fonts.gstatic.com/">
	<link rel="preconnect" href="https://fonts.googleapis.com/">
	<link rel="preconnect" href="https://fonts.gstatic.com/">
	<!-- preloading icon font is helping to speed up a little bit -->
	<link rel="preload" href="<?php echo $config->urls->templates; ?>assets/fonts/flaticon/Flaticon.woff2" as="font" type="font/woff2" crossorigin>

	<link rel="stylesheet" href="<?php echo $config->urls->templates; ?>assets/css/core.min.css">
	<link rel="stylesheet" href="<?php echo $config->urls->templates; ?>assets/css/vendor_bundle.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet">

	<!-- favicon -->
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="apple-touch-icon" href="demo.files/logo/icon_512x512.png">

</head>

<body id="html-body">

	<!-- <p id="topnav">
		<?php echo $home->and($home->children)->implode(" / ", "<a href='{url}'>{title}</a>"); ?>
	</p> -->

	<!-- 
	<h1 id="headline">
		<?php if ($page->parents->count()) : // breadcrumbs 
		?>
			<?php echo $page->parents->implode(" &gt; ", "<a href='{url}'>{title}</a>"); ?> &gt;
		<?php endif; ?>
		<?php echo $page->title; // headline 
		?>
	</h1> -->

	<div id="content">
		Default content
	</div>

	<!-- <?php if ($page->hasChildren) : ?>
		<ul>
			<?php echo $page->children->each("<li><a href='{url}'>{title}</a></li>"); // subnav 
			?>
		</ul>
	<?php endif; ?> -->

	<!-- <?php if ($page->editable()) : ?>
		<p><a href='<?php echo $page->editUrl(); ?>'>Edit this page</a></p>
	<?php endif; ?> -->

	<script src="<?php echo $config->urls->templates; ?>assets/js/core.min.js"></script>
	<script src="<?php echo $config->urls->templates; ?>assets/js/vendor_bundle.min.js"></script>

</body>

</html>