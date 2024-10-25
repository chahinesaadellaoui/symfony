<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\AddEditMedecinType;
use App\Repository\MedecinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/medecin')]
class MedecinController extends AbstractController
{
    #[Route('/', name: 'app_medecin_list', methods: ['GET'])]
    public function index(MedecinRepository $medecinRepository): Response
    {
        return $this->render('medecin/index.html.twig', [
            'medecins' => $medecinRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_medecin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $medecin = new Medecin();
        $form = $this->createForm(AddEditMedecinType::class, $medecin);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($medecin);
            $em->flush();

            return $this->redirectToRoute('app_medecin_list');
        }

        return $this->render('medecin/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_medecin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Medecin $medecin, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AddEditMedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_medecin_list');
        }

        return $this->render('medecin/form.html.twig', [
            'title' => 'Modifier le medecin',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_medecin_delete', methods: ['POST'])]
    public function delete(Request $request, Medecin $medecin, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medecin->getId(), $request->request->get('_token'))) {
            $em->remove($medecin);
            $em->flush();
        }

        return $this->redirectToRoute('app_medecin_list');
    }

    #[Route('/medecin/{id}', name: 'app_medecin_show', methods: ['GET'])]
public function show(Medecin $medecin): Response
{
    return $this->render('medecin/show.html.twig', [
        'medecin' => $medecin,
    ]);
}

}
