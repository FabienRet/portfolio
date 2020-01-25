<?php

namespace App\Controller;

use App\Entity\CourseCv;
use App\Form\CourseCvType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/course/cv")
 * @IsGranted("ROLE_ADMIN")
 */
class CourseCvController extends AbstractController
{

    /**
     * @Route("/new", name="course_cv_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $courseCv = new CourseCv();
        $form = $this->createForm(CourseCvType::class, $courseCv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($courseCv);
            $entityManager->flush();

            return $this->redirectToRoute('modify_cv');
        }

        return $this->render('course_cv/new.html.twig', [
            'course_cv' => $courseCv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="course_cv_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CourseCv $courseCv): Response
    {
        $form = $this->createForm(CourseCvType::class, $courseCv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('modify_cv');
        }

        return $this->render('course_cv/edit.html.twig', [
            'course_cv' => $courseCv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="course_cv_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CourseCv $courseCv): Response
    {
        if ($this->isCsrfTokenValid('delete'.$courseCv->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($courseCv);
            $entityManager->flush();
        }

        return $this->redirectToRoute('modify_cv');
    }
}
