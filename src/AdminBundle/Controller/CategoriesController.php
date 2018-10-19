<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Form\CategoryType;

/**
 * Description of TransportController
 *
 * @author Steve-KOUNA
 */
class CategoriesController extends Controller {

    public function indexCategorieWorkAction($token) {
        $verify_token = $this->container->get('app.verify_token')->tokenTest($token, $this->container->getParameter('api_uri'));
        if ($verify_token) {
            $curl = curl_init();

            $headers = [
                "cache-control: no-cache",
                "content-type: application/json",
                "Authorization: Bearer " . $token
            ];

            $opts = [
                CURLOPT_URL => $this->container->getParameter('api_uri') . "/gallery/art-works/categories",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers
            ];

            curl_setopt_array($curl, $opts);
            $result = curl_exec($curl);
            $response = null;
            $response = json_decode($result, true);
            curl_close($curl);
            
            return $this->render('@Admin/Layouts/categories/indexWork.html.twig', [
                        'datas' => $response,
                        'token' => $token
            ]);
        }
        return $this->redirectToRoute('account_homepage');
    }

    public function showAction($id, $token) {
        $verify_token = $this->container->get('app.verify_token')->tokenTest($token, $this->container->getParameter('api_uri'));
        if ($verify_token) {
            $response = $this->getTransport($token, $id);

            return $this->render('@Admin/Layouts/transport/show.html.twig', [
                        'response' => $response,
                        'token' => $token
            ]);
        }
        return $this->redirectToRoute('account_homepage');
    }

    public function newCategorieWorkAction(Request $request, $token) {
        $verify_token = $this->container->get('app.verify_token')->tokenTest($token, $this->container->getParameter('api_uri'));
        if ($verify_token) {
            $form = $this->createForm(CategoryType::class);
            $form->handleRequest($request);

            if ($request->getMethod() == 'POST') {
                if ($form->isValid()) {
                    $curl = curl_init();
                    $data = $request->request->get('admin_category');
                    $headers = [
                        "cache-control: no-cache",
                        "content-type: application/json",
                        "Authorization: Bearer " . $token
                    ];

                    $opts = [
                        CURLOPT_URL => $this->container->getParameter('api_uri') . "/admin/gallery/art-works/categories",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => $headers,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => json_encode($data),
                    ];

                    curl_setopt_array($curl, $opts);
                    $result = curl_exec($curl);
                    $response = null;
                    $response = json_decode($result);
                    curl_close($curl);

                    return $this->redirectToRoute('categorie_work_index', ['token' => $token, 'id' => $response->id]);
                }
            }

            return $this->render('@Admin/Layouts/categories/addWork.html.twig', [
                        'form' => $form->createView(),
                        'token' => $token
            ]);
        }
        return $this->redirectToRoute('account_homepage');
    }

    public function editAction(Request $request, $token, $id) {
        $verify_token = $this->container->get('app.verify_token')->tokenTest($token, $this->container->getParameter('api_uri'));
        if ($verify_token) {
            $data = $this->getTransport($token, $id);
            $edit_form = $this->createForm(TransportType::class, $data);
            $edit_form->handleRequest($request);
            if ($request->getMethod() == 'POST') {
                if ($edit_form->isValid()) {
                    $data = $request->request->get('admin_transport');
                    $curl = curl_init();
                    $data = $request->request->get('admin_transport');
                    $headers = [
                        "cache-control: no-cache",
                        "content-type: application/json",
                        "Authorization: Bearer " . $token
                    ];

                    $opts = [
                        CURLOPT_URL => $this->container->getParameter('api_uri') . "/admin/gallery/transport/" . $id,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => $headers,
                        CURLOPT_PUT => true,
                        CURLOPT_POSTFIELDS => json_encode($data),
                    ];

                    curl_setopt_array($curl, $opts);
                    $result = curl_exec($curl);
                    $response = null;
                    $response = json_decode($result);
                    curl_close($curl);
                }
            }

            return $this->render('@Admin/Layouts/transport/edit.html.twig', [
                        'edit_form' => $edit_form->createView(),
                        'token' => $token
            ]);
        }
        return $this->redirectToRoute('account_homepage');
    }

    private function getTransport($token, $id) {

        $curl = curl_init();

        $headers = [
            "cache-control: no-cache",
            "content-type: application/json",
            "Authorization: Bearer " . $token
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

        return $response;
    }

}
