<?php

namespace App\Card;

class Card
{
    protected $value;
    protected $color;
    
    protected $unicode;

    public function __construct($value, $color)
    {
        $this->value = $value;
        $this->color = $color;
    }

    public function getValue(): string
    {
        return $this->value . $this->color;
    }

    public function getAsString(): string
    {
        return "{$this->value}{$this->color}";
    }
}
