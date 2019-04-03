<?php
	// It always is necessary when we want to destroy or create a SESSION 
	session_start();

	// Destroy all activated SESSION 
	session_destroy();

	// Redirect to index.php from the main page for all users
	header("Location: ../index.php");
?>