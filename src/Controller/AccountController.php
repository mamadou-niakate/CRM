<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AccountFormType;
use App\Repository\AccountRepository;
use App\Repository\ContactRepository;
use App\Repository\InteractionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
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
     * @param Request $request
     * @param DataTableFactory $dataTableFactory
     * @return Response
     */
    public function index(Request $request, DataTableFactory $dataTableFactory): Response
    {
        $table = $dataTableFactory->create()
            ->add('account_name', TextColumn::class, ['label' => 'Nom Compte', 'className' => 'bold', 'searchable' => true])
            ->add('billing_city', TextColumn::class, ['label' => 'Ville de Facturation', 'className' => 'bold', 'searchable' => true])
            ->add('website', TextColumn::class, ['label' => 'Site Web', 'className' => 'bold', 'searchable' => true])
            ->add('office_phone', TextColumn::class, ['label' => 'Téléphone', 'className' => 'bold', 'searchable' => true])
            ->add('assigned_to', TextColumn::class, ['field' => 'assigned_to.first_name', 'label' => 'Assigné À', 'className' => 'bold', 'searchable' => true])
            ->add('id', TextColumn::class, ['render' => function($value, $context) {
                return sprintf('<a href="/details_account/%u"><i class="far fa-eye"style="padding-left: 20px"></i></a>',$value) . ' ' .
                    sprintf('<a href="/edit_account/%u"><i class="far fa-edit" style="padding-left: 20px"></i></a>', $value). ' ' .
                    sprintf('<a href="/remove_account/%u" className="pl-5"><i class="fa fa-trash" style="padding-left: 20px; color: red"></i></a>', $value);
            }, 'label' => 'Actions'])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Account::class
            ]);

        $table->handleRequest($request);

        if($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('account/index.html.twig', [
            'accounts' => $this->accountRepository->findAll(),
            'datatable' => $table
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
