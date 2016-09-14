<?php

namespace Disjfa\BuilderBundle\Controller;

use Disjfa\BuilderBundle\Entity\Builder;
use Disjfa\BuilderBundle\Form\Type\BuilderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/builder", name="disjfa_builder_builder_index")
 */
class BuilderController extends Controller
{
    /**
     * @Route("/", name="disjfa_builder_builder_index")
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('DisjfaBuilderBundle:Builder:index.html.twig', [
            'builders' => $this->getDoctrine()->getRepository(Builder::class)->findAll(),
        ]);
    }
    /**
     * @Route("/create", name="disjfa_builder_builder_create")
     * @return Response
     */
    public function createAction(Request $request)
    {
        $builder = new Builder($this->getUser());
        $form = $this->createForm(BuilderType::class, $builder);

        $form->handleRequest($request);
        if($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($builder);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('disjfa_builder_builder_show', ['builder' => $builder->getId()]);
        }

        return $this->render('DisjfaBuilderBundle:Builder:form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{builder}", name="disjfa_builder_builder_show")
     * @return Response
     */
    public function showAction(Builder $builder)
    {
        return $this->render('DisjfaBuilderBundle:Builder:show.html.twig', [
            'builder' => $builder,
        ]);
    }

    /**
     * @Route("/{builder}/edit", name="disjfa_builder_builder_edit")
     * @return Response
     */
    public function editAction(Builder $builder, Request $request)
    {
        $form = $this->createForm(BuilderType::class, $builder);

        $form->handleRequest($request);
        if($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($builder);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('disjfa_builder_builder_show', ['builder' => $builder->getId()]);
        }

        return $this->render('DisjfaBuilderBundle:Builder:form.html.twig', [
            'form' => $form->createView(),
            'builder' => $builder,
        ]);
    }
}
