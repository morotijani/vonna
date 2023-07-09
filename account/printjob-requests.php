<?php 
    // INDEX PAGE
    //echo md5(uniqid(mt_rand(), true)) . '<br>';
    //echo time() . mt_rand() . 23;
    require_once ('./../db_connection/conn.php');
    if (!user_is_logged_in()) {
        user_login_redirect();
    }
    include ('../inc/header.inc.php');
    include ('header.account.php');
    
    // exams query
    $queryExams = "
        SELECT * FROM vonna_printjob 
        ORDER BY id DESC
    ";
    $statement = $conn->prepare($queryExams);
    $statement->execute();
    $count_exams = $statement->rowCount();
    $exams = $statement->fetchAll();

    // banners query
    $queryBanners = "
        SELECT * FROM vonna_printjob_banners 
        ORDER BY id DESC
    ";
    $statement = $conn->prepare($queryBanners);
    $statement->execute();
    $count_banners = $statement->rowCount();
    $banners = $statement->fetchAll();

    // call cards query
    $queryCallcards = "
        SELECT * FROM vonna_printjob_callcards 
        ORDER BY id DESC
    ";
    $statement = $conn->prepare($queryCallcards);
    $statement->execute();
    $count_callcards = $statement->rowCount();
    $callcards = $statement->fetchAll();

    // fliers query
    $queryFliers = "
        SELECT * FROM vonna_printjob_fliers
        ORDER BY id DESC
    ";
    $statement = $conn->prepare($queryFliers);
    $statement->execute();
    $count_fliers = $statement->rowCount();
    $fliers = $statement->fetchAll();

    // thesis query
    $queryThesis = "
        SELECT * FROM vonna_printjob_thesis
        ORDER BY id DESC
    ";
    $statement = $conn->prepare($queryThesis);
    $statement->execute();
    $count_thesis = $statement->rowCount();
    $thesiss = $statement->fetchAll();

    // customize offuce files query
    $queryCustomize = "
        SELECT * FROM vonna_print_job_customze
        ORDER BY id DESC
    ";
    $statement = $conn->prepare($queryCustomize);
    $statement->execute();
    $count_cutomizes = $statement->rowCount();
    $cutomizes = $statement->fetchAll();

    // receipt query
    $queryReceipt = "
        SELECT * FROM vonna_print_job_receipt
        ORDER BY id DESC
    ";
    $statement = $conn->prepare($queryReceipt);
    $statement->execute();
    $count_receipts = $statement->rowCount();
    $receipts = $statement->fetchAll();

    // receipt query
    $queryInvoice = "
        SELECT * FROM vonna_print_job_invoice
        ORDER BY id DESC
    ";
    $statement = $conn->prepare($queryInvoice);
    $statement->execute();
    $count_invoices = $statement->rowCount();
    $invoices = $statement->fetchAll();

