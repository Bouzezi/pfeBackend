<?php

namespace  App\tests\Entity;

use App\Entity\CadreINS;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class CadreINSTest extends KernelTestCase
{

    public function getEntity(): CadreINS{
        return (new CadreINS())
        ->setNom("jeff")
        ->setPrenom("cavaliere")
        ->setGrade("grade")
        ->setFonction("youtuber");
    
    }

    public function assertHasErrors(CadreINS $code,int $number=0){
        self::bootkernel();
        $error=self::$container->get('validator')->validate($code);
        $this->assertcount($number, $error);
    }
    

    public function testValidEntityCadreINS(){

       $this->assertHasErrors($code =$this->getEntity(),0);
    }
    
    public function testInValideCadreINS(){

        $this->assertHasErrors ($code =$this->getEntity()->setNom(''),1);
        $this->assertHasErrors ($code =$this->getEntity()->setPrenom(''),1);
    } 

}