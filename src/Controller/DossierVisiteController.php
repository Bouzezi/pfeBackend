<?php

namespace App\Controller;

use App\Entity\DossierVisite;
use App\Entity\Participation;
use App\Repository\ParticipationRepository;
use App\Entity\PaysDestination;
use App\Entity\OrganismeEtranger;
use App\Entity\ProgrammeCooperation;
use App\Entity\FicheRenseignement;
use App\Entity\CadreINS;
use App\Controller\PaysDestinationController;
use App\Controller\OrganismeEtrangerController;
use App\Controller\ProgrammeCooperationController;
use App\Controller\CadreINSController;
use App\Repository\DossierVisiteRepository;
use App\Repository\FicheRenseignementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/dossiervisite")
 */
class DossierVisiteController extends AbstractController
{
    /**
     * @Route("/", name="dossiervisite_index", methods={"GET"})
     */
    public function index(DossierVisiteRepository $dossiervisiteRepository): Response
    {
        $dossiers=$dossiervisiteRepository->findAll();
        $datas=array();
        foreach ($dossiers as $key => $dossier){
            $datas[$key]['id'] = $dossier->getId();
            $datas[$key]['date_arrive_visite'] = $dossier->getDateArriveInvitation();
            $datas[$key]['nature'] = $dossier->getNature();
            $datas[$key]['sujet'] = $dossier->getSujet();
            $datas[$key]['date_deb'] = $dossier->getDateDebut();
            $datas[$key]['date_fin'] = $dossier->getDateFin();
            $datas[$key]['type_visite'] = $dossier->getTypeVisite();
            $datas[$key]['nb_participant_ins'] = $dossier->getNbrParticipantINS();
            $datas[$key]['nb_participant_sp'] = $dossier->getNbrParticipantSP();
            $datas[$key]['frais_transport'] = $dossier->getFraisTransport();
            $datas[$key]['frais_residence'] = $dossier->getFraisResidence();
            $datas[$key]['date_limite_reponce'] = $dossier->getDateLimiteReponce();
            $datas[$key]['statut'] = $dossier->getStatut();
            $datas[$key]['langues'] = $dossier->getLangues();
            $datas[$key]['ville'] = $dossier->getVille();
            $datas[$key]['pays_destination_id'] = $dossier->getPaysDestination()->getLibellePays();
            $datas[$key]['organisme_etranger_id'] = $dossier->getOrganismeEtranger()->getLibelleOrg();
            $datas[$key]['date'] = $dossier->getDate();
            $datas[$key]['date_envoi_documents'] = $dossier->getDateEnvoiDocuments();
            
        }
        return new JsonResponse($datas);
    }

    /**
     * @Route("/suivi", name="suivi", methods={"GET"})
     */
    public function suivi(DossierVisiteRepository $dossiervisiteRepository,ParticipationRepository $participationRepository): JsonResponse
    {
        $dossiers=$dossiervisiteRepository->findAll();
        $datas=array();
        $cadres=array();
        foreach ($dossiers as $key => $dossier){
            $datas[$key]['id_dossier'] = $dossier->getId();
            $datas[$key]['date_arrive_visite'] = $dossier->getDateArriveInvitation();
            $datas[$key]['nature'] = $dossier->getNature();
            $datas[$key]['sujet'] = $dossier->getSujet();
            $datas[$key]['date_deb'] = $dossier->getDateDebut();
            $datas[$key]['date_fin'] = $dossier->getDateFin();
            $datas[$key]['type_visite'] = $dossier->getTypeVisite();
            $datas[$key]['frais_transport'] = $dossier->getFraisTransport();
            $datas[$key]['frais_residence'] = $dossier->getFraisResidence();
            $datas[$key]['pays_destination_lib'] = $dossier->getPaysDestination()->getLibellePays();
            $datas[$key]['ville'] = $dossier->getVille();
            $datas[$key]['organisme_etranger_lib'] = $dossier->getOrganismeEtranger()->getLibelleOrg();
            $datas[$key]['date_envoi_documents'] = $dossier->getDateEnvoiDocuments();
            $cadres=array();
            $participations=$participationRepository->findBy([
                'dossier' => $dossier->getId()
            ]);
            $i=0;
            foreach ($participations as $key => $participe){
                $cadres[$i]=$participe->getCadre();
                $i++;
            }
            
            $c=array();
            foreach ($cadres as $key1 => $cadre){
                $c[$key1]['id_cadre']=$cadre->getId();
                $c[$key1]['nom']=$cadre->getNom();
                $c[$key1]['prenom']=$cadre->getPrenom();
                $c[$key1]['grade']=$cadre->getGrade();
                $c[$key1]['fonction']=$cadre->getFonction();
                $c[$key1]['direction']=$cadre->getDirectionCentrale()->getLibelleDirection();
                $fiche = $this->getDoctrine()
                ->getRepository(FicheRenseignement::class)
                ->findOneBy([
                    'cadreINS' => $cadre->getId(),
                    'dossierVisite' => $dossier
                ]);
                if($fiche != null){
                    $datas[$key]['objectif_visite'] = $fiche->getObjectifVisite(); 
                    $datas[$key]['date_envoie_rapport'] = $fiche->getDateEnvoieRapport();
                }
                
            }
            $datas[$key]['cadre_participe']=$c;
            
            
            
            
        }
        return new JsonResponse($datas);
    }

