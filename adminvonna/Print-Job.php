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
					      <h4>Print Jobs</h4>&nbsp;.&nbsp;
					      <h4><a href="<?= PROOT; ?>adminvonna/Print-Job" class="btn btn-secondary btn-sm"> << go back</a></h4>
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
					<?php elseif ($_GET['pj'] == 'thesis'): ?>
						<h3 class="my-4">Thesis / Reasearch</h3>
						<div class="table-responsive mt-5">
							<table class="table table-hover">
							  	<thead>
								    <tr>
								      	<th></th>
                                        <th>ID</th>
                                        <th>Have a Topic</th>
                                        <th>Date</th>
                                        <th></th>
							    	</tr>
							  	</thead>
							  	<tbody>
							  		<?php if ($count_thesis > 0): ?>
							  			 <?php $i = 1;
                                            foreach ($thesiss as $thesis): 
                                        ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td>
                                                <?php
                                                    echo $thesis["thesis_id"];

                                                    if ($thesis['thesis_status'] == 0) {
	                                                	echo '<br><span class="badge bg-danger h6 text-uppercase">New</span>';
		                                            } elseif ($thesis['thesis_status'] == 1) {
		                                                echo '<br><span class="badge bg-warning h6 text-uppercase">Processing</span>';
		                                            } elseif ($thesis['thesis_status'] == 2) {
		                                                echo '<br><span class="badge bg-info h6 text-uppercase">Paid</span>';
		                                            } elseif ($thesis['thesis_status'] == 3) {
		                                                echo '<br><span class="badge bg-success h6 text-uppercase">Ordered</span>';
		                                            } elseif ($thesis['thesis_status'] == 4) {
		                                            } else {
		                                                echo '';
		                                            }
                                                ?>
                                            </td>
                                          	<td><?= $thesis["thesis_already_have_tr"]; ?></td>
                                            <td><?= pretty_date($thesis["thesis_createdAt"]); ?></td>
                                            <td>
                                                <a href="<?= PROOT; ?>adminvonna/Print-Job-View.php?view=thesis&id=<?= $thesis['thesis_id']; ?>" class="badge bg-primary mb-2"><i data-feather="eye"></i></a>
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
					<?php elseif ($_GET['pj'] == 'flier'): ?>
						<h3 class="my-4">Flier</h3>
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
							  		<?php if ($count_fliers > 0): ?>
							  			 <?php $i = 1;
                                            foreach ($fliers as $flier): 
                                        ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td>
                                                <?php
                                                    echo $flier["flier_id"];

                                                    if ($flier['flier_status'] == 0) {
	                                                	echo '<br><span class="badge bg-danger h6 text-uppercase">New</span>';
		                                            } elseif ($flier['flier_status'] == 1) {
		                                                echo '<br><span class="badge bg-warning h6 text-uppercase">Processing</span>';
		                                            } elseif ($flier['flier_status'] == 2) {
		                                                echo '<br><span class="badge bg-info h6 text-uppercase">Paid</span>';
		                                            } elseif ($flier['flier_status'] == 3) {
		                                                echo '<br><span class="badge bg-success h6 text-uppercase">Ordered</span>';
		                                            } elseif ($flier['flier_status'] == 4) {
		                                            } else {
		                                                echo '';
		                                            }
                                                ?>
                                            </td>
                                          	<td><?= $flier["flier_size_to_print"]; ?></td>
                                            <td><?= $flier["flier_quantity_to_print"]; ?></td>
                                            <td><?= pretty_date($flier["flier_createdAt"]); ?></td>
                                            <td>
                                                <a href="<?= PROOT; ?>adminvonna/Print-Job-View.php?view=flier&id=<?= $flier['flier_id']; ?>" class="badge bg-primary mb-2"><i data-feather="eye"></i></a>
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