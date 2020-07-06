<?php

namespace  App\tests\Entity;

use App\Entity\Rapport;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class RapportTest extends KernelTestCase
{

    public function getEntity(): Rapport{
        return (new Rapport())
       ->setPath("C:\xampp\htdocs\pfeBackend\public\uploads");
    
    }

    public function assertHasErrors(Rapport $code,int $number=0){
        self::bootkernel();
        $error=self::$container->get('validator')->validate($code);
        $this->assertcount($number, $error);
    }
    

    public function testValidEntityRapport(){

       $this->assertHasErrors($code =$this->getEntity(),0);
    }
    
    public function testInValideRapport(){

        $this->assertHasErrors ($code =$this->getEntity()->setPath(''),1);
    } 

}