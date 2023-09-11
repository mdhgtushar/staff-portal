<?php namespace ProcessWire;

/**
 * ProcessWire Form Builder Template File
 *
 * This template file handles display of a form within an iframe, for embed
 * options A and B. It corresponds with template 'form-builder' in ProcessWire.
 *
 * This template file should be placed in /site/templates/form-builder.php
 *
 */

/** @var FormBuilder $forms */
/** @var FormBuilderForm $form */
/** @var Page $page */

if(!defined("PROCESSWIRE")) die();

?><!DOCTYPE html>
<html lang="<?php echo __('en', __FILE__); // HTML tag lang attribute
	/* this intentionally on a separate line */ ?>"> 
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex, nofollow" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title><?php echo $page->title; ?></title>
	<?php
	$forms->setTemplateVersion(2); 
	$form = $forms->getFromURL(true);
	if(is_object($form)) {
		echo $form->styles;
		echo $form->scripts;
	}
	?>
	
</head>
<body>
	<div id="content" class="pw-content content">
		<div class="pw-container container">
			<?php echo $form; ?>
		</div>
	</div>
</body>
</html>
