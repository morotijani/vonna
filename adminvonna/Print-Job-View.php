<?php 
    // INDEX PAGE
    // 
    require_once ('./../db_connection/conn.php');
    if (!admin_is_logged_in()) {
        admin_login_redirect();
    }

	
    /*
    * EXAMINATION QUESTION
     */
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
				redirect(PROOT . 'adminvonna/Print-Job?view=exams');
			} else {
				echo js_alert('Something went wrong... try again');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Examination print job order';
			redirect(PROOT . 'adminvonna/Print-Job?view=exams');
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
				redirect(PROOT . 'adminvonna/Print-Job?view=exams');
			} else {
				echo js_alert('Something went wrong... try again');
				//redirect(PROOT . 'adminvonna/Print-Job?view=exams');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Examination print job order';
			redirect(PROOT . 'adminvonna/Print-Job?view=exams');
		}
	}


	/**
	 * BANNERS
	 */
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
				redirect(PROOT . 'adminvonna/Print-Job?view=banner');
			} else {
				echo js_alert('Something went wrong... try again');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Banner print job order';
			redirect(PROOT . 'adminvonna/Print-Job?view=banner');
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
				redirect(PROOT . 'adminvonna/Print-Job?view=banner');
			} else {
				echo js_alert('Something went wrong... try again');
				//redirect(PROOT . 'adminvonna/Print-Job?view=banner');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Banner print job order';
			redirect(PROOT . 'adminvonna/Print-Job?view=banner');
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


				<?php if (isset($_GET['view'])): ?>
					<?php 
						if ($_GET['view'] == 'exams'): 
							$printjobid = $_GET['id'];
							$queryExams = "
						        SELECT * FROM vonna_printjob 
						        INNER JOIN vonna_user 
						        ON vonna_user.user_id = vonna_printjob.printjob_userid 
						        WHERE vonna_printjob.printjob_id = ?
						        ORDER BY id DESC
						    ";
						    $statement = $conn->prepare($queryExams);
						    $statement->execute([$printjobid]);
						    $count_exams = $statement->rowCount();
						    $exam = $statement->fetchAll();
						    if ($count_exams > 0) {
						    	$updateQ = "
									UPDATE vonna_printjob 
									SET printjob_status = ? 
									WHERE printjob_id = ? 
								";
								$statement = $conn->prepare($updateQ);
								$statement->execute([1, $printjobid]);
						    } else {
						    	$_SESSION['flash_error'] = 'Could not find Examination question.';
						    	redirect(PROOT . 'adminvonna/Print-Job?pj=exams');
						    }
					?>
						<h3 class="my-4">Examination questions view</h3>
		                <p class="text-muted">
		                    <?php 
		                        $outputexams_file = '';
		                        if ($exam[0]['printjob_upload_typed_work'] != '') {
		                            // code...
		                            $exams_files = explode(',', $exam[0]['printjob_upload_typed_work']);
		                            foreach ($exams_files as $exams_file) 
		                                $outputexams_file .= '<a href="'.$exams_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
		                        }

		                        if ($exam[0]['printjob_status'] == 0) {
		                            echo '<span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
		                        } elseif ($exam[0]['printjob_status'] == 1) {
		                            echo '<span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
		                        } elseif ($exam[0]['printjob_status'] == 2) {
		                            echo '<span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
		                        } elseif ($exam[0]['printjob_status'] == 3) {
		                            echo '<span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
		                        }
		                    ?>
		                </p>
		                    
		                <ul class="list-group">
		                    <li class="list-group-item">
		                        <div class="ms-2 me-auto">
		                            <div class="fw-bold">Subject</div>
		                            <?php 
		                                $subjects = explode(',', $exam[0]['printjob_name_of_subject']);
		                                $sb = '';
		                                foreach ($subjects as $subject) {
		                                    $sb .= '<div class="d-inline p-2 border m-1 text-bg-light">'.$subject.'</div>';
		                                }
		                                echo $sb;
		                            ?>
		                            <div class="fw-bold">No to be printed</div>
		                            <?php 
		                                $exams_prints = explode(',', $exam[0]['printjob_number_to_be_printed']);
		                                $ep = '';
		                                foreach ($exams_prints as $exams_print) {
		                                    $ep .= '<div class="d-inline p-2 border m-1 text-bg-light">'.$exams_print.'</div>';
		                                }
		                                echo $ep;
		                            ?>
		                            <div class="fw-bold">Level</div>
		                            <?php 
		                                $exams_levels = explode(',', $exam[0]['printjob_level']);
		                                $el = '';
		                                foreach ($exams_levels as $exams_level) {
		                                    $el .= '<div class="d-inline p-2 border m-1 text-bg-light">'.$exams_level.'</div>';
		                                }
		                                echo $el;
		                            ?>
		                            <div class="fw-bold">Class/Form</div>
		                            <?php 
		                                $exams_forms = explode(',', $exam[0]['printjob_class_or_form']);
		                                $ecf = '';
		                                foreach ($exams_forms as $exams_form) {
		                                    $ecf .= '<div class="d-inline p-2 border m-1 text-bg-light">'.$exams_form.'</div>';
		                                }
		                                echo $ecf;
		                            ?>
		                        </div>
		                    </li>

		                    <li class="list-group-item fw-bold"><span class="text-info">Examination question ID</span> <?= $exam[0]['printjob_id']; ?></li>
		                    <li class="list-group-item fw-bold"><span class="text-info">What is the total size of your student body?</span> <?= $exam[0]['printjob_total_students']; ?></li>
		                    <li class="list-group-item fw-bold"><span class="text-info">Do you have the questions typed already?</span> <?= $exam[0]['printjob_typed_already']; ?></li>
		                    <li class="list-group-item fw-bold"><span class="text-info">If yes, upload your typed work here:</span> <?= $outputexams_file; ?></a></li>
		                    <li class="list-group-item fw-bold"><span class="text-info">If no, Do you want us to type for you?</span> <?= $exam[0]['printjob_want_us_to_type']; ?></li>
		                    <li class="list-group-item fw-bold"><span class="text-info">When do you want the print job delivered?</span> <?= $exam[0]['printjob_when_to_be_delivered']; ?></li>
		                    <li class="list-group-item fw-bold"><span class="text-info">Receipient Contact 1:</span> <?= $exam[0]['printjob_delivery_address_1']; ?></li>
		                    <li class="list-group-item fw-bold"><span class="text-info">Receipient Contact 2:</span> <?= $exam[0]['printjob_delivery_address_2']; ?></li>
		                     <button type="button" class="list-group-item list-group-item-action fw-bold text-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Customer: <?= ucwords($exam[0]['user_fullname']); ?></button>
					    	<div class="collapse" id="collapseExample">
							  	<div class="card card-body">
							    	<ul class="list-group">
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Email
										    <span class="badge bg-primary rounded-pill"><?= $exam[0]['user_email']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Phone
										    <span class="badge bg-primary rounded-pill"><?= $exam[0]['user_phone']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Occupation
										    <span class="badge bg-primary rounded-pill"><?= $exam[0]['user_occupation']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Name of instituition
										    <span class="badge bg-primary rounded-pill"><?= $exam[0]['user_name_of_instituition']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Postal Address
										    <span class="badge bg-primary rounded-pill"><?= $exam[0]['user_postal_address']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Pysical Address
										    <span class="badge bg-primary rounded-pill"><?= $exam[0]['user_physical_address']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Size of instituition
										    <span class="badge bg-primary rounded-pill"><?= $exam[0]['user_size_of_instituition']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Country
										    <span class="badge bg-primary rounded-pill"><?= $exam[0]['user_country']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    State/Region
										    <span class="badge bg-primary rounded-pill"><?= $exam[0]['user_state']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    City
										    <span class="badge bg-primary rounded-pill"><?= $exam[0]['user_city']; ?></span>
										</li>
									</ul>
							  	</div>
							</div>
		                    <li class="list-group-item"><span class="fw-bold text-info">Date: </span> <?= pretty_date($exam[0]['printjob_createdAt']); ?></li>
		                </ul>
		                <form action="" class="mt-3">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="examsPaidSwitch" <?= (($exam[0]['printjob_status'] == 2 || $exam[0]['printjob_status'] == 3) ? 'checked' : ''); ?> name="paid">
								<label class="form-check-label" for="examsPaidSwitch">Paid</label>
							</div>
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="examsOrderedSwitch" <?= (($exam[0]['printjob_status'] == 3) ? 'checked' : ''); ?> name="ordered" value="<?= (($exam[0]['printjob_status'] == 2) ? 3 : 1); ?>">
								<label class="form-check-label" for="examsOrderedSwitch">Ordered</label>
							</div>
							<input type="hidden" id="orderId" value="<?= $exam[0]['printjob_id']; ?>">						
							<input type="hidden" id="id" value="<?= $exam[0]['id']; ?>">						
						</form>
                                       
					<?php elseif ($_GET['view'] == 'thesis'): ?>
					<?php elseif ($_GET['view'] == 'flier'): ?>
					<?php 
						elseif ($_GET['view'] == 'banner'): 
							$bannerid = $_GET['id'];
							$queryBanners = "
						        SELECT * FROM vonna_printjob_banners 
						        INNER JOIN vonna_user 
						        ON vonna_user.user_id = vonna_printjob_banners.banner_userid 
						        WHERE vonna_printjob_banners.banner_id = ?
						        ORDER BY id DESC
						    ";
						    $statement = $conn->prepare($queryBanners);
						    $statement->execute([$bannerid]);
						    $count_banners = $statement->rowCount();
						    $banner = $statement->fetchAll();
						    if ($count_banners > 0) {
						    	$updateQ = "
									UPDATE vonna_printjob_banners 
									SET banner_status = ? 
									WHERE banner_id = ? 
								";
								$statement = $conn->prepare($updateQ);
								$statement->execute([1, $bannerid]);
						    } else {
						    	$_SESSION['flash_error'] = 'Could not find Banner.';
						    	redirect(PROOT . 'adminvonna/Print-Job?pj=banner');
						    }

					?>
						<h3 class="my-4">Banner view</h3>
	                    <p class="text-muted">
	                        <?php 
	                         	$outputbanner_file = '';
	                                if ($banner[0]['banner_upload_design'] != '') {
	                                    // code...
	                                    $banner_files = explode(',', $banner[0]['banner_upload_design']);
	                                    foreach ($banner_files as $banner_file) 
	                                        $outputbanner_file .= '<a href="'.$banner_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
	                                }

	                            if ($banner[0]['banner_status'] == 0) {
	                                echo '<span class="badge bg-danger h6 text-uppercase">Pending</span>';
	                            } elseif ($banner[0]['banner_status'] == 1) {
	                                echo '<span class="badge bg-warning h6 text-uppercase">Processing</span>';
	                            } elseif ($banner[0]['banner_status'] == 2) {
	                                echo '<span class="badge bg-info h6 text-uppercase">Paid</span>';
	                            } elseif ($banner[0]['banner_status'] == 3) {
	                                echo '<span class="badge bg-success h6 text-uppercase">Ordered</span>';
	                            }
	                        ?>
	                    </p>
	                        
	                    <ul class="list-group">
	                        <li class="list-group-item fw-bold"><span class="text-info">Banner ID?</span> <?= $banner[0]['banner_id']; ?></li>
	                        <li class="list-group-item fw-bold"><span class="text-info">What size do you want?</span> <?= $banner[0]['banner_size']; ?></li>
	                        <li class="list-group-item fw-bold"><span class="text-info">What quantity do you want?</span> <?= $banner[0]['banner_quantity']; ?></li>
	                        <li class="list-group-item fw-bold"><span class="text-info">Do you have your designs already?</span> <?= $banner[0]['have_banner_designs']; ?></a></li>
	                        <li class="list-group-item fw-bold"><span class="text-info">If yes, Upload your design here:</span> <?= $outputbanner_file; ?></a></li>
	                        <li class="list-group-item fw-bold"><span class="text-info">If No, Do you want us to do the design for you?</span> <?= $banner[0]['banner_want_us']; ?></a></li>
	                        <li class="list-group-item fw-bold"><span class="fw-bold text-info">Date: </span> <?= pretty_date($banner[0]['banner_createdAt']); ?></li>
	                        <button type="button" class="list-group-item list-group-item-action fw-bold text-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Customer: <?= ucwords($banner[0]['user_fullname']); ?></button>
					    	<div class="collapse" id="collapseExample">
							  	<div class="card card-body">
							    	<ul class="list-group">
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Email
										    <span class="badge bg-primary rounded-pill"><?= $banner[0]['user_email']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Phone
										    <span class="badge bg-primary rounded-pill"><?= $banner[0]['user_phone']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Occupation
										    <span class="badge bg-primary rounded-pill"><?= $banner[0]['user_occupation']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Name of instituition
										    <span class="badge bg-primary rounded-pill"><?= $banner[0]['user_name_of_instituition']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Postal Address
										    <span class="badge bg-primary rounded-pill"><?= $banner[0]['user_postal_address']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Pysical Address
										    <span class="badge bg-primary rounded-pill"><?= $banner[0]['user_physical_address']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Size of instituition
										    <span class="badge bg-primary rounded-pill"><?= $banner[0]['user_size_of_instituition']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Country
										    <span class="badge bg-primary rounded-pill"><?= $banner[0]['user_country']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    State/Region
										    <span class="badge bg-primary rounded-pill"><?= $banner[0]['user_state']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    City
										    <span class="badge bg-primary rounded-pill"><?= $banner[0]['user_city']; ?></span>
										</li>
									</ul>
							  	</div>
							</div>
	                        <li class="list-group-item"><span class="fw-bold text-info">Date: </span> <?= pretty_date($banner[0]['banner_createdAt']); ?></li>
	                    </ul>
	                    <form action="" class="mt-3">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="bannerPaidSwitch" <?= (($banner[0]['banner_status'] == 2 || $banner[0]['banner_status'] == 3) ? 'checked' : ''); ?> name="paid">
								<label class="form-check-label" for="bannerPaidSwitch">Paid</label>
							</div>
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="bannerOrderedSwitch" <?= (($banner[0]['banner_status'] == 3) ? 'checked' : ''); ?> name="ordered" value="<?= (($banner[0]['banner_status'] == 2) ? 3 : 1); ?>">
								<label class="form-check-label" for="bannerOrderedSwitch">Ordered</label>
							</div>
							<input type="hidden" id="orderId" value="<?= $banner[0]['banner_id']; ?>">						
							<input type="hidden" id="id" value="<?= $banner[0]['id']; ?>">						
						</form>
	                           
							  		
					<?php elseif ($_GET['view'] == 'receipt'): ?>
					<?php elseif ($_GET['view'] == 'customize'): ?>
					<?php elseif ($_GET['view'] == 'card'): ?>
					<?php else: ?>
						<?php redirect(PROOT . 'adminvonna/Print-Job');  ?>
					<?php endif; ?>
				<?php else: ?>
						<?php redirect(PROOT . 'adminvonna/Print-Job');  ?>
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



        $(document).ready(function() {

        	// EXAMS
            $("#examsPaidSwitch").change(function(event) {
            	event.preventDefault()
            	if (confirm('Are you sure')) 
	            	var paid = 1;
	            	var id = $('#orderId').val();
	            	
	            	if ($('#examsPaidSwitch').is(":checked") == true) {
	            		paid = 2;
	            	}
	            	window.location = '<?= PROOT; ?>adminvonna/Print-Job-View?examspaid='+paid+'&id='+id;
            });

            $("#examsOrderedSwitch").change(function(event) {
            	event.preventDefault()
            	if (confirm('Are you sure')) 
	            	var ordered = 1;
	            	var id = $('#orderId').val();
	            	if ($('#examsOrderedSwitch').is(":checked") == true) {
	            		ordered = 3
	            	}
	            	window.location = '<?= PROOT; ?>adminvonna/Print-Job-View?examsordered='+ordered+'&id='+id;
            });


            // BANNER
            $("#bannerPaidSwitch").change(function(event) {
            	event.preventDefault()
            	if (confirm('Are you sure')) 
	            	var paid = 1;
	            	var id = $('#orderId').val();
	            	
	            	if ($('#bannerPaidSwitch').is(":checked") == true) {
	            		paid = 2;
	            	}
	            	window.location = '<?= PROOT; ?>adminvonna/Print-Job-View?bannerpaid='+paid+'&id='+id;
            });

            $("#bannerOrderedSwitch").change(function(event) {
            	event.preventDefault()
            	if (confirm('Are you sure')) 
	            	var ordered = 1;
	            	var id = $('#orderId').val();
	            	if ($('#bannerOrderedSwitch').is(":checked") == true) {
	            		ordered = 3
	            	}
	            	window.location = '<?= PROOT; ?>adminvonna/Print-Job-View?bannerordered='+ordered+'&id='+id;
            });
        })
    </script>

</body>
</html>