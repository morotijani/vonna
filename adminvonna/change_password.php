<?php 

    require_once ("../db_connection/conn.php");

    if (!admin_is_logged_in()) {
        admin_login_redirect();
    }

    $errors = '';
    $hashed = $admin_data['admin_password'];
    $old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
    $old_password = trim($old_password);
    $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
    $password = trim($password);
    $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
    $confirm = trim($confirm);
    $new_hashed = password_hash($password, PASSWORD_BCRYPT);
    $admin_id = $admin_data['admin_id'];
    echo $admin_id;

    if ($_POST) {
        if (empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])) {
            $errors = 'You must fill out all fields';
        } else {

            if (strlen($password) < 6) {
                $errors = 'Password must be at least 6 characters';
            }

            if ($password != $confirm) {
                $errors = 'The new password and confirm new password does not match.';
            }

            if (!password_verify($old_password, $hashed)) {
                $errors = 'Your old password does not our records.';
            }
        }

        if (!empty($errors)) {
            $errors;
        } else {
            $query = '
                UPDATE vonna_admin 
                SET admin_password = :admin_password 
                WHERE admin_id = :admin_id
            ';
            $satement = $conn->prepare($query);
            $result = $satement->execute(
                array(
                    ':admin_password' => $new_hashed,
                    ':admin_id' => $admin_id
                )
            );
            if (isset($result)) {
                $_SESSION['flash_success'] = 'Password successfully <span class="bg-info">UPDATED</span></div>';
                redirect(PROOT . "adminvonna/profile");
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
                            <img src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Bootstrap" width="30" height="24">
                        </a>
                        <div class="d-flex" role="search">
                          <h4>Change password</h4>
                        </div>
                    </div>
                </nav>

                <br><br>
                <a href="<?= PROOT; ?>adminvonna/profile" class="badge bg-dark text-decoration-none" style="float: right;"><i data-feather="arrow-left"></i> Go back</a>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form method="POST" id="edit_passwordForm">
                            <span class="text-danger lead"><?= $errors; ?></span>
                            <div class="mb-3">
                                <label for="old_password" class="form-label">Old password</label>
                                <input type="password" class="form-control form-control-sm" name="old_password" id="old_password" value="<?= $old_password; ?>" required>
                                <div class="form-text">enter old password in this field</div>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New password</label>
                                <input type="password" class="form-control form-control-sm" name="password" id="password" value="<?= $password; ?>" required>
                                <div class="form-text">enter new password in this field</div>
                            </div>
                            <div class="mb-3">
                                <label for="confirm" class="form-label">Confirm new password</label>
                                <input type="password" class="form-control form-control-sm" name="confirm" id="confirm" value="<?= $confirm; ?>" required>
                                <div class="form-text">enter confirm new password in this field</div>
                            </div>
                            <button type="submit" class="btn btn-sm btn-outline-warning" name="edit_pasword" id="edit_pasword">Edit</button>&nbsp;
                            <a href="<?= PROOT; ?>adminvonna/profile" class="btn btn-sm btn-outline-secondary">Cancel</a>
                        </form>
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
