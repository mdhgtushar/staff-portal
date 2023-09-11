<?php

namespace ProcessWire;

// Template file for “home” template used by the homepage
// Template file for “home” template used by the homepage
if (!$user->isLoggedin()) {
    $session->redirect($pages->get("/profile/login")->url);
}
?>


<div id="content">

    <?php include('./inc/staff_header.php'); ?>
    <div class="container">
        <?php

        $get_user_entry = $pages->get("/forms/generator-portal/")->hasChildren("user_id=$user->id");



        if ($get_user_entry) {
            if (isset($_POST['submit'])) {

                $description = stripslashes($_POST['description']);
                $p = new Page();
                $p->setOutputFormatting(false);
                $p->template = 'generator_portal_data';
                $p->parent = wire('pages')->get("template=generator_portal_form, user_id=$user->id");
                $p->user_id = $user->id;

                $p->date = date("Y-m-d", strtotime($_POST['date_select']));
                $p->short_description = $description;
                $p->title =  $user->name . "  -  " . date("d-m-Y H:i:s");
                $p->save();

        ?>
                <div class="alert alert-success" role="alert">
                    <?php echo "page ID {$p->id} created!<br>"; ?>
                </div>
        <?php
            }
        } else {
            $p = new Page();
            $p->setOutputFormatting(false);
            $p->template = 'generator_portal_form';
            $p->parent = wire('pages')->get('/forms/generator-portal/');
            $p->user_id = $user->id;
            $p->title = $user->name;
            $p->save();
        }
        ?>
        <div class="card my-4">
            <div class="card-body p-4">

                <div class="mb-4">
                    <h2 class="h4 mb-0"><?php echo $page->title ?></h2>
                    <small class="fw-bold"><?php echo $page->short_description ?></small>
                </div>

                <div class="row">

                    <div class="col-12 mb-4 border-top border-light d-lg-none"><!-- mobile separator --></div>

                    <div class="col-lg-6">

                        <div class="d-flex align-items-center">

                            <span class="flex-none">
                                <svg class="text-gray-600" width="58px" height="58px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"></path>
                                    <path fill-rule="evenodd" d="M9.5 1h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3zm4.354 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"></path>
                                </svg>
                            </span>

                            <div class="w-100 ps-3">
                                <strong class="d-block">
                                    <?php
                                    // echo $pages->find("template=generator_portal_data,  user_id=$user->id")->count();
                                    ?>
                                    <!-- Entry By You -->
                                </strong>
                                <a href="<?php echo $pages->get("/form-page/generator-portal-list/")->url ?>" class="text-decoration-none small">view entries</a>
                            </div>

                        </div>

                    </div>


                </div>

            </div>
        </div>
        <?php if (!$user->hasRole('superuser')) { ?>
            <div class="card mb-4 shadow-primary-xs border-0">
                <div class="card-body p-4">

                    <h2 class="h4 mb-4">
                        Generator <strong class="text-primary">Portal</strong>
                    </h2>
                    <?php echo $forms->embed('generator_portal'); ?>
                </div>
            </div>
        <?php } ?>

    </div>
</div>