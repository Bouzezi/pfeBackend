<?php

namespace  App\tests\Entity;


use    App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class UserTest extends KernelTestCase
{

    public function getEntity(): User{
        return (new User())->setUsername('france');
    
    }

    public function assertHasErrors(UserTest $code,int $number=0){
        self::bootkernel();
        $error=self::$container->get('validator')->validate($code);
        $this->assertcount($number, $error);
    }
    

    public function testValidEntityUser(){

       $this->assertHasErrors($code =$this->setUsername(),0);
    

    }
    
    public function testInValideUser(){

        $this->assertHasErrors ($code =$this->getEntity()->setUsername(''),1);
    }

}