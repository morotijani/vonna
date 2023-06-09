<?php 
    // INDEX PAGE
    // 
    require_once ('./../db_connection/conn.php');
    if (!admin_is_logged_in()) {
        admin_login_redirect();
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADMIN . VONNA</title>
    <link rel="stylesheet" href="<?= PROOT; ?>assets/css/bootstrap.min.css">

    <style>
		.icon {
		  width: 3rem;
		  height: 3rem;
		}

		.icon i {
		  font-size: 2.25rem;
		}

		.icon-shape {
		  display: inline-flex;
		  padding: 12px;
		  text-align: center;
		  border-radius: 50%;
		  align-items: center;
		  justify-content: center;
		}

		.icon-shape i {
		  font-size: 1.25rem;
		}

    </style>
</head>
<body>
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
					      <h4>Statistics</h4>
					    </div>
					</div>
				</nav>

			    <div class="header-body mt-5">
		          	<div class="row">
		            	<div class="col-xl-4 col-lg-6 mb-4 mb-xl-0">
		              		<div class="card card-stats">
		                		<div class="card-body">
				                  	<div class="row">
				                    	<div class="col">
				                      		<h5 class="card-title text-uppercase text-muted mb-0">All order</h5>
				                      		<span class="h2 font-weight-bold mb-0"><?= $conn->query("SELECT * FROM vonna_orders")->rowCount(); ?></span>
				                    	</div>
				                    	<div class="col-auto">
				                      		<div class="icon icon-shape bg-warning text-white rounded-circle shadow">
				                        		<i data-feather="shopping-cart"></i>
				                      		</div>
				                    	</div>
				                  	</div>
					                <p class="mt-3 mb-0 text-muted text-sm">
					                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= date('Y-m-d'); ?></span>
					                    <span class="text-nowrap"><?= date('F'); ?></span>
					                </p>
					            </div>
					        </div>
            			</div>
            			<div class="col-xl-4 col-lg-6 mb-4 mb-xl-0">
		              		<div class="card card-stats">
		                		<div class="card-body">
				                  	<div class="row">
				                    	<div class="col">
				                      		<h5 class="card-title text-uppercase text-muted mb-0">Customers</h5>
				                      		<span class="h2 font-weight-bold mb-0"><?= $conn->query("SELECT * FROM vonna_user")->rowCount(); ?></span>
				                    	</div>
				                    	<div class="col-auto">
				                      		<div class="icon icon-shape bg-success text-white rounded-circle shadow">
				                        		<i data-feather="users"></i>
				                      		</div>
				                    	</div>
				                  	</div>
					                <p class="mt-3 mb-0 text-muted text-sm">
					                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= date('Y-m-d'); ?></span>
					                    <span class="text-nowrap"><?= date('F'); ?></span>
					                </p>
					            </div>
					        </div>
            			</div>
            			<div class="col-xl-4 col-lg-6 mb-4 mb-xl-0">
		              		<div class="card card-stats">
		                		<div class="card-body">
				                  	<div class="row">
				                    	<div class="col">
				                      		<h5 class="card-title text-uppercase text-muted mb-0">Contacts</h5>
				                      		<span class="h2 font-weight-bold mb-0"><?= $conn->query("SELECT * FROM vonna_contact")->rowCount(); ?></span>
				                    	</div>
				                    	<div class="col-auto">
				                      		<div class="icon icon-shape bg-info text-white rounded-circle shadow">
				                        		<i data-feather="mail"></i>
				                      		</div>
				                    	</div>
				                  	</div>
					                <p class="mt-3 mb-0 text-muted text-sm">
					                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= date('Y-m-d'); ?></span>
					                    <span class="text-nowrap"><?= date('F'); ?></span>
					                </p>
					            </div>
					        </div>
            			</div>
            			<div class="col-xl-4 col-lg-6 mt-4 mb-xl-0">
		              		<div class="card card-stats">
		                		<div class="card-body">
				                  	<div class="row">
				                    	<div class="col">
				                      		<h5 class="card-title text-uppercase text-muted mb-0">EXAMINATION QUESTIONS</h5>
				                      		<span class="h2 font-weight-bold mb-0"><?= $conn->query("SELECT * FROM vonna_printjob")->rowCount(); ?></span>
				                    	</div>
				                    	<div class="col-auto">
				                      		<div class="icon icon-shape bg-success text-white rounded-circle shadow">
				                        		<i data-feather="file"></i>
				                      		</div>
				                    	</div>
				                  	</div>
					                <p class="mt-3 mb-0 text-muted text-sm">
					                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= date('Y-m-d'); ?></span>
					                    <span class="text-nowrap"><?= date('F'); ?></span>
					                </p>
					            </div>
					        </div>
            			</div>
            			<div class="col-xl-4 col-lg-6 mt-4 mb-xl-0">
		              		<div class="card card-stats">
		                		<div class="card-body">
				                  	<div class="row">
				                    	<div class="col">
				                      		<h5 class="card-title text-uppercase text-muted mb-0">THESIS/RESEARCH</h5>
				                      		<span class="h2 font-weight-bold mb-0"><?= $conn->query("SELECT * FROM vonna_printjob_thesis")->rowCount(); ?></span>
				                    	</div>
				                    	<div class="col-auto">
				                      		<div class="icon icon-shape bg-danger text-white rounded-circle shadow">
				                        		<i data-feather="book"></i>
				                      		</div>
				                    	</div>
				                  	</div>
					                <p class="mt-3 mb-0 text-muted text-sm">
					                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= date('Y-m-d'); ?></span>
					                    <span class="text-nowrap"><?= date('F'); ?></span>
					                </p>
					            </div>
					        </div>
            			</div>
            			<div class="col-xl-4 col-lg-6 mt-4 mb-xl-0">
		              		<div class="card card-stats">
		                		<div class="card-body">
				                  	<div class="row">
				                    	<div class="col">
				                      		<h5 class="card-title text-uppercase text-muted mb-0">FLIERS</h5>
				                      		<span class="h2 font-weight-bold mb-0"><?= $conn->query("SELECT * FROM vonna_printjob_fliers")->rowCount(); ?></span>
				                    	</div>
				                    	<div class="col-auto">
				                      		<div class="icon icon-shape bg-primary text-white rounded-circle shadow">
				                        		<i data-feather="square"></i>
				                      		</div>
				                    	</div>
				                  	</div>
					                <p class="mt-3 mb-0 text-muted text-sm">
					                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= date('Y-m-d'); ?></span>
					                    <span class="text-nowrap"><?= date('F'); ?></span>
					                </p>
					            </div>
					        </div>
            			</div>
            			<div class="col-xl-4 col-lg-6 mt-4 mb-xl-0">
		              		<div class="card card-stats">
		                		<div class="card-body">
				                  	<div class="row">
				                    	<div class="col">
				                      		<h5 class="card-title text-uppercase text-muted mb-0">BANNERS</h5>
				                      		<span class="h2 font-weight-bold mb-0"><?= $conn->query("SELECT * FROM vonna_printjob_banners")->rowCount(); ?></span>
				                    	</div>
				                    	<div class="col-auto">
				                      		<div class="icon icon-shape bg-secondary text-white rounded-circle shadow">
				                        		<i data-feather="target"></i>
				                      		</div>
				                    	</div>
				                  	</div>
					                <p class="mt-3 mb-0 text-muted text-sm">
					                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= date('Y-m-d'); ?></span>
					                    <span class="text-nowrap"><?= date('F'); ?></span>
					                </p>
					            </div>
					        </div>
            			</div>
            			<div class="col-xl-4 col-lg-6 mt-4 mb-xl-0">
		              		<div class="card card-stats">
		                		<div class="card-body">
				                  	<div class="row">
				                    	<div class="col">
				                      		<h5 class="card-title text-uppercase text-muted mb-0">RECEIPT BOOKS</h5>
				                      		<span class="h2 font-weight-bold mb-0"><?= $conn->query("SELECT * FROM vonna_print_job_receipt")->rowCount(); ?></span>
				                    	</div>
				                    	<div class="col-auto">
				                      		<div class="icon icon-shape bg-dark text-white rounded-circle shadow">
				                        		<i data-feather="table"></i>
				                      		</div>
				                    	</div>
				                  	</div>
					                <p class="mt-3 mb-0 text-muted text-sm">
					                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= date('Y-m-d'); ?></span>
					                    <span class="text-nowrap"><?= date('F'); ?></span>
					                </p>
					            </div>
					        </div>
            			</div>
            			<div class="col-xl-4 col-lg-6 mt-4 mb-xl-0">
		              		<div class="card card-stats">
		                		<div class="card-body">
				                  	<div class="row">
				                    	<div class="col">
				                      		<h5 class="card-title text-uppercase text-muted mb-0">Invoice</h5>
				                      		<span class="h2 font-weight-bold mb-0"><?= $conn->query("SELECT * FROM vonna_print_job_invoice")->rowCount(); ?></span>
				                    	</div>
				                    	<div class="col-auto">
				                      		<div class="icon icon-shape bg-info text-white rounded-circle shadow">
				                        		<i data-feather="table"></i>
				                      		</div>
				                    	</div>
				                  	</div>
					                <p class="mt-3 mb-0 text-muted text-sm">
					                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= date('Y-m-d'); ?></span>
					                    <span class="text-nowrap"><?= date('F'); ?></span>
					                </p>
					            </div>
					        </div>
            			</div>
            			<div class="col-xl-4 col-lg-6 mt-4 mb-xl-0">
		              		<div class="card card-stats">
		                		<div class="card-body">
				                  	<div class="row">
				                    	<div class="col">
				                      		<h5 class="card-title text-uppercase text-muted mb-0">CUSTOMIZES OFFICE FILES</h5>
				                      		<span class="h2 font-weight-bold mb-0"><?= $conn->query("SELECT * FROM vonna_print_job_customze")->rowCount(); ?></span>
				                    	</div>
				                    	<div class="col-auto">
				                      		<div class="icon icon-shape bg-warning text-white rounded-circle shadow">
				                        		<i data-feather="globe"></i>
				                      		</div>
				                    	</div>
				                  	</div>
					                <p class="mt-3 mb-0 text-muted text-sm">
					                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= date('Y-m-d'); ?></span>
					                    <span class="text-nowrap"><?= date('F'); ?></span>
					                </p>
					            </div>
					        </div>
            			</div>
            			<div class="col-xl-4 col-lg-6 mt-4 mb-xl-0">
		              		<div class="card card-stats">
		                		<div class="card-body">
				                  	<div class="row">
				                    	<div class="col">
				                      		<h5 class="card-title text-uppercase text-muted mb-0">CALL CARDS</h5>
				                      		<span class="h2 font-weight-bold mb-0"><?= $conn->query("SELECT * FROM vonna_printjob_callcards")->rowCount(); ?></span>
				                    	</div>
				                    	<div class="col-auto">
				                      		<div class="icon icon-shape bg-danger text-white rounded-circle shadow">
				                        		<i data-feather="phone"></i>
				                      		</div>
				                    	</div>
				                  	</div>
					                <p class="mt-3 mb-0 text-muted text-sm">
					                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= date('Y-m-d'); ?></span>
					                    <span class="text-nowrap"><?= date('F'); ?></span>
					                </p>
					            </div>
					        </div>
            			</div>
            			<div class="col-xl-4 col-lg-6 mt-4 mb-xl-0">
		              		<div class="card card-stats">
		                		<div class="card-body">
				                  	<div class="row">
				                    	<div class="col">
				                      		<h5 class="card-title text-uppercase text-muted mb-0">TEXT BOOKS</h5>
				                      		<span class="h2 font-weight-bold mb-0"><?= $conn->query("SELECT * FROM vonna_textbooks")->rowCount(); ?></span>
				                    	</div>
				                    	<div class="col-auto">
				                      		<div class="icon icon-shape bg-primary text-white rounded-circle shadow">
				                        		<i data-feather="book"></i>
				                      		</div>
				                    	</div>
				                  	</div>
					                <p class="mt-3 mb-0 text-muted text-sm">
					                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= date('Y-m-d'); ?></span>
					                    <span class="text-nowrap"><?= date('F'); ?></span>
					                </p>
					            </div>
					        </div>
            			</div>

			        </div>
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