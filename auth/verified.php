<?php 

// USER VERIFY

    require_once ('../db_connection/conn.php');
    include ('../inc/header.inc.php');

    if (user_is_logged_in()) {
        redirect(PROOT . 'account/index');
    }


    if (isset($_GET['vericode'])) {

        $vericode = sanitize($_GET['vericode']);
        $success = false;
        $msg = "Something has gone wrong or your account is already verified.";
        if($vericode) {
            $sql = "
                SELECT * FROM vonna_user 
                WHERE user_verified = 0 
                AND user_vericode = :user_vericode
            ";
            $statement = $conn->prepare($sql);
            $statement->execute([':user_vericode' => $vericode]);
            $result = $statement->fetchAll();
            foreach ($result as $user) {
                $sql = "
                    UPDATE vonna_user 
                    SET user_verified = 1 
                    WHERE user_id = :user_id";
                $statement = $conn->prepare($sql);
                $success = $statement->execute([':user_id' => $user["user_id"]]);

                if($success) {
                    $msg = "Your account has been verified! Please log in.";
                }
            }

        }
        
    } else {
        redirect(PROOT . 'index');
    }


?>

    <main class="">
        <div class="container-lg d-flex flex-column">
            <div class="row align-items-center justify-content-center min-vh-100 py-10 py-md-12 mt-n1">
                <div class="col-12 col-md-7 col-lg-5 text-center">
                    <h6 class="text-uppercase text-warning mb-5">
                        Vonna
                    </h6>
                    <h1 class="display-3 mb-4">
                        Email verification.
                    </h1>
                    <p class="text-muted">
                       <?= $msg; ?>
                    </p>
                    <a class="btn btn-warning" href="<?= PROOT . 'auth/signin'; ?>">
                        Login
                    </a>
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