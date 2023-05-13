<?php
    require_once ('../db_connection/conn.php');
    include ('../inc/header.inc.php');

    $output = '';
    $post = (isset($_POST['submit_signup']) ? cleanPost($_POST): '');
    $fullname = (isset($_POST['authFullname']) && !empty($post['authFullname']) ? sanitize($post['authFullname']) : '');
    $email = (isset($_POST['authEmail']) && !empty($post['authEmail']) ? sanitize($post['authEmail']) : '');
    $phone = (isset($_POST['authPhone']) && !empty($post['authPhone']) ? sanitize($post['authPhone']) : '');
    $password = (isset($_POST['authPassword']) && !empty($post['authPassword']) ? sanitize($post['authPassword']) : '');
    if (isset($_POST['submit_signup'])) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "SELECT * FROM vonna_user WHERE user_email = :user_email";
        $statement = $conn->prepare($sql);
        $statement->execute([':user_email' => $email]);

        if ($statement->rowCount() > 0) {
            $output =  '<div class="alert alert-light text-danger" role="alert">User account already exist.<div>';
        } else {
            $vericode = md5(time());

            $fn = ucwords($fullname);
            $to = $email;
            $subject = "Please Verify Your Account.";
            $body = "
                <h3>
                    {$fn},</h3>
                    <p>
                        Thank you for registering. Please verify your account by clicking 
                        <a href=\"https://sites.local/vonna/auth/verified/{$vericode}\" target=\"_blank\">here</a>.
                </p>
            ";

            $mail_result = send_email($fn, $to, $subject, $body);
            if ($mail_result) {

                $data = [
                    ':user_fullname'        => $fullname,
                    ':user_email'           => $email,
                    ':user_phone'           => $phone,
                    ':user_password'        => $password_hash
                ];
                $query = "
                    INSERT INTO vonna_user (user_fullname, user_email, user_phone, user_password) 
                    VALUES (:user_fullname, :user_email, :user_phone, :user_password); 
                ";
                $statement = $conn->prepare($query);
                $result = $statement->execute($data);
                $user_id = $conn->lastInsertId();

                if (isset($result)) {
                    $sql = "
                        UPDATE vonna_user 
                        SET user_vericode = :user_vericode 
                        WHERE user_id = :user_id
                    ";
                    $statement = $conn->prepare($sql);
                    $sub_result = $statement->execute([
                        ':user_vericode' => $vericode,
                        ':user_id' => $user_id
                    ]);
                    if ($sub_result) {
                        // code...
                        redirect(PROOT . 'auth/verify');
                    }
                }
            } else {
                //$output =  "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                $output =  '<div class="alert alert-light text-danger" role="alert">Message could not be sent, please tyr again</div>';
            }
        }
        echo $output;
    }

?>

    <main>
        <div class="container-lg d-flex flex-column">
            <div class="row align-items-center justify-content-center min-vh-100 py-10 py-md-12 mt-n1">
                <div class="col-12 col-md-7 col-lg-5 text-center">
                    <h1 class="display-3 mb-4">
                        Sign Up
                    </h1>
                    <p class="text-muted">
                        Register to start making orders.
                    </p>
                    <?= $output; ?>
                    <form class="mb-6" method="POST">
                        <div class="form-group">
                            <label class="visually-hidden" for="authFullname">
                                Your Full name
                            </label>
                            <input class="form-control" id="authFullname" name="authFullname" type="text" placeholder="Your Full name" value="<?= $fullname; ?>" autofocus>
                        </div>
                        <div class="form-group">
                            <label class="visually-hidden" for="authEmail">
                                Your email
                            </label>
                            <input class="form-control" id="authEmail" name="authEmail" type="email" placeholder="Your email" value="<?= $email; ?>" autocomplete>
                        </div>
                        <div class="form-group">
                            <label class="visually-hidden" for="authPhone">
                                Your phone
                            </label>
                            <input class="form-control" id="authPhone" name="authPhone" type="number" min="10" placeholder="Your phone" value="<?= $phone; ?>">
                        </div>
                        <div class="form-group">
                            <div class="input-group inpit-group-merge">
                                <input class="form-control" id="authPassword" name="authPassword" placeholder="Your password" type="password" aria-label="Your password" aria-describedby="authPasswordCaption">
                                <a class="input-group-text text-decoration-none text-gray-500" id="authPasswordCaption" data-toggle="password" href="#authPassword">
                                    <i class="fe fe-eye"></i>
                                </a>
                            </div>
                        </div>
                        <button type="submit" class="btn w-100 btn-primary" name="submit_signup" id="submit_signup">
                            Sign up
                        </button>
                    </form>
                    <small class="text-muted">
                        Already have an account? <a href="<?= PROOT; ?>auth/signin">Login</a>
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

    <script>
        // Fade out messages
        $("#temporary").fadeOut(5000);
    </script>

  </body>
</html>