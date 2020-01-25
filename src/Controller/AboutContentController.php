<?php

namespace App\Controller;

use App\Entity\AboutContent;
use App\Form\AboutContentType;
use App\Repository\AboutContentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/about/content")
 */
class AboutContentController extends AbstractController
{
    /**
     * @Route("/", name="about_content_index", methods={"GET"})
     */
    public function index(AboutContentRepository $aboutContentRepository): Response
    {
        return $this->render('about_content/index.html.twig', [
            'about_contents' => $aboutContentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="about_content_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $aboutContent = new AboutContent();
        $form = $this->createForm(AboutContentType::class, $aboutContent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($aboutContent);
            $entityManager->flush();

            return $this->redirectToRoute('about_content_index');
        }

        return $this->render('about_content/new.html.twig', [
            'about_content' => $aboutContent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="about_content_show", methods={"GET"})
     */
    public function show(AboutContent $aboutContent): Response
    {
        return $this->render('about_content/show.html.twig', [
            'about_content' => $aboutContent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="about_content_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AboutContent $aboutContent): Response
    {
        $form = $this->createForm(AboutContentType::class, $aboutContent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('about_content_index');
        }

        return $this->render('about_content/edit.html.twig', [
            'about_content' => $aboutContent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="about_content_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AboutContent $aboutContent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aboutContent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($aboutContent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('about_content_index');
    }
}
