<?php

require_once "./includes/markdown.php";

if (isset($_GET['n'])){
	$title = $_GET['n'];
	if (preg_match('/\w+\/\w+/', $title)) {
		include("./includes/exo.php");
	} else {
		include("./includes/dir.php");
	}
} else {
	include("./includes/homepage.php");
}
?>
