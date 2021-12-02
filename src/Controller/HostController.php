<?php

namespace App\Controller;
use App\Repository\HostRepository;
use App\Entity\Host;
use App\Form\HostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\InputStream;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use steevanb\SSH2Bundle\Entity\Profile;
use steevanb\SSH2Bundle\Entity\Connection;


class HostController extends AbstractController
{
    
    /**
     * @Route("/user/host/list", name="host_list")
     */
    public function host_list(HostRepository $repo): Response
    {
         $hosts=$repo->findAll();
        
        
        return $this->render('host/list.html.twig', ['hosts'=>$hosts ]);
    }
     
    /**
     * @Route("/user/home", name="home")
     */
    public function home(HostRepository $repo): Response
    {
         $hosts=$repo->findAll();
        
        
        return $this->render('host/home.html.twig', ['hosts'=>$hosts ]);
    }
    
    /**
     * Creates a new host entity.
     *
     * @Route("/admin/host/create", name="host.create", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse|Response
     */
    public function create(Request $request, EntityManagerInterface $em) : Response
    {
        $host = new Host();
        $form = $this->createForm(HostType::class, $host);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($host);
            $em->flush();

            return $this->redirectToRoute('host_list');
        }

        return $this->render('host/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * Edit existing host entity
     *
     * @Route("/admin/host/{id}/edit/", name="host_edit", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param Host $host
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function edit(Request $request, Host $host) : Response
    {
        $form = $this->createForm(HostType::class, $host);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('host_list');
        }

        return $this->render('host/edit.html.twig', [
            'host' => $host,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/host/{id}/delete", name="host_delete", methods="DELETE")
     */
    public function delete(Request $request, Host $host): Response
    {
        if ($this->isCsrfTokenValid('delete'.$host->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($host);
            $entityManager->flush();
        }
        return $this->redirectToRoute('host_list');
        
    }
    /**
     * @Route("/user/host/{id}", name="host_detail", methods={"GET"})
     */
    public function host_details(HostRepository $repo,$id): Response
    {
         $host=$repo->find($id);

        
        return $this->render('host/detail.html.twig', ['h'=>$host ]);
    }
    
    
    /**
     * @Route("/admin/host/panne/{id}", name="hostpannes")
     */
    public function hostpannes(HostRepository $repo,Host $id): Response
    {
        // $host=$repo->find($id);
         $pannes=$id->getPannes();
        
        return $this->render('host/hostpannes.html.twig', ['pannes'=>$pannes ]);
    }
    /**
     * @Route("/user/host/ping/{id}", name="ping_host")
     */
    function ping(Host $id,EntityManagerInterface $em): Response
     {
         
       
            $ip = $id->getIp();
            $timeout = 3;
            $ping = new \JJG\Ping($ip,$timeout);
            $latency = $ping->ping();
            if ($latency !== false) {
            $stat='up';
            $id->setStatus('up');
            }
            else {
                $stat='down';
                $id->setStatus('down');

            }
            $em->persist($id);
            $em->flush();
        
            return $this->redirectToRoute('host_list');

    }
    /**
     * @Route("/admin/host/ping2/kk", name="ping2_host")
     */
    function pingall(EntityManagerInterface $em,HostRepository $repo,MailerInterface $mailer): Response
     {
         
            $hosts=$repo->findAll();
            $list="les hosts non connectées au réseau sont :";

            foreach($hosts as $host)
            {     
                $ip = $host->getIp();
                $timeout = 3;
                $ping = new \JJG\Ping($ip,$timeout);
                $latency = $ping->ping();
                if ($latency !== false) {
                $stat='up';
                $host->setStatus('up');
                }
                else {
                    $stat='down';
                    $host->setStatus('down');    
                    $list.= $ip;
                    $list.= ',,,,,';

                        
                }
                    $em->persist($host);
                    $em->flush();

            }

            $email = (new Email())
            ->from('')
            ->to('')

            ->subject('alert!')
            ->text('alert')
            ->html($list);

            $mailer->send($email);   
            return $this->redirectToRoute('host_list');

    }
    /**
     * @Route("/admin/host/{id}/reboot", name="reboot_host")
     */
    function commande(Host $host)
     {
            $ip = $host->getIp();

                    # create connection profile
            $profile = new Profile($ip, 'osboxes', '123');
            # create connection, and connect
            $connection = new Connection($profile);
            # exec command, and return it's output as string
            $connection->exec('sudo reboot now');

           return $this->render('host/commande.html.twig', ['result'=>$ip ]);

    }
     /**
     * @Route("/email")
     */
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('cc@example.com')
            ->to('cc@example.com')
            
            ->subject('alert!')
            ->text('message')
            ->html('<p>message</p>');

        $mailer->send($email);

        return $this->redirectToRoute('host_list');

    }
}
