<?php
    // function to sanitize the data
	function sanitizeData($stringDataFromForm) {
		$sanitizedData = trim($stringDataFromForm);
		$sanitizedData = htmlspecialchars($sanitizedData);
		$sanitizedData = stripslashes($sanitizedData);
		
		return $sanitizedData;
	}
?>