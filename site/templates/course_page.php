<?php

namespace ProcessWire;

// Template file for “home” template used by the homepage
// Template file for “home” template used by the homepage
if (!$user->isLoggedin()) {
    $session->redirect($pages->get("/profile/login")->url);
}
?>

<div id="content">


    <body class="aside-start aside-sticky">

        <div id="wrapper">
            <div class="container">
                <?php
                echo $page->page_body;
                ?>
            </div>
        </div><!-- /#wrapper -->






        <!-- Mobile menu toggler -->
        <div class="position-fixed top-0 end-0 z-index-10 m-4 d-inline-block d-lg-none">

            <a href="#aside-main" class="btn-sidebar-toggle btn-burger-menu bg-white rounded w--60 h--60 d-inline-block px-3 py-3 shadow-md">
                <span class="burger-menu"></span>
            </a>

        </div>
        <!-- /Mobile menu toggler -->


        <!-- SIDEBAR -->
        <aside id="aside-main" class="aside-start aside-primary fw-light aside-hide-xs d-flex align-items-stretch justify-content-lg-between align-items-start flex-column">



            <div class="clearfix px-3 py-4 mb-1 text-center bg-diff align-self-baseline w-100">

                <a class="navbar-brand" href="<?php echo  $page->url; ?>">
                    <!-- <?php echo  $page->title; ?> -->
                    <img src="<?php echo $config->urls->templates; ?>assets/images/header-logo-ltr.png" width=" 110" height="38" alt="...">
                </a>
            </div>



            <div class="aside-wrapper scrollable-vertical scrollable-styled-light align-self-baseline h-100 w-100">

                <nav class="nav-deep nav-deep-dark nav-deep-hover nav-link-click-close">
                    <ul class="nav flex-column">


                        <li class="nav-item <?php echo $page->id == $page->id ? "active" : "" ?>">
                            <a class='nav-link' href="<?php echo $page->url ?>">
                                <i class='fi fi-home'></i>
                                Home</a>
                        </li>
                        <?php if ($page->hasChildren) : ?>
                            <?php
                            foreach ($page->children as  $regulation) {
                                $class = $regulation->id == $page->id ? "active" : "";
                                echo "<li class='nav-item $class'>

                                <a class='nav-link'  href='$regulation->url'><i class='fi fi-share'></i>
                                $regulation->title</a>
                                </li>";
                            }  ?>
                        <?php endif; ?>

                    </ul>
                    <ul class="nav flex-column" style="bottom: 0; position: absolute;width:100%;">
                        <li class="nav-item"><a class='nav-link' href="<?php echo  $pages->get('/')->url;  ?>"><i class='fi fi-share'></i> Staff Portal</a></li>
                        <li class="nav-item"><a class='nav-link' href="<?php echo  $pages->get('/courses')->url;  ?>"><i class='fi fi-share'></i> Course Panel</a></li>
                    </ul>
                </nav>

            </div>
        </aside>
        <!-- /SIDEBAR -->



    </body>


</div>