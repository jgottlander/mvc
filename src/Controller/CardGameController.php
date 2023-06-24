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
            $deck = new DeckOfCards();
            $session->set("deck", $deck);
        }

        $data = [
            "num_cards" => $deck->getNumberCards(),
            "deck" => $deck->getString()
        ];

        return $this->render("cards/deck.html.twig", $data);
    }

    #[Route("/card/deck/shuffle", name: "card_deck_shuffle")]
    public function deckShuffle(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();

        $deck->shuffle();
        $session->set("deck", $deck);

        return $this->redirectToRoute('card_deck');
    }

    #[Route("/card/deck/draw", name: "card_deck_draw")]
    public function deckDraw(
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck");

        if ($deck->getNumberCards() < 1) {
            throw new \Exception("Not enough cards in the deck");
        }

        $hand = new CardHand();

        $hand->add($deck->draw());

        $session->set("deck", $deck);

        $data = [
            "num_cards" => $deck->getNumberCards(),
            "deck" => $deck->getString(),
            "hand" => $hand->getString()
        ];

        return $this->render("cards/draw.html.twig", $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "card_deck_draw_num")]
    public function deckDrawNum(
        int $num,
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck");
        $num_cards = $deck->getNumberCards();

        if ($num > $num_cards) {
            throw new \Exception("Cannot draw more than {$num_cards} cards");
        }

        $hand = new CardHand();

        for ($i = 0; $i < $num; $i++) {
            $hand->add($deck->draw());
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
        $deck = new DeckOfCards();

        $data = [
            "num_cards" => $deck->getNumberCards(),
            "deck" => $deck->getString()
        ];

        return $this->render("cards/test/carddeck.html.twig", $data);
    }
}
