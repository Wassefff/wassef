<?php

namespace App\Controller;

use App\Entity\Kitchen;
use App\Form\KitchenType;
use App\Repository\KitchenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KitchenController extends AbstractController
{
    #[Route('/kitchen', name: 'app_kitchen')]
    public function index(KitchenRepository $kitchenRepository): Response
    {
        $kitchens = $kitchenRepository->findAll();
        return $this->render('kitchen/index.html.twig', [
            'kitchens' => $kitchens,
        ]);
    }
    #[Route('/kitchen/add', name: 'app_kitchen_add')]

    public function add(Request $request,EntityManagerInterface $entityManagerInterface): Response
    {
        $kitchen=new Kitchen();
        $form=$this->createForm(KitchenType::class,$kitchen);
        $form->handleRequest($request);
        if($form->isSubmitted()){
   
        $entityManagerInterface->persist($kitchen);
    $entityManagerInterface->flush();
    return $this->redirectToRoute("app_kitchen");
        }
    
        return $this->render('kitchen/kitchen.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/kitchen/modify/{id}', name: 'kitchen_mod')]

    public function modify($id,KitchenRepository $kitchenRepository,Request $request,EntityManagerInterface $entityManagerInterface): Response
    {
        
        $kitchen=$kitchenRepository->find($id);
        $form=$this->createForm(KitchenType::class,$kitchen);
        $form->handleRequest($request);
        if($form->isSubmitted()){
        $entityManagerInterface->persist($kitchen);
    $entityManagerInterface->flush();
    return $this->redirectToRoute("app_kitchen");
        }
    
        return $this->render('kitchen/kitchen.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/kitchen/delete/{id}', name: 'kitchen_delete')]
    
    public function delete($id,EntityManagerInterface $entityManager, KitchenRepository $kitchenRepository): Response
    {
        $kitchen=$kitchenRepository->find($id);
    
        $entityManager->remove($kitchen);
        $entityManager->flush();
        dump($kitchen);
        return $this->redirectToRoute('app_kitchen');
    }
}
