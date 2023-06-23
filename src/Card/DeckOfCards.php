<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{
    private $deck = [];

    public function add(Card $card): void
    {
        $this->deck[] = $card;
    }

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    public function draw($amount = 1): array
    {
        $cards = [];

        for ($i = 0; $i < $amount; $i++) {
            $cards[] = array_shift($this->deck);
        }
        return $cards;
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
