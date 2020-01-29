<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectFormType;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/admin/addProject", name="add_project")
     */
    public function addProject(Request $request, EntityManagerInterface $em){
        $form = $this->createForm(ProjectFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            /** @var UploadedFile $projectFile */
            $projectFile = $form['image']->getData();

            if($projectFile){
                $projectFilename = pathinfo($projectFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $projectFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$projectFile->guessExtension();

                try {
                    $projectFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e){

                }

            }

            $project = $form->getData();
            $project->setImageFilename($newFilename);
            $em->persist($project);
            $em->flush();



            $this->addFlash('success', 'Le projet a bien été créé !');


            return $this->redirect($this->generateUrl('admin'));
        }

        return $this->render('project/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="project_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Project $project, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(ProjectFormType::class, $project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $projectFile */
            $projectFile = $form['image']->getData();

            if($projectFile){
                $projectFilename = pathinfo($projectFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $projectFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$projectFile->guessExtension();

                try {
                    $projectFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e){

                }

            }
            $project = $form->getData();
            $project->setImageFilename($newFilename);
            $em->persist($project);
            $em->flush();
            $this->addFlash('success', 'Le projet a bien été modifié !');

            return $this->redirectToRoute('admin');
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="project_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Project $project): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($project);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Le projet a bien été supprimé !');

        return $this->redirectToRoute('admin');
    }
}
