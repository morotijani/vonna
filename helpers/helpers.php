<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require BASEURL . 'vendor/autoload.php';

function dnd($data) {
	echo "<pre>";
	print_r($data);
	echo "</pre>";
    die;
}

// Make Date Readable
function pretty_date($date){
	return date("M d, Y h:i A", strtotime($date));
}

// Display money in a readable way
function money($number) {
	return '$' . number_format($number, 2);
}

// Check For Incorrect Input Of Data
function sanitize($dirty) {
    $clean = htmlentities($dirty, ENT_QUOTES, "UTF-8");
    return trim($clean);
}

function cleanPost($post) {
    $clean = [];
    foreach ($post as $key => $value) {
      	if (is_array($value)) {
        	$ary = [];
        	foreach($value as $val) {
          		$ary[] = sanitize($val);
        	}
        	$clean[$key] = $ary;
      	} else {
        	$clean[$key] = sanitize($value);
      	}
    }
    return $clean;
}

//
function php_url_slug($string) {
 	$slug = preg_replace('/[^a-z0-9-]+/', '-', trim(strtolower($string)));
 	return $slug;
}


// REDIRECT PAGE
function redirect($url) {
    if(!headers_sent()) {
      	header("Location: {$url}");
    } else {
      	echo '<script>window.location.href="' . $url . '"</script>';
    }
    exit;
}

function issetElse($array, $key, $default = "") {
    if(!isset($array[$key]) || empty($array[$key])) {
      return $default;
    }
    return $array[$key];
}


// Email VALIDATION
function isEmail($email) {
	return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
}

// GET USER IP ADDRESS
function getIPAddress() {  
    //whether ip is from the share internet  
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  // whether ip is from the proxy
       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     } else {  // whether ip is from the remote address 
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
}

// PRINT OUT RANDAM NUMBERS
function digit_random($digits) {
  	return rand(pow(10, $digits - 1) - 1, pow(10, $digits) - 1);
}

function js_alert($msg) {
	return '<script>alert("' . $msg . '");</script>';
}


// 
function sms_otp($msg, $phone) {
	$sender = urlencode("Inqoins VER");
    $api_url = "https://api.innotechdev.com/sendmessage.php?key=".SMS_API_KEY."&message={$msg}&senderid={$sender}&phone={$phone}";
    $json_data = file_get_contents($api_url);
    $response_data = json_decode($json_data);
    // Can be use for checks on finished / unfinished balance
    $fromAPI = 'insufficient balance, kindly credit your account';  
    if ($api_url)
    	return 1;
	else
		return 0;
}

