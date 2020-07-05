<?php

namespace App\Controller;

use App\Entity\Bordereau;
use App\Entity\DossierVisite;
use App\Repository\BordereauRepository;
use App\Repository\DossierVisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/bordereau")
 */
class BordereauController extends AbstractController
{
     /**
     * @Route("/", name="bordereau_index", methods={"GET"})
     */
    public function index(BordereauRepository $bordereauRepository): Response
    {
        $bordereaux=$bordereauRepository->findAll();
        $datas=array();
        foreach ($bordereaux as $key => $bord){
            $datas[$key]['id'] = $bord->getId();
            $datas[$key]['numero_de_rang'] = $bord->getNumeroDeRang();
            $datas[$key]['nbr_documents'] = $bord->getNbrDocuments();
            $datas[$key]['date_bordereau'] = $bord->getDateBordereau();
            $datas[$key]['commentaires'] = $bord->getCommentaires();
            $datas[$key]['date_documents'] = $bord->getDateDocuments();
        }
        return new JsonResponse($datas);
    }

    /**
     * @Route("/new", name="bordereau_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        

        $bord = new Bordereau();
        $data = json_decode($request->getContent(),true);

        
        $numero_de_rang =  isset($data['numero_de_rang']) ? $data['numero_de_rang'] : null;
        $nbr_documents =  isset($data['nbr_documents']) ? $data['nbr_documents'] : null;
        $date_bordereau =  isset($data['date_bordereau']) ? $data['date_bordereau'] : null;
        $commentaires =  isset($data['commentaires']) ? $data['commentaires'] : null;
        $date_documents =  isset($data['date_documents']) ? $data['date_documents'] : null;
        $dossier_id =  isset($data['dossier_id']) ? $data['dossier_id'] : null;
        
        $dossier = $this->getDoctrine()
        ->getRepository(DossierVisite::class)
        ->find($dossier_id);

        $bord->setNumeroDeRang($numero_de_rang);
        $bord->setNbrDocuments($nbr_documents);
        $bord->setDateBordereau($date_bordereau);
        $bord->setCommentaires($commentaires);
        $bord->setDateDocuments($date_documents);
        $bord->setDossierVisite($dossier);

            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($bord);
            $entityManager->flush();
            $data['id']=$bord->getId();
            return new JsonResponse($data);
            
    }
    /**
     * @Route("/getBordereau/{dossier_visite_id}", name="bordereau_show", methods={"GET"})
     */
    public function show($dossier_visite_id): JsonResponse
    {
         $dossier = $this->getDoctrine()
        ->getRepository(DossierVisite::class)
        ->find($dossier_visite_id);
        
        $bord = $dossier->getBordereau();
        if (!$bord) {
            throw $this->createNotFoundException(
                'No note found for dossier_id '.$dossier_visite_id
            );
        }
        else 
        {
            $datas=array();
        
            $datas[0]['id'] = $bord->getId();
            $datas[0]['numero_de_rang'] = $bord->getNumeroDeRang();
            $datas[0]['nbr_documents'] = $bord->getNbrDocuments();
            $datas[0]['date_bordereau'] = $bord->getDateBordereau();
            $datas[0]['commentaires'] = $bord->getCommentaires();
            $datas[0]['date_documents'] = $bord->getDateDocuments();
            $datas[0]['dossier_id']=$dossier_visite_id;
        }
        
        return new JsonResponse($datas);
        
    }
    /**
     * @Route("/edit/{id}", name="bordereau_edit", methods={"PUT"})
     */
    public function edit(Request $request, $id): Response
    {
        $bord = $this->getDoctrine()
        ->getRepository(Bordereau::class)
        ->find($id);
        $data = json_decode($request->getContent(),true);

        $numero_de_rang =  isset($data['numero_de_rang']) ? $data['numero_de_rang'] : null;
        $nbr_documents =  isset($data['nbr_documents']) ? $data['nbr_documents'] : null;
        $date_bordereau =  isset($data['date_bordereau']) ? $data['date_bordereau'] : null;
        $commentaires =  isset($data['commentaires']) ? $data['commentaires'] : null;
        $date_documents =  isset($data['date_documents']) ? $data['date_documents'] : null;

        if($bord->getId() != null){
            
            $bord->setNumeroDeRang($numero_de_rang);
            $bord->setNbrDocuments($nbr_documents);
            $bord->setDateBordereau($date_bordereau);
            $bord->setCommentaires($commentaires);
            $bord->setDateDocuments($date_documents);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bord);
            $entityManager->flush();
            $data['id']=$id;
            return new JsonResponse($data);
        }
        
    }

    /**
     * @Route("/{id}", name="bordereau_delete", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        $bord = $this->getDoctrine()
        ->getRepository(Bordereau::class)
        ->find($id);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bord);
            $entityManager->flush();

        return new JsonResponse("deleted!!");
    }
}
