<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Personnage;
use AppBundle\Entity\Royaume;

class DefaultController extends Controller
{

    /**
     * @Route("/show/{id}", name="show")
     */
    public function showPersonnageAction($id){
        $em = $this->getDoctrine()->getManager();
        $personnage = $em->getRepository('AppBundle:Personnage')
            ->find($id);

        return $this->render('default/show.html.twig', ['personnage'=>$personnage]);

    }

    /**
     * @Route("/list/{sexe}", name="list")
     */
    public function listPersonnageAction($sexe) {
        $em = $this->getDoctrine()->getManager();
        $personnages = $em->getRepository('AppBundle:Personnage')
            ->findBySexe($sexe);
        return $this->render('default/list.html.twig', ['personnages'=>$personnages,'sexe' => $sexe]);
    }

    /**
     * @Route("/addPersonnage/{nom}/{prenom}/{sexe}/{bio}", name="add_personnage")
     */
    public function addPersoAction($nom,$prenom,$sexe,$bio){
        $em = $this->getDoctrine()->getManager();
        $personnage = new Personnage();
        $personnage->setNom($nom);
        $personnage->setSexe($sexe);
        $personnage->setPrenom($prenom);
        $personnage->setBio($bio);
        $em->persist($personnage);
        $em->flush();
        return $this->render('default/addPersonnage.html.twig',[
            'personnage'=>$personnage
        ]);
    }

    /**
     * @Route("/addRoyaume/{nom}/{capitale}/{nbHabitants}", name="add_royaume")
     */
    public function addRoyaumeAction($nom,$capitale,$nbHabitants){
        $em = $this->getDoctrine()->getManager();
        $royaume = new Royaume();
        $royaume->setNom($nom);
        $royaume->setCapitale($capitale);
        $royaume->setNbHabitant($nbHabitants);
        $em->persist($royaume);
        $em->flush();
        return $this->render('default/addRoyaume.html.twig',[
            'royaume'=>$royaume
        ]);
    }

    /**
     * @Route("/changePersoRoyaume/{personnage}/{royaume}", name="change_personnage_royaume")
     *
     */
    public function changePersoRoyaumeAction (Personnage $personnage, Royaume $royaume){

        $em=$this->getDoctrine()->getManager();
        //$royaume->addPersonnage($personnage);
        $personnage->setRoyaume($royaume);
        $em->flush();

        return $this->render('default/changePersoRoyaume.html.twig',[
            'personnage'=>$personnage,
            'royaume'=>$royaume
        ]);
    }

    /**
     * @Route("delete/{personnage}", name="delete")
     */
    public function deletePersoAction(Personnage $personnage){
        $em = $this->getDoctrine()->getManager();
        $em->remove($personnage);
        $em->flush();

        return $this->render('default/delete.html.twig',[
            'personnage'=>$personnage
        ]);
    }


}
