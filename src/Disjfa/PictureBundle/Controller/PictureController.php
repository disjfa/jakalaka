<?php

namespace Disjfa\PictureBundle\Controller;

use Disjfa\PictureBundle\Entity\Picture;
use Disjfa\PictureBundle\Form\Type\PictureType;
use Imagick;
use Intervention\Image\AbstractColor;
use Intervention\Image\AbstractFont;
use Intervention\Image\AbstractShape;
use Intervention\Image\Gd\Shapes\RectangleShape;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Imagick\Color;
use Intervention\Image\Imagick\Font;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/picture")
 */
class PictureController extends Controller
{
    /**
     * @Route("/", name="disjfa_picture_picture_index")
     */
    public function indexAction()
    {
        return $this->render('DisjfaPictureBundle:Picture:index.html.twig', [
            'pictures' => $this->getDoctrine()->getRepository(Picture::class)->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="disjfa_picture_picture_create")
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request)
    {
        $picture = new Picture($this->getUser());
        $form = $this->createForm(PictureType::class, $picture);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($picture);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('disjfa_picture_picture_show', ['picture' => $picture->getId()]);
        }

        return $this->render('DisjfaPictureBundle:Picture:form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{picture}/edit", name="disjfa_picture_picture_edit")
     * @param Picture $picture
     * @param Request $request
     * @return Response
     */
    public function editAction(Picture $picture, Request $request)
    {
        $form = $this->createForm(PictureType::class, $picture);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($picture);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('disjfa_picture_picture_show', ['picture' => $picture->getId()]);
        }

        return $this->render('DisjfaPictureBundle:Picture:form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{picture}/preview", name="disjfa_picture_picture_preview")
     */
    public function previewAction(Picture $picture)
    {
        $manager = new ImageManager(array('driver' => 'imagick'));
        $image = $manager->canvas($picture->getWidth(), $picture->getHeight());

        foreach ($picture->getElements() as $element) {
            $styles = $element->getStyles();

            $padding = 0;
            $shape = $manager->canvas($styles['width'] + $padding + $padding, $styles['height'] + $padding + $padding, '#FFF');

            $shape->rectangle($padding, $padding, $padding + $styles['width'], $padding + $styles['height'], function (AbstractShape $shape) use ($styles) {
                $shape->background($styles['backgroundColor']);
            });

            if (array_key_exists('opacity', $styles)) {
                $shape->opacity($styles['opacity'] * 100);
            }

            $left = array_key_exists('left', $styles) ? (int)$styles['left'] : 0;
            $top = array_key_exists('top', $styles) ? (int)$styles['top'] : 0;

            $image->insert($shape, null, $left - $padding, $top - $padding);
            $shape->destroy();
        }

        echo $image->response('jpg');
        exit;
    }

    /**
     * @Route("/{picture}", name="disjfa_picture_picture_show")
     */
    public function showAction(Picture $picture)
    {
        return $this->render('DisjfaPictureBundle:Picture:picture.html.twig', [
            'picture' => $picture,
        ]);
    }
}
