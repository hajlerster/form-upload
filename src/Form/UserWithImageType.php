<?php

namespace App\Form;

use App\Entity\UserWithImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\File;


class UserWithImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name', TextType::class, [
                'label' => 'Imię',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Nazwisko nie może być puste.',
                    ]),
                ],
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Nazwisko',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Nazwisko nie może być puste.',
                    ]),
                ],
            ])
            ->add('picture', FileType::class, [
                'label' => 'Zdjęcie',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '10M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Proszę przesłać poprawny format zdjęcia (JPEG lub PNG).',
                    ])
                ],
            ]);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserWithImage::class,
        ]);
    }
}
