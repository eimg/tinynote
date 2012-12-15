<?php
switch($action) {
	case "":
		show_home();
		break;
	default:
		show_404();
}

function show_home() {
	if(!is_auth()) {
		redirect("user/signin");
	}
	
	render("home");
}

function show_404() {
	render("404");
}