<?php

namespace App\DataFixtures;

use App\Entity\CategoryExpense;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryExpenseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $expenseCategories = [
            [
                'label' => 'Logement',
                'tag' => 'LOGEMENT',
                'active' => true,
            ],
            [
                'label' => 'Courses',
                'tag' => 'COURSE',
                'active' => true,
            ],
            [
                'label' => 'Transports',
                'tag' => 'TRANSPORT',
                'active' => true,
            ],
            [
                'label' => 'Abonnements',
                'tag' => 'ABONNEMENT',
                'active' => true,
            ],
            [
                'label' => 'Loisirs & Autres',
                'tag' => 'LOISIR',
                'active' => true,
            ],
        ];

        foreach ($expenseCategories as $item) {
            $category = new CategoryExpense();
            $category
                ->setLabel($item['label'])
                ->setTag($item['tag'])
                ->setActive($item['active']);

            $manager->persist($category);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
           
        ];
    }
}