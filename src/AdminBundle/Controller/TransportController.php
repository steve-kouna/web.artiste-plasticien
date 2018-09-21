<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of TransportController
 *
 * @author Steve-KOUNA
 */
class TransportController extends Controller {
    
    public function indexAction () {
        return $this->render('@Admin/Layouts/transport/index.html.twig');
    }
}
