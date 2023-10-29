<?php

namespace App\Controller;


use App\Entity\Squad;
use App\Entity\User;
use App\Form\SquadType;
use App\Repository\SquadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    #[IsGranted('ROLE_USER', statusCode: 403, exceptionCode: 10010)]
    public function index(Request $request, EntityManagerInterface $em, User $user): Response
    {
        $squad = new Squad();

        $form = $this->createForm(SquadType::class, $squad);
        $user = $this->getUser();


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $squad = $form->getData();
            $squad->setName($squad->getName());
            $squad->addMember($user);

            $em->persist($squad);
            $em->flush();
        }

        $formView = $form->createView();

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'formView' => $formView
        ]);
    }


    #[Route("/dashboard/show", name: "squad_show")]
    #[IsGranted('ROLE_USER', statusCode: 403, exceptionCode: 10010)]
    public function show(

        SquadRepository $SquadRepository,
    ) {

        $squad = $SquadRepository
            ->findAll();


        if (!$squad) {
            throw $this->createNotFoundException('Aucune squad à afficher pour le moment');
        }

        return $this
            ->render(
                'dashboard/show.html.twig',
                [

                    'squad' => $squad,

                ]
            );
    }


}
