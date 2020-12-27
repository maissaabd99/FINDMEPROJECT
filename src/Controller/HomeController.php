<?php

namespace App\Controller;

use App\Entity\Mutimedia;
use App\Entity\Publication;
use App\Form\MultimediaType;
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

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PublicationRepository $repository, UtilisateurRepository $rep, CommentaireRepository  $repo): Response
    {

        $em = $this->getDoctrine()->getManager();
        $pubs = $repository->findAll();
        $uti=$rep->findAll();
        $res = $repository->findBy(['statut'=>'r']);
        $comments=$repo->findAll();
        $commentsTotal = count($comments);
        $totalPubsWithStatusR = count($res);
        $totalPubs = count($pubs);
        $totalut = count($uti);

        return $this->render('home/index.html.twig',
            ['totalPubsWithStatusR'=>$totalPubsWithStatusR,
                'totalPubs'=>$totalPubs,
                'commentsTotal'=>$commentsTotal,
                'totalut'=>$totalut]);

    }



    /**
     * @Route("/registration/verification", name="verification")
     */
    public function verificationregister(): Response
    {
        return $this->render('registration/verifcationregister.html.twig');
    }

    /**
     * @Route("/registration/account-activation/{adresse}", name="activation")
     * @param Request $request
     * @param UtilisateurRepository $repository
     * @return Response
     */
    public function accountactivation(Request $request,UtilisateurRepository $repository): Response
    {
        $x=$request->get('adresse');
        $a=$repository->findOneBy(['email'=>$x]);
        $user=$repository->find($a->getId());
        $em=$this->getDoctrine()->getManager();
        $user->setVerified('true');
        $em->flush();
//        dd($x,$a);
        return $this->render('registration/activate.html.twig');
    }



    /**
     * @Route("/post/test", name="test")
     * @return Response

     */
    public function single(): Response
    {
        return $this->render('publication/localisatio.html.twig');
    }

    /**
     * @Route("/post/editcomment", name="editcomment")
     * @param CommentaireRepository $rep
     * @return Response
     */

    public function editcomment(CommentaireRepository $rep,Request $request):Response
    {
        $idc= $request->request->get('d');
        $contenu= $request->request->get('c');
        $comment =$rep->find($idc);
        $comment->setContenuComnt($contenu);
        $em= $this->getDoctrine()->getManager();
//        $em->persist($comment);
        $em->flush();
        return $this->json(['msg'=>'commentaire modifié !']);
    }


    /**
     * @Route("/post/new", name="newpost")
     * @param Request $request
     * @param UtilisateurRepository $repository
     * @return Response
     * @throws Exception
     */
    public function newpublication(Request $request, UtilisateurRepository $repository): Response
    {
        $multimedia = new Mutimedia();
        $pub = new Publication();
        $form1 = $this->createForm(PublicationType::class, $pub);
        $form1->handleRequest($request);
        $form = $this->createForm(MultimediaType::class, $multimedia);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if (($form1->isSubmitted())) {
//            $files[] = $_FILES['files'];
            $a = $request->request->get('markers1');
            $b = $request->request->get('markers2');
//            dd($a,$b);
            $files [] = $request->files->all();
            $pub->setLongitude($a);
            $pub->setLatitude($b);
            $pub->setDatePub(new \DateTime('now'));
            $pub->setUtilisateur($repository->find($this->getUser()->getId()));
            $em->persist($pub);
            $em->flush();
            foreach ($files as $key => $value) {
                foreach ($value as $cle => $v) {
                    foreach ($v as $c => $file) {
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
        return $this->render('publication/newpublication.html.twig', ['form' => $form->createView(), 'form1' => $form1->createView()]);
    }







}




