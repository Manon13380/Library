<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        
            yield TextField::new('title');
            yield TextField::new('author');
            yield TextField::new('publication');
            yield TextField::new('ISBN');
            yield ImageField::new('image')
            ->setUploadDir('/public/uploads/photos')
            ->setUploadedFileNamePattern(fn(UploadedFile $photo) => Book::setFilename($photo))
            ->setBasePath('/uploads/photos')
            ->setLabel('Photo');
            yield TextareaField::new('description');
            $createdAt = DateTimeField::new('createdAt')
            ->onlyOnIndex()
            ->setTimezone('Europe/Paris')
            ->setFormTypeOptions([
                'html5' => true,
                'years' => range(date('Y'), date('Y') + 5),
                'widget' => 'single_text',
            ]);
        $updatedAt = DateTimeField::new('updatedAt')
            ->onlyOnIndex()
            ->setTimezone('Europe/Paris')
            ->setFormTypeOptions([
                'html5' => true,
                'years' => range(date('Y'), date('Y') + 5),
                'widget' => 'single_text',
            ]);


        if (Crud::PAGE_EDIT === $pageName) {
            yield $createdAt->setFormTypeOption('disabled', true);
            yield $updatedAt;
        } else {
            yield $createdAt;
            yield $updatedAt->setFormTypeOption('disabled', true);
        }
        
    }

}
