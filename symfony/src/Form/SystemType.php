<?php

namespace App\Form;

use App\Entity\System;
use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Orm\ManagerRegistryAwareEntityManagerProvider;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SystemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('Room', EntityType::class, array(
                'class' => 'App\Entity\Room',
                'query_builder' => function (EntityRepository $er) {
                 return $er->createQueryBuilder('c');
                },
                'choice_label' => 'name'
            ))
            ->add('Tag');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => System::class,
        ]);
    }
}
