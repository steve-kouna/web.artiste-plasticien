<?php

namespace GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller {

    public function indexAction() {
        $curl = curl_init();

        $headers = [
            "cache-control: no-cache",
            "content-type: application/json",
        ];

        $opts = [
            CURLOPT_URL => $this->container->getParameter('api_uri') . "/gallery/art-works",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        ];

        curl_setopt_array($curl, $opts);
        $result = curl_exec($curl);
        $response = null;
        $response = json_decode($result, true);
        curl_close($curl);

        return $this->render('@Gallery/Layouts/home/index.html.twig', [
            'works' => $response
        ]);
    }

}
