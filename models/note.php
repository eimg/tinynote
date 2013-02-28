<?php
function get_notes() {
	$user = get_user_data();
	$user_id = $user['id'];

	$db = new db();
	$result = $db->read("notes", "user_id=:id ORDER BY created_date", array(
		":id" => $user_id
	));

	return $result;
}

function add_note() {
	$user = get_user_data();
	$user_id = $user['id'];

	$db = new db();
	$result = $db->create("notes", array(
		"user_id" => $user_id,
		"title" => "Empty note"
	));

	return $result;
}

function save_note($id, $title, $body) {
	if($body == "" && $title == "") {
		$title = "Empty note";
	}

	if(($title == "" || $title == "Empty note") && $body != "") {
		$title = truncate(strip_tags($body), 30);
	}

	$db = new db();
	$result = $db->update("notes", array(
		"title" => $title,
		"body" => $body
	), "id = :id", array(
		":id" => $id
	));

	$result = array(
		"id" => $id,
		"title" => $title,
		"body" => $body,
	);

	return $result;
}

function remove_note($id) {
	$db = new db();
	$result = $db->read("notes", "id = :id", array(
		":id" => $id
	), "super_note");

	if(!$result || $result[0]['super_note']) {
		return false;
	}

	$result = $db->delete("notes", "id = :id", array(
		":id" => $id
	));

	return $result;
}

function send_note_to_email($email, $id) {
	$db = new db();
	$result = $db->read("notes", "id = :id", array(
		":id" => $id
	));

	$subject = "[TinyNote] " . $result[0]['title'];
	$body = "<html><body>";
	$body .= $result[0]['body'];
	$body .= "</body></html>";

	$user = get_user_data();
	$user_id = $user['id'];
	$user_email = $db->get_query("SELECT email FROM users WHERE id=$user_id");
	$user_email = $user_email[0]['email'];

	$headers = "From: {$user_email}\r\n";
	$headers .= "Reply-To: {$user_email}\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	@mail($email, $subject, $body, $headers);

	return true;
}