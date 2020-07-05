<?php

namespace  App\tests\Entity;

use App\Entity\Note;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class NoteTest extends KernelTestCase
{

    public function getEntity(): Note{
        return (new Note())
       ->setPieceJointe("data")
       ->setDescription("description");
    
    }

    public function assertHasErrors(Note $code,int $number=0){
        self::bootkernel();
        $error=self::$container->get('validator')->validate($code);
        $this->assertcount($number, $error);
    }
    

    public function testValidEntityNote(){

       $this->assertHasErrors($code =$this->getEntity(),0);
    }
    
    public function testInValideNote(){

        $this->assertHasErrors ($code =$this->getEntity()->setDescription(''),1);
    } 

}