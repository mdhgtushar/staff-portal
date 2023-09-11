<?php

/**
 * FormBuilder render file (embed method D) for form 'test_form'
 * 
 * Instructions
 * ============
 * 
 * 1. If not already in place, the contents of this file should be placed in this file:
 * 
 *    /site/templates/FormBuilder/form-test_form.php
 * 
 *    When present, FormBuilder will always use this file for $forms->render('test_form'); calls, rather than 
 *    the markup that it generates at runtime.
 * 
 * 2. Move the indicated stylesheet <link> tags further-below to your document <head>, to appear when this form
 *    is rendered. You may optionally omit any or all of the stylesheets if you don't think you will need them. 
 *    In particular, remove any that duplicate stylesheets you may already be loading (like from CSS frameworks).
 * 
 * 3. Also move the indicated Javascript <script> tags below to your <head> or before closing the </body> tag,
 *    to appear when this form will be rendered. You may optionally omit any of the scripts if you don't think 
 *    you will need them. In particular, remove any that duplicate scripts you may already be loading (like jQuery 
 *    or CSS framework files). We recommend that you always keep the 'form-builder-d.js' script in place.
 * 
 * 4. Adjust the form markup below as you see fit. Keep the form field 'name' attributes in tact. Please note that
 *    removing any 'id' or 'class' attributes (or other significant changes to the markup) may interfere with or
 *    disable features provided by FormBuilder for a given field. So be sure to test any changes thoroughly.
 * 
 * 5. To render this form, place the following in a template file where you want the form to appear: 
 * 
 *    echo $forms->render('test_form'); 
 * 
 * Optional: Steps 2 and 3 above ask you copy <link> and <script> tags in your document <head>. We recommend that 
 * you surround them in something like if($page->id == 123) { ... }, so that you are only rendering these assets 
 * on the page where the form will be displayed (where '123' is the ID of the page).
 * 
 * Please leave the following here
 * ===============================
 * Date: 2023-09-11 23:28:12
 * Hash: 01227edc3bdbaee7ce4f737dd140615e
 * 
 * If you get want to disable an 'out of date' warning from FormBuilder for this file, copy the 'Hash' (like seen 
 * above) from the /site/assets/cache/FormBuilder/form-test_form.php file, and paste to make it replace the hash 
 * value that you see above. We also recommend you update the 'Date' for your own reference.
 * 
 * 
 * Variables provided to this template
 * ===================================
 * @var InputfieldForm $form Form that is being rendered or processed
 * @var FormBuilderProcessor $processor Processor of form
 * @var array $values Existing values of field inputs, indexed by field name
 * @var array $labels Field labels indexed by field name
 * @var array $descriptions Field descriptions indexed by field name
 * @var array $notes Field notes indexed by field name
 * @var array $errors Error messages to display (populated if form had errors)
 * @var bool $submitted This is TRUE when the form has been successfully submitted
 * @var string $successMessage The success message defined with the form (populated on success)
 * @var string $submitKey Unique hidden field value FormBuilder uses to detect valid form submission
 *
 */
?>

<!-- Move styles below to document <head> for pages where this form will appear -->
<link rel='stylesheet' type='text/css' href='<?php echo $config->urls->root; ?>site/modules/FormBuilder/FormBuilder.css' />
<link rel='stylesheet' type='text/css' href='<?php echo $config->urls->root; ?>site/modules/FormBuilder/frameworks/basic/main.css' />
<link rel='stylesheet' type='text/css' href='<?php echo $config->urls->root; ?>wire/modules/Inputfield/InputfieldCheckbox/InputfieldCheckbox.css' />
<link rel='stylesheet' type='text/css' href='<?php echo $config->urls->root; ?>wire/modules/Inputfield/InputfieldDatetime/InputfieldDatetime.css' />
<style type='text/css'> /* Optional responsive adjustments for mobile - can be removed if not using 'Column Width' for fields */ @media only screen and (max-width:479px){.InputfieldFormWidths .Inputfield{clear:both !important;width:100% !important;margin-left:0 !important;margin-bottom:1em !important;} .Inputfield .InputfieldContent,.Inputfield .InputfieldHeader{padding-left:0 !important;padding-right:0 !important;float:none !important;width:100%;} .InputfieldFormWidths .Inputfield .InputfieldHeader{margin-bottom:0;}.InputfieldFormNoWidths .Inputfield .InputfieldHeader{text-align:initial;}}</style>

