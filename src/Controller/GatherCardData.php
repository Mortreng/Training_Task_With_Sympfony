<?php

namespace App\Controller;

use App\Service\CardService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GatherCardData extends AbstractController
{

    private CardService $cardService;

    public function __construct(
        CardService $cardService
    ) {
        $this->cardService = $cardService;
    }

    #[Route('/card/gather_card_data/{pan}', name: 'gather_card_data', methods: ['POST'])]
    public function __invoke(string $pan): Response {
        $cardId = $this->cardService->gatherCardData($pan);
        return new Response($cardId);
    }

}