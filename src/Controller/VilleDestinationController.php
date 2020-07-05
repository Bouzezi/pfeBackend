<?php

namespace App\Controller;

use App\Entity\VilleDestination;
use App\Entity\PaysDestination;
use App\Controller\PaysDestinationController;
use App\Repository\VilleDestinationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/villedestination")
 */
class VilleDestinationController extends AbstractController
{
    /**
     * @Route("/villes", name="villedestination_index", methods={"POST","GET"})
     */
    public function getVilles(Request $request): Response
    {
        $data = json_decode($request->getContent(),true);
        $pays_destination_libelle =  isset($data['pays_destination_libelle']) ? $data['pays_destination_libelle'] : null;
        $repository = $this->getDoctrine()->getRepository(PaysDestination::class);
        $pays_destination = $repository->findOneBy(['libelle_pays' => $pays_destination_libelle]);
        $villedestinationRepository = $this->getDoctrine()->getRepository(VilleDestination::class);
        $Villes=$villedestinationRepository->findAll();
        $datas=array();
        foreach ($Villes as $key => $ville){
            if($ville->getPaysDestination() === $pays_destination){
                $datas[$key]['id'] = $ville->getId();
                $datas[$key]['libelle_ville'] = $ville->getLibelleVille();
            }
            
        }
        return new JsonResponse($datas);
    }

    /**
     * @Route("/new", name="villedestination_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        

        $ville = new VilleDestination();
        $data = json_decode($request->getContent(),true);

        
        $libelle_ville =  isset($data['libelle_ville']) ? $data['libelle_ville'] : null;
     
        $ville->setLibelleville($libelle_ville);
        

            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($ville);
            $entityManager->flush();
            
            return new JsonResponse($data);
            
    }

    /**
     * @Route("/{libelle_ville}", name="villedestination_show", methods={"GET"})
     */
    public function show(VilleDestination $villedestination): Response
    {
        
        $datas=array();
        
            $datas[0]['id'] = $villedestination->getId();
            $datas[0]['libelle_ville'] = $ville->getLibelleVille();
            
        
        return new JsonResponse($datas);
    }

    /**
     * @Route("/{id}/edit", name="villedestination", methods={"GET","PUT"})
     */
    public function edit(Request $request, VilleDestination $villedestination): Response
    {
        $data = json_decode($request->getContent(),true);

        $libelle_ville =  isset($data['libelle_ville']) ? $data['libelle_ville'] : null;

        if($villedestination->getId() != null){
            
            $villedestination->setLibellePays($libelle_ville);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($villedestination);
            $entityManager->flush();

            return new JsonResponse("updated!!");
        }
        
    }

    /**
     * @Route("/{id}", name="villedestination_delete", methods={"DELETE"})
     */
    public function delete(VilleDestination $villedestination): Response
    {
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($villedestination);
            $entityManager->flush();

        return new JsonResponse("deleted!!");
    }
}
