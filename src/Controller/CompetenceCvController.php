<?php

namespace App\Controller;

use App\Entity\CompetenceCv;
use App\Form\CompetenceCvType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/competence/cv")
 */
class CompetenceCvController extends AbstractController
{


    /**
     * @Route("/new", name="competence_cv_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $competenceCv = new CompetenceCv();
        $form = $this->createForm(CompetenceCvType::class, $competenceCv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competenceCv);
            $entityManager->flush();

            return $this->redirectToRoute('modify_cv');
        }

        return $this->render('competence_cv/new.html.twig', [
            'competence_cv' => $competenceCv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="competence_cv_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CompetenceCv $competenceCv): Response
    {
        $form = $this->createForm(CompetenceCvType::class, $competenceCv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('modify_cv');
        }

        return $this->render('competence_cv/edit.html.twig', [
            'competence_cv' => $competenceCv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="competence_cv_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CompetenceCv $competenceCv): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competenceCv->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($competenceCv);
            $entityManager->flush();
        }

        return $this->redirectToRoute('modify_cv');
    }
}
