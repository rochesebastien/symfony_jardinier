<?php

namespace App\Controller;

use App\Entity\Tailler;
use App\Entity\Haie;
use App\Entity\Devis;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class DevisController extends AbstractController
{

    #[Route('/devis/liste', name: 'devis_liste')]
    public function listeDevis(Request $request): Response
    { 
        $mesDevis = $this->getDoctrine()
            ->getRepository(Devis::class)
            ->findAll();
        
        return $this->render('devis/liste.html.twig', [
            'controller_name' => 'DevisController',
            'devis'=>$mesDevis,
        ]);
    }

    #[Route('/devis/{id}/delete', name: 'delete_devis', methods: ['GET'])]
    public function deleteDevis(Request $request, Devis $devis, Tailler $tailler): Response
    {
        if ($this->isCsrfTokenValid('delete'.$devis->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($devis);
            $entityManager->flush();

            $tailler = $this->getDoctrine()->getRepository(Tailler::class)->findBy(['id' => $devis->getId()]);
            foreach ($tailler as $key) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($key);
                $entityManager->flush();
            }

        }

        return $this->redirectToRoute('devis_liste', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/devis', name: 'devis')]
    public function index(Request $request): Response
    { 
        $mesHaies = $this->getDoctrine()
            ->getRepository(Haie::class)
            ->findAll();

            // Session initialisation
            $session = new Session();
            if($session->get('kart')){
                $kart = $session->get('kart');
            } else {
                $kart = array();
            }     

        if($request->isMethod('POST')){
            $haie_id = $request->get('haie_select_devis');
            $haie = $this->getDoctrine()->getRepository(Haie::class)->find($haie_id);

            $tailler = new Tailler();
            $tailler->setHauteur($request->get('hauteur'));
            $tailler->setLongueur($request->get('longueur'));
            $tailler->setHaie($haie);

            array_push($kart,$tailler);
            $session->set('kart',$kart);
        }

        $prixTotal= 0;
         foreach ($kart as $product) {
                    if($product->getHauteur() > 1.5) {
                        $prixTotal = $prixTotal + $product->getHaie()->getPrix() * $product->getLongueur()*1.5;
                    } else {
                        $prixTotal = $prixTotal + $product->getHaie()->getPrix() * $product->getLongueur();
                    }
                   
                }
  
        
        return $this->render('devis/index.html.twig', [
            'controller_name' => 'DevisController',
            'haies'=>$mesHaies,
            'taillers'=>$kart,
            'prixT'=>$prixTotal,
        ]);
    }

    #[Route('/devis/remove/{id}', name: 'devis_remove',methods: ['GET'])]
    public function devis_remove(Request $request,string $id): Response
    {
        
        if($request->isMethod('GET')){
            $session = new Session();
            $kart =$session->get('kart'); 
            for ($i=0; $i < count($kart); $i++) { 
                if($i == $id){
                    unset($kart[$i]);
                }
            }
            $kart = array_values($kart);
            $session->remove('kart');
            $session->set('kart',$kart);
            
           
        }  
        return $this->redirectToRoute('devis');  
    }


    #[Route('/devis/validation', name: 'devis_add')]
    public function devis_valid(Request $request,AuthenticationUtils $authenticationUtils): Response
    {

        if ($request->isMethod('POST')){
        $entityManager = $this->getDoctrine()->getManager();
        $date = date("d/m/Y");
        $session = new Session();
        if($session->get('kart')){
            $kart = $session->get('kart');
            $prixT = 0;
            foreach($kart as $haie ){
                if($haie->getHauteur() > 1.5){
                    $prixT = $prixT + $haie->getHaie()->getPrix() * $haie->getLongueur() * 1.5;
                } else {
                    $prixT = $prixT + $haie->getHaie()->getPrix() * $haie->getLongueur();
                }
                     
            }
            if($this->getUser()->getTypeClient()){
                $prixT =  $prixT - $prixT * 0.1;
            }

            $devis = new Devis();
            date_default_timezone_set('Europe/Paris');
            $devis->setDate(new DateTime());
            $devis->setPrix($prixT);
            $devis->setUtilisateur($this->getUser());
            $entityManager->persist($devis);
            $entityManager->flush();
           
            foreach ($kart as $haie) {
                $tailler = new Tailler();
                $tailler->setHauteur($haie->getHauteur());
                $tailler->setLongueur($haie->getLongueur());
                $tailler->setHaie($haie->getHaie());
                $tailler->setDevis($devis);
               
                $entityManager->merge($tailler);
                $entityManager->flush();                   
            }

            $kart = $session->remove('kart');
        } else {
            return $this->redirectToRoute('devis');
        }


        }
        return $this->render('devis/validation.html.twig', [
            'controller_name' => 'Mon devis',
            'haies'=> $kart,
            'prixT'=>$prixT,
            'date'=>$date,
        ]);
    }
}
