<?php

spl_autoload_register(function ($class) {

    //var_dump($class);
    // project-specific namespace prefix
    $prefix = 'App\\';

    // base directory for the namespace prefix
    $base_dir = ROOT;
    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    //var_dump($file);
    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});



/*function autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) .
            DIRECTORY_SEPARATOR;
}
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    var_dump($fileName);
    require $fileName;
}
spl_autoload_register('autoload');*/

/*spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'Controllers\\';

    // base directory for the namespace prefix
    $base_dir = __DIR__ . '/Controllers/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    //var_dump($file);
    // if the file exists, require it
    if (file_exists($file)) {
        var_dump($file);
        require $file;
    }
});*/