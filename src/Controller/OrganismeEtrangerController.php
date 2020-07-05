<?php

namespace App\Controller;

use App\Entity\OrganismeEtranger;
use App\Repository\OrganismeEtrangerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/organismeEtranger")
 */
class OrganismeEtrangerController extends AbstractController
{
    /**
     * @Route("/", name="organismeEtranger_index", methods={"GET"})
     */
    public function index(OrganismeEtrangerRepository $organismeEtrangerRepository): Response
    {
        $organismes=$organismeEtrangerRepository->findAll();
        $datas=array();
        foreach ($organismes as $key => $org){
            $datas[$key]['id'] = $org->getId();
            $datas[$key]['libelle_org'] = $org->getLibelleOrg();
        }
        return new JsonResponse($datas);
    }

    /**
     * @Route("/new", name="organismeEtranger_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        

        $Organismes = new OrganismeEtranger();
        $data = json_decode($request->getContent(),true);

        
        $libelle_org =  isset($data['libelle']) ? $data['libelle'] : null;
     
        $Organismes->setLibelleOrg($libelle_org);
        

            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($Organismes);
            $entityManager->flush();
            
            return new JsonResponse($data);
            
    }

    /**
     * @Route("/{id}", name="organismeEtranger_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $organismeEtranger = $this->getDoctrine()
        ->getRepository(OrganismeEtranger::class)
        ->find($id);
        $datas=array();
        if($organismeEtranger != null){
           
            $datas[0]['id'] = $organismeEtranger->getId();
            $datas[0]['libelle_org'] = $organismeEtranger->getLibelleOrg();
            
        }
        return new JsonResponse($datas);
    }

    /**
     * @Route("/edit/{id}", name="organismeEtranger", methods={"GET","PUT"})
     */
    public function edit(Request $request, $id): Response
    {
        $data = json_decode($request->getContent(),true);

        $libelle_org =  isset($data['libelle']) ? $data['libelle'] : null;
        $organismeEtranger = $this->getDoctrine()
        ->getRepository(OrganismeEtranger::class)
        ->find($id);

        if($organismeEtranger != null){
            
            $organismeEtranger->setLibelleOrg($libelle_org);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($organismeEtranger);
            $entityManager->flush();

            return new JsonResponse("updated!!");
        }
        
    }

    /**
     * @Route("/{id}", name="organismeEtranger_delete", methods={"DELETE"})
     */
    public function delete(OrganismeEtranger $organismeEtranger): Response
    {
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($organismeEtranger);
            $entityManager->flush();

        return new JsonResponse("deleted!!");
    }
}
