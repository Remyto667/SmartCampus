<?php

namespace App\Form;

use App\Entity\Sensor;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SensorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('type', ChoiceType::class,[
                'label'=> 'Type',
                'choices' =>[
                    'Humidite' => 'humidité',
                    'Temperature' => 'Temperature',
                    'CO2'=> 'CO2'
                ]
            ])
            ->add('state',ChoiceType::class, [
                'label' => 'Etat',
                'choices' => [
                    'Fonctionnel' =>'fonctionnel',
                    'Non-fonctionnel'=>'non-fonctionnel'
                ]
            ])
            ->add('systems', EntityType::class, array(
                'class' => 'App\Entity\System',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'name'
            ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sensor::class,
        ]);
    }
}

//            ->add('Room', EntityType::class, array(
//                'class' => 'App\Entity\Room',
//                'query_builder' => function (EntityRepository $er) {
//                    return $er->createQueryBuilder('c');
//                },
//                'choice_label' => 'name'
//            ));
