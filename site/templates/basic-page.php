<?php

namespace ProcessWire;

// Template file for pages using the “basic-page” template

?>


<div id="content">
	<div class="jumbotron">
		<h1>404 not found!</h1>
		<p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet.</p>
		<p><a class="btn btn-lg btn-success" href="<?php echo  $pages->get('/')->url; ?>" role="button">Go to staff portal</a></p>
	</div>
</div>