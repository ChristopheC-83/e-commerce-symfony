<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\SlugType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits')
            // ...
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        // $user = $this->getUser();
        // if ($user !== null) {
        //     $user_id = $user->getId();
        //     $folder = 'uploads/images/'.$user_id;
        // }

        // pageName === new si creation et edit si edition => utilie pour image requise seulemetnà la création d'un produit !
        $required =true;
        if ($pageName === 'edit') {
            $required = false;
        }

        return [
            TextField::new('name')->setLabel('Nom')->setHelp('Nom du Produit'),
            SlugField::new('slug')->setLabel('URL')->setTargetFieldName('name')->setHelp('URL du Produit généré automatiquement'),
            TextEditorField::new('description')->setLabel('Description')->setHelp('Description du Produit'),
            ImageField::new('illustration')
                ->setLabel('Image')
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')
                ->setUploadDir('public/uploads')
                ->setBasePath('uploads')
                ->setBasePath('uploads')
                ->setHelp('Image du Produit en 600x600 px')
                ->setRequired($required)
                ,
            NumberField::new('price')->setLabel('Prix HT')->setHelp('Prix du Produit hors taxe sans le sigle €'),
            ChoiceField::new('tva')->setLabel('TVA')->setChoices([
                '5.5%' => '5.5',
                '10%' => '10',
                '20%' => '20',
            ])->setHelp('Taux de TVA'),
            AssociationField::new('category')->setLabel('Catégorie')->setHelp('Catégorie du Produit'),
        ];
    }
}
