<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{
    protected $colors = array("♠", "♥︎", "♦︎", "♣︎");
    protected $values = array("A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K");
    private $deck = [];

    public function generate(): void
    {
        foreach ($this->colors as $color) {
            foreach ($this->values as $value) {
                $this->deck[] = new Card($color, $value);
            }
        }
    }

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    public function deal($amount = 1)
    {
        $cards = [];

        foreach (range(1, $amount) as $i) {
            $cards[] = array_shift($this->deck);
        }
        return $cards;
    }

    public function getString(): array
    {
        $deck = [];
        foreach ($this->deck as $card) {
            $deck[] = $card->getAsString();
        }
        return $deck;
    }
}
