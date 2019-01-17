<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;


class ProducerController extends AbstractController
{
    public function add_product(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, array(
                'constraints' => new NotBlank(),
            ))
            ->add('description', TextType::class, array(
                'constraints' => new NotBlank(),
            ))
            ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            return $this->redirectToRoute('producer_show_products', array('name'=>$data['name'], 'description'=>$data['description']));
        }

        return $this->render('producer/addProduct.html.twig', array('form' => $form->createView(), ));
    }

    public function show_products($name, $description)
    {
        return $this->render('producer/showProducts.html.twig', ['name' => $name, 'description' => $description]);
    }
}