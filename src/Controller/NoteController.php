<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\DossierVisite;
use App\Repository\NoteRepository;
use App\Repository\DossierVisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/note")
 */
class NoteController extends AbstractController
{
     /**
     * @Route("/", name="note_index", methods={"GET"})
     */
    public function index(NoteRepository $noteRepository): Response
    {
        $notes=$noteRepository->findAll();
        $datas=array();
        foreach ($notes as $key => $note){
            $datas[$key]['id'] = $note->getId();
            $datas[$key]['piece_jointe'] = $note->getPieceJointe();
            $datas[$key]['description'] = $note->getDescription();
            $datas[$key]['date'] = $note->getDate();
            $datas[$key]['sujet'] = $note->getDossierVisite()->getSujet();
        }
        return new JsonResponse($datas);
    }

    /**
     * @Route("/new", name="note_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        

        $note = new Note();
        $data = json_decode($request->getContent(),true);

        
        $piece_jointe =  isset($data['piece_jointe']) ? $data['piece_jointe'] : null;
        $description =  isset($data['description']) ? $data['description'] : null;
        $date =  isset($data['date']) ? $data['date'] : null;
        $dossier_id =  isset($data['dossier_id']) ? $data['dossier_id'] : null;
        $dossier = $this->getDoctrine()
        ->getRepository(DossierVisite::class)
        ->find($dossier_id);
        $note->setPieceJointe($piece_jointe);
        $note->setDescription($description);
        $note->setDate($date);
        $note->setDossierVisite($dossier);
        $dossier->setNote($note);
        

            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($note);
            $entityManager->flush();
            
            return new JsonResponse($data);
            
    }

    /**
     * @Route("/getNote/{dossier_visite_id}", name="note_show", methods={"GET"})
     */
    public function show($dossier_visite_id): JsonResponse
    {
         $dossier = $this->getDoctrine()
        ->getRepository(DossierVisite::class)
        ->find($dossier_visite_id);
        
        $note = $dossier->getNote();
        if (!$note) {
            throw $this->createNotFoundException(
                'No note found for dossier_id '.$dossier_id
            );
        }
        else 
        {
            $datas=array();
        
            $datas[0]['id'] = $note->getId();
            $datas[0]['piece_jointe'] = $note->getPieceJointe();
            $datas[0]['description'] = $note->getDescription();
            $datas[0]['date'] = $note->getDate();
            $datas[0]['dossier_id'] = $dossier_visite_id;
        }
        
        return new JsonResponse($datas);
        
    }

    /**
     * @Route("/edit/{id}", name="note_edit", methods={"PUT"})
     */
    public function edit(Request $request, $id): Response
    {
        $note = $this->getDoctrine()
        ->getRepository(Note::class)
        ->find($id);
        $data = json_decode($request->getContent(),true);

        $piece_jointe =  isset($data['piece_jointe']) ? $data['piece_jointe'] : null;
        $description =  isset($data['description']) ? $data['description'] : null;
        $date =  isset($data['date']) ? $data['date'] : null;

        if($note->getId() != null){
            
            $note->setPieceJointe($piece_jointe);
            $note->setDescription($description);
            $note->setDate($date);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();
            $data['id']=$id;
            return new JsonResponse($data);
        }
        
    }

    /**
     * @Route("/{id}", name="note_delete", methods={"DELETE"})
     */
    public function delete( $id): Response
    {
        $note = $this->getDoctrine()
        ->getRepository(Note::class)
        ->find($id);
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($note);
            $entityManager->flush();

        return new JsonResponse("deleted!!");
    }
}
