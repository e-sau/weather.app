<?php


namespace app\resources;


class Autoload
{
    public function loadClass(string $class)
    {
        $path = explode(DIRECTORY_SEPARATOR, $class);
        $path[0] = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '..';
        $file = implode(DIRECTORY_SEPARATOR, $path) . ".php";

        if (file_exists($file)) require_once $file;
    }
}