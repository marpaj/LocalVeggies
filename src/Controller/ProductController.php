<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="list_products")
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
     * @Route("/producer/product/create", name="create_product")
     * @IsGranted("ROLE_PRODUCER")
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
     * @Route("/producer/product/edit/{product}", name="edit_product")
     * @IsGranted("ROLE_PRODUCER")
     */
    public function edit(Request $request, product $product)
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

    /**
     * @Route("/producer/product/delete/{product}", name="delete_product")
     * @IsGranted("ROLE_PRODUCER")
     */
    public function delete(Request $request, Product $product)
    {
        if($product === null) {
            return $this->redirectToRoute('list_product');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
        
        return $this->redirectToRoute('list_product');
    }
}
