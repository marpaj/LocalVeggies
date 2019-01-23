<?php

namespace App\Controller;

use App\Document\Product;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;


class ProducerController extends AbstractController
{
    public function add_product(Request $request, DocumentManager $dm)
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, array(
                'constraints' => new NotBlank(),
            ))
            ->add('price', TextType::class, array(
                'constraints' => new NotBlank(),
            ))
            ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $product = new Product();
            $product->setName($data['name']);
            $product->setPrice($data['price']);

            $dm->persist($product);
            $dm->flush();

            return $this->redirectToRoute('producer_show_products');
        }

        return $this->render('producer/addProduct.html.twig', array('form' => $form->createView(), ));
    }

    public function show_products(DocumentManager $dm)
    {
        $repository = $dm->getRepository(Product::class);
        $products = $repository->findAll();

        return $this->render('producer/showProducts.html.twig', ['products' => $products]);
    }

    public function show_new_product(DocumentManager $dm)
    {   
        $repository = $dm->getRepository(Product::class);
        $product = $repository->findById('5c42fb16d40d882d70005a81');

        if (!$product) {
            throw $this->createNotFoundException('No product found for id 5c42fb16d40d882d70005a81');
        }

        return $this->render('producer/showProducts.html.twig', ['name' => $product['name'], 'price' => $product->getPrice()]);
    }

    public function create_product(DocumentManager $dm)
    {
        $product = new Product();
        $product->setName('A Foo Bar');
        $product->setPrice('19.99');

        $dm->persist($product);
        $dm->flush();

        return new Response('Created product id '.$product->getId());
    }
}