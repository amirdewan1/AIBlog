<?php

namespace App\Form;

use App\Entity\Blog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class BlogFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-input text-5xl h-16 w-full border-b focus:outline-none bg-transparent',
                    'placeholder' => 'Enter title here'
                ],
                'label' => 'Title'
            ])

            ->add('publisher', TextType::class, [
                'attr' => [
                    'class' => 'form-input text-xl h-10 w-3/4 border-b-2 border-gray-300 focus:outline-none bg-transparent',
                    'placeholder' => 'Enter publisher here'
                ],
                'label' => 'Publisher',
                'label_attr' => [
                    'class' => 'block text-gray-700 text-sm font-bold mb-2',
                ]
            ])
            
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-textarea w-full h-32 border rounded-md focus:outline-none',
                    'placeholder' => 'Enter a brief description'
                ],
                'label' => 'Description'
            ])
            ->add('imagePath', FileType::class, [
                'required' => false,
                'mapped' => false,
            ])

            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4 px-4 py-2 rounded-md'
                ],
                'label' => ' Save '
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}
