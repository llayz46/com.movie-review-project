<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\RadioType;

class ReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield ChoiceField::new('rate', 'Note')
            ->setChoices(fn() => [
                '1 étoile' => 1,
                '2 étoiles' => 2,
                '3 étoiles' => 3,
                '4 étoiles' => 4,
                '5 étoiles' => 5,
            ]);
        yield TextareaField::new('review', 'Avis');
        yield BooleanField::new('approved', 'Publié');
        yield AssociationField::new('movie', 'Film');
        yield AssociationField::new('user', 'Utilisateur');
    }
}
