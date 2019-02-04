<?php

namespace App\Form;

use App\Entity\Member;
use App\Form\UserType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', UserType::class)
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('phone', TextType::class)
            ->add('address', TextType::class)
            ->add('cp', IntegerType::class)
            ->add('city', TextType::class)
            ->add('country', TextType::class)
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}