<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\EventListener\MessageChangerNotifier;
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
//        $evm->dispatchEvent($message);
//        dd($notifier);
        if($user->getConversation()==null){
            $conversation= new Conversation();
            $conversation->setUtilisateur($user);
            $em->persist($conversation);

            $em->flush();
        }else{
            $msg=$request->request->get('msg');
//            dd($msg);
            $conv = $user->getConversation();
            $message->setUtilisateur($user);
            $message->setConversation($conv);
            $message->setDateMess(new \DateTime('now'));
            $message->setMessage($msg);
            $em->persist($message);
            $em->flush();
//            dd($message);
            $conv->addMessage($message);
            $em->persist($message);
            $em->flush();
        }

        return $this->json(['code'=>200,'message'=>$msg,'date'=>$message->getDateMess()->format('d/m/Y H:i')],200);
    }




}