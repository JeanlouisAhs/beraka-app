<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserConfirmation implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if ($user->isIsVerified()) {
            // the message passed to this exception is meant to be displayed to the user
            throw new CustomUserMessageAccountStatusException("Your user account is not verified. 
            Please check your email and confirm your account before {$user->getTokenRegistrationLifeTime()->format('d-m-Y-H-i')}");
        }

    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        // user account is expired, the user may be notified
//        if ($user->isExpired()) {
//            throw new AccountExpiredException('...');
//        }
    }
}