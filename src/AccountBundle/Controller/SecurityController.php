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
                    $roles = $this->getRolesAction($dataJson['access_token']);

                    if (is_array($roles)) {
                        if (in_array('ROLE_ADMIN', $roles)) {
                            return $this->redirectToRoute('dashboard', ['token' => $dataJson['access_token']]);
                        } elseif (in_array('ROLE_GALLERY', $roles) || in_array('ROLE_GALLERY_ADMIN', $roles)) {
                            return $this->redirectToRoute('dashboard', ['token' => $dataJson['access_token']]);
                        } elseif (in_array('ROLE_AUTHOR', $roles)) {
                            return $this->redirectToRoute('dashboard', ['token' => $dataJson['access_token']]);
                        } else {
                            $referer = $this->getRequest()->headers->get('referer');
                            return $this->redirect($referer);
                        }
                    }
                }
            }
        }

        return $this->render('@Account/Layouts/login.html.twig', [
                    'form' => $form->createView()
                        ]
        );
    }

    public function getAccountAction($token) {
        $response = $this->getAccount($token);
        
        $data = $response['data'];

        return $data;
    }

    public function getRolesAction($token) {
        $response = $this->getAccount($token);
        
        $data = $response['data'];

        return $data['roles'];
    }
    
    private function getAccount($token) {
        $curl = curl_init();

        $headers = [
            "cache-control: no-cache",
            "content-type: application/json",
            "Authorization: Bearer " . $token
        ];

        $opts = [
            CURLOPT_URL => $this->container->getParameter('api_uri') . "/admin/account/profile",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        ];

        curl_setopt_array($curl, $opts);
        $result = curl_exec($curl);
        $response = null;
        $response = json_decode($result, true);
        curl_close($curl);
        
        return $response;
    }
}





