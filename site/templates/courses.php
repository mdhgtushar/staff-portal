<?php

namespace ProcessWire;

// Template file for “home” template used by the homepage
if (!$user->isLoggedin()) {
    $session->redirect($pages->get("/profile/login")->url);
}
?>


<div id="content">
    <div id="wrapper">

        <div class="container text-center">

            <div class="bg-white w-100 max-w-500 d-inline-block mt-5 p-4 p-lg-5 rounded-xl shadow-xs">



                <h1 class="h3 my-5">
                    <span class="d-block mb-3 fw-bold">
                        We are coming soon!
                    </span>

                    <span class="d-block mt-4 text-primary">
                        Employee Trainning
                        <small class="fs-6 text-muted d-block">
                            All Advanced Courses
                        </small>
                    </span>


                </h1>

            </div>

        </div>

    </div><!-- /#wrapper -->
</div>