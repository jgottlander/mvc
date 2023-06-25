<?php

namespace App\Controller;

use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route("/api", name: "api_home")]
    public function apiHome(): Response
    {
        return $this->render("api.html.twig");
    }

    #[Route("/api/quote", name: "api_quote")]
    public function quote(): Response
    {
        $quotes = array(
            "The surest way to become Tense, Awkward, and Confused is to develop a mind that tries too hard"
            . " - one that thinks too much.",
            "Do you really want to be happy? You can begin by being appreciative of who you are and what you've got.",
            "When you know and respect your Inner Nature, you know where you belong."
            . " You also know where you don't belong.",
            "When you discard arrogance, complexity, and a few other things that get in the way,"
            . " sooner or later you will discover that simple, childlike,"
            . " and mysterious secret known to those of the Uncarved Block: Life is Fun.",
            "We simply need to believe in the power that's within us, and use it."
        );

        $response = [
            "quote" => $quotes[array_rand($quotes)],
            "date" => date("Y-m-d"),
            "time" => date("H:i:s")
        ];
        $response = new JsonResponse($response);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck", name: "api_deck", methods: ["GET"])]
    public function apiDeck(
        SessionInterface $session
    ): Response {
        $deck = [];
        $response = [];

        if ($session->has("deck")) {
            $deck = $session->get("deck");
        } else {
            $deck = new DeckOfCards();
            $session->set("deck", $deck);
        }

        foreach ($deck->getString() as $card) {
            $response[] = $card;
        }

        $response = new JsonResponse($response);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_deck_shuffle", methods: ["POST"])]
    public function apiDeckShuffle(
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck");

        $deck->shuffle();

        $session->set("deck", $deck);

        return $this->redirectToRoute('api_deck');
    }

    #[Route("/api/deck/draw", name: "api_deck_draw", methods: ["POST"])]
    public function apiDeckDrawNum(
        Request $request,
        SessionInterface $session
    ): Response {
        if ($request->request->has("num_cards")) {
            $num_cards = $request->request->get("num_cards");
        } else {
            $num_cards = 1;
        }

        $deck = $session->get("deck");
        $deck_size = $deck->getNumberCards();

        if ($num_cards > $deck_size) {
            throw new \Exception("Cannot draw more than {$num_cards} cards");
        }

        $hand = new CardHand();

        for ($i = 0; $i < $num_cards; $i++) {
            $hand->add($deck->draw());
        }

        $session->set("deck", $deck);

        $response = [
            "hand" => $hand->getString(),            
            "deck_size" => $deck->getNumberCards(),
            "deck" => $deck->getString()
        ];

        $response = new JsonResponse($response);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
