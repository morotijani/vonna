<?php 

	// RESEND VERIFY EMAIL PAGE

	require_once ('../db_connection/conn.php');
	if (user_is_logged_in()) {
	    redirect(PROOT . 'account/index');
	}
    include ('../inc/header.inc.php');

	$errors = '';
	if($_POST) {
	    $email = sanitize($_POST['authEmail']);
	    //validation
	    if(empty($email)) {
	      	$errors = '<div class="alert alert-light text-danger" role="alert">Email is required.</div>';
	    }

	    if(empty($errors)) {
	      	$user = findUserByEmail($email);
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
	      		':user_verified' => 0
	      	]);

	      	if($statement->rowCount() > 0) {
	      		$vericode = md5(time());

	      		foreach ($statement->fetchAll() as $sub_row) {
	      			// code...
	      		}
	      		$name = ucwords($sub_row['user_fullname']);
	      		$to = $sub_row['user_email'];
	         	$subject = "Please Verify Your Account.";
				$body = "
					<h3>
						{$name},</h3>
						<p>
							Thank you for registering. Please verify your account by clicking 
	          				<a href=\"https://sites.local/vonna/auth/verified/{$vericode}\" target=\"_blank\">here</a>.
	        		</p>
				";
				$mail_result = send_email($name, $to, $subject, $body);
				if ($mail_result) {
			      	$sql = "
			      		UPDATE vonna_user 
			      		SET user_vericode = :user_vericode 
			      		WHERE user_email = :user_email
			      	";
			      	$statement = $conn->prepare($sql);
			      	$result = $statement->execute([
			      		':user_vericode' => $vericode,
			      		':user_email' => $email
			      	]);
			      	echo js_alert("Check your email for reverification link");
			      	redirect(PROOT . 'auth/signin');
				} else {
				    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				   	$errors = '<div class="alert alert-light text-danger" role="alert">Message could not be sent... check your internet or try again later.</div>';

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
	              		Resend Verification Email
	            	</h1>
	            	<p class="text-muted">
	              		You must verify your account before logging in. Please check your inbox and spam folders. If you did not receive the verification email you may request a new verification email below.
	            	</p>
	            	<form class="mb-6" method="POST">
	            		<?= $errors; ?>
	              		<div class="form-group">
	                		<label class="visually-hidden" for="authEmail">
			                 	Your email
			                </label>
			                <input class="form-control" id="authEmail" name="authEmail" type="email" placeholder="Your email">
			            </div>
			            <button class="btn w-100 btn-warning mb-2"type="submit">
			                Resend Verification Email
			            </button>
			            <a href="<?= PROOT; ?>store/login" class="">Cancel</a>
	            	</form>
	            	<small class="text-muted">
	              		Remember your password? <a href="sign-in.html">Log in</a>.
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