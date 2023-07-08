<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Mailjet\Resources ; 


class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {

        return $this->render('home/index.html.twig', [
            'controller_name' => 'Accueil',
        ]);
    }

    #[Route('send-email', name: 'send_email' )]
    public function send_email(): Response
    {
        
// getenv will allow us to get the MJ_APIKEY_PUBLIC/PRIVATE variables we created before:

$apikey = $_ENV['MJ_APIKEY_PUBLIC'];
$apisecret = $_ENV['MJ_APIKEY_PRIVATE'];

$mj = new \Mailjet\Client($apikey, $apisecret,true, ['version' => 'v3.1']);

$body = [
    'Messages' => [
        [
            'From' => [
                'Email' => "contact@webboxfactory.com",
                'Name' => "Me"
            ],
            'To' => [
                [
                    'Email' => "footwedley@gmail.com",
                    'Name' => "You"
                ]
            ],
            'Subject' => "My first Mailjet Email!",
            'TextPart' => "Greetings from Mailjet!",
            'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href=\"https://www.mailjet.com/\">Mailjet</a>!</h3>
            <br />May the delivery force be with you!"
        ]
    ]
];

// All resources are located in the Resources class

$response = $mj->post(Resources::$Email, ['body' => $body]);

// Read the response

$response->success() && var_dump($response->getData());
  return $this->render('home/index.html.twig', [
    'controller_name' => 'Accueil',
]);



    }





}

