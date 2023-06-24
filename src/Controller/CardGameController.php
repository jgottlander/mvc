<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    private $colors = array("♠", "♥", "♦", "♣");
    private $values = array("A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K");

    #[Route('/card', name: "card_home")]
    public function home(): Response
    {
        return $this->render('cards/home.html.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function cardDeck(
        SessionInterface $session
    ): Response {
        $deck = [];

        if ($session->has("deck")) {
            $deck = $session->get("deck");
        } else {
            $deck = $this->generateDeck();
            $session->set("deck", $deck);
        }

        $data = [
            "num_cards" => $deck->getNumberCards(),
            "deck" => $deck->getString()
        ];

        return $this->render("cards/deck.html.twig", $data);
    }

    private function generateDeck()
    {
        $deck = new DeckOfCards();

        foreach ($this->colors as $color) {
            foreach ($this->values as $value) {
                $deck->add(new Card($value, $color));
            }
        }

        return $deck;
    }

    #[Route("/card/deck/shuffle", name: "card_deck_shuffle")]
    public function deckShuffle(
        SessionInterface $session
    ): Response {
        $deck = $this->generateDeck();

        $deck->shuffle();
        $session->set("deck", $deck);

        return $this->redirectToRoute('card_deck');
    }

    #[Route("/card/deck/draw", name: "card_deck_draw")]
    public function deckDraw(
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck");

        $hand = new CardHand();

        foreach ($deck->draw() as $card) {
            $hand->add($card);
        }

        $session->set("deck", $deck);

        $data = [
            "num_cards" => $deck->getNumberCards(),
            "deck" => $deck->getString(),
            "hand" => $hand->getString()
        ];

        return $this->render("cards/draw.html.twig", $data);
    }

    #[Route("/card/erase", name: "card_erase")]
    public function cardErase(
        SessionInterface $session
    ): Response {
        $session->remove("deck");
        $session->remove("card_deck");
        $session->remove("hand");

        return $this->redirectToRoute('card_home');
    }

    #[Route('/card/test/card_deck', name: "test_card_deck")]
    public function testCardDeck(): Response
    {
        $deck = new DeckOfCards;

        $data = [
            "num_cards" => $deck->getNumberCards(),
            "deck" => $deck->getString()
        ];

        return $this->render("cards/test/carddeck.html.twig", $data);
    }

    #[Route("/card/test/card_hand", name: "test_card_hand")]
    public function testCardHand(): Response
    {
        $hand = new CardHand();

        for ($i = 0; $i < 5; $i++) {
            if ($i % 2 === 1) {
                $hand->add(new CardGraphic(array_rand($this->values), array_rand($this->colors)));
            } else {
                $hand->add(new Card(array_rand($this->values), array_rand($this->colors)));
            }
        }

        $data = [
            "num_cards" => $hand->getNumberCards(),
            "hand" => $hand->getValues()
        ];

        return $this->render("cards/test/cardhand.html.twig", $data);
    }
}
