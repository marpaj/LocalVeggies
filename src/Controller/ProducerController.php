<?php

namespace App\Controller;

use App\Entity\Producer;
use App\Entity\User;
use App\Form\ProducerType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
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
    public function createProducer(Request $request)
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

            return $this->render( 'producer/createResponse.html.twig' );
        }

        return $this->render( 'producer/create.html.twig', ['form' => $form->createView()] );
    }
}
