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

    <div class="container">
        <div class="my-5">
            <h4 style="color:red; text-align:center;">Emergency Number Details</h4>
            <?php echo $page->page_body; ?>
        </div>
    </div>
</div>