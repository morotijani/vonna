<?php 
    // PRODUCTS PAGE

    require_once ('db_connection/conn.php');

    include ('inc/header.inc.php');
    $nav_bg = '';
    include ('inc/nav.inc.php');
?>

    <!-- WELCOME -->
    <section class="pt-6 pt-md-11 pb-11 pb-md-13">
        <div class="container-lg">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-6 text-center" data-aos="fade-up">
                    <h1 class="display-3 mb-4">
                        One stop to run your <span class="text-underline-warning">paper works</span>.
                    </h1>
                    <p class="fs-lg text-muted">
                        Direct supply of quality papers,<br>
                        to instituitions at factory prices.
                    </p>
                    <a class="btn btn-warning lift" href="<?= PROOT; ?>auth/signup">
                        Create an Account
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="position-relative">
        <div class="container-lg">
            <div class="row justify-content-center">
                <div class="col-md-10 col-xl-8 position-static">
                    <hr class="hr-sm bg-warning mx-auto">
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section class="pt-11 pt-md-13">
        <div class="container-lg">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6">
                    <img class="img-fluid mb-8 mb-md-0" src="assets/media/products/plain.jpg" alt="...">
                </div>
                <div class="col-md-6 col-lg-5">
                    <h2 class="display-4 mb-4">
                        Plain Paper
                    </h2>
                    <p class="text-muted">
                        Paper that has no ruled lines or other markings on it. Paper is a thin substance that people use for writing, printing, wrapping, and numerous other purposes.
                    </p>
                    <a class="h6 text-uppercase text-decoration-none" href="<?= PROOT; ?>account/index">
                        Order <i class="fe fe-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section>
        <div class="container-lg position-relative" style="z-index: 1;">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-5 order-md-1 pt-10 py-md-8">
                    <div class="position-relative">
                        <div class="position-absolute bottom-end text-warning mb-n8 me-n8">
                            <svg width="185" height="186" viewBox="0 0 185 186" fill="yellow" xmlns="http://www.w3.org/2000/svg"><circle cx="2" cy="2" r="2" fill="currentColor"/><circle cx="22" cy="2" r="2" fill="currentColor"/><circle cx="42" cy="2" r="2" fill="currentColor"/><circle cx="62" cy="2" r="2" fill="currentColor"/><circle cx="82" cy="2" r="2" fill="currentColor"/><circle cx="102" cy="2" r="2" fill="currentColor"/><circle cx="122" cy="2" r="2" fill="currentColor"/><circle cx="142" cy="2" r="2" fill="currentColor"/><circle cx="162" cy="2" r="2" fill="currentColor"/><circle cx="182" cy="2" r="2" fill="currentColor"/><circle cx="2" cy="22" r="2" fill="currentColor"/><circle cx="22" cy="22" r="2" fill="currentColor"/><circle cx="42" cy="22" r="2" fill="currentColor"/><circle cx="62" cy="22" r="2" fill="currentColor"/><circle cx="82" cy="22" r="2" fill="currentColor"/><circle cx="102" cy="22" r="2" fill="currentColor"/><circle cx="122" cy="22" r="2" fill="currentColor"/><circle cx="142" cy="22" r="2" fill="currentColor"/><circle cx="162" cy="22" r="2" fill="currentColor"/><circle cx="182" cy="22" r="2" fill="currentColor"/><circle cx="2" cy="42" r="2" fill="currentColor"/><circle cx="22" cy="42" r="2" fill="currentColor"/><circle cx="42" cy="42" r="2" fill="currentColor"/><circle cx="62" cy="42" r="2" fill="currentColor"/><circle cx="82" cy="42" r="2" fill="currentColor"/><circle cx="102" cy="42" r="2" fill="currentColor"/><circle cx="122" cy="42" r="2" fill="currentColor"/><circle cx="142" cy="42" r="2" fill="currentColor"/><circle cx="162" cy="42" r="2" fill="currentColor"/><circle cx="182" cy="42" r="2" fill="currentColor"/><circle cx="2" cy="62" r="2" fill="currentColor"/><circle cx="22" cy="62" r="2" fill="currentColor"/><circle cx="42" cy="62" r="2" fill="currentColor"/><circle cx="62" cy="62" r="2" fill="currentColor"/><circle cx="82" cy="62" r="2" fill="currentColor"/><circle cx="102" cy="62" r="2" fill="currentColor"/><circle cx="122" cy="62" r="2" fill="currentColor"/><circle cx="142" cy="62" r="2" fill="currentColor"/><circle cx="162" cy="62" r="2" fill="currentColor"/><circle cx="182" cy="62" r="2" fill="currentColor"/><circle cx="2" cy="82" r="2" fill="currentColor"/><circle cx="22" cy="82" r="2" fill="currentColor"/><circle cx="42" cy="82" r="2" fill="currentColor"/><circle cx="62" cy="82" r="2" fill="currentColor"/><circle cx="82" cy="82" r="2" fill="currentColor"/><circle cx="102" cy="82" r="2" fill="currentColor"/><circle cx="122" cy="82" r="2" fill="currentColor"/><circle cx="142" cy="82" r="2" fill="currentColor"/><circle cx="162" cy="82" r="2" fill="currentColor"/><circle cx="182" cy="82" r="2" fill="currentColor"/><circle cx="2" cy="102" r="2" fill="currentColor"/><circle cx="22" cy="102" r="2" fill="currentColor"/><circle cx="42" cy="102" r="2" fill="currentColor"/><circle cx="62" cy="102" r="2" fill="currentColor"/><circle cx="82" cy="102" r="2" fill="currentColor"/><circle cx="102" cy="102" r="2" fill="currentColor"/><circle cx="122" cy="102" r="2" fill="currentColor"/><circle cx="142" cy="102" r="2" fill="currentColor"/><circle cx="162" cy="102" r="2" fill="currentColor"/><circle cx="182" cy="102" r="2" fill="currentColor"/><circle cx="2" cy="122" r="2" fill="currentColor"/><circle cx="22" cy="122" r="2" fill="currentColor"/><circle cx="42" cy="122" r="2" fill="currentColor"/><circle cx="62" cy="122" r="2" fill="currentColor"/><circle cx="82" cy="122" r="2" fill="currentColor"/><circle cx="102" cy="122" r="2" fill="currentColor"/><circle cx="122" cy="122" r="2" fill="currentColor"/><circle cx="142" cy="122" r="2" fill="currentColor"/><circle cx="162" cy="122" r="2" fill="currentColor"/><circle cx="182" cy="122" r="2" fill="currentColor"/><circle cx="2" cy="142" r="2" fill="currentColor"/><circle cx="22" cy="142" r="2" fill="currentColor"/><circle cx="42" cy="142" r="2" fill="currentColor"/><circle cx="62" cy="142" r="2" fill="currentColor"/><circle cx="82" cy="142" r="2" fill="currentColor"/><circle cx="102" cy="142" r="2" fill="currentColor"/><circle cx="122" cy="142" r="2" fill="currentColor"/><circle cx="142" cy="142" r="2" fill="currentColor"/><circle cx="162" cy="142" r="2" fill="currentColor"/><circle cx="182" cy="142" r="2" fill="currentColor"/><circle cx="2" cy="162" r="2" fill="currentColor"/><circle cx="22" cy="162" r="2" fill="currentColor"/><circle cx="42" cy="162" r="2" fill="currentColor"/><circle cx="62" cy="162" r="2" fill="currentColor"/><circle cx="82" cy="162" r="2" fill="currentColor"/><circle cx="102" cy="162" r="2" fill="currentColor"/><circle cx="122" cy="162" r="2" fill="currentColor"/><circle cx="142" cy="162" r="2" fill="currentColor"/><circle cx="162" cy="162" r="2" fill="currentColor"/><circle cx="182" cy="162" r="2" fill="currentColor"/><circle cx="2" cy="182" r="2" fill="currentColor"/><circle cx="22" cy="182" r="2" fill="currentColor"/><circle cx="42" cy="182" r="2" fill="currentColor"/><circle cx="62" cy="182" r="2" fill="currentColor"/><circle cx="82" cy="182" r="2" fill="currentColor"/><circle cx="102" cy="182" r="2" fill="currentColor"/><circle cx="122" cy="182" r="2" fill="currentColor"/><circle cx="142" cy="182" r="2" fill="currentColor"/><circle cx="162" cy="182" r="2" fill="currentColor"/><circle cx="182" cy="182" r="2" fill="currentColor"/></svg>
                        </div>
                        <img class="img-fluid position-relative border border-7 border-white shadow-lg" src="assets/media/products/ruled.png" alt="...">
                    </div>
                </div>
                <div class="col-md-6 col-lg-5 order-md-0 py-10 py-md-12">
                    <h2 class="display-4 mb-4">
                        Ruled Paper
                    </h2>
                    <p class="text-muted">
                        Ruled paper (or lined paper) is writing paper printed with lines as a guide for handwriting. The lines often are printed with fine width and in light colour and such paper is sometimes called feint-ruled paper.
                    </p>
                    <a class="h6 text-uppercase text-decoration-none" href="<?= PROOT; ?>account/index">
                        Order <i class="fe fe-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-11 pt-md-13">
        <div class="container-lg">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6">
                    <img class="img-fluid mb-8 mb-md-0" src="assets/media/products/flip.png" alt="...">
                </div>
                <div class="col-md-6 col-lg-5">
                    <h2 class="display-4 mb-4">
                        Flip Chart
                    </h2>
                    <p class="text-muted">
                        A flip chart is a stationery item consisting of a pad of large paper sheets. It is typically fixed to the upper edge of a whiteboard, or supported on a tripod or four-legged easel. Such charts are commonly used for presentations.
                    </p>
                    <a class="h6 text-uppercase text-decoration-none" href="<?= PROOT; ?>account/index">
                        Order <i class="fe fe-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SHAPE -->
    <div class="position-relative">
        <div class="position-absolute top-end text-primary-dark mt-n12">
            <svg width="129" height="208" viewBox="0 0 129 208" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#decoration5clip0)"><path fill-rule="evenodd" clip-rule="evenodd" d="M142.812 201.281a6.47 6.47 0 1112.94.002 6.47 6.47 0 01-12.94-.002zm1.618 0a4.851 4.851 0 119.702 0 4.851 4.851 0 01-9.702 0zm4.851-27.018l4.811-4.811 1.144 1.143-4.811 4.811 4.811 4.811-1.144 1.144-4.811-4.811-4.811 4.811-1.143-1.144 4.811-4.811-4.811-4.811 1.143-1.143 4.811 4.811zm-32.343 1.143a6.468 6.468 0 1112.936 0 6.468 6.468 0 01-12.936 0zm1.617 0a4.851 4.851 0 119.702 0 4.851 4.851 0 01-9.702 0zm4.851 24.732l4.811-4.811 1.144 1.143-4.811 4.811 4.811 4.811-1.144 1.144-4.811-4.811-4.811 4.811-1.143-1.144 4.811-4.811-4.811-4.811 1.143-1.143 4.811 4.811z" fill="currentColor"/></g><g clip-path="url(#decoration5clip1)"><path fill-rule="evenodd" clip-rule="evenodd" d="M142.812 149.281a6.47 6.47 0 1112.94.002 6.47 6.47 0 01-12.94-.002zm1.618 0a4.851 4.851 0 119.702 0 4.851 4.851 0 01-9.702 0zm4.851-27.018l4.811-4.811 1.144 1.143-4.811 4.811 4.811 4.811-1.144 1.144-4.811-4.811-4.811 4.811-1.143-1.144 4.811-4.811-4.811-4.811 1.143-1.143 4.811 4.811zm-32.343 1.143a6.468 6.468 0 1112.936 0 6.468 6.468 0 01-12.936 0zm1.617 0a4.851 4.851 0 119.702 0 4.851 4.851 0 01-9.702 0zm4.851 24.732l4.811-4.811 1.144 1.143-4.811 4.811 4.811 4.811-1.144 1.144-4.811-4.811-4.811 4.811-1.143-1.144 4.811-4.811-4.811-4.811 1.143-1.143 4.811 4.811z" fill="currentColor"/></g><g clip-path="url(#decoration5clip2)"><path fill-rule="evenodd" clip-rule="evenodd" d="M142.812 97.281a6.47 6.47 0 1112.939.002 6.47 6.47 0 01-12.939-.002zm1.618 0a4.851 4.851 0 119.703 0 4.851 4.851 0 01-9.703 0zm4.851-27.018l4.811-4.811 1.144 1.143-4.811 4.811 4.811 4.811-1.144 1.144-4.811-4.811-4.811 4.81-1.143-1.143 4.811-4.81-4.811-4.812 1.143-1.143 4.811 4.81zm-32.343 1.143a6.469 6.469 0 1112.937 0 6.469 6.469 0 01-12.937 0zm1.617 0a4.851 4.851 0 119.703 0 4.851 4.851 0 01-9.703 0zm4.851 24.732l4.811-4.811 1.144 1.143-4.811 4.811 4.811 4.811-1.144 1.144-4.811-4.811-4.811 4.811-1.143-1.144 4.811-4.81-4.811-4.812 1.143-1.143 4.811 4.81z" fill="currentColor"/></g><g clip-path="url(#decoration5clip3)"><path fill-rule="evenodd" clip-rule="evenodd" d="M38.813 149.281a6.47 6.47 0 1112.938 0 6.47 6.47 0 01-12.938 0zm1.617 0a4.851 4.851 0 119.702 0 4.851 4.851 0 01-9.702 0zm4.851-27.018l4.811-4.811 1.144 1.143-4.811 4.811 4.81 4.811-1.143 1.144-4.81-4.811-4.812 4.811-1.143-1.144 4.81-4.811-4.81-4.811 1.143-1.143 4.811 4.811zm-32.343 1.143a6.469 6.469 0 1112.937.001 6.469 6.469 0 01-12.938-.001zm1.617 0a4.851 4.851 0 119.702 0 4.851 4.851 0 01-9.702 0zm4.851 24.732l4.811-4.811 1.144 1.143-4.811 4.811 4.81 4.811-1.143 1.144-4.81-4.811-4.812 4.811-1.143-1.144 4.81-4.811-4.81-4.811 1.143-1.143 4.811 4.811z" fill="currentColor"/></g><g clip-path="url(#decoration5clip4)"><path fill-rule="evenodd" clip-rule="evenodd" d="M38.813 97.281a6.469 6.469 0 1112.937 0 6.469 6.469 0 01-12.938 0zm1.617 0a4.852 4.852 0 119.703 0 4.852 4.852 0 01-9.703 0zm4.851-27.018l4.811-4.811 1.144 1.143-4.811 4.811 4.81 4.811-1.143 1.144-4.81-4.811-4.812 4.81-1.143-1.143 4.81-4.81-4.81-4.812 1.143-1.143 4.811 4.81zm-32.343 1.143a6.469 6.469 0 1112.937 0 6.469 6.469 0 01-12.938 0zm1.617 0a4.852 4.852 0 119.703 0 4.852 4.852 0 01-9.703 0zm4.851 24.732l4.811-4.811 1.144 1.143-4.811 4.811 4.81 4.811-1.143 1.144-4.81-4.811-4.812 4.811-1.143-1.144 4.81-4.81-4.81-4.812 1.143-1.143 4.811 4.81z" fill="currentColor"/></g><g clip-path="url(#decoration5clip5)"><path fill-rule="evenodd" clip-rule="evenodd" d="M38.813 45.281a6.469 6.469 0 1112.937 0 6.469 6.469 0 01-12.938 0zm1.617 0a4.852 4.852 0 119.703 0 4.852 4.852 0 01-9.703 0zm4.851-27.018l4.811-4.811 1.144 1.143-4.811 4.811 4.81 4.811-1.143 1.144-4.81-4.811-4.812 4.81-1.143-1.143 4.81-4.81-4.81-4.812 1.143-1.143 4.811 4.81zm-32.343 1.143a6.469 6.469 0 1112.937 0 6.469 6.469 0 01-12.938 0zm1.617 0a4.852 4.852 0 119.703 0 4.852 4.852 0 01-9.703 0zm4.851 24.732l4.811-4.811 1.144 1.143-4.811 4.811 4.81 4.811-1.143 1.144-4.81-4.811-4.812 4.81-1.143-1.143 4.81-4.81-4.81-4.812 1.143-1.143 4.811 4.81z" fill="currentColor"/></g><g clip-path="url(#decoration5clip6)"><path fill-rule="evenodd" clip-rule="evenodd" d="M90.813 175.281a6.47 6.47 0 1112.938 0 6.47 6.47 0 01-12.939 0zm1.617 0a4.851 4.851 0 119.702 0 4.851 4.851 0 01-9.702 0zm4.851-27.018l4.811-4.811 1.144 1.143-4.811 4.811 4.811 4.811-1.144 1.144-4.81-4.811-4.812 4.811-1.143-1.144 4.81-4.811-4.81-4.811 1.143-1.143 4.811 4.811zm-32.344 1.143a6.469 6.469 0 1112.938.001 6.469 6.469 0 01-12.938-.001zm1.618 0a4.851 4.851 0 119.702 0 4.851 4.851 0 01-9.702 0zm4.851 24.732l4.811-4.811 1.144 1.143-4.811 4.811 4.81 4.811-1.143 1.144-4.81-4.811-4.812 4.811-1.143-1.144 4.81-4.811-4.81-4.811 1.143-1.143 4.811 4.811z" fill="currentColor"/></g><g clip-path="url(#decoration5clip7)"><path fill-rule="evenodd" clip-rule="evenodd" d="M90.813 123.281a6.47 6.47 0 1112.938 0 6.47 6.47 0 01-12.939 0zm1.617 0a4.851 4.851 0 119.702 0 4.851 4.851 0 01-9.702 0zm4.851-27.018l4.811-4.811 1.144 1.143-4.811 4.811 4.811 4.811-1.144 1.144-4.81-4.811-4.812 4.811-1.143-1.144 4.81-4.81-4.81-4.812 1.143-1.143 4.811 4.81zm-32.344 1.143a6.469 6.469 0 1112.938 0 6.469 6.469 0 01-12.938 0zm1.618 0a4.852 4.852 0 119.703 0 4.852 4.852 0 01-9.703 0zm4.851 24.732l4.811-4.811 1.144 1.143-4.811 4.811 4.81 4.811-1.143 1.144-4.81-4.811-4.812 4.811-1.143-1.144 4.81-4.811-4.81-4.811 1.143-1.143 4.811 4.811z" fill="currentColor"/></g><g clip-path="url(#decoration5clip8)"><path fill-rule="evenodd" clip-rule="evenodd" d="M90.813 71.281a6.469 6.469 0 1112.937 0 6.469 6.469 0 01-12.938 0zm1.617 0a4.852 4.852 0 119.703 0 4.852 4.852 0 01-9.703 0zm4.851-27.018l4.811-4.811 1.144 1.143-4.811 4.811 4.811 4.811-1.144 1.144-4.81-4.811-4.812 4.81-1.143-1.143 4.81-4.81-4.81-4.812 1.143-1.143 4.811 4.81zm-32.344 1.143a6.469 6.469 0 1112.938 0 6.469 6.469 0 01-12.938 0zm1.618 0a4.852 4.852 0 119.703 0 4.852 4.852 0 01-9.703 0zm4.851 24.732l4.811-4.811 1.144 1.143-4.811 4.811 4.81 4.811-1.143 1.144-4.81-4.811-4.812 4.81-1.143-1.143 4.81-4.81-4.81-4.812 1.143-1.143 4.811 4.81z" fill="currentColor"/></g><defs><clipPath id="decoration4clip0"><path transform="matrix(0 -1 -1 0 155.75 207.75)" fill="#fff" d="M0 0h51.75v51.75H0z"/></clipPath><clipPath id="decoration4clip1"><path transform="rotate(-90 155.75 0)" fill="#fff" d="M0 0h51.75v51.75H0z"/></clipPath><clipPath id="decoration4clip2"><path transform="matrix(0 -1 -1 0 155.75 103.75)" fill="#fff" d="M0 0h51.75v51.75H0z"/></clipPath><clipPath id="decoration4clip3"><path transform="matrix(0 -1 -1 0 51.75 155.75)" fill="#fff" d="M0 0h51.75v51.75H0z"/></clipPath><clipPath id="decoration4clip4"><path transform="matrix(0 -1 -1 0 51.75 103.75)" fill="#fff" d="M0 0h51.75v51.75H0z"/></clipPath><clipPath id="decoration4clip5"><path transform="matrix(0 -1 -1 0 51.75 51.75)" fill="#fff" d="M0 0h51.75v51.75H0z"/></clipPath><clipPath id="decoration4clip6"><path transform="matrix(0 -1 -1 0 103.75 181.75)" fill="#fff" d="M0 0h51.75v51.75H0z"/></clipPath><clipPath id="decoration4clip7"><path transform="matrix(0 -1 -1 0 103.75 129.75)" fill="#fff" d="M0 0h51.75v51.75H0z"/></clipPath><clipPath id="decoration4clip8"><path transform="matrix(0 -1 -1 0 103.75 77.75)" fill="#fff" d="M0 0h51.75v51.75H0z"/></clipPath></defs></svg>
        </div>
    </div>
    <section>
        <div class="container-lg position-relative" style="z-index: 1;">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-5 order-md-1 pt-10 py-md-8">
                    <div class="position-relative">
                        <div class="position-absolute bottom-end text-warning mb-n8 me-n8">
                            <svg width="185" height="186" viewBox="0 0 185 186" fill="yellow" xmlns="http://www.w3.org/2000/svg"><circle cx="2" cy="2" r="2" fill="currentColor"/><circle cx="22" cy="2" r="2" fill="currentColor"/><circle cx="42" cy="2" r="2" fill="currentColor"/><circle cx="62" cy="2" r="2" fill="currentColor"/><circle cx="82" cy="2" r="2" fill="currentColor"/><circle cx="102" cy="2" r="2" fill="currentColor"/><circle cx="122" cy="2" r="2" fill="currentColor"/><circle cx="142" cy="2" r="2" fill="currentColor"/><circle cx="162" cy="2" r="2" fill="currentColor"/><circle cx="182" cy="2" r="2" fill="currentColor"/><circle cx="2" cy="22" r="2" fill="currentColor"/><circle cx="22" cy="22" r="2" fill="currentColor"/><circle cx="42" cy="22" r="2" fill="currentColor"/><circle cx="62" cy="22" r="2" fill="currentColor"/><circle cx="82" cy="22" r="2" fill="currentColor"/><circle cx="102" cy="22" r="2" fill="currentColor"/><circle cx="122" cy="22" r="2" fill="currentColor"/><circle cx="142" cy="22" r="2" fill="currentColor"/><circle cx="162" cy="22" r="2" fill="currentColor"/><circle cx="182" cy="22" r="2" fill="currentColor"/><circle cx="2" cy="42" r="2" fill="currentColor"/><circle cx="22" cy="42" r="2" fill="currentColor"/><circle cx="42" cy="42" r="2" fill="currentColor"/><circle cx="62" cy="42" r="2" fill="currentColor"/><circle cx="82" cy="42" r="2" fill="currentColor"/><circle cx="102" cy="42" r="2" fill="currentColor"/><circle cx="122" cy="42" r="2" fill="currentColor"/><circle cx="142" cy="42" r="2" fill="currentColor"/><circle cx="162" cy="42" r="2" fill="currentColor"/><circle cx="182" cy="42" r="2" fill="currentColor"/><circle cx="2" cy="62" r="2" fill="currentColor"/><circle cx="22" cy="62" r="2" fill="currentColor"/><circle cx="42" cy="62" r="2" fill="currentColor"/><circle cx="62" cy="62" r="2" fill="currentColor"/><circle cx="82" cy="62" r="2" fill="currentColor"/><circle cx="102" cy="62" r="2" fill="currentColor"/><circle cx="122" cy="62" r="2" fill="currentColor"/><circle cx="142" cy="62" r="2" fill="currentColor"/><circle cx="162" cy="62" r="2" fill="currentColor"/><circle cx="182" cy="62" r="2" fill="currentColor"/><circle cx="2" cy="82" r="2" fill="currentColor"/><circle cx="22" cy="82" r="2" fill="currentColor"/><circle cx="42" cy="82" r="2" fill="currentColor"/><circle cx="62" cy="82" r="2" fill="currentColor"/><circle cx="82" cy="82" r="2" fill="currentColor"/><circle cx="102" cy="82" r="2" fill="currentColor"/><circle cx="122" cy="82" r="2" fill="currentColor"/><circle cx="142" cy="82" r="2" fill="currentColor"/><circle cx="162" cy="82" r="2" fill="currentColor"/><circle cx="182" cy="82" r="2" fill="currentColor"/><circle cx="2" cy="102" r="2" fill="currentColor"/><circle cx="22" cy="102" r="2" fill="currentColor"/><circle cx="42" cy="102" r="2" fill="currentColor"/><circle cx="62" cy="102" r="2" fill="currentColor"/><circle cx="82" cy="102" r="2" fill="currentColor"/><circle cx="102" cy="102" r="2" fill="currentColor"/><circle cx="122" cy="102" r="2" fill="currentColor"/><circle cx="142" cy="102" r="2" fill="currentColor"/><circle cx="162" cy="102" r="2" fill="currentColor"/><circle cx="182" cy="102" r="2" fill="currentColor"/><circle cx="2" cy="122" r="2" fill="currentColor"/><circle cx="22" cy="122" r="2" fill="currentColor"/><circle cx="42" cy="122" r="2" fill="currentColor"/><circle cx="62" cy="122" r="2" fill="currentColor"/><circle cx="82" cy="122" r="2" fill="currentColor"/><circle cx="102" cy="122" r="2" fill="currentColor"/><circle cx="122" cy="122" r="2" fill="currentColor"/><circle cx="142" cy="122" r="2" fill="currentColor"/><circle cx="162" cy="122" r="2" fill="currentColor"/><circle cx="182" cy="122" r="2" fill="currentColor"/><circle cx="2" cy="142" r="2" fill="currentColor"/><circle cx="22" cy="142" r="2" fill="currentColor"/><circle cx="42" cy="142" r="2" fill="currentColor"/><circle cx="62" cy="142" r="2" fill="currentColor"/><circle cx="82" cy="142" r="2" fill="currentColor"/><circle cx="102" cy="142" r="2" fill="currentColor"/><circle cx="122" cy="142" r="2" fill="currentColor"/><circle cx="142" cy="142" r="2" fill="currentColor"/><circle cx="162" cy="142" r="2" fill="currentColor"/><circle cx="182" cy="142" r="2" fill="currentColor"/><circle cx="2" cy="162" r="2" fill="currentColor"/><circle cx="22" cy="162" r="2" fill="currentColor"/><circle cx="42" cy="162" r="2" fill="currentColor"/><circle cx="62" cy="162" r="2" fill="currentColor"/><circle cx="82" cy="162" r="2" fill="currentColor"/><circle cx="102" cy="162" r="2" fill="currentColor"/><circle cx="122" cy="162" r="2" fill="currentColor"/><circle cx="142" cy="162" r="2" fill="currentColor"/><circle cx="162" cy="162" r="2" fill="currentColor"/><circle cx="182" cy="162" r="2" fill="currentColor"/><circle cx="2" cy="182" r="2" fill="currentColor"/><circle cx="22" cy="182" r="2" fill="currentColor"/><circle cx="42" cy="182" r="2" fill="currentColor"/><circle cx="62" cy="182" r="2" fill="currentColor"/><circle cx="82" cy="182" r="2" fill="currentColor"/><circle cx="102" cy="182" r="2" fill="currentColor"/><circle cx="122" cy="182" r="2" fill="currentColor"/><circle cx="142" cy="182" r="2" fill="currentColor"/><circle cx="162" cy="182" r="2" fill="currentColor"/><circle cx="182" cy="182" r="2" fill="currentColor"/></svg>
                        </div>
                        <img class="img-fluid position-relative border border-7 border-white shadow-lg" src="assets/media/products/note.jpg" alt="...">
                    </div>
                </div>
                <div class="col-md-6 col-lg-5 order-md-0 py-10 py-md-12">
                    <h2 class="display-4 mb-4">
                        Notepad
                    </h2>
                    <p class="text-muted">
                        a pad of blank or ruled pages for writing notes on.
                    </p>
                    <a class="h6 text-uppercase text-decoration-none" href="<?= PROOT; ?>account/index">
                        Order <i class="fe fe-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-11 pt-md-13">
        <div class="container-lg">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6">
                    <img class="img-fluid mb-8 mb-md-0" src="assets/media/products/envelope.jpg" alt="...">
                </div>
                <div class="col-md-6 col-lg-5">
                    <h2 class="display-4 mb-4">
                        Envelope
                    </h2>
                    <p class="text-muted">
                        a flat paper container with a sealable flap, used to enclose a letter or document.
                    </p>
                    <a class="h6 text-uppercase text-decoration-none" href="<?= PROOT; ?>account/index">
                        Order <i class="fe fe-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="bg-gradient-light">
        <section class="position-relative pt-10 pt-md-12 pb-12 pb-md-16">
            <div class="container-lg">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8 text-center">
                        <hr class="hr-sm bg-warning mx-auto mb-10 mb-md-12">
                        <h6 class="text-uppercase text-warning mb-5">
                            Order today
                        </h6>
                        <h2 class="display-1 mb-4">
                            Buy from us.
                        </h2>
                        <p>
                            Vonna is legally registered Enterprise which serves as a vehicle to adequately distribute comfort and satisfaction to Offices and Institutions when it comes to the need for Paper
                        </p>
                        <a class="btn btn-warning lift" href="<?= PROOT; ?>account/index">
                            Order Now
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php include ('inc/footer.inc.php'); ?>
