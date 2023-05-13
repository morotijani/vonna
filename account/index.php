<?php 
    // INDEX PAGE
    //echo md5(uniqid(mt_rand(), true)) . '<br>';
    //echo time() . mt_rand() . 23;
    require_once ('./../db_connection/conn.php');
    if (!user_is_logged_in()) {
        user_login_redirect();
    }
    include ('../inc/header.inc.php');

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
            <div class="row align-items-start">
                <div class="col-lg-3 col-xl-2">
                    <div class="my-6 my-md-9 px-lg-8 border-start">

                        <!-- List -->
                        <ul class="list-unstyled fs-xs mb-0">
                            <li class="mb-2">
                                <a class="text-reset" href="<?= PROOT; ?>index">Visit Site</a>
                            </li>
                            <li class="mb-2">
                                <a class="text-reset" href="<?= PROOT; ?>account/index">App</a>
                            </li>
                            <li class="mb-2">
                                <a class="text-reset" href="<?= PROOT; ?>account/orders">Orders</a>
                            </li>
                            <li class="mb-2">
                                <a class="text-reset" href="<?= PROOT; ?>account/profile">Profile</a>
                            </li>
                            <li class="mb-2">
                                <a class="text-reset" href="<?= PROOT; ?>account/settings">Settings</a>
                            </li>
                            <li class="mb-2">
                                <a class="text-reset" href="<?= PROOT; ?>account/change-password">Change Password</a>
                            </li>
                            <li class="mb-2">
                                <a class="text-reset" href="<?= PROOT; ?>auth/logout">Logout</a>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="col-lg-9 col-xl-8 offset-lg-3 offset-xl-2 py-6 py-md-9">
                    <section class="py-1">
                        <h2 class="display-3 text-center mb-4">
                            Make An <span class="text-underline-warning">Order</span>
                        </h2>
                        <form id="orderForm" method="POST">
                            <div class="form-group">
                                <label class="visually-hidden" for="product">
                                    What item do you want:
                                </label>
                                <select class="form-control" id="product" name="product" type="text">
                                    <option value="">What item do you want:</option>
                                    <option value="Plain Paper">Plain Paper</option>
                                    <option value="Ruled Paper">Ruled Paper</option>
                                    <option value="Flip Chart">Flip Chart</option>
                                    <option value="Notepad">Notepad</option>
                                    <option value="Envelope">Envelope</option>
                                </select>
                            </div>

                            <div id="plainpaper" class="d-none">
                                <div class="form-group">
                                    <select class="form-control" id="plain_A_type" name="plain_A_type" type="text">
                                        <option value="">What size of paper would you need:</option>
                                        <option value="A4">A4</option>
                                        <option value="A3">A3</option>
                                        <option value="A1">A1</option>
                                    </select>
                                </div>
                                <div class="input-group form-group">
                                    <select type="text" class="form-control" name="plainpaper_type" id="plainpaper_type">
                                        <option value="">What quantity would you want</option>
                                        <option value="Rim(s)">Rim(s)</option>
                                        <option value="Box(es)">Box(es)</option>
                                    </select>
                                    <span class="input-group-text">&</span>
                                    <input type="number" min="1" class="form-control" name="plainpaper_qty" id="plainpaper_qty" placeholder="Quantity" aria-label="Server">
                                </div>
                            </div>

                            <div id="ruledpaper" class="d-none">
                                <div class="form-group">
                                    <label class="visually-hidden" for="ruledpaper_qty">
                                        Ruled Paper
                                    </label>
                                    <input type="number" min="1" class="form-control" name="ruledpaper_qty" id="ruledpaper_qty" placeholder="Quantity" aria-label="Server">
                                </div>
                            </div>

                            <div id="flipchart" class="d-none">
                                <div class="input-group form-group">
                                    <input type="text" class="form-control" name="flipchart_size" id="flipchart_size" placeholder="What size do you want:" aria-label="Server">
                                    <span class="input-group-text">&</span>
                                    <input type="number" min="1" class="form-control" name="flipchart_qty" id="flipchart_qty" placeholder="Quantity" aria-label="Server">
                                </div>
                            </div>

                            <div id="notepad" class="d-none">
                                <div class="input-group form-group">
                                    <input type="text" min="1" class="form-control" name="notepad_size" id="notepad_size" placeholder="What size do you want:" aria-label="Server">
                                    <span class="input-group-text">&</span>
                                    <input type="number" min="1" class="form-control" name="notepad_qty" id="notepad_qty" placeholder="Quantity" aria-label="Server">
                                </div>
                            </div>

                            <div id="envelope" class="d-none">
                                <div class="input-group form-group">
                                    <select class="form-control" id="envelope_color" name="envelope_color" type="text">
                                        <option value="">What color of Envelopes would you want:</option>
                                        <option value="Brown">Brown</option>
                                        <option value="White">White</option>
                                    </select>
                                    <span class="input-group-text">&</span>
                                    <input type="number" min="1" class="form-control" name="envelope_qty" id="envelope_qty" placeholder="Quantity" aria-label="Server">
                                </div>
                                <div class="form-group">
                                    <select class="form-control" id="envelope_type" name="envelope_type" type="text">
                                        <option value="">What size of Envelope do you want:</option>
                                        <option value="A4">A4</option>
                                        <option value="A3">A3</option>
                                        <option value="A1">A1</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn w-100 btn-warning" id="orderButton" name="orderButton" disabled>
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
