<?php

namespace App\Controller;

use App\Entity\Opportunity;
use App\Form\OpportunityFormType;
use App\Repository\OpportunityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OpportunityController extends AbstractController
{
    private $opportunityRepository;
    private $entityManager;

    public function __construct(OpportunityRepository $opportunityRepository, EntityManagerInterface $entityManager)
    {
        $this->opportunityRepository = $opportunityRepository;
        $this->entityManager = $entityManager;
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

    /**
     * @Route("/add_opportunity", name="add_opportunity")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $opportunity = new Opportunity();

        $form = $this->createForm(OpportunityFormType::class, $opportunity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($opportunity);
            $this->entityManager->flush();
            return $this->redirectToRoute('opportunity');
        }

        return $this->render('opportunity/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit_opportunity/{id}", name="edit_opportunity")
     * @param Opportunity $opportunity
     * @param Request $request
     * @return Response
     */
    public function edit(Opportunity $opportunity,Request $request): Response
    {
        $form = $this->createForm(OpportunityFormType::class, $opportunity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $opportunity = $form->getData();
            $this->entityManager->persist($opportunity);
            $this->entityManager->flush();
            return $this->redirectToRoute('opportunity');
        }

        return $this->render('opportunity/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/opportunity_details/{id}", name="opportunity_details")
     * @param Opportunity $opportunity
     * @return Response
     */
    public function details(Opportunity $opportunity): Response
    {

        return $this->render('opportunity/details.html.twig', [
            'opportunity' => $this->opportunityRepository->find($opportunity)
        ]);
    }

    /**
     * @Route("/remove_opportunity/{id}", name="remove_opportunity")
     * @param Opportunity $opportunity
     * @return Response
     */
    public function remove(Opportunity $opportunity): Response
    {
        $this->entityManager->remove($opportunity);
        $this->entityManager->flush();

        return $this->redirectToRoute('opportunity');
    }
}
