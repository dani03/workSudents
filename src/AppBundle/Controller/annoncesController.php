<?php

namespace AppBundle\Controller;

use AppBundle\Entity\toutesAnnonces;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class annoncesController extends Controller
{
    /**
     * @Route("/annonces", name="all_annonces")
     */
    public function annonceAction()
    {
       $annonces =$this->getDoctrine()
                  ->getRepository('AppBundle:toutesAnnonces')
                  ->findAll();

        return $this->render('Annonces/Annonces.html.twig', array(

          'annonces' => $annonces
        ));
    }

    /**
     * @Route("/annonces/create", name="create_annonce")
     */
    public function createAction(Request $request)
    {
       $MonAnnonce = new toutesAnnonces;

       $form = $this->createFormBuilder($MonAnnonce)
              // ->add('category')
              ->add('nom', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:20px')))
              ->add('email', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:20px')))
              ->add('titreAnnonce', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:20px')))
              ->add('ville', TextType::class, array('attr' => array('class' =>'form-control', 'style' => 'margin-bottom:20px')))
              ->add('description', TextareaType::class, array('attr' => array('class' =>'form-control', 'style' => 'margin-bottom:20px')))
              ->add('save', SubmitType::class, array('label' => 'ajouter une annonce', 'attr' => array('class' =>'btn btn-info', 'style' => 'margin-bottom:20px')))

              ->getForm();

            $form->handleRequest($request);

              if($form->isSubmitted() && $form->isValid()){
                // getData
                $nom = $form['nom']->getData();
                $email = $form['email']->getData();
                $titreAnnonce = $form['titreAnnonce']->getData();
                $ville = $form['ville']->getData();
                $description = $form['description']->getData();

                $MonAnnonce->setNom($nom);
                $MonAnnonce->setEmail($email);
                $MonAnnonce->setTitreAnnonce($titreAnnonce);
                $MonAnnonce->setVille($ville);
                $MonAnnonce->setDescription($description);

                $em =$this->getDoctrine()->getManager();

                $em->persist($MonAnnonce);
                $em->flush();
                $this->addFlash(
                  'notice',
                  'votre annonce a été bien ajouté'
                );
                return $this->redirectToRoute('all_annonces');
              }

        return $this->render('Annonces/create.html.twig', array(
          'form' => $form->createView()
        ));
    }

    /**
     * @Route("/annonces/editer/{id}", name="editer_annonce")
     */
    public function updateAction($id, Request $request)
    {
      $annonce =$this->getDoctrine()
                 ->getRepository('AppBundle:toutesAnnonces')
                 ->find($id);

                 $MonAnnonce->setNom($MonAnnonce->getNom());
                 $MonAnnonce->setEmail($MonAnnonce->getEmail());
                 $MonAnnonce->setTitreAnnonce($MonAnnonce->getTitreAnnonce());
                 $MonAnnonce->setVille($MonAnnonce->getVille());
                 $MonAnnonce->setDescription($MonAnnonce->getDescription());

                 $form = $this->createFormBuilder($MonAnnonce)
                        // ->add('category')
                        ->add('nom', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:20px')))
                        ->add('email', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:20px')))
                        ->add('titreAnnonce', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:20px')))
                        ->add('ville', TextType::class, array('attr' => array('class' =>'form-control', 'style' => 'margin-bottom:20px')))
                        ->add('description', TextareaType::class, array('attr' => array('class' =>'form-control', 'style' => 'margin-bottom:20px')))
                        ->add('save', SubmitType::class, array('label' => 'modifier une annonce', 'attr' => array('class' =>'btn btn-info', 'style' => 'margin-bottom:20px')))

                        ->getForm();

                      $form->handleRequest($request);

                        if($form->isSubmitted() && $form->isValid()){
                          // getData
                          $nom = $form['nom']->getData();
                          $email = $form['email']->getData();
                          $titreAnnonce = $form['titreAnnonce']->getData();
                          $ville = $form['ville']->getData();
                          $description = $form['description']->getData();

                            $em =$this->getDoctrine()->getManager();
                            $MonAnnonce = $em->getRepository('AppBundle:annonce')->find($id);
                          $MonAnnonce->setNom($nom);
                          $MonAnnonce->setEmail($email);
                          $MonAnnonce->setTitreAnnonce($titreAnnonce);
                          $MonAnnonce->setVille($ville);
                          $MonAnnonce->setDescription($description);


                          $em->flush();
                          $this->addFlash(
                            'notice',
                            'votre annonce a bien été modifié'
                          );
                          return $this->redirectToRoute('all_annonces');
                        }

       return $this->render('Annonces/update.html.twig', array(

         'annonce' => $annonce,
         'form' => $form->createView()
       ));
    }

    /**
     * @Route("/annonces/supprimer/{id}", name="supp_annonce")
     */
    public function deleteAction(Request $request)
    {
        return $this->render('Annonces/delete.html.twig');
    }

    /**
     * @Route("/annonces/details/{id}", name="details_annonce")
     */
    public function readAction($id)
    {
      $annonce =$this->getDoctrine()
                 ->getRepository('AppBundle:toutesAnnonces')
                 ->find($id);

       return $this->render('Annonces/read.html.twig', array(

         'annonce' => $annonce
       ));
    }
}
