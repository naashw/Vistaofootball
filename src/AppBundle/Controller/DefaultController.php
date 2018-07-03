<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\ActionsMatch;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/accueil", name="accueil")
     */
    public function accueilAction()
    {
        return $this->render('/accueil/index.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction()
    {
        return $this->render('/contact/index.html.twig');
    }


    /**
     * @Route("/coach", name="coachMenu")
     */


     public function coachAction(Request $request)
     {
         // replace this example code with whatever you need


         $user = $this->getUser();
         return $this->render('coach/menu.html.twig',  [
             'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR, 'user' => $user
         ]);
     }


    /**
     * @Route("/avantMatch", name="AvantMatch")
     */

     public function avantMatchAction(Request $request)
     {


       $userId = $this->getUser()->getId();
       $em = $this->getDoctrine()->getManager();
       $equipes = $em->getRepository('AppBundle:Equipes')->findBy(["entraineurId" => $userId]);

           return $this->render('clavier/AvantMatch.html.twig', array(
               'equipes' => $equipes,
           ));

     }
    /**
     * @Route("/joueurByEquipe/{x}", name="joueurByEquipe")
     *
     */

     public function joueurByEquipeAction(Request $request, $x)
     {

           $em = $this->getDoctrine()->getManager();
           $id = $x;
           $Joueur = $em->getRepository('AppBundle:Joueurs')->findBy(["equipeId" => $id]);

           $Joueur = json_encode($Joueur);

          return  new Response($Joueur);
        /*   return $this->render('equipes/index.html.twig', array(
               'equipes' => $equipes, 'equipesId' => $equipeId
           )); */

     }

    /**
     * @Route("/clavier", name="clavier")
     */
    public function clavierAction(Request $request)
    {
         $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render('clavier/index.html.twig',array( "equipe" => $_POST, "entraineur" => $user
        ));
    }

    /**
     * @Route("/statsmatch", name="statsmatch")
     */
    public function statsAction(Request $request)
    {
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render('stats/general.html.twig',array( "equipe" => $_POST, "entraineur" => $user
        ));
    }

    /**
     * @Route("/tirs", name="tirs")
     */
    public function tirsAction(Request $request)
    {
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render('stats/tirs.html.twig',array( "equipe" => $_POST, "entraineur" => $user
        ));
    }

    /**
     * @Route("/possession", name="possession")
     */
    public function possessionAction(Request $request)
    {
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render('stats/possession.html.twig',array( "equipe" => $_POST, "entraineur" => $user
        ));
    }

    /**
     * @Route("/recuperation", name="recuperation")
     */
    public function recuperationAction(Request $request)
    {
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render('stats/recuperation.html.twig',array( "equipe" => $_POST, "entraineur" => $user
        ));
    }

    /**
     * @Route("/cpa", name="cpa")
     */
    public function cpaAction(Request $request)
    {
        $user = $this->getUser();
        // replace this example code with whatever you need
        return $this->render('stats/cpa.html.twig',array( "equipe" => $_POST, "entraineur" => $user
        ));
    }


    /**
     * @Route("/envoiAjax/{actionneur}/{action}/{receveur}", name="envoiAjax")
     * @param $actionneur
     * @param $action
     * @param $receveur
     */
    public function ajaxEnvoi($actionneur, $action, $receveur)
    {
        $userId = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $actions_match = new ActionsMatch();

        $actions_match->setMatchId(2);
        $actions_match->setJoueurAction($actionneur);
        $actions_match->setActionId($action);
        $actions_match->setJoueurReceveur($receveur);

        $em->persist($actions_match);
        $em->flush();

        return "Ajax envoyé";

    }


}
