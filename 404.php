<?php 
    // 404 PAGE

    require_once ('db_connection/conn.php');

    include ('inc/header.inc.php');

?>

    <!-- BODY -->
    <main class="">
        <div class="container-lg d-flex flex-column">
            <div class="row align-items-center justify-content-center min-vh-100 py-10 py-md-12 mt-n1">
                <div class="col-12 col-md-7 col-lg-5 text-center">
                    <h6 class="text-uppercase text-warning mb-5">
                        404
                    </h6>
                    <h1 class="display-3 mb-4">
                        Uh oh.
                    </h1>
                    <p class="text-muted">
                        There’s nothing here, but if you feel this is an error please <a href="<?= PROOT; ?>contact">let us know</a>.
                    </p>
                    <a class="btn btn-primary" href="javascript:;" onclick="goBack()">
                        Go back
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- JAVASCRIPT -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>
    <script src="<?= PROOT; ?>assets/js/vendor.bundle.js"></script>
    <script src="<?= PROOT; ?>assets/js/theme.bundle.js"></script>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>

</body>
</html>
