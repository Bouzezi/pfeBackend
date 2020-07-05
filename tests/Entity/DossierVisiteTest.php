<?php

namespace  App\tests\Entity;

use App\Entity\DossierVisite;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class DossierVisiteTest extends KernelTestCase
{

    public function getEntity(): DossierVisite{
        return (new DossierVisite())
       ->setDateArriveInvitation("2020-06-27")
       ->setDateDebut("2020-07-5")
       ->setDateFin("2020-07-10")
       ->setDateLimiteReponce("2020-07-1")
       ->setSujet("sujet")
       ->setTypeVisite("mission")
       ->setNbrParticipantINS(2)
       ->setNbrParticipantSP(1)
       ->setFraisTransport(true)
       ->setFraisResidence(false)
       ->setStatut("en_cours")
       ->setNature("nat")
       ->setLangues("francais")
       ->setProgramme("MDICI")
       ->setDirection("Statistiques institutionnelles")
       ->setVille("paris")
       ->setDate("2020-06-28")
       ->setDateEnvoiDocuments("2020-07-03");
    
    }

    public function assertHasErrors(DossierVisite $code,int $number=0){
        self::bootkernel();
        $error=self::$container->get('validator')->validate($code);
        $this->assertcount($number, $error);
    }
    

    public function testValidEntityDossierVisite(){

       $this->assertHasErrors($code =$this->getEntity(),0);
    }
    
    public function testInValideDossierVisite(){

        $this->assertHasErrors ($code =$this->getEntity()->setDateArriveInvitation(''),2);
        $this->assertHasErrors ($code =$this->getEntity()->setStatut('statut'),2);
        $this->assertHasErrors ($code =$this->getEntity()->setTypeVisite('visite'),2);
    } 

}