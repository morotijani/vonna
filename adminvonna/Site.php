<?php 
    // INDEX PAGE
    // 
    require_once ('./../db_connection/conn.php');
    if (!admin_is_logged_in()) {
        admin_login_redirect();
    }



    $about_ = ((isset($_POST['about_info'])) ? sanitize($_POST['about_info']) : $about_info);
   

    if (isset($_POST['submit_form'])) {
        $about_ = $_POST['about_info'];

        if (empty($about_) || $about_ == '') {
            echo js_alert("Empty field required.");
        } else {
            $updateQ = "
                UPDATE vonna_about
                SET about_info = :about_info
            ";
            $statement = $conn->prepare($updateQ);
            $update_result = $statement->execute([
                ':about_info'   => $about_
            ]);

            if (isset($result)) {
                $_SESSION['flash_success'] = 'About us page has been successfully <span class="bg-info">UPDATED</span>';
               echo '<script>window.location = "'.PROOT.'admin/Site";</script>';
            }
        }

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
					      	VONNA.GH
					    </a>
					    <div class="d-flex" role="search">
					      <h4>About us page, Update.</h4>
					    </div>
					</div>
				</nav>

				<form method="POST">
		            <div class="form-group mb-2">
		                <label>Update about us.</label>
		                <textarea class="form-control" rows="15" name="about_info" id="about_info">
		                    <?= $about_info; ?>
		                </textarea>
		                <div class="form-text">After, it will update itself on the user page. click <a href="<?= PROOT; ?>about" target="blank">here...</a> to see changes</div>
		            </div>
		            <div class="form-group">
		                <button class="btn btn-info" type="submit" name="submit_form" id="submit_form">Update.</button>
		            </div>
		        </form>
			</div>
		</div>
	</div>

    <script src="<?= PROOT; ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= PROOT; ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= PROOT; ?>assets/js/feather.min.js"></script>
    <!-- <script type="text/javascript" src="<?= PROOT; ?>assets/js/tinymce.min.js"></script> -->
    <script src="https://cdn.tiny.cloud/1/87lq0a69wq228bimapgxuc63s4akao59p3y5jhz37x50zpjk/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
      	feather.replace()

        function goBack() {
            window.history.back();
        }
   
	    // Testarea Editor
	    tinymce.init({
	        selector: '#about_info'
	    });
	</script>

</body>
</html>