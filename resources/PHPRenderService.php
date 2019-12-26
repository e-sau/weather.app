<?php


namespace app\resources;


class PHPRenderService
{
    public function render($template, $model)
    {
        ob_start();
        include_once $_SERVER['DOCUMENT_ROOT'] . '/../view/' . $template . '.php';
        return ob_get_clean();
    }
}