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
        if (isset($_POST['print_type']) && $post['print_type'] == "Examination questions") {
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
            if (!empty($message)) {
                echo js_alert($message);
            } else {
                $query = "
                    INSERT INTO `vonna_printjob` (`printjob_id`, `printjob_userid`, `printjob_print_type`, `printjob_name_of_subject`, `printjob_number_to_be_printed`, `printjob_level`, `printjob_class_or_form`, `printjob_total_students`, `printjob_typed_already`, `printjob_upload_typed_work`, `printjob_want_us_to_type`, `printjob_when_to_be_delivered`, `printjob_delivery_address_1`, `printjob_delivery_address_2`, `printjob_createdAt`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";
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
                            <div class="form-group">
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
                                            <td><button type="button" name="add" id="add" class="btn btn-sm btn-success">Add subject</button></td>  
                                        </tr>  
                                    </tbody>
                                </table>

                                <div class="form-group">
                                    <input type="number" class="form-control" name="total_students" id="total_students" required min="0" placeholder="What is the total size of your student body?">
                                </div>


                                <label>Do you have the questions typed already?</label>
                                <br>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="typed_already" id="typed-alreadyYes" value="Yes" required>
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

                                <div class="form-group d-none yes-typed">
                                    <label for="upload-typed-work">If yes, upload your typed work here?</label>
                                    <input type="file" name="upload_typed_work[]" multiple id="upload-typed-work" class="form-control" accept="application/msword, application/vnd.ms-powerpoint, text/plain, application/pdf, .doc, .docx, image/*">
                                </div>

                                <div class="d-none no-typed">
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

                                <div class="form-group">
                                    <select name="when_to_be_delivered" id="when-to-be-delivered" class="form-control" required>
                                        <option value="">When do you want the print job delivered?</option>
                                        <option>Hours</option>
                                        <option>Days</option>
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
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="already_have_tr" id="already-have-trYes" value="Yes">
                                    <label for="already-have-trYes" class="form-check-label">Yes</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="already_have_tr" id="already-have-trNo" value="No">
                                    <label for="already-have-trNo" class="form-check-label">No</label>
                                </div>

                                <div class="form-group d-none yes-have">
                                    <label for="your-thesis-research"></label>
                                    <input type="text" name="your_thesis_research" id="your-thesis-research" class="form-control" placeholder="If yes, What is your thesis/research topic?">
                                </div>

                                <div class="d-none no-have">
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
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="have_you_typed" id="have-you-typedYes" value="Yes">
                                    <label for="have-you-typedYes" class="form-check-label">Yes</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="have_you_typed" id="have-you-typedNo" value="No">
                                    <label for="have-you-typedNo" class="form-check-label">No</label>
                                </div>

                                <div class="d-none no-typed-tr">
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
                                <div class="form-check">
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

                                <div class="form-group d-none no-effected">
                                    <label for="upload-typed-work">If no, upload your thesis/research so far</label>
                                    <input type="file" name="upload_tr[]" multiple id="upload-tr" class="form-control" accept="application/msword, application/vnd.ms-powerpoint, text/plain, application/pdf, .doc, .docx, image/*">
                                </div>
 
                                <label for="">When do you want your work delivered?</label>
                                <div class="input-group mb-3">
                                    <select name="delivered_tr" id="delivered-tr" class="form-select">
                                        <option value="">...</option>
                                        <option value="Day(s):">Day(s):</option>
                                        <option value="Week(s):">Week(s):</option>
                                    </select>
                                    <input type="number" min="1" name="day_week" id="day-week" class="form-control" placeholder="Number">
                                </div>


                            </div>

                            <!-- FLIERS -->
                            <div class="fliers d-none"></div>
                            <div class="banners d-none"></div>
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
                                        <option>Level</option>
                                        <option>Tertiary</option>
                                        <option>SHS</option>
                                        <option>JHS</option>
                                        <option>Primary</option>
                                        <option>Kindargarten</option>
                                        <option>Nursery</option>
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

                }

                if (printType == 'Thesis') {
                    $('.thesis').removeClass('d-none');
                    $('.exams').addClass('d-none');

                    $('#already-have-trYes').attr('required', true)
                    $('#have-you-typedYes').attr('required', true)
                    $('#final-editingYes').attr('required', true)
                    $('#delivered-tr').attr('required', true)
                    $('#day-week').attr('required', true)
                    
                    $('input[name="already_have_tr"]').click(function() {
                        var alreadyHave = $('input[name="already_have_tr"]:checked').val();
                        if (alreadyHave == 'Yes') {
                            $('.yes-have').removeClass('d-none');
                            $('.no-have').addClass('d-none');
                            
                            $('#your-thesis-research').attr('required', true)
                            $('#get-for-youYes').attr('required', false)
                        } else if (alreadyHave == 'No') {
                            $('.no-have').removeClass('d-none');
                            $('.yes-have').addClass('d-none');

                            $('#get-for-youYes').attr('required', true)
                            $('#your_thesis_research').attr('required', false)
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
                }

                if (printType == 'Fliers') {
                    
                }

                if (printType == 'Banners') {
                    
                }

                if (printType == 'Receipt books') {
                    
                }

                if (printType == 'Invoice') {
                    
                }

                if (printType == 'Customized office Files') {
                    
                }
                
            })

            $("#product").change(function() {

                // var selectedVal = $("#product option:selected").text();
                var productVal = $("#product option:selected").val();
                if (productVal != '') {
                    if (productVal == 'Plain Paper') {
                        $('#plainpaper').removeClass('d-none');

                        $('#plainpaper_size').attr('required', true);
                        $('#plainpaper_type').attr('required', true);
                        $('#plainpaper_qty').attr('required', true);

                        $('#ruledpaper_qty').attr('required', false);
                        $('#flipchart_size').attr('required', false);
                        $('#flipchart_qty').attr('required', false);
                        $('#notepad_size').attr('required', false);
                        $('#notepad_qty').attr('required', false);
                        $('#envelope_color').attr('required', false);
                        $('#envelope_qty').attr('required', false);


                        $('#ruledpaper').addClass('d-none');
                        $('#flipchart').addClass('d-none');
                        $('#notepad').addClass('d-none');
                        $('#envelope').addClass('d-none');


                        // var size = $('#plainpaper_size').find(":selected").val();
                        // var type = $('#plainpaper_type').find(":selected").val();
                        // var qty = $('#plainpaper_qty').val();

                        $('#orderButton').attr('disabled', false);

                    } else if (productVal == 'Ruled Paper') {
                        $('#ruledpaper').removeClass('d-none');

                        $('#ruledpaper_qty').attr('required', true);

                        $('#plainpaper_size').attr('required', false);
                        $('#plainpaper_type').attr('required', false);
                        $('#plainpaper_qty').attr('required', false);
                        $('#flipchart_size').attr('required', false);
                        $('#flipchart_qty').attr('required', false);
                        $('#notepad_size').attr('required', false);
                        $('#notepad_qty').attr('required', false);
                        $('#envelope_color').attr('required', false);
                        $('#envelope_qty').attr('required', false);

                        $('#plainpaper').addClass('d-none');
                        $('#flipchart').addClass('d-none');
                        $('#notepad').addClass('d-none');
                        $('#envelope').addClass('d-none');

                        $('#orderButton').attr('disabled', false);
                    } else if (productVal == 'Flip Chart') {
                        $('#flipchart').removeClass('d-none');

                        $('#flipchart_size').attr('required', true);
                        $('#flipchart_qty').attr('required', true);

                        $('#plainpaper_size').attr('required', false);
                        $('#plainpaper_type').attr('required', false);
                        $('#plainpaper_qty').attr('required', false);
                        $('#ruledpaper_qty').attr('required', false);
                        $('#notepad_size').attr('required', false);
                        $('#notepad_qty').attr('required', false);
                        $('#envelope_color').attr('required', false);
                        $('#envelope_qty').attr('required', false);

                        $('#plainpaper').addClass('d-none');
                        $('#ruledpaper').addClass('d-none');
                        $('#notepad').addClass('d-none');
                        $('#envelope').addClass('d-none');

                        $('#orderButton').attr('disabled', false);
                    } else if (productVal == 'Notepad') {
                        $('#notepad').removeClass('d-none');

                        $('#notepad_size').attr('required', true);
                        $('#notepad_qty').attr('required', true);

                        $('#plainpaper_size').attr('required', false);
                        $('#plainpaper_type').attr('required', false);
                        $('#plainpaper_qty').attr('required', false);
                        $('#ruledpaper_qty').attr('required', false);
                        $('#flipchart_size').attr('required', false);
                        $('#flipchart_qty').attr('required', false);
                        $('#envelope_color').attr('required', false);
                        $('#envelope_qty').attr('required', false);

                        $('#plainpaper').addClass('d-none');
                        $('#ruledpaper').addClass('d-none');
                        $('#flipchart').addClass('d-none');
                        $('#envelope').addClass('d-none');

                        $('#orderButton').attr('disabled', false);
                    } else if (productVal == 'Envelope') {
                        $('#envelope').removeClass('d-none');

                        $('#envelope_color').attr('required', true);
                        $('#envelope_qty').attr('required', true);

                        $('#plainpaper_size').attr('required', false);
                        $('#plainpaper_type').attr('required', false);
                        $('#plainpaper_qty').attr('required', false);
                        $('#ruledpaper_qty').attr('required', false);
                        $('#flipchart_size').attr('required', false);
                        $('#flipchart_qty').attr('required', false);
                        $('#notepad_size').attr('required', false);
                        $('#notepad_qty').attr('required', false);

                        $('#plainpaper').addClass('d-none');
                        $('#ruledpaper').addClass('d-none');
                        $('#flipchart').addClass('d-none');
                        $('#notepad').addClass('d-none');

                        $('#orderButton').attr('disabled', false);
                    } else {
                        
                        $('#plainpaper').addClass('d-none');
                        $('#ruledpaper').addClass('d-none');
                        $('#flipchart').addClass('d-none');
                        $('#notepad').addClass('d-none');
                        $('#envelope').addClass('d-none');
                        $('#orderButton').attr('disabled', true);
                    }

                } else {
                    alert();
                }

            });
        });
    </script>

</body>
</html>
