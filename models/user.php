<?php
function check_auth($email, $password) {
	$db = new db();

	$password = md5($password);
	$result = $db->read("users", "email = :email AND password = :password", array(
		":email" => $email,
		":password" => $password
	));

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
	$db = new db();

	$check = $db->read("users", "email = :email", array(
		":email" => $email
	));
	if($check) {
		return false;
	}

	$password = md5($password);
	$result = $db->create("users", array(
		"name" => $name,
		"email" => $email,
		"password" => $password,
	));

	if($result) {

		$title = "Hello, World!";
		$body = "This is your first note. Please edit as you wish and hit the Save Note button to save your changes. To add new note, use the Add New Note button above note list. You can send your note to any email address via Send To button.<br><br>This app is created with TinyMVC PHP micro framework and for example purpose only. Thanks for using...";

		$db->create("notes", array(
			"user_id" => $result,
			"title" => $title,
			"body" => $body,
			"super_note" => 1
		));

		set_auth($result);
		return $result;
	}

	return false;
}

function update_name($name) {
	$db = new db();

	$user = get_user_data();
	$id = $user['id'];

	$result = $db->update("users", array(
		"name" => $name
	), "id = :id", array(
		":id" => $id
	));

	return $result;
}

function update_password($password) {
	$db = new db();

	$user = get_user_data();
	$id = $user['id'];
	$password = md5($password);

	$result = $db->update("users", array(
		"password" => $password
	), "id = :id", array(
		":id" => $id
	));

	return $result;
}