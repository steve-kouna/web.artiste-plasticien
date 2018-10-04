<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller {

    public function indexAction($token) {
        $verify_token = $this->container->get('app.verify_token')->tokenTest($token, $this->container->getParameter('api_uri'));
        if ($verify_token) {
            return $this->render('@Admin/Layouts/dashboard/index.html.twig', [
                        'token' => $token
            ]);
        }
        return $this->redirectToRoute('account_homepage');
    }

}
