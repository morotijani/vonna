<?php 
    // 404 PAGE
    //echo md5(uniqid(mt_rand(), true)) . '<br>';
    //echo time() . mt_rand() . 23;
    require_once ('./../db_connection/conn.php');
    if (!user_is_logged_in()) {
        user_login_redirect();
    }
    include ('../inc/header.inc.php');

    $user_fullname = (isset($_POST['user_fullname']) ? sanitize($_POST['user_fullname']) : $user_data['user_fullname']);
    $user_email = (isset($_POST['user_email']) ? sanitize($_POST['user_email']) : $user_data['user_email']);
    $user_phone = (isset($_POST['user_phone']) ? sanitize($_POST['user_phone']) : $user_data['user_phone']);
    $user_occupation = (isset($_POST['user_occupation']) ? sanitize($_POST['user_occupation']) : $user_data['user_occupation']);
    $user_name_of_instituition = (isset($_POST['user_name_of_instituition']) ? sanitize($_POST['user_name_of_instituition']) : $user_data['user_name_of_instituition']);
    $user_size_of_instituition = (isset($_POST['user_size_of_instituition']) ? sanitize($_POST['user_size_of_instituition']) : $user_data['user_size_of_instituition']);
    $user_country = (isset($_POST['user_country']) ? sanitize($_POST['user_country']) : $user_data['user_country']);
    $user_state = (isset($_POST['user_state']) ? sanitize($_POST['user_state']) : $user_data['user_state']);
    $user_city = (isset($_POST['user_city']) ? sanitize($_POST['user_city']) : $user_data['user_city']);
    $user_postal_address = (isset($_POST['user_postal_address']) ? sanitize($_POST['user_postal_address']) : $user_data['user_postal_address']);
    $user_physical_address = (isset($_POST['user_physical_address']) ? sanitize($_POST['user_physical_address']) : $user_data['user_physical_address']);
    if ($_POST) {
        // code...
        $sql = '
            UPDATE `vonna_user` SET `user_fullname` = ?, `user_email` = ?, `user_phone` = ?, `user_occupation` = ?, `user_name_of_instituition` = ?, `user_postal_address` = ?, `user_physical_address` = ?, `user_size_of_instituition` = ?, `user_country` = ?, `user_state` = ?, `user_city` = ? 
            WHERE `user_id` = ?
        ';
        $statement = $conn->prepare($sql);
        $result = $statement->execute([
            $user_fullname,
            $user_email,
            $user_phone,
            $user_occupation,
            $user_name_of_instituition,
            $user_postal_address,
            $user_physical_address,
            $user_size_of_instituition,
            $user_country,
            $user_state,
            $user_city,
            $user_id
        ]);
        if (isset($result)) {
            // code...
            $_SESSION['flash_success'] = 'Your profile has been updated.';
            redirect(PROOT . 'account/settings');
        } else {
            $_SESSION['flash_error'] = 'Something went wrong, try again.';
            redirect(PROOT . 'account/settings');
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
                            <span class="text-underline-warning">Settings</span>
                        </h2>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="user_fullname" class="form-label">Full name</label>
                                <input type="text" class="form-control" id="user_fullname" name="user_fullname" value="<?= $user_fullname; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="user_email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="user_email" name="user_email" value="<?= $user_email?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="user_phone" class="form-label">Phone</label>
                                <input type="text" name="user_phone" class="form-control" id="user_phone" value="<?= $user_phone; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="user_occupation" class="form-label">Occupation</label>
                                <input type="text" name="user_occupation" class="form-control" id="user_occupation" value="<?= $user_occupation; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="user_name_of_instituition" class="form-label">Name of Institution</label>
                                <input type="text" name="user_name_of_instituition" class="form-control" id="user_name_of_instituition" value="<?= $user_name_of_instituition; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="user_size_of_instituition" class="form-label">Size of Institution</label>
                                <input type="text" name="user_size_of_instituition" class="form-control" id="user_size_of_instituition" value="<?= $user_size_of_instituition; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="user_country" class="form-label">Country</label>
                                <input type="text" name="user_country" class="form-control" id="user_country" value="<?= $user_country; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="user_state" class="form-label">State/Region</label>
                                <input type="text" name="user_state" class="form-control" id="user_state" value="<?= $user_state; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="user_city" class="form-label">City</label>
                                <input type="text" name="user_city" class="form-control" id="user_city" value="<?= $user_city; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="user_postal_address" class="form-label">Postal Address</label>
                                <input type="text" name="user_postal_address" class="form-control" id="user_postal_address" value="<?= $user_postal_address; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="user_physical_address" class="form-label">Physical Address</label>
                                <input type="text" name="user_physical_address" class="form-control" id="user_physical_address" value="<?= $user_physical_address; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        <a href="<?= PROOT; ?>account/change-password">change password >></a>
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
    </script>

</body>
</html>
