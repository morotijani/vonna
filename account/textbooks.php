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
                            Make An <span class="text-underline-warning">Order</span>
                        </h2>
                        <form id="orderForm" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Which writer are you looking for?</label>
                                <br>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="writer" id="" value="Excellence Series">
                                    <label for="" class="form-check-label">Excellence Series</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="writer" id="" value="Golden Series">
                                    <label for="" class="form-check-label">Golden Series</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="writer" id="" value="Reuben Series">
                                    <label for="" class="form-check-label">Reuben Series</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="writer" id="" value="Approaches">
                                    <label for="" class="form-check-label">Approaches</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="writer" id="" value="Aki oLa">
                                    <label for="" class="form-check-label">Aki oLa</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="writer" id="" value="Flamingo">
                                    <label for="" class="form-check-label">Flamingo</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="writer" id="" value="Myles">
                                    <label for="" class="form-check-label">Myles</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="writer" id="" value="Reuben Series">
                                    <label for="" class="form-check-label">Reuben Series</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="writer" id="" value="Kofi BIO">
                                    <label for="" class="form-check-label">Kofi BIO</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="writer" id="" value="Other">
                                    <label for="" class="form-check-label">Other</label>   
                                </div>
                            </div>

                            <div class="d-none" id="other">
                                <div class="form-group mb-3">
                                    <label>Specify</label>
                                    <input type="text" name="writer" class="form-control">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="">What is the title of the book you are looking for?</label>
                                    <input type="text" class="form-control" name="title" value="" placeholder="Title">
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="">What level do of study are you looking for?</label>
                                    <select class="form-control" id="other-level" name="level" type="text">
                                        <option value="">Level:</option>
                                        <option value="Chreche">Chreche</option>
                                        <option value="Nursery">Nursery</option>
                                        <option value="Kindergarten">Kindergarten</option>
                                        <option value="Lower Primary">Lower Primary</option>
                                        <option value="Upper Primary">Upper Primary</option>
                                        <option value="Junior High School">Junior High School</option>
                                        <option value="Senior High School">Senior High School</option>
                                        <option value="Nursing Training">Nursing Training</option>
                                        <option value="Teacher Training">Teacher Training</option>
                                        <option value="Thertiary">Thertiary</option>
                                    </select>
                                </div>
                            </div>


                            <!-- EXCELLENCE SERIES -->
                            <div class="d-none" id="exellence-series">
                                <div class="form-group mb-3">
                                    <label for="">What level do of study are you looking for?</label>
                                    <select class="form-control" id="exellence-level" name="level" type="text">
                                        <option value="">Level:</option>
                                        <option value="Nursery">Nursery</option>
                                        <option value="Primary">Primary</option>
                                    </select>
                                </div>

                                <!-- EXCELLENCE SERIES NUSERY -->
                               <div class="d-none form-group mb-3" id="exellence-nusery">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="book" id="" value="Coloring">
                                        <label for="" class="form-check-label">Coloring</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Pre writing">
                                        <label for="" class="form-check-label">Pre writing</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Phoemix">
                                        <label for="" class="form-check-label">Phoemix</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Literacy">
                                        <label for="" class="form-check-label">Literacy</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Numeracy">
                                        <label for="" class="form-check-label">Numeracy</label>
                                    </div>
                                </div>

                                <!-- EXCELLENCE SERIES PRIMARY -->
                                <div class="d-none form-group mb-3" id="exellence-primary">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="book" id="" value="Mathematics">
                                        <label for="" class="form-check-label">Mathematics</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="English">
                                        <label for="" class="form-check-label">English</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Science">
                                        <label for="" class="form-check-label">Science</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="RME">
                                        <label for="" class="form-check-label">RME</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Creative Arts">
                                        <label for="" class="form-check-label">Creative Arts</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Our World and our people">
                                        <label for="" class="form-check-label">Our World and our people</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Computing">
                                        <label for="" class="form-check-label">Computing</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="History">
                                        <label for="" class="form-check-label">History</label>
                                    </div>
                                </div>
                            </div>

                            <!-- GOLDEN SERIES -->
                            <div class="d-none" id="golden-series">
                                <div class="form-group mb-3">
                                    <label for="">What level do of study are you looking for?</label>
                                    <select class="form-control" id="golden-level" name="level" type="text">
                                        <option value="">Level:</option>
                                        <option value="Kindergarten">Kindergarten</option>
                                        <option value="Nursery">Nursery</option>
                                        <option value="Primary">Primary</option>
                                    </select>
                                </div>

                                <!-- GOLDEN SERIES KINDERGARTEN -->
                                <div class="form-group mb-3 d-none" id="golden-kindergarten">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="book" id="" value="Creative Arts">
                                        <label for="" class="form-check-label">Creative Arts</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Coloring">
                                        <label for="" class="form-check-label">Coloring</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Mathematics">
                                        <label for="" class="form-check-label">Mathematics</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="English">
                                        <label for="" class="form-check-label">English</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Our World and our people">
                                        <label for="" class="form-check-label">Our World and our people</label>
                                    </div>
                                </div>

                                <!-- GOLDEN SERIES NURSERY -->
                                <div class="form-group mb-3 d-none" id="golden-nursery">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="book" id="" value="Mathematics">
                                        <label for="" class="form-check-label">Mathematics</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="English">
                                        <label for="" class="form-check-label">English</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Coloring">
                                        <label for="" class="form-check-label">Coloring</label>
                                    </div>
                                </div>

                                <!-- GOLDEN SERIES PRIMARY -->
                                <div class="form-group mb-3" id="golden-primary">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="book" id="" value="Mathematics">
                                        <label for="" class="form-check-label">Mathematics</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="English">
                                        <label for="" class="form-check-label">English</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Science">
                                        <label for="" class="form-check-label">Science</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Religious and Moral Education (RME)">
                                        <label for="" class="form-check-label">Religious and Moral Education (RME)</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Creative Arts">
                                        <label for="" class="form-check-label">Creative Arts</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Our World and our people">
                                        <label for="" class="form-check-label">Our World and our people</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="History">
                                        <label for="" class="form-check-label">History</label>
                                    </div>
                                </div>
                            </div>

                            <!-- BEST BRAIN -->
                            <div class="" id="golden-series">
                                <!-- BEST BRAIN Primary -->
                                <div class="form-group mb-3" id="bestbrain-primary">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="book" id="" value="Mathematics">
                                        <label for="" class="form-check-label">Mathematics</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="English">
                                        <label for="" class="form-check-label">English</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Science">
                                        <label for="" class="form-check-label">Science</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="RME">
                                        <label for="" class="form-check-label">RME</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Creative Arts">
                                        <label for="" class="form-check-label">Creative Arts</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Our World and our people">
                                        <label for="" class="form-check-label">Our World and our people</label>
                                    </div>
                                </div>
                            </div>

                            <!-- AKI-OLA SERIES -->
                            <div class="" id="golden-series">
                                <!-- AKI-OLA SERIES JUNIOR HIGH SCHOOL -->
                                <div class="form-group mb-3" id="akiola-jhs">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="book" id="" value="Mathematics">
                                        <label for="" class="form-check-label">Mathematics</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="English">
                                        <label for="" class="form-check-label">English</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Science">
                                        <label for="" class="form-check-label">Science</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="RME">
                                        <label for="" class="form-check-label">RME</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Social">
                                        <label for="" class="form-check-label">Social</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Information communication Technology">
                                        <label for="" class="form-check-label">Information communication Technology</label>
                                    </div>
                                </div>

                                <!-- AKI-OLA SERIES SENIOR HIGH SCHOOL -->
                                <div class="form-group mb-3" id="akiola-shs">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="book" id="" value="Mathematics">
                                        <label for="" class="form-check-label">Mathematics</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="English">
                                        <label for="" class="form-check-label">English</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Integrated Science">
                                        <label for="" class="form-check-label">Integrated Science</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="RME">
                                        <label for="" class="form-check-label">RME</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Social Studies">
                                        <label for="" class="form-check-label">Social Studies</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Information communication Technology">
                                        <label for="" class="form-check-label">Information communication Technology</label>
                                    </div>
                                </div>
                            </div>

                            <!-- APPROACHERS -->
                            <div class="" id="approachers">
                                <!-- APPROACHERS SENIOR HIGH SCHOOL -->
                                <div class="form-group mb-3" id="approachers-shs">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="book" id="" value="Mathematics">
                                        <label for="" class="form-check-label">Mathematics</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="English">
                                        <label for="" class="form-check-label">English</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Integrated Science">
                                        <label for="" class="form-check-label">Integrated Science</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="RME">
                                        <label for="" class="form-check-label">RME</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Social Studies">
                                        <label for="" class="form-check-label">Social Studies</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Information communication Technology">
                                        <label for="" class="form-check-label">Information communication Technology</label>
                                    </div>
                                </div>
                            </div>

                            <!-- FLAMINGO SERIES -->
                            <div class="" id="flamingo-series">
                                <!-- FLAMINGO SERIES SENIOR HIGH SCHOOL -->
                                <div class="form-group mb-3" id="flamingo-shs">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="book" id="" value="Mathematics">
                                        <label for="" class="form-check-label">Mathematics</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="English">
                                        <label for="" class="form-check-label">English</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Integrated Science">
                                        <label for="" class="form-check-label">Integrated Science</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="RME">
                                        <label for="" class="form-check-label">RME</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Social Studies">
                                        <label for="" class="form-check-label">Social Studies</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="book" id="" value="Information communication Technology">
                                        <label for="" class="form-check-label">Information communication Technology</label>
                                    </div>
                                </div>
                            </div>

                            <!-- REUBEN SERIES -->
                            <div class="" id="reuben-series">
                                <!-- REUBEN SERIES JUNIOR HIGH SCHOOL -->
                                <div class="form-group mb-3" id="reuben-jhs">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="book" id="" value="Integrated Science">
                                        <label for="" class="form-check-label">Integrated Science</label>
                                    </div>
                                </div>
                            </div>

                            <!-- KOFI BIO -->
                            <div class="" id="kofi-bio">
                                <!-- KOFI BIO PRIMARY -->
                                <div class="form-group mb-3" id="kofi-bio-primary">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="book" id="" value="A guide to the Study of French">
                                        <label for="" class="form-check-label">A guide to the Study of French</label>
                                    </div>
                                </div>

                                <!-- JUNIOR HIGH SCHOOL -->
                                <div class="form-group mb-3" id="kofi-bio-jhs">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="book" id="" value="A guide to the Study of French">
                                        <label for="" class="form-check-label">A guide to the Study of French</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">What quantity do you want?</label>
                                <input type="number" min="1" class="form-control" name="quantity" id="quantity">
                            </div>


















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

            // var level = $("#level option:selected").val();

            $('input[name="writer"]').click(function(e) {
                e.preventDefault()
                var writer = $('input[name="writer"]:checked').val();

                if (writer == 'Excellence Series') {
                    $('#exellence-series').removeClass('d-none')
                    $('#golden-series').addClass('d-none')
                    
                    $("#exellence-level").change(function(e) {
                        e.preventDefault()
                        var level = $("#exellence-level option:selected").val();
                        if (level == 'Nursery') {
                            $('#exellence-nusery').removeClass('d-none')
                            $('#exellence-primary').addClass('d-none')
                        } else if (level == 'Primary') {
                            $('#exellence-nusery').addClass('d-none')
                            $('#exellence-primary').removeClass('d-none')
                        }
                    })


                } else if (writer == 'Golden Series') {
                    $('#golden-series').removeClass('d-none')
                    $('#exellence-series').addClass('d-none')
                    
                    $("#exellence-level").change(function(e) {
                        e.preventDefault()
                        var level = $("#exellence-level option:selected").val();
                        if (level == 'Kindergarten') {
                            $('#exellence-nusery').removeClass('d-none')
                            $('#exellence-primary').addClass('d-none')
                        } else if (level == 'Nursery') {
                            $('#exellence-nusery').addClass('d-none')
                            $('#exellence-primary').removeClass('d-none')
                        } else if (level == 'Primary') {
                            $('#exellence-nusery').addClass('d-none')
                            $('#exellence-primary').removeClass('d-none')
                        }
                    })

                } else if (writer == 'Reuben Series') {
                    
                } else if (writer == 'Approaches') {
                    
                } else if (writer == 'Aki oLa') {
                    
                } else if (writer == 'Flamingo') {
                    
                } else if (writer == 'Myles') {
                    
                } else if (writer == 'Reuben Series') {
                    
                } else if (writer == 'Kofi BIO') {
                    
                } else if (writer == 'Other') {
                    
                }



            });
        });
    </script>

</body>
</html>
