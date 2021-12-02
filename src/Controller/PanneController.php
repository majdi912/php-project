<?php

namespace App\Controller;
use App\Repository\PanneRepository;
use App\Entity\Panne;
use App\Form\PanneType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanneController extends AbstractController
{
   /**
     * @Route("/user/panne/list", name="panne_list")
     */
    public function panne_list(PanneRepository $repo): Response
    {
         $pannes=$repo->findAll();
        
        
        return $this->render('panne/liste.html.twig', ['pannes'=>$pannes ]);
    }
    /**
     * Creates a new panne entity.
     *
     * @Route("/admin/panne/create", name="panne.create", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     */
    public function create(Request $request, EntityManagerInterface $em) : Response
    {
        $panne = new Panne();
        $form = $this->createForm(PanneType::class, $panne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($panne);
            $em->flush();

            return $this->redirectToRoute('panne_list');
        }

        return $this->render('panne/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * Edit existing host entity
     *
     * @Route("/user/panne/{id}/edit/", name="panne_edit", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param Panne $panne
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function edit(Request $request, Panne $panne) : Response
    {
        $form = $this->createForm(PanneType::class, $panne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('panne_list');
        }

        return $this->render('panne/edit.html.twig', [
            'panne' => $panne,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/panne/{id}/delete", name="panne_delete", methods="DELETE")
     */
    public function delete(Request $request, Panne $panne): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panne->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($panne);
            $entityManager->flush();
        }
        return $this->redirectToRoute('panne_list');
        
    }
    
    /**
     * @Route("/user/panne/{id}", name="panne_detail")
     */
    public function panne_details(PanneRepository $repo,$id): Response
    {
         $panne=$repo->find($id);

        
        return $this->render('panne/detail.html.twig', ['p'=>$panne ]);
    }
    
    
    /**
     * @Route("/user/panne/hosts/{host}", name="panne_host")
     */
    public function pannehost(PanneRepository $repo,$host)
     {
        $pannes = $repo->myFindByHosts($host);
         
         
        return $this->render('panne/panne_host.html.twig', [
            'pannes' => $pannes
        ]);
    }
    

}