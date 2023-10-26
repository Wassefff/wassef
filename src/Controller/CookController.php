<?php

namespace App\Controller;

use App\Entity\Cook;
use App\Form\CookType;
use App\Repository\CookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CookController extends AbstractController
{
    #[Route('/cook', name: 'app_cook')]
    public function index(CookRepository $cookRepository): Response
    {
        $cooks = $cookRepository->findAll();
        return $this->render('cook/index.html.twig', [
            'controller_name' => 'EmployeeController',
            'cooks' => $cooks,
        ]);
    }
    #[Route('/cook/add', name: 'app_cook_add')]

    public function add(Request $request,EntityManagerInterface $entityManagerInterface): Response
    {
        $cook=new Cook();
        $form=$this->createForm(CookType::class,$cook);
        $form->handleRequest($request);
        if($form->isSubmitted()){
   
        $entityManagerInterface->persist($cook);
    $entityManagerInterface->flush();
    return $this->redirectToRoute("app_cook");
        }
    
        return $this->render('cook/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/cook/modify/{id}', name: 'cook_mod')]

    public function modify($id,CookRepository $cookRepository,Request $request,EntityManagerInterface $entityManagerInterface): Response
{
    
    $cook=$cookRepository->find($id);
    $form=$this->createForm(CookType::class,$cook);
    $form->handleRequest($request);
    if($form->isSubmitted()){
    $entityManagerInterface->persist($cook);
$entityManagerInterface->flush();
return $this->redirectToRoute("app_cook");
    }

    return $this->render('cook/form.html.twig', [
        'form' => $form->createView(),
    ]);
}
#[Route('/cook/delete/{id}', name: 'cook_delete')]

public function delete($id,EntityManagerInterface $entityManager, CookRepository $cookRepository): Response
{
    $cook=$cookRepository->find($id);

    $entityManager->remove($cook);
    $entityManager->flush();
    dump($cook);
    return $this->redirectToRoute('app_cook');
}
}
