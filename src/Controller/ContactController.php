<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Contact;
use App\Form\AccountFormType;
use App\Form\ContactFormType;
use App\Repository\AccountRepository;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    private $accountRepository;
    private $contactRepository;
    private $entityManager;

    public function __construct(ContactRepository $contactRepository, AccountRepository $accountRepository, EntityManagerInterface $entityManager)
    {
        $this->contactRepository = $contactRepository;
        $this->accountRepository = $accountRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', [
            'contacts' => $this->contactRepository->findAll(),
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
        return $this->render('contact/details.html.twig', [
            'contact' => $this->contactRepository->find($contact)
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
