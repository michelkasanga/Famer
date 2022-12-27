<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Article;
use App\Controller\Admin\UserCrudController;
use App\Controller\Admin\CategoryCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Articles')
            ->setEntityLabelInSingular('Article')
            ->setPaginatorPageSize(5)
            ->setPageTitle(Crud::PAGE_DETAIL, fn (Article $header) => sprintf(' <b>%s</b>', $header->getName()))
            ->setPageTitle(Crud::PAGE_EDIT, fn (Article $header) => sprintf(' Edit <b>%s</b>', $header->getName()))
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)

            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-pencil')->setLabel(false);
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                return $action->setLabel(false);
            })
            ->update(Crud::PAGE_DETAIL, Action::INDEX, function (Action $action) {
                return $action->setIcon('fa fa-right-from-bracket')->setLabel(false);
            })
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-plus')->setLabel(false);
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Edit');
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setLabel('Voir');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setLabel('Supprimer');
            })

            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Sauver');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action->setLabel(false)->setIcon('fas fa-plus');
            })

            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Sauver');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action) {
                return $action->setLabel('Sauver et Continuer');
            })
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('name'),
            IntegerField::new('price', 'prix'),
            AssociationField::new('category')
                ->setCrudController(CategoryCrudController::class)
                // ->autocomplete()
                // ->renderAsNativeWidget()
                ,
          AssociationField::new('userCreate')
                ->setCrudController(UserCrudController::class)
                ->onlyOnDetail()
                ->onlyOnIndex()
                // ->autocomplete()
                // ->renderAsNativeWidget()
                ,
           
                AssociationField::new('userUpdate')
                ->setCrudController(UserCrudController::class)
                ->onlyOnDetail()
                ->onlyOnIndex()
                // ->autocomplete()
                // ->renderAsNativeWidget()
                ,
                
             
                BooleanField::new('isPublic')
                ,
                ImageField::new('imageName','Image')
                ->setBasePath('images/article/')
                ->setUploadDir('public/images/article/'),
                TextEditorField::new('detail', 'Detail')

        ];
    }
}