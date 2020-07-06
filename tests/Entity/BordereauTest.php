<?php

namespace  App\tests\Entity;

use App\Entity\Bordereau;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class BordereauTest extends KernelTestCase
{

    public function getEntity(): Bordereau{
        return (new Bordereau())
        ->setNumeroDeRang(1)
        ->setNbrDocuments(5)
        ->setDateBordereau("2020-05-06")
        ->setCommentaires("commentaires")
        ->setDateDocuments("2020-05-16");
    
    }

    public function assertHasErrors(Bordereau $code,int $number=0){
        self::bootkernel();
        $error=self::$container->get('validator')->validate($code);
        $this->assertcount($number, $error);
    }
    

    public function testValidEntityBordereau(){

       $this->assertHasErrors($code =$this->getEntity(),0);
    }
    
    public function testInValideBordereau(){

        $this->assertHasErrors ($code =$this->getEntity()->setNbrDocuments(-2),1);
        $this->assertHasErrors ($code =$this->getEntity()->setDateBordereau(''),1);
    } 

}