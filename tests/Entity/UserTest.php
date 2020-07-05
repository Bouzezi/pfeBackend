<?php

namespace  App\tests\Entity;


use    App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class UserTest extends KernelTestCase
{

    public function getEntity(): User{
        return (new User('admin'));
    
    }

    public function getEntityBlank(): User{
        return (new User(''));
    
    }

    public function assertHasErrors(User $code,int $number=0){
        self::bootkernel();
        $error=self::$container->get('validator')->validate($code);
        $this->assertcount($number, $error);
    }
    

    public function testValidEntityUser(){

       $this->assertHasErrors($code =$this->getEntity(),0);
    

    }
    
    public function testInValideUser(){

        $this->assertHasErrors ($code =$this->getEntityBlank(),1);
    }

}