    /**
     * @Route("/new", name="dossiervisite_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        

        $dossiervisite = new DossierVisite();
        $data = json_decode($request->getContent(),true);

        $date_arrive_invitation =  isset($data['date_arrive_invitation']) ? $data['date_arrive_invitation'] : null;
        $nature =  isset($data['nature']) ? $data['nature'] : null;
        $sujet =  isset($data['sujet']) ? $data['sujet'] : null;
        $date_deb =  isset($data['date_deb']) ? $data['date_deb'] : null;
        $date_fin =  isset($data['date_fin']) ? $data['date_fin'] : null;
        $date_limite_rep =  isset($data['date_limite_reponce']) ? $data['date_limite_reponce'] : null;
        $type_visite =  isset($data['type_visite']) ? $data['type_visite'] : null;
        $annee=isset($data['annee']) ? $data['annee'] : null;
        $nbr_participant_ins =  isset($data['nbr_participant_ins']) ? $data['nbr_participant_ins'] : null;
        $nbr_participant_sp =  isset($data['nbr_participant_sp']) ? $data['nbr_participant_sp'] : null;
        $frais_transport =  isset($data['frais_transport']) ? $data['frais_transport'] : null;
        $frais_residence =  isset($data['frais_residence']) ? $data['frais_residence'] : null;
        $statut	 =  isset($data['statut']) ? $data['statut'] : null;
        $langues =  isset($data['langues']) ? $data['langues'] : null;
       $pays_destination_libelle =  isset($data['pays_destination_libelle']) ? $data['pays_destination_libelle'] : null;
       $organisme_etranger_libelle =  isset($data['organisme_etranger_libelle']) ? $data['organisme_etranger_libelle'] : null; 
       $programme_libelle =  isset($data['programme_libelle']) ? $data['programme_libelle'] : null;
       $ville =  isset($data['ville']) ? $data['ville'] : null;
       $direction =  isset($data['direction']) ? $data['direction'] : null;
       $date =  isset($data['date']) ? $data['date'] : null;
       $date_envoi_documents =  isset($data['date_envoi_documents']) ? $data['date_envoi_documents'] : null;
       
        $cadre_id = array();
       $cadre_id =  isset($data['cadre_id']) ? $data['cadre_id'] : null;
        
        $dossiervisite->setDateArriveInvitation($date_arrive_invitation);
        $dossiervisite->setDateDebut($date_deb);
        $dossiervisite->setDateFin($date_fin);
        $dossiervisite->setDateLimiteReponce($date_limite_rep);
        $dossiervisite->setSujet($sujet);
        $dossiervisite->setTypeVisite($type_visite);
        $dossiervisite->setNbrParticipantINS($nbr_participant_ins);
        $dossiervisite->setNbrParticipantSP($nbr_participant_sp);
        $dossiervisite->setFraisTransport($frais_transport);
        $dossiervisite->setFraisResidence($frais_residence);
        $dossiervisite->setStatut($statut);
        $dossiervisite->setNature($nature);
        $dossiervisite->setLangues($langues);
        $dossiervisite->setProgramme($programme_libelle);
        $dossiervisite->setDirection($direction);
        $dossiervisite->setVille($ville);
        $dossiervisite->setDate($date);
        $dossiervisite->setDateEnvoiDocuments($date_envoi_documents);

        


        $repository = $this->getDoctrine()->getRepository(PaysDestination::class);
        $pays_destination = $repository->findOneBy(['libelle_pays' => $pays_destination_libelle]);

            if ($pays_destination) {
                $dossiervisite->setPaysDestination($pays_destination);
                //$paysdestination=$dossiervisite->getPaysDestination();
                //return new JsonResponse($paysdestination->getLibellePays());
            }
            $repositoryOrg = $this->getDoctrine()->getRepository(OrganismeEtranger::class);
            $organismeEtranger = $repositoryOrg->findOneBy(['libelle_org' => $organisme_etranger_libelle]);
            $repositoryProg = $this->getDoctrine()->getRepository(ProgrammeCooperation::class);
            $programmeCooperation = $repositoryProg->findOneBy(['libelle_prog' => $programme_libelle]);
               
                if ($organismeEtranger && $programmeCooperation) {
                    $organismeEtranger->addOrganismeProgrammes($programmeCooperation);
                    $dossiervisite->setOrganismeEtranger($organismeEtranger);
                    
                }

            $repositoryCadre = $this->getDoctrine()->getRepository(CadreINS::class); 
            $entityManager = $this->getDoctrine()->getManager(); 
            $entityManager->persist($dossiervisite);
            $entityManager->flush();    
            $data['id']  = $dossiervisite->getId();

            for ($i=0; $i < count($cadre_id); $i++) { 
                $participation=new Participation();  
                $cadreINS = $repositoryCadre->findOneBy(['id' => $cadre_id[$i]]);
                
                $participation->setDossier($dossiervisite);
                $participation->setCadre($cadreINS);
                $participation->setAnnee($annee);
                $entityManager->persist($participation);
                $entityManager->flush();   
               }
            
            return new JsonResponse($data);
            
            
    }

    /**
     * @Route("/{id}", name="dossiervisite_show", methods={"GET"})
     */
    public function show($id,ParticipationRepository $participationRepository): Response
    {
        $dossier = $this->getDoctrine()
        ->getRepository(DossierVisite::class)
        ->find($id);

        $datas=array();

        $datas[0]['id'] = $dossier->getId();
        $datas[0]['date_arrive_visite'] = $dossier->getDateArriveInvitation();
        $datas[0]['nature'] = $dossier->getNature();
        $datas[0]['sujet'] = $dossier->getSujet();
        $datas[0]['date_deb'] = $dossier->getDateDebut();
        $datas[0]['date_fin'] = $dossier->getDateFin();
        $datas[0]['type_visite'] = $dossier->getTypeVisite();
        $datas[0]['nb_participant_ins'] = $dossier->getNbrParticipantINS();
        $datas[0]['nb_participant_sp'] = $dossier->getNbrParticipantSP();
        $datas[0]['frais_transport'] = $dossier->getFraisTransport();
        $datas[0]['frais_residence'] = $dossier->getFraisResidence();
        $datas[0]['date_limite_reponce'] = $dossier->getDateLimiteReponce();
        $datas[0]['statut'] = $dossier->getStatut();
        $datas[0]['langues'] = $dossier->getLangues();
        $datas[0]['ville'] = $dossier->getVille();
        $datas[0]['direction'] = $dossier->getDirection();
        $datas[0]['programme_libelle'] = $dossier->getProgramme();
        $datas[0]['pays_destination_id'] = $dossier->getPaysDestination()->getLibellePays();
        $datas[0]['organisme_etranger_id'] = $dossier->getOrganismeEtranger()->getLibelleOrg();
        $datas[0]['date'] = $dossier->getDate();
        $datas[0]['date_envoi_documents'] = $dossier->getDateEnvoiDocuments();
        $cadres=array();
        $participations=$participationRepository->findBy([
            'dossier' => $id
        ]);
        $i=0;
        foreach ($participations as $key => $participe){
            $cadres[$i]=$participe->getCadre();
            $i++;
        }
        $progs= $dossier->getOrganismeEtranger()->getOrganismeProgrammes();
        
        $c=array();
        foreach ($cadres as $key => $cadre){
            $c[$key]['id']=$cadre->getId();
            $c[$key]['nom']=$cadre->getNom();
            $c[$key]['prenom']=$cadre->getPrenom();
            $c[$key]['grade']=$cadre->getGrade();
            $c[$key]['fonction']=$cadre->getFonction();
            $c[$key]['direction']=$cadre->getDirectionCentrale()->getLibelleDirection();
        }
        $datas[0]['cadre_participe']=$c;
        
        
        return new JsonResponse($datas);
    }

