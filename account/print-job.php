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

    if (isset($_SERVER['REQUEST_METHOD']) == 'POST' && isset($_POST['orderButton'])) {
        // code...
        if ($user_data['user_physical_address'] == '' || $user_data['user_postal_address'] == '') {
            $_SESSION['flash_error'] = 'Complete your profile to be able to make an order.';
            redirect(PROOT . 'account/index');
        }
        $post = cleanPost($_POST);
        
        $product = $post['product'];
        $quantity = '';
        $size = '';
        $type = '';
        $a_type = '';
        $color = '';

        $userid = $user_id;
        $orderid = time() . mt_rand() . $userid;
        $order_date = date('Y-m-d H:i:s');


        if ($post['product'] == 'Plain Paper') {
            $size = $post['plain_A_type'];
            $type = $post['plainpaper_type'];
            $quantity =  $post['plainpaper_qty'];
        } else if ($post['product'] == 'Ruled Paper') {
            $quantity = $post['ruledpaper_qty'];
        } else if ($post['product'] == 'Flip Chart') {
            $size = $post['flipchart_size'];
            $quantity = $post['flipchart_qty'];
        } else if ($post['product'] == 'Notepad') {
            $size = $post['notepad_size'];
            $quantity = $post['notepad_qty'];
        } else if ($post['product'] == 'Envelope') {
            $color = $post['envelope_color'];
            $quantity = $post['envelope_qty'];
            $size = $post['envelope_type'];
        } else {
            $_SESSION['flash_error'] = 'Select a product to order!';
            redirect(PROOT . 'account/index');
        }


        $query = '
            INSERT INTO `vonna_orders`(`orders_id`, `orders_product`, `orders_size`, `orders_type`, `orders_quantity`, `orders_color`, `orders_userid`, `orders_orderdate`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ';
        $statement = $conn->prepare($query);
        $result = $statement->execute([
            $orderid,
            $product,
            $size,
            $type,
            $quantity,
            $color,
            $userid,
            $order_date
        ]);

        if (isset($result)) {
            // code...
            $_SESSION['flash_success'] = $post['product'] . ' order successfully made, product will be delivered soon.';
            redirect(PROOT . 'account/index');
        } else {
            $_SESSION['flash_error'] = 'Order couldn\'t go through, please try again';
            redirect(PROOT . 'account/index');
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
                        <form id="printjobForm" method="POST">
                            <div class="form-group">
                                <label class="visually-hidden" for="print-type">
                                    what print job do you want?
                                </label>
                                <select class="form-control" id="print-type" name="print-type" type="text">
                                    <option value="">what print job do you want?</option>
                                    <option>Examination questions</option>
                                    <option>Thesis</option>
                                    <option>Fliers</option>
                                    <option>Banners</option>
                                    <option>Receipt books</option>
                                    <option>Invoice</option>
                                    <option>Customized office Files</option>
                                </select>
                            </div>
 
                            <div class="exams d-none">
                                <table class="table table-sm" id="dynamic_field">  
                                    <tr>  
                                        <td><input type="text" name="name-of-subject[]" placeholder="Name of subject" class="form-control name-of-subject" /></td>  
                                        <td><input type="number" min='0' name="number-to-be-printed[]" placeholder="Number to be printed" class="form-control number-to-be-printed" /></td>  
                                        <td>
                                            <select type="text" name="level[]" placeholder="Enter your Name" class="form-control level">
                                                <option>Level</option>
                                                <option>Tertiary</option>
                                                <option>SHS</option>
                                                <option>JHS</option>
                                                <option>Primary</option>
                                                <option>Kindargarten</option>
                                                <option>Nursery</option>
                                            </select>
                                        </td>  
                                        <td><input type="text" name="class-or-form[]" placeholder="Class/Form" class="form-control class-or-form" /></td>  
                                        <td><button type="button" name="add" id="add" class="btn btn-sm btn-success">Add subject</button></td>  
                                    </tr>  
                                </table>

                                <div class="form-group">
                                    <label for="">Do you have the questions typed already?</label>
                                    <br>
                                    <input type="radio" class="" name="typed-already" value="Yes">
                                    <label for="">Yes</label>
                                    <br>
                                    <input type="radio" class="" name="typed-already" value="Yes">
                                    <label for="">No</label>
                                </div>

                                <div class="form-group d-none yes-typed">
                                    <label for="">If yes, upload your typed work here?</label>
                                    <input type="file" name="upload-typed-work" class="form-control">
                                </div>

                                <div class="form-group d-none no-typed">
                                    <label for="">If no, Do you want us to type for you?</label>
                                    <br>
                                    <input type="radio" class="" name="want-us-to-type" value="Yes">
                                    <label for="">Yes</label>
                                    <br>
                                    <input type="radio" class="" name="want-us-to-type" value="Yes">
                                    <label for="">No</label>
                                </div>

                                <div class="form-group">
                                    <select name="when-to-be-delivered" id="" class="form-control">
                                        <option value="">When do you want the print job delivered?</option>
                                        <option>Hours</option>
                                        <option>Days</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Enter devlivery Address here</label>
                                    <input type="text" name="delivery-address-1" class="form-control" id="" placeholder="Receipient Contact 1">
                                    <br>
                                    <input type="text" name="delivery-address-2" class="form-control" id="" placeholder="Receipient Contact 2">
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

                    var i = 1;  
                    $('#add').click(function() {  
                        i++;  
                        $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-sm btn-danger btn_remove">X</button></td></tr>');  
                        $('#dynamic_field').append(`
                            <tr id='row'+i+'"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-sm btn-danger btn_remove">X</button></td></tr>');  
                    });

                    $(document).on('click', '.btn_remove', function() {  
                        var button_id = $(this).attr("id");   
                        $('#row'+button_id+'').remove();  
                    });

                    $('#submit').click(function() {            
                       $.ajax ({  
                            url:"name.php",  
                            method:"POST",  
                            data:$('#add_name').serialize(),  
                            success:function(data) {  
                                alert(data);  
                                $('#add_name')[0].reset();  
                            }  
                        });
                    });  
                    
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
