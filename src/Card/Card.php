<?php

namespace App\Card;

class Card
{
    protected $color;
    protected $value;
    protected $unicode;

    public function __construct($color, $value)
    {
        $this->color = $color;
        $this->value = $value;
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
