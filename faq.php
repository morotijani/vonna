<?php 

// HOME PAGE

require_once ('db_connection/conn.php');

include ('inc/header.inc.php');
$nav_bg = '';
include ('inc/nav.inc.php');

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
                  		<div class="list-group-item">
                    		<a class="collapse-toggle fs-lg fw-bold text-decoration-none text-reset" data-bs-toggle="collapse" href="#faqOne" role="button" aria-expanded="true" aria-controls="faqOne">
                      			What is Vonna About?
                    		</a>
                    		<div class="collapse show" id="faqOne" data-bs-parent="#faq">
                      			<p class="mt-2 mb-0">
                        			Vonna is legally registered Enterprise which serves as a vehicle to adequately distribute comfort and satisfaction to Offices and Institutions when it comes to the need for Paper.
                      			</p>
                    		</div>
                  		</div>
		                <div class="list-group-item">
		                    <a class="collapse-toggle fs-lg fw-bold text-decoration-none text-reset" data-bs-toggle="collapse" href="#faqTwo" role="button" aria-expanded="false" aria-controls="faqTwo">
		                     	Does Vonna work with any paper mill factories?
		                    </a>
		                    <div class="collapse" id="faqTwo" data-bs-parent="#faq">
		                      	<p class="mt-2 mb-0">
		                        	Yes. We work in conjunction with paper Mill Factories to make various sizes of paper available at factory prices.
		                     	</p>
		                    </div>
		                </div>
		                <div class="list-group-item">
		                    <a class="collapse-toggle fs-lg fw-bold text-decoration-none text-reset" data-bs-toggle="collapse" href="#faqThree" role="button" aria-expanded="false" aria-controls="faqThree">
	                      		Their supplies
	                    	</a>
	                    	<div class="collapse" id="faqThree" data-bs-parent="#faq">
	                      		<p class="mt-2 mb-0">
	                        		Our Company is built to handle large supplies to Institutions such as Schools, Corporation as well as Enterprises who require the use of various forms of paper products.
	                      		</p>
	                    	</div>
		                </div>
		                <div class="list-group-item">
		                    <a class="collapse-toggle fs-lg fw-bold text-decoration-none text-reset" data-bs-toggle="collapse" href="#faqFour" role="button" aria-expanded="false" aria-controls="faqFour">
		                      	How to make an order?
		                    </a>
		                    <div class="collapse" id="faqFour" data-bs-parent="#faq">
		                      	<p class="mt-2 mb-0">
		                        	Create and verify account, after log into your account and start making orders.  
		                      	</p>
		                    </div>
                  		</div>
		                <div class="list-group-item">
		                    <a class="collapse-toggle fs-lg fw-bold text-decoration-none text-reset" data-bs-toggle="collapse" href="#faqFive" role="button" aria-expanded="false" aria-controls="faqFive">
		                      	How to purchase product?
		                    </a>
		                    <div class="collapse" id="faqFive" data-bs-parent="#faq">
		                      	<p class="mt-2 mb-0">
		                        	After a product order, you will make payment after delivery or before delivery either cash or digital. 
		                      	</p>
		                    </div>
                  		</div>
                	</div>
                </div>
    		</div>
		</div>
	</section>

<?php include ('inc/footer.inc.php'); ?>