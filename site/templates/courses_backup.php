<?php

namespace ProcessWire;

// Template file for “home” template used by the homepage
if (!$user->isLoggedin()) {
    $session->redirect($pages->get("/profile/login")->url);
}
?>


<div id="content">

    <div id="wrapper" data-aos="fade-in">


        <?php include('./inc/employee_header.php'); ?>

        <div class="section swiper-container swiper-btn-group swiper-btn-group-end text-white p-0 vh-75 overflow-hidden" data-swiper='{
					"slidesPerView": 1,
					"spaceBetween": 0,
					"autoplay": { "delay" : 3500, "disableOnInteraction": false },
					"loop": true,
					"pagination": { "type": "bullets" }
				}'>

            <div class="swiper-wrapper h-100">





                <?php if ($pages->get('/courses/course-list')->hasChildren("is_featured=1")) : ?>
                    <?php foreach ($pages->get('/courses/course-list')->children("is_featured=1,limit=3") as $i => $form) { ?>

                        <!-- slide 1 -->
                        <div class="h-100 swiper-slide d-middle bg-white overlay-dark overlay-opacity-2 d-middle bg-cover" style="background-image:url('<?php echo $form->thumbnail->url ?>')">
                            <div class="container z-index-10 text-white text-center-xs">

                                <h1 class="display-4 fw-bold lh-1" data-swiper-parallax="-300">
                                    <?php echo $form->title ?>
                                </h1>

                                <p class="h5" data-swiper-parallax="-100">
                                    <?php echo $form->short_description ?>
                                </p>

                                <p class="mt-5" data-swiper-parallax="-200">

                                    <a href="<?php echo $form->url ?>" class="btn btn-primary transition-hover-top">
                                        <i class="fi fi-arrow-end"></i>
                                        Explore Course Details
                                    </a>

                                </p>

                            </div>
                        </div>
                        <!-- /slide 1 -->


                    <?php }  ?>
                <?php endif; ?>





            </div>

            <!-- Add Arrows -->
            <div class="swiper-button-next swiper-button-white"></div>
            <div class="swiper-button-prev swiper-button-white"></div>

            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>

        </div>
        <!-- /SWIPER -->
        <section>
            <div class="container">

                <h2 class="h3 mb-5 text-center-xs font-weight-normal text-muted">
                    <b>Featured</b> Courses
                </h2>



                <!-- product list -->
                <div class="row gutters-xs--xs">


                    <?php if ($pages->get('/courses/course-list')->hasChildren("is_featured=1")) : ?>
                        <?php foreach ($pages->get('/courses/course-list')->children("is_featured=1,limit=3") as  $form) { ?>






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
        </section>
        <section class="bg-theme-color-light">
            <div class="container">


                <div class="text-center mb-5">
                    <span class="badge badge-pill badge-primary badge-soft font-weight-light pl-2 pr-2 pt--6 pb--6 mb-2">
                        PROFESSIONALS
                    </span>
                    <h2 class="font-weight-normal">
                        Instructors
                    </h2>
                </div>


                <div class="row">



                    <?php if ($pages->get('/courses/instructors')->hasChildren) : ?>
                        <?php foreach ($pages->get('/courses/instructors')->children as  $form) { ?>

                            <div class="col-6 col-lg-4 mb-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="0">

                                <a href="<?php echo $form->url ?>" class="d-block bg-white rounded img-circle p-2 shadow-primary-xs text-dark text-decoration-none transition-hover-top transition-all-ease-250">
                                    <img class="w-100 img-fluid rounded" src="<?php echo $form->profile_photo->url ?>" alt="...">
                                    <div class="px-2 py-3">
                                        <h5 class="mb-0"><?php echo $form->title ?></h5>
                                        <p class="mb-0"><?php echo $form->short_description ?></p>
                                    </div>
                                </a>

                            </div>
                        <?php }  ?>
                    <?php endif; ?>



                </div>

            </div>
        </section>

    </div>
</div>