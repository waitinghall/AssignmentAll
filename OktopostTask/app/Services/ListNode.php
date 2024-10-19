<?php
namespace App\Services;

class ListNode
{
    public $key;
    public $value;
    public $prev;
    public $next;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
        $this->prev = null;
        $this->next = null;
    }
}
