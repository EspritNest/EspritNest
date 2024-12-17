<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailTestController extends AbstractController
{
    #[Route('/email/test', name: 'app_email_test')]
    public function index(): Response
    {
        return $this->render('email_test/index.html.twig', [
            'controller_name' => 'EmailTestController',
        ]);
    }
    #[Route('/test-email', name: 'app_email_test')]
    public function testEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('rayenguedri24@gmail.com')
            ->to('rayen.guedri@esprit.tn') // Use a test recipient email
            ->subject('Test Email from Symfony Mailer')
            ->html('<p>This is a test email sent via Symfony Mailer and Gmail SMTP.</p>');

        // Send the email
        $mailer->send($email);
       
        return $this->json([
            'message' => 'Email sent successfully!',
        ]);
    }
}
