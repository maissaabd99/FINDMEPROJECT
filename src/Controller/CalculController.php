<?php

namespace App\Controller;

use App\Repository\CommentaireRepository;
use App\Repository\PublicationRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculController extends AbstractController
{
    /**
     * @Route("/calcul", name="calcul")
     */
    public function index(PublicationRepository $repository, UtilisateurRepository $rep, CommentaireRepository  $repo): Response
    {
        $em = $this->getDoctrine()->getManager();
        $pubs = $repository->findAll();
        $uti=$rep->findAll();
        
        $res = $repository->findBy(['statut'=>'r']);
        $NbrH = $repository->findBy(['sexe'=>'Homme']);
        $NbrF = $repository->findBy(['sexe'=>'Femme']);
        $Nbr18 = $repository->findAll(['age'>18]);
        $comments=$repo->findAll();
        $NbrHomme = count($NbrH);

        $NbrFemme = count($NbrF);
        $commentsTotal = count($comments);
        $totalPubsWithStatusR = count($res);
        $totalPubs = count($pubs);
        $totalut = count($uti);
        $nb= count($Nbr18);
        $PostNotResolved =$totalPubs - $totalPubsWithStatusR ;



        return $this->render('calcul/index.html.twig',  ['totalPubsWithStatusR'=>$totalPubsWithStatusR,
            'totalPubs'=>$totalPubs,
            'commentsTotal'=>$commentsTotal,
            'NbrHomme'=>$NbrHomme,
            'NbrFemme'=>$NbrFemme,
            'nb'=>$nb,
            'PostNotResolved'=>$PostNotResolved,
            'totalut'=>$totalut]);
    }




}
