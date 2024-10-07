/**
 * 
 * This script initializes the development environment for the web application.
 * It sets up various constants and configuration settings required for testing and development.
 * 
 * Constants:
 * - dev_id: Developer ID
 * - dev_firstname: Developer's first name
 * - dev_lastname: Developer's last name
 * - dev_username: Developer's username
 * - dev_password: Developer's password (hashed)
 * - dev_last_login: Last login time of the developer
 * - dev_date_updated: Last updated date
 * - dev_date_added: Date added
 * - dev_json_data: JSON-encoded version of the dev_data array
 * - base_url: Base URL/absolute URL of the application
 * - base_app: Base directory of the application, used for accessing files and folders
 * - dev_data: Array containing developer's data
 * 
 * Database Credentials:
 * - DB_SERVER: Database server address
 * - DB_USERNAME: Database username
 * - DB_PASSWORD: Database password
 * - DB_NAME: Database name
 */
<?php
// Development environment for the web application, for testing and development
$dev_data = array(
	'id' => '-1',
	'firstname' => 'Developer',
	'lastname' => 'Olrac',
	'username' => 'dev_oretnom',
	'password' => '5da283a2d990e8d8512cf967df5bc0d0',
	'last_login' => '',
	'date_updated' => '',
	'date_added' => ''
);

foreach ($dev_data as $k => $v) {
	if (!defined('dev_' . $k)) define('dev_' . $k, $v);
}

if (!defined('dev_json_data')) define('dev_json_data', json_encode($dev_data)); // stores the JSON-encoded version of the dev_array
if (!defined('base_url')) define('base_url', 'http://localhost/crm/'); // base URL/absolute URL
if (!defined('base_app')) define('base_app', str_replace('\\', '/', __DIR__) . '/'); // defines the base directory of the application, used for accessing files and folders
if (!defined('dev_data')) define('dev_data', $dev_data);

// Storing database credentials
if (!defined('DB_SERVER')) define('DB_SERVER', "localhost");
if (!defined('DB_USERNAME')) define('DB_USERNAME', "root");
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', "");
if (!defined('DB_NAME')) define('DB_NAME', "crm_db");
?>