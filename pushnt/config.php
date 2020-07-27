  
<?php
/**
 * Database config variables
 */
define("DB_HOST", "localhost:3306");
define("DB_USER", "root");			//fill with value
define("DB_PASSWORD", "");		//fill with value
define("DB_DATABASE", "medhax-task");		//fill with value

/*
 * Google API Key
 */
define("GOOGLE_API_KEY", ""); // Place your Google API Key
//define('GOOGLE_API_URL','https://android.googleapis.com/gcm/send'); //deprecated
define("GOOGLE_API_URL","https://gcm-http.googleapis.com/gcm/send");

define("BASE_URL", "https://neurobin.org/"); //optional
define("PWD", "./");
define("PWP", "https://neurobin.org/api/android/gcm/gcm-server-demo/"); //optional

?>