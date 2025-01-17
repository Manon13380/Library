<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('genre', null, [
                'label' => 'Genre'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
