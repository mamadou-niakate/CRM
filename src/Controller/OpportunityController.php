<?php

namespace App\Controller;

use App\Repository\OpportunityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OpportunityController extends AbstractController
{
    private $opportunityRepository;

    public function __construct(OpportunityRepository $opportunityRepository)
    {
        $this->opportunityRepository = $opportunityRepository;
    }

    /**
     * @Route("/opportunity", name="opportunity")
     */
    public function index(): Response
    {
        return $this->render('opportunity/index.html.twig', [
            'opportunities' => $this->opportunityRepository->findAll()
        ]);
    }
}
