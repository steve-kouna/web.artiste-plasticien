<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Admin/Layouts/dashboard/index.html.twig');
    }
}
