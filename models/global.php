<?php
function is_auth() {
	return $_SESSION["auth"];
}

function get_user_data() {
	if(!is_auth) return false;

	$id = $_SESSION['id'];
	$db = new Database();

	$result = $db->get_query("SELECT * FROM users WHERE id=$id");

	return $result[0];
}