<?php

namespace ProcessWire;

// Template file for “home” template used by the homepage
$page->edit(true);
// Template file for “home” template used by the homepage
if (!$user->isLoggedin()) {
    $session->redirect($pages->get("/profile/login")->url);
}
?>

<div id="content">


    <header id="header" class="shadow-xs bg-blue-dark">

        <!-- Navbar -->
        <div class="container position-relative">

            <nav class="navbar navbar-expand-lg navbar-dark">

                <div class="align-items-start">

                    <!-- mobile menu button : show -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
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
                    <a class="navbar-brand m-0" href="<?php echo  $page->url; ?>">
                        <!-- <img src="assets/images/logo/logo_dark.svg" width="110" height="38" alt="...">
             -->
                        Forms
                    </a>


                </div>


                <!-- securd indicator -->
                <span class="d-none d-lg-flex align-items-center text-success py-2 border-start px-3 mx-4">
                    <svg width="18px" height="18px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 .5c-.662 0-1.77.249-2.813.525a61.11 61.11 0 0 0-2.772.815 1.454 1.454 0 0 0-1.003 1.184c-.573 4.197.756 7.307 2.368 9.365a11.192 11.192 0 0 0 2.417 2.3c.371.256.715.451 1.007.586.27.124.558.225.796.225s.527-.101.796-.225c.292-.135.636-.33 1.007-.586a11.191 11.191 0 0 0 2.418-2.3c1.611-2.058 2.94-5.168 2.367-9.365a1.454 1.454 0 0 0-1.003-1.184 61.09 61.09 0 0 0-2.772-.815C9.77.749 8.663.5 8 .5zm2.854 6.354a.5.5 0 0 0-.708-.708L7.5 8.793 6.354 7.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"></path>
                    </svg>
                    <span class="ps-2 small">Secured data</span>
                </span>


                <!-- mobile nav only -->
                <div class="collapse navbar-collapse navbar-animate-fadein" id="navbarMainNav">


                    <!-- menu -->
                    <ul class="navbar-nav navbar-sm d-lg-none">

                        <li class="nav-item"><a class="nav-link px-3" href="#">Continue shopping</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="#">My account</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="#">Favorites</a></li>

                    </ul>

                </div>


                <ul class="list-inline list-unstyled mb-0 d-flex align-items-end navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo  $pages->get('/forms')->url; ?>">Back to all Forms</a>
                    </li>

                </ul>

            </nav>

        </div>
        <!-- /Navbar -->

    </header>


    <!-- Begin page content -->
    <div class="container">

        <!-- Jumbotron -->
        <div class="jumbotron">
            <h1><?php echo $page->title; ?></h1>
            <p class="lead"><?php echo $page->short_description; ?></p>
            <button class="btn btn-lg btn-success">
                <edit field="<?php echo $page->form_edit_fields ?>"> Fill Up The Form </edit>
            </button>
        </div>


    </div>
</div>