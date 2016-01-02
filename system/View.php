<?php namespace System;

class View
{
    public function render($template, array $args = null)
    {
        if ($args) {
            extract($args);
        }
        
        $template = BASE_PATH . '/resources/views/' . $template . '.php';
        
        if (file_exists($template)) {
            require $template;
        } else {
            throw new \Exception('View file $template was not found!');
        }
    }
}