<?php
function get_notes() {
	$user = get_user_data();
	$user_id = $user['id'];

	$db = new Database();
	$result = $db->get_query("SELECT * FROM notes WHERE user_id = $user_id ORDER BY created_date");

	return $result;
}

function add_note() {
	$user = get_user_data();
	$user_id = $user['id'];

	$db = new Database();
	$result = $db->set_query("INSERT INTO notes (user_id, title) VALUES ($user_id, 'Empty note')");

	return $result;
}

function save_note($id, $title, $body) {
	if($body == "" && $title == "") {
		$title = "Empty note";
	}

	if(($title == "" || $title == "Empty note") && $body != "") {
		$title = truncate(strip_tags($body), 30);
	}

	$db = new Database();
	$result = $db->set_query("UPDATE notes SET title='$title', body='$body' WHERE id=$id");

	$result = array(
		"id" => $id,
		"title" => $title,
		"body" => $body,
	);

	return $result;
}

function remove_note($id) {
	$db = new Database();
	$result = $db->get_query("SELECT super_note FROM notes WHERE id=$id");

	if(!$result || $result[0]['super_note']) {
		return false;
	}

	$result = $db->set_query("DELETE FROM notes WHERE id=$id");

	return $result;
}

function send_note_to_email($email, $id) {
	$db = new Database();
	$result = $db->get_query("SELECT * FROM notes WHERE id=$id");

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