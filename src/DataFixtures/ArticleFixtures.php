<?php


namespace App\DataFixtures;

use App\Entity\Article;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;


class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    const CATEGORIES = [
        'PHP',
        'Java',
        'Javascript',
        'Ruby',
        'DevOps',
    ];

    public function load(ObjectManager $manager)
    {
        // we set up the language
        $faker = Faker\Factory::create('fr_FR');

        // we set up 50 articles all in lower case
        for ($i = 0; $i < 50; $i++) {
            $article = new Article();
            $article->setTitle(mb_strtolower($faker->sentence()));
            $article->setContent(mb_strtolower($faker->sentence()));

            $manager->persist($article);
            $article->setCategory($this->getReference(array_rand(CATEGORIES)));

        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}