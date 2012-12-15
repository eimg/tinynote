<?php
function check_auth($email, $password) {
	$db = new Database();

	$password = md5($password);
	$result = $db->get_query("SELECT * FROM users WHERE email='$email' AND password='$password'");

	if($result) {
		set_auth($result[0]['id']);
		return true;
	}

	return false;
}

function set_auth($id) {
	$_SESSION["auth"] = true;
	$_SESSION["id"] = $id;
}

function clear_auth() {
	unset($_SESSION["auth"]);
	unset($_SESSION["id"]);
}

function insert_user($name, $email, $password) {
	$db = new Database();

	$check = $db->get_query("SELECT * FROM users WHERE email='$email'");
	if($check) {
		return false;
	}

	$password = md5($password);
	$result = $db->set_query("INSERT INTO users (name, email, password) VALUES ('$name','$email','$password')");

	if($result) {

		$title = "Hello, World!";
		$body = "This is your first note. Please edit as you wish and hit the Save Note button to save your changes. To add new note, use the Add New Note button above note list. You can send your note to any email address via Send To button.<br><br>This app is created with TinyMVC PHP micro framework and for example purpose only. Thanks for using...";
		$db->set_query("INSERT INTO notes (user_id, title, body, super_note) VALUES ($result,'$title','$body',1)");

		set_auth($result);
		return $result;
	}

	return false;
}

function update_name($name) {
	$db = new Database();

	$user = get_user_data();
	$id = $user['id'];
	$result = $db->set_query("UPDATE users SET name='$name' WHERE id=$id");

	return $result;
}

function update_password($password) {
	$db = new Database();

	$user = get_user_data();
	$id = $user['id'];
	$password = md5($password);
	$result = $db->set_query("UPDATE users SET password='$password' WHERE id=$id");

	return $result;
}