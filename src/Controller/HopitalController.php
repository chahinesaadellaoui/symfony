<?php

namespace App\Controller;

use App\Entity\Hopital;
use App\Form\AddEditHopitalType;
use App\Repository\HopitalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HopitalController extends AbstractController
{
    #[Route('/hopital/list', name: 'app_hopital_list')]
    public function hopitalList(HopitalRepository $HopitalRepository)
    {
        $hopitalsDB = $HopitalRepository->findAll();
        return $this->render('hopital/index.html.twig', [
            'hopitaux' => $hopitalsDB
        ]);
    }

    #[Route('/hopital/add', name: 'app_hopital_add')]
    public function addhopital(EntityManagerInterface $em)
    {
        $hopital = new Hopital();
        $hopital->setNom('hopital Test');
        $hopital->setdateFabrication(new \DateTime());
        $em->persist($hopital);
        $em->flush();
        dd($hopital);
    }

    #[Route('/hopital/new', name: 'app_hopital_new')]
    public function newhopital(Request $request, EntityManagerInterface $em)
    {
        $hopital = new Hopital();
        $form = $this->createForm(AddEditHopitalType::class, $hopital);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($hopital);
            $em->flush();
            return $this->redirectToRoute('app_hopital_list');
        }
        return $this->render('hopital/form.html.twig', [
            'title' => 'Add hopital',
            'form' => $form
        ]);
    }

    #[Route('/hopital/edit/{id}', name: 'app_hopital_edit')]
    public function edithopital($id, HopitalRepository $HopitalRepository, Request $request, EntityManagerInterface $em)
    {
        $hopital = $HopitalRepository->find($id);
        $form = $this->createForm(AddEditHopitalType::class, $hopital);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_hopital_list');
        }
        return $this->render('hopital/form.html.twig', [
            'title' => 'Update hopital',
            'form' => $form
        ]);
    }

    #[Route('/hopital/delete/{id}', name: 'app_hopital_delete')]
    public function deletehopital($id, HopitalRepository $HopitalRepository, EntityManagerInterface $em)
    {
        $hopital = $HopitalRepository->find($id);
        $em->remove($hopital);
        $em->flush();
        return $this->redirectToRoute('app_hopital_list');
    }

    #[Route('/hopital/update/{id}', name: 'app_hopital_update')]
    public function updatehopital($id, HopitalRepository $HopitalRepository, EntityManagerInterface $em)
    {
        $hopital = $HopitalRepository->find($id);
        $hopital->setNom('Nom mis à jour');
        $em->flush();
        dd($hopital);
    }

    #[Route('/hopital/{id}', name: 'app_hopital_show')]
    public function show(Hopital $hopital): Response
    {
        return $this->render('hopital/show.html.twig', [
            'hopital' => $hopital,
        ]);
    }

 #[Route('/hopital/stats', name: 'app_hopital_stats')]
    public function hopitalStats(HopitalRepository $hopitalRepository): Response
    {
        $hopitalStats = $hopitalRepository->getMedecinCountByHopital();
        return $this->render('hopital/stats.html.twig', [
            'hopitalStats' => $hopitalStats,
        ]);
    }

    
    
}
