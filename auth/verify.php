<?php 

// VERIFY

require_once ('../db_connection/conn.php');
include ('../inc/header.inc.php');

if (user_is_logged_in()) {
    redirect(PROOT . 'account/index');
}

?>
    <!-- BODY -->
    <main class="">
        <div class="container-lg d-flex flex-column">
            <div class="row align-items-center justify-content-center min-vh-100 py-10 py-md-12 mt-n1">
                <div class="col-12 col-md-7 col-lg-5 text-center">
                    <h6 class="text-uppercase text-warning mb-5">
                        Vonna
                    </h6>
                    <h1 class="display-3 mb-4">
                        Verify your email.
                    </h1>
                    <p class="text-muted">
                        A verification link has been sent to your email account. Please check your <b>spam folder</b> if not found in your <b>inbox</b> to verify your Vonna account.
                    </p>
                    <a class="btn btn-primary" href="<?= PROOT . 'auth/signin'; ?>">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- JAVASCRIPT -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>
    <script src="<?= PROOT; ?>assets/js/vendor.bundle.js"></script>
    <script src="<?= PROOT; ?>assets/js/theme.bundle.js"></script>

</body>
</html>

