<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/client')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository,Request $request): Response
    {
        if($request->get('error') == 1){
            $error = true;
        } else {
            $error = false;
        }
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'error' => $error,
        ]);
    }

    #[Route('/new', name: 'user_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET','POST'])]
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form, 
            // 'registrationForm' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            try {
                $entityManager->remove($user);
                $entityManager->flush();
                return $this->redirectToRoute('user_index', [
                    'error'=>false,
                ], Response::HTTP_SEE_OTHER);
            } catch (\Throwable $th) {
                return $this->redirectToRoute('user_index', [
                    'error'=>true,
                ], Response::HTTP_SEE_OTHER);
            }
            
        }

        
    }

    #[Route('/', name: 'user_search', methods: ['POST'])]
    public function search(UserRepository $userRepository): Response
    {
        $request = Request::createFromGlobals();
        $user_recherche=$request->get('search_user');
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findBy(['nom' => $user_recherche]),
            'error'=>false,
        ]);
    }
}
