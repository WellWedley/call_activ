<?php

namespace App\Controller;

use App\Entity\Squad;
use App\Entity\User;
use App\Form\SquadType;
use App\Repository\SquadRepository;
use Composer\DependencyResolver\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/squad', name: 'app_squad')]
class SquadController extends AbstractController
{
    /**
     * @param SquadRepository $squadRepository
     * 
     * @throws \Exception
     * 
     * @return Response
     */
    #[Route('/', name: '_show')]
    public function showSquads(SquadRepository $SquadRepository): Response
    {

        $squad = $SquadRepository->findAll();

        return $this->render('squad/show.html.twig',
            [
                'controller_name' => 'Mes Squads',
                'squad' => $squad ?: [],
            ]
        );
    }

    /**
     * @param Request                   $request
     * @param EntityManagerInterface    $em
     * @param User                      $user
     * 
     * @return Response
     */
    #[IsGranted('ROLE_USER', statusCode: 403, exceptionCode: 10010)]
    #[Route('/squad/add', name: 'app_squad_add')]
    public function addSquad(Request $request, EntityManagerInterface $em, #[CurrentUser] User $user): Response
    {
        $squad = new Squad();

        $form = $this->createForm(SquadType::class, $squad);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $squad = $form->getData();
            $squad->setName($squad->getName());
            $squad->addMember($user);

            $em->persist($squad);
            $em->flush();
        }

        return $this->render('squad/add.html.twig',
            [
                'controller_name' => 'Nouvelle Squad',
                "squad" => $squad,
                'form' => $form->createView()
            ]
        );
    }
}
