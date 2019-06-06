<?php


namespace App\DataFixtures;

use App\Entity\Article;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;


class ArticleFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        // we set up the language
        $faker = Faker\Factory::create('fr_FR');

        // we set up 50 articles all in lower case
        for ($i = 0; $i < 50; $i++) {
            $article = new Article();
            $article->setTitle(mb_strtolower($faker->sentence(3)));
            $article->setContent(mb_strtolower($faker->sentence(200)));
            $slugify = new Slugify();
            $slug = $slugify->generate($article->getTitle());
            $article->setSlug($slug);
            $manager->persist($article);
            $article->setCategory($this->getReference('categorie_' . rand(0, 4)));

        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}