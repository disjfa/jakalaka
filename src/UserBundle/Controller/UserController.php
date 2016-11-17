<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use UserBundle\Form\Type\UserType;

/**
 * @Route("/users")
 */
class UserController extends Controller
{
    /**
     * @Route("", name="disjfa_user_user_index")
     */
    public function indexAction()
    {
        return $this->render('UserBundle:User:index.html.twig', [
            'users' => $this->get('fos_user.user_manager')->findUsers(),
        ]);
    }

    private function handleUserForm(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $user->setEnabled(true);
            $user->setPassword(uniqid());

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('disjfa_user_user_show', ['user' => $user->getId()]);
        }

        return $this->render('UserBundle:User:form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create", name="disjfa_user_user_create")
     */
    public function createAction(Request $request)
    {
        $user = $this->get('fos_user.user_manager')->createUser();
        return $this->handleUserForm($user, $request);
    }

    /**
     * @Route("/{user}", name="disjfa_user_user_show")
     */
    public function showAction(User $user)
    {
        return $this->render('UserBundle:User:show.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     * @Route("/{user}/edit", name="disjfa_user_user_edit")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function editAction(User $user, Request $request)
    {
        return $this->handleUserForm($user, $request);
    }
}
