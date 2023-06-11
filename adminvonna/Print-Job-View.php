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
	 * THESIS/RESEARCH
	 */
	 // check for ordered order
	if (isset($_GET['thesisordered']) && !empty($_GET['thesisordered'])) {
		// code...
		$status = sanitize((int)$_GET['thesisordered']);
		$id = sanitize($_GET['id']);
		if ($id != '') {
			// code...
			$sql = "
				UPDATE vonna_printjob_thesis 
				SET thesis_status = ? 
				WHERE thesis_id = ?
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);

			if ($result) {
				// code...
				$_SESSION['flash_success'] = 'Thesis/Research print job ' . (($status == 1) ? 'Un-ordered' : 'Ordered');
				redirect(PROOT . 'adminvonna/Print-Job?pj=thesis');
			} else {
				echo js_alert('Something went wrong... try again');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Thesis/Research print job order';
			redirect(PROOT . 'adminvonna/Print-Job?pj=thesis');
		}
	}

	// check for paid order
	if (isset($_GET['thesispaid']) && !empty($_GET['thesispaid'])) {
		// code...
		$status = sanitize((int)$_GET['thesispaid']);
		$id = sanitize($_GET['id']);
		if ($id != '') {
			// code...
			$sql = "
				UPDATE vonna_printjob_thesis 
				SET thesis_status = ? 
				WHERE thesis_id = ?
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);

			if ($result) {
				// code...
				$_SESSION['flash_success'] = 'Thesis/Research print job ' . (($status == 1) ? 'Not Paid' : 'Paid, ready for order');
				redirect(PROOT . 'adminvonna/Print-Job?pj=thesis');
			} else {
				echo js_alert('Something went wrong... try again');
				//redirect(PROOT . 'adminvonna/Print-Job?pj=thesis');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Thesis/Research print job order';
			redirect(PROOT . 'adminvonna/Print-Job?pj=thesis');
		}
	}

	/**
	 * FLIER
	 */
	 // check for ordered order
	if (isset($_GET['flierordered']) && !empty($_GET['flierordered'])) {
		// code...
		$status = sanitize((int)$_GET['flierordered']);
		$id = sanitize($_GET['id']);
		if ($id != '') {
			// code...
			$sql = "
				UPDATE vonna_printjob_fliers 
				SET flier_status = ? 
				WHERE flier_id = ?
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);

			if ($result) {
				// code...
				$_SESSION['flash_success'] = 'Flier print job ' . (($status == 1) ? 'Un-ordered' : 'Ordered');
				redirect(PROOT . 'adminvonna/Print-Job?pj=flier');
			} else {
				echo js_alert('Something went wrong... try again');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Flier print job order';
			redirect(PROOT . 'adminvonna/Print-Job?pj=flier');
		}
	}

	// check for paid order
	if (isset($_GET['flierpaid']) && !empty($_GET['flierpaid'])) {
		// code...
		$status = sanitize((int)$_GET['flierpaid']);
		$id = sanitize($_GET['id']);
		if ($id != '') {
			// code...
			$sql = "
				UPDATE vonna_printjob_fliers 
				SET flier_status = ? 
				WHERE flier_id = ?
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);

			if ($result) {
				// code...
				$_SESSION['flash_success'] = 'Flier print job ' . (($status == 1) ? 'Not Paid' : 'Paid, ready for order');
				redirect(PROOT . 'adminvonna/Print-Job?pj=flier');
			} else {
				echo js_alert('Something went wrong... try again');
				//redirect(PROOT . 'adminvonna/Print-Job?pj=flier');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Flier print job order';
			redirect(PROOT . 'adminvonna/Print-Job?pj=flier');
		}
	}

	/**
	 * RECEIPT BOOK
	 */
	 // check for ordered order
	if (isset($_GET['receiptordered']) && !empty($_GET['receiptordered'])) {
		// code...
		$status = sanitize((int)$_GET['receiptordered']);
		$id = sanitize($_GET['id']);
		if ($id != '') {
			// code...
			$sql = "
				UPDATE vonna_print_job_receipt 
				SET receipt_status = ? 
				WHERE receipt_id = ?
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);

			if ($result) {
				// code...
				$_SESSION['flash_success'] = 'Receipt book print job ' . (($status == 1) ? 'Un-ordered' : 'Ordered');
				redirect(PROOT . 'adminvonna/Print-Job?pj=receipt');
			} else {
				echo js_alert('Something went wrong... try again');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Receipt book print job order';
			redirect(PROOT . 'adminvonna/Print-Job?pj=receipt');
		}
	}

	// check for paid order
	if (isset($_GET['receiptpaid']) && !empty($_GET['receiptpaid'])) {
		// code...
		$status = sanitize((int)$_GET['receiptpaid']);
		$id = sanitize($_GET['id']);
		if ($id != '') {
			// code...
			$sql = "
				UPDATE vonna_print_job_receipt 
				SET receipt_status = ? 
				WHERE receipt_id = ?
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);

			if ($result) {
				// code...
				$_SESSION['flash_success'] = 'Receipt book print job ' . (($status == 1) ? 'Not Paid' : 'Paid, ready for order');
				redirect(PROOT . 'adminvonna/Print-Job?pj=receipt');
			} else {
				echo js_alert('Something went wrong... try again');
				//redirect(PROOT . 'adminvonna/Print-Job?pj=receipt');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Receipt book print job order';
			redirect(PROOT . 'adminvonna/Print-Job?pj=receipt');
		}
	}

	/**
	 * CUSTOMIZE OFFICE FILES
	 */
	 // check for ordered order
	if (isset($_GET['customizeordered']) && !empty($_GET['customizeordered'])) {
		// code...
		$status = sanitize((int)$_GET['customizeordered']);
		$id = sanitize($_GET['id']);
		if ($id != '') {
			// code...
			$sql = "
				UPDATE vonna_print_job_customze 
				SET customze_status = ? 
				WHERE customze_id = ?
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);

			if ($result) {
				// code...
				$_SESSION['flash_success'] = 'Customize office files print job ' . (($status == 1) ? 'Un-ordered' : 'Ordered');
				redirect(PROOT . 'adminvonna/Print-Job?pj=customize');
			} else {
				echo js_alert('Something went wrong... try again');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Customize office files print job order';
			redirect(PROOT . 'adminvonna/Print-Job?pj=customize');
		}
	}

	// check for paid order
	if (isset($_GET['customizepaid']) && !empty($_GET['customizepaid'])) {
		// code...
		$status = sanitize((int)$_GET['customizepaid']);
		$id = sanitize($_GET['id']);
		if ($id != '') {
			// code...
			$sql = "
				UPDATE vonna_print_job_customze 
				SET customze_status = ? 
				WHERE customze_id = ?
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);

			if ($result) {
				// code...
				$_SESSION['flash_success'] = 'Customize office files print job ' . (($status == 1) ? 'Not Paid' : 'Paid, ready for order');
				redirect(PROOT . 'adminvonna/Print-Job?pj=customize');
			} else {
				echo js_alert('Something went wrong... try again');
				//redirect(PROOT . 'adminvonna/Print-Job?pj=customize');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Customize office files print job order';
			redirect(PROOT . 'adminvonna/Print-Job?pj=customize');
		}
	}
    

	/**
	 * CALL CARDS
	 */
   if (isset($_GET['cardordered']) && !empty($_GET['cardordered'])) {
		// code...
		$status = sanitize((int)$_GET['cardordered']);
		$id = sanitize($_GET['id']);
		if ($id != '') {
			// code...
			$sql = "
				UPDATE vonna_printjob_callcards 
				SET card_status = ? 
				WHERE card_id = ?
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);

			if ($result) {
				// code...
				$_SESSION['flash_success'] = 'Call cards print job ' . (($status == 1) ? 'Un-ordered' : 'Ordered');
				redirect(PROOT . 'adminvonna/Print-Job?pj=card');
			} else {
				echo js_alert('Something went wrong... try again');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Call cards print job order';
			redirect(PROOT . 'adminvonna/Print-Job?pj=card');
		}
	}

	// check for paid order
	if (isset($_GET['cardpaid']) && !empty($_GET['cardpaid'])) {
		// code...
		$status = sanitize((int)$_GET['cardpaid']);
		$id = sanitize($_GET['id']);
		if ($id != '') {
			// code...
			$sql = "
				UPDATE vonna_printjob_callcards 
				SET card_status = ? 
				WHERE card_id = ?
			";
			$statement = $conn->prepare($sql);
			$result = $statement->execute([$status, $id]);

			if ($result) {
				// code...
				$_SESSION['flash_success'] = 'Call cards print job ' . (($status == 1) ? 'Not Paid' : 'Paid, ready for order');
				redirect(PROOT . 'adminvonna/Print-Job?pj=card');
			} else {
				echo js_alert('Something went wrong... try again');
				//redirect(PROOT . 'adminvonna/Print-Job?pj=card');
			}
		} else {
			$_SESSION['flash_error'] = 'Unknow Call cards print job order';
			redirect(PROOT . 'adminvonna/Print-Job?pj=card');
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
					      <h4>Print Jobs</h4>&nbsp;.&nbsp;
					      <h4><a href="<?= PROOT; ?>adminvonna/Print-Job?pj=<?= ((isset($_GET['view'])) ? $_GET['view'] : ''); ?>" class="btn btn-secondary btn-sm"> << go back</a></h4>
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
						    	if ($exam[0]['printjob_status'] == 0) {
							    	$updateQ = "
										UPDATE vonna_printjob 
										SET printjob_status = ? 
										WHERE printjob_id = ? 
									";
									$statement = $conn->prepare($updateQ);
									$statement->execute([1, $printjobid]);
						    	}
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
		                                $outputexams_file .= '<a href="' . PROOT . 'account/' . $exams_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
		                        }

		                        if ($exam[0]['printjob_status'] == 0) {
		                            echo '<span class="badge bg-danger h6 text-uppercase">Pending</span>';
		                        } elseif ($exam[0]['printjob_status'] == 1) {
		                            echo '<span class="badge bg-warning h6 text-uppercase">Processing</span>';
		                        } elseif ($exam[0]['printjob_status'] == 2) {
		                            echo '<span class="badge bg-info h6 text-uppercase">Paid</span>';
		                        } elseif ($exam[0]['printjob_status'] == 3) {
		                            echo '<span class="badge bg-success h6 text-uppercase">Ordered</span>';
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
                                       
					<?php 
						elseif ($_GET['view'] == 'thesis'): 
							$thesisid = $_GET['id'];
							$queryThesis = "
						        SELECT * FROM vonna_printjob_thesis 
						        INNER JOIN vonna_user 
						        ON vonna_user.user_id = vonna_printjob_thesis.thesis_userid 
						        WHERE vonna_printjob_thesis.thesis_id = ?
						        ORDER BY id DESC
						    ";
						    $statement = $conn->prepare($queryThesis);
						    $statement->execute([$thesisid]);
						    $count_thesis = $statement->rowCount();
						    $thesis = $statement->fetchAll();
						    if ($count_thesis > 0) {
						    	if ($thesis[0]['thesis_status'] == 0) {
							    	$updateQ = "
										UPDATE vonna_printjob_thesis 
										SET thesis_status = ? 
										WHERE thesis_id = ? 
									";
									$statement = $conn->prepare($updateQ);
									$statement->execute([1, $thesisid]);
								}
						    } else {
						    	$_SESSION['flash_error'] = 'Could not find Thesis/Reserch.';
						    	redirect(PROOT . 'adminvonna/Print-Job?pj=thesis');
						    }
					?>
					<h3 class="my-4">Banner view</h3>
	                    <p class="text-muted">
	                        <?php 
								$outputthesis_file = '';
                                if ($thesis[0]['thesis_upload_work_tr'] != '') {
                                    // code...
                                    $thesis_files = explode(',', $thesis[0]['thesis_upload_work_tr']);
                                    foreach ($thesis_files as $thesis_file) 
                                        $outputthesis_file .= '<a href="' . PROOT . 'account/' . $thesis_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                }

                                $outputthesis_work_file = '';
                                if ($thesis[0]['thesis_upload_tr'] != '') {
                                    // code...
                                    $thesis_work_files = explode(',', $thesis[0]['thesis_upload_tr']);
                                    foreach ($thesis_work_files as $thesis_work_file) 
                                        $outputthesis_work_file .= '<a href="' . PROOT . 'account/' . $thesis_work_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                }

	                            if ($thesis[0]['thesis_status'] == 0) {
	                                echo '<span class="badge bg-danger h6 text-uppercase">Pending</span>';
	                            } elseif ($thesis[0]['thesis_status'] == 1) {
	                                echo '<span class="badge bg-warning h6 text-uppercase">Processing</span>';
	                            } elseif ($thesis[0]['thesis_status'] == 2) {
	                                echo '<span class="badge bg-info h6 text-uppercase">Paid</span>';
	                            } elseif ($thesis[0]['thesis_status'] == 3) {
	                                echo '<span class="badge bg-success h6 text-uppercase">Ordered</span>';
	                            }
	                        ?>
	                    </p>
	                        
	                    <ul class="list-group">
                            <li class="list-group-item"><span class="fw-bold text-info">Do you have a thesis/research topic already?</span> <?= $thesis[0]['thesis_already_have_tr']; ?></li>
                            <li class="list-group-item"><span class="fw-bold text-info">If yes, What is your thesis/research topic?</span> <?= $thesis[0]['thesis_your_thesis_research']; ?></li>
                            <li class="list-group-item"><span class="fw-bold text-info">if no,would you want us to get you a suitable research/thesis topic?</span> <?= $thesis[0]['thesis_get_for_you']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Have you typed your thesis/research already?</span> <?= $thesis[0]['thesis_have_you_typed']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">if no, do you want us to handle the typing of your thesis/research for you?</span> <?= $thesis[0]['thesis_handle_typing']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Have you effected the final editing to your thesis/research topic already?</span> <?= $thesis[0]['thesis_final_editing']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">If yes , Upload your work here:</span> <?= $outputthesis_file; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">If no, upload your thesis/research so far:</span> <?= $outputthesis_work_file; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">When do you want your work delivered?</span> <?= $thesis[0]['thesis_day_week'] . ' - ' . $thesis[0]['thesis_delivered_tr']; ?></li>
	                        <button type="button" class="list-group-item list-group-item-action fw-bold text-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Customer: <?= ucwords($thesis[0]['user_fullname']); ?></button>
					    	<div class="collapse" id="collapseExample">
							  	<div class="card card-body">
							    	<ul class="list-group">
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Email
										    <span class="badge bg-primary rounded-pill"><?= $thesis[0]['user_email']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Phone
										    <span class="badge bg-primary rounded-pill"><?= $thesis[0]['user_phone']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Occupation
										    <span class="badge bg-primary rounded-pill"><?= $thesis[0]['user_occupation']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Name of instituition
										    <span class="badge bg-primary rounded-pill"><?= $thesis[0]['user_name_of_instituition']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Postal Address
										    <span class="badge bg-primary rounded-pill"><?= $thesis[0]['user_postal_address']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Pysical Address
										    <span class="badge bg-primary rounded-pill"><?= $thesis[0]['user_physical_address']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Size of instituition
										    <span class="badge bg-primary rounded-pill"><?= $thesis[0]['user_size_of_instituition']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Country
										    <span class="badge bg-primary rounded-pill"><?= $thesis[0]['user_country']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    State/Region
										    <span class="badge bg-primary rounded-pill"><?= $thesis[0]['user_state']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    City
										    <span class="badge bg-primary rounded-pill"><?= $thesis[0]['user_city']; ?></span>
										</li>
									</ul>
							  	</div>
							</div>
	                        <li class="list-group-item"><span class="fw-bold text-info">Date: </span> <?= pretty_date($thesis[0]['thesis_createdAt']); ?></li>
	                    </ul>
	                    <form action="" class="mt-3">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="thesisPaidSwitch" <?= (($thesis[0]['thesis_status'] == 2 || $thesis[0]['thesis_status'] == 3) ? 'checked' : ''); ?> name="paid">
								<label class="form-check-label" for="thesisPaidSwitch">Paid</label>
							</div>
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="thesisOrderedSwitch" <?= (($thesis[0]['thesis_status'] == 3) ? 'checked' : ''); ?> name="ordered" value="<?= (($thesis[0]['thesis_status'] == 2) ? 3 : 1); ?>">
								<label class="form-check-label" for="thesisOrderedSwitch">Ordered</label>
							</div>
							<input type="hidden" id="orderId" value="<?= $thesis[0]['thesis_id']; ?>">						
							<input type="hidden" id="id" value="<?= $thesis[0]['id']; ?>">						
						</form>
					<?php 
						elseif ($_GET['view'] == 'flier'): 
						$flierid = $_GET['id'];
						$queryFliers = "
					        SELECT * FROM vonna_printjob_fliers 
					        INNER JOIN vonna_user 
					        ON vonna_user.user_id = vonna_printjob_fliers.flier_userid 
						    WHERE vonna_printjob_fliers.flier_id = ? 
					        ORDER BY id DESC
					    ";
					    $statement = $conn->prepare($queryFliers);
					    $statement->execute([$flierid]);
					    $count_fliers = $statement->rowCount();
					    $flier = $statement->fetchAll();
					     if ($count_fliers > 0) {
						    	if ($flier[0]['flier_status'] == 0) {
							    	$updateQ = "
										UPDATE vonna_printjob_fliers 
										SET flier_status = ? 
										WHERE flier_id = ? 
									";
									$statement = $conn->prepare($updateQ);
									$statement->execute([1, $flierid]);
								}
						    } else {
						    	$_SESSION['flash_error'] = 'Could not find Flier.';
						    	redirect(PROOT . 'adminvonna/Print-Job?pj=flier');
						    }
					?>
						<h3 class="my-4">Flier view</h3>
	                    <p class="text-muted">
	                        <?php 
	                         	$outputflier_file = '';
                                if ($flier[0]['flier_design_file'] != '') {
                                    // code...
                                    $flier_files = explode(',', $flier[0]['flier_design_file']);
                                    foreach ($flier_files as $flier_file) 
                                        $outputflier_file .= '<a href="' . PROOT . 'account/' . $flier_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                }

	                            if ($flier[0]['flier_status'] == 0) {
	                                echo '<span class="badge bg-danger h6 text-uppercase">Pending</span>';
	                            } elseif ($flier[0]['flier_status'] == 1) {
	                                echo '<span class="badge bg-warning h6 text-uppercase">Processing</span>';
	                            } elseif ($flier[0]['flier_status'] == 2) {
	                                echo '<span class="badge bg-info h6 text-uppercase">Paid</span>';
	                            } elseif ($flier[0]['flier_status'] == 3) {
	                                echo '<span class="badge bg-success h6 text-uppercase">Ordered</span>';
	                            }
	                        ?>
	                    </p>
	                        
	                    <ul class="list-group">
	                        <li class="list-group-item"><span class="fw-bold text-info">What size do you want to print?</span> <?= $flier[0]['flier_size_to_print']; ?></li>
                            <li class="list-group-item"><span class="fw-bold text-info">what quantity do you want to print?</span> <?= $flier[0]['flier_quantity_to_print']; ?></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Do you have your design(s) already?</span> <?= $flier[0]['flier_have_designs']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">If NO, Do you want us to design your flier for you?</span> <?= $flier[0]['flier_us_to_design']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">If yes What occasion are you designing the flier for?</span> <?= $flier[0]['flier_for']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Upload your design(s) here:</span> <?= $outputflier_file; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">When do you want the job delivered?</span> <?= $flier[0]['flier_date_to_deliver']; ?></a></li>
	                        <button type="button" class="list-group-item list-group-item-action fw-bold text-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Customer: <?= ucwords($flier[0]['user_fullname']); ?></button>
					    	<div class="collapse" id="collapseExample">
							  	<div class="card card-body">
							    	<ul class="list-group">
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Email
										    <span class="badge bg-primary rounded-pill"><?= $flier[0]['user_email']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Phone
										    <span class="badge bg-primary rounded-pill"><?= $flier[0]['user_phone']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Occupation
										    <span class="badge bg-primary rounded-pill"><?= $flier[0]['user_occupation']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Name of instituition
										    <span class="badge bg-primary rounded-pill"><?= $flier[0]['user_name_of_instituition']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Postal Address
										    <span class="badge bg-primary rounded-pill"><?= $flier[0]['user_postal_address']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Pysical Address
										    <span class="badge bg-primary rounded-pill"><?= $flier[0]['user_physical_address']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Size of instituition
										    <span class="badge bg-primary rounded-pill"><?= $flier[0]['user_size_of_instituition']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Country
										    <span class="badge bg-primary rounded-pill"><?= $flier[0]['user_country']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    State/Region
										    <span class="badge bg-primary rounded-pill"><?= $flier[0]['user_state']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    City
										    <span class="badge bg-primary rounded-pill"><?= $flier[0]['user_city']; ?></span>
										</li>
									</ul>
							  	</div>
							</div>
	                        <li class="list-group-item"><span class="fw-bold text-info">Date: </span> <?= pretty_date($flier[0]['flier_createdAt']); ?></li>
	                    </ul>
	                    <form action="" class="mt-3">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="flierPaidSwitch" <?= (($flier[0]['flier_status'] == 2 || $flier[0]['flier_status'] == 3) ? 'checked' : ''); ?> name="paid">
								<label class="form-check-label" for="flierPaidSwitch">Paid</label>
							</div>
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="flierOrderedSwitch" <?= (($flier[0]['flier_status'] == 3) ? 'checked' : ''); ?> name="ordered" value="<?= (($flier[0]['flier_status'] == 2) ? 3 : 1); ?>">
								<label class="form-check-label" for="flierOrderedSwitch">Ordered</label>
							</div>
							<input type="hidden" id="orderId" value="<?= $flier[0]['flier_id']; ?>">						
							<input type="hidden" id="id" value="<?= $flier[0]['id']; ?>">						
						</form>
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
						    	if ($banner[0]['banner_status'] == 0) {
							    	$updateQ = "
										UPDATE vonna_printjob_banners 
										SET banner_status = ? 
										WHERE banner_id = ? 
									";
									$statement = $conn->prepare($updateQ);
									$statement->execute([1, $bannerid]);
								}
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
	                                        $outputbanner_file .= '<a href="' . PROOT . 'account/' . $banner_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
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
	                       
					<?php 
						elseif ($_GET['view'] == 'receipt'): 
							$receiptid = $_GET['id'];
							$queryReceipt = "
						        SELECT * FROM vonna_print_job_receipt 
						        INNER JOIN vonna_user 
						        ON vonna_user.user_id = vonna_print_job_receipt.receipt_userid 
						        WHERE vonna_print_job_receipt.receipt_id = ?
						        ORDER BY id DESC
						    ";
						    $statement = $conn->prepare($queryReceipt);
						    $statement->execute([$receiptid]);
						    $count_receipts = $statement->rowCount();
						    $receipt = $statement->fetchAll();
						    if ($count_receipts > 0) {
						    	if ($receipt[0]['receipt_status'] == 0) {
							    	$updateQ = "
										UPDATE vonna_print_job_receipt 
										SET receipt_status = ? 
										WHERE receipt_id = ? 
									";
									$statement = $conn->prepare($updateQ);
									$statement->execute([1, $receiptid]);
								}
						    } else {
						    	$_SESSION['flash_error'] = 'Could not find Receipt Book.';
						    	redirect(PROOT . 'adminvonna/Print-Job?pj=receipt');
						    }
					?>
					<h3 class="my-4">Receipt Book view</h3>
	                    <p class="text-muted">
	                        <?php 
	                         	$outputreceipt_logo = '';
                                if ($receipt[0]['receipt_upload_logo'] != '') {
                                    // code...
                                    $receipt_logos = explode(',', $receipt[0]['receipt_upload_logo']);
                                    foreach ($receipt_logos as $receipt_logo) 
                                        $outputreceipt_logo .= '<a href="' . PROOT . 'account/' . $receipt_logo.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                }

                                $outputreceipt_file = '';
                                if ($receipt[0]['receipt_upload_outfit_design'] != '') {
                                    // code...
                                    $receipt_files = explode(',', $receipt[0]['receipt_upload_outfit_design']);
                                    foreach ($receipt_files as $receipt_file) 
                                        $outputreceipt_file .= '<a href="' . PROOT . 'account/' . $receipt_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                }

	                            if ($receipt[0]['receipt_status'] == 0) {
	                                echo '<span class="badge bg-danger h6 text-uppercase">Pending</span>';
	                            } elseif ($receipt[0]['receipt_status'] == 1) {
	                                echo '<span class="badge bg-warning h6 text-uppercase">Processing</span>';
	                            } elseif ($receipt[0]['receipt_status'] == 2) {
	                                echo '<span class="badge bg-info h6 text-uppercase">Paid</span>';
	                            } elseif ($receipt[0]['receipt_status'] == 3) {
	                                echo '<span class="badge bg-success h6 text-uppercase">Ordered</span>';
	                            }
	                        ?>
	                    </p>
	                        
	                    <ul class="list-group">
	                        <li class="list-group-item"><span class="fw-bold text-info">what is the name of your outfit?</span> <?= $receipt[0]['receipt_outfit_name']; ?></li>
                            <li class="list-group-item"><span class="fw-bold text-info">what type of receipt book do you want?</span> <?= $receipt[0]['receipt_type']; ?></li>
                            <li class="list-group-item"><span class="fw-bold text-info">if Customized,Do you have a logo for your company?</span> <?= $receipt[0]['receipt_want_logo']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">if yes, upload your logo here:</span> <?= $outputreceipt_logo; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">How many receipt books do you want?</span> <?= $receipt[0]['receipt_quantity']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">When do you want the receipt books delivered?</span> <?= $receipt[0]['receipt_delivery_date']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Upload the design of your outfit for the design:</span> <?= $outputreceipt_file; ?></a></li>
	                        <button type="button" class="list-group-item list-group-item-action fw-bold text-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Customer: <?= ucwords($receipt[0]['user_fullname']); ?></button>
					    	<div class="collapse" id="collapseExample">
							  	<div class="card card-body">
							    	<ul class="list-group">
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Email
										    <span class="badge bg-primary rounded-pill"><?= $receipt[0]['user_email']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Phone
										    <span class="badge bg-primary rounded-pill"><?= $receipt[0]['user_phone']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Occupation
										    <span class="badge bg-primary rounded-pill"><?= $receipt[0]['user_occupation']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Name of instituition
										    <span class="badge bg-primary rounded-pill"><?= $receipt[0]['user_name_of_instituition']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Postal Address
										    <span class="badge bg-primary rounded-pill"><?= $receipt[0]['user_postal_address']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Pysical Address
										    <span class="badge bg-primary rounded-pill"><?= $receipt[0]['user_physical_address']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Size of instituition
										    <span class="badge bg-primary rounded-pill"><?= $receipt[0]['user_size_of_instituition']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Country
										    <span class="badge bg-primary rounded-pill"><?= $receipt[0]['user_country']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    State/Region
										    <span class="badge bg-primary rounded-pill"><?= $receipt[0]['user_state']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    City
										    <span class="badge bg-primary rounded-pill"><?= $receipt[0]['user_city']; ?></span>
										</li>
									</ul>
							  	</div>
							</div>
	                        <li class="list-group-item"><span class="fw-bold text-info">Date: </span> <?= pretty_date($receipt[0]['receipt_createdAt']); ?></li>
	                    </ul>
	                    <form action="" class="mt-3">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="receiptPaidSwitch" <?= (($receipt[0]['receipt_status'] == 2 || $receipt[0]['receipt_status'] == 3) ? 'checked' : ''); ?> name="paid">
								<label class="form-check-label" for="receiptPaidSwitch">Paid</label>
							</div>
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="receiptOrderedSwitch" <?= (($receipt[0]['receipt_status'] == 3) ? 'checked' : ''); ?> name="ordered" value="<?= (($receipt[0]['receipt_status'] == 2) ? 3 : 1); ?>">
								<label class="form-check-label" for="receiptOrderedSwitch">Ordered</label>
							</div>
							<input type="hidden" id="orderId" value="<?= $receipt[0]['receipt_id']; ?>">						
							<input type="hidden" id="id" value="<?= $receipt[0]['id']; ?>">						
						</form>

					<?php 
						elseif ($_GET['view'] == 'customize'): 
							$customizeid = $_GET['id'];
							$queryCustomize = "
						        SELECT * FROM vonna_print_job_customze 
						        INNER JOIN vonna_user 
						        ON vonna_user.user_id = vonna_print_job_customze.customze_userid 
						        WHERE vonna_print_job_customze.customze_id = ?
						        ORDER BY id DESC
						    ";
						    $statement = $conn->prepare($queryCustomize);
						    $statement->execute([$customizeid]);
						    $count_cutomizes = $statement->rowCount();
						    $customize = $statement->fetchAll();
						    if ($count_cutomizes > 0) {
						    	if ($customize[0]['customze_status'] == 0) {
							    	$updateQ = "
										UPDATE vonna_print_job_customze 
										SET customze_status = ? 
										WHERE customze_id = ? 
									";
									$statement = $conn->prepare($updateQ);
									$statement->execute([1, $customizeid]);
								}
						    } else {
						    	$_SESSION['flash_error'] = 'Could not find Customized office Files.';
						    	redirect(PROOT . 'adminvonna/Print-Job?pj=customize');
						    }
					?>
						<h3 class="my-4">Customized office Files view</h3>
	                    <p class="text-muted">
	                        <?php 
                                $outputcustomize_logo = '';
                                if ($customize[0]['customize_upload_logo'] != '') {
                                    // code...
                                    $customize_logos = explode(',', $customize[0]['customize_upload_logo']);
                                    foreach ($customize_logos as $customize_logo) 
                                        $outputcustomize_logo .= '<a href="' . PROOT . 'account/' . $customize_logo.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                }

	                            if ($customize[0]['customze_status'] == 0) {
	                                echo '<span class="badge bg-danger h6 text-uppercase">Pending</span>';
	                            } elseif ($customize[0]['customze_status'] == 1) {
	                                echo '<span class="badge bg-warning h6 text-uppercase">Processing</span>';
	                            } elseif ($customize[0]['customze_status'] == 2) {
	                                echo '<span class="badge bg-info h6 text-uppercase">Paid</span>';
	                            } elseif ($customize[0]['customze_status'] == 3) {
	                                echo '<span class="badge bg-success h6 text-uppercase">Ordered</span>';
	                            }
	                        ?>
	                    </p>
	                        
	                    <ul class="list-group">
	                        <li class="list-group-item"><span class="fw-bold text-info">What is the name of your outfit?</span> <?= $customize[0]['customize_outfit_name']; ?></li>
                            <li class="list-group-item"><span class="fw-bold text-info">what is your the addresss of your outfit?</span> <?= $customize[0]['customize_outfit_address']; ?></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Contact:</span> <?= $customize[0]['customize_contact']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Email:</span> <?= $customize[0]['customize_email']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Location:</span> <?= $customize[0]['customize_location']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">GPS address:</span> <?= $customize[0]['customize_gps']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Does your company have a logo?</span> <?= $customize[0]['customize_have_logo']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">if yes, upload your logo here:</span> <?= $outputcustomize_logo; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">If No, Do you want us to design a logo for your company?</span> <?= $customize[0]['customze_us_to_design_logo']; ?></a></li>
	                        <button type="button" class="list-group-item list-group-item-action fw-bold text-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Customer: <?= ucwords($customize[0]['user_fullname']); ?></button>
					    	<div class="collapse" id="collapseExample">
							  	<div class="card card-body">
							    	<ul class="list-group">
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Email
										    <span class="badge bg-primary rounded-pill"><?= $customize[0]['user_email']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Phone
										    <span class="badge bg-primary rounded-pill"><?= $customize[0]['user_phone']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Occupation
										    <span class="badge bg-primary rounded-pill"><?= $customize[0]['user_occupation']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Name of instituition
										    <span class="badge bg-primary rounded-pill"><?= $customize[0]['user_name_of_instituition']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Postal Address
										    <span class="badge bg-primary rounded-pill"><?= $customize[0]['user_postal_address']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Pysical Address
										    <span class="badge bg-primary rounded-pill"><?= $customize[0]['user_physical_address']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Size of instituition
										    <span class="badge bg-primary rounded-pill"><?= $customize[0]['user_size_of_instituition']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Country
										    <span class="badge bg-primary rounded-pill"><?= $customize[0]['user_country']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    State/Region
										    <span class="badge bg-primary rounded-pill"><?= $customize[0]['user_state']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    City
										    <span class="badge bg-primary rounded-pill"><?= $customize[0]['user_city']; ?></span>
										</li>
									</ul>
							  	</div>
							</div>
	                        <li class="list-group-item"><span class="fw-bold text-info">Date: </span> <?= pretty_date($customize[0]['customze_createdAt']); ?></li>
	                    </ul>
	                    <form action="" class="mt-3">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="customizePaidSwitch" <?= (($customize[0]['customze_status'] == 2 || $customize[0]['customze_status'] == 3) ? 'checked' : ''); ?> name="paid">
								<label class="form-check-label" for="customizePaidSwitch">Paid</label>
							</div>
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="customizeOrderedSwitch" <?= (($customize[0]['customze_status'] == 3) ? 'checked' : ''); ?> name="ordered" value="<?= (($customize[0]['customze_status'] == 2) ? 3 : 1); ?>">
								<label class="form-check-label" for="customizeOrderedSwitch">Ordered</label>
							</div>
							<input type="hidden" id="orderId" value="<?= $customize[0]['customze_id']; ?>">						
							<input type="hidden" id="id" value="<?= $customize[0]['id']; ?>">						
						</form>

					<?php 
						elseif ($_GET['view'] == 'card'): 
							$cardid = $_GET['id'];
							 $queryCallcards = "
						        SELECT * FROM vonna_printjob_callcards 
						        INNER JOIN vonna_user 
						        ON vonna_user.user_id = vonna_printjob_callcards.card_userid 
						        WHERE vonna_printjob_callcards.card_id = ?
						        ORDER BY id DESC
						    ";
						    $statement = $conn->prepare($queryCallcards);
						    $statement->execute([$cardid]);
						    $count_callcards = $statement->rowCount();
						    $callcard = $statement->fetchAll();
						    if ($count_callcards > 0) {
						    	if ($callcard[0]['card_status'] == 0) {
							    	$updateQ = "
										UPDATE vonna_printjob_callcards 
										SET card_status = ? 
										WHERE card_id = ? 
									";
									$statement = $conn->prepare($updateQ);
									$statement->execute([1, $cardid]);
								}
						    } else {
						    	$_SESSION['flash_error'] = 'Could not find Call card.';
						    	redirect(PROOT . 'adminvonna/Print-Job?pj=card');
						    }
					?>
					<h3 class="my-4">Customized office Files view</h3>
	                    <p class="text-muted">
	                        <?php 
                                $outputcard_file = '';
                                if ($callcard[0]['card_upload_logo'] != '') {
                                    // code...
                                    $card_files = explode(',', $callcard[0]['card_upload_logo']);
                                    foreach ($card_files as $card_file) 
                                        $outputcard_file .= '<a href="' . PROOT . 'account/' . $card_file.'"><img src="' . PROOT . 'account/media/file.png" class="img-fluid" width="70"></a>';
                                }

	                            if ($callcard[0]['card_status'] == 0) {
	                                echo '<span class="badge bg-danger h6 text-uppercase">Pending</span>';
	                            } elseif ($callcard[0]['card_status'] == 1) {
	                                echo '<span class="badge bg-warning h6 text-uppercase">Processing</span>';
	                            } elseif ($callcard[0]['card_status'] == 2) {
	                                echo '<span class="badge bg-info h6 text-uppercase">Paid</span>';
	                            } elseif ($callcard[0]['card_status'] == 3) {
	                                echo '<span class="badge bg-success h6 text-uppercase">Ordered</span>';
	                            }
	                        ?>
	                    </p>
	                        
	                    <ul class="list-group">
	                       <li class="list-group-item"><span class="fw-bold text-info">What is your name?</span> <?= $callcard[0]['card_name']; ?></li>
                            <li class="list-group-item"><span class="fw-bold text-info">What is the name of your company?</span> <?= $callcard[0]['card_company_name']; ?></li>
                            <li class="list-group-item"><span class="fw-bold text-info">what is your address?</span> <?= $callcard[0]['card_address']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">what is your email?</span> <?= $callcard[0]['card_email']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Facebook:</span> <?= $callcard[0]['card_facebook']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Instagram:</span> <?= $callcard[0]['card_instagram']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Twitter:</span> <?= $callcard[0]['card_twitter']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Tik tok:</span> <?= $callcard[0]['card_tiktok']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Office Contact:</span> <?= $callcard[0]['card_office_contact']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Personal Contact:</span> <?= $callcard[0]['card_whatsapp']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Whatsapp:</span> <?= $callcard[0]['card_personal_contact']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">Does your company have a logo?</span> <?= $callcard[0]['card_have_logo']; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">If yes , upload your company logo here:</span> <?= $outputcard_file; ?></a></li>
                            <li class="list-group-item"><span class="fw-bold text-info">If no,Do you want us to design a logo for you?</span> <?= $callcard[0]['card_us_to_design_logo']; ?></li>
	                        <button type="button" class="list-group-item list-group-item-action fw-bold text-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Customer: <?= ucwords($callcard[0]['user_fullname']); ?></button>
					    	<div class="collapse" id="collapseExample">
							  	<div class="card card-body">
							    	<ul class="list-group">
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Email
										    <span class="badge bg-primary rounded-pill"><?= $callcard[0]['user_email']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Phone
										    <span class="badge bg-primary rounded-pill"><?= $callcard[0]['user_phone']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Occupation
										    <span class="badge bg-primary rounded-pill"><?= $callcard[0]['user_occupation']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Name of instituition
										    <span class="badge bg-primary rounded-pill"><?= $callcard[0]['user_name_of_instituition']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Postal Address
										    <span class="badge bg-primary rounded-pill"><?= $callcard[0]['user_postal_address']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Pysical Address
										    <span class="badge bg-primary rounded-pill"><?= $callcard[0]['user_physical_address']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Size of instituition
										    <span class="badge bg-primary rounded-pill"><?= $callcard[0]['user_size_of_instituition']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    Country
										    <span class="badge bg-primary rounded-pill"><?= $callcard[0]['user_country']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    State/Region
										    <span class="badge bg-primary rounded-pill"><?= $callcard[0]['user_state']; ?></span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center">
										    City
										    <span class="badge bg-primary rounded-pill"><?= $callcard[0]['user_city']; ?></span>
										</li>
									</ul>
							  	</div>
							</div>
	                        <li class="list-group-item"><span class="fw-bold text-info">Date: </span> <?= pretty_date($callcard[0]['card_createdAt']); ?></li>
	                    </ul>
	                    <form action="" class="mt-3">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="cardPaidSwitch" <?= (($callcard[0]['card_status'] == 2 || $callcard[0]['card_status'] == 3) ? 'checked' : ''); ?> name="paid">
								<label class="form-check-label" for="cardPaidSwitch">Paid</label>
							</div>
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch" id="cardOrderedSwitch" <?= (($callcard[0]['card_status'] == 3) ? 'checked' : ''); ?> name="ordered" value="<?= (($callcard[0]['card_status'] == 2) ? 3 : 1); ?>">
								<label class="form-check-label" for="cardOrderedSwitch">Ordered</label>
							</div>
							<input type="hidden" id="orderId" value="<?= $callcard[0]['card_id']; ?>">						
							<input type="hidden" id="id" value="<?= $callcard[0]['id']; ?>">						
						</form>

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

            // THESIS
            $("#thesisPaidSwitch").change(function(event) {
            	event.preventDefault()
            	if (confirm('Are you sure')) 
	            	var paid = 1;
	            	var id = $('#orderId').val();
	            	
	            	if ($('#thesisPaidSwitch').is(":checked") == true) {
	            		paid = 2;
	            	}
	            	window.location = '<?= PROOT; ?>adminvonna/Print-Job-View?thesispaid='+paid+'&id='+id;
            });

            $("#thesisOrderedSwitch").change(function(event) {
            	event.preventDefault()
            	if (confirm('Are you sure')) 
	            	var ordered = 1;
	            	var id = $('#orderId').val();
	            	if ($('#thesisOrderedSwitch').is(":checked") == true) {
	            		ordered = 3
	            	}
	            	window.location = '<?= PROOT; ?>adminvonna/Print-Job-View?thesisordered='+ordered+'&id='+id;
            });

            // FLIER
            $("#flierPaidSwitch").change(function(event) {
            	event.preventDefault()
            	if (confirm('Are you sure')) 
	            	var paid = 1;
	            	var id = $('#orderId').val();
	            	
	            	if ($('#flierPaidSwitch').is(":checked") == true) {
	            		paid = 2;
	            	}
	            	window.location = '<?= PROOT; ?>adminvonna/Print-Job-View?flierpaid='+paid+'&id='+id;
            });

            $("#flierOrderedSwitch").change(function(event) {
            	event.preventDefault()
            	if (confirm('Are you sure')) 
	            	var ordered = 1;
	            	var id = $('#orderId').val();
	            	if ($('#flierOrderedSwitch').is(":checked") == true) {
	            		ordered = 3
	            	}
	            	window.location = '<?= PROOT; ?>adminvonna/Print-Job-View?flierordered='+ordered+'&id='+id;
            });

            // FLIER
            $("#receiptPaidSwitch").change(function(event) {
            	event.preventDefault()
            	if (confirm('Are you sure')) 
	            	var paid = 1;
	            	var id = $('#orderId').val();
	            	
	            	if ($('#receiptPaidSwitch').is(":checked") == true) {
	            		paid = 2;
	            	}
	            	window.location = '<?= PROOT; ?>adminvonna/Print-Job-View?receiptpaid='+paid+'&id='+id;
            });

            $("#receiptOrderedSwitch").change(function(event) {
            	event.preventDefault()
            	if (confirm('Are you sure')) 
	            	var ordered = 1;
	            	var id = $('#orderId').val();
	            	if ($('#receiptOrderedSwitch').is(":checked") == true) {
	            		ordered = 3
	            	}
	            	window.location = '<?= PROOT; ?>adminvonna/Print-Job-View?receiptordered='+ordered+'&id='+id;
            });

            // CUSTOMIZED OFFICE FILES
            $("#customizePaidSwitch").change(function(event) {
            	event.preventDefault()
            	if (confirm('Are you sure')) 
	            	var paid = 1;
	            	var id = $('#orderId').val();
	            	
	            	if ($('#customizePaidSwitch').is(":checked") == true) {
	            		paid = 2;
	            	}
	            	window.location = '<?= PROOT; ?>adminvonna/Print-Job-View?customizepaid='+paid+'&id='+id;
            });

            $("#customizeOrderedSwitch").change(function(event) {
            	event.preventDefault()
            	if (confirm('Are you sure')) 
	            	var ordered = 1;
	            	var id = $('#orderId').val();
	            	if ($('#customizeOrderedSwitch').is(":checked") == true) {
	            		ordered = 3
	            	}
	            	window.location = '<?= PROOT; ?>adminvonna/Print-Job-View?customizeordered='+ordered+'&id='+id;
            });

            // CALL CARDS
            $("#cardPaidSwitch").change(function(event) {
            	event.preventDefault()
            	if (confirm('Are you sure')) 
	            	var paid = 1;
	            	var id = $('#orderId').val();
	            	
	            	if ($('#cardPaidSwitch').is(":checked") == true) {
	            		paid = 2;
	            	}
	            	window.location = '<?= PROOT; ?>adminvonna/Print-Job-View?cardpaid='+paid+'&id='+id;
            });

            $("#cardOrderedSwitch").change(function(event) {
            	event.preventDefault()
            	if (confirm('Are you sure')) 
	            	var ordered = 1;
	            	var id = $('#orderId').val();
	            	if ($('#cardOrderedSwitch').is(":checked") == true) {
	            		ordered = 3
	            	}
	            	window.location = '<?= PROOT; ?>adminvonna/Print-Job-View?cardordered='+ordered+'&id='+id;
            });
        })
    </script>

</body>
</html>