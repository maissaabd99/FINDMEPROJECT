<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use Symfony\Component\HttpFoundation\Request;

use App\Form\CommentaireFormType;
use App\Repository\PublicationRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/{id}", name="comment")
     * @param $id
     * @param Request $request
     * @param PublicationRepository $comment
     * @param UtilisateurRepository $repository
     * @return Response
     * @throws \Exception
     */
    public function index($id,Request $request,PublicationRepository $comment,UtilisateurRepository  $repository): Response
    { $pub = $comment->find($id);
    $comments=$pub->getCommentaires();
    $commentaire=new Commentaire();
    $form=$this->createForm(CommentaireFormType::class,$commentaire);
    $form->handleRequest($request);
        if ($form->isSubmitted()) {
             $commentaire->setDateComnt(new \DateTime('now'));
             $id=$this->getUser()->getId();
             $commentaire->setUtilisateur($repository->find($id));
             $commentaire->setPublication($pub);
//             dd($commentaire);
             $em= $this->getDoctrine()->getManager();
             $em->persist($commentaire);
             $em->flush();
             return $this->redirectToRoute('post');
            }

        return $this->render('comment/index.html.twig', [
            'publication'=>$pub,
            'comments'=>$comments,
            'form'=>$form->createView(),
        ]);
    }
}
