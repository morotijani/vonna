<?php 
    // 404 PAGE
    //echo md5(uniqid(mt_rand(), true)) . '<br>';
    //echo time() . mt_rand() . 23;
    require_once ('./../db_connection/conn.php');
    if (!user_is_logged_in()) {
        user_login_redirect();
    }
    include ('../inc/header.inc.php');
    include ('header.account.php');

    $errors = '';
    $hashed = $user_data['user_password'];
    $old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
    $old_password = trim($old_password);
    $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
    $password = trim($password);
    $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
    $confirm = trim($confirm);
    $new_hashed = password_hash($password, PASSWORD_BCRYPT);
    $user_id = $user_data['user_id'];

    if ($_POST) {
        if (empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])) {
            $errors = 'You must fill out all fields';
        } else {

            if (strlen($password) < 6) {
                $errors = 'Password must be at least 6 characters';
            }

            if ($password != $confirm) {
                $errors = 'The new password and confirm new password does not match.';
            }

            if (!password_verify($old_password, $hashed)) {
                $errors = 'Your old password does not our records.';
            }
        }

        if (!empty($errors)) {
            $errors;
        } else {
            $query = '
                UPDATE vonna_user 
                SET user_password = :user_password 
                WHERE user_id = :user_id
            ';
            $satement = $conn->prepare($query);
            $result = $satement->execute(
                array(
                    ':user_password' => $new_hashed,
                    ':user_id' => $user_id
                )
            );
            if (isset($result)) {
                $_SESSION['flash_success'] = 'Password successfully UPDATED</div>';
                redirect(PROOT . "account/change-password");
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
                    <section class="py-1">
                        <h2 class="display-3 text-center mb-4">
                            Change <span class="text-underline-warning">password</span>
                        </h2>
                        <form method="POST">
                            <p class="text-danger"><?= $errors; ?></p>
                            <div class="mb-3">
                                <label for="user_fullname" class="form-label">Old password</label>
                                <input type="password" class="form-control" id="old_password" name="old_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="user_email" class="form-label">New password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="user_phone" class="form-label">Confirm new password</label>
                                <input type="password" name="confirm" class="form-control" id="confirm" required>
                            </div>
                            <button type="submit" class="btn btn-warning">Submit</button>
                        </form>
                        <a href="<?= PROOT; ?>account/settings">update profile >></a>
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
