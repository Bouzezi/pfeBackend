<?php

namespace App\Controller;

use App\Entity\PaysDestination;
use App\Repository\PaysDestinationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use \Datetime;
/**
 * @Route("/paysdestination")
 */
class PaysDestinationController extends AbstractController
{
    /**
     * @Route("/", name="paysdestination_index", methods={"GET"})
     */
    public function index(PaysDestinationRepository $paysdestinationRepository): Response
    {
        $Pays=$paysdestinationRepository->findAll();
        $datas=array();
        foreach ($Pays as $key => $pays){
            $datas[$key]['id'] = $pays->getId();
            $datas[$key]['libelle_pays'] = $pays->getLibellePays();
        }
        return new JsonResponse($datas);
    }

    /**
     * @Route("/new", name="paysdestination_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        

        $pays = new PaysDestination();
        $data = json_decode($request->getContent(),true);

        
        $libelle_pays =  isset($data['libelle_pays']) ? $data['libelle_pays'] : null;
     
        $pays->setLibellePays($libelle_pays);
        

            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($pays);
            $entityManager->flush();
            
            return new JsonResponse($data);
            
    }

    /**
     * @Route("/{id}", name="paysdestination_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $paysdestination = $this->getDoctrine()
        ->getRepository(PaysDestination::class)
        ->find($id);
        $datas=array();
        if (!$paysdestination) {
            throw $this->createNotFoundException(
                'No cadre found for id '.$id
            );
        }
        else 
        {
            $datas[0]['id'] = $paysdestination->getId();
            $datas[0]['libelle_pays'] = $paysdestination->getLibellePays();
        }
            
        
        return new JsonResponse($datas);
    }

    /**
     * @Route("/{id}/edit", name="paysdestination", methods={"GET","PUT"})
     */
    public function edit(Request $request, PaysDestination $paysdestination): Response
    {
        $data = json_decode($request->getContent(),true);

        $libelle_pays =  isset($data['libelle_pays']) ? $data['libelle_pays'] : null;

        if($paysdestination->getId() != null){
            
            $pays->setLibellePays($libelle_pays);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($paysdestination);
            $entityManager->flush();

            return new JsonResponse("updated!!");
        }
        
    }

    /**
     * @Route("/{id}", name="paysdestination_delete", methods={"DELETE"})
     */
    public function delete(PaysDestination $paysdestination): Response
    {
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($paysdestination);
            $entityManager->flush();

        return new JsonResponse("deleted!!");
    }
}
