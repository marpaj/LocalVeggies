<?php

namespace App\Controller;

use App\Document\Product;
use App\Form\ProductType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;


class ProducerController extends AbstractController
{
    public function show_products(Request $request, DocumentManager $dm)
    {
        $repository = $dm->getRepository(Product::class);
        $products = $repository->findAll();

        return $this->render('producer/showProducts.html.twig', ['products' => $products]);
    }

    public function add_product(Request $request, DocumentManager $dm)
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $dm->persist($product);
            $dm->flush();

            return $this->redirectToRoute('producer_show_products');
        }

        return $this->render( 'producer/addProduct.html.twig', ['form' => $form->createView()] );
    }

     /**
     * @Route(
     *      "/{_locale}/producer/product/edit/{product}", 
     *      name="producer_edit_product",
     *      requirements = { "_locale": "en|fr|lu"}
     * )
     */
    public function edit_product(Request $request, DocumentManager $dm, Product $id)
    {   
        $product = $dm->getRepository(Product::class)->find($id);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dm->flush();

            return $this->redirectToRoute('producer_show_products');
        }
        
        return $this->render('producer/editProduct.html.twig', ['form' => $form->createView()] );
    }
}