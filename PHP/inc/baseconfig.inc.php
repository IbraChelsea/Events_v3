<?php 
if (!defined('MYSQL_HOST')) {
    define('MYSQL_HOST', 'localhost');
}

if (!defined('MYSQL_USER')) {
    define('MYSQL_USER', 'root');
}

if (!defined('PARTICIPANTS_PW')) {
    define('PARTICIPANTS_PW', 'f9038b631ed495c34a74a122eebef38ae84b475a');
}

if (!defined('MYSQL_PASSWORD')) {
    define('MYSQL_PASSWORD', 'chelsea');
}

if (!defined('MYSQL_DATABASE')) {
    define('MYSQL_DATABASE', 'test_ito');
}

if (getenv('APPLICATION_ENV') == 'development') {
    define('APPLICATION_ENV', 'development');
} else {
    define('APPLICATION_ENV', 'production');
}
?>