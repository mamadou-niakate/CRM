<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserStatus;
use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/registration", name="registration")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

            /*$user_status = new UserStatus();
            $user_status->setStatus('Active');

            $em = $this->getDoctrine()->getManager();
            $em->persist($user_status);
            $em->flush();

            $user->setStatus($user_status);*/

            $user->setRoles(['ROLE_USER']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }


        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
