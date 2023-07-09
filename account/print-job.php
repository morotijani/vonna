<?php 
    // INDEX PAGE
    //echo md5(uniqid(mt_rand(), true)) . '<br>';
    //echo time() . mt_rand() . 23;
    require_once ('./../db_connection/conn.php');
    if (!user_is_logged_in()) {
        user_login_redirect();
    }
    include ('../inc/header.inc.php');
    include ('header.account.php');

    $message = '';
    if (isset($_SERVER['REQUEST_METHOD']) == 'POST' && isset($_POST['printjobSubmitButton'])) {
        $post = (cleanPost(isset($_POST) ? $_POST : ''));

        if (isset($_POST['print_type'])) {
            if ($post['print_type'] == "Examination questions") {
                $print_type = ((isset($_POST['print_type']) && !empty($_POST['print_type'])) ? $post['print_type'] : '');
                // $name_of_subject = ((isset($_POST['name_of_subject']) && !empty($_POST['name_of_subject'])) ? $post['name_of_subject'] : '');
                // $number_to_be_printed = ((isset($_POST['number_to_be_printed']) && !empty($_POST['number_to_be_printed'])) ? $post['number_to_be_printed'] : '');
                // $level = ((isset($_POST['level']) && !empty($_POST['level'])) ? $post['level'] : '');
                // $class_or_form = ((isset($_POST['class_or_form']) && !empty($_POST['class_or_form'])) ? $post['class_or_form'] : '');
                $total_students = ((isset($_POST['total_students']) && !empty($_POST['total_students'])) ? $post['total_students'] : '');
                $typed_already = ((isset($_POST['typed_already']) && !empty($_POST['typed_already'])) ? $post['typed_already'] : '');
                $want_us_to_type = ((isset($_POST['want_us_to_type']) && !empty($_POST['want_us_to_type'])) ? $post['want_us_to_type'] : '');
                $when_to_be_delivered = ((isset($_POST['when_to_be_delivered']) && !empty($_POST['when_to_be_delivered'])) ? $post['when_to_be_delivered'] : '');;
                $delivery_address_1 = ((isset($_POST['delivery_address_1']) && !empty($_POST['delivery_address_1'])) ? $post['delivery_address_1'] : '');
                $delivery_address_2 = ((isset($_POST['delivery_address_2']) && !empty($_POST['delivery_address_2'])) ? $post['delivery_address_2'] : '');

                $count_subjects = count($post['name_of_subject']);
                if ($count_subjects > 0) {
                    $name_of_subject = '';
                    $number_to_be_printed = '';
                    $level = '';
                    $class_or_form = '';
                    for ($i = 0; $i < $count_subjects; $i++) {
                        if ($post['name_of_subject'][$i] != '') {
                            $name_of_subject .= $post['name_of_subject'][$i] . ',';
                            $number_to_be_printed .= $post['number_to_be_printed'][$i] . ',';
                            $level .= $post['level'][$i] . ',';
                            $class_or_form .= $post['class_or_form'][$i] . ',';
                        }
                    }
                }

                $upload_typed_work = '';
                if (isset($_FILES['upload_typed_work'])) {
                    $count_files = count($_FILES['upload_typed_work']['name']);
                    for ($i = 0; $i < $count_files; $i++) {
                        if (!empty($_FILES['upload_typed_work']['name'][$i])) {
                            $fileName = $_FILES['upload_typed_work']['name'][$i];
                            $fileSize = $_FILES['upload_typed_work']['size'][$i];
                            $fileType = $_FILES['upload_typed_work']['type'][$i];
                            $fileTmpName = $_FILES['upload_typed_work']['tmp_name'][$i];
                            $fileError = $_FILES['upload_typed_work']['error'][$i];

                            $fileExt = explode('.', $fileName);
                            $fileActualExt = strtolower(end($fileExt));

                            $maxSize = 10000000; //10mb 
                            $allowed = array('jpg', 'pdf','jpeg', 'pdf', 'png');

                            if (in_array($fileActualExt, $allowed)) {
                                if ($fileError === 0) {
                                    if ($fileSize < $maxSize) {
                                        $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                        $fileDestination =  'media/uploads/' . $fileNewName;
                                        if (file_exists($fileDestination)) {
                                            $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                            $fileDestination = 'media/uploads/' . $fileNewName;
                                        }
                                        $moveFiles = move_uploaded_file($fileTmpName, $fileDestination);
                                        if ($moveFiles) {
                                            $upload_typed_work .= $fileDestination . ',';
                                        } else {
                                            $message = 'Your file(s) was not able to upload.';
                                        }
                                    } else {
                                    }
                                } else {
                                    $message = 'There was an error uploading your file(s).';
                                }
                            } else {
                                $message = 'You cannot upload file(s) of this type!';
                            }
                        }
                    }
                }


                $printjob_id = time() . mt_rand() . $user_id;
                $printjob_createdAt = date('Y-m-d H:i:s');

                $data = [$printjob_id, $user_id, rtrim($name_of_subject, ', '), rtrim($number_to_be_printed, ', '), rtrim($level, ', '), rtrim($class_or_form, ', '), $total_students, $typed_already, rtrim($upload_typed_work, ', '), $want_us_to_type, $when_to_be_delivered, $delivery_address_1, $delivery_address_2, $printjob_createdAt];
                $query = "
                    INSERT INTO `vonna_printjob` (`printjob_id`, `printjob_userid`, `printjob_name_of_subject`, `printjob_number_to_be_printed`, `printjob_level`, `printjob_class_or_form`, `printjob_total_students`, `printjob_typed_already`, `printjob_upload_typed_work`, `printjob_want_us_to_type`, `printjob_when_to_be_delivered`, `printjob_delivery_address_1`, `printjob_delivery_address_2`, `printjob_createdAt`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";
                   
            
            } else if ($post['print_type'] == "Thesis") {
                $already_have_tr = ((isset($_POST['already_have_tr']) && !empty($_POST['already_have_tr'])) ? sanitize($_POST['already_have_tr']) : '');
                $your_thesis_research = ((isset($_POST['your_thesis_research']) && !empty($_POST['your_thesis_research'])) ? sanitize($_POST['your_thesis_research']) : '');
                $get_for_you = ((isset($_POST['get_for_you']) && !empty($_POST['get_for_you'])) ? sanitize($_POST['get_for_you']) : '');
                $have_you_typed = ((isset($_POST['have_you_typed']) && !empty($_POST['have_you_typed'])) ? sanitize($_POST['have_you_typed']) : '');
                $handle_typing = ((isset($_POST['handle_typing']) && !empty($_POST['handle_typing'])) ? sanitize($_POST['handle_typing']) : '');
                $final_editing = ((isset($_POST['final_editing']) && !empty($_POST['final_editing'])) ? sanitize($_POST['final_editing']) : '');
                //$upload_work_tr = ((isset($_POST['upload_work_tr']) && !empty($_POST['upload_work_tr'])) ? sanitize($_POST['upload_work_tr']) : '');
                //$upload_tr = ((isset($_POST['upload_tr']) && !empty($_POST['upload_tr'])) ? sanitize($_POST['upload_tr']) : '');
                $delivered_tr = ((isset($_POST['delivered_tr']) && !empty($_POST['delivered_tr'])) ? sanitize($_POST['delivered_tr']) : '');
                $day_week = ((isset($_POST['day_week']) && !empty($_POST['day_week'])) ? sanitize($_POST['day_week']) : '');
                $thesis_id = time() . mt_rand() . $user_id;
                $createdAt = date('Y-m-d H:i:s');

                $upload_work_tr = '';
                if (isset($_FILES['upload_work_tr'])) {
                    $count_files = count($_FILES['upload_work_tr']['name']);
                    for ($i = 0; $i < $count_files; $i++) {
                        if (!empty($_FILES['upload_work_tr']['name'][$i])) {
                            $fileName = $_FILES['upload_work_tr']['name'][$i];
                            $fileSize = $_FILES['upload_work_tr']['size'][$i];
                            $fileType = $_FILES['upload_work_tr']['type'][$i];
                            $fileTmpName = $_FILES['upload_work_tr']['tmp_name'][$i];
                            $fileError = $_FILES['upload_work_tr']['error'][$i];

                            $fileExt = explode('.', $fileName);
                            $fileActualExt = strtolower(end($fileExt));

                            $maxSize = 10000000; //10mb 
                            $allowed = array('jpg', 'pdf','jpeg', 'pdf', 'png');

                            if (in_array($fileActualExt, $allowed)) {
                                if ($fileError === 0) {
                                    if ($fileSize < $maxSize) {
                                        $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                        $fileDestination =  'media/uploads/' . $fileNewName;
                                        if (file_exists($fileDestination)) {
                                            $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                            $fileDestination = 'media/uploads/' . $fileNewName;
                                        }
                                        $moveFiles = move_uploaded_file($fileTmpName, $fileDestination);
                                        if ($moveFiles) {
                                            $upload_work_tr .= $fileDestination . ',';
                                        } else {
                                            $message = 'Your file(s) was not able to upload.';
                                        }
                                    } else {
                                    }
                                } else {
                                    $message = 'There was an error uploading your file(s).';
                                }
                            } else {
                                $message = 'You cannot upload file(s) of this type!';
                            }
                        }
                    }
                }

                $upload_tr = '';
                if (isset($_FILES['upload_tr'])) {
                    $count_files = count($_FILES['upload_tr']['name']);
                    for ($i = 0; $i < $count_files; $i++) {
                        if (!empty($_FILES['upload_tr']['name'][$i])) {
                            $fileName = $_FILES['upload_tr']['name'][$i];
                            $fileSize = $_FILES['upload_tr']['size'][$i];
                            $fileType = $_FILES['upload_tr']['type'][$i];
                            $fileTmpName = $_FILES['upload_tr']['tmp_name'][$i];
                            $fileError = $_FILES['upload_tr']['error'][$i];

                            $fileExt = explode('.', $fileName);
                            $fileActualExt = strtolower(end($fileExt));

                            $maxSize = 10000000; //10mb 
                            $allowed = array('jpg', 'pdf','jpeg', 'pdf', 'png');

                            if (in_array($fileActualExt, $allowed)) {
                                if ($fileError === 0) {
                                    if ($fileSize < $maxSize) {
                                        $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                        $fileDestination =  'media/uploads/' . $fileNewName;
                                        if (file_exists($fileDestination)) {
                                            $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                            $fileDestination = 'media/uploads/' . $fileNewName;
                                        }
                                        $moveFiles = move_uploaded_file($fileTmpName, $fileDestination);
                                        if ($moveFiles) {
                                            $upload_tr .= $fileDestination . ',';
                                        } else {
                                            $message = 'Your file(s) was not able to upload.';
                                        }
                                    } else {
                                    }
                                } else {
                                    $message = 'There was an error uploading your file(s).';
                                }
                            } else {
                                $message = 'You cannot upload file(s) of this type!';
                            }
                        }
                    }
                }

                $data = [$thesis_id, $user_id, $already_have_tr, $your_thesis_research, $get_for_you, $have_you_typed, $handle_typing, $final_editing, rtrim($upload_work_tr, ', '), rtrim($upload_tr, ', '), $delivered_tr, $day_week, $createdAt];
                $query = "
                    INSERT INTO `vonna_printjob_thesis`(`thesis_id`, `thesis_userid`, `thesis_already_have_tr`, `thesis_your_thesis_research`, `thesis_get_for_you`, `thesis_have_you_typed`, `thesis_handle_typing`, `thesis_final_editing`, `thesis_upload_work_tr`, `thesis_upload_tr`, `thesis_delivered_tr`, `thesis_day_week`, `thesis_createdAt`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";
            } else if ($post['print_type'] == "Fliers") {
                $size_to_print = ((isset($_POST['size_to_print']) && !empty($_POST['size_to_print'])) ? sanitize($_POST['size_to_print']) : '');
                $quantity_to_print = ((isset($_POST['quantity_to_print']) && !empty($_POST['quantity_to_print'])) ? sanitize($_POST['quantity_to_print']) : '');
                $have_designs = ((isset($_POST['have_designs']) && !empty($_POST['have_designs'])) ? sanitize($_POST['have_designs']) : '');
                $us_to_design = ((isset($_POST['us_to_design']) && !empty($_POST['us_to_design'])) ? sanitize($_POST['us_to_design']) : '');
                $flier_for = ((isset($_POST['flier_for']) && !empty($_POST['flier_for'])) ? sanitize($_POST['flier_for']) : '');
                // $design_file = ((isset($_POST['design_file']) && !empty($_POST['design_file'])) ? sanitize($_POST['design_file']) : '');
                $date_to_deliver = ((isset($_POST['date_to_deliver']) && !empty($_POST['date_to_deliver'])) ? sanitize($_POST['date_to_deliver']) : '');
                $flier_id = time() . mt_rand() . $user_id;
                $createdAt = date('Y-m-d H:i:s');

                $design_file = '';
                if (isset($_FILES['design_file'])) {
                    $count_files = count($_FILES['design_file']['name']);
                    for ($i = 0; $i < $count_files; $i++) {
                        if (!empty($_FILES['design_file']['name'][$i])) {
                            $fileName = $_FILES['design_file']['name'][$i];
                            $fileSize = $_FILES['design_file']['size'][$i];
                            $fileType = $_FILES['design_file']['type'][$i];
                            $fileTmpName = $_FILES['design_file']['tmp_name'][$i];
                            $fileError = $_FILES['design_file']['error'][$i];

                            $fileExt = explode('.', $fileName);
                            $fileActualExt = strtolower(end($fileExt));

                            $maxSize = 10000000; //10mb 
                            $allowed = array('jpg', 'pdf','jpeg', 'pdf', 'png');

                            if (in_array($fileActualExt, $allowed)) {
                                if ($fileError === 0) {
                                    if ($fileSize < $maxSize) {
                                        $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                        $fileDestination =  'media/uploads/' . $fileNewName;
                                        if (file_exists($fileDestination)) {
                                            $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                            $fileDestination = 'media/uploads/' . $fileNewName;
                                        }
                                        $moveFiles = move_uploaded_file($fileTmpName, $fileDestination);
                                        if ($moveFiles) {
                                            $design_file .= $fileDestination . ',';
                                        } else {
                                            $message = 'Your file(s) was not able to upload.';
                                        }
                                    } else {
                                    }
                                } else {
                                    $message = 'There was an error uploading your file(s).';
                                }
                            } else {
                                $message = 'You cannot upload file(s) of this type!';
                            }
                        }
                    }
                }

                $data = [$flier_id, $user_id, $size_to_print, $quantity_to_print, $have_designs, $us_to_design, $flier_for, rtrim($design_file, ', '), $date_to_deliver, $createdAt];
                $query = "
                    INSERT INTO `vonna_printjob_fliers`(`flier_id`, `flier_userid`, `flier_size_to_print`, `flier_quantity_to_print`, `flier_have_designs`, `flier_us_to_design`, `flier_for`, `flier_design_file`, `flier_date_to_deliver`, `flier_createdAt`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";

            } else if ($post['print_type'] == "Banners") {
                $banner_size = ((isset($_POST['banner_size']) && !empty($_POST['banner_size'])) ? sanitize($_POST['banner_size']) : '');
                $banner_quantity = ((isset($_POST['banner_quantity']) && !empty($_POST['banner_quantity'])) ? sanitize($_POST['banner_quantity']) : '');
                $have_banner_designs = ((isset($_POST['have_banner_designs']) && !empty($_POST['have_banner_designs'])) ? sanitize($_POST['have_banner_designs']) : '');
                // $upload_design = ((isset($_POST['upload_design']) && !empty($_POST['upload_design'])) ? sanitize($_POST['upload_design']) : '');
                $want_us = ((isset($_POST['want_us']) && !empty($_POST['want_us'])) ? sanitize($_POST['want_us']) : '');
                $banner_id = time() . mt_rand() . $user_id;
                $createdAt = date('Y-m-d H:i:s');

                $upload_design = '';
                if (isset($_FILES['upload_design'])) {
                    $count_files = count($_FILES['upload_design']['name']);
                    for ($i = 0; $i < $count_files; $i++) {
                        if (!empty($_FILES['upload_design']['name'][$i])) {
                            $fileName = $_FILES['upload_design']['name'][$i];
                            $fileSize = $_FILES['upload_design']['size'][$i];
                            $fileType = $_FILES['upload_design']['type'][$i];
                            $fileTmpName = $_FILES['upload_design']['tmp_name'][$i];
                            $fileError = $_FILES['upload_design']['error'][$i];

                            $fileExt = explode('.', $fileName);
                            $fileActualExt = strtolower(end($fileExt));

                            $maxSize = 10000000; //10mb 
                            $allowed = array('jpg', 'pdf','jpeg', 'pdf', 'png');

                            if (in_array($fileActualExt, $allowed)) {
                                if ($fileError === 0) {
                                    if ($fileSize < $maxSize) {
                                        $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                        $fileDestination =  'media/uploads/' . $fileNewName;
                                        if (file_exists($fileDestination)) {
                                            $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                            $fileDestination = 'media/uploads/' . $fileNewName;
                                        }
                                        $moveFiles = move_uploaded_file($fileTmpName, $fileDestination);
                                        if ($moveFiles) {
                                            $upload_design .= $fileDestination . ',';
                                        } else {
                                            $message = 'Your file(s) was not able to upload.';
                                        }
                                    } else {
                                    }
                                } else {
                                    $message = 'There was an error uploading your file(s).';
                                }
                            } else {
                                $message = 'You cannot upload file(s) of this type!';
                            }
                        }
                    }
                }
                $data = [$banner_id, $user_id, $banner_size, $banner_quantity, $have_banner_designs, rtrim($upload_design, ', '), $want_us, $createdAt];
                $query = "
                    INSERT INTO `vonna_printjob_banners`(`banner_id`, `banner_userid`, `banner_size`, `banner_quantity`, `have_banner_designs`, `banner_upload_design`, `banner_want_us`, `banner_createdAt`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ";
            } else if ($post['print_type'] == "Receipt books") {
                $outfit_name = ((isset($_POST['outfit_name']) && !empty($_POST['outfit_name'])) ? sanitize($_POST['outfit_name']) : '');
                $receipt_type = ((isset($_POST['receipt_type']) && !empty($_POST['receipt_type'])) ? sanitize($_POST['receipt_type']) : '');
                $receipt_quantity = ((isset($_POST['receipt_quantity']) && !empty($_POST['receipt_quantity'])) ? sanitize($_POST['receipt_quantity']) : '');
                $want_logo = ((isset($_POST['want_logo']) && !empty($_POST['want_logo'])) ? sanitize($_POST['want_logo']) : '');
                // $upload_logo = ((isset($_POST['upload_logo']) && !empty($_POST['upload_logo'])) ? sanitize($_POST['upload_logo']) : '');
                $receipt_delivery_date = ((isset($_POST['receipt_delivery_date']) && !empty($_POST['receipt_delivery_date'])) ? sanitize($_POST['receipt_delivery_date']) : '');
                // $upload_outfit_design = ((isset($_POST['upload_outfit_design']) && !empty($_POST['upload_outfit_design'])) ? sanitize($_POST['upload_outfit_design']) : '');
                $receipt_id = time() . mt_rand() . $user_id;
                $createdAt = date('Y-m-d H:i:s');
                
                $upload_logo = '';
                if (isset($_FILES['upload_logo'])) {
                    $count_files = count($_FILES['upload_logo']['name']);
                    for ($i = 0; $i < $count_files; $i++) {
                        if (!empty($_FILES['upload_logo']['name'][$i])) {
                            $fileName = $_FILES['upload_logo']['name'][$i];
                            $fileSize = $_FILES['upload_logo']['size'][$i];
                            $fileType = $_FILES['upload_logo']['type'][$i];
                            $fileTmpName = $_FILES['upload_logo']['tmp_name'][$i];
                            $fileError = $_FILES['upload_logo']['error'][$i];

                            $fileExt = explode('.', $fileName);
                            $fileActualExt = strtolower(end($fileExt));

                            $maxSize = 10000000; //10mb 
                            $allowed = array('jpg', 'pdf','jpeg', 'pdf', 'png');

                            if (in_array($fileActualExt, $allowed)) {
                                if ($fileError === 0) {
                                    if ($fileSize < $maxSize) {
                                        $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                        $fileDestination =  'media/uploads/' . $fileNewName;
                                        if (file_exists($fileDestination)) {
                                            $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                            $fileDestination = 'media/uploads/' . $fileNewName;
                                        }
                                        $moveFiles = move_uploaded_file($fileTmpName, $fileDestination);
                                        if ($moveFiles) {
                                            $upload_logo .= $fileDestination . ',';
                                        } else {
                                            $message = 'Your file(s) was not able to upload.';
                                        }
                                    } else {
                                    }
                                } else {
                                    $message = 'There was an error uploading your file(s).';
                                }
                            } else {
                                $message = 'You cannot upload file(s) of this type!';
                            }
                        }
                    }
                }

                $upload_outfit_design = '';
                if (isset($_FILES['upload_outfit_design'])) {
                    $count_files = count($_FILES['upload_outfit_design']['name']);
                    for ($i = 0; $i < $count_files; $i++) {
                        if (!empty($_FILES['upload_outfit_design']['name'][$i])) {
                            $fileName = $_FILES['upload_outfit_design']['name'][$i];
                            $fileSize = $_FILES['upload_outfit_design']['size'][$i];
                            $fileType = $_FILES['upload_outfit_design']['type'][$i];
                            $fileTmpName = $_FILES['upload_outfit_design']['tmp_name'][$i];
                            $fileError = $_FILES['upload_outfit_design']['error'][$i];

                            $fileExt = explode('.', $fileName);
                            $fileActualExt = strtolower(end($fileExt));

                            $maxSize = 10000000; //10mb 
                            $allowed = array('jpg', 'pdf','jpeg', 'pdf', 'png');

                            if (in_array($fileActualExt, $allowed)) {
                                if ($fileError === 0) {
                                    if ($fileSize < $maxSize) {
                                        $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                        $fileDestination =  'media/uploads/' . $fileNewName;
                                        if (file_exists($fileDestination)) {
                                            $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                            $fileDestination = 'media/uploads/' . $fileNewName;
                                        }
                                        $moveFiles = move_uploaded_file($fileTmpName, $fileDestination);
                                        if ($moveFiles) {
                                            $upload_outfit_design .= $fileDestination . ',';
                                        } else {
                                            $message = 'Your file(s) was not able to upload.';
                                        }
                                    } else {
                                    }
                                } else {
                                    $message = 'There was an error uploading your file(s).';
                                }
                            } else {
                                $message = 'You cannot upload file(s) of this type!';
                            }
                        }
                    }
                }
                $data = [$receipt_id, $user_id, $outfit_name, $receipt_type, $receipt_quantity, $want_logo, rtrim($upload_logo, ', '), $receipt_delivery_date, rtrim($upload_outfit_design, ', '), $createdAt];
                $query = "
                    INSERT INTO `vonna_print_job_receipt`(`receipt_id`, `receipt_userid`, `receipt_outfit_name`, `receipt_type`, `receipt_quantity`, `receipt_want_logo`, `receipt_upload_logo`, `receipt_delivery_date`, `receipt_upload_outfit_design`, `receipt_createdAt`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";
            } else if ($post['print_type'] == "Invoice") {
                $outfit_name = ((isset($_POST['outfit_name']) && !empty($_POST['outfit_name'])) ? sanitize($_POST['outfit_name']) : '');
                $receipt_type = ((isset($_POST['receipt_type']) && !empty($_POST['receipt_type'])) ? sanitize($_POST['receipt_type']) : '');
                $receipt_quantity = ((isset($_POST['receipt_quantity']) && !empty($_POST['receipt_quantity'])) ? sanitize($_POST['receipt_quantity']) : '');
                $want_logo = ((isset($_POST['want_logo']) && !empty($_POST['want_logo'])) ? sanitize($_POST['want_logo']) : '');
                // $upload_logo = ((isset($_POST['upload_logo']) && !empty($_POST['upload_logo'])) ? sanitize($_POST['upload_logo']) : '');
                $receipt_delivery_date = ((isset($_POST['receipt_delivery_date']) && !empty($_POST['receipt_delivery_date'])) ? sanitize($_POST['receipt_delivery_date']) : '');
                // $upload_outfit_design = ((isset($_POST['upload_outfit_design']) && !empty($_POST['upload_outfit_design'])) ? sanitize($_POST['upload_outfit_design']) : '');
                $receipt_id = time() . mt_rand() . $user_id;
                $createdAt = date('Y-m-d H:i:s');
                
                $upload_logo = '';
                if (isset($_FILES['upload_logo'])) {
                    $count_files = count($_FILES['upload_logo']['name']);
                    for ($i = 0; $i < $count_files; $i++) {
                        if (!empty($_FILES['upload_logo']['name'][$i])) {
                            $fileName = $_FILES['upload_logo']['name'][$i];
                            $fileSize = $_FILES['upload_logo']['size'][$i];
                            $fileType = $_FILES['upload_logo']['type'][$i];
                            $fileTmpName = $_FILES['upload_logo']['tmp_name'][$i];
                            $fileError = $_FILES['upload_logo']['error'][$i];

                            $fileExt = explode('.', $fileName);
                            $fileActualExt = strtolower(end($fileExt));

                            $maxSize = 10000000; //10mb 
                            $allowed = array('jpg', 'pdf','jpeg', 'pdf', 'png');

                            if (in_array($fileActualExt, $allowed)) {
                                if ($fileError === 0) {
                                    if ($fileSize < $maxSize) {
                                        $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                        $fileDestination =  'media/uploads/' . $fileNewName;
                                        if (file_exists($fileDestination)) {
                                            $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                            $fileDestination = 'media/uploads/' . $fileNewName;
                                        }
                                        $moveFiles = move_uploaded_file($fileTmpName, $fileDestination);
                                        if ($moveFiles) {
                                            $upload_logo .= $fileDestination . ',';
                                        } else {
                                            $message = 'Your file(s) was not able to upload.';
                                        }
                                    } else {
                                    }
                                } else {
                                    $message = 'There was an error uploading your file(s).';
                                }
                            } else {
                                $message = 'You cannot upload file(s) of this type!';
                            }
                        }
                    }
                }

                $upload_outfit_design = '';
                if (isset($_FILES['upload_outfit_design'])) {
                    $count_files = count($_FILES['upload_outfit_design']['name']);
                    for ($i = 0; $i < $count_files; $i++) {
                        if (!empty($_FILES['upload_outfit_design']['name'][$i])) {
                            $fileName = $_FILES['upload_outfit_design']['name'][$i];
                            $fileSize = $_FILES['upload_outfit_design']['size'][$i];
                            $fileType = $_FILES['upload_outfit_design']['type'][$i];
                            $fileTmpName = $_FILES['upload_outfit_design']['tmp_name'][$i];
                            $fileError = $_FILES['upload_outfit_design']['error'][$i];

                            $fileExt = explode('.', $fileName);
                            $fileActualExt = strtolower(end($fileExt));

                            $maxSize = 10000000; //10mb 
                            $allowed = array('jpg', 'pdf','jpeg', 'pdf', 'png');

                            if (in_array($fileActualExt, $allowed)) {
                                if ($fileError === 0) {
                                    if ($fileSize < $maxSize) {
                                        $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                        $fileDestination =  'media/uploads/' . $fileNewName;
                                        if (file_exists($fileDestination)) {
                                            $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                            $fileDestination = 'media/uploads/' . $fileNewName;
                                        }
                                        $moveFiles = move_uploaded_file($fileTmpName, $fileDestination);
                                        if ($moveFiles) {
                                            $upload_outfit_design .= $fileDestination . ',';
                                        } else {
                                            $message = 'Your file(s) was not able to upload.';
                                        }
                                    } else {
                                    }
                                } else {
                                    $message = 'There was an error uploading your file(s).';
                                }
                            } else {
                                $message = 'You cannot upload file(s) of this type!';
                            }
                        }
                    }
                }
                $data = [$receipt_id, $user_id, $outfit_name, $receipt_type, $receipt_quantity, $want_logo, rtrim($upload_logo, ', '), $receipt_delivery_date, rtrim($upload_outfit_design, ', '), $createdAt];
                $query = "
                    INSERT INTO `vonna_print_job_invoice`(`invoice_id`, `invoice_userid`, `invoice_outfit_name`, `invoice_type`, `invoice_quantity`, `invoice_want_logo`, `invoice_upload_logo`, `invoice_delivery_date`, `invoice_upload_outfit_design`, `invoice_createdAt`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";
            } else if ($post['print_type'] == "Customized office Files") {
                $customize_outfit_name = ((isset($_POST['customize_outfit_name']) && !empty($_POST['customize_outfit_name'])) ? sanitize($_POST['customize_outfit_name']) : '');
                $customize_outfit_address = ((isset($_POST['customize_outfit_address']) && !empty($_POST['customize_outfit_address'])) ? sanitize($_POST['customize_outfit_address']) : '');
                $customize_contact = ((isset($_POST['customize_contact']) && !empty($_POST['customize_contact'])) ? sanitize($_POST['customize_contact']) : '');
                $customize_email = ((isset($_POST['customize_email']) && !empty($_POST['customize_email'])) ? sanitize($_POST['customize_email']) : '');
                $customize_location = ((isset($_POST['customize_location']) && !empty($_POST['customize_location'])) ? sanitize($_POST['customize_location']) : '');
                $customize_gps = ((isset($_POST['customize_gps']) && !empty($_POST['customize_gps'])) ? sanitize($_POST['customize_gps']) : '');
                $customize_have_logo = ((isset($_POST['customize_have_logo']) && !empty($_POST['customize_have_logo'])) ? sanitize($_POST['customize_have_logo']) : '');
                // $customize_upload_logo = ((isset($_POST['customize_upload_logo']) && !empty($_POST['customize_upload_logo'])) ? sanitize($_POST['customize_upload_logo']) : '');
                $us_to_design_logo = ((isset($_POST['us_to_design_logo']) && !empty($_POST['us_to_design_logo'])) ? sanitize($_POST['us_to_design_logo']) : '');
                $customize_id = time() . mt_rand() . $user_id;
                $createdAt = date('Y-m-d H:i:s');

                $customize_upload_logo = '';
                if (isset($_FILES['customize_upload_logo'])) {
                    $count_files = count($_FILES['customize_upload_logo']['name']);
                    for ($i = 0; $i < $count_files; $i++) {
                        if (!empty($_FILES['customize_upload_logo']['name'][$i])) {
                            $fileName = $_FILES['customize_upload_logo']['name'][$i];
                            $fileSize = $_FILES['customize_upload_logo']['size'][$i];
                            $fileType = $_FILES['customize_upload_logo']['type'][$i];
                            $fileTmpName = $_FILES['customize_upload_logo']['tmp_name'][$i];
                            $fileError = $_FILES['customize_upload_logo']['error'][$i];

                            $fileExt = explode('.', $fileName);
                            $fileActualExt = strtolower(end($fileExt));

                            $maxSize = 10000000; //10mb 
                            $allowed = array('jpg', 'pdf','jpeg', 'pdf', 'png');

                            if (in_array($fileActualExt, $allowed)) {
                                if ($fileError === 0) {
                                    if ($fileSize < $maxSize) {
                                        $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                        $fileDestination =  'media/uploads/' . $fileNewName;
                                        if (file_exists($fileDestination)) {
                                            $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                            $fileDestination = 'media/uploads/' . $fileNewName;
                                        }
                                        $moveFiles = move_uploaded_file($fileTmpName, $fileDestination);
                                        if ($moveFiles) {
                                            $customize_upload_logo .= $fileDestination . ',';
                                        } else {
                                            $message = 'Your file(s) was not able to upload.';
                                        }
                                    } else {
                                    }
                                } else {
                                    $message = 'There was an error uploading your file(s).';
                                }
                            } else {
                                $message = 'You cannot upload file(s) of this type!';
                            }
                        }
                    }
                }

                $data = [$customize_id, $user_id, $customize_outfit_name, $customize_outfit_address, $customize_contact, $customize_email, $customize_location, $customize_gps, $customize_have_logo, rtrim($customize_upload_logo, ', '), $us_to_design_logo, $createdAt];
                $query = "
                    INSERT INTO `vonna_print_job_customze`(`customze_id`, `customze_userid`, `customize_outfit_name`, `customize_outfit_address`, `customize_contact`, `customize_email`, `customize_location`, `customize_gps`, `customize_have_logo`, `customize_upload_logo`, `customze_us_to_design_logo`, `customze_createdAt`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";
            } else if ($post['print_type'] == "Call cards") {
                $card_name = ((isset($_POST['card_name']) && !empty($_POST['card_name'])) ? sanitize($_POST['card_name']) : '');
                $card_company_name = ((isset($_POST['card_company_name']) && !empty($_POST['card_company_name'])) ? sanitize($_POST['card_company_name']) : '');
                $card_address = ((isset($_POST['card_address']) && !empty($_POST['card_address'])) ? sanitize($_POST['card_address']) : '');
                $card_email = ((isset($_POST['card_email']) && !empty($_POST['card_email'])) ? sanitize($_POST['card_email']) : '');
                $card_facebook = ((isset($_POST['card_facebook']) && !empty($_POST['card_facebook'])) ? sanitize($_POST['card_facebook']) : '');
                $card_instagram = ((isset($_POST['card_instagram']) && !empty($_POST['card_instagram'])) ? sanitize($_POST['card_instagram']) : '');
                $card_twitter = ((isset($_POST['card_twitter']) && !empty($_POST['card_twitter'])) ? sanitize($_POST['card_twitter']) : '');
                $card_tiktok = ((isset($_POST['card_tiktok']) && !empty($_POST['card_tiktok'])) ? sanitize($_POST['card_tiktok']) : '');
                $card_office_contact = ((isset($_POST['card_office_contact']) && !empty($_POST['card_office_contact'])) ? sanitize($_POST['card_office_contact']) : '');
                $card_personal_contact = ((isset($_POST['card_personal_contact']) && !empty($_POST['card_personal_contact'])) ? sanitize($_POST['card_personal_contact']) : '');
                $card_whatsapp = ((isset($_POST['card_whatsapp']) && !empty($_POST['card_whatsapp'])) ? sanitize($_POST['card_whatsapp']) : '');
                $card_have_logo = ((isset($_POST['card_have_logo']) && !empty($_POST['card_have_logo'])) ? sanitize($_POST['card_have_logo']) : '');
                // $card_upload_logo = ((isset($_POST['card_upload_logo']) && !empty($_POST['card_upload_logo'])) ? sanitize($_POST['card_upload_logo']) : '');
                $card_us_to_design_logo = ((isset($_POST['card_us_to_design_logo']) && !empty($_POST['card_us_to_design_logo'])) ? sanitize($_POST['card_us_to_design_logo']) : '');
                $card_id = time() . mt_rand() . $user_id;
                $createdAt = date('Y-m-d H:i:s');

                $card_upload_logo = '';
                if (isset($_FILES['card_upload_logo'])) {
                    $count_files = count($_FILES['card_upload_logo']['name']);
                    for ($i = 0; $i < $count_files; $i++) {
                        if (!empty($_FILES['card_upload_logo']['name'][$i])) {
                            $fileName = $_FILES['card_upload_logo']['name'][$i];
                            $fileSize = $_FILES['card_upload_logo']['size'][$i];
                            $fileType = $_FILES['card_upload_logo']['type'][$i];
                            $fileTmpName = $_FILES['card_upload_logo']['tmp_name'][$i];
                            $fileError = $_FILES['card_upload_logo']['error'][$i];

                            $fileExt = explode('.', $fileName);
                            $fileActualExt = strtolower(end($fileExt));

                            $maxSize = 10000000; //10mb 
                            $allowed = array('jpg', 'pdf','jpeg', 'pdf', 'png');

                            if (in_array($fileActualExt, $allowed)) {
                                if ($fileError === 0) {
                                    if ($fileSize < $maxSize) {
                                        $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                        $fileDestination =  'media/uploads/' . $fileNewName;
                                        if (file_exists($fileDestination)) {
                                            $fileNewName = uniqid('', true) . "." . $fileActualExt;
                                            $fileDestination = 'media/uploads/' . $fileNewName;
                                        }
                                        $moveFiles = move_uploaded_file($fileTmpName, $fileDestination);
                                        if ($moveFiles) {
                                            $card_upload_logo .= $fileDestination . ',';
                                        } else {
                                            $message = 'Your file(s) was not able to upload.';
                                        }
                                    } else {
                                    }
                                } else {
                                    $message = 'There was an error uploading your file(s).';
                                }
                            } else {
                                $message = 'You cannot upload file(s) of this type!';
                            }
                        }
                    }
                }

                $data = [$card_id, $user_id, $card_name, $card_company_name, $card_address, $card_email, $card_facebook, $card_instagram, $card_twitter, $card_tiktok, $card_office_contact, $card_personal_contact, $card_whatsapp, $card_have_logo, rtrim($card_upload_logo, ', '), $card_us_to_design_logo, $createdAt];
                $query = "
                    INSERT INTO `vonna_printjob_callcards`(`card_id`, `card_userid`, `card_name`, `card_company_name`, `card_address`, `card_email`, `card_facebook`, `card_instagram`, `card_twitter`, `card_tiktok`, `card_office_contact`, `card_personal_contact`, `card_whatsapp`, `card_have_logo`, `card_upload_logo`, `card_us_to_design_logo`, `card_createdAt`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";
            }

            if (!empty($message)) {
                echo js_alert($message);
            } else {
                $statement = $conn->prepare($query);
                $result = $statement->execute($data);
                if ($result) {
                    $_SESSION['flash_success'] = 'Print job send successfully';
                    redirect(PROOT . 'account/print-job');
                }
            }
        }

    }

?>


    <!-- BODY -->
    <main class="">
        <?= $flash; ?>
        <div class="container-lg d-flex flex-column">
            <div class="row align-items-start justify-content-center">
                <div class="col-lg-12 py-6 py-md-9">
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= PROOT; ?>account/print-job">Print Job</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="<?= PROOT; ?>account/printjob-requests">Requests</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="<?= PROOT; ?>account/print-job">Rerefesh</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="<?= PROOT; ?>account/index">Go home</a>
                        </li>
                    </ul>
                    <section class="py-1">
                        <h2 class="display-3 text-center mb-4">
                            Print <span class="text-underline-warning">job</span>
                        </h2>
                        <form id="printjobForm" method="POST" enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label class="visually-hidden" for="print-type">
                                    what print job do you want?
                                </label>
                                <select class="form-control" id="print-type" name="print_type" type="text" required>
                                    <option value="">what print job do you want?</option>
                                    <option value="Examination questions">Examination questions</option>
                                    <option value="Thesis">Thesis</option>
                                    <option value="Fliers">Fliers</option>
                                    <option value="Banners">Banners</option>
                                    <option value="Receipt books">Receipt books</option>
                                    <option value="Invoice">Invoice</option>
                                    <option value="Customized office Files">Customized office Files</option>
                                    <option value="Call cards">Call cards</option>
                                </select>
                            </div>
 
                            <div class="exams d-none">
                                <table class="table table-sm">  
                                    <tbody id="dynamic_field">
                                        <tr>  
                                            <td><input type="text" name="name_of_subject[]" placeholder="Name of subject" class="form-control name-of-subject"></td>  
                                            <td><input type="number" min='0' name="number_to_be_printed[]" placeholder="Number to be printed" class="form-control number-to-be-printed"></td>  
                                            <td>
                                                <select type="text" name="level[]" class="form-control level">
                                                    <option value="">Level</option>
                                                    <option value="Tertiary">Tertiary</option>
                                                    <option value="SHS">SHS</option>
                                                    <option value="JHS">JHS</option>
                                                    <option value="Primary">Primary</option>
                                                    <option value="Kindargarten">Kindargarten</option>
                                                    <option value="Nursery">Nursery</option>
                                                </select>
                                            </td>  
                                            <td><input type="text" name="class_or_form[]" placeholder="Class/Form" class="form-control class-or-form"></td>  
                                            <td><button type="button" name="add" id="add" class="btn btn-sm btn-success">Add subject</button></td>  
                                        </tr>  
                                    </tbody>
                                </table>

                                <div class="form-group">
                                    <input type="number" class="form-control" name="total_students" id="total_students" min="0" placeholder="What is the total size of your student body?">
                                </div>


                                <label>Do you have the questions typed already?</label>
                                <br>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="typed_already" id="typed-alreadyYes" value="Yes">
                                    <label class="form-check-label" for="typed-alreadyYes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="typed_already" id="typed-alreadyNo" value="No">
                                    <label class="form-check-label" for="typed-alreadyNo">
                                        No
                                    </label>
                                </div>

                                <div class="form-group d-none yes-typed mb-3">
                                    <label for="upload-typed-work">If yes, upload your typed work here?</label>
                                    <input type="file" name="upload_typed_work[]" multiple id="upload-typed-work" class="form-control" accept="application/msword, application/vnd.ms-powerpoint, text/plain, application/pdf, .doc, .docx, image/*">
                                </div>

                                <div class="d-none no-typed mb-3">
                                    <label for="">If no, Do you want us to type for you?</label>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="want_us_to_type" id="want-us-to-typeYes" value="Yes">
                                        <label for="want-us-to-typeYes" class="form-check-label">Yes</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="want_us_to_type" id="want-us-to-typeNo" value="No">
                                        <label for="want-us-to-typeNo" class="form-check-label">No</label>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <select name="when_to_be_delivered" id="when-to-be-delivered" class="form-control">
                                        <option value="">When do you want the print job delivered?</option>
                                        <option value="Hours">Hours</option>
                                        <option value="Days">Days</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Enter devlivery Address here</label>
                                    <input type="text" name="delivery_address_1" class="form-control" id="" placeholder="Receipient Contact 1">
                                    <br>
                                    <input type="text" name="delivery_address_2" class="form-control" id="" placeholder="Receipient Contact 2">
                                </div>
                            </div>

                            <!-- THESIS/RESEARCH -->
                            <div class="thesis d-none">
                                <label for="">Do you have a thesis/research topic already?</label>
                                <br>
                                <div class="form-check mb-3">
                                    <input type="radio" class="form-check-input" name="already_have_tr" id="already-have-trYes" value="Yes">
                                    <label for="already-have-trYes" class="form-check-label">Yes</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="already_have_tr" id="already-have-trNo" value="No">
                                    <label for="already-have-trNo" class="form-check-label">No</label>
                                </div>

                                <div class="form-group d-none yes-have">
                                    <input type="text" name="your_thesis_research" id="your-thesis-research" class="form-control" placeholder="If yes, What is your thesis/research topic?">
                                </div>

                                <div class="d-none no-have mb-3">
                                    <label for="">if no, would you want us to get you a suitable research/thesis topic?</label>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="get_for_you" id="get-for-youYes" value="Yes">
                                        <label for="get-for-youYes" class="form-check-label">Yes</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="get_for_you" id="get-for-youNo" value="No">
                                        <label for="get-for-youNo" class="form-check-label">No</label>
                                    </div>
                                </div>

                                <label for="">Have you typed your thesis/research already?</label>
                                <br>
                                <div class="form-check mb-3">
                                    <input type="radio" class="form-check-input" name="have_you_typed" id="have-you-typedYes" value="Yes">
                                    <label for="have-you-typedYes" class="form-check-label">Yes</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="have_you_typed" id="have-you-typedNo" value="No">
                                    <label for="have-you-typedNo" class="form-check-label">No</label>
                                </div>

                                <div class="d-none no-typed-tr mb-3">
                                    <label for="">if no, do you want us to handle the typing of your thesis/research for you?</label>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="handle_typing" id="handle-typingYes" value="Yes">
                                        <label for="handle-typingYes" class="form-check-label">Yes</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="handle_typing" id="handle-typingNo" value="No">
                                        <label for="handle-typingNo" class="form-check-label">No</label>
                                    </div>
                                </div>

                                <label for="">Have you effected the final editing to your thesis/research topic already?</label>
                                <br>
                                <div class="form-check mb-3">
                                    <input type="radio" class="form-check-input" name="final_editing" id="final-editingYes" value="Yes">
                                    <label for="final-editingYes" class="form-check-label">Yes</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="final_editing" id="final-editingNo" value="No">
                                    <label for="final-editingNo" class="form-check-label">No</label>
                                </div>

                                <div class="form-group d-none yes-effected">
                                    <label for="upload-typed-work">If yes , Upload your work here</label>
                                    <input type="file" name="upload_work_tr[]" multiple id="upload-work-tr" class="form-control" accept="application/msword, application/vnd.ms-powerpoint, text/plain, application/pdf, .doc, .docx, image/*">
                                </div>

                                <div class="form-group d-none no-effected mb-3">
                                    <label for="upload-typed-work">If no, upload your thesis/research so far</label>
                                    <input type="file" name="upload_tr[]" multiple id="upload-tr" class="form-control" accept="application/msword, application/vnd.ms-powerpoint, text/plain, application/pdf, .doc, .docx, image/*">
                                </div>
 
                                <label for="">When do you want your work delivered?</label>
                                <div class="input-group mb-3">
                                    <select name="delivered_tr" id="delivered-tr" class="form-select">
                                        <option value="">Open to select</option>
                                        <option value="Day(s):">Day(s):</option>
                                        <option value="Week(s):">Week(s):</option>
                                    </select>
                                    <input type="number" min="1" name="day_week" id="day-week" class="form-control" placeholder="Number">
                                </div>


                            </div>

                            <!-- FLIERS -->
                            <div class="fliers d-none">
                                <div class="form-group mb-3">
                                    <input type="text" name="size_to_print" id="size-to-print" class="form-control" id="" placeholder="What size do you want to print?">
                                </div>

                                <div class="form-group mb-3">
                                    <input type="number" name="quantity_to_print" id="quantity-to-print" class="form-control" id="" placeholder="what quantity do you want to print?">
                                </div>

                                <label for="">Do you have your design(s) already?</label>
                                <br>
                                <div class="form-check mb-3">
                                    <input type="radio" class="form-check-input" name="have_designs" id="have-designsYes" value="Yes">
                                    <label for="have-designsYes" class="form-check-label">Yes</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="have_designs" id="have-designsNo" value="No">
                                    <label for="have-designsNo" class="form-check-label">No</label>
                                </div>

                                <div class="d-none no-have-designs mb-3">
                                    <label for="">If NO, Do you want us to design your flier for you?</label>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="us_to_design" id="us-to-designYes" value="Yes">
                                        <label for="us-to-designYes" class="form-check-label">Yes</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="us_to_design" id="us-to-designNo" value="No">
                                        <label for="us-to-designNo" class="form-check-label">No</label>
                                    </div>
                                </div>

                                <div class="d-none yes-us-designs mb-3">
                                    <input type="text" name="flier_for" id="flier-for" class="form-control" placeholder="If yes What occasion are you designing the flier for?">
                                </div>

                                <div class="mb-3">
                                    <label>Upload your design(s) or sample designs here.</label>
                                    <input type="file" name="design_file[]" multiple id="design-file" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>When do you want the job delivered?</label>
                                    <input type="date" name="date_to_deliver" id="date-to-deliver" class="form-control">
                                </div>

                            </div>

                            <!-- BANNERS -->
                            <div class="banners d-none">
                                <div class="mb-3">
                                    <label>What size do you want?</label>
                                    <input type="text" name="banner_size" id="banner-size" class="form-control">
                                    <div class="form-text">eg. 8 x 4</div>
                                </div>

                                <div class="mb-3">
                                    <label>What quantity do you want?</label>
                                    <input type="number" min="1" name="banner_quantity" id="banner-quantity" class="form-control">
                                </div>

                                <label for="">Do you have your designs already?</label>
                                <br>
                                <div class="form-check mb-3">
                                    <input type="radio" class="form-check-input" name="have_banner_designs" id="have-banner-designsYes" value="Yes">
                                    <label for="have-banner-designsYes" class="form-check-label">Yes</label>
                                    <br>
                                    <input type="radio" class="form-check-input" name="have_banner_designs" id="have-banner-designsNo" value="No">
                                    <label for="have-banner-designsNo" class="form-check-label">No</label>
                                </div>

                                <div class="d-none yes-have-banner-designs mb-3">
                                    <label for="">If yes, Upload your design here</label>
                                    <input type="file" multiple name="upload_design[]" class="form-control" id="upload-design" value="Yes">
                                </div>

                                <div class="d-none no-have-banner-designs mb-3">
                                    <label for="">If No, Do you want us to do the design for you?</label>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="want_us" id="want-usYes" value="Yes">
                                        <label for="want-usYes" class="form-check-label">Yes</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="want_us" id="want-usNo" value="No">
                                        <label for="want-usNo" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>

                            <!-- RECEIPT -->
                            <div class="receipt d-none">
                                <div class="mb-3">
                                    <label for="">what is the name of your outfit?</label>
                                    <input type="text" name="outfit_name" class="form-control" id="outfit-name">
                                </div>

                                <div class="mb-3">
                                    <select type="text" name="receipt_type" class="form-control" id="receipt-type">
                                        <option value="">what type of receipt book do you want?</option>
                                        <option value="Customized Receipt book">Customized Receipt book</option>
                                        <option value="General receipt book">General receipt book</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="">if Customized, Do you have a logo for your company?</label>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="want_logo" id="want-logoYes" value="Yes">
                                        <label for="want-logoYes" class="form-check-label">Yes</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="want_logo" id="want-logoNo" value="No">
                                        <label for="want-logoNo" class="form-check-label">No</label>
                                    </div>
                                </div>

                                <div class="d-none yes-want-logo mb-3">
                                    <label for="">if yes, upload your logo here</label>
                                    <input type="file" multiple name="upload_logo[]" class="form-control" id="upload-logo">
                                </div>

                                <div class="mb-3">
                                    <label>How many receipt books do you want?</label>
                                    <input type="number" min="1" name="receipt_quantity" placeholder="" class="form-control" id="receipt-quantity">
                                </div>

                                <div class="mb-3">
                                    <label>When do you want the receipt books delivered?</label>
                                    <input type="date" name="receipt_delivery_date" class="form-control" id="receipt-delivery-date">
                                </div>

                                <div class="mb-3">
                                    <label for="">upload the design of your outfit for the design?</label>
                                    <input type="file" multiple name="upload_outfit_design[]" class="form-control" id="upload-outfit-design">
                                </div>
                                
                            </div>

                            <!-- INVOICE -->
                            <div class="invoice d-none">
                                <div class="mb-3">
                                    <label for="">what is the name of your outfit?</label>
                                    <input type="text" name="invoice_outfit_name" class="form-control" id="invoice-outfit-name">
                                </div>

                                <div class="mb-3">
                                    <select type="text" name="invoice_receipt_type" class="form-control" id="invoice-receipt-type">
                                        <option value="">what type of receipt book do you want?</option>
                                        <option value="Customized Receipt book">Customized Receipt book</option>
                                        <option value="General receipt book">General receipt book</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="">if Customized, Do you have a logo for your company?</label>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="invoice_want_logo" id="invoice-want-logoYes" value="Yes">
                                        <label for="invoice-want-logoYes" class="form-check-label">Yes</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="invoice_want_logo" id="invoice-want-logoNo" value="No">
                                        <label for="invoice-want-logoNo" class="form-check-label">No</label>
                                    </div>
                                </div>

                                <div class="d-none invoice-yes-want-logo mb-3">
                                    <label for="">if yes, upload your logo here</label>
                                    <input type="file" multiple name="invoice_upload_logo[]" class="form-control" id="invoice-upload-logo">
                                </div>

                                <div class="mb-3">
                                    <label>How many receipt books do you want?</label>
                                    <input type="number" min="1" name="invoice_receipt_quantity" placeholder="" class="form-control" id="invoice-receipt-quantity">
                                </div>

                                <div class="mb-3">
                                    <label>When do you want the receipt books delivered?</label>
                                    <input type="date" name="invoice_receipt_delivery_date" class="form-control" id="invoice-receipt-delivery-date">
                                </div>

                                <div class="mb-3">
                                    <label for="">upload the design of your outfit for the design?</label>
                                    <input type="file" multiple name="invoice_upload_outfit_design[]" class="form-control" id="invoice-upload-outfit-design">
                                </div>
                                
                            </div>

                            <!-- CUSTOMIZE -->
                            <div class="customized d-none">
                                <div class="mb-3">
                                    <label for="">What is the name of your outfit?</label>
                                    <input type="text" name="customize_outfit_name" class="form-control" id="customize-outfit-name">
                                </div>

                                <div class="mb-3">
                                    <label for="">what is your the addresss of your outfit?</label>
                                    <input type="text" name="customize_outfit_address" class="form-control" id="customize-outfit-address">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="">Contact number</label>
                                    <input type="tel" name="customize_contact" class="form-control" id="customize-contact">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="">Email</label>
                                    <input type="email" name="customize_email" class="form-control" id="customize-email">
                                </div>

                                <div class="mb-3">
                                    <label for="">Location</label>
                                    <input type="text" name="customize_location" class="form-control" id="customize-location">
                                </div>

                                <div class="mb-3">
                                    <label for="">GPS address?</label>
                                    <input type="text" name="customize_gps" class="form-control" id="customize-gps">
                                </div>

                                <div class="mb-3">
                                    <label for="">Does your company have a logo? Yes/No</label>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="customize_have_logo" id="customize-have-logoYes" value="Yes">
                                        <label for="customize-have-logoYes" class="form-check-label">Yes</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="customize_have_logo" id="customize-have-logoNo" value="No">
                                        <label for="customize-have-logoNo" class="form-check-label">No</label>
                                    </div>
                                </div>

                                <div class="d-none yes-have-logo mb-3">
                                    <label for="customize-upload-logo">if yes, upload your logo here</label>
                                    <input type="file" multiple name="customize_upload_logo[]" id="customize-upload-logo" class="form-control">
                                </div>

                                <div class="d-none no-have-logo mb-3">
                                    <label for="">If No, Do you want us to design a logo for your company?</label>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="us_to_design_logo" id="us-to-design-logoYes" value="Yes">
                                        <label for="us-to-design-logoYes" class="form-check-label">Yes</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="us_to_design_logo" id="us-to-design-logoNo" value="No">
                                        <label for="us-to-design-logoNo" class="form-check-label">No</label>
                                    </div>
                                </div>

                            </div>

                            <!-- CALL CARDS -->
                            <div class="call-cards d-none">
                                <div class="mb-3">
                                    <label for="">What is your name?</label>
                                    <input type="text" name="card_name" class="form-control" id="card-name">
                                </div>

                                <div class="mb-3">
                                    <label for="">What is the name of your company?</label>
                                    <input type="text" name="card_company_name" class="form-control" id="card-company-name">
                                </div>

                                <div class="mb-3">
                                    <label for="">what is your address?</label>
                                    <input type="text" name="card_address" class="form-control" id="card-address">
                                </div>

                                <div class="mb-3">
                                    <label for="">what is your email?</label>
                                    <input type="email" name="card_email" class="form-control" id="card-email">
                                </div>

                                <label for="">what are your social media handles?</label>
                                <div class="row g-3 mb-3">
                                    <div class="col-sm">
                                        <input type="text" name="card_facebook" id="card-facebook" class="form-control" placeholder="Facebook:">
                                    </div>
                                    <div class="col-sm">
                                        <input type="text" name="card_instagram" id="card-instagram" class="form-control" placeholder="Instagram:">
                                    </div>
                                    <div class="col-sm">
                                        <input type="text" name="card_twitter" id="card-twitter" class="form-control" placeholder="Twitter:">
                                    </div>
                                    <div class="col-sm">
                                        <input type="text" name="card_tiktok" id="card-tiktok" class="form-control" placeholder="Tik tok:">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="">Office Contact 1:</label>
                                    <input type="text" name="card_office_contact" class="form-control" id="card-office-contact">
                                </div>

                                <div class="mb-3">
                                    <label for="">Personal Contact 2:</label>
                                    <input type="text" name="card_personal_contact" class="form-control" id="card-personal-contact">
                                </div>

                                <div class="mb-3">
                                    <label for="">Whatsapp:</label>
                                    <input type="text" name="card_whatsapp" class="form-control" id="card-whatsapp">
                                </div>

                                <div class="mb-3">
                                    <label for="">Does your company have a logo?</label>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="card_have_logo" id="card-have-logoYes" value="Yes">
                                        <label for="card-have-logoYes" class="form-check-label">Yes</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="card_have_logo" id="card-have-logoNo" value="No">
                                        <label for="card-have-logoNo" class="form-check-label">No</label>
                                    </div>
                                </div>

                                <div class="d-none yes-card-logo mb-3">
                                    <label for="card-upload-logo">Upload your company logo here:</label>
                                    <input type="file" multiple name="card_upload_logo[]" id="card-upload-logo" class="form-control">
                                </div>

                                <div class="d-none no-card-logo mb-3">
                                    <label for="">If no, Do you want us to design a logo for you?</label>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="card_us_to_design_logo" id="card-us-to-design-logoYes" value="Yes">
                                        <label for="card-us-to-design-logoYes" class="form-check-label">Yes</label>
                                        <br>
                                        <input type="radio" class="form-check-input" name="card_us_to_design_logo" id="card-us-to-design-logoNo" value="No">
                                        <label for="card-us-to-design-logoNo" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn w-100 btn-warning mt-2" id="printjobSubmitButton" name="printjobSubmitButton" disabled>
                                Send print job now
                            </button>
                        </form>
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
        // Fade out messages
        $("#temporary").fadeOut(5000);
        
        function goBack() {
            window.history.back();
        }

        $(document).ready(function() {

            $("#print-type").change(function(e) {
                event.preventDefault()
                var printType = $("#print-type option:selected").text();

                if (printType == 'Examination questions') {
                    $('.exams').removeClass('d-none');
                    $('.thesis').addClass('d-none');
                    $('.fliers').addClass('d-none');
                    $('.banners').addClass('d-none');
                    $('.receipt').addClass('d-none');
                    $('.customized').addClass('d-none');
                    $('.call-cards').addClass('d-none');

                    $('input[name="name_of_subject[]"]').attr('required', true)
                    $('input[name="number_to_be_printed[]"]').attr('required', true)
                    $('select[name="level[]"]').attr('required', true)
                    $('input[name="class_or_form[]"]').attr('required', true)
                    $('input[name="total_students"]').attr('required', true)
                    $('input[name="typed_already"]').attr('required', true)
                    $('select[name="when_to_be_delivered"]').attr('required', true)

                    // 
                    $('#already-have-trYes').attr('required', false)
                    $('#have-you-typedYes').attr('required', false)
                    $('#final-editingYes').attr('required', false)
                    $('#delivered-tr').attr('required', false)
                    $('#day-week').attr('required', false)
                    $('#size-to-print').attr('required', false)
                    $('#quantity-to-print').attr('required', false)
                    $('#have-designsYes').attr('required', false)
                    $('#design-file').attr('required', false)
                    $('#date-to-deliver').attr('required', false)
                    $('#size-to-print').attr('required', false)
                    $('#quantity-to-print').attr('required', false)
                    $('#have-designsYes').attr('required', false)
                    $('#design-file').attr('required', false)
                    $('#date-to-deliver').attr('required', false)
                    $('#size-to-print').attr('disabled', true)
                    $('#quantity-to-print').attr('disabled', true)
                    $('#have-designsYes').attr('disabled', true)
                    $('#design-file').attr('disabled', true)
                    $('#date-to-deliver').attr('disabled', true)
                    $('#banner_size').attr('required', false);
                    $('#banner_quantity').attr('required', false);
                    $('input[name="have_banner_designs"]').attr('required', false);
                    $('#want-usYes').attr('required', false);
                    $('#outfit-name').attr('required', false)
                    $('#receipt-type').attr('required', false)
                    $('#want-logoYes').attr('required', false)
                    $('#receipt-quantity').attr('required', false)
                    $('#receipt-delivery-date').attr('required', false)
                    $('#upload-outfit-design').attr('required', false)
                    $('#upload-logo').attr('required', false)
                    $('#customize-outfit-name').attr('required', false)
                    $('#customize-outfit-address').attr('required', false)
                    $('#customize-contact').attr('required', false)
                    $('#customize-email').attr('required', false)
                    $('#customize-location').attr('required', false)
                    $('#customize-gps').attr('required', false)
                    $('#customize-have-logoYes').attr('required', false)
                    $('#customize-upload-logo').attr('required', false)
                    $('#us-to-design-logoYes').attr('required', false)
                    $('#card-name').attr('required', false)
                    $('#card-company-name').attr('required', false)
                    $('#card-address').attr('required', false)
                    $('#card-email').attr('required', false)
                    $('#card-office-contact').attr('required', false)
                    $('#card-personal-contact').attr('required', false)
                    $('#card-whatsapp').attr('required', false)
                    $('#card-have-logoYes').attr('required', false)
                    $('#card-us-to-design-logoYes').attr('required', false)
                    $('#card-upload-logo').attr('required', false)

                    // add more fields
                    var i = 1;  
                    $('#add').click(function() {  
                        i++; 
                        $('#dynamic_field').append(`
                            <tr id="row` + i +`"> 
                                <td><input type="text" name="name_of_subject[]" placeholder="Name of subject" class="form-control name-of-subject" required></td>  
                                <td><input type="number" min='0' name="number_to_be_printed[]" placeholder="Number to be printed" class="form-control number-to-be-printed" required></td>  
                                <td>
                                    <select type="text" name="level[]" placeholder="Enter your Name" class="form-control level" required>
                                        <option value="">Level</option>
                                        <option value="Tertiary">Tertiary</option>
                                        <option value="SHS">SHS</option>
                                        <option value="JHS">JHS</option>
                                        <option value="Primary">Primary</option>
                                        <option value="Kindargarten">Kindargarten</option>
                                        <option value="Nursery">Nursery</option>
                                    </select>
                                </td>
                                <td><input type="text" name="class_or_form[]" placeholder="Class/Form" class="form-control class-or-form" required></td>  
                                <td><button type="button" name="remove" id="` + i + `" class="btn btn-sm btn-danger btn_remove">X</button></td>
                            </tr>
                        `);  
                    });

                    // remove field
                    $(document).on('click', '.btn_remove', function() {  
                        var button_id = $(this).attr("id");   
                        $('#row' + button_id + '').remove();  
                    });

                    $('input[name="typed_already"]').click(function() {
                        var typedAlready = $('input[name="typed_already"]:checked').val();
                        if (typedAlready == 'Yes') {
                            $('.yes-typed').removeClass('d-none');
                            $('.no-typed').addClass('d-none');

                            $('input[name="want_us_to_type"]').prop('checked', false)
                            $('#upload-typed-work').attr('required', true);
                            $('#want-us-to-typeYes').attr('required', false);

                        } else if (typedAlready == 'No') { 
                            $('.no-typed').removeClass('d-none');
                            $('.yes-typed').addClass('d-none');

                            $('#want-us-to-typeYes').attr('required', true);
                            $('#upload-typed-work').val('');
                            $('#upload-typed-work').attr('required', false);
                            
                            $('input[name="want_us_to_type"]').click(function() {
                                if ($('input[name="want_us_to_type"]').is(':checked')) {
                                    return true;
                                } else {
                                    alert("If no, Do you want us to type for you? ");
                                    return false;
                                }
                            });

                        } else {
                            alert('Please, Do you have the questions typed already');
                            return false;
                            // undefined
                        }
                    });

                    $('#printjobSubmitButton').attr('disabled', false);

                } else if (printType == 'Thesis') {
                    $('.thesis').removeClass('d-none');
                    $('.exams').addClass('d-none');
                    $('.fliers').addClass('d-none');
                    $('.banners').addClass('d-none');
                    $('.receipt').addClass('d-none');
                    $('.customized').addClass('d-none');
                    $('.call-cards').addClass('d-none');

                    // 
                    $('#already-have-trYes').attr('required', true)
                    $('#have-you-typedYes').attr('required', true)
                    $('#final-editingYes').attr('required', true)
                    $('#delivered-tr').attr('required', true)
                    $('#day-week').attr('required', true)

                    $('input[name="name_of_subject[]"]').attr('required', false)
                    $('input[name="number_to_be_printed[]"]').attr('required', false)
                    $('select[name="level[]"]').attr('required', false)
                    $('input[name="class_or_form[]"]').attr('required', false)
                    $('input[name="total_students"]').attr('required', false)
                    $('input[name="typed_already"]').attr('required', false)
                    $('select[name="when_to_be_delivered"]').attr('required', false)
                    $('input[name="delivery_address_1"]').attr('required', false)
                    $('input[name="delivery_address_2"]').attr('required', false)
                    $('#size-to-print').attr('required', false)
                    $('#quantity-to-print').attr('required', false)
                    $('#have-designsYes').attr('required', false)
                    $('#design-file').attr('required', false)
                    $('#date-to-deliver').attr('required', false)
                    $('#banner_size').attr('required', false);
                    $('#banner_quantity').attr('required', false);
                    $('input[name="have_banner_designs"]').attr('required', false);
                    $('#want-usYes').attr('required', false);
                    $('#outfit-name').attr('required', false)
                    $('#receipt-type').attr('required', false)
                    $('#want-logoYes').attr('required', false)
                    $('#receipt-quantity').attr('required', false)
                    $('#receipt-delivery-date').attr('required', false)
                    $('#upload-outfit-design').attr('required', false)
                    $('#upload-logo').attr('required', false)
                    $('#customize-outfit-name').attr('required', false)
                    $('#customize-outfit-address').attr('required', false)
                    $('#customize-contact').attr('required', false)
                    $('#customize-email').attr('required', false)
                    $('#customize-location').attr('required', false)
                    $('#customize-gps').attr('required', false)
                    $('#customize-have-logoYes').attr('required', false)
                    $('#customize-upload-logo').attr('required', false)
                    $('#us-to-design-logoYes').attr('required', false)
                    $('#card-name').attr('required', false)
                    $('#card-company-name').attr('required', false)
                    $('#card-address').attr('required', false)
                    $('#card-email').attr('required', false)
                    $('#card-office-contact').attr('required', false)
                    $('#card-personal-contact').attr('required', false)
                    $('#card-whatsapp').attr('required', false)
                    $('#card-have-logoYes').attr('required', false)
                    $('#card-us-to-design-logoYes').attr('required', false)
                    $('#card-upload-logo').attr('required', false)

                    
                    $('input[name="already_have_tr"]').click(function() {
                        var alreadyHave = $('input[name="already_have_tr"]:checked').val();
                        if (alreadyHave == 'Yes') {
                            $('.yes-have').removeClass('d-none');
                            $('.no-have').addClass('d-none');
                            
                            $('#your-thesis-research').attr('required', true)
                            $('#get-for-youYes').attr('required', false)

                            $('input[name="get_for_you"]').prop('checked', false);
                        } else if (alreadyHave == 'No') {
                            $('.no-have').removeClass('d-none');
                            $('.yes-have').addClass('d-none');

                            $('#get-for-youYes').attr('required', true)
                            $('#your-thesis-research').val('');
                            $('#your-thesis-research').attr('required', false)
                        }
                    })

                    $('input[name="have_you_typed"]').click(function() {
                        var youTyped = $('input[name="have_you_typed"]:checked').val();
                        if (youTyped == 'No') {
                            $('.no-typed-tr').removeClass('d-none');
                            $('#handle-typingYes').attr('required', true);
                        } else {
                            $('.no-typed-tr').addClass('d-none');
                            $('#handle-typingYes').attr('required', false);
                        }
                    })
                    
                    $('input[name="final_editing"]').click(function() {
                        var final = $('input[name="final_editing"]:checked').val();
                        if (final == 'Yes') {
                            $('.yes-effected').removeClass('d-none');
                            $('.no-effected').addClass('d-none');
                            $('#upload-work-tr').attr('required', true);
                            $('#upload-tr').attr('required', false);

                        } else if (final == 'No') {
                            $('.no-effected').removeClass('d-none');
                            $('.yes-effected').addClass('d-none');
                            $('#upload-tr').attr('required', true);
                            $('#upload-work-tr').attr('required', false);

                        }
                    })

                    $('#printjobSubmitButton').attr('disabled', false);
                } else if (printType == 'Fliers') {
                    $('.fliers').removeClass('d-none');
                    $('.thesis').addClass('d-none');
                    $('.exams').addClass('d-none');
                    $('.banners').addClass('d-none');
                    $('.receipt').addClass('d-none');
                    $('.customized').addClass('d-none');
                    $('.call-cards').addClass('d-none');

                    // 
                    $('#size-to-print').attr('required', true)
                    $('#quantity-to-print').attr('required', true)
                    $('#have-designsYes').attr('required', true)
                    $('#date-to-deliver').attr('required', true)

                    $('#already-have-trYes').attr('required', false)
                    $('#have-you-typedYes').attr('required', false)
                    $('#final-editingYes').attr('required', false)
                    $('#delivered-tr').attr('required', false)
                    $('#day-week').attr('required', false)
                    $('#your-thesis-research').attr('required', false)
                    $('input[name="name_of_subject[]"]').attr('required', false)
                    $('input[name="number_to_be_printed[]"]').attr('required', false)
                    $('select[name="level[]"]').attr('required', false)
                    $('input[name="class_or_form[]"]').attr('required', false)
                    $('input[name="total_students"]').attr('required', false)
                    $('input[name="typed_already"]').attr('required', false)
                    $('select[name="when_to_be_delivered"]').attr('required', false)
                    $('input[name="delivery_address_1"]').attr('required', false)
                    $('input[name="delivery_address_2"]').attr('required', false)
                    $('#banner_size').attr('required', false);
                    $('#banner_quantity').attr('required', false);
                    $('input[name="have_banner_designs"]').attr('required', false);
                    $('#want-usYes').attr('required', false);
                    $('#outfit-name').attr('required', false)
                    $('#receipt-type').attr('required', false)
                    $('#want-logoYes').attr('required', false)
                    $('#receipt-quantity').attr('required', false)
                    $('#receipt-delivery-date').attr('required', false)
                    $('#upload-outfit-design').attr('required', false)
                    $('#upload-logo').attr('required', false)
                    $('#customize-outfit-name').attr('required', false)
                    $('#customize-outfit-address').attr('required', false)
                    $('#customize-contact').attr('required', false)
                    $('#customize-email').attr('required', false)
                    $('#customize-location').attr('required', false)
                    $('#customize-gps').attr('required', false)
                    $('#customize-have-logoYes').attr('required', false)
                    $('#customize-upload-logo').attr('required', false)
                    $('#us-to-design-logoYes').attr('required', false)
                    $('#card-name').attr('required', false)
                    $('#card-company-name').attr('required', false)
                    $('#card-address').attr('required', false)
                    $('#card-email').attr('required', false)
                    $('#card-office-contact').attr('required', false)
                    $('#card-personal-contact').attr('required', false)
                    $('#card-whatsapp').attr('required', false)
                    $('#card-have-logoYes').attr('required', false)
                    $('#card-us-to-design-logoYes').attr('required', false)
                    $('#card-upload-logo').attr('required', false)


                    $('input[name="have_designs"]').click(function() {
                        var have = $('input[name="have_designs"]:checked').val();
                        if (have == 'No') {
                            $('#design-file').attr('required', false)
                            $('.no-have-designs').removeClass('d-none');
                            $('#us-to-designYes').attr('required', true)
                        } else {
                            $('#design-file').attr('required', true)
                            $('.no-have-designs').addClass('d-none');
                            $('#us-to-designYes').attr('required', false)
                        }
                    })

                    $('input[name="us_to_design"]').click(function() {
                        var usTo = $('input[name="us_to_design"]:checked').val();
                        if (usTo == 'Yes') {
                            $('.yes-us-designs').removeClass('d-none');
                            $('#flier-for').attr('required', true)
                        } else {
                            $('.yes-us-designs').addClass('d-none');
                            $('#flier-for').attr('required', false)
                            $('#flier-for').val('')
                        }
                    })
                    $('#printjobSubmitButton').attr('disabled', false);
                    
                } else if (printType == 'Banners') {
                    $('.banners').removeClass('d-none');
                    $('.fliers').addClass('d-none');
                    $('.thesis').addClass('d-none');
                    $('.exams').addClass('d-none');
                    $('.receipt').addClass('d-none');
                    $('.customized').addClass('d-none');
                    $('.call-cards').addClass('d-none');

                    $('#banner_size').attr('required', true);
                    $('#banner_quantity').attr('required', true);
                    $('input[name="have_banner_designs"]').attr('required', true);

                    $('#size-to-print').attr('required', false)
                    $('#quantity-to-print').attr('required', false)
                    $('#have-designsYes').attr('required', false)
                    $('#date-to-deliver').attr('required', false)
                    $('#already-have-trYes').attr('required', false)
                    $('#have-you-typedYes').attr('required', false)
                    $('#final-editingYes').attr('required', false)
                    $('#delivered-tr').attr('required', false)
                    $('#day-week').attr('required', false)
                    $('#your-thesis-research').attr('required', false)
                    $('input[name="name_of_subject[]"]').attr('required', false)
                    $('input[name="number_to_be_printed[]"]').attr('required', false)
                    $('select[name="level[]"]').attr('required', false)
                    $('input[name="class_or_form[]"]').attr('required', false)
                    $('input[name="total_students"]').attr('required', false)
                    $('input[name="typed_already"]').attr('required', false)
                    $('select[name="when_to_be_delivered"]').attr('required', false)
                    $('input[name="delivery_address_1"]').attr('required', false)
                    $('input[name="delivery_address_2"]').attr('required', false)
                    $('#outfit-name').attr('required', false)
                    $('#receipt-type').attr('required', false)
                    $('#want-logoYes').attr('required', false)
                    $('#receipt-quantity').attr('required', false)
                    $('#receipt-delivery-date').attr('required', false)
                    $('#upload-outfit-design').attr('required', false)
                    $('#upload-logo').attr('required', false)
                    $('#customize-outfit-name').attr('required', false)
                    $('#customize-outfit-address').attr('required', false)
                    $('#customize-contact').attr('required', false)
                    $('#customize-email').attr('required', false)
                    $('#customize-location').attr('required', false)
                    $('#customize-gps').attr('required', false)
                    $('#customize-have-logoYes').attr('required', false)
                    $('#customize-upload-logo').attr('required', false)
                    $('#us-to-design-logoYes').attr('required', false)
                    $('#card-name').attr('required', false)
                    $('#card-company-name').attr('required', false)
                    $('#card-address').attr('required', false)
                    $('#card-email').attr('required', false)
                    $('#card-office-contact').attr('required', false)
                    $('#card-personal-contact').attr('required', false)
                    $('#card-whatsapp').attr('required', false)
                    $('#card-have-logoYes').attr('required', false)
                    $('#card-us-to-design-logoYes').attr('required', false)
                    $('#card-upload-logo').attr('required', false)

                    $('input[name="have_banner_designs"]').click(function() {
                        var have = $('input[name="have_banner_designs"]:checked').val();
                        if (have == 'Yes') {
                            $('.yes-have-banner-designs').removeClass('d-none')
                            $('.no-have-banner-designs').addClass('d-none')
                            $('#upload-design').attr('required', true);
                            $('#want-usYes').attr('required', false);
                            $('input[name="want_us"]').prop('checked', false);
                        } else if (have == 'No') {
                            $('.no-have-banner-designs').removeClass('d-none')
                            $('.yes-have-banner-designs').addClass('d-none')
                            $('#want-usYes').attr('required', true);
                            $('#upload-design').attr('required', false);

                        }
                    })

                    $('#printjobSubmitButton').attr('disabled', false);
                    
                } else if (printType == 'Receipt books') {
                    $('.receipt').removeClass('d-none');
                    $('.banners').addClass('d-none');
                    $('.fliers').addClass('d-none');
                    $('.thesis').addClass('d-none');
                    $('.exams').addClass('d-none');
                    $('.customized').addClass('d-none');
                    $('.call-cards').addClass('d-none');

                    $('#outfit-name').attr('required', true)
                    $('#receipt-type').attr('required', true)
                    $('#want-logoYes').attr('required', true)
                    $('#receipt-quantity').attr('required', true)
                    $('#receipt-delivery-date').attr('required', true)
                    $('#upload-outfit-design').attr('required', true)

                    $('#banner_size').attr('required', false);
                    $('#banner_quantity').attr('required', false);
                    $('input[name="have_banner_designs"]').attr('required', false);
                    $('#size-to-print').attr('required', false)
                    $('#quantity-to-print').attr('required', false)
                    $('#have-designsYes').attr('required', false)
                    $('#date-to-deliver').attr('required', false)
                    $('#already-have-trYes').attr('required', false)
                    $('#have-you-typedYes').attr('required', false)
                    $('#final-editingYes').attr('required', false)
                    $('#delivered-tr').attr('required', false)
                    $('#day-week').attr('required', false)
                    $('#your-thesis-research').attr('required', false)
                    $('input[name="name_of_subject[]"]').attr('required', false)
                    $('input[name="number_to_be_printed[]"]').attr('required', false)
                    $('select[name="level[]"]').attr('required', false)
                    $('input[name="class_or_form[]"]').attr('required', false)
                    $('input[name="total_students"]').attr('required', false)
                    $('input[name="typed_already"]').attr('required', false)
                    $('select[name="when_to_be_delivered"]').attr('required', false)
                    $('input[name="delivery_address_1"]').attr('required', false)
                    $('input[name="delivery_address_2"]').attr('required', false)
                    $('#customize-outfit-name').attr('required', false)
                    $('#customize-outfit-address').attr('required', false)
                    $('#customize-contact').attr('required', false)
                    $('#customize-email').attr('required', false)
                    $('#customize-location').attr('required', false)
                    $('#customize-gps').attr('required', false)
                    $('#customize-have-logoYes').attr('required', false)
                    $('#customize-upload-logo').attr('required', false)
                    $('#us-to-design-logoYes').attr('required', false)
                    $('#card-name').attr('required', false)
                    $('#card-company-name').attr('required', false)
                    $('#card-address').attr('required', false)
                    $('#card-email').attr('required', false)
                    $('#card-office-contact').attr('required', false)
                    $('#card-personal-contact').attr('required', false)
                    $('#card-whatsapp').attr('required', false)
                    $('#card-have-logoYes').attr('required', false)
                    $('#card-us-to-design-logoYes').attr('required', false)
                    $('#card-upload-logo').attr('required', false)

                    $('input[name="want_logo"]').click(function() {
                        var want = $('input[name="want_logo"]:checked').val();
                        if (want == 'Yes') {
                            $('.yes-want-logo').removeClass('d-none')
                            $('#upload-logo').attr('required', true)
                        } else if (want == 'No') {
                            $('.yes-want-logo').addClass('d-none')
                            $('#upload-logo').val('')
                            $('#upload-logo').attr('required', false)

                        }
                    })
                   // $('#ir').val('Receipt');
                    $('#printjobSubmitButton').attr('disabled', false);
                } else if (printType == 'Invoice') {
                    // $('.invoice').removeClass('d-none');
                    // $('.customized').addClass('d-none');
                    // $('.receipt').addClass('d-none');
                    // $('.banners').addClass('d-none');
                    // $('.fliers').addClass('d-none');
                    // $('.thesis').addClass('d-none');
                    // $('.exams').addClass('d-none');
                    // $('.call-cards').addClass('d-none');


                    $('.receipt').removeClass('d-none');
                    $('.banners').addClass('d-none');
                    $('.fliers').addClass('d-none');
                    $('.thesis').addClass('d-none');
                    $('.exams').addClass('d-none');
                    $('.customized').addClass('d-none');
                    $('.call-cards').addClass('d-none');

                    $('#outfit-name').attr('required', true)
                    $('#receipt-type').attr('required', true)
                    $('#want-logoYes').attr('required', true)
                    $('#receipt-quantity').attr('required', true)
                    $('#receipt-delivery-date').attr('required', true)
                    $('#upload-outfit-design').attr('required', true)

                    $('#banner_size').attr('required', false);
                    $('#banner_quantity').attr('required', false);
                    $('input[name="have_banner_designs"]').attr('required', false);
                    $('#size-to-print').attr('required', false)
                    $('#quantity-to-print').attr('required', false)
                    $('#have-designsYes').attr('required', false)
                    $('#date-to-deliver').attr('required', false)
                    $('#already-have-trYes').attr('required', false)
                    $('#have-you-typedYes').attr('required', false)
                    $('#final-editingYes').attr('required', false)
                    $('#delivered-tr').attr('required', false)
                    $('#day-week').attr('required', false)
                    $('#your-thesis-research').attr('required', false)
                    $('input[name="name_of_subject[]"]').attr('required', false)
                    $('input[name="number_to_be_printed[]"]').attr('required', false)
                    $('select[name="level[]"]').attr('required', false)
                    $('input[name="class_or_form[]"]').attr('required', false)
                    $('input[name="total_students"]').attr('required', false)
                    $('input[name="typed_already"]').attr('required', false)
                    $('select[name="when_to_be_delivered"]').attr('required', false)
                    $('input[name="delivery_address_1"]').attr('required', false)
                    $('input[name="delivery_address_2"]').attr('required', false)
                    $('#customize-outfit-name').attr('required', false)
                    $('#customize-outfit-address').attr('required', false)
                    $('#customize-contact').attr('required', false)
                    $('#customize-email').attr('required', false)
                    $('#customize-location').attr('required', false)
                    $('#customize-gps').attr('required', false)
                    $('#customize-have-logoYes').attr('required', false)
                    $('#customize-upload-logo').attr('required', false)
                    $('#us-to-design-logoYes').attr('required', false)
                    $('#card-name').attr('required', false)
                    $('#card-company-name').attr('required', false)
                    $('#card-address').attr('required', false)
                    $('#card-email').attr('required', false)
                    $('#card-office-contact').attr('required', false)
                    $('#card-personal-contact').attr('required', false)
                    $('#card-whatsapp').attr('required', false)
                    $('#card-have-logoYes').attr('required', false)
                    $('#card-us-to-design-logoYes').attr('required', false)
                    $('#card-upload-logo').attr('required', false)

                    $('input[name="want_logo"]').click(function() {
                        var want = $('input[name="want_logo"]:checked').val();
                        if (want == 'Yes') {
                            $('.yes-want-logo').removeClass('d-none')
                            $('#upload-logo').attr('required', true)
                        } else if (want == 'No') {
                            $('.yes-want-logo').addClass('d-none')
                            $('#upload-logo').val('')
                            $('#upload-logo').attr('required', false)

                        }
                    })
                   //  $('#ir').val('Invoice');
                    $('#printjobSubmitButton').attr('disabled', false);

                } else if (printType == 'Customized office Files') {
                    $('.customized').removeClass('d-none');
                    $('.receipt').addClass('d-none');
                    $('.banners').addClass('d-none');
                    $('.fliers').addClass('d-none');
                    $('.thesis').addClass('d-none');
                    $('.exams').addClass('d-none');
                    $('.call-cards').addClass('d-none');
                    
                    $('#customize-outfit-name').attr('required', true)
                    $('#customize-outfit-address').attr('required', true)
                    $('#customize-contact').attr('required', true)
                    $('#customize-email').attr('required', true)
                    $('#customize-location').attr('required', true)
                    $('#customize-gps').attr('required', true)
                    $('#customize-have-logoYes').attr('required', true)

                    $('#outfit-name').attr('required', false)
                    $('#receipt-type').attr('required', false)
                    $('#want-logoYes').attr('required', false)
                    $('#receipt-quantity').attr('required', false)
                    $('#receipt-delivery-date').attr('required', false)
                    $('#upload-outfit-design').attr('required', false)
                    $('#banner_size').attr('required', false);
                    $('#banner_quantity').attr('required', false);
                    $('input[name="have_banner_designs"]').attr('required', false);
                    $('#size-to-print').attr('required', false)
                    $('#quantity-to-print').attr('required', false)
                    $('#have-designsYes').attr('required', false)
                    $('#date-to-deliver').attr('required', false)
                    $('#already-have-trYes').attr('required', false)
                    $('#have-you-typedYes').attr('required', false)
                    $('#final-editingYes').attr('required', false)
                    $('#delivered-tr').attr('required', false)
                    $('#day-week').attr('required', false)
                    $('#your-thesis-research').attr('required', false)
                    $('input[name="name_of_subject[]"]').attr('required', false)
                    $('input[name="number_to_be_printed[]"]').attr('required', false)
                    $('select[name="level[]"]').attr('required', false)
                    $('input[name="class_or_form[]"]').attr('required', false)
                    $('input[name="total_students"]').attr('required', false)
                    $('input[name="typed_already"]').attr('required', false)
                    $('select[name="when_to_be_delivered"]').attr('required', false)
                    $('input[name="delivery_address_1"]').attr('required', false)
                    $('input[name="delivery_address_2"]').attr('required', false)
                    $('#card-name').attr('required', false)
                    $('#card-company-name').attr('required', false)
                    $('#card-address').attr('required', false)
                    $('#card-email').attr('required', false)
                    $('#card-office-contact').attr('required', false)
                    $('#card-personal-contact').attr('required', false)
                    $('#card-whatsapp').attr('required', false)
                    $('#card-have-logoYes').attr('required', false)
                    $('#card-us-to-design-logoYes').attr('required', false)
                    $('#card-upload-logo').attr('required', false)

                    $('input[name="customize_have_logo"]').click(function() {
                        var have = $('input[name="customize_have_logo"]:checked').val();
                        if (have == 'Yes') {
                            $('.yes-have-logo').removeClass('d-none')
                            $('#customize-upload-logo').attr('required', true)
                            $('.no-have-logo').addClass('d-none')
                            $('#us-to-design-logoYes').attr('required', false)
                            $('input[name="us_to_design_logo"]').prop('checked', false)
                        } else if (have == 'No') {
                            $('.no-have-logo').removeClass('d-none')
                            $('#us-to-design-logoYes').attr('required', true)
                            $('.yes-have-logo').addClass('d-none')
                            $('#customize-upload-logo').val('')
                            $('#customize-upload-logo').attr('required', false)

                        }
                    })
                    $('#printjobSubmitButton').attr('disabled', false);
                } else if (printType == 'Call cards') {
                    $('.call-cards').removeClass('d-none');
                    $('.customized').addClass('d-none');
                    $('.receipt').addClass('d-none');
                    $('.banners').addClass('d-none');
                    $('.fliers').addClass('d-none');
                    $('.thesis').addClass('d-none');
                    $('.exams').addClass('d-none');

                    $('#card-name').attr('required', true)
                    $('#card-company-name').attr('required', true)
                    $('#card-address').attr('required', true)
                    $('#card-email').attr('required', true)
                    $('#card-office-contact').attr('required', true)
                    $('#card-personal-contact').attr('required', true)
                    $('#card-whatsapp').attr('required', true)
                    $('#card-have-logoYes').attr('required', true)

                    $('#customize-outfit-address').attr('required', false)
                    $('#customize-contact').attr('required', false)
                    $('#customize-email').attr('required', false)
                    $('#customize-location').attr('required', false)
                    $('#customize-gps').attr('required', false)
                    $('#customize-have-logoYes').attr('required', false)
                    $('#us-to-design-logoYes').attr('required', false)
                    $('#customize-upload-logo').attr('required', false)
                    $('#outfit-name').attr('required', false)
                    $('#receipt-type').attr('required', false)
                    $('#want-logoYes').attr('required', false)
                    $('#receipt-quantity').attr('required', false)
                    $('#receipt-delivery-date').attr('required', false)
                    $('#upload-outfit-design').attr('required', false)
                    $('#banner_size').attr('required', false);
                    $('#banner_quantity').attr('required', false);
                    $('input[name="have_banner_designs"]').attr('required', false);
                    $('#size-to-print').attr('required', false)
                    $('#quantity-to-print').attr('required', false)
                    $('#have-designsYes').attr('required', false)
                    $('#date-to-deliver').attr('required', false)
                    $('#already-have-trYes').attr('required', false)
                    $('#have-you-typedYes').attr('required', false)
                    $('#final-editingYes').attr('required', false)
                    $('#delivered-tr').attr('required', false)
                    $('#day-week').attr('required', false)
                    $('#your-thesis-research').attr('required', false)
                    $('input[name="name_of_subject[]"]').attr('required', false)
                    $('input[name="number_to_be_printed[]"]').attr('required', false)
                    $('select[name="level[]"]').attr('required', false)
                    $('input[name="class_or_form[]"]').attr('required', false)
                    $('input[name="total_students"]').attr('required', false)
                    $('input[name="typed_already"]').attr('required', false)
                    $('select[name="when_to_be_delivered"]').attr('required', false)
                    $('input[name="delivery_address_1"]').attr('required', false)
                    $('input[name="delivery_address_2"]').attr('required', false)

                    $('input[name="card_have_logo"]').click(function() {
                        var have = $('input[name="card_have_logo"]:checked').val();
                        if (have == 'Yes') {
                            $('.yes-card-logo').removeClass('d-none')
                            $('#card-upload-logo').attr('required', true)
                            $('.no-card-logo').addClass('d-none')
                            $('#card-us-to-design-logoYes').attr('required', false)
                            $('input[name="card_us_to_design_logo"]').prop('checked', false)
                        } else if (have == 'No') {
                            $('.no-card-logo').removeClass('d-none')
                            $('#card-us-to-design-logoYes').attr('required', true)
                            $('.yes-card-logo').addClass('d-none')
                            $('#card-upload-logo').val('')
                            $('#card-upload-logo').attr('required', false)

                        }
                    })
                    $('#printjobSubmitButton').attr('disabled', false);

                }
                
            })

        });
    </script>

</body>
</html>
