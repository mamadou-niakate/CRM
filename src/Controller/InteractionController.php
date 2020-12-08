<?php

namespace App\Controller;

use App\Entity\Interaction;
use App\Form\InteractionFormType;
use App\Repository\InteractionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InteractionController extends AbstractController
{
    private $interactionRepository;
    private $entityManager;

    public function __construct(InteractionRepository $interactionRepository, EntityManagerInterface $entityManager)
    {
        $this->interactionRepository = $interactionRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/interaction", name="interaction")
     */
    public function index(): Response
    {
        return $this->render('interaction/index.html.twig', [
            'interactions' => $this->interactionRepository->findAll()
        ]);
    }

    /**
     * @Route("/add_interaction", name="add_interaction")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $interaction = new Interaction();

        $form = $this->createForm(InteractionFormType::class, $interaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($interaction);
            $this->entityManager->flush();

            return $this->redirectToRoute('interaction');
        }
        return $this->render('interaction/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit_interaction/{id}", name="edit_interaction")
     * @param Interaction $interaction
     * @param Request $request
     * @return Response
     */
    public function edit(Interaction $interaction, Request $request): Response
    {
        $form = $this->createForm(InteractionFormType::class, $interaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $interaction = $form->getData();
            $this->entityManager->persist($interaction);
            $this->entityManager->flush();

            return $this->redirectToRoute('interaction');
        }
        return $this->render('interaction/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/remove_interaction/{id}", name="remove_interaction")
     * @param Interaction $interaction
     * @return Response
     */
    public function remove(Interaction $interaction): Response
    {
        $this->entityManager->remove($interaction);
        $this->entityManager->flush();

        return $this->redirectToRoute('interaction');
    }
}
