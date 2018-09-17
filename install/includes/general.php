<?php

error_reporting(0); //Setting this to E_ALL showed that that cause of not redirecting were few blank lines added in some php files.

$db_config_path = '../application/config/database.php';


	// Only load the classes in case the user submitted the form
	if($_POST) 
	{
		// Load the classes and create the new objects
		require_once('core_class.php');
		require_once('database_class.php');

		$core = new Core();
		$database = new Database();


		// Validate the post data
		if($core->validate_post($_POST) == true)
		{
			// First create the database, then create tables, then write config file
			if($database->create_database($_POST) == false) {
				$message = $core->show_message('error',"The database could not be created, please verify your settings.");
			} else if ($database->create_tables($_POST) == false) {
				$message = $core->show_message('error',"The database tables could not be created, please verify your settings.");
			} else if ($core->write_config($_POST) == false) {
				$message = $core->show_message('error',"The database configuration file could not be written, please chmod application/config/database.php file to 777");
			}

			// If no errors, redirect to registration page
			if(!isset($message)) 
			{

			}
		}
		else {
			$message = $core->show_message('error','Not all fields have been filled in correctly. The host, username, password, and database name are required.');
		}
	}

?>