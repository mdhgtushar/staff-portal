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
    <section class="bg-light p-0 mb-5">
        <div class="container-fluid py-5">

            <h1 class="h3">
                Full List
            </h1>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb fs--14">
                    <li class="breadcrumb-item"><a href="<?php echo $pages->get('/')->url ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo $pages->get('/forms')->url ?>">Forms</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo $pages->get('/forms/daily-duties-form/')->url ?>"><?php echo $page->title ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">all</li>
                </ol>
            </nav>

        </div>
    </section>

    <h2 style="color:gray; text-align:center;">Daily Duties Details</h2>
    <?php if ($user->hasRole('superuser')) { ?>
        <div class="container-fluid">
            <table class=" shadow-primary-xs table-datatable table table-bordered table-hover table-striped" data-lng-empty="No data available in table" data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries" data-lng-filtered="(filtered from _MAX_ total entries)" data-lng-loading="Loading..." data-lng-processing="Processing..." data-lng-search="Search..." data-lng-norecords="No matching records found" data-lng-sort-ascending=": activate to sort column ascending" data-lng-sort-descending=": activate to sort column descending" data-main-search="true" data-column-search="false" data-row-reorder="false" data-col-reorder="true" data-responsive="true" data-header-fixed="true" data-select-onclick="true" data-enable-paging="true" data-enable-col-sorting="true" data-autofill="false" data-group="false" data-items-per-page="10" data-enable-column-visibility="true" data-lng-column-visibility="Column Visibility" data-enable-export="true" data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>" data-lng-csv="CSV" data-lng-pdf="PDF" data-lng-xls="XLS" data-lng-copy="Copy" data-lng-print="Print" data-lng-all="All" data-export-pdf-disable-mobile="true" data-export='["csv", "pdf", "xls"]' data-options='["copy", "print"]' data-custom-config='{}'>
                <?php
                $form = $forms->get('daily_duties');
                ?>
                <thead>
                    <?php foreach ($form->entries()->find("limit=1") as $data) { ?>
                        <tr>
                            <?php
                            foreach ($data as $key => $value) {
                                if ($key != "entryFlags" && $key != "id" && $key != "forms_id" && $key != "entryStr") {
                                    echo  " <th>" . $key . "</th>";
                                }
                            }
                            ?>
                        </tr>
                    <?php  } ?>
                </thead>
                <tbody>
                    <?php foreach ($form->entries()->find("") as $data) { ?>
                        <tr>
                            <?php
                            foreach ($data as $key => $value) {
                                if ($key != "entryFlags" && $key != "id" && $key != "forms_id" && $key != "entryStr") {

                                    if ($key == "date" || $key ==  "created" || $key ==  "modified") {
                                        echo " <td>" . date('d/M/Y', strtotime($value)) . "</td>";
                                    } else if ($key == "user_id") {
                                        echo " <td>" . $pages->get($value)->name . "</td>";
                                    } else {
                                        echo  " <td>" . $value . "</td>";
                                    }
                                }
                            }

                            ?>
                            <td><a class="btn btn-primary" href="<?php echo $pages->get("/forms/daily-duties-form/view-daily-duties/")->url . "?id=" . $data['id'] ?>">View Entry</a></td>
                        </tr>
                    <?php  } ?>

                </tbody>

            </table>

        </div>
    <?php } ?>
</div>