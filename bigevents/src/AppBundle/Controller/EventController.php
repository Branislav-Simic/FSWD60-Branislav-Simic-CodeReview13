<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bigevents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EventController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
    	 $events = $this->getDoctrine()->getRepository('AppBundle:Bigevents')->findAll();
        // replace this example code with whatever you need
        return $this->render('event/index.html.twig',array('bigevents'=>$events));
    }
       /**
    * @Route("/event/create", name="event_create")
    */
   public function createAction(Request $request)
   {
   	  $event = new Bigevents;
      
        $form = $this->createFormBuilder($event)->add('name', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
   		->add('daytime', DateTimeType::class, array('attr' => array('style'=>'margin-bottom:15px')))
       ->add('description', TextareaType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
		->add('img', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('capacity', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('email', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
		->add('phone', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
		->add('address', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
		->add('website', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('type', ChoiceType::class, array('choices'=>array('Music'=>'Music', 'Party'=>'Party', 'Movie'=>'Movie','Sport'=>'Sport'),'attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
   		->add('save', SubmitType::class, array('label'=> 'Create Bigevents', 'attr' => array('class'=> 'btn-primary', 'style'=>'margin-bottom:15px')))
       ->getForm();
       $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           //fetching data
           $name = $form['name']->getData();
           // $daytime = $form['daytime']->getData();
           $description = $form['description']->getData();
           $img = $form['img']->getData();
           $capacity = $form['capacity']->getData();
           $email = $form['email']->getData();
           $phone = $form['phone']->getData();
           $address = $form['address']->getData();
           $website = $form['website']->getData();
           $type = $form['type']->getData();


/* these functions we bring from our entities, every column have a set function and we put the value that we get from the form */
           $event->setName($name);
           $event->setDaytime($daytime);
           $event->setDescription($description);
           $event->setImg($img);
           $event->setCapacity($capacity);
           $event->setEmail($email);
           $event->setPhone($phone);
           $event->setAddress($address);
           $event->setWebsite($website);
           $event->setType($type);
           $em = $this->getDoctrine()->getManager();
           $em->persist($event);
           $em->flush();
           $this->addFlash(
                   'notice',
                   'Bigevents Added'
                   );
           return $this->redirectToRoute('homepage');
       }
		return $this->render('event/create.html.twig', array('form' => $form->createView()));
   }


           /**
    * @Route("/event/details/{id}", name="event_details")
    */
   public function detailsAction($id)
   {
   	  $event = $this->getDoctrine()->getRepository('AppBundle:Bigevents')->find($id);
       return $this->render('event/details.html.twig', array('event' => $event));
   }
 
           /**
    * @Route("event/edit/{id}", name="event_edit")
    */
   public function editAction($id, Request $request)
   {
   	  $event = $this->getDoctrine()->getRepository('AppBundle:Bigevents')->find($id);
    		$event->setName($event->getName());
           $event->setDaytime($event->getDaytime());
           $event->setDescription($event->getDescription());
           $event->setImg($event->getImg());
           $event->setCapacity($event->getCapacity());
           $event->setEmail($event->getEmail());
           $event->setPhone($event->getPhone());
           $event->setAddress($event->getAddress());
           $event->setWebsite($event->getWebsite());
           $event->setType($event->getType());

 $form = $this->createFormBuilder($event)->add('name', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('daytime', DateTimeType::class, array('attr' => array('style'=>'margin-bottom:15px')))
       ->add('description', TextareaType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('img', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('capacity', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('email', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('phone', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('address', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('website', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
        ->add('type', ChoiceType::class, array('choices'=>array('music'=>'music', 'sport'=>'sport', 'movie'=>'movie', 'theater'=>'theater'),'attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
 
   ->add('save', SubmitType::class, array('label'=> 'Update An Event', 'attr' => array('class'=> 'btn-primary', 'style'=>'margin-bottom:15px')))
       ->getForm();
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           //fetching data
         $name = $form['name']->getData();
           $daytime = $form['daytime']->getData();
           $description = $form['description']->getData();
           $img = $form['img']->getData();
           $capacity = $form['capacity']->getData();
           $email = $form['email']->getData();
           $phone = $form['phone']->getData();
           $address = $form['address']->getData();
           $website = $form['website']->getData();
           $type = $form['type']->getData();
           
           $em = $this->getDoctrine()->getManager();
           $event = $em->getRepository('AppBundle:Bigevents')->find($id);
           $event->setName($name);           
           $event->setDaytime($daytime);
           $event->setDescription($description);          
           $event->setImg($img);
           $event->setCapacity($capacity);
           $event->setEmail($email);
           $event->setPhone($phone);
           $event->setAddress($address);
           $event->setWebsite($website);
           $event->setType($type);
       
           $em->flush();
           $this->addFlash(
                   'notice',
                   'event Updated'
                   );
           return $this->redirectToRoute('homepage');
       }
       return $this->render('event/edit.html.twig', array('event' => $event, 'form' => $form->createView()));
   }

   /**
    * @Route("/event/delete/{id}", name="event_delete")
    */
public function deleteAction($id){
            $em = $this->getDoctrine()->getManager();
           $event = $em->getRepository('AppBundle:Bigevents')->find($id);
           $em->remove($event);
            $em->flush();
           $this->addFlash(
                   'notice',
                   'Event Removed'
                   );
            return $this->redirectToRoute('homepage');
   }


  }


 
   
