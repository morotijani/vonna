<?php 

// HOME PAGE

require_once ('db_connection/conn.php');

include ('inc/header.inc.php');
$nav_bg = '';
include ('inc/nav.inc.php');

$rows = $conn->query('SELECT * FROM vonna_faq')->fetchAll();
?>


	<!-- WELCOME -->
    <section class="pt-6 pt-md-11">
      	<div class="container-lg">
        	<div class="row justify-content-center">
          		<div class="col-md-10 col-lg-9 text-center">
            		<h6 class="text-uppercase text-primary mb-5">
              			FAQ
            		</h6>
            		<h2 class="display-3 mb-4">
              			Frequently Asked Questions
            		</h2>
            		<p class="fs-lg text-muted">
              			You have any question, scroll down to find answers to your queries.
            		</p>
          		</div>
        	</div>
      	</div>
    </section>

	<!-- CONTENT -->
    <section class="pt-10 pt-md-12 mb-10">
      	<div class="container-lg">
        	<div class="row">
          		<div class="col">
            		<hr class="hr-sm bg-warning mx-auto mb-10 mb-md-12">
          		</div>
        	</div>
        	<div class="card rounded-top-start-3 rounded-bottom-end-3" style="z-index: 1;">
              	<div class="card-body">
                	<div class="list-group list-group-lg list-group-flush my-n7" id="faq">
                		<?php foreach ($rows as $row): ?>
	                  		<div class="list-group-item">
	                    		<a class="collapse-toggle fs-lg fw-bold text-decoration-none text-reset" data-bs-toggle="collapse" href="#faq<?= $row['id']; ?>" role="button" aria-expanded="true" aria-controls="faq<?= $row['id']; ?>">
	                      			<?= $row['faq_head']; ?>
	                    		</a>
	                    		<div class="collapse" id="faq<?= $row['id']; ?>" data-bs-parent="#faq">
	                      			<p class="mt-2 mb-0">
	                        			<?= nl2br($row['faq_body']); ?>
	                      			</p>
	                    		</div>
	                  		</div>
                		<?php endforeach; ?>
                	</div>
                </div>
    		</div>
		</div>
	</section>

<?php include ('inc/footer.inc.php'); ?>