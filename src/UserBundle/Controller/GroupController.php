<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Group;
use UserBundle\Entity\User;
use UserBundle\Form\Type\GroupType;
use UserBundle\Form\Type\UserType;

/**
 * @Route("/user-groups")
 */
class GroupController extends Controller
{
    /**
     * @Route("", name="disjfa_user_group_index")
     */
    public function indexAction()
    {
        return $this->render('UserBundle:Group:index.html.twig', [
            'groups' => $this->getDoctrine()->getRepository(Group::class)->findAll(),
        ]);
    }

    /**
     * @param Group $group
     * @param Request $request
     * @return Response
     */
    private function handleUserForm(Group $group, Request $request)
    {
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);
        if ($form->isValid()) {

            $this->getDoctrine()->getManager()->persist($group);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('disjfa_user_group_show', ['group' => $group->getId()]);
        }

        return $this->render('UserBundle:Group:form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create", name="disjfa_user_group_create")
     */
    public function createAction(Request $request)
    {
        $group = new Group('');
        return $this->handleUserForm($group, $request);
    }

    /**
     * @Route("/{group}", name="disjfa_user_group_show")
     */
    public function showAction(Group $group)
    {
        return $this->render('UserBundle:Group:show.html.twig', [
            'group' => $group,
        ]);
    }


    /**
     * @Route("/{group}/edit", name="disjfa_user_group_edit")
     * @param Group $group
     * @param Request $request
     * @return Response
     */
    public function editAction(Group $group, Request $request)
    {
        return $this->handleUserForm($group, $request);
    }
}