//
function send_email($name, $to, $subject, $body) {
	$mail = new PHPMailer(true);
	try {
        $fn = $name;
        $to = $to;
        $from = MAIL_MAIL;
        $from_name = 'Vonna, Gh.';
        $subject = $subject;
        $body = $body;

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        $mail->IsSMTP();
        $mail->SMTPAuth = true;

        $mail->SMTPSecure = 'ssl'; 
        $mail->Host = 'smtp.vonnagh.com';
        $mail->Port = 465;  
        $mail->Username = $from;
        $mail->Password = MAIL_KEY; 

        $mail->IsHTML(true);
        $mail->WordWrap = 50;
        $mail->From = $from;
        $mail->FromName = $from_name;
        $mail->Sender = $from;
        $mail->AddReplyTo($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
        $mail->send();
        return true;
    } catch (Exception $e) {
    	//return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    	return false;
        //$message = "Please check your internet connection well...";
    }
}







////////////////////////////////////////////////////////////////////////////////////////////////////////


function get_header_information() {
	global $conn;
	$siteQuery = "
	    SELECT * FROM mifo_about 
	    LIMIT 1
	";
	$statement = $conn->prepare($siteQuery);
	$statement->execute();
	$site_result = $statement->fetchAll();

	foreach ($site_result as $site_row) {
	    $phone_1 = $site_row["about_phone"];
	}
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$actual_linkBreakDown = explode('/', $actual_link);
	$actual_linkLast = end($actual_linkBreakDown);

	$output = '';
	if ($actual_linkLast != 'signin' && $actual_linkLast != 'signin.php') {

		$output .= '
		<div class="header-eyebrow bg-dark">
		<div class="container">
		<div class="navbar navbar-dark row">
		<div class="col">
		<ul class="navbar-nav mr-auto">
		<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="javascript:;" id="curency" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		USD
		</a>
		<ul class="dropdown-menu" aria-labelledby="curency">
		<li><a class="dropdown-item" href="javascript:;">EUR</a></li>
		<li><a class="dropdown-item" href="javascript:;">RUB</a></li>
		</ul>
		</li>
		<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#!" id="language" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		EN
		</a>
		<ul class="dropdown-menu" aria-labelledby="language">
		<li><a class="dropdown-item" href="#!">Deutsch</a></li>
		<li><a class="dropdown-item" href="#!">Russian</a></li>
		<li><a class="dropdown-item" href="#!">French</a></li>
		</ul>
		</li>
		</ul>
		</div>
		<div class="col text-right">
		<span class="phone text-white">'.$phone_1.'</span>
		</div>
		</div>
		</div>
		</div>
		';

	} else {
		$output = '';
	}
	return $output;
}

function getTitle() {
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$actual_linkBreakDown = explode('/', $actual_link);
	$actual_linkLast = end($actual_linkBreakDown);

	$output = '';
	if ($actual_linkLast == 'signin' || $actual_linkLast == 'signin.php') {
		$output = 'Sigin · ';
	} elseif ($actual_linkLast == 'index.php' || $actual_linkLast == 'index' || $actual_linkLast == '') {
		$output = 'Welcome · ';
	} elseif ($actual_linkLast == 'products' || $actual_linkLast == 'products.php') {
		$output = 'Products · ';
	} elseif ($actual_linkLast == 'profile' || $actual_linkLast == 'profile.php') {
		$output = 'Profile · ';
	} elseif ($actual_linkLast == 'yourpassword' || $actual_linkLast == 'yourpassword.php') {
		$output = 'My Password · ';
	} elseif ($actual_linkLast == 'youraddress' || $actual_linkLast == 'youraddress.php') {
		$output = 'My Address · ';
	} elseif ($actual_linkLast == 'yourorders' || $actual_linkLast == 'yourorders.php') {
		$output = 'My Orders · ';
	} elseif ($actual_linkLast == 'cart' || $actual_linkLast == 'cart.php') {
		$output = 'My Cart · ';
	} elseif ($actual_linkLast == 'forgotPassword' || $actual_linkLast == 'forgotPassword.php') {
		$output = 'Forgot Password · ';
	} elseif ($actual_linkLast == 'verify' || $actual_linkLast == 'verify.php') {
		$output = 'Verify Account · ';
	} elseif ($actual_linkLast == 'verified' || $actual_linkLast == 'verified.php') {
		$output = 'Account on Verification · ';
	} elseif ($actual_linkLast == 'contact-us' || $actual_linkLast == 'contact-us.php') {
		$output = 'Contact Us · ';
	} elseif ($actual_linkLast == 'resendVericode' || $actual_linkLast == 'resendVericode.php') {
		$output = 'Resend Verification Code · ';
	} elseif ($actual_linkLast == 'resetPassword' || $actual_linkLast == 'resetPassword.php') {
		$output = 'Reset Password · ';
	} elseif ($actual_linkLast == 'thankYou' || $actual_linkLast == 'thankYou.php') {
		$output = 'Thank You · ';
	}
	return $output;
}








/////////////////////////////////////////////////////////////////////////////////////////////////




// Sessions For login
function adminLogin($admin_id) {
	$_SESSION['VNAdmin'] = $admin_id;
	global $conn;
	$data = array(
		':admin_last_login' => date("Y-m-d H:i:s"),
		':admin_id' => (int)$admin_id
	);
	$query = "
		UPDATE vonna_admin 
		SET admin_last_login = :admin_last_login 
		WHERE admin_id = :admin_id";
	$statement = $conn->prepare($query);
	$result = $statement->execute($data);
	if (isset($result)) {
		$_SESSION['flash_success'] = '<div class="text-center" id="temporary">You are now logged in!</div>';
		header('Location: index');
	}
}

function admin_is_logged_in(){
	if (isset($_SESSION['VNAdmin']) && $_SESSION['VNAdmin'] > 0) {
		return true;
	}
	return false;
}

// Redirect admin if !logged in
function admin_login_redirect($url = 'login') {
	$_SESSION['flash_error'] = '<div class="text-center" id="temporary" style="margin-top: 60px;">You must be logged in to access that page.</div>';
	header('Location: '.$url);
}

// Redirect admin if do not have permission
function admin_permission_redirect($url = 'login') {
	$_SESSION['flash_error'] = '<div class="text-center" id="temporary" style="margin-top: 60px;">You do not have permission in to access that page.</div>';
	header('Location: '.$url);
}

function admin_has_permission($permission = 'admin') {
	global $admin_data;
	$permissions = explode(',', $admin_data['admin_permissions']);
	if (in_array($permission, $permissions, true)) {
		return true;
	}
	return false;
}







/////////////////////////////////////////////////////////////////////////////////////////////////////////



// GET PRODUCT CATEGORY
function get_category($category_id) {
	global $conn;
	$output = [];

	$query = "
		SELECT * FROM mifo_category 
		WHERE category_id = :category_id
		AND category_trash = :category_trash 
		LIMIT 1
	";
	$statement = $conn->prepare($query);
	$statement->execute(
		[
			':category_id' 	=> $category_id,
			':category_trash' 	=> 0
		]
	);
	$children = $statement->fetchAll();
	foreach ($children as $child) {
		$output['child'] = $child['category'];
		$parents = $conn->query("SELECT * FROM mifo_category WHERE category_id = {$child['category_parent']}")->fetchAll();
		foreach ($parents as $parent) {
			$output['parent'] = $parent['category'];
		}
	}
	return $output;
}

function get_entire_category($child_id){
	global $conn;
	$id = sanitize($child_id);
	$sql = "
	

		SELECT p.category_parent AS 'pid', p.category AS 'parent', c.category_id AS 'cid', c.category AS 'child'
		FROM mifo_category c
		INNER JOIN mifo_category p
		ON c.category_parent = p.category_id
		WHERE c.category_id = '$id'";

	$statement = $conn->query($sql);
	$categories = $statement->fetchAll();
	foreach ($categories as $category) {
		// code...
	return $category;
	}
}


	// GET PRODUCT CATEGORY
function get_product_category($product_category) {
	global $conn;
	$output = '';

	$query = "
		SELECT * FROM mifo_category 
		WHERE category_trash = :category_trash
	";
	$statement = $conn->prepare($query);
	$statement->execute(
		[
			':category_trash' 	=> 0
		]
	);
	$result = $statement->fetchAll();
	$count_category = $statement->rowCount();
	if ($count_category > 0) {
		foreach ($result as $row) {
			$output .= '
				<option value="'.$row['category_id']. '" '.(($product_category == $row['category_id'])? "selected" : "").'>'.ucwords($row['category']).'</option>
			';
		}
	} else {
		$output = '<option value="">No category found.</option>';
	}
	return $output;
}

// GET ALL PRODUCTS WHERE TRASH = 0
function  get_all_product($product_trash = '') {
	global $conn;
	$output = '';

	$query = "
		SELECT * FROM mifo_product 
		INNER JOIN mifo_brand 
		ON mifo_brand.brand_id = mifo_product.product_brand  
		INNER JOIN mifo_category
		ON mifo_category.category_id = mifo_product.product_category
		LEFT JOIN vonna_admin
		ON vonna_admin.admin_id = mifo_product.product_added_by
		WHERE mifo_product.product_trash = :product_trash
		AND mifo_category.category_trash = :category_trash
		ORDER BY mifo_product.product_id DESC
	";
	$statement = $conn->prepare($query);
	$statement->execute([
		':product_trash' 	=> $product_trash,
		':category_trash' 	=> 0
	]);
	$count_products = $statement->rowCount();
	$result = $statement->fetchAll();

	if ($count_products > 0) {
		$i = 1;
		foreach ($result as $key => $row) {
			$output .= '
				<tr>
					<td>'.$i.'</td>
					<td>'.ucwords($row["product_name"]).'</td>
					<td>'.$row["brand_name"].'</td>
					<td>'.ucwords($row["category"]).'</td>
					<td>'.money($row["product_price"]).'</td>
					<td>'.$row["product_sizes"].'</td>
					<td>'.ucwords($row["admin_fullname"]).'</td>
					<td>'.pretty_date($row["product_added_date"]).'</td>
				';
				if ($product_trash == 0) {
					$output .= '
						<td>
							<a href="'.PROOT.'admin/products?featured='.(($row['product_featured'] == 0)?"1":"0").'&id='.$row["product_id"].'" class="btn btn-sm btn-light">
								<span data-feather="'.(($row['product_featured'] == 0)?"plus":"minus").'"></span> '.(($row['product_featured'] == 0)?"":"Featured product").'
							</a>
						</td>
						<td>
					';
				} else {
					$output .= '
						<td>
						</td>
						<td>
					';
				}
				if ($product_trash == 1) {
					$output .= '
						<a href="'.PROOT.'admin/products?permanent_delete='.$row["product_id"].'&upload_product_image_name='.$row["product_image"].'" class="btn btn-sm btn-outline-primary"><span data-feather="trash"></span></a>&nbsp;
                          <a href="'.PROOT.'admin/products?restore='.$row["product_id"].'" class="btn btn-sm btn-outline-danger"><span data-feather="refresh-cw"></span></a>&nbsp;
					';
				} else {
					$output .= '
							<a href="'.PROOT.'admin/products?edit='.$row["product_id"].'" class="btn btn-sm btn-info"><span data-feather="edit-2"></span></a>
							<a href="'.PROOT.'admin/products?delete='.$row["product_id"].'" class="btn btn-sm btn-secondary"><span data-feather="trash-2"></span></a>
						';
				}
				$output .= '
						</td>
					</tr>
				';
			$i++;
		}
	} else {
		$output = '
			<tr>
				<td colspan="9">No products found in the database...</h3></td>
			</tr>
		';
	}
	return $output;
}

// GET ALL CATEGORIES
function get_all_category($category_trash = 0) {
	global $conn;
	$output = '';

	$query = "
		SELECT * FROM mifo_category 
		WHERE category_parent = :category_parent 
		AND category_trash = :category_trash 
		ORDER BY category_id DESC
	";
	$statement = $conn->prepare($query);
	$statement->execute([
		':category_parent' => 0,
		':category_trash' => $category_trash
	]);
	$result = $statement->fetchAll();
	$count_row = $statement->rowCount();

	if ($count_row > 0) {
		foreach ($result as $row) {
			$parent_id = (int)$row["category_id"];
			$child = $conn->query("
				SELECT * FROM mifo_category 
				WHERE category_parent = {$parent_id}
			")->fetchAll();


			$output .= '
				<tr class="bg-info">
					<td>
						<a href="category?edit='.$row["category_id"].'" class="btn btn-sm btn-secondary"><i data-feather="edit"></i></a>
					</td>
					<td>'.ucwords($row["category"]).'</td>
					<td>Parent</td>
					<td>'.pretty_date($row["category_added_date"]).'</td>
					<td>
						<span id="'.$row["category_id"].'" onclick="perm_delete_category(category_id = '.$row["category_id"].');" class="btn btn-sm btn-light"><i data-feather="trash-2"></i></span>
					</td>
				</tr>
			';
			foreach ($child as $child_row) {
				// code...
				$output .= '

				<tr class="bg-light">
					<td>
						<a href="category?edit='.$child_row["category_id"].'" class="btn btn-sm btn-secondary"><i data-feather="edit"></i></a>
					</td>
					<td>'.ucwords($row["category"]).'</td>
					<td>'.ucwords($child_row["category"]).'</td>
					<td>'.pretty_date($child_row["category_added_date"]).'</td>
					<td>
						<span id="'.$child_row["category_id"].'" onclick="temp_delete_category(category_id = '.$child_row["category_id"].');" class="btn btn-sm btn-light">Delete</span>
						</td>
					</tr>
				';
			}
		}
	} else {
		$output = '
			<tr>
				<td colspan="4">No category found.</td>
			</tr>
		';
	}
	return $output;
}


// GET ALL CATEGORIES
function get_all_faqs() {
	global $conn;
	$output = '';

	$query = "
		SELECT * FROM vonna_faq 
		ORDER BY id DESC
	";
	$statement = $conn->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$count_row = $statement->rowCount();

	if ($count_row > 0) {
		foreach ($result as $row) {
			$output .= '
				<tr>
					<td>
						<a href="'. PROOT .'adminvonna/Faq/'.$row["id"].'" class="btn btn-sm btn-secondary"><i data-feather="edit"></i></a>
					</td>
					<td>'.ucwords($row["faq_head"]).'</td>
					<td>'.ucwords($row["faq_body"]).'</td>
					<td>'.pretty_date($row["createdAt"]).'</td>
					<td>
						<span id="'.$row["id"].'" onclick="delete_faq_all(id = '.$row["id"].');" class="btn btn-sm btn-light"><i data-feather="trash-2"></i></span>
					</td>
				</tr>
			';
		}
	} else {
		$output = '
			<tr>
				<td colspan="5">No data found.</td>
			</tr>
		';
	}
	return $output;
}

// CHECK IF FAQ EXISTS
function faq_exist($id) {
	global $conn;

	$query = "
        SELECT * FROM vonna_faq 
        WHERE id = :id 
        LIMIT 1
    ";
    $statement = $conn->prepare($query);
    $statement->execute([':id' => $id]);

    $arr['counting'] = $statement->rowCount();;
    $arr['row'] = $statement->fetchAll();

    return $arr;
}



function low_inventory_access() {
	global $conn;
	$inventoryQ = "
        SELECT * FROM mifo_product 
        WHERE product_trash = ?
    ";
    $statement = $conn->prepare($inventoryQ);
    $statement->execute([0]);
    $inventory_result = $statement->fetchAll();
    $lowItems = array();
    foreach ($inventory_result as $inventory_row) {
    	$item = array();
    	$sizes = sizesToArray($inventory_row['product_sizes']);
    	foreach ($sizes as $size) {
    		// code...
    		if ($size['quantity'] <= $size['threshold']) {
    			// code...
		    	$cat = get_entire_category($inventory_row['product_category']);
		    	$item = array(
		    		'title' => $inventory_row['product_name'],
		    		'size' => $size['size'],
		    		'quantity' => $size['quantity'],
		    		'threshold' => $size['threshold'],
		    		'category' => $cat['parent'] . ' ~ ' . $cat['child']
		    	);
	        	$lowItems[] = $item;
	    	}
    	}
         
        
    }
    return $lowItems;
}











////////////////////////////////////////////////////////////////////////////////////////////////////

// GET ALL ADMINS
function get_all_admins() {
	global $conn;
	global $admin_data;
	$output = '';

	$query = "
		SELECT * FROM vonna_admin 
		WHERE admin_trash = :admin_trash
	";
	$statement = $conn->prepare($query);
	$statement->execute([':admin_trash' => 0]);
	$result = $statement->fetchAll();

	foreach ($result as $row) {
		$admin_last_login = $row["admin_last_login"];
		if ($admin_last_login == NULL) {
			$admin_last_login = '<span class="text-secondary">Never</span>';
		} else {
			$admin_last_login = pretty_date($admin_last_login);
		}
		$output .= '
			<tr>
				<td>
		';
					
		if ($row['admin_id'] != $admin_data['admin_id']) {
			$output .= '
				<a href="'.PROOT.'admin/admins?delete='.$row["admin_id"].'" class="btn btn-sm btn-light"><span data-feather="trash-2"></span></a>
			';
		}

		$output .= '
				</td>
				<td>'.ucwords($row["admin_fullname"]).'</td>
				<td>'.$row["admin_email"].'</td>
				<td>'.pretty_date($row["admin_joined_date"]).'</td>
				<td>'.$admin_last_login.'</td>
				<td>'.$row["admin_permissions"].'</td>
			</tr>
		';
	}
	return $output;
}

// GET ADMIN PROFILE DETAILS
function get_admin_profile() {
	global $conn;
	global $admin_data;
	$output = '';

	$query = "
		SELECT * FROM vonna_admin 
		WHERE admin_id = :admin_id 
		AND admin_trash = :admin_trash 
		LIMIT 1
	";
	$statement = $conn->prepare($query);
	$statement->execute([
		':admin_id' => $admin_data['admin_id'],
		':admin_trash' => 0,
	]);
	$result = $statement->fetchAll();

	foreach ($result as $row) {
		$output = '
			<h3>Name</h3>
		    <p class="lead">'.ucwords($row["admin_fullname"]).'</p>
		    <br>
		    <h3>Email</h3>
		    <p class="lead">'.$row["admin_email"].'</p>
		    <br>
		    <h3>Joined Date</h3>
		    <p class="lead">'.pretty_date($row["admin_joined_date"]).'</p>
		    <br>
		    <h3>Last Login</h3>
		    <p class="lead">'.pretty_date($row["admin_last_login"]).'</p>
		';
	}
	return $output;
}

// LIST * USERS
function get_all_users($user_trash = 0) {
	global $conn;

	$query = "
		SELECT * FROM mifo_user
		WHERE user_trash = :user_trash
	";
	$statement = $conn->prepare($query);
	$statement->execute([':user_trash' => $user_trash]);
	$result = $statement->fetchAll();
	$row_count = $statement->rowCount();

	$output = '';
	if ($row_count > 0) {

		$i = 1;
		foreach ($result as $row) {
			$user_last_login = $row["user_last_login"];
			if ($user_last_login == NULL) {
				$user_last_login = '<span class="text-secondary">Never</span>';
			} else {
				$user_last_login = pretty_date($user_last_login);
			}

			$output .= '
				<td>'.$i.'</td>
				<td>'.ucwords($row["user_fullname"]).'</td>
				<td>'.$row["user_email"].'</td>
				<td>'.(($row["user_phone"] != '')?$row["user_phone"]:'<span class="text-secondary">Empty</span>').'</td>
				<td>'.(($row["user_address"] != '')?ucwords($row["user_address"]):'<span class="text-secondary">Empty</span>').'</td>
				<td>'.pretty_date($row["user_joined_date"]).'</td>
				<td>'.$user_last_login.'</td>
				<td>
					<a href="users?view='.$row["user_id"].'" class="btn btn-sm btn-light"><span data-feather="eye"></span></a>&nbsp;
			';
			if ($user_trash == 1) {
				$output .= '
					<a href="users?restore='.$row["user_id"].'" class="btn btn-sm btn-secondary"><span data-feather="refresh-ccw"></span></a>&nbsp;
					<a href="users?delete='.$row["user_id"].'" class="btn btn-sm btn-warning"><span data-feather="trash"></span></a>&nbsp;
				';
			} else {
				$output .= '
					<a href="users?terminate='.$row["user_id"].'" class="btn btn-sm btn-secondary"><span data-feather="user-x"></span></a>&nbsp;
				';
			}
			$output .= '
					</td>
				</tr>
			';
			$i++;
		}
	} else {
		$output = '
			<tr>
				<td colspan="8"> - No data found under users table.</td>
			</tr>
		';
	}
	return $output;
}

// LIST * USERS
function subscriped_emails() {
	global $conn;

	$query = "
		SELECT * FROM mifo_subscription
	";
	$statement = $conn->prepare($query);
	$statement->execute();
	$row_count = $statement->rowCount();
	$result = $statement->fetchAll();

	$output = '';
	$i = 1;
	if ($row_count > 0) {
		foreach ($result as $row) {
			$output .= '
				<tr>
					<td>'.$i.'</td>
					<td>'.$row["subscription_email"].'</td>
					<td>'.pretty_date($row["subscription_date"]).'</td>
				</tr>
			';
			$i++;
		}
	} else {
		$output = '
			<tr>
				<td colspan="3">No emails under subscription table.</td>
			</tr>
		';
	}
	return $output;
}

// CHECK IF USER EXISTS
function user_exist($user_id) {
	global $conn;

	$query = "
        SELECT * FROM mifo_user 
        WHERE user_id = :user_id 
        LIMIT 1
    ";
    $statement = $conn->prepare($query);
    $statement->execute([':user_id' => $user_id]);
    $count_row = $statement->rowCount();
    return $count_row;
}


// CHECK IF USER EXISTS
function category_exist($category_id) {
	global $conn;

	$query = "
        SELECT * FROM mifo_category 
        WHERE category_id = :category_id 
        LIMIT 1
    ";
    $statement = $conn->prepare($query);
    $statement->execute([':category_id' => $category_id]);
    $count_row = $statement->rowCount();
    $row = $statement->fetchAll();
    $arr['row'] = $row;
    $arr['counting'] = $count_row;

    return $arr;
}











//////////////////////////////////////////////////////////////////////////////////////////////////////////


// Get categories
function get_all_categories() {
	global $conn;
	$output = '';

	$query = '
		SELECT * FROM mifo_category 
		WHERE category_parent = :category_parent 
		AND category_trash = :category_trash 
		ORDER BY category ASC
		LIMIT 5
	';
	$statement = $conn->prepare($query);
	$statement->execute([
		':category_parent' 	=> 0,
		':category_trash' 	=> 0
	]);
	$result = $statement->fetchAll();

	foreach ($result as $row) {
		$output .= '
			<a class="nav-link" href="'.PROOT.'store/category/'.$row["category_id"].'">'.ucwords($row["category"]).'</a>
		';
	}
	return $output;
}


// Get featured products
function get_featured_products($featured = 1, $limit = 12) {
	global $conn;
	$output = '';

	$query = '
		SELECT * FROM mifo_product 
		INNER JOIN mifo_category 
		ON mifo_category.category_id = mifo_product.product_category 
		WHERE mifo_product.product_trash = 0
	';
	if ($featured == 1) {
		$query .= ' AND mifo_product.product_featured = 1';
	}
	$query .= ' ORDER BY mifo_product.product_name ASC LIMIT ' . $limit;

	$statement = $conn->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();

	if ($statement->rowCount() > 0) {
		$n = 0;
		foreach ($result as $row) {
			$product_images = explode(",", $row['product_image']);
			if (count($product_images) == 1) {
				$product_image = '
					<div class="row">
	                    <div class="col h-20">
	                    	<img class="w-100"  style="object-fit: cover;" src="' . PROOT . $row['product_image'] . '" alt="' . $row['category'] . ' image." style="transform: translate(0px, 0px); opacity: 1;" />
	                    </div>
	                </div>
				';
			} else {
				$product_image = '
                    <div class="hoverbox">
                        <div class="row">
                            <div class="col h-20">
                            	<img class="w-100"  style="object-fit: cover;" src="' . PROOT . $product_images[0] . '" alt="' . $row['category'] . ' image." style="transform: translate(0px, 0px); opacity: 1;" />
                            </div>
                        </div>
                        <div class="hoverbox-content hoverbox-background">
                            <div class="hoverbox-bg d-flex flex-center h-100 w-100">
                            	<img class="w-100"  style="object-fit: cover;" src="' . PROOT . $product_images[1] . '" alt="' . $row['category'] . ' image." />
                            </div>
                        </div>
                    </div>
				';
			}
			
			$output .= '
				<div class="col-6 col-lg-3 mt-4">
                    <a class="row g-0" href="' . PROOT . 'shop/products/'.$row['product_url'].'">
                        <div class="col-12 overflow-hidden rounded position-relative" data-zanim-timeline="{"/delay/":0}" data-zanim-trigger="scroll">
                            <div class="badge badge-rotate bg-danger" style="transform: translate(-40.5879px, 0px) rotate(-45deg); opacity: 1;"}">' . soldOut($row['product_id']) . '</div>
                            ' . $product_image . '
                        </div>
                        <div class="col-6 mt-2">
                            <h5 class="fs-0">' . ucwords($row["product_name"]) . '</h5>
                        </div>
                        <div class="col-6 mt-2 text-end">
                            <h6 class="fw-normal mb-0 d-inline-block">' . money($row["product_price"]) . '</h6>
            ';
                     	if ($row['product_list_price'] != '0.00') {
                        	$output .= '<h6 class="fw-normal text-600"><span class="d-inline-block"><del>$454.00</del></span></h6>';
                     	}
            $output .= '</div>
                    </a>
                </div>
			';
			$n++;
			if ($n == 4) {
				$output .= '
					<div class="w-100 d-none d-lg-block"></div>
				';
			}
		}
	}
	return $output;
}








///////////////////////////////////////////////////////////////////////////////////////////////////////////

// FIND USER WITH EMAIL
 function findUserByEmail($email) {
 	global $conn;
    $sql = "
    	SELECT * FROM vonna_user 
    	WHERE user_email = :user_email
    ";
    $statement = $conn->prepare($sql);
    $statement->execute([':user_email' => $email]);
    $result = $statement->fetchAll();
    foreach ($result as $row) {
    	return $row;
    }
}

// Sessions For login
function userLogin($user_id) {
	$_SESSION['VNUser'] = $user_id;
	global $conn;
	$data = array(
		':user_last_login' => date("Y-m-d H:i:s"),
		':user_id' => (int)$user_id
	);
	$query = "
		UPDATE vonna_user 
		SET user_last_login = :user_last_login 
		WHERE user_id = :user_id
	";
	$statement = $conn->prepare($query);
	$result = $statement->execute($data);
	if (isset($result)) {
		$_SESSION['flash_success'] = 'You are now logged in!';
		redirect(PROOT . 'account/index');
	}
}

function user_is_logged_in(){
	if (isset($_SESSION['VNUser']) && $_SESSION['VNUser'] > 0) {
		return true;
	}
	return false;
}

// Redirect admin if !logged in
function user_login_redirect($url = 'signin') {
	$_SESSION['flash_error'] = 'You must be logged in to access that page.';
	redirect(PROOT . 'auth/' . $url);
}


function send_vericode($email) {
	global $conn;
    $success = false;
    $user = findUserByEmail($email);

    if($user) {
      	$vericode = md5(time());
      	$sql = "
      		UPDATE mifo_user 
      		SET user_vericode = :user_vericode 
      		WHERE user_id = :user_id
      	";
      	$statement = $conn->prepare($sql);
      	$result = $statement->execute([
      		':user_vericode' => $vericode,
      		':user_id' => $user['user_id']
      	]);
      	if ($result) {
        	$fn = ucwords($user['user_fullname']);
        	$to = $email;
         	$subject = "Please Verify Your Account";
			$body = "
				<h3>
					{$fn},</h3>
					<p>
						Thank you for regestering. Please verify your account by clicking 
          				<a href=\"http://sites.local/mifo/verify/{$vericode}\" target=\"_blank\">here</a>.
        		</p>
			";

			$mail = send_email($fn, $to, $subject, $body);
			if ($mail) {
				$success = 'Message has been sent';
			} else {
			    return "Message could not be sent.";
			    //return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}
      	}
    }
    return $success;
 }











////////////////////////////////////////////////////////////////////////////////////

// count products in cart
function count_cart_new() {
	global $conn;
	global $user_data;
	$output = 0;

	$cart_id = '';
 	if (isset($_COOKIE[CART_COOKIE])) {
 		$cart_id = sanitize($_COOKIE[CART_COOKIE]);
 	}

	if (!empty($cart_id)) {
      	$sql = "
        	SELECT * FROM mifo_cart 
        	WHERE cart_id = ?
      	";
      	$statement = $conn->prepare($sql);
      	$statement->execute([$cart_id]);
      	$row = $statement->fetchAll();
      	if ($statement->rowCount() > 0) {
          	$items = json_decode($row[0]['items'], true);
          	$user_idArray = array();
          	foreach ($items as $item) {
          		// code...
				$user_idArray[] = $item['user_id'];
		    	$logged_user = (user_is_logged_in() ? $user_data['user_id'] : '');
		        if ($item['user_id'] == $logged_user && $item['pays'] == 0) {
		        	$output = '(' . count($user_idArray) . ')';
		        } else {
		        	if (!user_is_logged_in()) {
		        		// code...
			        	$counts = array_count_values($user_idArray);
						$output = '(' . @$counts['0'] . ')';
		        	}
		        }
          	}
	    }
    }
    if ($output == 0) {
    	$output = '';
    }
	
	return $output;
}

// sizes to array
function sizesToArray($string) {
	$sizesArray = explode(',', $string);
	$returnArray = array();
	foreach ($sizesArray as $size) {
		// code...
		$s = explode(":", $size);
		$returnArray[] = array('size' => $s[0], 'quantity' => $s[1], 'threshold' => $s[2]);
							//Array ( [0] => Array ( [size] => small [quantity] => 11 [threshold] => 2 ) )
	}
	return $returnArray;
}

// 
function sizesToString($sizes) {
	$sizeString = '';
	foreach ($sizes as $size) {
		// code...
		$sizeString .= $size['size'] . ':' . $size['quantity'] . ':' . $size['threshold'] . ',';
	}
	$trimmed = rtrim($sizeString, ',');
	return $trimmed;
}

// get sold out products
function soldOut($product_id) {
	$product_id = sanitize((int)$product_id);
	global $conn;

	 $sql = "
        SELECT * FROM mifo_product 
        WHERE mifo_product.product_id = :product_id 
        AND mifo_product.product_trash = :product_trash 
        LIMIT 1
    ";
    $statement = $conn->prepare($sql);
    $statement->execute([
        ':product_id'     => $product_id,
        ':product_trash'  => 0
    ]);
    $count_row = $statement->rowCount();
    $row = $statement->fetchAll();
    if ($count_row > 0) {
       $sizeString = $row[0]['product_sizes']; 
       $size_array = explode(',', $sizeString); 

	    foreach ($size_array as $string) { 
	        $string_array = explode(':', $string);
	        $size = $string_array[0];
	        $available = $string_array[1];
	        if ($available > 0) {
	            return null;
	        } else {
	            return 'Sold out';
	        }
		}                   
   }
}


// get all brands
function getall_brands($limit) {
	global $conn;
 	$sql = "
        SELECT * FROM mifo_brand 
        ORDER BY brand_id DESC 
        LIMIT $limit
    ";
    $statement = $conn->prepare($sql);
    $statement->execute();
    return $statement->fetchAll();
}


?>