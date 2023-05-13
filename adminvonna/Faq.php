<?php 

    require_once ("../db_connection/conn.php");

    if (!admin_is_logged_in()) {
        admin_login_redirect();
    }

    

    $message = '';
    $faq_head = ((isset($_POST['faq_head']) ? sanitize($_POST["faq_head"]) : ''));
    $faq_body = ((isset($_POST['faq_body']) ? sanitize($_POST["faq_body"]) : ''));


    // Select faq on edit
    if (isset($_GET['edit']) && !empty($_GET['edit'])) {
        $edit_id = sanitize((int)$_GET['edit']);
        $count = faq_exist($edit_id)['counting'];

        if ($count > 0) {
            $row = faq_exist($edit_id)['row'][0];

           
            $faq_head = ((isset($_POST['faq_head']) && $_POST['faq_head'] != '')?sanitize($_POST['faq_head']):$row['faq_head']);
            $faq_body = ((isset($_POST['faq_body']) && $_POST['faq_body'] != '')?sanitize($_POST['faq_body']):$row['faq_body']);
            
        } else {
            $_SESSION['flash_error'] = 'FAQ can not be <span class="bg-info">Found</span> in the database.';
            redirect(PROOT. "adminvonna/Faq");
        }
    }

    // Insert faq
    if (isset($_POST['submit_faq']) && !empty($_POST)) {

        if (empty($faq_head) || $faq_head == '') {
            $message = '<div class="text-danger" id="temporary">The Question cannot be blank</div>';
        }

        if (empty($faq_body) || $faq_body == '') {
            $message = '<div class="text-danger" id="temporary">The Answer cannot be blank</div>';
        } else {

            $query = "
                SELECT * FROM vonna_faq 
                WHERE faq_head = :faq_head 
            ";
            if (isset($_GET['edit']) && !empty($_GET['edit'])) {
                $edit_id = sanitize((int)$_GET['edit']);
                $query = "
                    SELECT * FROM vonna_faq 
                    WHERE faq_head = :faq_head 
                    AND id != '{$edit_id}'
                ";
            }
            $statement = $conn->prepare($query);
            $statement->execute(
                array(
                  ':faq_head' => $faq_head
                )
            );

            if ($statement->rowCount() > 0) {
                $message = '<div class="text-danger" id="temporary">'.$faq_head.' already exists. Please choose a new Question</div>';
            } else {
                if (empty($message)) {

                    if (isset($_GET['edit']) && !empty($_GET['edit'])) {
                        $edit_id = sanitize((int)$_GET['edit']);
                        $updateQ = "
                            UPDATE vonna_faq 
                            SET faq_head = ?, faq_body = ? 
                            WHERE id = ?
                        ";
                        $statement = $conn->prepare($updateQ);
                        $update_result = $statement->execute([$faq_head, $faq_body, $edit_id]);
                        if (isset($update_result)) {
                            $_SESSION['flash_success'] = 'FAQ successfully <span class="bg-info">UPDATED</span>';
                            redirect (PROOT . "adminvonna/Faq");
                        }
                    } else {
                        $query = "
                            INSERT INTO vonna_faq (`faq_head`, `faq_body`) 
                            VALUES (?, ?)
                        ";
                        $statement = $conn->prepare($query);
                        $result = $statement->execute(
                            [$faq_head, $faq_body]
                        );
                        if (isset($result)) {
                            $_SESSION['flash_success'] = 'FAQ successfully <span class="bg-info">Added</span></div>';
                            redirect(PROOT . "adminvonna/Faq");
                        }
                    }
                } else {
                    $message = $message;
                }
            }
        }
    }

    // DELETE FAQ
    if (isset($_GET['trash']) && !empty($_GET['trash'])) {
        $delete_id = sanitize((int)$_GET['trash']);

        $count = faq_exist($delete_id)['counting'];
        if ($count > 0) {
            // code...
            $query = "
                DELETE FROM vonna_faq 
                WHERE id = ?
            ";
            $statement = $conn->prepare($query);
            $result = $statement->execute([$delete_id]);
            if ($result) {
                // code...
                $_SESSION['flash_success'] = 'FAQ Deleted';
                redirect(PROOT . 'adminvonna/Faq');
            } else {
                echo js_alert('Something went wrong.');
                redirect(PROOT . 'adminvonna/Faq');
            }
        }
    
    }


    $faqQ = $conn->query("
        SELECT * FROM vonna_faq 
    ")->fetchAll();


?><!DOCTYPE html>
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
                          <h4>FAQ</h4>
                        </div>
                    </div>
                </nav>

                <div class="row mt-4">
                    <div class="col-md-4">
                        <?php 
                            $action = '';
                           if (isset($_GET['edit'])) {
                                // code...
                                $action = '?edit=' . $_GET['edit'];
                            }
                        ?>
                        <form method="POST" action="Faq<?= $action; ?>" id="faq_form" class="mb-4">
                            <?= $message; ?>
                                <div class="mb-3">
                                    <label for="faq_head" class="form-label">Question</label>
                                    <input type="text" class="form-control form-control-sm" name="faq_head" id="faq_head" value="<?= $faq_head; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="faq_body" class="form-label">Answer</label>
                                    <textarea type="text" rows="10" class="form-control form-control-sm" name="faq_body" id="faq_body" required><?= $faq_body; ?></textarea>
                                </div>
                            <button type="submit" class="btn btn-sm btn-outline-warning" name="submit_faq" id="submit_faq"><?= ((isset($_GET["edit"]) || isset($_GET['edit-parent']))?'Edit':'Add'); ?> Faq</button>
                            <?php if(isset($_GET['edit']) || isset($_GET['edit-parent'])): ?>&nbsp;
                            <a href="<?= PROOT; ?>adminvonna/Faq" class="btn btn-sm btn-outline-danger btn-sm">Cancel</a>
                            <?php endif; ?>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Question</th>
                                        <th scope="col">Answer</th>
                                        <th scope="col">Date</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?= get_all_faqs(); ?>
                                </tbody>
                            </table>
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
        
        function delete_faq_all(id) {
            if (confirm("Faq will be DELETED.") == true) {
                window.location = '<?= PROOT; ?>adminvonna/Faq?trash='+id+'';
            } else {
                return false;
            }
        }
    </script>
</body>
</html>