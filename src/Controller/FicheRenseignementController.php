<?php

namespace App\Controller;

use App\Entity\FicheRenseignement;
use App\Entity\DossierVisite;
use App\Repository\FicheRenseignementRepository;
use App\Repository\DossierVisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/fiches")
 */
class FicheRenseignementController extends AbstractController
{
     /**
     * @Route("/", name="fiche_index", methods={"GET"})
     */
    public function index(FicheRenseignementRepository $ficheRepository): Response
    {
        $fiches=$ficheRepository->findAll();
        $datas=array();
        foreach ($fiches as $key => $fiche){
            $datas[$key]['id'] = $fiche->getId();
            $datas[$key]['date'] = $fiche->getDate();
            $datas[$key]['autre_frais'] = $fiche->getAutreFrais();
            $datas[$key]['objectif_visite'] = $fiche->getObjectifVisite();
            $datas[$key]['relation_participant_visite'] = $fiche->getRelationParticipantVisite();
            $datas[$key]['derniere_visite'] = $fiche->getDerniereVisite();
            $datas[$key]['date_envoie_rapport'] = $fiche->getDateEnvoieRapport();
        }
        return new JsonResponse($datas);
    }

    /**
     * @Route("/new", name="fiche_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        

        $fiche = new FicheRenseignement();
        $data = json_decode($request->getContent(),true);

        
        $date =  isset($data['date']) ? $data['date'] : null;
        $autre_frais =  isset($data['autre_frais']) ? $data['autre_frais'] : null;
        $objectif_visite =  isset($data['objectif_visite']) ? $data['objectif_visite'] : null;
        $relation_participant_visite =  isset($data['relation_participant_visite']) ? $data['relation_participant_visite'] : null;
        $derniere_visite =  isset($data['derniere_visite']) ? $data['derniere_visite'] : null;
        $date_envoie_rapport =  isset($data['date_envoie_rapport']) ? $data['date_envoie_rapport'] : null;
        $dossier_id =  isset($data['dossier_id']) ? $data['dossier_id'] : null;
        $cadre_ins =  isset($data['cadre_ins']) ? $data['cadre_ins'] : null;
        
        $dossier = $this->getDoctrine()
        ->getRepository(DossierVisite::class)
        ->find($dossier_id);

        $fiche1 = $this->getDoctrine()
        ->getRepository(FicheRenseignement::class)
        ->findOneBy([
            'cadreINS' => $cadre_ins,
            'dossierVisite' => $dossier_id,
            
        ]);

        if($fiche1 == null){
            $fiche->setDate($date);
            $fiche->setAutreFrais($autre_frais);
            $fiche->setObjectifVisite($objectif_visite);
            $fiche->setRelationParticipantVisite($relation_participant_visite);
            $fiche->setDerniereVisite($derniere_visite);
            $fiche->setDateEnvoieRapport($date_envoie_rapport);
            $fiche->setCadreINS($cadre_ins);
            $dossier->addFich($fiche);
        
            $entityManager = $this->getDoctrine()->getManager();  
            $entityManager->persist($fiche);
            $entityManager->flush();
        }
        else{
            throw $this->createNotFoundException(
                ' fiche renseignement duplicated '
            );
        }
            

            return new JsonResponse($data);
            
    }

    /**
     * @Route("/getFiche/{dossier_visite_id}/{cadreINS}", name="fiche_show", methods={"GET"})
     */
    public function show($dossier_visite_id , $cadreINS): JsonResponse
    {
         $dossier = $this->getDoctrine()
        ->getRepository(DossierVisite::class)
        ->find($dossier_visite_id);
        
        $fiches = $dossier->getFiches()->toArray();
        if (!$fiches) {
            throw $this->createNotFoundException(
                'No fiche renseignement found for dossier_id '.$dossier_id
            );
        }
        else 
        {
            $datas=array();
        
            foreach ($fiches as $key => $fiche){
                if($fiche->getCadreINS() == $cadreINS){
                    $datas[$key]['id'] = $fiche->getId();
                    $datas[$key]['date'] = $fiche->getDate();
                    $datas[$key]['autre_frais'] = $fiche->getAutreFrais();
                    $datas[$key]['objectif_visite'] = $fiche->getObjectifVisite();
                    $datas[$key]['relation_participant_visite'] = $fiche->getRelationParticipantVisite();
                    $datas[$key]['derniere_visite'] = $fiche->getDerniereVisite();
                    $datas[$key]['date_envoie_rapport'] = $fiche->getDateEnvoieRapport();
                }
                
            }
        }
        
        return new JsonResponse($datas);
        
    }

    /**
     * @Route("/edit/{id}", name="fiche_edit", methods={"PUT"})
     */
    public function edit(Request $request, $id): Response
    {
        $fiche = $this->getDoctrine()
        ->getRepository(FicheRenseignement::class)
        ->find($id);
        $data = json_decode($request->getContent(),true);

        $date =  $data['date'];
        $autre_frais =  isset($data['autre_frais']) ? $data['autre_frais'] : null;
        $objectif_visite =  isset($data['objectif_visite']) ? $data['objectif_visite'] : null;
        $relation_participant_visite =  isset($data['relation_participant_visite']) ? $data['relation_participant_visite'] : null;
        $derniere_visite =  isset($data['derniere_visite']) ? $data['derniere_visite'] : null;
        $date_envoie_rapport =  isset($data['date_envoie_rapport']) ? $data['date_envoie_rapport'] : null;

        if($fiche->getId() != null){
            
            $fiche->setDate($date);
            $fiche->setAutreFrais($autre_frais);
            $fiche->setObjectifVisite($objectif_visite);
            $fiche->setRelationParticipantVisite($relation_participant_visite);
            $fiche->setDerniereVisite($derniere_visite);
            $fiche->setDateEnvoieRapport($date_envoie_rapport);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fiche);
            $entityManager->flush();
            $data['id']=$id;
            return new JsonResponse($data);
        }     
    }

    /**
     * @Route("/delete/{dossier_visite_id}/{id}", name="fiche_delete", methods={"DELETE"})
     */
    public function delete($dossier_visite_id , $id ): Response
    {
        $dossier = $this->getDoctrine()
        ->getRepository(DossierVisite::class)
        ->find($dossier_visite_id);

        $fiche = $this->getDoctrine()
        ->getRepository(FicheRenseignement::class)
        ->find($id);

        $dossier->removeFich($fiche);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fiche);
            $entityManager->flush();

        return new JsonResponse("deleted!!");
    }
}
