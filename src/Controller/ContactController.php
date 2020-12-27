<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\Mutimedia;
use App\Entity\Publication;
use App\EventListener\MessageChangerNotifier;
use App\Form\MultimediaType;
use App\Form\PublicationType;
use App\Repository\ConversationRepository;
use App\Repository\PublicationRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\EventManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{




    /**
     * @Route("/contact-admin", name="contact")
     * @param ConversationRepository $repository
     * @param UtilisateurRepository $rep
     * @param Request $request
     * @return Response
     */
    public function index(ConversationRepository $repository,UtilisateurRepository $rep,Request $request): Response
    {
        $user = $rep->find($this->getUser()->getId());
        if($user->getConversation()==null){
            $conversation= new Conversation();
            $conversation->setUtilisateur($user);
            $em=$this->getDoctrine()->getManager();
            $em->persist($conversation);
            $em->flush();
        }
        $coversation = $repository->findOneBy(['utilisateur'=>$user]);
        $messages=$coversation->getMessages();
        return $this->render('Contact/Contact.html.twig',['messages'=>$messages]);
    }


    /**
     * @Route("/contact-admin/newmsg", name="newmsg")
     * @param UtilisateurRepository $repository
     * @param Request $request
     * @param MessageChangerNotifier $notifier
     * @return Response
     * @throws Exception
     */
    public function newmsg(UtilisateurRepository $repository,Request $request,MessageChangerNotifier $notifier): Response
    {

        $message = new Message();
        $iduser = $this->getUser()->getId();
        $user= $repository->find($iduser);
        $em=$this->getDoctrine()->getManager();
        $evm = new EventManager();
        $msg=$request->request->get('msg');
            $conv = $user->getConversation();
            $message->setUtilisateur($user);
            $message->setConversation($conv);
            $message->setDateMess(new \DateTime('now'));
            $message->setMessage($msg);
            $em->persist($message);
            $em->flush();
            $conv->addMessage($message);
            $em->persist($message);
            $em->flush();
//        }

        return $this->json(['code'=>200,'message'=>$msg,'date'=>$message->getDateMess()->format('d/m/Y H:i')],200);
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
            $a = $request->request->get('markers1');
            $b = $request->request->get('markers2');
            $files [] = $request->files->all();
            $pub->setLongitude($a);
            $pub->setLatitude($b);
            $pub->setDatePub(new \DateTime('now'));
            $pub->setStatut('n');
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