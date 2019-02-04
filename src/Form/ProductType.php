<?php

namespace App\Form;

use App\Entity\Product;
use App\Service\DistributionService;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    private $distributionService;

    public function __construct(DistributionService $distributionService)
    {
        $this->distributionService = $distributionService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('category', TextType::class)
            ->add('description', TextType::class)
            ->add('price')
            ->add('distributionDate', ChoiceType::class, [
                'choices'  => $this->distributionService->getNextsDistributions()
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}