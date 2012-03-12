<?php

/* Timezone */
date_default_timezone_set('UTC');

/**
 * Autoloader that implements the PSR-0 spec for interoperability between
 * PHP software.
 */
if (($autoloader = @include __DIR__.'/../vendor/.composer/autoload.php')) {
    $autoloader->add('Zend', __DIR__ . '/../vendor/pear-zf2/Zend_Dom/php');
} else {
    set_include_path('../library' . PATH_SEPARATOR . get_include_path());
    spl_autoload_register(
        function($className) {
            $fileParts = explode('\\', ltrim($className, '\\'));

            if (false !== strpos(end($fileParts), '_'))
                array_splice($fileParts, -1, 1, explode('_', current($fileParts)));

            $file = implode(DIRECTORY_SEPARATOR, $fileParts) . '.php';

            foreach (explode(PATH_SEPARATOR, get_include_path()) as $path) {
                if (file_exists($path = $path . DIRECTORY_SEPARATOR . $file))
                    return require $path;
            }
        }
    );
}
