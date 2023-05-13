<?php 
    // PRODUCTS PAGE

    require_once ('db_connection/conn.php');

    include ('inc/header.inc.php');
    $nav_bg = '';
    include ('inc/nav.inc.php');
?>

    <!-- CONTENT -->
    <section class="pt-6 pt-md-11 pb-10 pb-md-12">
        <div class="container-lg">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <h6 class="text-uppercase text-warning text-center mb-5">
                        Vonna
                    </h6>
                    <h1 class="display-3 text-center mb-4">
                        About Us
                    </h1>
                    <p class="fs-lg text-center text-muted mb-0">
                        We work hard to keep all our legal mumbo jumbo as simple as possible, but we still have to have it.
                    </p>
                    <hr class="hr-sm bg-warning mx-auto my-10 my-md-12">
                    <h2 class="mb-4 font-sans-serif">
                        Vonna Ghana
                    </h2>
                    <p class="mb-6">
                      <?= nl2br($about_info); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

<?php include ('inc/footer.inc.php'); ?>
