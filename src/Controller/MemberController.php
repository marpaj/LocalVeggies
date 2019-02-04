<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\User;
use App\Form\MemberType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MemberController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/member/orders", name="list_member_orders")
     */
    public function index()
    {
        return $this->render('home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/create/member", name="create_member")
     */
    public function createMember(Request $request)
    {
        $form = $this->createForm(MemberType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $member = $form->getData();

            $userMember = new User();
            $userMember->setEmail($member->getUser()->getEmail());
            $userMember->setRoles(['ROLE_MEMBER']);
            $userMember->setPassword($this->passwordEncoder->encodePassword($userMember, $member->getUser()->getPassword()));
            $member->setUser($userMember);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($member);
            $entityManager->flush();

            $this->addFlash(
                'message',
                'You can make an order now for the next distribution!'
            );
            
            return $this->redirectToRoute( 'app_home' );
        }

        return $this->render( 'member/create.html.twig', ['form' => $form->createView()] );
    }
}
