<?php

namespace App\Controller;

use App\Entity\Lead;
use App\Form\LeadFormType;
use App\Repository\LeadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LeadController extends AbstractController
{
    private $entityManager;
    private $leadRepository;

    public function __construct(EntityManagerInterface $entityManager, LeadRepository $leadRepository)
    {
        $this->entityManager = $entityManager;
        $this->leadRepository = $leadRepository;
    }

    /**
     * @Route("/lead", name="lead")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('lead/index.html.twig', [
            'leads' => $this->leadRepository->findAll()
        ]);
    }

    /**
     * @Route("/add_lead", name="add_lead")
     * @param Request $request
     * @return Response
     */
    public function addLead(Request $request): Response
    {
        $lead = new Lead();

        $form = $this->createForm(LeadFormType::class, $lead);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($lead);
            $this->entityManager->flush();

            return $this->redirectToRoute('lead');
        }

        return $this->render('lead/addLead.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/remove/{id}", name="remove_lead")
     * @param Lead $lead
     * @return Response
     */
    public function remove(Lead $lead)
    {
        $this->entityManager->remove($lead);
        $this->entityManager->flush();

        return $this->redirectToRoute('lead');
    }

    /**
     * @Route("/edit_lead/{id}", name="edit_lead")
     * @param Lead $lead
     * @param Request $request
     * @return Response
     */
    public function edit(Lead $lead, Request $request)
    {
        $form = $this->createForm(LeadFormType::class, $lead);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lead = $form->getData();
            $this->entityManager->persist($lead);
            $this->entityManager->flush();

            return $this->redirectToRoute('lead');
        }

        return $this->render('lead/addLead.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/details_lead/{id}", name="lead_details")
     * @param Lead $lead
     * @return Response
     */
    public function leadDetails(Lead $lead)
    {
        return $this->render('lead/leadDetails.html.twig', [
            'lead' => $this->leadRepository->find($lead),
        ]);
    }
}
