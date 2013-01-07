<?php
switch($action) {
	case "":
	case "signin":
	case "signin-failed":
	case "create-failed":
		show_signin();
		break;
	case "try-signin":
		try_signin();
		break;
	case "account":
		show_account();
		break;
	case "create":
		create_account();
		break;
	case "signout":
		signout();
		break;
	case "change-name":
		change_name();
		break;
	case "change-password":
		change_password();
		break;
	default:
		show_404();
}

function show_signin() {
	if(is_auth()) {
		redirect("home");
	}

	render("signin");
}

function try_signin() {
	$email = $_POST['email'];
	$password = $_POST['password'];

	$result = check_auth($email, $password);

	if($result) {
		redirect("home");
	} else {
		redirect("user/signin-failed");
	}
}

function show_account() {
	$user = get_user_data();

	if($user) {
		$data['name'] = $user['name'];
		$data['email'] = $user['email'];

		render("account", $data);
	} else {
		redirect("user/signin");
	}
}

function create_account() {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	$result = insert_user($name, $email, $password);

	if($result) {
		redirect("home");
	} else {
		redirect("user/create-failed");
	}
}

function signout() {
	clear_auth();
	redirect("user/signin");
}

function change_name() {
	$result = update_name($_POST['name']);

	if($result) {
		redirect("user/account");
	} else {
		redirect("user/account/update-name-failed");
	}
}

function change_password($id) {
	$result = update_password($_POST['password']);

	if($result) {
		redirect("user/account");
	} else {
		redirect("user/account/update-password-failed");
	}
}

function show_404() {
	render("404");
}
