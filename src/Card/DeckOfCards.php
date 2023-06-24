<?php

namespace App\Card;

use App\Card\Card;
use phpDocumentor\Reflection\Types\Void_;

class DeckOfCards
{
    private $colors = array("♠", "♥", "♦", "♣");
    private $values = array("A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K");
    private $deck = [];

    public function __construct()
    {
        $this->generateDeck();
    }

    public function generateDeck(): void
    {
        foreach ($this->colors as $color) {
            foreach ($this->values as $value) {
                $this->add(new Card($value, $color));
            }
        }
    }

    public function add(Card $card): void
    {
        $this->deck[] = $card;
    }

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    public function draw(): Card
    {
        return array_shift($this->deck);
    }

    public function getNumberCards(): int
    {
        return count($this->deck);
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
