<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // List of genres to create
        $genres = ['Comedy', 'Drama', 'Sci-Fi', 'Fantasy', 'Horror', 'Thriller', 'Action', 'Romance'];

        foreach ($genres as $index => $genreName) {
            $genre = new Genre();
            $genre->setName($genreName);
            $manager->persist($genre);

            // Add a reference for each genre
            $this->addReference('Genre_' . $index, $genre);
        }

        // Save all genres to the database
        $manager->flush();
    }
}
