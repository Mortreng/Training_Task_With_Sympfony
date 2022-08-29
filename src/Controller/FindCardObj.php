<?php

namespace App\Controller;
use App\Service\CardService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FindCardObj extends AbstractController
{

    private CardService $cardService;

    public function __construct(
        CardService $cardService
    ) {
        $this->cardService = $cardService;
    }

    #[Route('/card/find_card/{id}', name:'find_card', methods:['GET'])]
    public function __invoke(int $id): Response {
        $card = $this->cardService->findCardObj($id);
        if ($card != null) {
            $card = $this->json($card)->getContent();
            return new Response("$card");
        } else {
            return new Response("<html lang=eng><body> No entry found by id: $id</body></html>");
        }
    }

}