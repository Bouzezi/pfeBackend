<?php

namespace App\Controller;

use App\Entity\DirectionCentrale;
use App\Repository\DirectionCentraleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/directionCentrale")
 */
class DirectionCentraleController extends AbstractController
{
    /**
     * @Route("/", name="directionCentrale_index", methods={"GET"})
     */
    public function index(DirectionCentraleRepository $directionCentraleRepository): Response
    {
        $directions=$directionCentraleRepository->findAll();
        $datas=array();
        foreach ($directions as $key => $dir){
            $datas[$key]['id'] = $dir->getId();
            $datas[$key]['libelle_direction'] = $dir->getLibelleDirection();
        }
        return new JsonResponse($datas);
    }

    /**
     * @Route("/new", name="directionCentrale_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
    
        $direction = new DirectionCentrale();
        $data = json_decode($request->getContent(),true);

        $libelle_direction =  isset($data['libelle_direction']) ? $data['libelle_direction'] : null;
        $direction->setLibelleDirection($libelle_direction);
            $entityManager = $this->getDoctrine()->getManager();         
            $entityManager->persist($direction);
            $entityManager->flush();
            
            return new JsonResponse($data);          
    }

    /**
     * @Route("/{libelle_direction}", name="directionCentrale_show", methods={"GET"})
     */
    public function show(DirectionCentrale $directionCentrale): Response
    {
        
        $datas=array();
        
            $datas[0]['id'] = $directionCentrale->getId();
            $datas[0]['libelle_direction'] = $directionCentrale->getLibelleDirection();
            
        
        return new JsonResponse($datas);
    }

    /**
     * @Route("/{id}/edit", name="directionCentrale", methods={"GET","PUT"})
     */
    public function edit(Request $request, DirectionCentrale $directionCentrale): Response
    {
        $data = json_decode($request->getContent(),true);

        $libelle_direction =  isset($data['libelle_direction']) ? $data['libelle_direction'] : null;

        if($directionCentrale->getId() != null){
            
            $directionCentrale->setLibelleDirection($libelle_direction);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($directionCentrale);
            $entityManager->flush();

            return new JsonResponse("updated!!");
        }
        
    }

    /**
     * @Route("/{id}", name="directionCentrale_delete", methods={"DELETE"})
     */
    public function delete(DirectionCentrale $directionCentrale): Response
    {
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($directionCentrale);
            $entityManager->flush();

        return new JsonResponse("deleted!!");
    }
}
