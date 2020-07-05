<?php

namespace App\Controller;

use App\Entity\ProgrammeCooperation;
use App\Entity\OrganismeEtranger;
use App\Repository\ProgrammeCooperationRepository;
use App\Repository\OrganismeEtrangerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/programmeCooperation")
 */
class ProgrammeCooperationController extends AbstractController
{
    /**
     * @Route("/programmes", name="programmeCooperation", methods={"GET"})
     */
    public function index(ProgrammeCooperationRepository $programmeCooperationrRepository): JsonResponse
    {
        $programmes=$programmeCooperationrRepository->findAll();
        $datas=array();
        foreach ($programmes as $key => $prog){
            $datas[$key]['libelle_prog'] = $prog->getLibelleProg();
        }
        return new JsonResponse($datas);
    }
    /**
     * @Route("/programmes_par_organisme", name="programmeCooperation_index", methods={"POST"})
     */
    /* 
    public function index(Request $request): Response
    {

        $data = json_decode($request->getContent(),true);
        $libelle_org =  isset($data['libelle_org']) ? $data['libelle_org'] : null;
        $repo_Org = $this->getDoctrine()->getRepository(OrganismeEtranger::class);
        $organismeEtranger = $repo_Org->findOneBy(['libelle_org' => $libelle_org]);
        $organismeProgrammes=$organismeEtranger->getOrganismeProgrammes();
         if($this->organismeProgrammes->contains($prog)){
            return;
        } 

        $organismes=$organismeEtrangerRepository->findAll();
        $datas=array();
        foreach ($organismes as $key => $org){
            $datas[$key]['id'] = $org->getId();
            $datas[$key]['libelle_org'] = $org->getLibelleOrg();
        }

        $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($Organismes);
            $entityManager->flush();
        return new JsonResponse($datas);
    } */

    /**
     * @Route("/new", name="programmeCooperation_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        

        $Programmes = new ProgrammeCooperation();
        $data = json_decode($request->getContent(),true);

        
        $libelle_prog =  isset($data['libelle_prog']) ? $data['libelle_prog'] : null;
     
        $Programmes->setLibelleProg($libelle_prog);
        

            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($Programmes);
            $entityManager->flush();
            
            return new JsonResponse($data);
            
    }

    /**
     * @Route("/{libelle_prog}", name="programmeCooperation_show", methods={"GET"})
     */
    public function show(ProgrammeCooperation $programmeCooperation): Response
    {
        
        $datas=array();
        
            $datas[0]['id'] = $programmeCooperation->getId();
            $datas[0]['libelle_org'] = $programmeCooperation->getLibelleProg();
            
        
        return new JsonResponse($datas);
    }

    /**
     * @Route("/{id}/edit", name="programmeCooperation_edit", methods={"GET","PUT"})
     */
    public function edit(Request $request, ProgrammeCooperation $programmeCooperation): Response
    {
        $data = json_decode($request->getContent(),true);

        $libelle_prog =  isset($data['libelle_prog']) ? $data['libelle_prog'] : null;

        if($programmeCooperation->getId() != null){
            
            $programmeCooperation->setLibelleProg($libelle_prog);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($programmeCooperation);
            $entityManager->flush();

            return new JsonResponse("updated!!");
        }
        
    }

    /**
     * @Route("/{id}", name="programmeCooperation_delete", methods={"DELETE"})
     */
    public function delete(ProgrammeCooperation $programmeCooperation): Response
    {
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($programmeCooperation);
            $entityManager->flush();

        return new JsonResponse("deleted!!");
    }
}
