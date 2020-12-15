<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Mutimedia;
use App\Entity\Photo;
use App\Entity\Publication;
use App\Form\CommentaireFormType;
use App\Form\CommentType;
use App\Form\MultimediaType;
use App\Form\PhotoType;
use App\Form\PublicationType;
use App\Repository\CommentaireRepository;
use App\Repository\PublicationRepository;
use App\Repository\UtilisateurRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     * @param PublicationRepository $repository
     * @param Request $request
     * @return Response
     */
    public function index(PublicationRepository $repository,Request $request): Response
    {
        $pubs= $repository->findAll();
        $commentaire= new Commentaire();
        $forms=[];
        $form= $this->createForm(CommentType::class,$commentaire);
        return $this->render('publication/post.html.twig',['pubs'=>$pubs,'form'=>$form->createView()]);
    }

    /**
     * @Route("/post/{id}", name="singlepost")
     * @param PublicationRepository $repository
     * @param Request $request
     * @return Response
     */
    public function singlepost($id,PublicationRepository $repository,Request $request): Response
    {
        $pub= $repository->find($id);
        $commentaire= new Commentaire();
        $forms=[];
        $form= $this->createForm(CommentType::class,$commentaire);
        return $this->render('publication/singlepost.html.twig',['pub'=>$pub,'form'=>$form->createView()]);
    }

    /**
     * @Route("/post/new", name="newpost")
     * @param Request $request
     * @param UtilisateurRepository $repository
     * @return Response
     * @throws Exception
     */
    public function newpublication(Request $request,UtilisateurRepository $repository): Response
    {
        $multimedia = new Mutimedia();
        $pub = new Publication();
        $form1= $this->createForm(PublicationType::class,$pub);
        $form1->handleRequest($request);
        $form= $this->createForm(MultimediaType::class,$multimedia);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if (($form1->isSubmitted())) {
//            $files[] = $_FILES['files'];
            $files []= $request->files->all();
//            dd($files);
            $pub->setDatePub(new \DateTime('now'));
            $pub->setUtilisateur($repository->find($this->getUser()->getId()));
            $em->persist($pub);
            $em->flush();
            foreach ($files as $key => $value) {
                foreach ($value as $cle => $v) {
//                    dd($v);
                    foreach ($v as $c=>$file){
//                        dd($file);
                        $p = new Mutimedia();
                        $filename = $file->getClientOriginalName();
//                        dd($filename);
                        $file->move($this->getParameter('images_directory'), $filename);
                        $p->setSource($filename);
                        $p->setPublication($pub);
                        $em->persist($p);
                    }
                }
            }
            $em->flush();
            $this->addFlash('notice', 'Publication crée avec succée !');
            return $this->redirectToRoute("post");
        }
        return $this->render('publication/newpublication.html.twig', ['form' => $form->createView(),'form1' => $form1->createView()]);
    }

    /**
     * @Route("/post/{id}/addcomment", name="newcomment")
     * @param $id
     * @param Request $request
     * @param PublicationRepository $repository
     * @param UtilisateurRepository $rep
     * @return Response
     * @throws Exception
     */
    public function addcomment($id,Request $request,PublicationRepository $repository,UtilisateurRepository $rep):Response{
        $commentaire= new Commentaire();
//        $comment = $_POST['aa'];
        $data = $request->request->get('aa');
//        dd($data);
        $pub= $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $commentaire->setDateComnt(new \DateTime('now'));
        $commentaire->setUtilisateur($rep->find($this->getUser()->getId()));
        $commentaire->setPublication($pub);
        $commentaire->setContenuComnt($data);
        $em->persist($commentaire);
        $em->flush();
            return $this->json(['code'=>200,'message'=>$data,'nbrcomments'=>$pub->getCommentaires()->count(),
                'dateajout'=>$commentaire->getDateComnt()->format('H:i')],200);

    }

    /**
     * @Route("/post/deletecomment/{id}", name="deletecomment")
     * @param $id
     * @param Request $request
     * @param PublicationRepository $repository
     * @param CommentaireRepository $rep
     * @return Response
     */
    public function deletecomment($id,Request $request,PublicationRepository $repository,CommentaireRepository $rep):Response{
        $comment =$rep->find($id);
        $em= $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();
        return $this->json(['code'=>200,'message'=>'commentaire supprimé !'],200);
    }

}



