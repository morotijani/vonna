<?php 
    // INDEX PAGE
    // 
    require_once ('./../db_connection/conn.php');
    if (!admin_is_logged_in()) {
        admin_login_redirect();
    }

	$queryExams = "
        SELECT * FROM vonna_printjob 
        INNER JOIN vonna_user 
        ON vonna_user.user_id = vonna_printjob.printjob_userid  
        ORDER BY id DESC
    ";
    $statement = $conn->prepare($queryExams);
    $statement->execute();
    $count_exams = $statement->rowCount();
    $exams = $statement->fetchAll();


	// check for ordered order
	if (isset($_GET['examsordered']) && !empty($_GET['examsordered'])) {
		// code...
		$status = sanitize((int)$_GET['examsordered']);
		$id = sanitize($_GET['id']);
		if ($id != '') {
			// code...
			$sql = "
				UPDATE vonna_printjob 
				SET printjob_status = ? 
				WHERE printjob_id = ?
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);

			if ($result) {
				// code...
				$_SESSION['flash_success'] = 'Examination print job ' . (($status == 1) ? 'Un-ordered' : 'Ordered');
				redirect(PROOT . 'adminvonna/Print-Job?pj=exams');
			} else {
				echo js_alert('Something went wrong... try again');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Examination print job order';
			redirect(PROOT . 'adminvonna/Print-Job?pj=exams');
		}
	}


	// check for paid order
	if (isset($_GET['examspaid']) && !empty($_GET['examspaid'])) {
		// code...
		$status = sanitize((int)$_GET['examspaid']);
		$id = sanitize($_GET['id']);
		if ($id != '') {
			// code...
			$sql = "
				UPDATE vonna_printjob 
				SET printjob_status = ? 
				WHERE printjob_id = ?
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);

			if ($result) {
				// code...
				$_SESSION['flash_success'] = 'Examination print job ' . (($status == 1) ? 'Not Paid' : 'Paid, ready for order');
				redirect(PROOT . 'adminvonna/Print-Job?pj=exams');
			} else {
				echo js_alert('Something went wrong... try again');
				//redirect(PROOT . 'adminvonna/Print-Job?pj=exams');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Examination print job order';
			redirect(PROOT . 'adminvonna/Print-Job?pj=exams');
		}
	}


	/**
	 * BANNERS
	 */
    $queryBanners = "
        SELECT * FROM vonna_printjob_banners 
        INNER JOIN vonna_user 
        ON vonna_user.user_id = vonna_printjob_banners.banner_userid  
        ORDER BY id DESC
    ";
    $statement = $conn->prepare($queryBanners);
    $statement->execute();
    $count_banners = $statement->rowCount();
    $banners = $statement->fetchAll();

    // check for ordered order
	if (isset($_GET['bannerordered']) && !empty($_GET['bannerordered'])) {
		// code...
		$status = sanitize((int)$_GET['bannerordered']);
		$id = sanitize($_GET['id']);
		if ($id != '') {
			// code...
			$sql = "
				UPDATE vonna_printjob_banners 
				SET banner_status = ? 
				WHERE banner_id = ?
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);

			if ($result) {
				// code...
				$_SESSION['flash_success'] = 'Banner print job ' . (($status == 1) ? 'Un-ordered' : 'Ordered');
				redirect(PROOT . 'adminvonna/Print-Job?pj=banner');
			} else {
				echo js_alert('Something went wrong... try again');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Banner print job order';
			redirect(PROOT . 'adminvonna/Print-Job?pj=banner');
		}
	}


	// check for paid order
	if (isset($_GET['bannerpaid']) && !empty($_GET['bannerpaid'])) {
		// code...
		$status = sanitize((int)$_GET['bannerpaid']);
		$id = sanitize($_GET['id']);
		if ($id != '') {
			// code...
			$sql = "
				UPDATE vonna_printjob_banners 
				SET banner_status = ? 
				WHERE banner_id = ?
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);

			if ($result) {
				// code...
				$_SESSION['flash_success'] = 'Banner print job ' . (($status == 1) ? 'Not Paid' : 'Paid, ready for order');
				redirect(PROOT . 'adminvonna/Print-Job?pj=banner');
			} else {
				echo js_alert('Something went wrong... try again');
				//redirect(PROOT . 'adminvonna/Print-Job?pj=banner');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Banner print job order';
			redirect(PROOT . 'adminvonna/Print-Job?pj=banner');
		}
	}


	/**
	 * CALL CARDS
	 */
    $queryCallcards = "
        SELECT * FROM vonna_printjob_callcards 
        INNER JOIN vonna_user 
        ON vonna_user.user_id = vonna_printjob_callcards.card_userid  
        ORDER BY id DESC
    ";
    $statement = $conn->prepare($queryCallcards);
    $statement->execute();
    $count_callcards = $statement->rowCount();
    $callcards = $statement->fetchAll();

    $queryFliers = "
        SELECT * FROM vonna_printjob_fliers 
        INNER JOIN vonna_user 
        ON vonna_user.user_id = vonna_printjob_fliers.flier_userid 
        ORDER BY id DESC
    ";
    $statement = $conn->prepare($queryFliers);
    $statement->execute();
    $count_fliers = $statement->rowCount();
    $fliers = $statement->fetchAll();

    $queryThesis = "
        SELECT * FROM vonna_printjob_thesis 
        INNER JOIN vonna_user 
        ON vonna_user.user_id = vonna_printjob_thesis.thesis_userid 
        ORDER BY id DESC
    ";
    $statement = $conn->prepare($queryThesis);
    $statement->execute();
    $count_thesis = $statement->rowCount();
    $thesiss = $statement->fetchAll();

    $queryCustomize = "
        SELECT * FROM vonna_print_job_customze 
        INNER JOIN vonna_user 
        ON vonna_user.user_id = vonna_print_job_customze.customze_userid 
        ORDER BY id DESC
    ";
    $statement = $conn->prepare($queryCustomize);
    $statement->execute();
    $count_cutomizes = $statement->rowCount();
    $cutomizes = $statement->fetchAll();

    $queryReceipt = "
        SELECT * FROM vonna_print_job_receipt 
        INNER JOIN vonna_user 
        ON vonna_user.user_id = vonna_print_job_receipt.receipt_userid 
        ORDER BY id DESC
    ";
    $statement = $conn->prepare($queryReceipt);
    $statement->execute();
    $count_receipts = $statement->rowCount();
    $receipts = $statement->fetchAll();


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


				<?php if (isset($_GET['pj'])): ?>
					<?php if ($_GET['pj'] == 'exams'):
					?>
						<h3 class="my-4">Examination questions</h3>
						<div class="table-responsive mt-5">
							<table class="table table-hover">
							  	<thead>
								    <tr>
								      	<th></th>
                                        <th>ID</th>
                                        <th>Subjects</th>
                                        <th>Total students</th>
                                        <th>Date</th>
                                        <th></th>
							    	</tr>
							  	</thead>
							  	<tbody>
							  		<?php if ($count_exams > 0): ?>
							  			 <?php $i = 1;
                                            foreach ($exams as $exam): 
                                        ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td>
                                                <?php
                                                    echo $exam["printjob_id"];

                                                    if ($exam['printjob_status'] == 0) {
	                                                	echo '<br><span class="badge bg-danger h6 text-uppercase">New</span>';
		                                            } elseif ($exam['printjob_status'] == 1) {
		                                                echo '<br><span class="badge bg-warning h6 text-uppercase">Processing</span>';
		                                            } elseif ($exam['printjob_status'] == 2) {
		                                                echo '<br><span class="badge bg-info h6 text-uppercase">Paid</span>';
		                                            } elseif ($exam['printjob_status'] == 3) {
		                                                echo '<br><span class="badge bg-success h6 text-uppercase">Ordered</span>';
		                                            } elseif ($exam['printjob_status'] == 4) {
		                                            } else {
		                                                echo '';
		                                            }
                                                ?>
                                            </td>
                                            <td><?= $exam["printjob_name_of_subject"]; ?></td>
                                            <td><?= $exam["printjob_total_students"]; ?></td>
                                            <td><?= pretty_date($exam["printjob_createdAt"]); ?></td>
                                            <td>
                                                <a href="<?= PROOT; ?>adminvonna/Print-Job-View.php?view=exams&id=<?= $exam['printjob_id']; ?>" class="badge bg-primary mb-2"><i data-feather="eye"></i></a>
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
					<?php elseif ($_GET['pj'] == 'exams'): ?>
					<?php elseif ($_GET['pj'] == 'thesis'): ?>
					<?php elseif ($_GET['pj'] == 'flier'): ?>
					<?php elseif ($_GET['pj'] == 'banner'): ?>
						<h3 class="my-4">Banners</h3>
						<div class="table-responsive mt-5">
							<table class="table table-hover">
							  	<thead>
								    <tr>
								      	<th></th>
                                        <th>ID</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                        <th></th>
							    	</tr>
							  	</thead>
							  	<tbody>
							  		<?php if ($count_banners > 0): ?>
							  			 <?php $i = 1;
                                            foreach ($banners as $banner): 
                                        ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td>
                                                <?php
                                                    echo $banner["banner_id"];

                                                    if ($banner['banner_status'] == 0) {
	                                                	echo '<br><span class="badge bg-danger h6 text-uppercase">New</span>';
		                                            } elseif ($banner['banner_status'] == 1) {
		                                                echo '<br><span class="badge bg-warning h6 text-uppercase">Processing</span>';
		                                            } elseif ($banner['banner_status'] == 2) {
		                                                echo '<br><span class="badge bg-info h6 text-uppercase">Paid</span>';
		                                            } elseif ($banner['banner_status'] == 3) {
		                                                echo '<br><span class="badge bg-success h6 text-uppercase">Ordered</span>';
		                                            } elseif ($banner['banner_status'] == 4) {
		                                            } else {
		                                                echo '';
		                                            }
                                                ?>
                                            </td>
                                           <td><?= $banner["banner_size"]; ?></td>
                                            <td><?= $banner["banner_quantity"]; ?></td>
                                            <td><?= pretty_date($banner["banner_createdAt"]); ?></td>
                                            <td>
                                                <a href="<?= PROOT; ?>adminvonna/Print-Job-View.php?view=banner&id=<?= $banner['banner_id']; ?>" class="badge bg-primary mb-2"><i data-feather="eye"></i></a>
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
					<?php elseif ($_GET['pj'] == 'receipt'): ?>
					<?php elseif ($_GET['pj'] == 'customize'): ?>
					<?php elseif ($_GET['pj'] == 'card'): ?>
					<?php else: ?>
						<?php redirect(PROOT . 'adminvonna/Print-Job');  ?>
					<?php endif; ?>
				<?php else: ?>
					<div class="list-group my-5">
					  	<a href="?pj=exams" class="list-group-item list-group-item-action">Examination questions</a>
					  	<a href="?pj=thesis" class="list-group-item list-group-item-action">Thesis</a>
					  	<a href="?pj=flier" class="list-group-item list-group-item-action">Fliers</a>
					  	<a href="?pj=banner" class="list-group-item list-group-item-action">Banners</a>
					  	<a href="?pj=receipt" class="list-group-item list-group-item-action">Receipt books</a>
					  	<a href="?pj=customize" class="list-group-item list-group-item-action">Customized office Files</a>
					  	<a href="?pj=card" class="list-group-item list-group-item-action">Call cards</a>
					</div>
				<?php endif; ?>

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
						  					<a href="<?= PROOT; ?>adminvonna/Orders/<?= $order['orders_id']; ?>" class="btn btn-warning">Details</a>						  						
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
    </script>

</body>
</html>