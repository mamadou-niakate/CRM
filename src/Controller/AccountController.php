<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AccountFormType;
use App\Repository\AccountRepository;
use App\Repository\ContactRepository;
use App\Repository\InteractionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    private $accountRepository;
    private $entityManager;
    private $contactRepository;
    private $interactionRepository;

    public function __construct(AccountRepository $accountRepository, InteractionRepository $interactionRepository,
                                EntityManagerInterface $entityManager,ContactRepository $contactRepository)
    {
        $this->interactionRepository = $interactionRepository;
        $this->accountRepository = $accountRepository;
        $this->contactRepository = $contactRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/account", name="account")
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'accounts' => $this->accountRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add_account",name="add_account")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request)
    {
        $account = new Account();

        $form = $this->createForm(AccountFormType::class, $account);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($account);
            $this->entityManager->flush();
            return $this->redirectToRoute('account');
        }

        return $this->render('account/add.html.twig', [
           'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit_account/{id}", name="edit_account")
     * @param Account $account
     * @param Request $request
     * @return Response
     */
    public function edit(Account $account, Request $request)
    {

        $form = $this->createForm(AccountFormType::class, $account);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $account = $form->getData();
            $this->entityManager->persist($account);
            $this->entityManager->flush();

            return $this->redirectToRoute('account');
        }

        return $this->render('account/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/remove_account/{id}", name="remove_account")
     * @param Account $account
     * @return Response
     */
    public function remove(Account $account)
    {
        $this->entityManager->remove($account);
        $this->entityManager->flush();

        return $this->redirectToRoute('account');
    }

    /**
     * @Route("/details_account/{id}", name="account_details")
     * @param Account $account
     * @return Response
     */
    public function details(Account $account)
    {
        return $this->render('account/details.html.twig', [
            'account' => $this->accountRepository->find($account),
            'contacts' => $this->contactRepository->findBy(['account' => $account]),
        ]);
    }
}
