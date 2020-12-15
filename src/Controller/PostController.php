<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Mutimedia;
use App\Entity\Photo;
use App\Entity\Publication;
use App\Form\CommentaireFormType;
use App\Form\MultimediaType;
use App\Form\PhotoType;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use App\Repository\UtilisateurRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     * @param PublicationRepository $repository
     * @return Response
     */
    public function index(PublicationRepository $repository): Response
    {
        $pubs= $repository->findAll();
        return $this->render('publication/post.html.twig',['pubs'=>$pubs]);
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
//
                    }
                }
            }
            $em->flush();
            $this->addFlash('notice', 'Publication crée avec succée !');
            return $this->redirectToRoute("post");
        }
        return $this->render('publication/newpublication.html.twig', ['form' => $form->createView(),'form1' => $form1->createView()]);
    }

}



