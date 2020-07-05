<?php

namespace  App\tests\Entity;

use App\Entity\FicheRenseignement;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class FicheTest extends KernelTestCase
{

    public function getEntity(): FicheRenseignement{
        return (new FicheRenseignement())
        ->setDate("2020-05-27")
        ->setAutreFrais("autre frais")
        ->setObjectifVisite("objectif")
        ->setRelationParticipantVisite("relation")
        ->setDerniereVisite("2020-03-15")
        ->setDateEnvoieRapport("2020-06-19");
    
    }

    public function assertHasErrors(FicheRenseignement $code,int $number=0){
        self::bootkernel();
        $error=self::$container->get('validator')->validate($code);
        $this->assertcount($number, $error);
    }
    

    public function testValidEntityFicheRenseignement(){

       $this->assertHasErrors($code =$this->getEntity(),0);
    }
    
    public function testInValideFicheRenseignement(){

        $this->assertHasErrors ($code =$this->getEntity()->setObjectifVisite(''),1);
    } 

}