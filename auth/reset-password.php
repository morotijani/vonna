<?php 

// RESET PASSWORD
require_once ('../db_connection/conn.php');
if (user_is_logged_in()) {
    redirect(PROOT . 'account/index');
}
include ('../inc/header.inc.php');


$errors = '';
$userId = issetElse($_SESSION, 'password_reset_user_id', 0);
$code = issetElse($_SESSION, 'password_reset_code_verified', 0);
if ($userId != 0 && $code != 0) {
    // code...

    $post = [];
    if ($_POST) {
        $post = cleanPost($_POST);
        $password = $post['password'];
        $confirm = $post['confirm'];
        //verification
        $required = ['password' => "Password", 'confirm' => "Confirm Password"];
        foreach ($required as $field => $display) {
            if (empty($post[$field])){
                $errors = '<div class="alert alert-light text-danger" role="alert">' . $display . ' is required.</div>';
            }
        }

        if ($userId == 0 || $code == 0) {
            $errors = '<div class="alert alert-light text-danger" role="alert">Something has gone wrong. Please try again.</div>';
        }

        if ($password !== $confirm) {
            $errors = '<div class="alert alert-light text-danger" role="alert">Your passwords do not match.</div>';
        }

        if(empty($errors)) {

            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "
                UPDATE vonna_user 
                SET user_password = :user_password 
                WHERE user_id = :user_id
            ";
            $statement = $conn->prepare($sql);
            $result = $statement->execute([
                ':user_password' => $hashed,
                ':user_id' => $userId
            ]);

            if ($result) {

                unset($_SESSION['password_reset_user_Id'], $_SESSION['password_reset_code_verified']);
                $expired = date("Y-m-d H:i:s", strtotime("-14 days"));

                $sql = "
                    DELETE FROM vonna_user_password_resets 
                    WHERE password_reset_user_id = :password_reset_user_id 
                    OR password_reset_created_at < :password_reset_created_at
                ";
                $statement = $conn->prepare($sql);
                $statement->execute(
                    array(
                        ':password_reset_user_id'   => $userId,
                        ':password_reset_created_at' => $expired
                    )
                );
                redirect(PROOT . 'auth/signin');
            } else {
                $errors = '<div class="alert alert-light text-danger" role="alert">Something has gone wrong. Please try again.<div>';
            }
        }
    }

?>
    <main class="">
        <div class="container-lg d-flex flex-column">
            <div class="row align-items-center justify-content-center min-vh-100 py-10 py-md-12 mt-n1">
                <div class="col-12 col-md-7 col-lg-5 text-center">
                    <h1 class="display-3 mb-4">
                        Reset Password.
                    </h1>
                    <?= $errors; ?>
                    <form class="mb-6" method="POST">
                        <div class="form-group">
                            <div class="input-group inpit-group-merge">
                                <input class="form-control" id="password" name="password" placeholder="Your password" type="password" aria-label="Your password" aria-describedby="authPasswordCaption">
                                <a class="input-group-text text-decoration-none text-gray-500" id="authPasswordCaption" data-toggle="password" href="#password">
                                    <i class="fe fe-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group inpit-group-merge">
                                <input class="form-control" id="confirm" name="confirm" placeholder="Confirm password" type="password" aria-label="Your password" aria-describedby="authPasswordCaption">
                                <a class="input-group-text text-decoration-none text-gray-500" id="confirm" data-toggle="password" href="#confirm">
                                    <i class="fe fe-eye"></i>
                                </a>
                            </div>
                        </div>
                        <button class="btn w-100 btn-warning mb-2" type="submit">
                            Reset Password
                        </button>
                        <a href="<?= PROOT; ?>auth/signin" class="">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </main>


<?php 
    } else {
        redirect(PROOT . 'shop/reset-verify');
    }

?>
    <script src="<?= PROOT; ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>
    <script src="<?= PROOT; ?>assets/js/vendor.bundle.js"></script>
    <script src="<?= PROOT; ?>assets/js/theme.bundle.js"></script>
    
    <script>
        // Fade out messages
        $("#temporary").fadeOut(5000);
    </script>
</body>
</html>