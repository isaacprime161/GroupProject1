<?php
require_once 'conf.php';

$directories = [
    'Layouts',
    'Forms',
    'Globals'
];

spl_autoload_register(function ($className) use ($directories) {
    foreach ($directories as $dir) {
        $filePath = __DIR__ . '/' . $dir . '/' . $className . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
            return;
        }
    }
});

if (class_exists('Layouts')) {
    $ObjLayouts = new Layouts();
}
if (class_exists('Forms')) {
    $ObjForms = new Forms();
}
