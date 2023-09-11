<?php

namespace ProcessWire;

// Template file for “home” template used by the homepage
if (!$user->isLoggedin()) {
    $session->redirect($pages->get("/profile/login")->url);
}
?>


<div id="content" data-aos="fade-in">




    <?php include('./inc/employee_header.php'); ?>
    <section class="bg-light p-0">
        <div class="container py-5">

            <h1 class="h3">
                All Courses
            </h1>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb fs--14">
                    <li class="breadcrumb-item"><a href="#!">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">all</li>
                </ol>
            </nav>

        </div>
    </section>


    <section class="pt-5">
        <div class="container">

            <div class="row">

                <!-- sidebar -->
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 mb--60">





                    <!-- CATEGORIES -->
                    <nav class="nav-deep nav-deep-light mb-4 bg-white shadow-xs shadow-none-md shadow-none-xs px-4 pb-3 p-0-md p-0-xs rounded js-ajaxified">

                        <!-- mobile trigger : categories -->
                        <button class="clearfix btn btn-toggle btn-sm btn-block text-align-left shadow-md border rounded mb-1 d-block d-lg-none js-togglified" data-target="#nav_responsive" data-toggle-container-class="d-none d-sm-block bg-white shadow-md border animate-fadein rounded p-3">
                            <span class="group-icon px-2 py-2 float-start">
                                <i class="fi fi-bars-2"></i>
                                <i class="fi fi-close"></i>
                            </span>

                            <span class="h5 py-2 m-0 float-start">
                                Featured Courses
                            </span>
                        </button>

                        <!-- desktop only -->
                        <h5 class="h6 pt-3 pb-3 m-0 d-none d-lg-block">
                            Featured Courses
                        </h5>
                        <!-- navigation -->
                        <ul id="nav_responsive" class="nav flex-column d-none d-lg-block">

                            <?php if ($pages->get('/courses/course-list')->hasChildren) : ?>
                                <?php foreach ($pages->get('/courses/course-list')->children("is_featured=1") as  $form) { ?>
                                    <li class="nav-item"> <a class="nav-link px-0" href="<?php echo $form->url ?>"><?php echo $form->title ?></a> </li>
                                <?php }  ?>
                            <?php endif; ?>

                        </ul>

                    </nav>
                    <!-- /CATEGORIES -->


                    <!-- CATEGORIES -->
                    <nav class="nav-deep nav-deep-light mb-4 bg-white shadow-xs shadow-none-md shadow-none-xs px-4 pb-3 p-0-md p-0-xs rounded js-ajaxified">

                        <!-- mobile trigger : categories -->
                        <button class="clearfix btn btn-toggle btn-sm btn-block text-align-left shadow-md border rounded mb-1 d-block d-lg-none js-togglified" data-target="#nav_responsive" data-toggle-container-class="d-none d-sm-block bg-white shadow-md border animate-fadein rounded p-3">
                            <span class="group-icon px-2 py-2 float-start">
                                <i class="fi fi-bars-2"></i>
                                <i class="fi fi-close"></i>
                            </span>

                            <span class="h5 py-2 m-0 float-start">
                                Instructors
                            </span>
                        </button>

                        <!-- desktop only -->
                        <h5 class="h6 pt-3 pb-3 m-0 d-none d-lg-block">
                            Instructors
                        </h5>
                        <!-- navigation -->
                        <ul id="nav_responsive" class="nav flex-column d-none d-lg-block">

                            <?php if ($pages->get('/courses/instructors')->hasChildren) : ?>
                                <?php foreach ($pages->get('/courses/instructors')->children as  $form) { ?>
                                    <li class="nav-item"> <a class="nav-link px-0" href="<?php echo $form->url ?>"><?php echo $form->title ?></a> </li>
                                <?php }  ?>
                            <?php endif; ?>

                        </ul>

                    </nav>
                    <!-- /CATEGORIES -->

                    <!-- CATEGORIES -->
                    <nav class="nav-deep nav-deep-light mb-4 bg-white shadow-xs shadow-none-md shadow-none-xs px-4 pb-3 p-0-md p-0-xs rounded js-ajaxified">

                        <!-- mobile trigger : categories -->
                        <button class="clearfix btn btn-toggle btn-sm btn-block text-align-left shadow-md border rounded mb-1 d-block d-lg-none js-togglified" data-target="#nav_responsive" data-toggle-container-class="d-none d-sm-block bg-white shadow-md border animate-fadein rounded p-3">
                            <span class="group-icon px-2 py-2 float-start">
                                <i class="fi fi-bars-2"></i>
                                <i class="fi fi-close"></i>
                            </span>

                            <span class="h5 py-2 m-0 float-start">
                                Categories
                            </span>
                        </button>

                        <!-- desktop only -->
                        <h5 class="h6 pt-3 pb-3 m-0 d-none d-lg-block">
                            Categories
                        </h5>
                        <!-- navigation -->
                        <ul id="nav_responsive" class="nav flex-column d-none d-lg-block">

                            <?php if ($pages->get('/courses/course-categories')->hasChildren) : ?>
                                <?php foreach ($pages->get('/courses/course-categories')->children as  $form) { ?>
                                    <li class="nav-item"> <a class="nav-link px-0" href="<?php echo $form->url ?>"><?php echo $form->title ?></a> </li>
                                <?php }  ?>
                            <?php endif; ?>

                        </ul>

                    </nav>
                    <!-- /CATEGORIES -->



                </div>
                <!-- /sidebar -->



                <!-- products -->
                <div class="col-12 col-sm-12 col-md-12 col-lg-9">


                    <!-- additional filters -->
                    <div class="shadow-xs bg-white mb-5 p-3 rounded clearfix">


                        <h2 class="h6 mb-0">
                            View All courses
                        </h2>

                    </div>
                    <!-- /additional filters -->


                    <!-- product list -->
                    <div class="row gutters-xs--xs">


                        <?php if ($pages->get('/courses/course-list')->hasChildren) : ?>
                            <?php foreach ($pages->get('/courses/course-list')->children as  $form) { ?>





                                <!-- item -->
                                <div class="col-6 col-lg-4 mb-4 mb-2-xs">

                                    <div class="bg-white shadow-md shadow-3d-hover transition-all-ease-250 transition-hover-top rounded show-hover-container p-2 h-100">


                                        <a href="<?php echo $form->url ?>" class="d-block text-decoration-none text-center-xs text-gray-600">


                                            <figure class="m-0 text-center bg-gradient-radial-light rounded-top overflow-hidden">
                                                <img class="img-fluid bg-suprime opacity-9" src="<?php echo $form->thumbnail->url ?>" alt="..." />
                                            </figure>

                                            <div class="d-block  py-3 overflow-hidden">

                                                <h5 class="d-block fs--16 max-h-50 overflow-hidden text-black">
                                                    <?php echo $form->title ?>
                                                </h5>
                                                <hr>
                                                <span class="d-block fs--16 max-h-50 overflow-hidden">
                                                    <?php echo $form->short_description ?>
                                                </span>
                                                <?php
                                                foreach ($form->instructor as $instructor) {
                                                    echo "<span class='badge bg-primary-soft'style='margin-right:2px'>$instructor->title</span>";
                                                }
                                                echo count($form->instructor) > 0 ? '<br>' : "";
                                                foreach ($form->course_category as $category) {
                                                    echo "<span class='badge rounded-pill bg-info-soft'style='margin-right:2px'>$category->title</span>";
                                                }
                                                ?>
                                                <hr>

                                                <a class="btn btn-default bg-primary-soft" href="<?php echo $form->url ?>">View Course &raquo;</a>
                                            </div>

                                        </a>

                                    </div>

                                </div>
                                <!-- /item -->


                            <?php }  ?>
                        <?php endif; ?>

                    </div>
                    <!-- /product list -->



                </div>
                <!-- /products -->

            </div>

        </div>
    </section>




</div>