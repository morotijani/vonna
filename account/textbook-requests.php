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
                SET textbooks_status = ? 
                WHERE textbook_id = ?
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
                WHERE textbook_id = ?
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
                        
                        <table class="table table-sm table-hover">
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
                                        <tr style="background-color: <?= ($order['textbooks_status'] == 4) ? '#ff63473d' : ''; ?>">
                                            <td><?= $i; ?></td>
                                            <td>
                                                <?= $order['textbook_id']; ?>
                                                <?php 
                                                    if ($order['textbooks_status'] == 0) {
                                                        // code...
                                                        echo '<br><span class="badge bg-danger-soft h6 text-uppercase">Pending</span>';
                                                        echo '&nbsp;<a href="?cancel='.$order["textbook_id"].'&status=4" class="">cancel order</a>';
                                                    } elseif ($order['textbooks_status'] == 1) {
                                                        echo '<br><span class="badge bg-warning-soft h6 text-uppercase">Processing</span>';
                                                    } elseif ($order['textbooks_status'] == 2) {
                                                        echo '<br><span class="badge bg-info-soft h6 text-uppercase">Paid</span>';
                                                    } elseif ($order['textbooks_status'] == 3) {
                                                        echo '<br><span class="badge bg-success-soft h6 text-uppercase">Ordered</span>';
                                                    } elseif ($order['textbooks_status'] == 4) {
                                                        echo '<br><a href="?cancel='.$order["textbook_id"].'&status=new" class="">re-order</a>';
                                                    } else {
                                                        echo '';
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?= ucwords($order['textbook_writer']); ?>
                                                <br>
                                                Level: <?= ucwords($order['textbook_level']); ?>
                                            </td>
                                            <td>
                                                <?= ucwords($order['textbook_book']); ?>
                                                <br>
                                                Qty: <?= $order['textbook_quantity']; ?>
                                            </td>
                                            <td><?= pretty_date($order['textbook_createdAt']); ?></td>
                                            <td>
                                                <a href="javascript:;"  onclick="(confirm('Order will be deleted!') ? window.location = '<?= PROOT; ?>account/textbook-requests/<?= $order['textbook_id']; ?>' : '');" class="badge bg-primary-soft"><i data-feather="trash"></i></a>
                                            </td>
                                        </tr>
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
