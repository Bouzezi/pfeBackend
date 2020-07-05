<?php

namespace App\Controller;

use App\Entity\Participation;
use App\Repository\ParticipationRepository;
use App\Entity\CadreINS;
use App\Entity\DossierViste;
use App\Repository\CadreINSRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/participation")
 */
class ParticipationController extends AbstractController
{
    /**
     * @Route("/count", name="nombreParticipation", methods={"POST","GET"})
     */
    public function count(Request $request,ParticipationRepository $participationRepository): Response
    {
        
        $participations=$participationRepository->findAll();
        $nbr=0;
        $data = json_decode($request->getContent(),true);

        
        $cadre_id =  isset($data['cadre_id']) ? $data['cadre_id'] : null;
        $annee =  isset($data['annee']) ? $data['annee'] : null;
        
        $repositoryCadre = $this->getDoctrine()->getRepository(CadreINS::class); 
        $cadreINS = $repositoryCadre->findOneBy(['id' => $cadre_id]);
        foreach ($participations as $key => $participe){
            if($cadreINS == $participe->getCadre() && $annee == $participe->getAnnee())
                $nbr++;
        }
            return new Response($nbr);        
    }
    
    /**
     * @Route("/cadreParAnnee", name="stat1", methods={"GET"})
     */
    public function cadreParAnnee(ParticipationRepository $participationRepository): JsonResponse
    {
        $cadres=$participationRepository->findAllCadreParticipe();
         $annee=$participationRepository->findAllAnnee();
        $tab=array();
        $t=array();
        foreach ($cadres as $key => $cad){
            $cadre= $this->getDoctrine()
                        ->getRepository(CadreINS::class)
                        ->findOneBy([
                            'id' => $cad['id']
                        ]);
            
                  $nom=$cadre->getNom();
                  $prenom=$cadre->getPrenom();   
            $tab[$key]['np']="".$nom." ".$prenom;
            $t['np']="".$nom." ".$prenom;

            foreach ($annee as $key1 => $an){
                $nb=$participationRepository->cadreParAnnee($an['annee'],$cad['id']);
                $tab[$key][$an['annee']]=$nb[0]['nombreDossier'];
            }
        } 
        $tab['annee']=$annee;
        
        return new JsonResponse($tab);           
    }
    /**
     * @Route("/statParOrganisme", name="stat2", methods={"POST","GET"})
     */
    public function statParOrganisme(Request $request,ParticipationRepository $participationRepository): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $organismeLib =  isset($data['organisme']) ? $data['organisme'] : null;
        $cadres=$participationRepository->findAllCadreParticipe();
         $annee=$participationRepository->findAllAnnee();
        $tab=array();
        foreach ($cadres as $key => $cad){
            $cadre= $this->getDoctrine()
                        ->getRepository(CadreINS::class)
                        ->findOneBy([
                            'id' => $cad['id']
                        ]);
                $nom=$cadre->getNom();
                $prenom=$cadre->getPrenom();   
            $tab[$key]['np']="".$nom." ".$prenom;
            foreach ($annee as $key1 => $an){
                $participation = $this->getDoctrine()
                        ->getRepository(Participation::class)
                        ->findBy([
                            'annee' => $an['annee'],
                            'cadre' => $cadre
                        ]);
                        if($participation != null){
                            foreach ($participation as $key2 => $part){
                                $dossier_id=$part->getDossier()->getId();
                                $libOragnisme=$part->getDossier()->getOrganismeEtranger()->getLibelleOrg();
                                if($libOragnisme == $organismeLib){
                                    $nb=$participationRepository->statParOrganisme($an['annee'],$cad['id'],$dossier_id);
                                    $tab[$key][$an['annee']]=$nb[0]['nombreDossier'];
                                }
                                else
                                $tab[$key][$an['annee']]=0;
                            }

                        }
                        else
                        $tab[$key][$an['annee']]=0;
            }
        } 
        return new JsonResponse($tab);           
    }

    /**
     * @Route("/statParDirection", name="stat3", methods={"POST","GET"})
     */
    public function statParDirection(Request $request,ParticipationRepository $participationRepository): JsonResponse
    {
        $data = json_decode($request->getContent(),true);
        $directionLib =  isset($data['direction']) ? $data['direction'] : null;
        $cadres=$participationRepository->findAllCadreParticipe();
         $annee=$participationRepository->findAllAnnee();
        $tab=array();
        foreach ($cadres as $key => $cad){
            $cadre= $this->getDoctrine()
                        ->getRepository(CadreINS::class)
                        ->findOneBy([
                            'id' => $cad['id']
                        ]);
            $Libdirection=$cadre->getDirectionCentrale()->getLibelleDirection();
            foreach ($annee as $key1 => $an){
                
                        if($Libdirection != null){
                            if($directionLib == $Libdirection){
                                $nom=$cadre->getNom();
                                $prenom=$cadre->getPrenom();   
                                $tab[$key]['np']="".$nom." ".$prenom;
                                $nb=$participationRepository->cadreParAnnee($an['annee'],$cadre->getId());
                                $tab[$key][$an['annee']]=$nb[0]['nombreDossier'];
                            } 
                        }
            }
        } 
        return new JsonResponse($tab);           
    }

}
