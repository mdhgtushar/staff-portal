<?php

namespace ProcessWire;

// Template file for “home” template used by the homepage
// Check User is allready loggedin or not, Login user can't see this page
if ($user->isLoggedin() && !$input->get('profile') && !$input->get('logout')) {
    $session->redirect($pages->get("/")->url);
}
?>

<div id="content">
    <style>
        .Inputfield {
            background: transparent !important;
            padding: 0;
            margin: 0;
        }
    </style>
    <?php
    $wire->addHookBefore('Inputfield::render', function ($event) {
        $inputfield = $event->object;

        if ($inputfield instanceof InputfieldTextarea) {
            // textarea input
            $inputfield->addClass('form-control');
        } else if ($inputfield instanceof InputfieldText) {
            // includes most single-line text types 
            $inputfield->addClass('form-control');
        } else if ($inputfield instanceof InputfieldSubmit) {
            // submit button
            $inputfield->addClass('btn btn-primary');
        }
    });
    ?>
    <div class="row g-0 bg-white min-vh-100 align-items-center">
        <div class="col-lg-6 text-center text-lg-start overflow-hidden z-index-2">
            <div class="px-3 py-6">

                <!-- back button -->
                <a href="<?php echo $pages->get("/")->url ?>" class="link-muted position-absolute top-0 start-0 p-2 d-inline-grid gap-auto-2">
                    <svg class="rtl-flip" height="18px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                    </svg>
                    <span>back to homepage</span>
                </a>

                <div class="row">
                    <div class="col-sm-8 col-md-6 col-lg-9 col-xl-12 mx-auto max-w-450">
                        <?= $modules->get('LoginRegister')->execute() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-none d-lg-block min-vh-100 col-lg-6 bg-cover py-8 overlay-dark overlay-opacity-25" style="background-image:url(<?php echo $config->urls->templates; ?>assets/images/Servers22-1.jpg)">
            <svg class="d-none d-lg-block position-absolute h-100 top-0 text-white ms-n5" style="width:6rem" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon points="50,0 100,0 50,100 0,100"></polygon>
            </svg>
        </div>
    </div>
</div>