<?php

namespace ProcessWire;

// Template file for “home” template used by the homepage
// Template file for “home” template used by the homepage
if (!$user->isLoggedin()) {
    $session->redirect($pages->get("/profile/login/")->url);
}
?>

<div id="content">



    <?php include('./inc/staff_header.php'); ?>



    <div class="container py-5">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Forms</li>
            </ol>
        </nav>

        <h1 class="h2 fw-bold">Forms</h1>

    </div>
    <div class="container pb-7">

        <div class="row g-4">

            <div class="col-lg-8 mb-5">


                <!-- #cart-items -->
                <div id="cart-items">


                    <?php if ($pages->get('/forms')->hasChildren) : ?>
                        <?php foreach ($pages->get('/forms')->children as  $form) { ?>

                            <!-- item -->
                            <div class="card mb-3 overflow-hidden">
                                <div class="card-body p-md-4">


                                    <!-- image -->
                                    <div class="row g-3 py-2 align-items-center">
                                        <div class="col-4 col-md-2">
                                            <div class="ratio ratio-1x1">
                                                <span class="d-flex justify-content-center align-items-center">
                                                    <img class="img-fluid rounded" src="<?php echo $form->thumbnail->src ?>" alt="<?php echo $form->title ?>">
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-8 col-md-5">

                                            <!-- item name -->
                                            <a href="<?php echo $form->url ?>" class="link-normal fw-medium"><?php echo $form->title ?></a>
                                            <p><?php echo $form->form_visibility->id == 101 ? '<span class="badge bg-success-soft">Public</span>' : '<span class="badge bg-gray-600">Locked</span>'; ?></p>
                                            <!-- unit price -->
                                            <small class="d-block text-muted"><?php echo $form->short_description ?></small>


                                        </div>

                                        <div class="col-12 col-md-5">
                                            <div class="row g-3">


                                                <div class="col-8 col-sm-6 col-lg-7 text-md-end">

                                                    <!-- <del class="d-block fw-normal text-muted small">$1122.00</del> -->
                                                    <span class="d-block fw-medium">
                                                        <a class="btn btn-default bg-primary-soft" href="<?php echo $form->url ?>" role="button">View Form &raquo; </a>
                                                    </span>

                                                    <!-- <small class="d-block text-success d-block mb-2">You save $11.00</small> -->

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- gift -->

                                </div>
                            </div>
                            <!-- /item -->

                        <?php }  ?>
                    <?php endif; ?>
                </div>



            </div>


            <!-- summary -->
            <div class="col-lg-4 mb-4">

                <!-- #cart-summary -->
                <div class="card text-gray-800">
                    <div class="card-header border-light fs-5 fw-bold mx-3 px-0 py-4">Featured Forms</div>
                    <div class="card-body p-md-4">



                        <ul class="list-unstyled mb-0 small">
                            <?php if ($pages->get('/forms')->hasChildren) : ?>
                                <?php foreach ($pages->get('/forms')->children as  $form) { ?>
                                    <li class="list-item pb-1"><a class="link-muted" href="<?php echo $form->url ?>"><?php echo $form->title ?></a></li>
                                <?php }  ?>
                            <?php endif; ?>
                        </ul>

                    </div>
                </div>


            </div>

        </div>

    </div>

</div>