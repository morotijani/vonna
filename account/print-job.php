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

    if (isset($_SERVER['REQUEST_METHOD']) == 'POST' && isset($_POST['printjobSubmitButton'])) {
        $post = (cleanPost(isset($_POST) ? $_POST : ''));
        dnd($post);

        if (isset($_POST['print_type']) && $post['print_type'] == "Examination questions") {
            $print_type = ((isset($_POST['print_type']) && !empty($_POST['print_type'])) ? $post['print_type'] : '');
            $name_of_subject = ((isset($_POST['name_of_subject']) && !empty($_POST['name_of_subject'])) ? $post['name_of_subject'] : '');
            $number_to_be_printed = ((isset($_POST['number_to_be_printed']) && !empty($_POST['number_to_be_printed'])) ? $post['number_to_be_printed'] : '');
            $level = ((isset($_POST['level']) && !empty($_POST['level'])) ? $post['level'] : '');
            $class_or_form = ((isset($_POST['class_or_form']) && !empty($_POST['class_or_form'])) ? $post['class_or_form'] : '');
            $total_students = ((isset($_POST['total_students']) && !empty($_POST['total_students'])) ? $post['total_students'] : '');
            $typed_already = ((isset($_POST['typed_already']) && !empty($_POST['typed_already'])) ? $post['typed_already'] : '');
            $want_us_to_type = ((isset($_POST['want_us_to_type']) && !empty($_POST['want_us_to_type'])) ? $post['want_us_to_type'] : '');
            $when_to_be_delivered = ((isset($_POST['when_to_be_delivered']) && !empty($_POST['when_to_be_delivered'])) ? $post['when_to_be_delivered'] : '');;
            $delivery_address_1 = ((isset($_POST['delivery_address_1']) && !empty($_POST['delivery_address_1'])) ? $post['delivery_address_1'] : '');
            $delivery_address_2 = ((isset($_POST['delivery_address_2']) && !empty($_POST['delivery_address_2'])) ? $post['delivery_address_2'] : '');

            $count_subjects = count($post['name_of_subject']);
            if ($count_subjects > 0) {  
                for ($i = 0; $i < $count_subjects; $i++) {
                    if ($post['name_of_subject'][$i] != '') {
                        // code...
                    }
                }
            }

            if (isset($_FILES['upload_typed_work'])) {
                echo 'setted';
                if (!empty($_FILES)) {
                    echo 'not';
                    $count_files = count($_FILES['upload_typed_work']['name']);
                    dnd($count_files);
                }
            } else {
                echo 'qsd';
            }



            $query = "
                INSERT INTO `vonna_printjob` (`printjob_id`, `printjob_print_type`, `printjob_name_of_subject`, `printjob_number_to_be_printed`, `printjob_level`, `printjob_class_or_form`, `printjob_total_students`, `printjob_typed_already`, `printjob_upload_typed_work`, `printjob_want_us_to_type`, `printjob_when_to_be_delivered`, `printjob_delivery_address_1`, `printjob_delivery_address_2`, `printjob_createdAt`) 
                VALUES ()
            ";
            $statement = $conn->prepare($query);
            $statement->execute($data);
        }

    }

?>


    <!-- BODY -->
    <main class="">
        <?= $flash; ?>
        <div class="container-lg d-flex flex-column">
            <div class="row align-items-start justify-content-center">
                <div class="col-lg-12 py-6 py-md-9">
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

                                <label for="">If no, Do you want us to type for you?</label>
                                <br>
                                <div class="form-check d-none no-typed">
                                    <input type="radio" class="form-check-input" name="want_us_to_type" id="want-us-to-typeYes" value="Yes">
                                    <label for="want-us-to-typeYes" class="form-check-label">Yes</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="want_us_to_type" id="want-us-to-typeNo" value="No">
                                    <label for="want-us-to-typeNo" class="form-check-label">No</label>
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

                            <div class="thesis d-none"></div>
                            <div class="fliers d-none"></div>
                            <div class="banners d-none"></div>
                            <div class="receipt d-none"></div>
                            <div class="invoice d-none"></div>
                            <div class="customized d-none"></div>

                            <button type="submit" class="btn w-100 btn-warning" id="printjobSubmitButton" name="printjobSubmitButton" disabled>
                                Order Now
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


                    // $('#submit').click(function() {

                    //    $.ajax ({  
                    //         url:"name.php",  
                    //         method:"POST",  
                    //         data:$('#add_name').serialize(),  
                    //         success:function(data) {  
                    //             alert(data);  
                    //             $('#add_name')[0].reset();  
                    //         }  
                    //     });
                    // });  
                    
                    // $("#print-type").click(function() {}

                }

                if (printType == 'Thesis') {
                    
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
