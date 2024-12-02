<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Bundle\SecurityBundle\Security;

final class LoginSuccessListener
{
    private RouterInterface $router;
    private Security $security;

    public function __construct(RouterInterface $router, Security $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    #[AsEventListener(event: 'security.interactive_login')]
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $user = $this->security->getUser();
        $roles = $user->getRoles();
        $response = $event->getRequest()->getSession()->get('_security.main.target_path');

        if (in_array('ROLE_ADMIN', $roles, true)) {
            $response = new RedirectResponse($this->router->generate('app_admin'));
        } elseif (in_array('ROLE_USER', $roles, true)) {
            $response = new RedirectResponse($this->router->generate('app_front'));
        }

        $event->getRequest()->getSession()->set('_security.main.target_path', $response->getTargetUrl());
    }
}
