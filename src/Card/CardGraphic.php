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

    public function getObject(): string
    {
        return <<< CARD
        <div class=\"card\">
            <p>{$this->value}</p>
            <p>{$this->color}</p>
        </div>
        CARD;
    }
}
