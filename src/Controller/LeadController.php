<?php

namespace App\Controller;

use App\Entity\Lead;
use App\Entity\User;
use App\Form\LeadFormType;
use App\Repository\LeadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\BoolColumn;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTableFactory;
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
     * @param Request $request
     * @param DataTableFactory $dataTableFactory
     * @return Response
     */
    public function index(Request $request, DataTableFactory $dataTableFactory): Response
    {
        $table = $dataTableFactory->create()
            ->add('first_name', TextColumn::class,['label' => 'Prénom', 'className' => 'bold',
                                                              'searchable' => true, 'globalSearchable' => true,])
            ->add('last_name', TextColumn::class,['label' => 'Nom', 'className' => 'bold',
                                                             'searchable' => true, "globalSearchable" => true])
            ->add('website', TextColumn::class,['label' => 'Site Web', 'className' => 'bold',
                                                            'searchable' => true, "globalSearchable" => true])
            ->add('phone', TextColumn::class,['label' => 'Téléphone', 'className' => 'bold',
                                                         'searchable' => true, "globalSearchable" => true])
            ->add('email', TextColumn::class,['label' => 'Email', 'className' => 'bold',
                                                         'searchable' => true, "globalSearchable" => true])
            ->add('industry', TextColumn::class,['label' => 'Industrie', 'className' => 'bold',
                                                            'searchable' => true, "globalSearchable" => true])
            ->add('street', TextColumn::class,['label' => 'Rue', 'className' => 'bold',
                                                            'searchable' => true,"globalSearchable" => true])
            ->add('zipcode', TextColumn::class,['label' => 'Code Postale', 'className' => 'bold',
                                                            'searchable' => true, "globalSearchable" => true])
            ->add('city', TextColumn::class,['label' => 'Ville', 'className' => 'bold',
                                                        'searchable' => true, "globalSearchable" => true])
            ->add('assigned_to', TextColumn::class, ['field' => 'assigned_to.first_name',
                                                                'label' => 'Assigné À', 'className' => 'bold',
                                                                'searchable' => true, "globalSearchable" => true])
            ->add('status', TextColumn::class,  ['field' => 'status.status', 'label' => 'Status',
                                                            'className' => 'bold', 'searchable' => true, "globalSearchable" => true])
            ->add('id', TextColumn::class, ['render' => function($value, $context) {
                return sprintf('<a href="/details_lead/%u"><i class="far fa-eye"style="padding-left: 1px"></i></a>',$value) . ' ' .
                        sprintf('<a href="/edit_lead/%u"><i class="far fa-edit" style="padding-left: 7px"></i></a>', $value). ' ' .
                        sprintf('<a href="/remove_lead/%u" className="pl-5"><i class="fa fa-trash" style="padding-left: 2px; color: red"></i></a>', $value);
            },'label' => 'Actions'])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Lead::class
            ])
            ->handleRequest($request);

        if($table->isCallback()) {
            return $table->getResponse();
        }


        return $this->render('lead/index.html.twig', [
            'leads' => $this->leadRepository->findAll(),
            'datatable' => $table
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
     * @Route("/remove_lead/{id}", name="remove_lead")
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
