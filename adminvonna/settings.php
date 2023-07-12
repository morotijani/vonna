<?php 

    // ADMIN SETTINGS

    require_once ("../db_connection/conn.php");

    if (!admin_is_logged_in()) {
        admin_login_redirect();
    }

    $errors = '';
    $admin_fullname = ((isset($_POST['admin_fullname']))?sanitize($_POST['admin_fullname']):$admin_data['admin_fullname']);
    $admin_email = ((isset($_POST['admin_email']))?sanitize($_POST['admin_email']):$admin_data['admin_email']);

    if ($_POST) {
        if (empty($_POST['admin_email']) && empty($_POST['admin_email'])) {
            $errors = 'Fill out all empty fileds';
        }

        if (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
            $errors = 'The email you provided is not valid';
        }

        if (!empty($errors)) {
            $errors;
        } else {
            $data = [
                ':admin_fullname' => $admin_fullname,
                ':admin_email' => $admin_email,
                ':admin_id' => $admin_data['admin_id']
            ];
            $query = "
                UPDATE vonna_admin 
                SET admin_fullname = :admin_fullname, admin_email = :admin_email 
                WHERE admin_id = :admin_id
            ";
            $statement = $conn->prepare($query);
            $result = $statement->execute($data);
            if (isset($result)) {
                $_SESSION['flash_success'] = 'Admin has been <span class="bg-info">Updated</span></div>';
                redirect(PROOT . "adminvonna/Settings");
            }
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
                            VONNA.GH
                        </a>
                        <div class="d-flex" role="search">
                          <h4>Update admin</h4>
                        </div>
                    </div>
                </nav>
                <br><br>
                <a href="<?= PROOT; ?>adminvonna/change_password" class="btn btn-sm btn-outline-secondary" style="float: right;">Change password</a><br>
                <form method="POST" id="settingsForm">
                    <span class="text-danger lead"><?= $errors; ?></span>
                    <div class="mb-3">
                        <label for="admin_fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control-sm form-control" name="admin_fullname" id="admin_fullname" value="<?= $admin_fullname; ?>" required>
                        <div class="form-text">change your full name in this field</div>
                    </div>
                    <div class="mb-3">
                        <label for="admin_email" class="form-label">Email</label>
                        <input type="email" class="form-control-sm form-control" name="admin_email" id="admin_email" value="<?= $admin_email; ?>" required>
                        <div class="form-text">change your email in this field</div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-outline-warning" name="submit_settings" id="submit_settings">Update</button>&nbsp;
                    <a href="<?= PROOT; ?>admin/profile" class="btn btn-sm btn-outline-secondary">Cancel</a>
                </form>
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
