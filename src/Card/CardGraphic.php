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

    public function getValue(): string
    {
        ob_start(); ?>
        <div class="card">
            <p>
                <?php echo ($this->value) ?>
            </p>
            <p>{$this->color}</p>
        </div>"
        <?php
        return ob_get_clean();
    }
}