?>


    <!-- BODY -->
    <main class="">
        <?= $flash; ?>
        <div class="container-lg d-flex flex-column">
            <div class="row align-items-start justify-content-center">
                <div class="col-lg-12 py-6 py-md-9">
                    <ul class="nav justify-content-center">
                         <li class="nav-item">
                            <a class="nav-link text-secondary" aria-current="page" href="<?= PROOT; ?>account/print-job">Print Job</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= PROOT; ?>account/printjob-requests">Requests</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="<?= PROOT; ?>account/index">Go home</a>
                        </li>
                    </ul>
                    <section class="py-1">
                        <h2 class="display-3 text-center mb-10">
                            Print job <span class="text-underline-warning">requests</span>
                        </h2>
                        <div class="d-flex align-items-start">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link active" id="v-pills-eq-tab" data-bs-toggle="pill" data-bs-target="#v-pills-eq" type="button" role="tab" aria-controls="v-pills-eq" aria-selected="true">Examination questions</button>
                                <button class="nav-link" id="v-pills-th-tab" data-bs-toggle="pill" data-bs-target="#v-pills-th" type="button" role="tab" aria-controls="v-pills-th" aria-selected="true">Thesis / Research</button>
                                <button class="nav-link " id="v-pills-fl-tab" data-bs-toggle="pill" data-bs-target="#v-pills-fl" type="button" role="tab" aria-controls="v-pills-fl" aria-selected="true">Fliers</button>
                                <button class="nav-link " id="v-pills-bn-tab" data-bs-toggle="pill" data-bs-target="#v-pills-bn" type="button" role="tab" aria-controls="v-pills-bn" aria-selected="true">Banners</button>
                                <button class="nav-link " id="v-pills-rb-tab" data-bs-toggle="pill" data-bs-target="#v-pills-rb" type="button" role="tab" aria-controls="v-pills-rb" aria-selected="true">Receipt books</button>
                                <button class="nav-link " id="v-pills-iv-tab" data-bs-toggle="pill" data-bs-target="#v-pills-iv" type="button" role="tab" aria-controls="v-pills-iv" aria-selected="true">Invoice</button>
                                <button class="nav-link " id="v-pills-cof-tab" data-bs-toggle="pill" data-bs-target="#v-pills-cof" type="button" role="tab" aria-controls="v-pills-cof" aria-selected="true">Customized office Files</button>
                                <button class="nav-link " id="v-pills-cc-tab" data-bs-toggle="pill" data-bs-target="#v-pills-cc" type="button" role="tab" aria-controls="v-pills-cc" aria-selected="true">Call cards</button>
                                <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Go back</button>
                            </div>
                            <div class="tab-content" id="v-pills-tabContent">
                                <!-- Exams -->
                                <?php 

                                    // CANCEL / RE ORDER
                                    if (isset($_GET['cancelexams']) && !empty($_GET['cancelexams'])) {
                                        // code...
                                        $order_id = sanitize($_GET['cancelexams']);
                                        $status = $_GET['status'];
                                        if ($status == 'new') {
                                            $status = 0;
                                        }
                                        if (is_numeric($order_id)) {
                                            $query = "
                                                UPDATE vonna_printjob 
                                                SET printjob_status = ? 
                                                WHERE printjob_id = ?
                                            ";
                                            $statement = $conn->prepare($query);
                                            $result = $statement->execute([$status, $order_id]);
                                            if ($result) {
                                                // code...
                                                $_SESSION['flash_success'] = 'Order cancel successfully.';
                                                redirect(PROOT . 'account/printjob-requests');
                                            } else {
                                                echo js_alert('Something went wrong... please try again.');
                                                redirect(PROOT . 'account/printjob-requests');
                                            }
                                        }
                                    }

                                    // DELETE ORDER
                                    if (isset($_GET['trashexams']) && !empty($_GET['trashexams'])) {
                                        // code...
                                        $order_id = sanitize($_GET['trashexams']);
                                        if (is_numeric($order_id)) {
                                            if ($_GET['media'] != '') {
                                                // code...
                                                $medias = explode(',', $_GET['media']);
                                                foreach ($medias as $media) {
                                                    if (file_exists(BASEURL . 'account/' . $media)) {
                                                        // code...
                                                        unlink(BASEURL . 'account/' . $media);
                                                    }
                                                }
                                            }

                                            $query = "
                                                DELETE FROM vonna_printjob 
                                                WHERE printjob_id = ?
                                            ";
                                            $statement = $conn->prepare($query);
                                            $result = $statement->execute([$order_id]);
                                            if ($result) {
                                                // code...
                                                $_SESSION['flash_success'] = 'Order deleted successfully.';
                                                redirect(PROOT . 'account/printjob-requests');
                                            } else {
                                                echo js_alert('Something went wrong... please try again.');
                                                redirect(PROOT . 'account/printjob-requests');
                                            }
                                        }
                                    }

                                ?>
                                <div class="tab-pane fade show active" id="v-pills-eq" role="tabpanel" aria-labelledby="v-pills-eq-tab" tabindex="0">
                                    <p class="text-center text-muted h2">Examination questions</p>
                                    <div class="table-responsive">
                                        <table class="table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID</th>
                                                    <th>Subjects</th>
                                                    <th>Total students</th>
                                                    <th>Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                    foreach ($exams as $exam): 
                                                ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td>
                                                        <?php
                                                            echo $exam["printjob_id"];

                                                            if ($exam['printjob_status'] == 0) {
                                                                // code...
                                                                echo '<br><span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                echo '&nbsp;<a href="?cancelexams='.$exam["printjob_id"].'&status=4" class="">cancel order</a>';
                                                            } elseif ($exam['printjob_status'] == 1) {
                                                                echo '<br><span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                            } elseif ($exam['printjob_status'] == 2) {
                                                                echo '<br><span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                            } elseif ($exam['printjob_status'] == 3) {
                                                                echo '<br><span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                            } elseif ($exam['printjob_status'] == 4) {
                                                                echo '<br><a href="?cancelexams='.$exam["printjob_id"].'&status=new" class="">re-order</a>';
                                                            } else {
                                                                echo '';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?= $exam["printjob_name_of_subject"]; ?></td>
                                                    <td><?= $exam["printjob_total_students"]; ?></td>
                                                    <td><?= pretty_date($exam["printjob_createdAt"]); ?></td>
                                                    <td>
                                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#Modal<?= $exam['printjob_id']; ?>" class="badge bg-primary mb-2"><i data-feather="eye"></i></a>
                                                        <a href="javascript:;"  onclick="(confirm('Order will be deleted!') ? window.location = '<?= PROOT; ?>account/printjob-requests?trashexams=<?= $exam['printjob_id']; ?>&media=<?= $exam['printjob_upload_typed_work']; ?>' : '');" class="badge bg-primary-soft"><i data-feather="trash"></i></a>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="Modal<?= $exam['printjob_id']; ?>" tabindex="-1" aria-labelledby="ModalLabel<?= $exam['printjob_id']; ?>" aria-modal="true" role="dialog">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center">
                                                                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                                                                <h1 class="mb-4" id="ModalLabel<?= $exam['printjob_id']; ?>">
                                                                    <?= $exam['printjob_id']; ?>
                                                                </h1>
                                                                <p class="text-muted">
                                                                    <?php 
                                                                        $outputexams_file = '';
                                                                        if ($exam['printjob_upload_typed_work'] != '') {
                                                                            // code...
                                                                            $exams_files = explode(',', $exam['printjob_upload_typed_work']);
                                                                            foreach ($exams_files as $exams_file) 
                                                                                $outputexams_file .= '<a href="'.$exams_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                                                        }

                                                                        if ($exam['printjob_status'] == 0) {
                                                                            echo '<span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                        } elseif ($exam['printjob_status'] == 1) {
                                                                            echo '<span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                                        } elseif ($exam['printjob_status'] == 2) {
                                                                            echo '<span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                                        } elseif ($exam['printjob_status'] == 3) {
                                                                            echo '<span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                                        }
                                                                    ?>
                                                                </p>
                                                                    
                                                                <ul class="list-group">
                                                                    <li class="list-group-item">
                                                                        <div class="ms-2 me-auto">
                                                                            <div class="fw-bold">Subject</div>
                                                                            <?php 
                                                                                $subjects = explode(',', $exam['printjob_name_of_subject']);
                                                                                $sb = '';
                                                                                foreach ($subjects as $subject) {
                                                                                    $sb .= '<div class="d-inline p-2 border m-1 text-bg-light">'.$subject.'</div>';
                                                                                }
                                                                                echo $sb;
                                                                            ?>
                                                                            <div class="fw-bold">No to be printed</div>
                                                                            <?php 
                                                                                $exams_prints = explode(',', $exam['printjob_number_to_be_printed']);
                                                                                $ep = '';
                                                                                foreach ($exams_prints as $exams_print) {
                                                                                    $ep .= '<div class="d-inline p-2 border m-1 text-bg-light">'.$exams_print.'</div>';
                                                                                }
                                                                                echo $ep;
                                                                            ?>
                                                                            <div class="fw-bold">Level</div>
                                                                            <?php 
                                                                                $exams_levels = explode(',', $exam['printjob_level']);
                                                                                $el = '';
                                                                                foreach ($exams_levels as $exams_level) {
                                                                                    $el .= '<div class="d-inline p-2 border m-1 text-bg-light">'.$exams_level.'</div>';
                                                                                }
                                                                                echo $el;
                                                                            ?>
                                                                            <div class="fw-bold">Class/Form</div>
                                                                            <?php 
                                                                                $exams_forms = explode(',', $exam['printjob_class_or_form']);
                                                                                $ecf = '';
                                                                                foreach ($exams_forms as $exams_form) {
                                                                                    $ecf .= '<div class="d-inline p-2 border m-1 text-bg-light">'.$exams_form.'</div>';
                                                                                }
                                                                                echo $ecf;
                                                                            ?>
                                                                        </div>
                                                                    </li>

                                                                    <li class="list-group-item"><span class="fw-bold text-info">What is the total size of your student body?</span> <?= $exam['printjob_total_students']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Do you have the questions typed already?</span> <?= $exam['printjob_typed_already']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">If yes, upload your typed work here:</span> <?= $outputexams_file; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">If no, Do you want us to type for you?</span> <?= $exam['printjob_want_us_to_type']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">When do you want the print job delivered?</span> <?= $exam['printjob_when_to_be_delivered']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Receipient Contact 1:</span> <?= $exam['printjob_delivery_address_1']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Receipient Contact 2:</span> <?= $exam['printjob_delivery_address_2']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Date: </span> <?= pretty_date($exam['printjob_createdAt']); ?></li>
                                                                </ul>
                                                                <!-- Text -->
                                                                <small class="text-muted mt-2">
                                                                    <a class="text-reset" data-bs-dismiss="modal" href="javascript:;">Close.</a>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $i++; endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Thesis -->
                                <?php 

                                    // CANCEL / RE ORDER
                                    if (isset($_GET['cancelthesis']) && !empty($_GET['cancelthesis'])) {
                                        // code...
                                        $order_id = sanitize($_GET['cancelthesis']);
                                        $status = $_GET['status'];
                                        if ($status == 'new') {
                                            $status = 0;
                                        }
                                        if (is_numeric($order_id)) {
                                            $query = "
                                                UPDATE vonna_printjob_thesis 
                                                SET thesis_status = ? 
                                                WHERE thesis_id = ?
                                            ";
                                            $statement = $conn->prepare($query);
                                            $result = $statement->execute([$status, $order_id]);
                                            if ($result) {
                                                // code...
                                                $_SESSION['flash_success'] = 'Order cancel successfully.';
                                                redirect(PROOT . 'account/printjob-requests');
                                            } else {
                                                echo js_alert('Something went wrong... please try again.');
                                                redirect(PROOT . 'account/printjob-requests');
                                            }
                                        }
                                    }

                                    // DELETE ORDER
                                    if (isset($_GET['trashthesis']) && !empty($_GET['trashthesis'])) {
                                        // code...
                                        $order_id = sanitize($_GET['trashthesis']);
                                        if (is_numeric($order_id)) {
                                            if ($_GET['media'] != '') {
                                                $medias = explode(',', $_GET['media']);
                                                foreach ($medias as $media) {
                                                    if (file_exists(BASEURL . 'account/' . $media)) {
                                                        unlink(BASEURL . 'account/' . $media);
                                                    }
                                                }
                                            }

                                            if ($_GET['media1'] != '') {
                                                $medias1 = explode(',', $_GET['media1']);
                                                foreach ($medias1 as $media1) {
                                                    if (file_exists(BASEURL . 'account/' . $media1)) {
                                                        unlink(BASEURL . 'account/' . $media1);
                                                    }
                                                }
                                            }

                                            $query = "
                                                DELETE FROM vonna_printjob_thesis 
                                                WHERE thesis_id = ?
                                            ";
                                            $statement = $conn->prepare($query);
                                            $result = $statement->execute([$order_id]);
                                            if ($result) {
                                                // code...
                                                $_SESSION['flash_success'] = 'Order deleted successfully.';
                                                redirect(PROOT . 'account/printjob-requests');
                                            } else {
                                                echo js_alert('Something went wrong... please try again.');
                                                redirect(PROOT . 'account/printjob-requests');
                                            }
                                        }
                                    }

                                ?>
                                <div class="tab-pane fade" id="v-pills-th" role="tabpanel" aria-labelledby="v-pills-th-tab" tabindex="0">
                                    <p class="text-center text-muted h2">THESIS/RESEARCH</p>
                                    <div class="table-responsive">
                                        <table class="table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID</th>
                                                    <th>Have a Topic</th>
                                                    <th>Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                    foreach ($thesiss as $thesis): 
                                                ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td>
                                                        <?php
                                                            echo $thesis["thesis_id"];

                                                            if ($thesis['thesis_status'] == 0) {
                                                                // code...
                                                                echo '<br><span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                echo '&nbsp;<a href="?cancelthesis='.$thesis["thesis_id"].'&status=4" class="">cancel order</a>';
                                                            } elseif ($thesis['thesis_status'] == 1) {
                                                                echo '<br><span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                            } elseif ($thesis['thesis_status'] == 2) {
                                                                echo '<br><span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                            } elseif ($thesis['thesis_status'] == 3) {
                                                                echo '<br><span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                            } elseif ($thesis['thesis_status'] == 4) {
                                                                echo '<br><a href="?cancelthesis='.$thesis["thesis_id"].'&status=new" class="">re-order</a>';
                                                            } else {
                                                                echo '';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?= $thesis["thesis_already_have_tr"]; ?></td>
                                                    <td><?= pretty_date($thesis["thesis_createdAt"]); ?></td>
                                                    <td>
                                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#Modal<?= $thesis['thesis_id']; ?>" class="badge bg-primary mb-2"><i data-feather="eye"></i></a>
                                                        <a href="javascript:;"  onclick="(confirm('Order will be deleted!') ? window.location = '<?= PROOT; ?>account/printjob-requests?trashthesis=<?= $thesis['thesis_id']; ?>&media=<?= $thesis['thesis_upload_work_tr']; ?>&media1=<?= $thesis['thesis_upload_tr']; ?>' : '');" class="badge bg-primary-soft"><i data-feather="trash"></i></a>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="Modal<?= $thesis['thesis_id']; ?>" tabindex="-1" aria-labelledby="ModalLabel<?= $thesis['thesis_id']; ?>" aria-modal="true" role="dialog">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center">
                                                                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                                                                <h1 class="mb-4" id="ModalLabel<?= $thesis['thesis_id']; ?>">
                                                                    <?= $thesis['thesis_id']; ?>
                                                                </h1>
                                                                <p class="text-muted">
                                                                    <?php 
                                                                        $outputthesis_file = '';
                                                                        if ($thesis['thesis_upload_work_tr'] != '') {
                                                                            // code...
                                                                            $thesis_files = explode(',', $thesis['thesis_upload_work_tr']);
                                                                            foreach ($thesis_files as $thesis_file) 
                                                                                $outputthesis_file .= '<a href="'.$thesis_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                                                        }

                                                                        $outputthesis_work_file = '';
                                                                        if ($thesis['thesis_upload_tr'] != '') {
                                                                            // code...
                                                                            $thesis_work_files = explode(',', $thesis['thesis_upload_tr']);
                                                                            foreach ($thesis_work_files as $thesis_work_file) 
                                                                                $outputthesis_work_file .= '<a href="'.$thesis_work_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                                                        }

                                                                        if ($thesis['thesis_status'] == 0) {
                                                                            echo '<span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                        } elseif ($thesis['thesis_status'] == 1) {
                                                                            echo '<span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                                        } elseif ($thesis['thesis_status'] == 2) {
                                                                            echo '<span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                                        } elseif ($thesis['thesis_status'] == 3) {
                                                                            echo '<span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                                        }
                                                                    ?>
                                                                </p>
                                                                    
                                                                <ul class="list-group">
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Do you have a thesis/research topic already?</span> <?= $thesis['thesis_already_have_tr']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">If yes, What is your thesis/research topic?</span> <?= $thesis['thesis_your_thesis_research']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">if no,would you want us to get you a suitable research/thesis topic?</span> <?= $thesis['thesis_get_for_you']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Have you typed your thesis/research already?</span> <?= $thesis['thesis_have_you_typed']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">if no, do you want us to handle the typing of your thesis/research for you?</span> <?= $thesis['thesis_handle_typing']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Have you effected the final editing to your thesis/research topic already?</span> <?= $thesis['thesis_final_editing']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">If yes , Upload your work here:</span> <?= $outputthesis_file; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">If no, upload your thesis/research so far:</span> <?= $outputthesis_work_file; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">When do you want your work delivered?</span> <?= $thesis['thesis_day_week'] . ' - ' . $thesis['thesis_delivered_tr']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Date: </span> <?= pretty_date($thesis['thesis_createdAt']); ?></li>
                                                                </ul>
                                                                <!-- Text -->
                                                                <small class="text-muted mt-2">
                                                                    <a class="text-reset" data-bs-dismiss="modal" href="javascript:;">Close.</a>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $i++; endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Fliers -->
                                <?php 

                                    // CANCEL / RE ORDER
                                    if (isset($_GET['cancelflier']) && !empty($_GET['cancelflier'])) {
                                        // code...
                                        $order_id = sanitize($_GET['cancelflier']);
                                        $status = $_GET['status'];
                                        if ($status == 'new') {
                                            $status = 0;
                                        }
                                        if (is_numeric($order_id)) {
                                            $query = "
                                                UPDATE vonna_printjob_fliers 
                                                SET flier_status = ? 
                                                WHERE flier_id = ?
                                            ";
                                            $statement = $conn->prepare($query);
                                            $result = $statement->execute([$status, $order_id]);
                                            if ($result) {
                                                // code...
                                                $_SESSION['flash_success'] = 'Order cancel successfully.';
                                                redirect(PROOT . 'account/printjob-requests');
                                            } else {
                                                echo js_alert('Something went wrong... please try again.');
                                                redirect(PROOT . 'account/printjob-requests');
                                            }
                                        }
                                    }

                                    // DELETE ORDER
                                    if (isset($_GET['trashflier']) && !empty($_GET['trashflier'])) {
                                        // code...
                                        $order_id = sanitize($_GET['trashflier']);
                                        if (is_numeric($order_id)) {
                                            if ($_GET['media'] != '') {
                                                $medias = explode(',', $_GET['media']);
                                                foreach ($medias as $media) {
                                                    if (file_exists(BASEURL . 'account/' . $media)) {
                                                        unlink(BASEURL . 'account/' . $media);
                                                    }
                                                }
                                            }

                                            $query = "
                                                DELETE FROM vonna_printjob_fliers 
                                                WHERE flier_id = ?
                                            ";
                                            $statement = $conn->prepare($query);
                                            $result = $statement->execute([$order_id]);
                                            if ($result) {
                                                // code...
                                                $_SESSION['flash_success'] = 'Order deleted successfully.';
                                                redirect(PROOT . 'account/printjob-requests');
                                            } else {
                                                echo js_alert('Something went wrong... please try again.');
                                                redirect(PROOT . 'account/printjob-requests');
                                            }
                                        }
                                    }

                                ?>
                                <div class="tab-pane fade" id="v-pills-fl" role="tabpanel" aria-labelledby="v-pills-fl-tab" tabindex="0">
                                    <p class="text-center text-muted h2">FLIERS</p>
                                    <div class="table-responsive">
                                        <table class="table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID</th>
                                                    <th>Size</th>
                                                    <th>Quantity</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                    foreach ($fliers as $flier): 
                                                ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td>
                                                        <?php
                                                            echo $flier["flier_id"];

                                                            if ($flier['flier_status'] == 0) {
                                                                // code...
                                                                echo '<br><span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                echo '&nbsp;<a href="?cancelflier='.$flier["flier_id"].'&status=4" class="">cancel order</a>';
                                                            } elseif ($flier['flier_status'] == 1) {
                                                                echo '<br><span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                            } elseif ($flier['flier_status'] == 2) {
                                                                echo '<br><span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                            } elseif ($flier['flier_status'] == 3) {
                                                                echo '<br><span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                            } elseif ($flier['flier_status'] == 4) {
                                                                echo '<br><a href="?cancelflier='.$flier["flier_id"].'&status=new" class="">re-order</a>';
                                                            } else {
                                                                echo '';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?= $flier["flier_size_to_print"]; ?></td>
                                                    <td><?= $flier["flier_quantity_to_print"]; ?></td>
                                                    <td><?= pretty_date($flier["flier_createdAt"]); ?></td>
                                                    <td>
                                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#Modal<?= $flier['flier_id']; ?>" class="badge bg-primary mb-2"><i data-feather="eye"></i></a>
                                                        <a href="javascript:;"  onclick="(confirm('Order will be deleted!') ? window.location = '<?= PROOT; ?>account/printjob-requests?trashflier=<?= $flier['flier_id']; ?>&media=<?= $flier['flier_design_file']; ?>' : '');" class="badge bg-primary-soft"><i data-feather="trash"></i></a>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="Modal<?= $flier['flier_id']; ?>" tabindex="-1" aria-labelledby="ModalLabel<?= $flier['flier_id']; ?>" aria-modal="true" role="dialog">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center">
                                                                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                                                                <h1 class="mb-4" id="ModalLabel<?= $flier['flier_id']; ?>">
                                                                    <?= $flier['flier_id']; ?>
                                                                </h1>
                                                                <p class="text-muted">
                                                                    <?php 
                                                                        $outputflier_file = '';
                                                                        if ($flier['flier_design_file'] != '') {
                                                                            // code...
                                                                            $flier_files = explode(',', $flier['flier_design_file']);
                                                                            foreach ($flier_files as $flier_file) 
                                                                                $outputflier_file .= '<a href="'.$flier_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                                                        }

                                                                        if ($flier['flier_status'] == 0) {
                                                                            echo '<span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                        } elseif ($flier['flier_status'] == 1) {
                                                                            echo '<span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                                        } elseif ($flier['flier_status'] == 2) {
                                                                            echo '<span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                                        } elseif ($flier['flier_status'] == 3) {
                                                                            echo '<span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                                        }
                                                                    ?>
                                                                </p>
                                                                    
                                                                <ul class="list-group">
                                                                    <li class="list-group-item"><span class="fw-bold text-info">What size do you want to print?</span> <?= $flier['flier_size_to_print']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">what quantity do you want to print?</span> <?= $flier['flier_quantity_to_print']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Do you have your design(s) already?</span> <?= $flier['flier_have_designs']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">If NO, Do you want us to design your flier for you?</span> <?= $flier['flier_us_to_design']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">If yes What occasion are you designing the flier for?</span> <?= $flier['flier_for']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Upload your design(s) here:</span> <?= $outputflier_file; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">When do you want the job delivered?</span> <?= $flier['flier_date_to_deliver']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Date: </span> <?= pretty_date($flier['flier_createdAt']); ?></li>
                                                                </ul>
                                                                <!-- Text -->
                                                                <small class="text-muted mt-2">
                                                                    <a class="text-reset" data-bs-dismiss="modal" href="javascript:;">Close.</a>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $i++; endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Banners -->
                                <?php 

                                    // CANCEL / RE ORDER
                                    if (isset($_GET['cancelbanner']) && !empty($_GET['cancelbanner'])) {
                                        // code...
                                        $order_id = sanitize($_GET['cancelbanner']);
                                        $status = $_GET['status'];
                                        if ($status == 'new') {
                                            $status = 0;
                                        }
                                        if (is_numeric($order_id)) {
                                            $query = "
                                                UPDATE vonna_printjob_banners 
                                                SET banner_status = ? 
                                                WHERE banner_id = ?
                                            ";
                                            $statement = $conn->prepare($query);
                                            $result = $statement->execute([$status, $order_id]);
                                            if ($result) {
                                                // code...
                                                $_SESSION['flash_success'] = 'Order cancel successfully.';
                                                redirect(PROOT . 'account/printjob-requests');
                                            } else {
                                                echo js_alert('Something went wrong... please try again.');
                                                redirect(PROOT . 'account/printjob-requests');
                                            }
                                        }
                                    }

                                    // DELETE ORDER
                                    if (isset($_GET['trashbanner']) && !empty($_GET['trashbanner'])) {
                                        // code...
                                        $order_id = sanitize($_GET['trashbanner']);
                                        if (is_numeric($order_id)) {
                                            if ($_GET['media'] != '') {
                                                $medias = explode(',', $_GET['media']);
                                                foreach ($medias as $media) {
                                                    if (file_exists(BASEURL . 'account/' . $media)) {
                                                        unlink(BASEURL . 'account/' . $media);
                                                    }
                                                }
                                            }

                                            $query = "
                                                DELETE FROM vonna_printjob_banners 
                                                WHERE banner_id = ?
                                            ";
                                            $statement = $conn->prepare($query);
                                            $result = $statement->execute([$order_id]);
                                            if ($result) {
                                                // code...
                                                $_SESSION['flash_success'] = 'Order deleted successfully.';
                                                redirect(PROOT . 'account/printjob-requests');
                                            } else {
                                                echo js_alert('Something went wrong... please try again.');
                                                redirect(PROOT . 'account/printjob-requests');
                                            }
                                        }
                                    }

                                ?>
                                <div class="tab-pane fade" id="v-pills-bn" role="tabpanel" aria-labelledby="v-pills-bn-tab" tabindex="0">
                                    <p class="text-center text-muted h2">BANNERS</p>
                                    <div class="table-responsive">
                                        <table class="table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID</th>
                                                    <th>Size</th>
                                                    <th>Quantity</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                    foreach ($banners as $banner): 
                                                ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td>
                                                        <?php
                                                            echo $banner["banner_id"];

                                                            if ($banner['banner_status'] == 0) {
                                                                // code...
                                                                echo '<br><span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                echo '&nbsp;<a href="?cancelbanner='.$banner["banner_id"].'&status=4" class="">cancel order</a>';
                                                            } elseif ($banner['banner_status'] == 1) {
                                                                echo '<br><span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                            } elseif ($banner['banner_status'] == 2) {
                                                                echo '<br><span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                            } elseif ($banner['banner_status'] == 3) {
                                                                echo '<br><span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                            } elseif ($banner['banner_status'] == 4) {
                                                                echo '<br><a href="?cancelbanner='.$banner["banner_id"].'&status=new" class="">re-order</a>';
                                                            } else {
                                                                echo '';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?= $banner["banner_size"]; ?></td>
                                                    <td><?= $banner["banner_quantity"]; ?></td>
                                                    <td><?= pretty_date($banner["banner_createdAt"]); ?></td>
                                                    <td>
                                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#Modal<?= $banner['banner_id']; ?>" class="badge bg-primary mb-2"><i data-feather="eye"></i></a>
                                                        <a href="javascript:;"  onclick="(confirm('Order will be deleted!') ? window.location = '<?= PROOT; ?>account/printjob-requests?trashbanner=<?= $banner['banner_id']; ?>&media=<?= $banner['banner_upload_design']; ?>' : '');" class="badge bg-primary-soft"><i data-feather="trash"></i></a>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="Modal<?= $banner['banner_id']; ?>" tabindex="-1" aria-labelledby="ModalLabel<?= $banner['banner_id']; ?>" aria-modal="true" role="dialog">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center">
                                                                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                                                                <h1 class="mb-4" id="ModalLabel<?= $banner['banner_id']; ?>">
                                                                    <?= $banner['banner_id']; ?>
                                                                </h1>
                                                                <p class="text-muted">
                                                                    <?php 
                                                                        $outputbanner_file = '';
                                                                        if ($banner['banner_upload_design'] != '') {
                                                                            // code...
                                                                            $banner_files = explode(',', $banner['banner_upload_design']);
                                                                            foreach ($banner_files as $banner_file) 
                                                                                $outputbanner_file .= '<a href="'.$banner_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                                                        }

                                                                        if ($banner['banner_status'] == 0) {
                                                                            echo '<span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                        } elseif ($banner['banner_status'] == 1) {
                                                                            echo '<span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                                        } elseif ($banner['banner_status'] == 2) {
                                                                            echo '<span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                                        } elseif ($banner['banner_status'] == 3) {
                                                                            echo '<span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                                        }
                                                                    ?>
                                                                </p>
                                                                    
                                                                <ul class="list-group">
                                                                    <li class="list-group-item"><span class="fw-bold text-info">What size do you want?</span> <?= $banner['banner_size']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">What quantity do you want?</span> <?= $banner['banner_quantity']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Do you have your designs already?</span> <?= $banner['have_banner_designs']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">If yes, Upload your design here:</span> <?= $outputbanner_file; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">If No, Do you want us to do the design for you?</span> <?= $banner['banner_want_us']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Date: </span> <?= pretty_date($banner['banner_createdAt']); ?></li>
                                                                </ul>
                                                                <!-- Text -->
                                                                <small class="text-muted mt-2">
                                                                    <a class="text-reset" data-bs-dismiss="modal" href="javascript:;">Close.</a>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $i++; endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Receipt -->
                                <?php 

                                    // CANCEL / RE ORDER
                                    if (isset($_GET['cancelreceipt']) && !empty($_GET['cancelreceipt'])) {
                                        // code...
                                        $order_id = sanitize($_GET['cancelreceipt']);
                                        $status = $_GET['status'];
                                        if ($status == 'new') {
                                            $status = 0;
                                        }
                                        if (is_numeric($order_id)) {
                                            $query = "
                                                UPDATE vonna_print_job_receipt 
                                                SET receipt_status = ? 
                                                WHERE receipt_id = ?
                                            ";
                                            $statement = $conn->prepare($query);
                                            $result = $statement->execute([$status, $order_id]);
                                            if ($result) {
                                                // code...
                                                $_SESSION['flash_success'] = 'Order cancel successfully.';
                                                redirect(PROOT . 'account/printjob-requests');
                                            } else {
                                                echo js_alert('Something went wrong... please try again.');
                                                redirect(PROOT . 'account/printjob-requests');
                                            }
                                        }
                                    }

                                    // DELETE ORDER
                                    if (isset($_GET['trashreceipt']) && !empty($_GET['trashreceipt'])) {
                                        // code...
                                        $order_id = sanitize($_GET['trashreceipt']);
                                        if (is_numeric($order_id)) {
                                            if ($_GET['media'] != '') {
                                                $medias = explode(',', $_GET['media']);
                                                foreach ($medias as $media) {
                                                    if (file_exists(BASEURL . 'account/' . $media)) {
                                                        unlink(BASEURL . 'account/' . $media);
                                                    }
                                                }
                                            }

                                            if ($_GET['media1'] != '') {
                                                $medias1 = explode(',', $_GET['media1']);
                                                foreach ($medias1 as $media1) {
                                                    if (file_exists(BASEURL . 'account/' . $media1)) {
                                                        unlink(BASEURL . 'account/' . $media1);
                                                    }
                                                }
                                            }

                                            $query = "
                                                DELETE FROM vonna_print_job_receipt 
                                                WHERE receipt_id = ?
                                            ";
                                            $statement = $conn->prepare($query);
                                            $result = $statement->execute([$order_id]);
                                            if ($result) {
                                                // code...
                                                $_SESSION['flash_success'] = 'Order deleted successfully.';
                                                redirect(PROOT . 'account/printjob-requests');
                                            } else {
                                                echo js_alert('Something went wrong... please try again.');
                                                redirect(PROOT . 'account/printjob-requests');
                                            }
                                        }
                                    }

                                ?>
                                <div class="tab-pane fade" id="v-pills-rb" role="tabpanel" aria-labelledby="v-pills-rb-tab" tabindex="0">
                                    <p class="text-center text-muted h2">RECEIPT BOOKS</p>
                                    <div class="table-responsive">
                                        <table class="table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID</th>
                                                    <th>Outfit name</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                    foreach ($receipts as $receipt): 
                                                ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td>
                                                        <?php
                                                            echo $receipt["receipt_id"];

                                                            if ($receipt['receipt_status'] == 0) {
                                                                // code...
                                                                echo '<br><span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                echo '&nbsp;<a href="?cancelreceipt='.$receipt["receipt_id"].'&status=4" class="">cancel order</a>';
                                                            } elseif ($receipt['receipt_status'] == 1) {
                                                                echo '<br><span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                            } elseif ($receipt['receipt_status'] == 2) {
                                                                echo '<br><span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                            } elseif ($receipt['receipt_status'] == 3) {
                                                                echo '<br><span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                            } elseif ($receipt['receipt_status'] == 4) {
                                                                echo '<br><a href="?cancelreceipt='.$receipt["receipt_id"].'&status=new" class="">re-order</a>';
                                                            } else {
                                                                echo '';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?= $receipt["receipt_outfit_name"]; ?></td>
                                                    <td><?= $receipt["receipt_type"]; ?></td>
                                                    <td><?= pretty_date($receipt["receipt_createdAt"]); ?></td>
                                                    <td>
                                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#Modal<?= $receipt['receipt_id']; ?>" class="badge bg-primary mb-2"><i data-feather="eye"></i></a>
                                                        <a href="javascript:;"  onclick="(confirm('Order will be deleted!') ? window.location = '<?= PROOT; ?>account/printjob-requests?trashreceipt=<?= $receipt['receipt_id']; ?>&media=<?= $receipt['receipt_upload_logo']; ?>&media1=<?= $receipt['receipt_upload_outfit_design']; ?>' : '');" class="badge bg-primary-soft"><i data-feather="trash"></i></a>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="Modal<?= $receipt['receipt_id']; ?>" tabindex="-1" aria-labelledby="ModalLabel<?= $receipt['receipt_id']; ?>" aria-modal="true" role="dialog">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center">
                                                                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                                                                <h1 class="mb-4" id="ModalLabel<?= $receipt['receipt_id']; ?>">
                                                                    <?= $receipt['receipt_id']; ?>
                                                                </h1>
                                                                <p class="text-muted">
                                                                    <?php 
                                                                        $outputreceipt_logo = '';
                                                                        if ($receipt['receipt_upload_logo'] != '') {
                                                                            // code...
                                                                            $receipt_logos = explode(',', $receipt['receipt_upload_logo']);
                                                                            foreach ($receipt_logos as $receipt_logo) 
                                                                                $outputreceipt_logo .= '<a href="'.$receipt_logo.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                                                        }

                                                                        $outputreceipt_file = '';
                                                                        if ($receipt['receipt_upload_outfit_design'] != '') {
                                                                            // code...
                                                                            $receipt_files = explode(',', $receipt['receipt_upload_outfit_design']);
                                                                            foreach ($receipt_files as $receipt_file) 
                                                                                $outputreceipt_file .= '<a href="'.$receipt_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                                                        }

                                                                        if ($receipt['receipt_status'] == 0) {
                                                                            echo '<span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                        } elseif ($receipt['receipt_status'] == 1) {
                                                                            echo '<span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                                        } elseif ($receipt['receipt_status'] == 2) {
                                                                            echo '<span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                                        } elseif ($receipt['receipt_status'] == 3) {
                                                                            echo '<span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                                        }
                                                                    ?>
                                                                </p>
                                                                    
                                                                <ul class="list-group">
                                                                    <li class="list-group-item"><span class="fw-bold text-info">what is the name of your outfit?</span> <?= $receipt['receipt_outfit_name']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">what type of receipt book do you want?</span> <?= $receipt['receipt_type']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">if Customized,Do you have a logo for your company?</span> <?= $receipt['receipt_want_logo']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">if yes, upload your logo here:</span> <?= $outputreceipt_logo; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">How many receipt books do you want?</span> <?= $receipt['receipt_quantity']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">When do you want the receipt books delivered?</span> <?= $receipt['receipt_delivery_date']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Upload the design of your outfit for the design:</span> <?= $outputreceipt_file; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Date: </span> <?= pretty_date($receipt['receipt_createdAt']); ?></li>
                                                                </ul>
                                                                <!-- Text -->
                                                                <small class="text-muted mt-2">
                                                                    <a class="text-reset" data-bs-dismiss="modal" href="javascript:;">Close.</a>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $i++; endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Invoice -->
                                <?php 

                                    // CANCEL / RE ORDER
                                    if (isset($_GET['cancelinvoice']) && !empty($_GET['cancelinvoice'])) {
                                        // code...
                                        $order_id = sanitize($_GET['cancelinvoice']);
                                        $status = $_GET['status'];
                                        if ($status == 'new') {
                                            $status = 0;
                                        }
                                        if (is_numeric($order_id)) {
                                            $query = "
                                                UPDATE vonna_print_job_invoice 
                                                SET invoice_status = ? 
                                                WHERE invoice_id = ?
                                            ";
                                            $statement = $conn->prepare($query);
                                            $result = $statement->execute([$status, $order_id]);
                                            if ($result) {
                                                // code...
                                                $_SESSION['flash_success'] = 'Order cancel successfully.';
                                                redirect(PROOT . 'account/printjob-requests');
                                            } else {
                                                echo js_alert('Something went wrong... please try again.');
                                                redirect(PROOT . 'account/printjob-requests');
                                            }
                                        }
                                    }

                                    // DELETE ORDER
                                    if (isset($_GET['trashinvoice']) && !empty($_GET['trashinvoice'])) {
                                        // code...
                                        $order_id = sanitize($_GET['trashinvoice']);
                                        if (is_numeric($order_id)) {
                                            if ($_GET['media'] != '') {
                                                $medias = explode(',', $_GET['media']);
                                                foreach ($medias as $media) {
                                                    if (file_exists(BASEURL . 'account/' . $media)) {
                                                        unlink(BASEURL . 'account/' . $media);
                                                    }
                                                }
                                            }

                                            if ($_GET['media1'] != '') {
                                                $medias1 = explode(',', $_GET['media1']);
                                                foreach ($medias1 as $media1) {
                                                    if (file_exists(BASEURL . 'account/' . $media1)) {
                                                        unlink(BASEURL . 'account/' . $media1);
                                                    }
                                                }
                                            }

                                            $query = "
                                                DELETE FROM vonna_print_job_invoice 
                                                WHERE invoice_id = ?
                                            ";
                                            $statement = $conn->prepare($query);
                                            $result = $statement->execute([$order_id]);
                                            if ($result) {
                                                // code...
                                                $_SESSION['flash_success'] = 'Order deleted successfully.';
                                                redirect(PROOT . 'account/printjob-requests');
                                            } else {
                                                echo js_alert('Something went wrong... please try again.');
                                                redirect(PROOT . 'account/printjob-requests');
                                            }
                                        }
                                    }

                                ?>
                                <div class="tab-pane fade" id="v-pills-iv" role="tabpanel" aria-labelledby="v-pills-iv-tab" tabindex="0">
                                    <p class="text-center text-muted h2">INVOICE</p>
                                
                                    <div class="table-responsive">
                                        <table class="table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID</th>
                                                    <th>Outfit name</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                    foreach ($invoices as $invoice): 
                                                ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td>
                                                        <?php
                                                            echo $invoice["invoice_id"];

                                                            if ($invoice['invoice_status'] == 0) {
                                                                // code...
                                                                echo '<br><span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                echo '&nbsp;<a href="?cancelinvoice='.$invoice["invoice_id"].'&status=4" class="">cancel order</a>';
                                                            } elseif ($invoice['invoice_status'] == 1) {
                                                                echo '<br><span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                            } elseif ($invoice['invoice_status'] == 2) {
                                                                echo '<br><span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                            } elseif ($invoice['invoice_status'] == 3) {
                                                                echo '<br><span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                            } elseif ($invoice['invoice_status'] == 4) {
                                                                echo '<br><a href="?cancelinvoice='.$invoice["invoice_id"].'&status=new" class="">re-order</a>';
                                                            } else {
                                                                echo '';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?= $invoice["invoice_outfit_name"]; ?></td>
                                                    <td><?= $invoice["invoice_type"]; ?></td>
                                                    <td><?= pretty_date($invoice["invoice_createdAt"]); ?></td>
                                                    <td>
                                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#Modal<?= $invoice['invoice_id']; ?>" class="badge bg-primary mb-2"><i data-feather="eye"></i></a>
                                                        <a href="javascript:;"  onclick="(confirm('Order will be deleted!') ? window.location = '<?= PROOT; ?>account/printjob-requests?trashinvoice=<?= $invoice['invoice_id']; ?>&media=<?= $invoice['invoice_upload_logo']; ?>&media1=<?= $invoice['invoice_upload_outfit_design']; ?>' : '');" class="badge bg-primary-soft"><i data-feather="trash"></i></a>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="Modal<?= $invoice['invoice_id']; ?>" tabindex="-1" aria-labelledby="ModalLabel<?= $invoice['invoice_id']; ?>" aria-modal="true" role="dialog">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center">
                                                                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                                                                <h1 class="mb-4" id="ModalLabel<?= $invoice['invoice_id']; ?>">
                                                                    <?= $invoice['invoice_id']; ?>
                                                                </h1>
                                                                <p class="text-muted">
                                                                    <?php 
                                                                        $outputinvoice_logo = '';
                                                                        if ($invoice['invoice_upload_logo'] != '') {
                                                                            // code...
                                                                            $invoice_logos = explode(',', $invoice['invoice_upload_logo']);
                                                                            foreach ($invoice_logos as $invoice_logo) 
                                                                                $outputinvoice_logo .= '<a href="'.$invoice_logo.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                                                        }

                                                                        $outputinvoice_file = '';
                                                                        if ($invoice['invoice_upload_outfit_design'] != '') {
                                                                            // code...
                                                                            $invoice_files = explode(',', $invoice['invoice_upload_outfit_design']);
                                                                            foreach ($invoice_files as $invoice_file) 
                                                                                $outputinvoice_file .= '<a href="'.$invoice_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                                                        }

                                                                        if ($invoice['invoice_status'] == 0) {
                                                                            echo '<span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                        } elseif ($invoice['invoice_status'] == 1) {
                                                                            echo '<span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                                        } elseif ($invoice['invoice_status'] == 2) {
                                                                            echo '<span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                                        } elseif ($invoice['invoice_status'] == 3) {
                                                                            echo '<span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                                        }
                                                                    ?>
                                                                </p>
                                                                    
                                                                <ul class="list-group">
                                                                    <li class="list-group-item"><span class="fw-bold text-info">what is the name of your outfit?</span> <?= $invoice['invoice_outfit_name']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">what type of receipt book do you want?</span> <?= $invoice['invoice_type']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">if Customized,Do you have a logo for your company?</span> <?= $invoice['invoice_want_logo']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">if yes, upload your logo here:</span> <?= $outputinvoice_logo; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">How many receipt books do you want?</span> <?= $invoice['invoice_quantity']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">When do you want the receipt books delivered?</span> <?= $invoice['invoice_delivery_date']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Upload the design of your outfit for the design:</span> <?= $outputinvoice_file; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Date: </span> <?= pretty_date($invoice['invoice_createdAt']); ?></li>
                                                                </ul>
                                                                <!-- Text -->
                                                                <small class="text-muted mt-2">
                                                                    <a class="text-reset" data-bs-dismiss="modal" href="javascript:;">Close.</a>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $i++; endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Customize -->
                                <?php 

                                    // CANCEL / RE ORDER
                                    if (isset($_GET['cancelcustomize']) && !empty($_GET['cancelcustomize'])) {
                                        // code...
                                        $order_id = sanitize($_GET['cancelcustomize']);
                                        $status = $_GET['status'];
                                        if ($status == 'new') {
                                            $status = 0;
                                        }
                                        if (is_numeric($order_id)) {
                                            $query = "
                                                UPDATE vonna_print_job_customze 
                                                SET customze_status = ? 
                                                WHERE customze_id = ?
                                            ";
                                            $statement = $conn->prepare($query);
                                            $result = $statement->execute([$status, $order_id]);
                                            if ($result) {
                                                // code...
                                                $_SESSION['flash_success'] = 'Order cancel successfully.';
                                                redirect(PROOT . 'account/printjob-requests');
                                            } else {
                                                echo js_alert('Something went wrong... please try again.');
                                                redirect(PROOT . 'account/printjob-requests');
                                            }
                                        }
                                    }

                                    // DELETE ORDER
                                    if (isset($_GET['trashcustomize']) && !empty($_GET['trashcustomize'])) {
                                        // code...
                                        $order_id = sanitize($_GET['trashcustomize']);
                                        if (is_numeric($order_id)) {
                                            if ($_GET['media'] != '') {
                                                $medias = explode(',', $_GET['media']);
                                                foreach ($medias as $media) {
                                                    if (file_exists(BASEURL . 'account/' . $media)) {
                                                        unlink(BASEURL . 'account/' . $media);
                                                    }
                                                }
                                            }

                                            $query = "
                                                DELETE FROM vonna_print_job_customze 
                                                WHERE customze_id = ?
                                            ";
                                            $statement = $conn->prepare($query);
                                            $result = $statement->execute([$order_id]);
                                            if ($result) {
                                                // code...
                                                $_SESSION['flash_success'] = 'Order deleted successfully.';
                                               redirect(PROOT . 'account/printjob-requests');
                                            } else {
                                                echo js_alert('Something went wrong... please try again.');
                                                redirect(PROOT . 'account/printjob-requests');
                                            }
                                        }
                                    }

                                ?>
                                <div class="tab-pane fade" id="v-pills-cof" role="tabpanel" aria-labelledby="v-pills-cof-tab" tabindex="0">
                                    <p class="text-center text-muted h2">CUSTOMIZES OFFICE FILES</p>
                                    <div class="table-responsive">
                                        <table class="table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID</th>
                                                    <th>Outfit name</th>
                                                    <th>Address</th>
                                                    <th>Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                    foreach ($cutomizes as $customize): 
                                                ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td>
                                                        <?php
                                                            echo $customize["customze_id"];

                                                            if ($customize['customze_status'] == 0) {
                                                                // code...
                                                                echo '<br><span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                echo '&nbsp;<a href="?cancelcustomize='.$customize["customze_id"].'&status=4" class="">cancel order</a>';
                                                            } elseif ($customize['customze_status'] == 1) {
                                                                echo '<br><span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                            } elseif ($customize['customze_status'] == 2) {
                                                                echo '<br><span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                            } elseif ($customize['customze_status'] == 3) {
                                                                echo '<br><span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                            } elseif ($customize['customze_status'] == 4) {
                                                                echo '<br><a href="?cancelcustomize='.$customize["customze_id"].'&status=new" class="">re-order</a>';
                                                            } else {
                                                                echo '';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?= $customize["customize_outfit_name"]; ?></td>
                                                    <td><?= $customize["customize_outfit_address"]; ?></td>
                                                    <td><?= pretty_date($customize["customze_createdAt"]); ?></td>
                                                    <td>
                                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#Modal<?= $customize['customze_id']; ?>" class="badge bg-primary mb-2"><i data-feather="eye"></i></a>
                                                        <a href="javascript:;"  onclick="(confirm('Order will be deleted!') ? window.location = '<?= PROOT; ?>account/printjob-requests?trashcustomize=<?= $customize['customze_id']; ?>&media=<?= $customize['customize_upload_logo']; ?>' : '');" class="badge bg-primary-soft"><i data-feather="trash"></i></a>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="Modal<?= $customize['customze_id']; ?>" tabindex="-1" aria-labelledby="ModalLabel<?= $customize['customze_id']; ?>" aria-modal="true" role="dialog">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center">
                                                                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                                                                <h1 class="mb-4" id="ModalLabel<?= $customize['customze_id']; ?>">
                                                                    <?= $customize['customze_id']; ?>
                                                                </h1>
                                                                <p class="text-muted">
                                                                    <?php 
                                                                        $outputcustomize_logo = '';
                                                                        if ($customize['customize_upload_logo'] != '') {
                                                                            // code...
                                                                            $customize_logos = explode(',', $customize['customize_upload_logo']);
                                                                            foreach ($customize_logos as $customize_logo) 
                                                                                $outputcustomize_logo .= '<a href="'.$customize_logo.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                                                        }

                                                                        if ($customize['customze_status'] == 0) {
                                                                            echo '<span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                        } elseif ($customize['customze_status'] == 1) {
                                                                            echo '<span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                                        } elseif ($customize['customze_status'] == 2) {
                                                                            echo '<span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                                        } elseif ($customize['customze_status'] == 3) {
                                                                            echo '<span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                                        }
                                                                    ?>
                                                                </p>
                                                                    
                                                                <ul class="list-group">
                                                                    <li class="list-group-item"><span class="fw-bold text-info">What is the name of your outfit?</span> <?= $customize['customize_outfit_name']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">what is your the addresss of your outfit?</span> <?= $customize['customize_outfit_address']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Contact:</span> <?= $customize['customize_contact']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Email:</span> <?= $customize['customize_email']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Location:</span> <?= $customize['customize_location']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">GPS address:</span> <?= $customize['customize_gps']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Does your company have a logo?</span> <?= $customize['customize_have_logo']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">if yes, upload your logo here:</span> <?= $outputcustomize_logo; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">If No, Do you want us to design a logo for your company?</span> <?= $customize['customze_us_to_design_logo']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Date: </span> <?= pretty_date($customize['customze_createdAt']); ?></li>
                                                                </ul>
                                                                <!-- Text -->
                                                                <small class="text-muted mt-2">
                                                                    <a class="text-reset" data-bs-dismiss="modal" href="javascript:;">Close.</a>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $i++; endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <!-- Call cards -->
                                <?php 

                                    // CANCEL / RE ORDER
                                    if (isset($_GET['cancelcards']) && !empty($_GET['cancelcards'])) {
                                        // code...
                                        $order_id = sanitize($_GET['cancelcards']);
                                        $status = $_GET['status'];
                                        if ($status == 'new') {
                                            $status = 0;
                                        }
                                        if (is_numeric($order_id)) {
                                            $query = "
                                                UPDATE vonna_printjob_callcards 
                                                SET card_status = ? 
                                                WHERE card_id = ?
                                            ";
                                            $statement = $conn->prepare($query);
                                            $result = $statement->execute([$status, $order_id]);
                                            if ($result) {
                                                // code...
                                                $_SESSION['flash_success'] = 'Order cancel successfully.';
                                                redirect(PROOT . 'account/printjob-requests');
                                            } else {
                                                echo js_alert('Something went wrong... please try again.');
                                                redirect(PROOT . 'account/printjob-requests');
                                            }
                                        }
                                    }

                                    // DELETE ORDER
                                    if (isset($_GET['trashcards']) && !empty($_GET['trashcards'])) {
                                        // code...
                                        $order_id = sanitize($_GET['trashcards']);
                                        if (is_numeric($order_id)) {
                                            if ($_GET['media'] != '') {
                                                $medias = explode(',', $_GET['media']);
                                                foreach ($medias as $media) {
                                                    if (file_exists(BASEURL . 'account/' . $media)) {
                                                        unlink(BASEURL . 'account/' . $media);
                                                    }
                                                }
                                            }

                                            $query = "
                                                DELETE FROM vonna_printjob_callcards 
                                                WHERE card_id = ?
                                            ";
                                            $statement = $conn->prepare($query);
                                            $result = $statement->execute([$order_id]);
                                            if ($result) {
                                                // code...
                                                $_SESSION['flash_success'] = 'Order deleted successfully.';
                                               redirect(PROOT . 'account/printjob-requests');
                                            } else {
                                                echo js_alert('Something went wrong... please try again.');
                                                redirect(PROOT . 'account/printjob-requests');
                                            }
                                        }
                                    }

                                ?>
                                <div class="tab-pane fade" id="v-pills-cc" role="tabpanel" aria-labelledby="v-pills-cc-tab" tabindex="0">
                                    <p class="text-center text-muted h2">CALL CARDS</p>
                                    <div class="table-responsive">
                                        <table class="table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Company name</th>
                                                    <th>Address</th>
                                                    <th>Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                    foreach ($callcards as $callcard): 
                                                ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td>
                                                        <?php
                                                            echo $callcard["card_id"];

                                                            if ($callcard['card_status'] == 0) {
                                                                // code...
                                                                echo '<br><span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                echo '&nbsp;<a href="?cancelcards='.$callcard["card_id"].'&status=4" class="">cancel order</a>';
                                                            } elseif ($callcard['card_status'] == 1) {
                                                                echo '<br><span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                            } elseif ($callcard['card_status'] == 2) {
                                                                echo '<br><span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                            } elseif ($callcard['card_status'] == 3) {
                                                                echo '<br><span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                            } elseif ($callcard['card_status'] == 4) {
                                                                echo '<br><a href="?cancelcards='.$callcard["card_id"].'&status=new" class="">re-order</a>';
                                                            } else {
                                                                echo '';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?= $callcard["card_name"]; ?></td>
                                                    <td><?= $callcard["card_company_name"]; ?></td>
                                                    <td><?= $callcard["card_address"]; ?></td>
                                                    <td><?= pretty_date($callcard["card_createdAt"]); ?></td>
                                                    <td>
                                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#Modal<?= $callcard['card_id']; ?>" class="badge bg-primary mb-2"><i data-feather="eye"></i></a>
                                                        <a href="javascript:;"  onclick="(confirm('Order will be deleted!') ? window.location = '<?= PROOT; ?>account/printjob-requests?trashcards=<?= $callcard['card_id']; ?>&media=<?= $callcard['card_upload_logo']; ?>' : '');" class="badge bg-primary-soft"><i data-feather="trash"></i></a>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="Modal<?= $callcard['card_id']; ?>" tabindex="-1" aria-labelledby="ModalLabel<?= $callcard['card_id']; ?>" aria-modal="true" role="dialog">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center">
                                                                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                                                                <h1 class="mb-4" id="ModalLabel<?= $callcard['card_id']; ?>">
                                                                    <?= $callcard['card_id']; ?>
                                                                </h1>
                                                                <p class="text-muted">
                                                                    <?php 
                                                                        $outputcard_file = '';
                                                                        if ($callcard['card_upload_logo'] != '') {
                                                                            // code...
                                                                            $card_files = explode(',', $callcard['card_upload_logo']);
                                                                            foreach ($card_files as $card_file) 
                                                                                $outputcard_file .= '<a href="'.$card_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                                                        }

                                                                        if ($callcard['card_status'] == 0) {
                                                                            echo '<span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                        } elseif ($callcard['card_status'] == 1) {
                                                                            echo '<span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                                        } elseif ($callcard['card_status'] == 2) {
                                                                            echo '<span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                                        } elseif ($callcard['card_status'] == 3) {
                                                                            echo '<span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                                        }
                                                                    ?>
                                                                </p>
                                                                    
                                                                <ul class="list-group">
                                                                    <li class="list-group-item"><span class="fw-bold text-info">What is your name?</span> <?= $callcard['card_name']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">What is the name of your company?</span> <?= $callcard['card_company_name']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">what is your address?</span> <?= $callcard['card_address']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">what is your email?</span> <?= $callcard['card_email']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Facebook:</span> <?= $callcard['card_facebook']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Instagram:</span> <?= $callcard['card_instagram']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Twitter:</span> <?= $callcard['card_twitter']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Tik tok:</span> <?= $callcard['card_tiktok']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Office Contact:</span> <?= $callcard['card_office_contact']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Personal Contact:</span> <?= $callcard['card_whatsapp']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Whatsapp:</span> <?= $callcard['card_personal_contact']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Does your company have a logo?</span> <?= $callcard['card_have_logo']; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">If yes , upload your company logo here:</span> <?= $outputcard_file; ?></a></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">If no,Do you want us to design a logo for you?</span> <?= $callcard['card_us_to_design_logo']; ?></li>
                                                                    <li class="list-group-item"><span class="fw-bold text-info">Date: </span> <?= pretty_date($callcard['card_createdAt']); ?></li>
                                                                </ul>
                                                                <!-- Text -->
                                                                <small class="text-muted mt-2">
                                                                    <a class="text-reset" data-bs-dismiss="modal" href="javascript:;">Close.</a>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $i++; endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                   <!--  <a class="btn btn-primary" href="javascript:;" onclick="goBack()">
                        Go back
                    </a> -->
                </div>
            </div>
        </div>
    </main>

    <!-- JAVASCRIPT -->
    <script src="<?= PROOT; ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>
    <script src="<?= PROOT; ?>assets/js/vendor.bundle.js"></script>
    <script src="<?= PROOT; ?>assets/js/theme.bundle.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>

   <script>

        feather.replace()

        // Fade out messages
        $("#temporary").fadeOut(5000);

        function goBack() {
            window.history.back();
        }

    </script>
</body>
</html>
