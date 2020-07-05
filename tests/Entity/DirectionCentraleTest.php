<?php

namespace App\tests\Entity;
use App\Entity\DirectionCentrale;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class DirectionCentraleTest extends KernelTestCase 
{
    public function getEntity(): DirectionCentrale{
        return (new DirectionCentrale())->setLibelleDirection('direction');
    }

    public function assertHasErrors(DirectionCentrale $code, int $number=0){
        
        self::bootKernel();
        $error=self::$container->get('validator')->validate($code);
        $this->assertCount($number, $error);
        
    }
    public function testValidEntityDirection()
    {
        
       $this->assertHasErrors($code =$this->getEntity(),0);
    }

    public function testInvalidBlankCodeEntity()
    {
        $this->assertHasErrors($code=$this->getEntity()->setLibelleDirection(''), 1);
        
    }
}