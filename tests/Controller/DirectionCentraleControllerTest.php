<?php
namespace App\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\DirectionCentrale;
use Symfony\Component\HttpClient\HttpClient;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
class DirectionCentraleControllerTest extends WebTestCase 
{

    public function testNewDirectionCentrale()
    {
        require "vendor/autoload.php";
        $client = new \GuzzleHttp\Client(["base_uri" => "192.168.l.l"]);
        $data = [
            'libelle_direction' => 'libelle_direction'
         ]; 
        $response = $client->post("/directionCentrale/new",[
        'json' => ['libelle_direction' => 'bar']]);
        echo $response->getBody();

       /*  $client = self::createClient();
          
         $client->request('POST', '/directionCentrale/new', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'libelle_direction' => 'libelle_direction'
            ],
        ]);
         $response = $client->getResponse();
         $this->assertResponseStatusCodeSame(401);
       $this->assertEquals(200, $client->getResponse()->getStatusCode()); */
      
    }
}   




     /*  $direction = new DirectionCentrale();
        $direction->setLibelleDirection("informatique"); */
       
               /* $entityManager = $this->getDoctrine()->getManager();
               
               $entityManager->persist($direction);
               $entityManager->flush(); */
        //$direction=factory(DirectionCentrale::class)->create($data);
        //$this->assertInstanceOf(DirectionCentrale::class,$direction);
        //$this->new($client, $data, '/directionCentrale/new');
        //$response = $client->getResponse();
        //$this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        //$this->assertJson($response->getContent());
        
        //$this->assertContains('libelle_direction', $response->getContent());
        /* [
            'libelle_direction'=>'informatique's
         ] */
   

