<?php

spl_autoload_register(function($className) {
    // Define the base directory for the namespace prefix
    $baseDir = __DIR__ . '/src/';

    // Define the namespace prefix
    $prefix = 'MyApp\\';

    // Does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $className, $len) !== 0) {
        // No, move to the next autoloader
        return;
    }

    // Get the relative class name
    $relativeClass = substr($className, $len);

    // Replace the namespace prefix with the base directory
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});
