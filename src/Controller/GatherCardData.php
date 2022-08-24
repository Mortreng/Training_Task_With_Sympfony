<?php

namespace App\Controller;

use App\Entity\Card;
use App\Service\CardService;
use ErrorException;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/card', name: 'gather_card_data')]
    public function GatherCardData(Request $request): Response {

        $card = [];
        $cardForm = $this -> createFormBuilder($card)
            ->add('pan', TextType::class)
            ->add('submit', SubmitType::class, ['label' => 'Verify'])
            ->getForm();

        $cardForm -> handleRequest($request);

        if ($cardForm->isSubmitted() && $cardForm->isValid()) {
            try {
                $card = $cardForm -> getData();
                $result = $this->cardService->GatherCardData($card['pan']);
            } catch (ErrorException $e) {
                return $this->redirectToRoute('verification_failure',['e' => $e->getMessage()]);
            }
            return $this->redirectToRoute('verification_success',['s' => $result]);
        }

        return $this->renderForm('Card/new.html.twig', [
            'form' => $cardForm
        ]);

    }

    #[Route('/card/verification_failure/{e}', name:'verification_failure',methods:['GET'])]
    public function VerificationFailure(string $e): Response {
        return new Response("<html lang=en><body> verification failed, reason: $e</body></html>");
    }

    #[Route('/card/verification_success/{s}', name:'verification_success',methods:['GET'])]
    public function VerificationSuccess(string $s): Response {
        return new Response("<html lang=en><body> verification passed, $s. </body></html>");
    }
}