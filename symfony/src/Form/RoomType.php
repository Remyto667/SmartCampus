<?php

namespace App\Form;

use App\Entity\Room;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('windows_number')
            ->add('room_size')
            ->add('orientation', ChoiceType::class, [
                'label' => 'Orientation',
                'choices' => [
                    'Nord' => 0,
                    'Sud' => 1,
                    'Est' => 2,
                    'Ouest' => 3
                ]
            ])
            ->add('floor')
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Bureau' => 0,
                    'Salle de classe' => 1,
                    'Serveur ' => 2,
                    'Secrétariat' => 3,
                    'Autres' => 4
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
