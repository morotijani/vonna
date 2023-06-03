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

    $message = '';
    if (isset($_SERVER['REQUEST_METHOD']) == 'POST' && isset($_POST['printjobSubmitButton'])) {
        $post = (cleanPost(isset($_POST) ? $_POST : ''));

        if (isset($_POST['print_type'])) {
            if ($post['print_type'] == "Examination questions") {
                $print_type = ((isset($_POST['print_type']) && !empty($_POST['print_type'])) ? $post['print_type'] : '');
                // $name_of_subject = ((isset($_POST['name_of_subject']) && !empty($_POST['name_of_subject'])) ? $post['name_of_subject'] : '');
                // $number_to_be_printed = ((isset($_POST['number_to_be_printed']) && !empty($_POST['number_to_be_printed'])) ? $post['number_to_be_printed'] : '');
                // $level = ((isset($_POST['level']) && !empty($_POST['level'])) ? $post['level'] : '');
                // $class_or_form = ((isset($_POST['class_or_form']) && !empty($_POST['class_or_form'])) ? $post['class_or_form'] : '');
                $total_students = ((isset($_POST['total_students']) && !empty($_POST['total_students'])) ? $post['total_students'] : '');
                $typed_already = ((isset($_POST['typed_already']) && !empty($_POST['typed_already'])) ? $post['typed_already'] : '');
                $want_us_to_type = ((isset($_POST['want_us_to_type']) && !empty($_POST['want_us_to_type'])) ? $post['want_us_to_type'] : '');
                $when_to_be_delivered = ((isset($_POST['when_to_be_delivered']) && !empty($_POST['when_to_be_delivered'])) ? $post['when_to_be_delivered'] : '');;
                $delivery_address_1 = ((isset($_POST['delivery_address_1']) && !empty($_POST['delivery_address_1'])) ? $post['delivery_address_1'] : '');
                $delivery_address_2 = ((isset($_POST['delivery_address_2']) && !empty($_POST['delivery_address_2'])) ? $post['delivery_address_2'] : '');

                $count_subjects = count($post['name_of_subject']);
                if ($count_subjects > 0) {
                    $name_of_subject = '';
                    $number_to_be_printed = '';
                    $level = '';
                    $class_or_form = '';
                    for ($i = 0; $i < $count_subjects; $i++) {
                        if ($post['name_of_subject'][$i] != '') {
                            $name_of_subject .= $post['name_of_subject'][$i] . ',';
                            $number_to_be_printed .= $post['number_to_be_printed'][$i] . ',';
                            $level .= $post['level'][$i] . ',';
                            $class_or_form .= $post['class_or_form'][$i] . ',';
                        }
                    }
                }

                $upload_typed_work = '';
                if (isset($_FILES['upload_typed_work'])) {
                    $count_files = count($_FILES['upload_typed_work']['name']);
                    for ($i = 0; $i < $count_files; $i++) {
                        if (!empty($_FILES['upload_typed_work']['name'][$i])) {
                            $fileName = $_FILES['upload_typed_work']['name'][$i];
                            $fileSize = $_FILES['upload_typed_work']['size'][$i];
                            $fileType = $_FILES['upload_typed_work']['type'][$i];
                            $fileTmpName = $_FILES['upload_typed_work']['tmp_name'][$i];
                            $fileError = $_FILES['upload_typed_work']['error'][$i];

                            $fileExt = explode('.', $fileName);
                            $fileActualExt = strtolower(end($fileExt));

                            $maxSize = 10000000; //10mb 
                            $allowed = array('jpg', 'pdf','jpeg', 'pdf', 'png');

                            if (in_array($fileActualExt, $allowed)) {
                                if ($fileError === 0) {
                                    if ($fileSize < $maxSize) {
                                        $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                        $fileDestination =  'media/uploads/' . $fileNewName;
                                        if (file_exists($fileDestination)) {
                                            $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                            $fileDestination = 'media/uploads/' . $fileNewName;
                                        }
                                        $moveFiles = move_uploaded_file($fileTmpName, $fileDestination);
                                        if ($moveFiles) {
                                            $upload_typed_work .= $fileDestination . ',';
                                        } else {
                                            $message = 'Your file(s) was not able to upload.';
                                        }
                                    } else {
                                    }
                                } else {
                                    $message = 'There was an error uploading your file(s).';
                                }
                            } else {
                                $message = 'You cannot upload file(s) of this type!';
                            }
                        }
                    }
                }


                $printjob_id = time() . mt_rand() . $user_id;
                $printjob_createdAt = date('Y-m-d H:i:s');

                $data = [$printjob_id, $user_id, $print_type, rtrim($name_of_subject, ', '), rtrim($number_to_be_printed, ', '), rtrim($level, ', '), rtrim($class_or_form, ', '), $total_students, $typed_already, rtrim($upload_typed_work, ', '), $want_us_to_type, $when_to_be_delivered, $delivery_address_1, $delivery_address_2, $printjob_createdAt];
                $query = "
                    INSERT INTO `vonna_printjob` (`printjob_id`, `printjob_userid`, `printjob_print_type`, `printjob_name_of_subject`, `printjob_number_to_be_printed`, `printjob_level`, `printjob_class_or_form`, `printjob_total_students`, `printjob_typed_already`, `printjob_upload_typed_work`, `printjob_want_us_to_type`, `printjob_when_to_be_delivered`, `printjob_delivery_address_1`, `printjob_delivery_address_2`, `printjob_createdAt`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";
                   
            
            } else if ($post['print_type'] == "Thesis") {
                $already_have_tr = ((isset($_POST['already_have_tr']) && !empty($_POST['already_have_tr'])) ? sanitize($_POST['already_have_tr']) : '');
                $your_thesis_research = ((isset($_POST['your_thesis_research']) && !empty($_POST['your_thesis_research'])) ? sanitize($_POST['your_thesis_research']) : '');
                $get_for_you = ((isset($_POST['get_for_you']) && !empty($_POST['get_for_you'])) ? sanitize($_POST['get_for_you']) : '');
                $have_you_typed = ((isset($_POST['have_you_typed']) && !empty($_POST['have_you_typed'])) ? sanitize($_POST['have_you_typed']) : '');
                $handle_typing = ((isset($_POST['handle_typing']) && !empty($_POST['handle_typing'])) ? sanitize($_POST['handle_typing']) : '');
                $final_editing = ((isset($_POST['final_editing']) && !empty($_POST['final_editing'])) ? sanitize($_POST['final_editing']) : '');
                //$upload_work_tr = ((isset($_POST['upload_work_tr']) && !empty($_POST['upload_work_tr'])) ? sanitize($_POST['upload_work_tr']) : '');
                //$upload_tr = ((isset($_POST['upload_tr']) && !empty($_POST['upload_tr'])) ? sanitize($_POST['upload_tr']) : '');
                $delivered_tr = ((isset($_POST['delivered_tr']) && !empty($_POST['delivered_tr'])) ? sanitize($_POST['delivered_tr']) : '');
                $day_week = ((isset($_POST['day_week']) && !empty($_POST['day_week'])) ? sanitize($_POST['day_week']) : '');
                $thesis_id = time() . mt_rand() . $user_id;
                $createdAt = date('Y-m-d H:i:s');

                $upload_work_tr = '';
                if (isset($_FILES['upload_work_tr'])) {
                    $count_files = count($_FILES['upload_work_tr']['name']);
                    for ($i = 0; $i < $count_files; $i++) {
                        if (!empty($_FILES['upload_work_tr']['name'][$i])) {
                            $fileName = $_FILES['upload_work_tr']['name'][$i];
                            $fileSize = $_FILES['upload_work_tr']['size'][$i];
                            $fileType = $_FILES['upload_work_tr']['type'][$i];
                            $fileTmpName = $_FILES['upload_work_tr']['tmp_name'][$i];
                            $fileError = $_FILES['upload_work_tr']['error'][$i];

                            $fileExt = explode('.', $fileName);
                            $fileActualExt = strtolower(end($fileExt));

                            $maxSize = 10000000; //10mb 
                            $allowed = array('jpg', 'pdf','jpeg', 'pdf', 'png');

                            if (in_array($fileActualExt, $allowed)) {
                                if ($fileError === 0) {
                                    if ($fileSize < $maxSize) {
                                        $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                        $fileDestination =  'media/uploads/' . $fileNewName;
                                        if (file_exists($fileDestination)) {
                                            $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                            $fileDestination = 'media/uploads/' . $fileNewName;
                                        }
                                        $moveFiles = move_uploaded_file($fileTmpName, $fileDestination);
                                        if ($moveFiles) {
                                            $upload_work_tr .= $fileDestination . ',';
                                        } else {
                                            $message = 'Your file(s) was not able to upload.';
                                        }
                                    } else {
                                    }
                                } else {
                                    $message = 'There was an error uploading your file(s).';
                                }
                            } else {
                                $message = 'You cannot upload file(s) of this type!';
                            }
                        }
                    }
                }

                $upload_tr = '';
                if (isset($_FILES['upload_tr'])) {
                    $count_files = count($_FILES['upload_tr']['name']);
                    for ($i = 0; $i < $count_files; $i++) {
                        if (!empty($_FILES['upload_tr']['name'][$i])) {
                            $fileName = $_FILES['upload_tr']['name'][$i];
                            $fileSize = $_FILES['upload_tr']['size'][$i];
                            $fileType = $_FILES['upload_tr']['type'][$i];
                            $fileTmpName = $_FILES['upload_tr']['tmp_name'][$i];
                            $fileError = $_FILES['upload_tr']['error'][$i];

                            $fileExt = explode('.', $fileName);
                            $fileActualExt = strtolower(end($fileExt));

                            $maxSize = 10000000; //10mb 
                            $allowed = array('jpg', 'pdf','jpeg', 'pdf', 'png');

                            if (in_array($fileActualExt, $allowed)) {
                                if ($fileError === 0) {
                                    if ($fileSize < $maxSize) {
                                        $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                        $fileDestination =  'media/uploads/' . $fileNewName;
                                        if (file_exists($fileDestination)) {
                                            $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                            $fileDestination = 'media/uploads/' . $fileNewName;
                                        }
                                        $moveFiles = move_uploaded_file($fileTmpName, $fileDestination);
                                        if ($moveFiles) {
                                            $upload_tr .= $fileDestination . ',';
                                        } else {
                                            $message = 'Your file(s) was not able to upload.';
                                        }
                                    } else {
                                    }
                                } else {
                                    $message = 'There was an error uploading your file(s).';
                                }
                            } else {
                                $message = 'You cannot upload file(s) of this type!';
                            }
                        }
                    }
                }

                $data = [$thesis_id, $user_id, $already_have_tr, $your_thesis_research, $get_for_you, $have_you_typed, $handle_typing, $final_editing, $upload_work_tr, $upload_tr, $delivered_tr, $day_week, $createdAt];
                $query = "
                    INSERT INTO `vonna_printjob_thesis`(`thesis_id`, `thesis_userid`, `thesis_already_have_tr`, `thesis_your_thesis_research`, `thesis_get_for_you`, `thesis_have_you_typed`, `thesis_handle_typing`, `thesis_final_editing`, `thesis_upload_work_tr`, `thesis_upload_tr`, `thesis_delivered_tr`, `thesis_day_week`, `thesis_createdAt`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";
            } else if ($post['print_type'] == "Fliers") {
                $size_to_print = ((isset($_POST['size_to_print']) && !empty($_POST['size_to_print'])) ? sanitize($_POST['size_to_print']) : '');
                $quantity_to_print = ((isset($_POST['quantity_to_print']) && !empty($_POST['quantity_to_print'])) ? sanitize($_POST['quantity_to_print']) : '');
                $have_designs = ((isset($_POST['have_designs']) && !empty($_POST['have_designs'])) ? sanitize($_POST['have_designs']) : '');
                $us_to_design = ((isset($_POST['us_to_design']) && !empty($_POST['us_to_design'])) ? sanitize($_POST['us_to_design']) : '');
                $flier_for = ((isset($_POST['flier_for']) && !empty($_POST['flier_for'])) ? sanitize($_POST['flier_for']) : '');
                // $design_file = ((isset($_POST['design_file']) && !empty($_POST['design_file'])) ? sanitize($_POST['design_file']) : '');
                $date_to_deliver = ((isset($_POST['date_to_deliver']) && !empty($_POST['date_to_deliver'])) ? sanitize($_POST['date_to_deliver']) : '');
                $flier_id = time() . mt_rand() . $user_id;
                $createdAt = date('Y-m-d H:i:s');

                $design_file = '';
                if (isset($_FILES['design_file'])) {
                    $count_files = count($_FILES['design_file']['name']);
                    for ($i = 0; $i < $count_files; $i++) {
                        if (!empty($_FILES['design_file']['name'][$i])) {
                            $fileName = $_FILES['design_file']['name'][$i];
                            $fileSize = $_FILES['design_file']['size'][$i];
                            $fileType = $_FILES['design_file']['type'][$i];
                            $fileTmpName = $_FILES['design_file']['tmp_name'][$i];
                            $fileError = $_FILES['design_file']['error'][$i];

                            $fileExt = explode('.', $fileName);
                            $fileActualExt = strtolower(end($fileExt));

                            $maxSize = 10000000; //10mb 
                            $allowed = array('jpg', 'pdf','jpeg', 'pdf', 'png');

                            if (in_array($fileActualExt, $allowed)) {
                                if ($fileError === 0) {
                                    if ($fileSize < $maxSize) {
                                        $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                        $fileDestination =  'media/uploads/' . $fileNewName;
                                        if (file_exists($fileDestination)) {
                                            $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                            $fileDestination = 'media/uploads/' . $fileNewName;
                                        }
                                        $moveFiles = move_uploaded_file($fileTmpName, $fileDestination);
                                        if ($moveFiles) {
                                            $design_file .= $fileDestination . ',';
                                        } else {
                                            $message = 'Your file(s) was not able to upload.';
                                        }
                                    } else {
                                    }
                                } else {
                                    $message = 'There was an error uploading your file(s).';
                                }
                            } else {
                                $message = 'You cannot upload file(s) of this type!';
                            }
                        }
                    }
                }

                $data = [$flier_id, $userid, $size_to_print, $quantity_to_print, $have_designs, $us_to_design, $flier_for, $design_file, $date_to_deliver, $createdAt];
                $query = "
                    INSERT INTO `vonna_printjob_fliers`(`flier_id`, `flier_userid`, `flier_size_to_print`, `flier_quantity_to_print`, `flier_have_designs`, `flier_us_to_design`, `flier_for`, `flier_design_file`, `flier_date_to_deliver`, `flier_createdAt`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";

            } else if ($post['print_type'] == "Banners") {
                
            } else if ($post['print_type'] == "Receipt books") {
                
            } else if ($post['print_type'] == "Invoice") {
                
            } else if ($post['print_type'] == "Customized office Files") {
                
            }

            if (!empty($message)) {
                echo js_alert($message);
            } else {
                $statement = $conn->prepare($query);
                $result = $statement->execute($data);
                if ($result) {
                    $_SESSION['flash_success'] = 'Print job send successfully';
                    redirect(PROOT . 'account/print-job');
                }
            }
        }

    }

?>


    <!-- BODY -->
    <main class="">
        <?= $flash; ?>
        <div class="container-lg d-flex flex-column">
            <div class="row align-items-start justify-content-center">
                <div class="col-lg-12 py-6 py-md-9">
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= PROOT; ?>account/print-job">Print Job</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="<?= PROOT; ?>account/print-job/requests">Requests</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="<?= PROOT; ?>account/print-job">Rerefesh</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="<?= PROOT; ?>account/index">Go home</a>
                        </li>
                    </ul>
                    <section class="py-1">
                        <h2 class="display-3 text-center mb-4">
                            Print <span class="text-underline-warning">job</span>
                        </h2>
                        <form id="printjobForm" method="POST" enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label class="visually-hidden" for="print-type">
                                    what print job do you want?
                                </label>
                                <select class="form-control" id="print-type" name="print_type" type="text" required>
                                    <option value="">what print job do you want?</option>
                                    <option value="Examination questions">Examination questions</option>
                                    <option value="Thesis">Thesis</option>
                                    <option value="Fliers">Fliers</option>
                                    <option value="Banners">Banners</option>
                                    <option value="Receipt books">Receipt books</option>
                                    <option value="Invoice">Invoice</option>
                                    <option value="Customized office Files">Customized office Files</option>
                                </select>
                            </div>
 
                            <div class="exams d-none">
                                <table class="table table-sm">  
                                    <tbody id="dynamic_field">
                                        <tr>  
                                            <td><input type="text" name="name_of_subject[]" placeholder="Name of subject" class="form-control name-of-subject"></td>  
                                            <td><input type="number" min='0' name="number_to_be_printed[]" placeholder="Number to be printed" class="form-control number-to-be-printed"></td>  
                                            <td>
                                                <select type="text" name="level[]" class="form-control level">
                                                    <option value="">Level</option>
                                                    <option value="Tertiary">Tertiary</option>
                                                    <option value="SHS">SHS</option>
                                                    <option value="JHS">JHS</option>
                                                    <option value="Primary">Primary</option>
                                                    <option value="Kindargarten">Kindargarten</option>
                                                    <option value="Nursery">Nursery</option>
                                                </select>
                                            </td>  
                                            <td><input type="text" name="class_or_form[]" placeholder="Class/Form" class="form-control class-or-form"></td>  
                                            <td><button type="button" name="add" id="add" class="btn btn-sm btn-success">Add subject</button></td>  
                                        </tr>  
                                    </tbody>
                                </table>

                                <div class="form-group">
                                    <input type="number" class="form-control" name="total_students" id="total_students" min="0" placeholder="What is the total size of your student body?">
                                </div>


                                <label>Do you have the questions typed already?</label>
                                <br>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="typed_already" id="typed-alreadyYes" value="Yes">
                                    <label class="form-check-label" for="typed-alreadyYes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="typed_already" id="typed-alreadyNo" value="No">
                                    <label class="form-check-label" for="typed-alreadyNo">
                                        No
                                    </label>
                                </div>

                                <div class="form-group d-none yes-typed mb-3">
                                    <label for="upload-typed-work">If yes, upload your typed work here?</label>
                                    <input type="file" name="upload_typed_work[]" multiple id="upload-typed-work" class="form-control" accept="application/msword, application/vnd.ms-powerpoint, text/plain, application/pdf, .doc, .docx, image/*">
                                </div>

                                <div class="d-none no-typed mb-3">
                                    <label for="">If no, Do you want us to type for you?</label>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="want_us_to_type" id="want-us-to-typeYes" value="Yes">
                                        <label for="want-us-to-typeYes" class="form-check-label">Yes</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="want_us_to_type" id="want-us-to-typeNo" value="No">
                                        <label for="want-us-to-typeNo" class="form-check-label">No</label>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <select name="when_to_be_delivered" id="when-to-be-delivered" class="form-control">
                                        <option value="">When do you want the print job delivered?</option>
                                        <option value="Hours">Hours</option>
                                        <option value="Days">Days</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Enter devlivery Address here</label>
                                    <input type="text" name="delivery_address_1" class="form-control" id="" placeholder="Receipient Contact 1">
                                    <br>
                                    <input type="text" name="delivery_address_2" class="form-control" id="" placeholder="Receipient Contact 2">
                                </div>
                            </div>

                            <!-- THESIS/RESEARCH -->
                            <div class="thesis d-none">
                                <label for="">Do you have a thesis/research topic already?</label>
                                <br>
                                <div class="form-check mb-3">
                                    <input type="radio" class="form-check-input" name="already_have_tr" id="already-have-trYes" value="Yes">
                                    <label for="already-have-trYes" class="form-check-label">Yes</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="already_have_tr" id="already-have-trNo" value="No">
                                    <label for="already-have-trNo" class="form-check-label">No</label>
                                </div>

                                <div class="form-group d-none yes-have">
                                    <input type="text" name="your_thesis_research" id="your-thesis-research" class="form-control" placeholder="If yes, What is your thesis/research topic?">
                                </div>

                                <div class="d-none no-have mb-3">
                                    <label for="">if no, would you want us to get you a suitable research/thesis topic?</label>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="get_for_you" id="get-for-youYes" value="Yes">
                                        <label for="get-for-youYes" class="form-check-label">Yes</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="get_for_you" id="get-for-youNo" value="No">
                                        <label for="get-for-youNo" class="form-check-label">No</label>
                                    </div>
                                </div>

                                <label for="">Have you typed your thesis/research already?</label>
                                <br>
                                <div class="form-check mb-3">
                                    <input type="radio" class="form-check-input" name="have_you_typed" id="have-you-typedYes" value="Yes">
                                    <label for="have-you-typedYes" class="form-check-label">Yes</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="have_you_typed" id="have-you-typedNo" value="No">
                                    <label for="have-you-typedNo" class="form-check-label">No</label>
                                </div>

                                <div class="d-none no-typed-tr mb-3">
                                    <label for="">if no, do you want us to handle the typing of your thesis/research for you?</label>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="handle_typing" id="handle-typingYes" value="Yes">
                                        <label for="handle-typingYes" class="form-check-label">Yes</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="handle_typing" id="handle-typingNo" value="No">
                                        <label for="handle-typingNo" class="form-check-label">No</label>
                                    </div>
                                </div>

                                <label for="">Have you effected the final editing to your thesis/research topic already?</label>
                                <br>
                                <div class="form-check mb-3">
                                    <input type="radio" class="form-check-input" name="final_editing" id="final-editingYes" value="Yes">
                                    <label for="final-editingYes" class="form-check-label">Yes</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="final_editing" id="final-editingNo" value="No">
                                    <label for="final-editingNo" class="form-check-label">No</label>
                                </div>

                                <div class="form-group d-none yes-effected">
                                    <label for="upload-typed-work">If yes , Upload your work here</label>
                                    <input type="file" name="upload_work_tr[]" multiple id="upload-work-tr" class="form-control" accept="application/msword, application/vnd.ms-powerpoint, text/plain, application/pdf, .doc, .docx, image/*">
                                </div>

                                <div class="form-group d-none no-effected mb-3">
                                    <label for="upload-typed-work">If no, upload your thesis/research so far</label>
                                    <input type="file" name="upload_tr[]" multiple id="upload-tr" class="form-control" accept="application/msword, application/vnd.ms-powerpoint, text/plain, application/pdf, .doc, .docx, image/*">
                                </div>
 
                                <label for="">When do you want your work delivered?</label>
                                <div class="input-group mb-3">
                                    <select name="delivered_tr" id="delivered-tr" class="form-select">
                                        <option value="">Open to select</option>
                                        <option value="Day(s):">Day(s):</option>
                                        <option value="Week(s):">Week(s):</option>
                                    </select>
                                    <input type="number" min="1" name="day_week" id="day-week" class="form-control" placeholder="Number">
                                </div>


                            </div>

                            <!-- FLIERS -->
                            <div class="fliers d-none">
                                <div class="form-group mb-3">
                                    <input type="text" name="size_to_print" id="size-to-print" class="form-control" id="" placeholder="What size do you want to print?">
                                </div>

                                <div class="form-group mb-3">
                                    <input type="number" name="quantity_to_print" id="quantity-to-print" class="form-control" id="" placeholder="what quantity do you want to print?">
                                </div>

                                <label for="">Do you have your design(s) already?</label>
                                <br>
                                <div class="form-check mb-3">
                                    <input type="radio" class="form-check-input" name="have_designs" id="have-designsYes" value="Yes">
                                    <label for="have-designsYes" class="form-check-label">Yes</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="have_designs" id="have-designsNo" value="No">
                                    <label for="have-designsNo" class="form-check-label">No</label>
                                </div>

                                <div class="d-none no-have-designs mb-3">
                                    <label for="">If NO, Do you want us to design your flier for you?</label>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="us_to_design" id="us-to-designYes" value="Yes">
                                        <label for="us-to-designYes" class="form-check-label">Yes</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="us_to_design" id="us-to-designNo" value="No">
                                        <label for="us-to-designNo" class="form-check-label">No</label>
                                    </div>
                                </div>

                                <div class="d-none yes-us-designs mb-3">
                                    <input type="text" name="flier_for" id="flier-for" class="form-control" placeholder="If yes What occasion are you designing the flier for?">
                                </div>

                                <div class="mb-3">
                                    <label>Upload your design(s) or sample designs here.</label>
                                    <input type="file" name="design_file[]" multiple id="design-file" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>When do you want the job delivered?</label>
                                    <input type="date" name="date_to_deliver" id="date-to-deliver" class="form-control">
                                </div>

                            </div>

                            <!-- BANNERS -->
                            <div class="banners d-none">
                                <div class="mb-3">
                                    <label>What size do you want?</label>
                                    <input type="text" name="size" id="size" class="form-control">
                                    <div class="form-text">eg. 8 x 4</div>
                                </div>

                                <div class="mb-3">
                                    <label>What quantity do you want?</label>
                                    <input type="number" min="1" name="banner_quantity" id="banner-quantity" class="form-control">
                                    <div class="form-text">eg. 8 x 4</div>
                                </div>

                                <label for="">Do you have your designs already?</label>
                                <br>
                                <div class="form-check mb-3">
                                    <input type="radio" class="form-check-input" name="have_banner_designs" id="have-banner-designsYes" value="Yes">
                                    <label for="have-banner-designsYes" class="form-check-label">Yes</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="have_banner_designs" id="have-banner-designsNo" value="No">
                                    <label for="have-banner-designsNo" class="form-check-label">No</label>
                                </div>

                                <div class="d-none yes-have-banner-designs mb-3">
                                    <div class="form-check">
                                        <label for="">If yes, Upload your design here</label>
                                        <input type="file" name="[]" class="form-check-input" name="us_to_design" id="us-to-designYes" value="Yes">
                                        <label for="us-to-designNo" class="form-check-label">No</label>
                                    </div>
                                </div>

                                <div class="d-none no-have-banner-designs mb-3">
                                    <label for="">If No, Do you want us to do the design for you?</label>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="us_to_design" id="us-to-designYes" value="Yes">
                                        <label for="us-to-designYes" class="form-check-label">Yes</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="us_to_design" id="us-to-designNo" value="No">
                                        <label for="us-to-designNo" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>

                            <!-- RECEIPT -->
                            <div class="receipt d-none"></div>
                            <div class="invoice d-none"></div>
                            <div class="customized d-none"></div>

                            <button type="submit" class="btn w-100 btn-warning" id="printjobSubmitButton" name="printjobSubmitButton" disabled>
                                Send print job now
                            </button>
                        </form>
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

    <script>
        // Fade out messages
        $("#temporary").fadeOut(5000);
        
        function goBack() {
            window.history.back();
        }

        $(document).ready(function() {

            $("#print-type").change(function(e) {
                event.preventDefault()
                var printType = $("#print-type option:selected").text();

                if (printType == 'Examination questions') {
                    $('.exams').removeClass('d-none');
                    $('.thesis').addClass('d-none');
                    $('.fliers').addClass('d-none');

                    $('input[name="name_of_subject[]"]').attr('required', true)
                    $('input[name="number_to_be_printed[]"]').attr('required', true)
                    $('select[name="level[]"]').attr('required', true)
                    $('input[name="class_or_form[]"]').attr('required', true)
                    $('input[name="total_students"]').attr('required', true)
                    $('input[name="typed_already"]').attr('required', true)
                    $('select[name="when_to_be_delivered"]').attr('required', true)

                    $('input[name="name_of_subject[]"]').attr('disabled', false)
                    $('input[name="number_to_be_printed[]"]').attr('disabled', false)
                    $('select[name="level[]"]').attr('disabled', false)
                    $('input[name="class_or_form[]"]').attr('disabled', false)
                    $('input[name="total_students"]').attr('disabled', false)
                    $('input[name="typed_already"]').attr('disabled', false)
                    $('select[name="when_to_be_delivered"]').attr('disabled', false)

                    // 
                    $('#already-have-trYes').attr('disabled', true)
                    $('#have-you-typedYes').attr('disabled', true)
                    $('#final-editingYes').attr('disabled', true)
                    $('#delivered-tr').attr('disabled', true)
                    $('#day-week').attr('disabled', true)
                    $('#size-to-print').attr('disabled', true)
                    $('#quantity-to-print').attr('disabled', true)
                    $('#have-designsYes').attr('disabled', true)
                    $('#design-file').attr('disabled', true)
                    $('#date-to-deliver').attr('disabled', true)
                    $('#already-have-trYes').attr('required', false)
                    $('#have-you-typedYes').attr('required', false)
                    $('#final-editingYes').attr('required', false)
                    $('#delivered-tr').attr('required', false)
                    $('#day-week').attr('required', false)
                    $('#size-to-print').attr('required', false)
                    $('#quantity-to-print').attr('required', false)
                    $('#have-designsYes').attr('required', false)
                    $('#design-file').attr('required', false)
                    $('#date-to-deliver').attr('required', false)

                    $('#size-to-print').attr('required', false)
                    $('#quantity-to-print').attr('required', false)
                    $('#have-designsYes').attr('required', false)
                    $('#design-file').attr('required', false)
                    $('#date-to-deliver').attr('required', false)
                    $('#size-to-print').attr('disabled', true)
                    $('#quantity-to-print').attr('disabled', true)
                    $('#have-designsYes').attr('disabled', true)
                    $('#design-file').attr('disabled', true)
                    $('#date-to-deliver').attr('disabled', true)

                    // add more fields
                    var i = 1;  
                    $('#add').click(function() {  
                        i++; 
                        $('#dynamic_field').append(`
                            <tr id="row` + i +`"> 
                                <td><input type="text" name="name_of_subject[]" placeholder="Name of subject" class="form-control name-of-subject" required></td>  
                                <td><input type="number" min='0' name="number_to_be_printed[]" placeholder="Number to be printed" class="form-control number-to-be-printed" required></td>  
                                <td>
                                    <select type="text" name="level[]" placeholder="Enter your Name" class="form-control level" required>
                                        <option value="">Level</option>
                                        <option value="Tertiary">Tertiary</option>
                                        <option value="SHS">SHS</option>
                                        <option value="JHS">JHS</option>
                                        <option value="Primary">Primary</option>
                                        <option value="Kindargarten">Kindargarten</option>
                                        <option value="Nursery">Nursery</option>
                                    </select>
                                </td>
                                <td><input type="text" name="class_or_form[]" placeholder="Class/Form" class="form-control class-or-form" required></td>  
                                <td><button type="button" name="remove" id="` + i + `" class="btn btn-sm btn-danger btn_remove">X</button></td>
                            </tr>
                        `);  
                    });

                    // remove field
                    $(document).on('click', '.btn_remove', function() {  
                        var button_id = $(this).attr("id");   
                        $('#row' + button_id + '').remove();  
                    });

                    $('input[name="typed_already"]').click(function() {
                        var typedAlready = $('input[name="typed_already"]:checked').val();
                        if (typedAlready == 'Yes') {
                            $('.yes-typed').removeClass('d-none');
                            $('.no-typed').addClass('d-none');

                            $('input[name="want_us_to_type"]').prop('checked', false)
                            $('#upload-typed-work').attr('required', true);
                            $('#want-us-to-typeYes').attr('required', false);

                        } else if (typedAlready == 'No') { 
                            $('.no-typed').removeClass('d-none');
                            $('.yes-typed').addClass('d-none');

                            $('#want-us-to-typeYes').attr('required', true);
                            $('#upload-typed-work').val('');
                            $('#upload-typed-work').attr('required', false);
                            
                            $('input[name="want_us_to_type"]').click(function() {
                                if ($('input[name="want_us_to_type"]').is(':checked')) {
                                    return true;
                                } else {
                                    alert("If no, Do you want us to type for you? ");
                                    return false;
                                }
                            });

                        } else {
                            alert('Please, Do you have the questions typed already');
                            return false;
                            // undefined
                        }
                    });

                    $('#printjobSubmitButton').attr('disabled', false);

                } else if (printType == 'Thesis') {
                    $('.thesis').removeClass('d-none');
                    $('.exams').addClass('d-none');
                    $('.fliers').addClass('d-none');

                    // 
                    $('#already-have-trYes').attr('required', true)
                    $('#have-you-typedYes').attr('required', true)
                    $('#final-editingYes').attr('required', true)
                    $('#delivered-tr').attr('required', true)
                    $('#day-week').attr('required', true)

                    $('#already-have-trYes').attr('disabled', false)
                    $('#have-you-typedYes').attr('disabled', false)
                    $('#final-editingYes').attr('disabled', false)
                    $('#delivered-tr').attr('disabled', false)
                    $('#day-week').attr('disabled', false)

                    // 
                    $('input[name="name_of_subject[]"]').attr('disabled', true)
                    $('input[name="number_to_be_printed[]"]').attr('disabled', true)
                    $('select[name="level[]"]').attr('disabled', true)
                    $('input[name="class_or_form[]"]').attr('disabled', true)
                    $('input[name="total_students"]').attr('disabled', true)
                    $('input[name="typed_already"]').attr('disabled', true)
                    $('select[name="when_to_be_delivered"]').attr('disabled', true)
                    $('input[name="delivery_address_1"]').attr('disabled', true)
                    $('input[name="delivery_address_2"]').attr('disabled', true)
                    $('#size-to-print').attr('disabled', true)
                    $('#quantity-to-print').attr('disabled', true)
                    $('#have-designsYes').attr('disabled', true)
                    $('#design-file').attr('disabled', true)
                    $('#date-to-deliver').attr('disabled', true)

                    $('input[name="name_of_subject[]"]').attr('required', false)
                    $('input[name="number_to_be_printed[]"]').attr('required', false)
                    $('select[name="level[]"]').attr('required', false)
                    $('input[name="class_or_form[]"]').attr('required', false)
                    $('input[name="total_students"]').attr('required', false)
                    $('input[name="typed_already"]').attr('required', false)
                    $('select[name="when_to_be_delivered"]').attr('required', false)
                    $('input[name="delivery_address_1"]').attr('required', false)
                    $('input[name="delivery_address_2"]').attr('required', false)
                    $('#size-to-print').attr('required', false)
                    $('#quantity-to-print').attr('required', false)
                    $('#have-designsYes').attr('required', false)
                    $('#design-file').attr('required', false)
                    $('#date-to-deliver').attr('required', false)

                    
                    $('input[name="already_have_tr"]').click(function() {
                        var alreadyHave = $('input[name="already_have_tr"]:checked').val();
                        if (alreadyHave == 'Yes') {
                            $('.yes-have').removeClass('d-none');
                            $('.no-have').addClass('d-none');
                            
                            $('#your-thesis-research').attr('required', true)
                            $('#get-for-youYes').attr('required', false)

                            $('input[name="get_for_you"]').prop('checked', false);
                        } else if (alreadyHave == 'No') {
                            $('.no-have').removeClass('d-none');
                            $('.yes-have').addClass('d-none');

                            $('#get-for-youYes').attr('required', true)
                            $('#your-thesis-research').val('');
                            $('#your-thesis-research').attr('required', false)
                        }
                    })

                    $('input[name="have_you_typed"]').click(function() {
                        var youTyped = $('input[name="have_you_typed"]:checked').val();
                        if (youTyped == 'No') {
                            $('.no-typed-tr').removeClass('d-none');
                            $('#handle-typingYes').attr('required', true);
                        } else {
                            $('.no-typed-tr').addClass('d-none');
                            $('#handle-typingYes').attr('required', false);
                        }
                    })
                    
                    $('input[name="final_editing"]').click(function() {
                        var final = $('input[name="final_editing"]:checked').val();
                        if (final == 'Yes') {
                            $('.yes-effected').removeClass('d-none');
                            $('.no-effected').addClass('d-none');
                            $('#upload-work-tr').attr('required', true);
                            $('#upload-tr').attr('required', false);

                        } else if (final == 'No') {
                            $('.no-effected').removeClass('d-none');
                            $('.yes-effected').addClass('d-none');
                            $('#upload-tr').attr('required', true);
                            $('#upload-work-tr').attr('required', false);

                        }
                    })

                    $('#printjobSubmitButton').attr('disabled', false);
                } else if (printType == 'Fliers') {
                    $('.fliers').removeClass('d-none');
                    $('.thesis').addClass('d-none');
                    $('.exams').addClass('d-none');

                    // 
                    $('#size-to-print').attr('required', true)
                    $('#quantity-to-print').attr('required', true)
                    $('#have-designsYes').attr('required', true)
                    $('#date-to-deliver').attr('required', true)

                    $('#size-to-print').attr('disabled', false)
                    $('#quantity-to-print').attr('disabled', false)
                    $('#have-designsYes').attr('disabled', false)
                    $('#design-file').attr('disabled', false)
                    $('#date-to-deliver').attr('disabled', false)

                    // 
                    $('#already-have-trYes').attr('disabled', true)
                    $('#have-you-typedYes').attr('disabled', true)
                    $('#final-editingYes').attr('disabled', true)
                    $('#delivered-tr').attr('disabled', true)
                    $('#day-week').attr('disabled', true)
                    $('#your-thesis-research').attr('disabled', true)
                    $('input[name="name_of_subject[]"]').attr('disabled', true)
                    $('input[name="number_to_be_printed[]"]').attr('disabled', true)
                    $('select[name="level[]"]').attr('disabled', true)
                    $('input[name="class_or_form[]"]').attr('disabled', true)
                    $('input[name="total_students"]').attr('disabled', true)
                    $('input[name="typed_already"]').attr('disabled', true)
                    $('select[name="when_to_be_delivered"]').attr('disabled', true)
                    $('input[name="delivery_address_1"]').attr('disabled', true)
                    $('input[name="delivery_address_2"]').attr('disabled', true)

                    $('#already-have-trYes').attr('required', false)
                    $('#have-you-typedYes').attr('required', false)
                    $('#final-editingYes').attr('required', false)
                    $('#delivered-tr').attr('required', false)
                    $('#day-week').attr('required', false)
                    $('#your-thesis-research').attr('required', false)
                    $('input[name="name_of_subject[]"]').attr('required', false)
                    $('input[name="number_to_be_printed[]"]').attr('required', false)
                    $('select[name="level[]"]').attr('required', false)
                    $('input[name="class_or_form[]"]').attr('required', false)
                    $('input[name="total_students"]').attr('required', false)
                    $('input[name="typed_already"]').attr('required', false)
                    $('select[name="when_to_be_delivered"]').attr('required', false)
                    $('input[name="delivery_address_1"]').attr('required', false)
                    $('input[name="delivery_address_2"]').attr('required', false)

                    $('input[name="have_designs"]').click(function() {
                        var have = $('input[name="have_designs"]:checked').val();
                        if (have == 'No') {
                            $('#design-file').attr('required', false)
                            $('.no-have-designs').removeClass('d-none');
                            $('#us-to-designYes').attr('required', true)
                        } else {
                            $('#design-file').attr('required', true)
                            $('.no-have-designs').addClass('d-none');
                            $('#us-to-designYes').attr('required', false)
                        }
                    })

                    $('input[name="us_to_design"]').click(function() {
                        var usTo = $('input[name="us_to_design"]:checked').val();
                        if (usTo == 'Yes') {
                            $('.yes-us-designs').removeClass('d-none');
                            $('#flier-for').attr('required', true)
                        } else {
                            $('.yes-us-designs').addClass('d-none');
                            $('#flier-for').attr('required', false)
                            $('#flier-for').val('')
                        }
                    })
                    $('#printjobSubmitButton').attr('disabled', false);
                    
                } else if (printType == 'Banners') {
                    
                } else if (printType == 'Receipt books') {
                    
                } else if (printType == 'Invoice') {
                    
                } else if (printType == 'Customized office Files') {
                    
                }
                
            })

        });
    </script>

</body>
</html>
