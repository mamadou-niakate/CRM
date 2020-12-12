<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Contact;
use App\Form\AccountFormType;
use App\Form\ContactFormType;
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

class ContactController extends AbstractController
{
    private $interactionRepository;
    private $accountRepository;
    private $contactRepository;
    private $entityManager;

    public function __construct(ContactRepository $contactRepository, AccountRepository $accountRepository,
                                EntityManagerInterface $entityManager, InteractionRepository $interactionRepository)
    {
        $this->interactionRepository = $interactionRepository;
        $this->contactRepository = $contactRepository;
        $this->accountRepository = $accountRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param DataTableFactory $dataTableFactory
     * @return Response
     */
    public function index(Request $request, DataTableFactory $dataTableFactory): Response
    {
        $table = $dataTableFactory->create()
            ->add('first_name', TextColumn::class, ['label' => 'Prénom', 'className' => 'bold', 'searchable' => true])
            ->add('last_name', TextColumn::class, ['label' => 'Nom', 'className' => 'bold', 'searchable' => true])
            ->add('function', TextColumn::class, ['label' => 'Fonction', 'className' => 'bold', 'searchable' => true])
            ->add('phone', TextColumn::class, ['label' => 'Téléphone', 'className' => 'bold', 'searchable' => true])
            ->add('email', TextColumn::class, ['label' => 'Email', 'className' => 'bold', 'searchable' => true])
            ->add('assigned_to', TextColumn::class, ['field' => 'assigned_to.first_name', 'label' => 'Assigné À', 'className' => 'bold', 'searchable' => true])
            ->add('account', TextColumn::class, ['field' => 'account.account_name', 'label' => 'Compte Relatif', 'className' => 'bold', 'searchable' => true])
            ->add('id', TextColumn::class, ['render' => function($value, $context) {
                return sprintf('<a href="/details_contact/%u"><i class="far fa-eye"style="padding-left: 20px"></i></a>',$value) . ' ' .
                    sprintf('<a href="/edit_contact/%u"><i class="far fa-edit" style="padding-left: 20px"></i></a>', $value). ' ' .
                    sprintf('<a href="/remove_contact/%u" className="pl-5"><i class="fa fa-trash" style="padding-left: 20px; color: red"></i></a>', $value);
            },'label' => 'Actions'])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Contact::class
            ]);

        $table->handleRequest($request);

        if($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('contact/index.html.twig', [
            'contacts' => $this->contactRepository->findAll(),
            'datatable' => $table
        ]);
    }

    /**
     * @Route("/add_contact", name="add_contact")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($contact);
            $this->entityManager->flush();
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("edit_contact/{id}", name="edit_contact")
     * @param Contact $contact
     * @param Request $request
     * @return Response
     */
    public function edit(Contact $contact,Request $request)
    {
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $this->entityManager->persist($contact);
            $this->entityManager->flush();
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/remove_contact/{id}", name="remove_contact")
     * @param Contact $contact
     * @return Response
     */
    public function remove(Contact $contact)
    {
        $this->entityManager->remove($contact);
        $this->entityManager->flush();

        return $this->redirectToRoute('contact');
    }

    /**
     * @Route("/details_contact/{id}", name="contact_details")
     * @param Contact $contact
     * @return Response
     */
    public function details(Contact $contact)
    {
        $contact_interactions = $this->interactionRepository->findBy(['contact' => $contact]);
        return $this->render('contact/details.html.twig', [
            'contact' => $this->contactRepository->find($contact),
            'contact_interactions' => $contact_interactions
        ]);
    }


    /**
     * @Route("account_contacts", name="account_contacts")
     * @param Account $account
     * @return Response
     */
    public function getAccountContacts(Account $account)
    {
        return $this->render('account/contacts.html.twig', [
            'contacts' => $this->contactRepository->find($account)
        ]);
    }
}
