<?php

namespace App\Form;

use App\Entity\CourseCv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseCvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_start', IntegerType::class, ['label' => 'Date de début'] )
            ->add('date_end', IntegerType::class, ['label' => 'Date de fin'])
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('content', TextareaType::class, ['label' => 'Contenu'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseCv::class,
        ]);
    }
}
