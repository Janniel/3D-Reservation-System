<?php
	session_start();
if ($_SESSION['account_type'] == "admin") {
	session_unset();
	session_destroy();
	header('Location: loginAdmin.php');
} else {
	session_unset();
	session_destroy();
	header('Location: index.php');
}
?>