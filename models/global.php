<?php
function is_auth() {
	return $_SESSION["auth"];
}

function get_user_data() {
	if(!is_auth) return false;

	$id = $_SESSION['id'];
	$db = new db();

	$result = $db->read("users", "id = :id", array(
		":id" => $id
	));

	return $result[0];
}