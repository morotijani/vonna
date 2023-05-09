<?php 
    // 404 PAGE
    //echo md5(uniqid(mt_rand(), true)) . '<br>';
    //echo time() . mt_rand() . 23;
    require_once ('./../db_connection/conn.php');
    if (!user_is_logged_in()) {
        user_login_redirect();
    }
    include ('../inc/header.inc.php');

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
                            Your <span class="text-underline-warning">profile</span>
                        </h2>
                        <ul class="list-group">
                            <li class="list-group-item">Full name: <?= ucwords($user_data['user_fullname']); ?></li>
                            <li class="list-group-item">Email: <?= $user_data['user_email']; ?></li>
                            <li class="list-group-item">Phone: <?= $user_data['user_phone']; ?></li>
                            <li class="list-group-item">Occupation: <?= $user_data['user_occupation']; ?></li>
                            <li class="list-group-item">Name of Institution: <?= $user_data['user_name_of_instituition']; ?></li>
                            <li class="list-group-item">Size of Institution: <?= $user_data['user_size_of_instituition']; ?></li>
                            <li class="list-group-item">Country: <?= ucwords($user_data['user_country']); ?></li>
                            <li class="list-group-item">State/Region: <?= ucwords($user_data['user_state']); ?></li>
                            <li class="list-group-item">City: <?= ucwords($user_data['user_city']); ?></li>
                            <li class="list-group-item">Postal Address: <?= $user_data['user_postal_address']; ?></li>
                            <li class="list-group-item">Physical Address: <?= $user_data['user_physical_address']; ?></li>
                            <li class="list-group-item">Joined Date: <?= pretty_date($user_data['user_joined_date']); ?></li>
                        </ul>
                        <a href="<?= PROOT; ?>account/settings">edit >></a>
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
