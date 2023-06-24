<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
    public function apiDeck(): Response
    {
        $deck = new DeckOfCards;

        foreach ($deck->getString() as $card) {
            $response[] = $card;
        }

        $response = new JsonResponse($response);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
