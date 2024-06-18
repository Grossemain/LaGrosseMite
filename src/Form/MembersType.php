<?php

namespace App\Form;

use App\Entity\Members;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Teams;

class MembersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('name_member')
            ->add('img_member')
            ->add('TEAMS', 
            EntityType::class, 
            [ 'class' => Teams::class, 'choice_label' => 'name', ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Members::class,
        ]);
    }
}
