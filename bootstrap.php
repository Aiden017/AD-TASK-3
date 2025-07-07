<?php

// Define the base directory (root of the project)
define('BASE_PATH', realpath(__DIR__));

// Common directory paths used across the project
define('UTILS_PATH', realpath(BASE_PATH . '/utils'));
define('DUMMIES_PATH', realpath(BASE_PATH . '/staticData/dummies'));
define('DATABASE_PATH', realpath(BASE_PATH . '/database'));
define('HANDLERS_PATH', realpath(BASE_PATH . '/handlers'));
define('SRC_PATH', realpath(BASE_PATH . '/src'));

// You can add more if needed
