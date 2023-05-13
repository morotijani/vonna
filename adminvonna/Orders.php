<?php 
    // INDEX PAGE
    // 
    require_once ('./../db_connection/conn.php');
    if (!admin_is_logged_in()) {
        admin_login_redirect();
    }



    // Get all orders
	$sql = "
		SELECT * FROM vonna_orders 
		INNER JOIN vonna_user 
		ON vonna_user.user_id = vonna_orders.orders_userid 
		-- WHERE vonna_orders.orders_userid = ?
		ORDER BY id DESC;
	";
	$statement = $conn->prepare($sql);
	$statement->execute();
	$order_count = $statement->rowCount();
	$orders = $statement->fetchAll();


	// check for ordered order
	if (isset($_GET['ordered']) && !empty($_GET['ordered'])) {
		// code...
		$status = sanitize((int)$_GET['ordered']);
		$id = sanitize($_GET['id']);
		if ($id != '') {
			// code...
			$sql = "
				UPDATE vonna_orders 
				SET orders_status = ? 
				WHERE orders_id = ?
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);

			if ($result) {
				// code...
				$_SESSION['flash_success'] = ($status == 1) ? 'Un-ordered' : 'Ordered';
				redirect(PROOT . 'adminvonna/Orders');
				//redirect(PROOT . 'adminvonna/Orders?details='.$id);
			} else {
				echo js_alert('Something went wrong... try again');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow order';
			redirect(PROOT . 'adminvonna/Orders?details='.$id);
		}
	}


	// check for paid order
	if (isset($_GET['paid']) && !empty($_GET['paid'])) {
		// code...
		$status = sanitize((int)$_GET['paid']);
		$id = sanitize($_GET['id']);
		if ($id != '') {
			// code...
			$sql = "
				UPDATE vonna_orders 
				SET orders_status = ? 
				WHERE orders_id = ?
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);

			if ($result) {
				// code...
				$_SESSION['flash_success'] = ($status == 1) ? 'Not Paid' : 'Paid, ready for order';
				redirect(PROOT . 'adminvonna/Orders');
				//redirect(PROOT . 'adminvonna/Orders?details='.$id);
			} else {
				echo js_alert('Something went wrong... try again');
				//redirect(PROOT . 'adminvonna/Orders?details='.$id);
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow order';
			redirect(PROOT . 'adminvonna/Orders?details='.$id);
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
					      <h4>Orders</h4>
					    </div>
					</div>
				</nav>

				<?php 
					if (isset($_GET['details']) && !empty($_GET['details'])): 
						$id = sanitize($_GET['details']);

						$query = "
							SELECT * FROM vonna_orders 
							INNER JOIN vonna_user 
							ON vonna_user.user_id = vonna_orders.orders_userid 
							WHERE vonna_orders.orders_id = ? 
							LIMIT 1
						";
						$statement = $conn->prepare($query);
						$statement->execute([$id]);
						$detail = $statement->fetchAll();
						if ($statement->rowCount() > 0) {
							$updateQ = "
								UPDATE vonna_orders 
								SET orders_status = ? 
								WHERE orders_id = ? 
							";
							$statement = $conn->prepare($updateQ);
							$statement->execute([1, $id]);
						?>
							<br><br>
							<a href="<?= PROOT; ?>adminvonna/Orders" class="badge bg-dark text-decoration-none" style="float: right;"><i data-feather="arrow-left"></i> Go back</a>
							<ol class="list-group mt-5">
								<li class="list-group-item d-flex justify-content-between align-items-center">
							      	<div class="fw-bold">Order ID</div>
								    <span class=""><?= $detail[0]['orders_id']; ?></span>
								 </li>
							  	<li class="list-group-item d-flex justify-content-between align-items-center">
						      		<div class="fw-bold">Product</div>
						      		<span><?= $detail[0]['orders_product']; ?></span>
							  	</li>
							  	<?php if ($detail[0]['orders_size'] != ''): ?>
								  	<li class="list-group-item d-flex justify-content-between align-items-center">
							      		<div class="fw-bold">Size</div>
							     		<span><?= $detail[0]['orders_size']; ?></span>
								  	</li>
							  	<?php endif; ?>
							  	<?php if ($detail[0]['orders_type'] != ''): ?>
							  	<li class="list-group-item d-flex justify-content-between align-items-center">
						      		<div class="fw-bold">Type</div>
						     		<span><?= $detail[0]['orders_type']; ?></span>
							  	</li>
							  	<?php endif; ?>
							  	<li class="list-group-item d-flex justify-content-between align-items-center">
						      		<div class="fw-bold">Quantity</div>
						     		<span><?= $detail[0]['orders_quantity']; ?></span>
							  	</li>
							  	<?php if ($detail[0]['orders_color'] != ''): ?>
							  	<li class="list-group-item d-flex justify-content-between align-items-center">
						      		<div class="fw-bold">Color</div>
						     		<span><?= $detail[0]['orders_color']; ?></span>
							  	</li>
							  	<?php endif; ?>
							  	 <button type="button" class="list-group-item list-group-item-action fw-bold text-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Customer: <?= ucwords($detail[0]['user_fullname']); ?></button>
							    	<div class="collapse" id="collapseExample">
									  	<div class="card card-body">
									    	<ul class="list-group">
												<li class="list-group-item d-flex justify-content-between align-items-center">
												    Email
												    <span class="badge bg-primary rounded-pill"><?= $detail[0]['user_email']; ?></span>
												</li>
												<li class="list-group-item d-flex justify-content-between align-items-center">
												    Phone
												    <span class="badge bg-primary rounded-pill"><?= $detail[0]['user_phone']; ?></span>
												</li>
												<li class="list-group-item d-flex justify-content-between align-items-center">
												    Occupation
												    <span class="badge bg-primary rounded-pill"><?= $detail[0]['user_occupation']; ?></span>
												</li>
												<li class="list-group-item d-flex justify-content-between align-items-center">
												    Name of instituition
												    <span class="badge bg-primary rounded-pill"><?= $detail[0]['user_name_of_instituition']; ?></span>
												</li>
												<li class="list-group-item d-flex justify-content-between align-items-center">
												    Postal Address
												    <span class="badge bg-primary rounded-pill"><?= $detail[0]['user_postal_address']; ?></span>
												</li>
												<li class="list-group-item d-flex justify-content-between align-items-center">
												    Pysical Address
												    <span class="badge bg-primary rounded-pill"><?= $detail[0]['user_physical_address']; ?></span>
												</li>
												<li class="list-group-item d-flex justify-content-between align-items-center">
												    Size of instituition
												    <span class="badge bg-primary rounded-pill"><?= $detail[0]['user_size_of_instituition']; ?></span>
												</li>
												<li class="list-group-item d-flex justify-content-between align-items-center">
												    Country
												    <span class="badge bg-primary rounded-pill"><?= $detail[0]['user_country']; ?></span>
												</li>
												<li class="list-group-item d-flex justify-content-between align-items-center">
												    State/Region
												    <span class="badge bg-primary rounded-pill"><?= $detail[0]['user_state']; ?></span>
												</li>
												<li class="list-group-item d-flex justify-content-between align-items-center">
												    City
												    <span class="badge bg-primary rounded-pill"><?= $detail[0]['user_city']; ?></span>
												</li>
											</ul>
									  	</div>
									</div>
							  	</li>
							  	<li class="list-group-item d-flex justify-content-between align-items-start">
						      		<div class="fw-bold">Date</div>
						     		<span><?= pretty_date($detail[0]['orders_orderdate']); ?></span>
							  	</li>
							</ol>

							<form action="" class="mt-3">
								<div class="form-check form-switch">
									<input class="form-check-input" type="checkbox" role="switch" id="paidSwitch" <?= (($detail[0]['orders_status'] == 2 || $detail[0]['orders_status'] == 3) ? 'checked' : ''); ?> name="paid">
									<label class="form-check-label" for="paidSwitch">Paid</label>
								</div>
								<div class="form-check form-switch">
									<input class="form-check-input" type="checkbox" role="switch" id="orderedSwitch" <?= (($detail[0]['orders_status'] == 3) ? 'checked' : ''); ?> name="ordered" value="<?= (($detail[0]['orders_status'] == 2) ? 3 : 1); ?>">
									<label class="form-check-label" for="orderedSwitch">Ordered</label>
								</div>
								<input type="hidden" id="orderId" value="<?= $detail[0]['orders_id']; ?>">						
								<input type="hidden" id="id" value="<?= $detail[0]['id']; ?>">						
							</form>
						<?php
						} else {
							$_SESSION['flash_error'] = 'Order not found!';
							redirect(PROOT . 'adminvonna/Orders');
						}
				?>
				
				<?php else: ?>
				<div class="table-responsive mt-5">
					<table class="table table-hover">
					  	<thead>
						    <tr>
						      	<th scope="col"></th>
						      	<th scope="col"></th>
						      	<th scope="col">Product</th>
						      	<th scope="col">QTY</th>
						      	<th scope="col">Customer</th>
						      	<th scope="col">Date</th>
						      	<th scope="col"></th>
					    	</tr>
					  	</thead>
					  	<tbody>
					  		<?php if ($order_count > 0): ?>
					  			<?php $i = 1; foreach ($orders as $order): ?>
						  			<tr scope="row">
						  				<td><?= $i; ?></td>
						  				<td>
						  					<?= $order['orders_id']; ?>
						  					<?php 
						  						if ($order['orders_status'] == 0) {
	                                                echo '<br><span class="badge bg-danger h6 text-uppercase">New</span>';
	                                            } elseif ($order['orders_status'] == 1) {
	                                                echo '<br><span class="badge bg-warning h6 text-uppercase">Processing</span>';
	                                            } elseif ($order['orders_status'] == 2) {
	                                                echo '<br><span class="badge bg-info h6 text-uppercase">Paid</span>';
	                                            } elseif ($order['orders_status'] == 3) {
	                                                echo '<br><span class="badge bg-success h6 text-uppercase">Ordered</span>';
	                                            } elseif ($order['orders_status'] == 4) {
	                                            } else {
	                                                echo '';
	                                            }
						  					?>		
						  				</td>
						  				<td><?= $order['orders_product']; ?></td>
						  				<td><?= $order['orders_quantity']; ?></td>
						  				<td><?= ucwords($order['user_fullname']); ?></td>
						  				<td><?= pretty_date($order['orders_orderdate']); ?></td>
						  				<td>
						  					<a href="<?= PROOT; ?>adminvonna/Orders?details=<?= $order['orders_id']; ?>" class="btn btn-warning">Details</a>						  						
						  				</td>
						  			</tr>
					  			<?php $i++; endforeach; ?>
					  		<?php else: ?>
					  			<tr>
					  				<td rowspan="6">No orders.</td>
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



        $(document).ready(function() {

            $("#paidSwitch").change(function(event) {
            	event.preventDefault()
            	if (confirm('Are you sure')) 
	            	var paid = 1;
	            	var id = $('#orderId').val();
	            	
	            	if ($('#paidSwitch').is(":checked") == true) {
	            		paid = 2;
	            	}
	            	window.location = '<?= PROOT; ?>adminvonna/Orders?paid='+paid+'&id='+id;
            });

            $("#orderedSwitch").change(function(event) {
            	event.preventDefault()
            	if (confirm('Are you sure')) 
	            	var ordered = 1;
	            	var id = $('#orderId').val();
	            	if ($('#orderedSwitch').is(":checked") == true) {
	            		ordered = 3
	            	}
	            	window.location = '<?= PROOT; ?>adminvonna/Orders?ordered='+ordered+'&id='+id;
            });
        })
    </script>

</body>
</html>