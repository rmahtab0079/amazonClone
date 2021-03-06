<?php
function title($str){
	if(empty($str)){
		$str = "Amazon";
	}
	echo $str;
}

function redirect_user ($page = 'indexView.php') {

	// Start defining the URL...
	// URL is http:// plus the host name plus the current directory:
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

	// Remove any trailing slashes:
	$url = rtrim($url, '/\\');

	// Add the page:
	$url .= '/' . $page;

	// Redirect the user:
	header("Location: $url");
	exit(); // Quit the script.

} // End of redirect_user() function.

function redirect($where){
	// Start defining the URL...
	// URL is http:// plus the host name plus the current directory:
	// $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

	// Remove any trailing slashes:
	$url = rtrim($url, '/\\');

	// Add the page:
	// $url .= '/' . $page;

	// Redirect the user:
	header("Location: $url");
	exit(); // Quit the script.
    // header("Location: $where");
}

function sortBy() {
    if ($_REQUEST['select1'] == 'p1'){
        redirect('http://google.com');
    }elseif($_REQUEST['select1'] == 'p2'){
        redirect('http://example.com/elsewhere.php');
    }
}


function numStars ($s) {
	switch ($s) {
    case 1:
        return "images/1-star.png";
        break;
    case 2:
        return "images/2-stars.png";
        break;
    case 3:
        return "images/3-stars.png";
        break;
	case 4:
		return "images/4-stars.png";
		break;
	case 5:
	    return "images/5-stars.png";
	    break;
    default:
        return "images/5-stars.png";
	}
}

function isPrime ($p) {
	if ($p == 1) {
		return "<img src='images/prime.png' class='prime' />";
	}
}


/* This function validates the form data (the email address and password).
 * If both are present, the database is queried.
 * The function requires a database connection.
 * The function returns an array of information, including:
 * - a TRUE/FALSE variable indicating success
 * - an array of either errors or the database result
 */
function check_login($dbc, $email = '', $pass = '') {

	$errors = array(); // Initialize error array.

	// Validate the email address:
	if (empty($email)) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($email));
	}

	// Validate the password:
	if (empty($pass)) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($pass));
	}

	if (empty($errors)) { // If everything's OK.

		// Retrieve the user_id and first_name for that email/password combination:
		$q = "SELECT user_id, name FROM users WHERE email='$e' AND password=SHA1('$p')";
		$r = @mysqli_query ($dbc, $q); // Run the query.

		// Check the result:
		if (mysqli_num_rows($r) == 1) {

			// Fetch the record:
			$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);

			// Return true and the record:
			return array(true, $row);

		} else { // Not a match!
			$errors[] = 'The email address and password entered do not match those on file.';
		}

	} // End of empty($errors) IF.

	// Return false and the errors:
	return array(false, $errors);

} // End of check_login() function.

function check_search($dbc, $search = '') {

	$errors = array(); // Initialize error array.

	// Validate the email address:
	if (empty($search)) {
		$errors[] = 'You forgot to enter something in the search address.';
	} else {
		$s = mysqli_real_escape_string($dbc, trim($search));
	}


	if (empty($errors)) { // If everything's OK.

		// Retrieve the user_id and first_name for that email/password combination:
		$q = "SELECT product_id, product_img_url, name, review_stars, review_num, price_dollars, price_cents, is_prime, product_condition, tag_1, tag_2 FROM products WHERE name = " .$searchQ. " OR tag_1 = " .$searchQ. " OR tag_2 = " .$searchQ. ";";
		// $q = "SELECT user_id, name FROM users WHERE email='$e' AND password=SHA1('$p')";
		$r = mysqli_query($dbc, $q); // Run the query.

		// Check the result:
		if (mysqli_num_rows($r) >= 1) {

			// Fetch the record:
			$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);

			// Return true and the record:
			return array(true, $row);

		} else { // Not a match!
			$errors[] = 'The email address and password entered do not match those on file.';
		}

	} // End of empty($errors) IF.

	// Return false and the errors:
	return array(false, $errors);

} // End of check_login() function.


?>
