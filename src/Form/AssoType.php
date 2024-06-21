<?php

namespace App\Form;

use App\Entity\Asso;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class AssoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('img_asso', FileType::class, [
                'label' => 'Photo de l’article',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                new File([
                'maxSize' => '5000k',
                'mimeTypes' => [
                'image/*',
                ],
                'mimeTypesMessage' => 'Image trop lourde',
                ])
                ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Asso::class,
        ]);
    }
}
