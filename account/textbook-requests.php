<?php 
    // 404 PAGE
    //echo md5(uniqid(mt_rand(), true)) . '<br>';
    //echo time() . mt_rand() . 23;
    require_once ('./../db_connection/conn.php');
    if (!user_is_logged_in()) {
        user_login_redirect();
    }
    include ('../inc/header.inc.php');
    include ('header.account.php');

  
    // FETCH ALL ORDERS
    $sql = "
        SELECT * FROM vonna_textbooks 
        WHERE textbook_userid = ? 
        ORDER BY textbook_createdAt DESC
    ";
    $statement = $conn->prepare($sql);
    $statement->execute([$user_id]);
    $orders = $statement->fetchAll();
    $count_orders = $statement->rowCount();

    // CANCEL / RE ORDER
    if (isset($_GET['cancel']) && !empty($_GET['cancel'])) {
        // code...
        $order_id = sanitize($_GET['cancel']);
        $status = $_GET['status'];
        if ($status == 'new') {
            $status = 0;
        }
        if (is_numeric($order_id)) {
            $query = "
                UPDATE vonna_textbooks 
                SET orders_status = ? 
                WHERE orders_id = ?
            ";
            $statement = $conn->prepare($query);
            $result = $statement->execute([$status, $order_id]);
            if ($result) {
                // code...
                $_SESSION['flash_success'] = 'Order cancel successfully.';
                redirect(PROOT . 'account/textbook-requets');
            } else {
                echo js_alert('Something went wrong... please try again.');
                redirect(PROOT . 'account/textbook-requets');
            }
        }
    }

    // DELETE ORDER
    if (isset($_GET['deleted']) && !empty($_GET['deleted'])) {
        // code...
        $order_id = sanitize($_GET['deleted']);
        if (is_numeric($order_id)) {
            $query = "
                DELETE FROM vonna_textbooks 
                WHERE orders_id = ?
            ";
            $statement = $conn->prepare($query);
            $result = $statement->execute([$order_id]);
            if ($result) {
                // code...
                $_SESSION['flash_success'] = 'Order deleted successfully.';
                redirect(PROOT . 'account/textbook-requets');
            } else {
                echo js_alert('Something went wrong... please try again.');
                redirect(PROOT . 'account/textbook-requets');
            }
        }
    }
