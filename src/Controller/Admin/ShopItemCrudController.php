<?php

namespace App\Controller\Admin;

use App\Entity\ShopItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ShopItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ShopItem::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
}
