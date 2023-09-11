<header id="header" class="shadow-xs bg-blue-dark">


    <!-- NAVBAR -->
    <div class="container position-relative">

        <nav class="navbar navbar-expand-lg navbar-dark text-white justify-content-lg-between justify-content-md-inherit">

            <div class="align-items-start">

                <!-- mobile menu button : show -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <svg width="25" viewBox="0 0 20 20">
                        <path d="M 19.9876 1.998 L -0.0108 1.998 L -0.0108 -0.0019 L 19.9876 -0.0019 L 19.9876 1.998 Z"></path>
                        <path d="M 19.9876 7.9979 L -0.0108 7.9979 L -0.0108 5.9979 L 19.9876 5.9979 L 19.9876 7.9979 Z"></path>
                        <path d="M 19.9876 13.9977 L -0.0108 13.9977 L -0.0108 11.9978 L 19.9876 11.9978 L 19.9876 13.9977 Z"></path>
                        <path d="M 19.9876 19.9976 L -0.0108 19.9976 L -0.0108 17.9976 L 19.9876 17.9976 L 19.9876 19.9976 Z"></path>
                    </svg>
                </button>


                <a class="navbar-brand" href="<?php echo  $pages->get('/courses')->url; ?>">
                    Employee Training <!-- <img src="assets/images/logo/logo_dark.svg" width="110" height="70" alt="..."> -->
                </a>

            </div>




            <!-- Menu -->
            <div class="collapse navbar-collapse navbar-animate-fadein justify-content-end" id="navbarMainNav">


                <div class="navbar-xs d-none"><!-- .sticky-top -->

                    <button class="navbar-toggler pt-0" type="button" data-toggle="collapse" data-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
                        <svg width="20" viewBox="0 0 20 20">
                            <path d="M 20.7895 0.977 L 19.3752 -0.4364 L 10.081 8.8522 L 0.7869 -0.4364 L -0.6274 0.977 L 8.6668 10.2656 L -0.6274 19.5542 L 0.7869 20.9676 L 10.081 11.679 L 19.3752 20.9676 L 20.7895 19.5542 L 11.4953 10.2656 L 20.7895 0.977 Z"></path>
                        </svg>
                    </button>

                    <a class="navbar-brand" href="<?php echo  $pages->get('/')->url; ?>">
                        Staff Portal
                        <!-- <img src="assets/images/logo/logo_dark.svg" width="110" height="70" alt="..."> -->
                    </a>

                </div>

                <ul class="navbar-nav fs--14">
                    <li class="nav-item active"><a class="nav-link" href="<?php echo  $pages->get('/courses')->url;  ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo  $pages->get('/courses/all-courses/')->url;  ?>">All Courses</a></li>




                    <li class="nav-item dropdown">
                        <a href="#" id="mainNavHomea" class="nav-link dropdown-toggle js-stoppropag" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Menu
                        </a>

                        <div aria-labelledby="mainNavHomea" class="dropdown-menu dropdown-menu-clean dropdown-menu-hover">
                            <ul class="list-unstyled m-0 p-0">

                                <li class="dropdown-item">
                                    <h3 class="fs-6 text-muted py-3 px-lg-4">
                                        Featured Courses
                                    </h3>
                                </li>
                                <?php if ($pages->get('/courses/course-list')->hasChildren) : ?>
                                    <?php foreach ($pages->get('/courses/course-list')->children("is_featured=1") as  $form) { ?>
                                        <li class="dropdown-item"><a class="dropdown-link" href="<?php echo $form->url ?>"><?php echo $form->title ?></a></li>
                                    <?php }  ?>
                                <?php endif; ?>

                                <?php if ($pages->get('/courses/course-categories/')->hasChildren) : ?>
                                    <li role="separator" class="divider"></li>
                                    <li class="dropdown-item">
                                        <hr>
                                        <h3 class="fs-6 text-muted py-3 px-lg-4">
                                            Categories
                                        </h3>
                                    </li>
                                    <?php foreach ($pages->get('/courses/course-categories/')->children as  $form) { ?>
                                        <li class="dropdown-item"><a class="dropdown-link" href="<?php echo $form->url ?>"><?php echo $form->title ?></a></li>
                                    <?php }  ?>
                                <?php endif; ?>


                                <?php if ($pages->get('/courses/instructors')->hasChildren) : ?>
                                    <li role="separator" class="divider"></li>
                                    <li class="dropdown-item">
                                        <hr>
                                        <h3 class="fs-6 text-muted py-3 px-lg-4">
                                            Instructors
                                        </h3>
                                    </li>

                                    <?php foreach ($pages->get('/courses/instructors')->children as  $form) { ?>
                                        <li class="dropdown-item"><a class="dropdown-link" href="<?php echo $form->url ?>"><?php echo $form->title ?></a></li>
                                    <?php }  ?>
                                <?php endif; ?>

                            </ul>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo  $pages->get('/')->url; ?>">Staff Portal</a></li>
                    <!-- <li><a href="#contact">Your Profile</a></li> -->
                </ul>


            </div>

        </nav>

    </div>
    <!-- /NAVBAR -->

</header>
<!-- /HEADER -->