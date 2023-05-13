<?php 

// HOME PAGE

require_once ('db_connection/conn.php');

include ('inc/header.inc.php');
$nav_bg = 'bg-light';
include ('inc/nav.inc.php');

?>
    <section class="pt-6 pt-md-8 pb-8 pb-md-9 bg-light">
        <div class="container-lg">
            <div class="row align-items-center">
                <div class="col-md-9 offset-md-n3 order-md-1">
                    <img class="img-fluid mw-md-125 mb-8 mb-md-0" src="assets/media/illustration-1.png" alt="..." data-aos="fade-up" data-aos-delay="100">
                </div>
                <div class="col-md-6 order-md-0 text-center text-md-start" data-aos="fade-up">
                    <h1 class="display-3 mb-4">
                        Need for paper. <br /> Use
                        <span class="text-primary-light">Vonna.</span>
                    </h1>
                    <p class="fs-lg">
                        Distribute comfort and satisfaction to Offices and Institutions when it comes to the need for Paper. 
                    </p>
                    <a class="btn btn-primary-light lift" href="<?= PROOT; ?>auth/signup">
                        Get Started
                    </a>
                    <a class="btn btn-white lift ms-3" href="<?= PROOT; ?>account/index">
                        Make an Order
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SHAPE -->
    <div class="position-relative">
        <div class="shape shape-fluid-x shape-bottom text-light pb-15 pb-md-4">
            <div class="shape-img pb-9 pb-md-15">
                <svg viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0 0h100v25H75L25 50H0z" fill="currentColor"/></svg>        </div>
        </div>
    </div>

    <!-- ABOUT -->
    <section class="pt-10 pt-md-12">
        <div class="container-lg">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-5">
                    <img src="<?= PROOT; ?>assets/media/illustration-9.png" class="img-fluid" alt="">
                </div>
                <div class="col-md-6 col-xl-5 text-center text-md-start">
                    <h2 class="display-4 mb-4">
                        No need to worry about your papers
                    </h2>
                    <p class="text-muted mb-4">
                        We work in conjunction with paper Mill Factories to make various sizes of paper available at factory prices.
                    </p>
                    <p class="text-muted mb-0">
                        Our Company is built to handle large supplies to Institutions such as Schools, Corporation as well as Enterprises who require the use of various forms of paper products.
                    </p>
                </div>
            </div>
        </div>
    </section>


    <!-- ABOUT -->
    <section class="py-10 py-md-12">
        <div class="container-lg">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6 order-md-1">
                    <img class="img-fluid mb-6 mb-md-0" src="<?= PROOT; ?>assets/media/illustration-4.png" alt="...">
                </div>
                <div class="col-md-6 col-xl-5 order-md-0 text-center text-md-start">
                    <h2 class="display-4 mb-6">
                        Anything, paper.
                    </h2>
                    <div class="row">
                        <div class="col-12 col-md-auto">
                            <div class="icon text-primary-light mb-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"/><path d="M6 9v6a3 3 0 003 3h6v.818C15 20.232 14.232 21 12.818 21H5.182C3.768 21 3 20.232 3 18.818v-7.636C3 9.768 3.768 9 5.182 9H6z" fill="#335EEA"/><path d="M10.182 4h7.636C19.232 4 20 4.768 20 6.182v7.636C20 15.232 19.232 16 17.818 16h-7.636C8.768 16 8 15.232 8 13.818V6.182C8 4.768 8.768 4 10.182 4z" fill="#335EEA" opacity=".3"/></g></svg>
                            </div>
                        </div>
                        <div class="col">
                            <p class="fs-lg fw-bold mb-2">
                                Paper
                            </p>
                            <p class="text-muted mb-5">
                                We work in conjunction with paper Mill Factories to make various sizes of paper available at factory prices.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-auto">
                            <div class="icon text-primary-light mb-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"/><path d="M4 4l7.631-1.43a2 2 0 01.738 0L20 4v9.283a8.51 8.51 0 01-4 7.217l-3.47 2.169a1 1 0 01-1.06 0L8 20.5a8.51 8.51 0 01-4-7.217V4z" fill="#335EEA" opacity=".3"/><path d="M11.175 14.75a.946.946 0 01-.67-.287l-1.917-1.917a.926.926 0 010-1.342c.383-.383 1.006-.383 1.341 0l1.246 1.246 3.163-3.162a.926.926 0 011.341 0 .926.926 0 010 1.341l-3.833 3.834a.946.946 0 01-.671.287z" fill="#335EEA"/></g></svg>
                            </div>
                        </div>
                        <div class="col">
                            <p class="fs-lg fw-bold mb-2">
                                Distribute comfort
                            </p>
                            <p class="text-muted mb-0">
                                Vonna is legally registered Enterprise which serves as a vehicle to adequately distribute comfort and satisfaction.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- SERVICES -->
    <section class="pt-10 pt-md-12">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-6">
                    <hr class="hr-sm bg-warning ms-0 mb-6">
                    <h2 class="display-4 mb-9">
                        Explore our products and service.
                    </h2>
                </div>
            </div>
            <div class="row mt-n6">
                <div class="col-md-6 col-lg-3">
                    <div class="card card-sm rounded-top-start rounded-bottom-end mt-6">
                        <img class="card-img rounded-top-start" style="height: 350px; object-fit: cover;" src="<?= PROOT; ?>assets/media/products/note.jpg" alt="...">
                        <div class="position-relative">
                            <div class="shape shape-fluid-x shape-top text-white">
                                <div class="shape-img pb-5">
                                    <svg viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0 25h25L75 0h25v50H0z" fill="currentColor"/></svg>
                                </div>
                              </div>
                        </div>
                        <div class="card-body">
                            <h3 class="font-sans-serif mb-2">
                                Notepad
                            </h3>
                            <small class="text-muted">
                                a pad of blank or ruled pages for writing notes on.
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-sm rounded-top-start rounded-bottom-end mt-6">
                        <img class="card-img rounded-top-start" style="height: 350px; object-fit: cover;" src="<?= PROOT; ?>assets/media/products/flip.png" alt="...">
                        <div class="position-relative">
                            <div class="shape shape-fluid-x shape-top text-white">
                                <div class="shape-img pb-5">
                                    <svg viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0 25h25L75 0h25v50H0z" fill="currentColor"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h3 class="font-sans-serif mb-2">
                                Flip Chart
                            </h3>
                            <small class="text-muted">
                                stationery item consisting of a pad of large paper sheets.
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-sm rounded-top-start rounded-bottom-end mt-6">
                        <img class="card-img rounded-top-start" style="height: 350px; object-fit: cover;" src="<?= PROOT; ?>assets/media/products/plain.jpg" alt="...">
                        <div class="position-relative">
                            <div class="shape shape-fluid-x shape-top text-white">
                                <div class="shape-img pb-5">
                                    <svg viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0 25h25L75 0h25v50H0z" fill="currentColor"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h3 class="font-sans-serif mb-2">
                                Plain Paper
                            </h3>
                            <small class="text-muted">
                                Paper that has no ruled lines or other markings on it.
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-sm rounded-top-start rounded-bottom-end mt-6">
                        <img class="card-img rounded-top-start" style="height: 350px; object-fit: cover;" src="<?= PROOT; ?>assets/media/products/ruled.png" alt="...">
                        <div class="position-relative">
                            <div class="shape shape-fluid-x shape-top text-white">
                                <div class="shape-img pb-5">
                                    <svg viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0 25h25L75 0h25v50H0z" fill="currentColor"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h3 class="font-sans-serif mb-2">
                                Ruled Paper
                            </h3>
                            <small class="text-muted">
                                Ruled paper (or lined paper) is writing paper printed with lines as a guide for handwriting.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="position-relative mt-5 py-12 py-md-16 bg-light">
        <div class="container-lg">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8 text-center">
                    <h6 class="text-uppercase text-primary mb-5">
                        Vonna Gh
                    </h6>
                    <h2 class="display-1 mb-4">
                        Give us a try.
                    </h2>
                    <p>Our Company is built to handle large supplies to Institutions such as Schools, Corporation as well as Enterprises who require the use of various forms of paper products.
                    </p>
                    <a class="btn btn-primary lift" href="<?= PROOT; ?>auth/signup">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </section>

<?php include ('inc/footer.inc.php'); ?>