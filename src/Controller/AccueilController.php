<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request ;
use Doctrine\Common\Persistence\ObjectManager;

class AccueilController extends Controller
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index()
    {
        return $this->render('accueil/home.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('accueil/home.html.twig');
    }
    /**
     * @Route("/forms", name="forms")
     */
    public function forms()
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findAll();


        return $this->render('accueil/forms.html.twig',['user' => $user]);
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, ObjectManager $manager)
    {
      $newuser = new User ();
      $forms = $this->createFormBuilder($newuser)
                    ->add('firstname')
                    ->add('age')
                    ->add('forget')
                    ->getForm();

      $forms->handleRequest($request);
      if ($forms-> isSubmitted() && $forms-> isValid()){
        $newuser->setCreateAt(new \DateTime());
        $manager -> persist($newuser);
        $manager->flush();
        return $this->redirectToRoute('forms');
      }

        return $this->render('accueil/index.html.twig',["forms"=>$forms->createView()]);
    }
}
