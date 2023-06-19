<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route('/card', name: "cards_start")]
    public function home(): Response
    {
        return $this->render('cards/home.html.twig');
    }

    #[Route('/card/test/card_hand', name: "test_card_hand")]
    public function testCardHand(): Response
    {
        $deck = new DeckOfCards;
        $deck->generate();

        $data = [
            "deck" => $deck->getString()
        ];

        return $this->render("cards/test/cardhand.html.twig", $data);
    }
}
