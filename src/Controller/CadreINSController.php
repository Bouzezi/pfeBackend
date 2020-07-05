<?php

namespace App\Controller;

use App\Entity\CadreINS;
use App\Entity\DirectionCentrale;
use App\Repository\CadreINSRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/cadreINS")
 */
class CadreINSController extends AbstractController
{
     /**
     * @Route("/cadres", name="cadreINS_index", methods={"GET"})
     */
    public function index(CadreINSRepository $cadreINSRepository): Response
    {
        $cadres=$cadreINSRepository->findAll();
        $datas=array();
        foreach ($cadres as $key => $cadre){
            $datas[$key]['id'] = $cadre->getId();
            $datas[$key]['nom'] = $cadre->getNom();
            $datas[$key]['prenom'] = $cadre->getPrenom();
            $datas[$key]['grade'] = $cadre->getGrade();
            $datas[$key]['fonction'] = $cadre->getFonction();
        }
        return new JsonResponse($datas);
    }

     /**
     * @Route("/parDirection", name="cadreINS_dir", methods={"POST"})
     */
    public function getCadre(Request $request): Response
    {
        $data = json_decode($request->getContent(),true);
        $libelle_direction =  isset($data['libelle_direction']) ? $data['libelle_direction'] : null;
        $repository = $this->getDoctrine()->getRepository(DirectionCentrale::class);
        $direction_centrale = $repository->findOneBy(['libelle_direction' => $libelle_direction]);
        $cadreINSRepository = $this->getDoctrine()->getRepository(CadreINS::class);
        $cadres=$cadreINSRepository->findAll();
        $datas=array();
        foreach ($cadres as $key => $cadre){
            if($cadre->getDirectionCentrale() === $direction_centrale){
                $datas[$key]['id'] = $cadre->getId();
                $datas[$key]['nom'] = $cadre->getNom();
                $datas[$key]['prenom'] = $cadre->getPrenom();
                $datas[$key]['grade'] = $cadre->getGrade();
                $datas[$key]['fonction'] = $cadre->getFonction();
               
            }
            
        }
        return new JsonResponse($datas);
    }

    /**
     * @Route("/new", name="cadreINS_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {   $cadre = new CadreINS();
        $data = json_decode($request->getContent(),true);
        
        $nom =  isset($data['nom']) ? $data['nom'] : null;
        $prenom =  isset($data['prenom']) ? $data['prenom'] : null;
        $grade =  isset($data['grade']) ? $data['grade'] : null;
        $fonction =  isset($data['fonction']) ? $data['fonction'] : null;
        $direction_centrale_id= isset($data['direction']) ? $data['direction'] : null;
       
           $direction=$this->getDoctrine()->getRepository(DirectionCentrale::class)
           ->findOneBy(['libelle_direction' => $direction_centrale_id]);


        $cadre->setNom($nom);
        $cadre->setPrenom($prenom);
        $cadre->setGrade($grade);
        $cadre->setFonction($fonction);
        $cadre->setDirectionCentrale($direction);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cadre);
            $entityManager->flush();

            return new JsonResponse($data);
            
    }

    /**
     * @Route("/{id}", name="cadreINS_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $cadre = $this->getDoctrine()
        ->getRepository(CadreINS::class)
        ->find($id);

        if (!$cadre) {
            throw $this->createNotFoundException(
                'No cadre found for id '.$id
            );
        }
        else 
        {
            $datas=array();
        
            $datas[0]['id'] = $cadre->getId();
            $datas[0]['nom'] = $cadre->getNom();
            $datas[0]['prenom'] = $cadre->getPrenom();
            $datas[0]['grade'] = $cadre->getGrade();
            $datas[0]['fonction'] = $cadre->getFonction();
            $datas[0]['direction'] = $cadre->getDirectionCentrale()->getLibelleDirection();
        }
        return new JsonResponse($datas);
    }

    /**
     * @Route("/edit/{id}", name="cadreINS_edit", methods={"GET","PUT"})
     */
    public function edit(Request $request, $id): Response
    {
        $data = json_decode($request->getContent(),true);
        $cadreINS = $this->getDoctrine()
        ->getRepository(CadreINS::class)
        ->find($id);
        $nom =  isset($data['nom']) ? $data['nom'] : null;
        $prenom =  isset($data['prenom']) ? $data['prenom'] : null;
        $grade =  isset($data['grade']) ? $data['grade'] : null;
        $fonction =  isset($data['fonction']) ? $data['fonction'] : null;
        $direction_centrale_id= isset($data['direction']) ? $data['direction'] : null;
        $direction=$this->getDoctrine()->getRepository(DirectionCentrale::class)
           ->findOneBy(['libelle_direction' => $direction_centrale_id]);
           
        if($cadreINS->getId() != null){
            
            $cadreINS->setNom($nom);
            $cadreINS->setPrenom($prenom);
            $cadreINS->setGrade($grade);
            $cadreINS->setFonction($fonction);
            $cadreINS->setDirectionCentrale($direction);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cadreINS);
            $entityManager->flush();

            return new JsonResponse("updated!!");
        }
        
    }

    
/**
     * @Route("/{id}", name="cadreINS_delete", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        $cadreINS = $this->getDoctrine()
        ->getRepository(CadreINS::class)
        ->find($id);
           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cadreINS);
            $entityManager->flush();

        return new JsonResponse("deleted!!");
    }
}