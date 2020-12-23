<?php

namespace App\Controller;

use App\Repository\CommentaireRepository;
use App\Repository\PublicationRepository;
use App\Repository\UtilisateurRepository;
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
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
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




}
