<?php

namespace Disjfa\PictureBundle\Controller\Api;

use Disjfa\PictureBundle\Entity\Picture;
use Disjfa\PictureBundle\Form\Type\PictureType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/picture")
 */
class PictureController extends Controller
{
    /**
     * @Route("/{picture}", name="disjfa_picture_api_picture_get", options={"expose": true})
     * @Method("GET")
     * @param Picture $picture
     * @return Response
     */
    public function getAction(Picture $picture)
    {
        return new JsonResponse([
            'picture' => $picture
        ]);
    }

    /**
     * @Route("/{picture}", name="disjfa_picture_api_picture_patch", options={"expose": true})
     * @Method("PATCH")
     * @param Picture $picture
     * @param Request $request
     * @return Response
     */
    public function patchAction(Picture $picture, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(PictureType::class, $picture);
        $form->submit($data);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse([
                'message' => 'saved',
                'picture' => $picture,
            ]);
        } else {
            return new JsonResponse([
                'message' => 'not saved',
                'errors' => $this->getErrorMessages($form),
            ], 400);
        }
    }

    private function getErrorMessages(Form $form)
    {
        $errors = array();

        foreach ($form->getErrors() as $key => $error) {
            if ($form->isRoot()) {
                $errors['#'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }

}
