<?php

namespace App\Controller;
use App\Entity\Technicien;
use App\Entity\Host;
use App\Form\TechnicienType;
use App\Repository\TechnicienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class TechnicienController extends AbstractController
{
   /**
     * @Route("/user/technicien/list", name="technicien_list")
     */
    public function technicien_list(TechnicienRepository $repo): Response
    {
         $techniciens=$repo->findAll();
        
        
        return $this->render('technicien/liste.html.twig', ['techniciens'=>$techniciens ]);
    }
    
    /**
     * Creates a new technicien entity.
     *
     * @Route("/admin/technicien/create", name="technicien.create", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     */
    public function create(Request $request, EntityManagerInterface $em) : Response
    {
        $technicien = new Technicien();
        $form = $this->createForm(TechnicienType::class, $technicien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($technicien);
            $em->flush();

            return $this->redirectToRoute('technicien_list');
        }

        return $this->render('technicien/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * Edit existing technicien entity
     *
     * @Route("/admin/technicien/{id}/edit/", name="technicien_edit", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param Technicien $technicien
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function edit(Request $request, Technicien $technicien) : Response
    {
        $form = $this->createForm(TechnicienType::class, $technicien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('technicien_list');
        }

        return $this->render('host/edit.html.twig', [
            'technicien' => $technicien,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/technicien/{id}/delete", name="technicien_delete", methods="DELETE")
     */
    public function delete(Request $request, Technicien $technicien): Response
    {
        if ($this->isCsrfTokenValid('delete'.$technicien->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($technicien);
            $entityManager->flush();
        }
        return $this->redirectToRoute('technicien_list');
        
    }
    /**
     * @Route("/admin/technicien/{id}", name="technicien_detail")
     */
    public function technicien_details(TechnicienRepository $repo,$id): Response
    {
         $technicien=$repo->find($id);

        
        return $this->render('technicien/detail.html.twig', ['t'=>$technicien ]);
    }
    /**
     * @Route("/user/technicien/panne/{id}", name="techpannes")
     */
    public function techpannes(TechnicienRepository $repo,Technicien $id): Response
    {
        // $host=$repo->find($id);
         $pannes=$id->getPannes();
        
        return $this->render('technicien/techpannes.html.twig', ['pannes'=>$pannes ]);
    }
    
}
