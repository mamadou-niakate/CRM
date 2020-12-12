<?php

namespace App\Controller;

use App\Entity\Opportunity;
use App\Form\OpportunityFormType;
use App\Repository\OpportunityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
     * @param Request $request
     * @param DataTableFactory $dataTableFactory
     * @return Response
     */
    public function index(Request $request, DataTableFactory $dataTableFactory): Response
    {
        $table = $dataTableFactory->create()
            ->add('amount', TextColumn::class, ['label' => 'Montant', 'className' => 'bold', 'searchable' => true])
            //->add('date_due', TextColumn::class)
            ->add('assigned_to', TextColumn::class, ['field' => 'assigned_to.first_name', 'label' => 'Assigné À', 'className' => 'bold', 'searchable' => true])
            ->add('account', TextColumn::class, ['field' => 'account.account_name', 'label' => 'Relatif compte', 'className' => 'bold', 'searchable' => true])
            ->add('lead', TextColumn::class, ['field' => 'lead.first_name','label' => 'Prospect', 'className' => 'bold', 'searchable' => true])
            ->add('name', TextColumn::class, ['label' => 'Nom', 'className' => 'bold', 'searchable' => true])
            ->add('status', TextColumn::class, ['field' => 'status.status', 'label' => 'Status', 'className' => 'bold', 'searchable' => true])
            ->add('probability', TextColumn::class, ['label' => 'Probabilité', 'className' => 'bold', 'searchable' => true])
            ->add('id', TextColumn::class, ['render' => function($value, $context) {
                return sprintf('<a href="/opportunity_details/%u"><i class="far fa-eye"style="padding-left: 10px"></i></a>',$value) . ' ' .
                    sprintf('<a href="/edit_opportunity/%u"><i class="far fa-edit" style="padding-left: 10px"></i></a>', $value). ' ' .
                    sprintf('<a href="/remove_opportunity/%u" className="pl-5"><i class="fa fa-trash" style="padding-left: 10px; color: red"></i></a>', $value);
            },'label' => 'Actions'])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Opportunity::class
            ])
            ->handleRequest($request);

        if($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('opportunity/index.html.twig', [
            'opportunities' => $this->opportunityRepository->findAll(),
            'datatable' => $table
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
