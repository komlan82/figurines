<?php

namespace App\EventListener;

use App\Entity\User;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

#[AsEventListener(event: LoginSuccessEvent::class)]
class LoginSuccessListener
{
    public function __invoke(LoginSuccessEvent $event): void
    {
        $user = $event->getUser();
        $session = $event->getRequest()->getSession();

        if ($user instanceof User && $session instanceof FlashBagAwareSessionInterface) {
            $session->getFlashBag()->add('primary', 'Bienvenue '.$user->getFirstname().' !');
        }
    }
}
