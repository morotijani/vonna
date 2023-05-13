<?php 

// RESET VERIFY EMAIL PAGE
require_once ('../db_connection/conn.php');
if (user_is_logged_in()) {
    redirect(PROOT . 'account/index');
}
include ('../inc/header.inc.php');

$userId = issetElse($_SESSION, 'password_reset_user_id', 0);
if ($userId != 0 && !empty($userId)) {
    	// code...
	$errors = '';
  	if ($_POST) {
    	$code = sanitize($_POST['code']);
    	$now = date("Y-m-d H:i:s");
    	$userId = issetElse($_SESSION, 'password_reset_user_id', 0);
		// validation
		if(empty($code)) {
		  	$errors = '<div class="alert alert-light text-danger" role="alert">Please enter your 6 digit code.</div>';
		}

	    if(empty($errors)) {
	      	$sql = "
	      		SELECT * FROM vonna_user_password_resets 
	      		WHERE password_reset_verify = :password_reset_verify 
	      		AND password_reset_user_id = :password_reset_user_id 
	      		ORDER BY password_reset_id DESC LIMIT 1
	      	";
	      	$statement = $conn->prepare($sql);
	      	$statement->execute([
	      		':password_reset_verify' => $code,
	      		':password_reset_user_id' => $userId
	      	]);
	      	$result = $statement->fetchAll();
	      	foreach ($result as $reset) {
	      		# code...
	      	}
	      	if (!$result) {
	        	$errors = '<div class="alert alert-light text-danger" role="alert">The code you entered is incorrect or has expired.</div>';
	      	} else {
	        	$expireTime = date("Y-m-d H:i:s", strtotime($reset['password_reset_created_at'] . " +10 minutes"));
	        	$expired = strtotime($now) > strtotime($expireTime); 
	  
	        	if ($expired) {
	          		$errors = '<div class="alert alert-light text-danger" role="alert">Your code has expired. Please try again.</div>';
	        	} else {
		          	$_SESSION['password_reset_code_verified'] = $code;
		          	redirect(PROOT . 'auth/reset-password');
		        }
	    	}

		}
	}


?>

    <main class="">
        <div class="container-lg d-flex flex-column">
            <div class="row align-items-center justify-content-center min-vh-100 py-12 mt-n1">
                <div class="col-12 col-md-7 col-lg-5 text-center">
                    <h1 class="display-3 mb-4">
                        Please Enter Your 6 digit code
                    </h1>
                    <p class="text-muted">
                        A 6 digit code has been sent to your email address.
                    </p>
                    <form class="mb-6" method="POST">
                        <?= $errors; ?>
                        <div class="form-group">
                            <label class="visually-hidden" for="email">
                                Your email
                            </label>
                            <input class="form-control" id="code" name="code" type="text" placeholder="Verify">
                        </div>
                        <button class="btn w-100 btn-warning mb-2">
                            Verify
                        </button>
                        <a href="<?= PROOT; ?>auth/signin" class="">Cancel</a>
                    </form>
                    <small class="text-muted">
                        Resend Code? <a href="<?= PROOT; ?>auth/forgot-password">Try Again</a>.
                    </small>
                </div>
            </div>
        </div>
    </main>
<?php 
	} else {
		redirect(PROOT . 'auth/forgot-password');
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