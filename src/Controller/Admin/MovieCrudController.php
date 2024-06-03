<?php

namespace App\Controller\Admin;

use App\Entity\Movie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MovieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Movie::class;
    }

    public function configureFields(string $pageName): iterable
    {

        $mappingParams = $this->getParameter('vich_uploader.mappings');
        $moviesImagePath = $mappingParams['movies']['uri_prefix'] = '/images/movies';

        yield TextField::new('name', 'Titre');
        yield TextEditorField::new('synopsis', 'Synopsis');
        yield AssociationField::new('genres', 'Genre');
        yield AssociationField::new('directors', 'Réalisateur');
        yield TextareaField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex();
        yield ImageField::new('imageName', 'Affiche')->setBasePath($moviesImagePath)->hideOnForm();
        yield DateField::new('release_date', 'Date de sortie');
        yield TimeField::new('duration', 'Durée');
    }
}
