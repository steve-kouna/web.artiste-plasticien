<?php

namespace AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use AccountBundle\Form\LoginType;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller {

    public function LoginAction(Request $request) {
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST') {
            if ($form->isValid()) {
                $curl = curl_init();
                $data = $request->request->get('accountbundle_login');
                
                $uri = $this->container->getParameter('api_uri') . "/oauth/v2/token?client_id=" . $this->container->getParameter('client_id') . "&client_secret=" . $this->container->getParameter('client_secret') . "&grant_type=password&redirect_uri=" . $this->container->getParameter('redirect_uri') . "&username=" . $data['username'] . "&password=" . $data['password'];

                $timeout = 30;

                $headers = [
                    "cache-control: no-cache",
                    "content-type: application/json",
                ];

                $options = [
                    CURLOPT_URL => trim($uri),
                    CURLOPT_FRESH_CONNECT => true,
                    CURLOPT_TIMEOUT => $timeout,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CONNECTTIMEOUT => 0,
                    CURLOPT_HEADER => FALSE,
                    CURLOPT_HTTPHEADER => $headers
                ];

                curl_setopt_array($curl, $options);

                $page_content = curl_exec($curl);
                $info = curl_getinfo($curl);

                if ($info['http_code'] == 200) {
                    $dataJson = json_decode($page_content, true);
//                    
//                    $session->set('access_token', $dataJson['access_token']);
//                    $session->set('expires_in', $dataJson['expires_in']);
//                    $session->set('refresh_token', $dataJson['refresh_token']);

                    curl_close($curl);

                    return $this->redirectToRoute('transport_add', ['token' => $dataJson['access_token']]);
                }
            }
        }

        return $this->render('@Account/Layouts/login.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

}
