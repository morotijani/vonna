<?php 

    require_once ("../db_connection/conn.php");

    if (!admin_is_logged_in()) {
        admin_login_redirect();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADMIN . VONNA</title>
    <link rel="stylesheet" href="<?= PROOT; ?>assets/css/bootstrap.min.css">
</head>
<body>
    <?= $flash; ?>

	<div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php include ('INC/Sidebar.INC.php'); ?>
            </div>
            <div class="col-md-9">

                <nav class="navbar bg-body-tertiary">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">
                            <img src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Bootstrap" width="30" height="24">
                        </a>
                        <div class="d-flex" role="search">
                          <h4>Profile details</h4>
                        </div>
                    </div>
                </nav>

                <div class="row justify-content-center mt-4">
        	        <div class="col-md-6">
        		        <div class="card">
        		        	<div class="card-body">
        		        		<?= get_admin_profile(); ?>
        		        	</div>
        		        </div>
        	        </div>
                </div>

            </div>
        </div>
    </div>

    <script src="<?= PROOT; ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= PROOT; ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= PROOT; ?>assets/js/feather.min.js"></script>

    <script>
        feather.replace()

        function goBack() {
            window.history.back();
        }
    </script>

</body>
</html>
