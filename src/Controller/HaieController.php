<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Haie;
use App\Form\HaieType;
use App\Repository\HaieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/haie')]
class HaieController extends AbstractController
{
    #[Route('/', name: 'haie_index', methods: ['GET'])]
    public function index(HaieRepository $haieRepository): Response
    {
        return $this->render('haie/index.html.twig', [
            'haies' => $haieRepository->findAll(),
        ]);
    }

    #[Route('/cate_add', name: 'cate_add')]
    public function add_catego(Request $request): Response
    {
        if ($request->isMethod('POST')){
            $categorie = new Categorie();
            $categorie->setLibelle($request->get('libelle'));
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($categorie);
            $entityManager->flush();
        }

        return $this->render('haie/categorie.html.twig', [
        ]);
    }

    #[Route('/new', name: 'haie_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $haie = new Haie();
        $form = $this->createForm(HaieType::class, $haie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($haie);
            $entityManager->flush();

            return $this->redirectToRoute('haie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('haie/new.html.twig', [
            'haie' => $haie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'haie_show', methods: ['GET'])]
    public function show(Haie $haie): Response
    {
        return $this->render('haie/show.html.twig', [
            'haie' => $haie,
        ]);
    }

    #[Route('/{id}/edit', name: 'haie_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Haie $haie): Response
    {
        $form = $this->createForm(HaieType::class, $haie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('haie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('haie/edit.html.twig', [
            'haie' => $haie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'haie_delete', methods: ['POST'])]
    public function delete(Request $request, Haie $haie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$haie->getCode(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($haie);
            $entityManager->flush();

        }

        return $this->redirectToRoute('haie_index', [], Response::HTTP_SEE_OTHER);
    }
}
