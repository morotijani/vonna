<?php 
    // INDEX PAGE
    // 
    require_once ('./../db_connection/conn.php');
    if (!admin_is_logged_in()) {
        admin_login_redirect();
    }


    // Get all customer
	$sql = "
		SELECT * FROM vonna_user 
		ORDER BY user_fullname ASC
	";
	$statement = $conn->prepare($sql);
	$statement->execute();
	$user_count = $statement->rowCount();
	$users = $statement->fetchAll();

	// DEACTIVATE OR ACTIVATE CUSTOMER
	if (isset($_GET['status'])) {
		if ($_GET['id'] != '') {
			$id = sanitize((int)$_GET['id']);
			$status = ($_GET['status'] == 0) ? 0 : $_GET['status'];

			$sql = "
				UPDATE vonna_user 
				SET user_trash = ? 
				WHERE user_id = ? 
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);
			if (isset($result)) {
				$_SESSION['flash_success'] = 'Customer ' . (($status == 1) ? 'Deactivated' : 'Activated') . '!';
				redirect(PROOT . 'adminvonna/Customers');
			} else {
				echo js_alert('Something went wrong, please try again');
			}
		} else {
			$_SESSION['flash_error'] = 'Customer not found!';
			redirect(PROOT . 'adminvonna/Customers');
		}
	}
	

	// Delete Customer
	if (isset($_GET['delete']) && !empty($_GET['delete'])) {
		$id = sanitize((int)$_GET['delete']);
		
		$sql = "
			SELECT * FROM vonna_user 
			WHERE user_id = ? 
			LIMIT 1
		";
		$statement = $conn->prepare($sql);
		$statement->execute([$id]);
		$result = $statement->fetchAll();
		if ($statement->rowCount() > 0) {
			$delete = "
				DELETE FROM vonna_orders 
				WHERE orders_userid = ? 
			";
			$statement = $conn->prepare($delete);
			$sub_result = $statement->execute([$id]);
			if ($sub_result) {
				$deleteQ = "
					DELETE FROM vonna_user 
					WHERE user_id = ? 
				";
				$statement = $conn->prepare($deleteQ);
				$row = $statement->execute([$id]);

				if (isset($row)) {
					$_SESSION['flash_success'] = 'Customer deleted!';
					redirect(PROOT . 'adminvonna/Customers');
				} else {
					echo js_alert('Something Went wrong please try agian');
				}
			}
		} else {
			$_SESSION['flash_error'] = 'Customer not found!';
			redirect(PROOT . 'adminvonna/Customers');
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
					      <h4>Customers</h4>
					    </div>
					</div>
				</nav>

				<div class="table-responsive mt-5">
					<table class="table table-hover">
					  	<thead>
						    <tr>
						      	<th scope="col"></th>
						      	<th scope="col"></th>
						      	<th scope="col">Name</th>
						      	<th scope="col">Email</th>
						      	<th scope="col">Phone</th>
						      	<th scope="col">Date</th>
						      	<th scope="col"></th>
					    	</tr>
					  	</thead>
					  	<tbody>
					  		<?php if ($user_count > 0): ?>
					  			<?php $i = 1; foreach ($users as $user): ?>
						  			<tr scope="row" class="table-<?= ($user['user_trash'] == 0) ? '' : 'danger'; ?>">
						  				<td><?= $i; ?></td>
						  				<td>
						  					<span class="badge bg-<?= ($user['user_verified'] == 1) ? 'success' : 'danger'; ?> h6 text-uppercase"><?= ($user['user_verified'] == 1) ? '' : 'Not'; ?> Verified</span>
						  				</td>
						  				<td><?= ucwords($user['user_fullname']); ?></td>
						  				<td><?= $user['user_email']; ?></td>
						  				<td><?= $user['user_phone']; ?></td>
						  				<td><?= pretty_date($user['user_joined_date']); ?></td>
						  				<td>
						  					<a href="javascript:;"  data-bs-toggle="modal" data-bs-target="#userDetailsModal<?= $user['user_id']; ?>" class="btn btn-warning">Details</a>
						  				</td>
						  			</tr>

						  			<div class="modal fade" id="userDetailsModal<?= $user['user_id']; ?>" tabindex="-1" aria-labelledby="userDetailsModalLabel<?= $user['user_id']; ?>" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
										<div class="modal-dialog modal-dialog-centered">
										    <div class="modal-content">
										      	<div class="modal-header">
										        	<h1 class="modal-title fs-5" id="userDetailsModalLabel<?= $user['user_id']; ?>">Details</h1>
										        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										      	</div>
												<div class="modal-body">
													<ul class="list-group">
							                            <li class="list-group-item">Full name: <?= ucwords($user['user_fullname']); ?></li>
							                            <li class="list-group-item">Email: <?= $user['user_email']; ?></li>
							                            <li class="list-group-item">Phone: <?= $user['user_phone']; ?></li>
							                            <li class="list-group-item">Occupation: <?= $user['user_occupation']; ?></li>
							                            <li class="list-group-item">Name of Institution: <?= $user['user_name_of_instituition']; ?></li>
							                            <li class="list-group-item">Size of Institution: <?= $user['user_size_of_instituition']; ?></li>
							                            <li class="list-group-item">Country: <?= ucwords($user['user_country']); ?></li>
							                            <li class="list-group-item">State/Region: <?= ucwords($user['user_state']); ?></li>
							                            <li class="list-group-item">City: <?= ucwords($user['user_city']); ?></li>
							                            <li class="list-group-item">Postal Address: <?= $user['user_postal_address']; ?></li>
							                            <li class="list-group-item">Physical Address: <?= $user['user_physical_address']; ?></li>
							                            <li class="list-group-item">Joined Date: <?= pretty_date($user['user_joined_date']); ?></li>
							                        </ul>
										      	</div>
										      	<div class="modal-footer">
										        	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										        	<a href="javascript:;" class="btn btn-warning" onclick="(confirm('Customer will be <?= ($user['user_trash'] == 0) ? 'Deactivated' : 'Activated'; ?>!') ? window.location = '<?= PROOT; ?>adminvonna/Customers?status=<?= ($user['user_trash'] == 0) ? '1' : '0'; ?>&id=<?= $user['user_id']; ?>' : '');"><?= ($user['user_trash'] == 0) ? 'Deactivate' : 'Activate'; ?></a>
										        	<a href="javascript:;" class="btn btn-danger" onclick="(confirm('Customer will be deleted and any of his/her orders!') ? window.location = '<?= PROOT; ?>adminvonna/Customers?delete=<?= $user['user_id']; ?>' : '');">Delete</a>
										      	</div>
										    </div>
										 </div>
									</div>
					  			<?php $i++; endforeach; ?>
					  		<?php else: ?>
					  			<tr>
					  				<td colspan="6">No customers.</td>
					  			</tr>
					  		<?php endif; ?>
					  	</tbody>
					</table>
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