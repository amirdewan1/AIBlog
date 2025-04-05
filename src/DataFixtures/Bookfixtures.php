<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class Bookfixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $book1 = new Book();
        $book1->setTitle('Book1');
        $book1->setDescription('A thrilling tale.');
        $book1->setGenre($this->getReference('Genre_5')); // Thriller
        $book1->setImagePath('https://example.com/images/thriller.jpg');
        $manager->persist($book1);

        $book2 = new Book();
        $book2->setTitle('Book2');
        $book2->setDescription('A hilarious comedy.');
        $book2->setGenre($this->getReference('Genre_0')); // Comedy
        $book2->setImagePath('https://example.com/images/comedy.jpg');
        $manager->persist($book2);

        $manager->flush();
        

    }

    public function getDependencies(): array
    {
        return [
            GenreFixtures::class,
        ];
    }


}


