<?php

namespace Disjfa\ProjectBundle\Controller;

use Disjfa\ProjectBundle\Entity\Project;
use Disjfa\ProjectBundle\Form\Type\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/projects")
 */
class ProjectController extends Controller
{
    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getProjectRepository()
    {
        return $this->getDoctrine()->getRepository(Project::class);
    }

    /**
     * @Route("/", name="disjfa_project_project_index")
     */
    public function indexAction()
    {
        return $this->render('DisjfaProjectBundle:Project:index.html.twig', [
            'projects' => $this->getProjectRepository()->findAll()
        ]);
    }

    /**
     * @Route("/create", name="disjfa_project_project_create")
     */
    public function createAction(Request $request)
    {
        $project = new Project($this->getUser());
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('disjfa_project_project_index');
        }

        return $this->render('DisjfaProjectBundle:Project:form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create/{project}/edit", name="disjfa_project_project_edit")
     * @param Request $request
     * @param Project $project
     * @return Response
     */
    public function editAction(Request $request, Project $project)
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('disjfa_project_project_index');
        }

        return $this->render('DisjfaProjectBundle:Project:form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
