<?php

namespace App\Form;

use App\Entity\MyInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MyInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['label' => 'Prénom'])
            ->add('lastName', TextType::class, ['label' => 'Nom'])
            ->add('address', TextType::class, ['label' => 'Adresse'])
            ->add('postalCode', TextType::class, ['label' => 'Code Postal'])
            ->add('town', TextType::class, ['label' => 'Ville'])
            ->add('email', TextType::class, ['label' => 'Email'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MyInfo::class,
        ]);
    }
}
