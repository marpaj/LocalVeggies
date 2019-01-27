<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="list_product")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();

        return $this->render('product/list.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/product/create", name="create_product")
     */
    public function create(Request $request)
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $product = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('list_product');
        }

        return $this->render( 'product/create.html.twig', ['form' => $form->createView()] );
    }

    /**
     * @Route(
     *      "/product/edit/{product}", 
     *      name="edit_product"
     * )
     */
    public function edit_product(Request $request, Product $product)
    {   
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('list_product');
        }
        
        return $this->render('product/edit.html.twig', ['form' => $form->createView()] );
    }
}
