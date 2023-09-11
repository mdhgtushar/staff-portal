<?php

namespace ProcessWire;

// Template file for “home” template used by the homepage
// Template file for “home” template used by the homepage
if (!$user->isLoggedin()) {
    $session->redirect($pages->get("/profile/login")->url);
}
$form = $forms->get('daily_duties');
$formdata = $form->entries()->find("id=" . $_GET['id']);

?>


<div id="content">
    <div class="container py-3 py-lg-6">

        <div class="card shadow-secondary shadow-none-print border-none-print rounded text-gray-800">

            <!-- invoice header -->
            <div class="card-header padding-0-print bg-white px-sm-5 px-lg-7">
                <div class="row">
                    <div class="col-12 col-sm-6 py-2 py-sm-4">
                        <!-- <img src="assets/images/logo/logo_dark.svg" width="136" height="40" alt="..."> -->
                        <h2 class="m-0 p-0"> You are viewing <?php echo date("d M Y", $page->getUnformatted("date")) ?> Daily Duty Task!</h2><br>
                        <h5 class="m-0 p-0">Employee Name: <?php echo $page->user_id->name ?></h5>
                    </div>
                    <div class="col-12 col-sm-6 py-2 py-sm-4 text-sm-end">
                        <h4 class="mb-0">Daily Duty: #<?php echo $page->id ?></h4>
                        <p class="mb-0"><?php echo date("d M Y", $page->getUnformatted("date")) ?></p>
                    </div>
                </div>
            </div>


            <!-- invoice body -->
            <div class="card-body padding-0-print px-sm-5 px-lg-7">
                <?php echo $pages->get("/form-page/daily-duties-list/")->page_body; ?>

                <!-- invoice items -->
                <div class="table-responsive mb-4">
                    <table class="table table-borderless table-nowrap border-bottom text-gray-800">
                        <thead class="border-top border-bottom text-gray-600">
                            <tr>
                                <th>Duty Details</th>
                                <th>Status </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($formdata as $datachank) { ?>

                                <?php
                                foreach (array_chunk($datachank, 1, true) as $data) {  ?>
                                    <tr>

                                        <?php
                                        foreach ($data as $key => $value) {
                                            if ($key != "entryFlags" && $key != "id" && $key != "forms_id" && $key != "entryStr") {
                                                echo  " <th>" . $key . "</th>";
                                            }

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
                                    </tr>
                                <?php
                                }
                                ?>

                            <?php  } ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

        <!-- print button -->
        <div class="d-inline-grid gap-auto-2 pt-4 hide-print">
            <a href="javascript:window.print();" class="btn btn-sm bg-white border transition-1 shadow-soft-hover">
                <svg class="rtl-flip" height="18px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                    <path d="M11 2H5a1 1 0 0 0-1 1v2H3V3a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h-1V3a1 1 0 0 0-1-1zm3 4H2a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h1v1H2a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1z"></path>
                    <path fill-rule="evenodd" d="M11 9H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1zM5 8a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H5z"></path>
                    <path d="M3 7.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"></path>
                </svg>
                <span>Print</span>
            </a>
        </div>

    </div>
</div>