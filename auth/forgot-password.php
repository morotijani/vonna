<?php 

// USER forget password

    require_once ('../db_connection/conn.php');
    if (user_is_logged_in()) {
        redirect(PROOT . 'account/index');
    }
    include ('../inc/header.inc.php');

    $errors = '';
    if($_POST) {
        $email = sanitize($_POST['email']);
        //validation
        if(empty($email)) {
            $errors = '<div class="alert alert-light text-danger" role="alert">Email is required.</div>';
        }

        if(empty($errors)) {
            $sql = "
                SELECT * FROM vonna_user 
                WHERE user_email = :user_email 
                AND user_verified = :user_verified
                AND user_trash = :user_trash
            ";
            $statement = $conn->prepare($sql);
            $statement->execute([
                ':user_email' => $email, 
                ':user_trash' => 0, 
                ':user_verified' => 1
            ]);
            $user_result = $statement->fetchAll();

            if($statement->rowCount() > 0) {
                $code = rand(100001,999999);
                foreach ($user_result as $user_row) {
                    $email = $user_row['user_email'];
                    $user_id = $user_row['user_id'];
                    $time = date("Y-m-d H:i:s");
                }

                $name = ucwords($user_row["user_fullname"]);
                $to = $email;
                $subject = "Reset Your Password.";
                $body = "
                    <h3>{$name},</h3>
                    <p>Your verification code to reset your password is </p>
                    <p>{$code}</p>
                    <p>This code will expire in 10 minutes.</p>
                ";
                $mail_result = send_email($name, $to, $subject, $body);
                if ($mail_result) {
                    $query = "
                        INSERT INTO vonna_user_password_resets (password_reset_created_at, password_reset_user_id, password_reset_verify) 
                        VALUES (:password_reset_created_at, :password_reset_user_id, :password_reset_verify);
                    ";
                    $statement = $conn->prepare($query);
                    $result = $statement->execute(
                        array(
                            ':password_reset_created_at'    => $time,
                            ':password_reset_user_id'   => $user_id,
                            ':password_reset_verify'    => $code
                        )
                    ); 
                    if (isset($result)) {
                       // code...
                       $_SESSION['password_reset_user_id'] = $user_id;
                        redirect(PROOT . 'auth/reset-verify');
                    }   
                } else {
                    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    $errors = '<div class="alert alert-light text-danger" role="alert">Something went wrong... try agian.</div>';
                }
            } else {
                $errors = '<div class="alert alert-light text-danger" role="alert">Can not find user account.</div>';
            }
        }
    }



?>

    <main class="">
        <div class="container-lg d-flex flex-column">
            <div class="row align-items-center justify-content-center min-vh-100 py-12 mt-n1">
                <div class="col-12 col-md-7 col-lg-5 text-center">
                    <h1 class="display-3 mb-4">
                        Reset Your Password
                    </h1>
                    <p class="text-muted">
                        Enter your email to reset your password.
                    </p>
                    <form class="mb-6" method="POST">
                        <?= $errors; ?>
                        <div class="form-group">
                            <label class="visually-hidden" for="email">
                                Your email
                            </label>
                            <input class="form-control" id="email" name="email" type="email" placeholder="Your email">
                        </div>
                        <button class="btn w-100 btn-primary mb-2">
                            Recover Password
                        </button>
                        <a href="<?= PROOT; ?>auth/signin" class="">Cancel</a>
                    </form>
                    <small class="text-muted">
                        Remember your password? <a href="<?= PROOT; ?>auth/signin">Log in</a>.
                    </small>
                </div>
            </div>
        </div>
    </main>


    <!-- JAVASCRIPT -->
    <script src="<?= PROOT; ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>
    <script src="<?= PROOT; ?>assets/js/vendor.bundle.js"></script>
    <script src="<?= PROOT; ?>assets/js/theme.bundle.js"></script>

</body>
</html>