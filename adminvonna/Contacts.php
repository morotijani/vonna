<?php 
    // INDEX PAGE
    // 
    require_once ('./../db_connection/conn.php');
    if (!admin_is_logged_in()) {
        admin_login_redirect();
    }

    // Get all orders
	$sql = "
		SELECT * FROM vonna_contact 
		ORDER BY contact_id DESC;
	";
	$statement = $conn->prepare($sql);
	$statement->execute();
	$contact_count = $statement->rowCount();
	$contacts = $statement->fetchAll();


	// Delete Customer
	if (isset($_GET['delete']) && !empty($_GET['delete'])) {
		$id = sanitize((int)$_GET['delete']);
		
		$sql = "
			SELECT * FROM vonna_contact 
			WHERE contact_id = ? 
			LIMIT 1
		";
		$statement = $conn->prepare($sql);
		$statement->execute([$id]);
		if ($statement->rowCount() > 0) {
			$delete = "
				DELETE FROM vonna_contact 
				WHERE contact_id = ? 
			";
			$statement = $conn->prepare($delete);
			$result = $statement->execute([$id]);
			if ($result) {
				$_SESSION['flash_success'] = 'Message deleted!';
				redirect(PROOT . 'adminvonna/Contacts');
				
			}
		} else {
			$_SESSION['flash_error'] = 'Message not found!';
			redirect(PROOT . 'adminvonna/Contacts');
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
					      	<img src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Bootstrap" width="30" height="24">
					    </a>
					    <div class="d-flex" role="search">
					      <h4>Contacts</h4>
					    </div>
					</div>
				</nav>
				<?php 
					if (isset($_GET['update']) && !empty($_GET['update'])):
						$errors = '';
				        $country = ((isset($_POST['country']))?sanitize($_POST["country"]):'');
				        $state = ((isset($_POST['state']))?sanitize($_POST["state"]):'');
				        $city = ((isset($_POST['city']))?sanitize($_POST["city"]):'');
				        $email = ((isset($_POST['email']))?sanitize($_POST["email"]):'');
				        $phone_1 = ((isset($_POST['phone_1']))?sanitize($_POST["phone_1"]):'');
				        $phone_2 = ((isset($_POST['phone_2']))?sanitize($_POST["phone_2"]):'');
				        $fax = ((isset($_POST['fax']))?sanitize($_POST["fax"]):'');
				        $street_1 = ((isset($_POST['street_1']))?sanitize($_POST["street_1"]):'');
				        $street_2 = ((isset($_POST['street_2']))?sanitize($_POST["street_2"]):'');
				        $facebook = ((isset($_POST['facebook']))?sanitize($_POST["facebook"]):'');
				        $twitter = ((isset($_POST['twitter']))?sanitize($_POST["twitter"]):'');
				        $instagram = ((isset($_POST['instagram']))?sanitize($_POST["instagram"]):'');



				        $query = "
				            SELECT * FROM vonna_about
				        ";
				        $statement = $conn->prepare($query);
				        $statement->execute();
				        $result = $statement->fetchAll();

				        foreach ($result as $row) {
				            $country = ((isset($_POST['country']))?sanitize($_POST["country"]):$row["about_country"]);
				            $state = ((isset($_POST['state']))?sanitize($_POST["state"]):$row["about_state"]);
				            $city = ((isset($_POST['city']))?sanitize($_POST["city"]):$row["about_city"]);
				            $email = ((isset($_POST['email']))?sanitize($_POST["email"]):$row["about_email"]);
				            $phone_1 = ((isset($_POST['phone_1']))?sanitize($_POST["phone_1"]):$row["about_phone"]);
				            $phone_2 = ((isset($_POST['phone_2']))?sanitize($_POST["phone_2"]):$row["about_phone2"]);
				            $fax = ((isset($_POST['fax']))?sanitize($_POST["fax"]):$row["about_fax"]);
				            $street_1 = ((isset($_POST['street_1']))?sanitize($_POST["street_1"]):$row["about_street1"]);
				            $street_2 = ((isset($_POST['street_2']))?sanitize($_POST["street_2"]):$row["about_street2"]);
				            $facebook = ((isset($_POST['facebook']))?sanitize($_POST["facebook"]):$row["about_facebook"]);
				            $twitter = ((isset($_POST['twitter']))?sanitize($_POST["twitter"]):$row["about_twitter"]);
				            $instagram = ((isset($_POST['instagram']))?sanitize($_POST["instagram"]):$row["about_instagram"]);
				        }

				       
				        if ($_POST) {
				            $post = array(
				                'country'           => 'Country',
				                'state'             => 'State',
				                'city'              => 'City',
				                'email'             => 'Email',
				                'phone_1'           => 'Phone_1',
				                'fax'               => 'Fax',
				                'street_1'          => 'Street_1',
				            );
				            foreach ($post as $k => $v) {
				                if (empty($_POST[$k])) {
				                    $errors = '<span class="bg-info">'.$v.'</span> is required.';
				                } else {
				                    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				                        $errors = 'Please enter a valid email address.';
				                    }
				                }
				            }

				            if (empty($errors)) {
				                $data = array(
				                    ':about_street1'            => $street_1,
				                    ':about_street2'            => $street_2,
				                    ':about_country'            => $country,
				                    ':about_state'              => $state,
				                    ':about_city'               => $city,
				                    ':about_phone'              => $phone_1,
				                    ':about_email'              => $email,
				                    ':about_phone2'             => $phone_2,
				                    ':about_fax'                => $fax,
				                    ':about_facebook'           => $facebook,
				                    ':about_twitter'            => $twitter,
				                    ':about_instagram'          => $instagram
				                );

				                $sql = "
				                    UPDATE vonna_about 
				                    SET about_street1 = :about_street1, about_street2 = :about_street2, about_country = :about_country, about_state = :about_state, about_city = :about_city, about_phone = :about_phone, about_email = :about_email, about_phone2 = :about_phone2, about_fax = :about_fax, about_facebook = :about_facebook, about_twitter = :about_twitter, about_instagram = :about_instagram
				                ";
				                $statement = $conn->prepare($sql);
				                $result = $statement->execute($data);
				                if (isset($result)) {
				                    $_SESSION['flash_success'] = 'Contact page successfully updated';
				                   redirect(PROOT . 'adminvonna/Contacts?update=1');
				                }
				            }
				        }
				?><br><br>
				<a href="<?= PROOT; ?>adminvonna/Contacts" class="badge bg-dark text-decoration-none" style="float: right;"><i data-feather="arrow-left"></i> go back</a>
				<h2>Update</h2>
				<form method="POST" action="contacts.php?update=1" id="updateForm">
		            <p class="bg-danger text-white text-center"><?= $errors; ?></p>
		            <div class="row">
		                <div class="col-md-4 mb-2">
		                    <div class="form-group">
		                        <label for="country">Country</label>
		                        <input type="text" name="country" id="country" class="form-control form-control-sm" value="<?= $country; ?>">
		                        <div class="form-text">Enter country name in this field.</div>
		                    </div>
		                </div>
		                <div class="col-md-4">
		                    <div class="form-group">
		                        <label for="state">State</label>
		                        <input type="text" name="state" id="state" class="form-control form-control-sm" value="<?= $state; ?>">
		                        <div class="form-text">Enter state name in this field.</div>
		                    </div>
		                </div>
		                <div class="col-md-4">
		                    <div class="form-group">
		                        <label for="city">City</label>
		                        <input type="text" name="city" id="city" class="form-control form-control-sm" value="<?= $city; ?>">
		                        <div class="form-text">Enter city name in this field.</div>
		                    </div>
		                </div>
		                <div class="col-md-3 mb-2">
		                    <div class="form-group">
		                        <label for="email">Email</label>
		                        <input type="email" name="email" id="email" class="form-control form-control-sm" value="<?= $email; ?>">
		                        <div class="form-text">Enter email name in this field.</div>
		                    </div>
		                </div>
		                <div class="col-md-3">
		                    <div class="form-group">
		                        <label for="phone_1">Phone 1</label>
		                        <input type="text" name="phone_1" id="phone_1" class="form-control form-control-sm" value="<?= $phone_1; ?>">
		                        <div class="form-text">Enter phone 1 name in this field.</div>
		                    </div>
		                </div>
		                <div class="col-md-3">
		                    <div class="form-group">
		                        <label for="phone_2">Phone 2 (Optional)</label>
		                        <input type="text" name="phone_2" id="phone_2" class="form-control form-control-sm" value="<?= $phone_2; ?>">
		                        <div class="form-text">Enter phone 2 name in this field.</div>
		                    </div>
		                </div>
		                <div class="col-md-3">
		                    <div class="form-group">
		                        <label for="fax">Fax</label>
		                        <input type="text" name="fax" id="fax" class="form-control form-control-sm" value="<?= $fax; ?>">
		                        <div class="form-text">Enter fax name in this field.</div>
		                    </div>
		                </div>
		                <div class="col-md-6">
		                    <div class="form-group">
		                        <label for="street_1">Address 1 (Street)</label>
		                        <input type="text" name="street_1" id="street_1" class="form-control" value="<?= $street_1; ?>">
		                        <div class="form-text">Enter street address in this field.</div>
		                    </div>
		                </div>
		                <div class="col-md-6">
		                    <div class="form-group">
		                        <label for="street_2">Address 2 (Optional)</label>
		                        <input type="text" name="street_2" id="street_2" class="form-control" value="<?= $street_2; ?>">
		                        <div class="form-text">Enter street address 2 in this field.</div>
		                    </div>
		                </div>

		                 <div class="col-md-4 mb-2">
		                    <div class="form-group">
		                        <label for="facebook">Facebook</label>
		                        <input type="url" name="facebook" id="facebook" class="form-control form-control-sm" value="<?= $facebook; ?>">
		                        <div class="form-text">Enter instagram url.</div>
		                    </div>
		                </div>
		                <div class="col-md-4">
		                    <div class="form-group">
		                        <label for="twitter">Twitter</label>
		                        <input type="url" name="twitter" id="twitter" class="form-control form-control-sm" value="<?= $twitter; ?>">
		                        <div class="form-text">Enter twitter url.</div>
		                    </div>
		                </div>
		                <div class="col-md-4">
		                    <div class="form-group">
		                        <label for="instagram">Instagram</label>
		                        <input type="url" name="instagram" id="instagram" class="form-control form-control-sm" value="<?= $instagram; ?>">
		                        <div class="form-text">Enter instagram url.</div>
		                    </div>
		                </div>
		            </div>
		            <div class="form-group mt-3">
		                <button type="submit" name="update_contact" id="update_contact" class="btn btn-dark btn-sm">Update</button>
		            </div>
		        </form>
				<?php else: ?>
				<br><br>
				<a href="<?= PROOT; ?>adminvonna/Contacts?update=1" class="badge bg-dark text-decoration-none" style="float: right;"><i data-feather="phone"></i> Update Contact us details</a>
				<div class="table-responsive mt-5">
					<table class="table table-hover">
					  	<thead>
						    <tr>
						      	<th scope="col"></th>
						      	<th scope="col">Name</th>
						      	<th scope="col">Email</th>
						      	<th scope="col">Message</th>
						      	<th scope="col">Date</th>
						      	<th scope="col"></th>
					    	</tr>
					  	</thead>
					  	<tbody>
					  		<?php if ($contact_count > 0): ?>
					  			<?php $i = 1; foreach ($contacts as $contact): ?>
						  			<tr scope="row">
						  				<td><?= $i; ?></td>
						  				<td><?= ucwords($contact['contact_name']); ?></td>
						  				<td><?= $contact['contact_email']; ?></td>
						  				<td><?= nl2br($contact['contact_message']); ?></td>
						  				<td><?= pretty_date($contact['contact_date']); ?></td>
						  				<td>
						  					<a href="javascript:;"  onclick="(confirm('Message will be deleted!') ? window.location = '<?= PROOT; ?>adminvonna/Contacts/<?= $contact['contact_id']; ?>' : '');" class="btn btn-warning">Delete</a>						  						
						  				</td>
						  			</tr>

					  			<?php $i++; endforeach; ?>
					  		<?php else: ?>
					  			<tr>
					  				<td colspan="6">No contacts.</td>
					  			</tr>
					  		<?php endif; ?>
					  	</tbody>
					</table>
				</div>
				<?php endif ?>
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