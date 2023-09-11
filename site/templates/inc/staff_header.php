<!-- HEADER -->
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

                <!-- 
					Logo : height: 70px max
				-->
                <a class="navbar-brand" href="<?php echo  $pages->get('/')->url; ?>">
                    Staff Portal
                    <!-- <img src="assets/images/logo/logo_dark.svg" width="110" height="70" alt="..."> -->
                </a>

            </div>




            <!-- Menu -->
            <div class="collapse navbar-collapse navbar-animate-fadein justify-content-end" id="navbarMainNav">


                <!-- MOBILE MENU NAVBAR -->
                <div class="navbar-xs d-none"><!-- .sticky-top -->

                    <!-- mobile menu button : close -->
                    <button class="navbar-toggler pt-0" type="button" data-toggle="collapse" data-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
                        <svg width="20" viewBox="0 0 20 20">
                            <path d="M 20.7895 0.977 L 19.3752 -0.4364 L 10.081 8.8522 L 0.7869 -0.4364 L -0.6274 0.977 L 8.6668 10.2656 L -0.6274 19.5542 L 0.7869 20.9676 L 10.081 11.679 L 19.3752 20.9676 L 20.7895 19.5542 L 11.4953 10.2656 L 20.7895 0.977 Z"></path>
                        </svg>
                    </button>

                    <!-- 
						Mobile Menu Logo 
						Logo : height: 70px max
					-->
                    <a class="navbar-brand" href="<?php echo  $pages->get('/')->url; ?>">
                        Staff Portal
                        <!-- <img src="assets/images/logo/logo_dark.svg" width="110" height="70" alt="..."> -->
                    </a>

                </div>
                <!-- /MOBILE MENU NAVBAR -->





                <?php
                if ($user->isLoggedin() && !$input->get('profile') && !$input->get('logout')) {
                ?>


                    <!-- NAVIGATION -->
                    <ul class="navbar-nav fs--14">
                        <li class="nav-item active"><a class="nav-link" href="<?php echo  $pages->get('/')->url; ?>">Home</a></li>
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
                                    <li class="dropdown-item"><a class="dropdown-link" href="<?php echo  $pages->get('/courses/course-list/rules-and-regulations/')->url; ?>">Rules & Regulatioins</a></li>
                                    <li class="dropdown-item"><a class="dropdown-link" href="<?php echo  $pages->get('/courses/course-list/company-policies/')->url; ?>">Company Policies</a></li>
                                    <hr>
                                    <li class="dropdown-item">
                                        <h3 class="fs-6 text-muted py-3 px-lg-4">
                                            Featured Forms
                                        </h3>
                                    </li>
                                    <li class="dropdown-item"><a class="dropdown-link" href="<?php echo  $pages->get('/forms/daily-duties-form/')->url; ?>">Daily Duties</a></li>



                                </ul>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo  $pages->get('/courses')->url; ?>">Employee Tranning</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo  $pages->get('/forms')->url; ?>">Forms</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo  $pages->get('/emergency-numbers')->url; ?>">Emergency Numbers</a></li>

                    </ul>

                    <!-- /NAVIGATION -->
                    <ul class="list-inline list-unstyled mb-0 d-flex align-items-end">

                        <li class="list-inline-item mx-1 dropdown">

                            <a href="#" aria-label="Account Options" id="dropdownAccountOptions" class="btn btn-sm btn-primary js-stoppropag" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                <span class="group-icon float-start">
                                    <i class="fi fi-user-male"></i>
                                    <i class="fi fi-close"></i>
                                </span>
                                <span>Account</span>
                            </a>

                            <div aria-labelledby="dropdownAccountOptions" class="list-unstyled dropdown-menu dropdown-menu-clean dropdown-click-ignore end-0 py-2 rounded-xl" style="min-width:215px;">

                                <div class="dropdown-header px-4 mb-1 text-wrap fw-medium"><?php echo $user->name  ?></div>
                                <div class="dropdown-divider mb-3"></div>
                                <a class="dropdown-item active" href="<?php echo  $pages->get('/profile')->url; ?>">
                                    <svg class="text-gray-600 float-start" width="18px" height="18px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 3.293l6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"></path>
                                        <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"></path>
                                    </svg>
                                    <span>My account</span>
                                </a>
                                <div class="dropdown-divider mt-3"></div>
                                <a href="?logout=1" title="Log Out" class="dropdown-item mt-1">
                                    <i class="fi fi-power float-start"></i>
                                    Log Out
                                </a>
                            </div>

                        </li>

                    </ul>
                <?php
                } else { ?>
                    <!-- /NAVIGATION -->
                    <ul class="list-inline list-unstyled mb-0 d-flex align-items-end">

                        <li class="list-inline-item mx-1 dropdown">

                            <a href="#" aria-label="Account Options" id="dropdownAccountOptions" class="btn btn-sm btn-primary js-stoppropag" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                <span class="group-icon float-start">
                                    <i class="fi fi-user-male"></i>
                                    <i class="fi fi-close"></i>
                                </span>
                                <span>Login</span>
                            </a>

                            <div aria-labelledby="dropdownAccountOptions" class="list-unstyled dropdown-menu dropdown-menu-clean dropdown-click-ignore end-0 py-2 rounded-xl" style="min-width:215px;">

                                <a href="<?php echo $pages->get("/profile/login/")->url ?>" title="Log Out" class="dropdown-item mt-1">
                                    Login
                                </a>
                            </div>

                        </li>

                    </ul>
                <?php } ?>




            </div>

        </nav>

    </div>
    <!-- /NAVBAR -->

</header>
<!-- /HEADER -->