<!-- Move scripts below to document <head> or before </body> for pages where this form will appear -->
<script type="text/javascript">var _pwfb={ config:<?php echo json_encode(array_merge($config->js(),array("urls"=>array("root"=>$config->urls->root),"debug" => $config->debug)));?>};if(typeof ProcessWire=="undefined"){var ProcessWire=_pwfb;}else{for(var _pwfbkey in _pwfb.config) ProcessWire.config[_pwfbkey] = _pwfb.config[_pwfbkey];}if(typeof config=="undefined"){var config=ProcessWire.config;}_pwfb=null;</script>
<script src='<?php echo $config->urls->root; ?>wire/modules/Jquery/JqueryCore/dev/JqueryCore.js.6.4'></script>
<script src='<?php echo $config->urls->root; ?>wire/modules/Jquery/JqueryCore/dev/jquery-migrate-quiet-3.4.0.min.js'></script>
<script src='<?php echo $config->urls->root; ?>wire/modules/Inputfield/InputfieldDatetime/InputfieldDatetime.js'></script>
<script src='<?php echo $config->urls->root; ?>wire/templates-admin/scripts/inputfields.min.js'></script>
<!-- This next script (form-builder-d.js) must go either in the document head or somewhere before the <form> -->
<script src='<?php echo $config->urls->FormBuilder; ?>form-builder-d.js'></script>

<?php if($submitted): /* When form submitted, show success message */ ?>

	<div id="FormBuilderSubmitted">
		<h3><?php echo $successMessage; ?></h3>
	</div>

<?php else: /* Render the form markup */ ?>

<form class="FormBuilderFrameworkBasic FormBuilder InputfieldNoFocus InputfieldFormWidths InputfieldForm" id="FormBuilder_test_form" name="test_form" method="post" action="./" data-colspacing="0">

	<?php 
	// output error messages
	if(count($errors)) {
		$form->getErrors(true); // reset
		foreach($errors as $error) {
			echo '<p class="error">' . $error . '</p>';
		}
	}
	?>

	<div class="Inputfields">
		<div class="Inputfield Inputfield_checkbox_test InputfieldCheckbox" id="wrap_Inputfield_checkbox_test">
			<label class="InputfieldHeader" for="">
				<?php echo $labels['checkbox_test']; ?><!-- Checkbox Test -->
			</label>
			<div class="InputfieldContent">
				<p class="description"><?php echo $descriptions['checkbox_test']; ?></p>
				<label>
					<input type="checkbox" id="Inputfield_checkbox_test" name="checkbox_test" value="1" />
					<span class="pw-no-select"><?php echo $labels['checkbox_test']; ?><!-- Checkbox Test --></span>
				</label>
			</div>
		</div>
		<div class="Inputfield Inputfield_date_time InputfieldDatetime InputfieldNoFocus" id="wrap_Inputfield_date_time">
			<label class="InputfieldHeader" for="Inputfield_date_time">
				<?php echo $labels['date_time']; ?><!-- Date Time -->
			</label>
			<div class="InputfieldContent">
				<p class="description"><?php echo $descriptions['date_time']; ?></p>
				<input id="Inputfield_date_time" name="date_time" type="text" size="25" value="" autocomplete="off" data-dateformat="yy-mm-dd" data-timeformat="" data-timeselect="0" data-ts="0" data-ampm="1" />
			</div>
		</div>
		<div class="Inputfield Inputfield_test_form_submit InputfieldSubmit" id="wrap_test_form_submit">
			<div class="InputfieldContent">
				<button type="submit" name="test_form_submit" value="<?php echo $labels['test_form_submit']; ?><!-- Submit -->">
					<?php echo $labels['test_form_submit']; ?><!-- Submit -->
				</button>
			</div>
		</div>
	</div>
	<?php echo $session->CSRF->renderInput(); ?>
	<input type="hidden" name="_submitKey" value="3:test_form:fu67lkeHPajk5o82Y7I8ok1:23501" />
	<input type="hidden" name="_InputfieldForm" value="test_form" />
</form>

<?php 
if(count($values)) {
	// populate existing values to fields
	echo "<script>FormBuilderD.populate('$form->id', " . json_encode($values) . ");</script>";
}

endif;
?>