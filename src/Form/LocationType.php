<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Range;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class, [
                'attr' => [
                    'placeholder' => 'Enter city name',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'City name should not be empty',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 100,
                        'minMessage' => 'City name should be at least {{ limit }} characters long',
                    ]),
                ],
            ])

            ->add('country', ChoiceType::class, [
                'choices' => [
                    'Poland' => 'PL',
                    'Germany' => 'DE',
                    'France' => 'FR',
                    'Spain' => 'ES',
                    'Italy' => 'IT',
                    'United Kingdom' => 'GB',
                    'United States' => 'US',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please select a country',
                    ]),
                ],
            ])

            ->add('latitude', NumberType::class, [
                'scale' => 7,
                'html5' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Latitude should not be empty',
                    ]),
                    new Range([
                        'min' => -90,
                        'max' => 90,
                        'notInRangeMessage' => 'Latitude should be between -90 and 90',
                    ]),
                ],
            ])

            ->add('longitude', NumberType::class, [
                'scale' => 7,
                'html5' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Longitude should not be empty',
                    ]),
                    new Range([
                        'min' => -180,
                        'max' => 180,
                        'notInRangeMessage' => 'Longitude should be between -180 and 180',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
