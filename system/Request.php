<?php namespace System;

class Request
{
    protected $attributes = [];
    
    public function __construct(array $server = [])
    {
        $this->attributes = $server;
    }
    
    public function getAttribute($key)
    {
        return isset($this->attributes[$key]) ?
            htmlspecialchars($this->attributes[$key], ENT_QUOTES, 'UTF-8')
            : null;
    }
}