?>

  <script src="https://unpkg.com/feather-icons"></script>
    <!-- BODY -->
    <main class="">
        <?= $flash; ?>
        <div class="container-lg d-flex flex-column">
            <div class="row align-items-start justify-content-center">
                <div class="col-lg-12">
                    <section class="py-6">
                        <h2 class="display-3 text-center mb-4">
                            Text book <span class="text-underline-warning">orders</span>
                        </h2>
                        
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Order ID</th>
                                    <th>Writer</th>
                                    <th>Boook</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($count_orders > 0): ?>
                                    <?php $i = 1; foreach ($orders as $order): ?>
                                        <tr style="background-color: <?= ($order['orders_status'] == 4) ? '#ff63473d' : ''; ?>">
                                            <td><?= $i; ?></td>
                                            <td>
                                                <?= $order['orders_id']; ?>
                                                <?php 
                                                    if ($order['orders_status'] == 0) {
                                                        // code...
                                                        echo '<br><span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                        echo '&nbsp;<a href="?cancel='.$order["orders_id"].'&status=4" class="">cancel order</a>';
                                                    } elseif ($order['orders_status'] == 1) {
                                                        echo '<br><span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                    } elseif ($order['orders_status'] == 2) {
                                                        echo '<br><span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                    } elseif ($order['orders_status'] == 3) {
                                                        echo '<br><span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                    } elseif ($order['orders_status'] == 4) {
                                                        echo '<br><a href="?cancel='.$order["orders_id"].'&status=new" class="">re-order</a>';
                                                    } else {
                                                        echo '';
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?= ucwords($order['orders_product']); ?>
                                                <br>
                                                Qty: <?= $order['orders_quantity']; ?>
                                            </td>
                                            <td><?= pretty_date($order['textbook_createdAt']); ?></td>
                                            <td>
                                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#Modal<?= $order['orders_id']; ?>" class="badge bg-primary mb-2"><i data-feather="eye"></i></a>
                                                <a href="javascript:;"  onclick="(confirm('Order will be deleted!') ? window.location = '<?= PROOT; ?>account/orders/<?= $order['orders_id']; ?>' : '');" class="badge bg-primary-soft"><i data-feather="trash"></i></a>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="Modal<?= $order['orders_id']; ?>" tabindex="-1" aria-labelledby="ModalLabel<?= $order['orders_id']; ?>" aria-modal="true" role="dialog">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                                                        <?php if ($order['orders_product'] == 'Plain Paper'): ?>
                                                            <img class="img-fluid mb-4 mt-n11" src="<?= PROOT; ?>assets/media/products/plain.jpg" style="width: 350px; height: 350px; object-fit: contain;" alt="...">
                                                        <?php elseif ($order['orders_product'] == 'Ruled Paper'): ?>
                                                            <img class="img-fluid mb-4 mt-n11" src="<?= PROOT; ?>assets/media/products/ruled.png" style="width: 350px; height: 350px; object-fit: contain;" alt="...">
                                                        <?php elseif ($order['orders_product'] == 'Flip Chart'): ?>
                                                            <img class="img-fluid mb-4 mt-n11" src="<?= PROOT; ?>assets/media/products/flip.png" style="width: 350px; height: 350px; object-fit: contain;" alt="...">
                                                        <?php elseif ($order['orders_product'] == 'Notepad'): ?>
                                                            <img class="img-fluid mb-4 mt-n11" src="<?= PROOT; ?>assets/media/products/note.jpg" style="width: 350px; height: 350px; object-fit: contain;" alt="...">
                                                        <?php elseif ($order['orders_product'] == 'Envelope'): ?>
                                                            <img class="img-fluid mb-4 mt-n11" src="<?= PROOT; ?>assets/media/products/envelope.jpg" style="width: 350px; height: 350px; object-fit: contain;" alt="...">
                                                        <?php else: ?>
                                                        <?php endif ?>
                                                        <h1 class="mb-4" id="ModalLabel<?= $order['orders_id']; ?>">
                                                            <?= $order['orders_id']; ?>
                                                        </h1>
                                                        <p class="text-muted">
                                                            <?php 

                                                                if ($order['orders_status'] == 0) {
                                                                    // code...
                                                                    echo '<span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                                } elseif ($order['orders_status'] == 1) {
                                                                    echo '<span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                                } elseif ($order['orders_status'] == 2) {
                                                                    echo '<span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                                } elseif ($order['orders_status'] == 3) {
                                                                    echo '<span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                                }
                                                            ?>
                                                        </p>
                                                        <ul class="list-group">
                                                            <li class="list-group-item"><?= $order['orders_product']; ?></li>
                                                            <?php if ($order['orders_size'] != ''): ?>
                                                                <li class="list-group-item"><span>Size: </span><?= $order['orders_size']; ?></li>
                                                            <?php endif ?>

                                                            <?php if ($order['orders_type'] != ''): ?>
                                                                <li class="list-group-item"><?= $order['orders_type']; ?></li>
                                                            <?php endif ?>

                                                            <?php if ($order['orders_quantity'] != ''): ?>
                                                                <li class="list-group-item"><span>Quantity: </span><?= $order['orders_quantity']; ?></li>
                                                            <?php endif ?>

                                                            <?php if ($order['orders_color'] != ''): ?>
                                                                <li class="list-group-item"><?= $order['orders_color']; ?></li>
                                                            <?php endif ?>

                                                            <li class="list-group-item"><span>Ordered on: </span><?= pretty_date($order['textbook_createdAt']); ?></li>
                                                        </ul>
                                                        <!-- Text -->
                                                        <small class="text-muted mt-2">
                                                            <a class="text-reset" data-bs-dismiss="modal" href="javascript:;">Close.</a>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php $i++; endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7">No textbooks orders yet.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </section>

                   <!--  <a class="btn btn-primary" href="javascript:;" onclick="goBack()">
                        Go back
                    </a> -->
                </div>
            </div>
        </div>
    </main>

    <!-- JAVASCRIPT -->
    <script src="<?= PROOT; ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>
    <script src="<?= PROOT; ?>assets/js/vendor.bundle.js"></script>
    <script src="<?= PROOT; ?>assets/js/theme.bundle.js"></script>

    <script>

        feather.replace()

        // Fade out messages
        $("#temporary").fadeOut(5000);

        function goBack() {
            window.history.back();
        }

    </script>

</body>
</html>
