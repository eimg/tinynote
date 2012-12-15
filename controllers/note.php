<?php
if(!is_auth()) redirect("user/signin");

switch($action) {
	case "all":
		get_all();
		break;
	case "new":
		new_note();
		break;
	case "update":
		update_note();
		break;
	case "delete":
		delete_note();
		break;
	case "send":
		send_note();
		break;
	default:
		invalid_request_error();
}

function get_all() {
	$result = get_notes();
	echo json_encode($result);
}

function new_note() {
	$result = add_note();

	if($result) {
		echo json_encode(array(
			"err" => 0,
			"id" => $result
		));
	} else {
		echo json_encode(array(
			"err" => 1,
			"msg" => "Unable to add new note!"
		));
	}
}

function update_note() {
	$id = $_POST['id'];
	$title = $_POST['title'];
	$body = $_POST['body'];

	$result = save_note($id, $title, $body);

	if($result) {
		echo json_encode($result);
	} else {
		echo json_encode(array(
			"err" => 1,
			"msg" => "Unable to save note!"
		));
	}
}

function delete_note() {
	$id = $_POST['id'];

	$result = remove_note($id);

	if($result) {
		echo json_encode(array(
			"err" => 0
		));
	} else {
		echo json_encode(array(
			"err" => 1,
			"msg" => "Unable to save note!"
		));
	}
}

function send_note() {
	$id = $_POST['id'];
	$email = $_POST['email'];

	$result = send_note_to_email($email, $id);
	echo "";
}

function invalid_request_error() {
	return json_encode(array(
		"err" => 1,
		"msg" => "Invalid Request!"
	));
}