<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpCache\ResponseCacheStrategy;
use Symfony\Component\Routing\Annotation\Route;

class MyController extends AbstractController
{
    #[Route('/', name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route('/about', name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route('/report', name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route('/lucky', name: "big_toe")]
    public function number(): Response
    {
        $number = random_int(0, 10);

        $data = [
            'number' => $number
        ];

        return $this->render('lucky_number.html.twig', $data);
    }

    #[Route('/api/quote', name: "quote")]
    public function quote(): Response
    {
        $quotes = array(
            "The surest way to become Tense, Awkward, and Confused is to develop a mind that tries too hard " .
            "- one that thinks too much.",
            "Do you really want to be happy? You can begin by being appreciative of who you are and what you've got.",
            "When you know and respect your Inner Nature, you know where you belong. " .
            "You also know where you don't belong.",
            "When you discard arrogance, complexity, and a few other things that get in the way, " .
            "sooner or later you will discover that simple, childlike, " .
            "and mysterious secret known to those of the Uncarved Block: Life is Fun.",
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
}
