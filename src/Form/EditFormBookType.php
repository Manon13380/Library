<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\CallbackTransformer;

class EditFormBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre'
            ])
            ->add('author', null, [
                'label' => 'Auteur'
            ])
            ->add('publication', null, [
                'label' => 'Date de publication'
            ])
            ->add('description', null, [
                'label' => 'Description'
            ])
            ->add('genre', TextType::class, [
                'label' => 'Genre',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Genres (séparés par des virgules)'
                ]
            ])
        ;

        $builder->get('genre')
            ->addModelTransformer(new CallbackTransformer(
                function ($genreAsArray) {
                    // transform the array to a string
                    return $genreAsArray ? implode(', ', $genreAsArray) : '';
                },
                function ($genreAsString) {
                    // transform the string back to an array
                    if (!$genreAsString) {
                        return [];
                    }
                    $genres = array_map('trim', explode(',', $genreAsString));
                    return array_filter($genres, function($genre) {
                        return !empty($genre);
                    });
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
