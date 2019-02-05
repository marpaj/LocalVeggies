<?php

namespace App\Controller;

use App\Entity\Producer;
use App\Entity\User;
use App\Form\ProducerType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProducerController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/producer/orders", name="list_producer_orders")
     * @IsGranted("ROLE_PRODUCER")
     */
    public function listOrders()
    {
        return $this->render('home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/create/producer", name="create_producer")
     */
    public function createProducer(LoginFormAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, Request $request)
    {
        $form = $this->createForm(ProducerType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $producer = $form->getData();

            $userProducer = new User();
            $userProducer->setEmail($producer->getUser()->getEmail());
            $userProducer->setRoles(['ROLE_PRODUCER']);
            $userProducer->setPassword($this->passwordEncoder->encodePassword($userProducer, $producer->getUser()->getPassword()));
            $producer->setUser($userProducer);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($producer);
            $entityManager->flush();

            $this->addFlash(
                'message', 'Your request to be a producer of Local veggies has been sent.'
            );

            $this->addFlash(
                'message', 'We will contact you as soon as possible.'
            );

            return $guardHandler->authenticateUserAndHandleSuccess(
                $userProducer,          // the User object you just created
                $request,
                $authenticator, // authenticator whose onAuthenticationSuccess you want to use
                'main'          // the name of your firewall in security.yaml
            );
            
            /* return $this->redirectToRoute( 'app_home' ); */
        }

        return $this->render( 'producer/create.html.twig', ['form' => $form->createView()] );
    }
}
