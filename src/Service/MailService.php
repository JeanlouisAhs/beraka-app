<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailService
{

    private MailerInterface $mailerInterface;

    public function __construct(MailerInterface $mailerInterface)
    {
        $this->mailerInterface = $mailerInterface;
    }

    /**
     * @throws  TransportExceptionInterface
     */
    public function send(
        string $to,
        string $subject,
        string $templateTwig,
        array $context ): void
    {
        $email=(new TemplatedEmail())
            ->from(new Address('noreply@beraka.com','Beraka'))
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("mails/$templateTwig")
            ->context($context);
        try {
            $this->mailerInterface->send($email);
        } catch (TransportExceptionInterface $transportException) {
            /** @var TransportExceptionInterface $transportException */
            throw $transportException;
        }
    }

}