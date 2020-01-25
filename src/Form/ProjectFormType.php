<?php


namespace App\Form;


use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProjectFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('content', TextareaType::class, ['label' => 'Contenu'])
            ->add('url', TextType::class, ['label' => 'URL'])
            ->add('image', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => true,
                'constraints' =>[
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg'
                        ],
                        'mimeTypesMessage'=>'Ce format n\'est pas valide'

                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }


}