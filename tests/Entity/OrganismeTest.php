<?php

namespace  App\tests\Entity;


use    App\Entity\OrganismeEtranger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class OrganismeTest extends KernelTestCase
{

    public function getEntity(): OrganismeEtranger{
        return (new OrganismeEtranger())->setLibelleOrg('france');
    
    }

    public function assertHasErrors(OrganismeEtranger $code,int $number=0){
        self::bootkernel();
        $error=self::$container->get('validator')->validate($code);
        $this->assertcount($number, $error);
    }
    

    public function testValidEntityOrg(){

       $this->assertHasErrors($code =$this->getEntity(),0);
    

    }
    
    public function testInValideOrg(){

        $this->assertHasErrors ($code =$this->getEntity()->setLibelleOrg(''),1);
    }

}