    /**
     * @Route("/edit/{id}", name="dossiervisite_edit", methods={"GET","PUT"})
     */
    public function edit(Request $request, $id): Response
    {
        $dossiervisite = $this->getDoctrine()
        ->getRepository(DossierVisite::class)
        ->find($id);

        $data = json_decode($request->getContent(),true);
        $annee =  isset($data['annee']) ? $data['annee'] : null;
        $date_arrive_invitation =  isset($data['date_arrive_invitation']) ? $data['date_arrive_invitation'] : null;
        $nature =  isset($data['nature']) ? $data['nature'] : null;
        $sujet =  isset($data['sujet']) ? $data['sujet'] : null;
        $date_deb =  isset($data['date_deb']) ? $data['date_deb'] : null;
        $date_fin =  isset($data['date_fin']) ? $data['date_fin'] : null;
        $date_limite_rep =  isset($data['date_limite_rep']) ? $data['date_limite_rep'] : null;
        $paye_destination =  isset($data['paye_destination']) ? $data['paye_destination'] : null;
        $ville_destination =  isset($data['ville_destination']) ? $data['ville_destination'] : null;
        $nbr_participant_ins =  isset($data['nbr_participant_ins']) ? $data['nbr_participant_ins'] : null;
        $nbr_participant_sp =  isset($data['nbr_participant_sp']) ? $data['nbr_participant_sp'] : null;
        $frais_transport =  isset($data['frais_transport']) ? $data['frais_transport'] : null;
        $frais_residence =  isset($data['frais_residence']) ? $data['frais_residence'] : null;
        $date_limite_rep =  isset($data['date_limite_reponce']) ? $data['date_limite_reponce'] : null;
        $statut	 =  isset($data['statut']) ? $data['statut'] : null;
        $langues =  isset($data['langues']) ? $data['langues'] : null;
        $ville =  isset($data['ville']) ? $data['ville'] : null;
        $direction =  isset($data['direction']) ? $data['direction'] : null;
        $programme_libelle =  isset($data['programme_libelle']) ? $data['programme_libelle'] : null;
        $pays_destination_libelle =  isset($data['pays_destination_libelle']) ? $data['pays_destination_libelle'] : null;
        $organisme_etranger_libelle =  isset($data['organisme_etranger_libelle']) ? $data['organisme_etranger_libelle'] : null; 
        $date =  isset($data['date']) ? $data['date'] : null;
        $date_envoi_documents =  isset($data['date_envoi_documents']) ? $data['date_envoi_documents'] : null;
        $cadre_id = array();
        $cadre_id =  isset($data['cadre_id']) ? $data['cadre_id'] : null;
        $cadre_participe = array();
        $cadre_participe =  isset($data['cadre_participe']) ? $data['cadre_participe'] : null;
        $data['id']=$id;
        if($dossiervisite->getId() != null){
            $dossiervisite->setDateArriveInvitation($date_arrive_invitation);
            $dossiervisite->setDateDebut($date_deb);
            $dossiervisite->setDateFin($date_fin);
            $dossiervisite->setDateLimiteReponce($date_limite_rep);
            $dossiervisite->setSujet($sujet);
            $dossiervisite->setNbrParticipantINS($nbr_participant_ins);
            $dossiervisite->setNbrParticipantSP($nbr_participant_sp);
            $dossiervisite->setFraisTransport($frais_transport);
            $dossiervisite->setFraisResidence($frais_residence);
            $dossiervisite->setStatut($statut);
            $dossiervisite->setNature($nature);
            $dossiervisite->setLangues($langues);
            $dossiervisite->setProgramme($programme_libelle);
            $dossiervisite->setDirection($direction);
            $dossiervisite->setVille($ville);
            $dossiervisite->setDate($date);
            $dossiervisite->setDateEnvoiDocuments($date_envoi_documents);
            $repositoryCadre = $this->getDoctrine()->getRepository(CadreINS::class);    
            $entityManager = $this->getDoctrine()->getManager();
                        
                   for ($i=0; $i < count($cadre_participe); $i++) { 
                        $cadreINS = $repositoryCadre->findOneBy(['id' => $cadre_participe[$i]]);
                        $participation = $this->getDoctrine()
                        ->getRepository(Participation::class)
                        ->findOneBy([
                            'cadre' => $cadreINS->getId(),
                            'dossier' => $dossiervisite
                        ]);
                        $entityManager->remove($participation);
                        $entityManager->flush(); 
                   }
                   for ($j=0; $j < count($cadre_id); $j++) { 
                        $cadreINS = $repositoryCadre->findOneBy(['id' => $cadre_id[$j]]);
                        $participation=new Participation();  
                        $participation->setDossier($dossiervisite);
                        $participation->setCadre($cadreINS);
                        $participation->setAnnee($annee);
                        $entityManager->persist($participation);
                        $entityManager->flush();
                    }

            $entityManager->persist($dossiervisite);
            $entityManager->flush();

            return new JsonResponse($data);
        }
        
    }

}
