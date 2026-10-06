<?php

namespace App\DataFixtures;

use App\Entity\Figurine;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            ['Alice', 'Martin', 'alice@example.com'],
            ['Bruno', 'Dupont', 'bruno@example.com'],
            ['Chloé', 'Lambert', 'chloe@example.com'],
        ];

        $users = [];
        foreach ($usersData as [$firstname, $lastname, $email]) {
            $user = (new User())
                ->setFirstname($firstname)
                ->setLastname($lastname)
                ->setEmail($email)
                ->setIsVerified(true);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password123'));

            $manager->persist($user);
            $users[] = $user;
        }

        
        $figurines = [
            ['Samouraï articulé édition collector', 'Figurine de 28 cm avec armure amovible, deux sabres et socle lumineux.', 129.90],
            ['Dragon d\'obsidienne 30 cm', 'Dragon en résine peinte à la main, ailes déployées. Tirage limité à 500 exemplaires.', 89.00],
            ['Robot géant MK-II', 'Mecha en métal moulé et ABS, 14 points d\'articulation, accessoires inclus.', 74.50],
            ['Chevalier lunaire', 'Statuette premium échelle 1/6, cape en tissu véritable.', 159.99],
            ['Petit renard des neiges', 'Mini figurine kawaii de 8 cm, idéale pour un bureau.', 12.90],
            ['Pirate des sept mers - édition deluxe avec perroquet', 'Un pirate haut en couleur livré avec son perroquet, son coffre et son drapeau.', 64.00],
            ['Ninja de l\'ombre', null, 39.90],
            ['Sorcière des marais', 'Figurine 1/8 avec chaudron fumigène (fumée non fournie).', 54.20],
            ['Astronaute vintage', 'Hommage rétro aux années 60, casque transparent et drapeau.', 29.99],
            ['Golem de pierre géant', 'Pièce imposante de 40 cm, peinture effet roche, yeux lumineux.', 189.00],
            ['Pilote de course', 'Figurine 1/12 avec combinaison détaillée et casque amovible.', 24.50],
            ['Elfe archère forêt profonde', 'Statuette en résine, arc articulé et carquois détachable.', 99.90],
        ];

        foreach ($figurines as $i => [$title, $description, $price]) {
            $date = new \DateTimeImmutable(sprintf('-%d days', 12 - $i));

            $figurine = (new Figurine())
                ->setTitle($title)
                ->setDescription($description)
                ->setPrice($price)
                ->setImageName(sprintf('fig-%02d.svg', $i + 1)) 
                ->setUser($users[$i % 3])
                ->setCreatedAt($date)
                ->setUpdatedAt($date);

            $manager->persist($figurine);
        }

        $manager->flush();
    }
}
