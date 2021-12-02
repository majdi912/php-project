<?php

namespace App\DataFixtures;
use Faker\Factory;
use App\Entity\Panne;
use App\Entity\Technicien;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class AppFixtures extends Fixture 

{
    private $userPasswordEncoder;
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }
    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager) : void
    {
     

        for($i=1;$i<3;$i++)
        { 
         $user = new User();
         $user->setEmail("user".$i);
         $user->setPassword($this->passwordEncoder->encoderPassword($user,'uer'.$i));
         $manager->persist($user);
         
         
         

        }
       
            
        

        $manager->flush();
    }
}
