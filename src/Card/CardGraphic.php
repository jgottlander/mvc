<?php

namespace App\Card;

class CardGraphic extends Card
{
    protected $value;
    protected $color;

    public function __construct($value, $color)
    {
        parent::__construct($value, $color);
    }
    public function getAsString(): string
    {
        return "<div class=\"card\"><span class=\"card-value\">{$this->value}</span>"
            . "<span class=\"card-color\">{$this->color}</span></div>";
    }
}
