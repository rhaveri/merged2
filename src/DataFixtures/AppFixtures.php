<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Factory\QuestionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       // QuestionFactory::new()->create();//creates one question
        QuestionFactory::new()->createMany(4);// THEN symfony console doctrine:fixtures:load

        QuestionFactory::new()
            ->unpublished()
            ->createMany(5)//creates 5 unpublished questions
        ;

    }
}
