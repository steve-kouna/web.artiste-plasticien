<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Form\TransportType;

/**
 * Description of TransportController
 *
 * @author Steve-KOUNA
 */
class TransportController extends Controller {

    public function indexAction() {
        $session = new Session();
        $curl = curl_init();

        $headers = [
            "cache-control: no-cache",
            "content-type: application/json",
            "Authorization: Bearer " . $session->get('access_token')
        ];

        $opts = [
            CURLOPT_URL => $this->container->getParameter('api_uri') . "/gallery/transport",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        ];

        curl_setopt_array($curl, $opts);
        $result = curl_exec($curl);
        $response = null;
        $response = json_decode($result, true);
        curl_close($curl);

        return $this->render('@Admin/Layouts/transport/index.html.twig', [
                    'response' => $response
        ]);
    }

    public function showAction($id) {
        $session = new Session();
        $curl = curl_init();

        $headers = [
            "cache-control: no-cache",
            "content-type: application/json",
            "Authorization: Bearer " . $session->get('access_token')
        ];

        $opts = [
            CURLOPT_URL => $this->container->getParameter('api_uri') . "/gallery/transport/" . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        ];

        curl_setopt_array($curl, $opts);
        $result = curl_exec($curl);
        $response = null;
        $response = json_decode($result, true);
        curl_close($curl);

        return $this->render('@Admin/Layouts/transport/show.html.twig', [
                    'response' => $response
        ]);
    }

    public function newAction(Request $request) {
        $session = new Session();
//        die($session->get('access_token'));
        $form = $this->createForm(TransportType::class);
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST') {
            if ($form->isValid()) {
                $curl = curl_init();
                $headers = [
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "Authorization: Bearer " . $session->get('access_token')
                ];

                $opts = [
                    CURLOPT_URL => $this->container->getParameter('api_uri') . "/admin/gallery/transport",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => $headers,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($form->getData()),
                ];

                curl_setopt_array($curl, $opts);
                $result = curl_exec($curl);
                $response = null;
                $response = json_decode($result);
                curl_close($curl);
                
                dump($response);die();
            }
        }

        return $this->render('@Admin/Layouts/transport/add.html.twig', [
                    'form' => $form->createView()
        ]);
    }

}
