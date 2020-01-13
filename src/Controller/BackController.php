<?php

namespace App\Controller;

use App\Entity\CompetenceCv;
use App\Entity\CourseCv;
use App\Entity\MyInfo;
use App\Form\CompetenceCvForm;
use App\Form\CourseCvForm;
use App\Form\MyInfoFormType;
use App\Form\ProjectFormType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/** @IsGranted("ROLE_ADMIN") */
class BackController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('back/index.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }

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



            $this->addFlash('success', 'Article created! Knowledge is power !');


            return $this->redirect($this->generateUrl('admin'));
        }

        return $this->render('back/addproject.html.twig', [
            'projectForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/list", name="list_project")
     */
    public function list(ProjectRepository $projectRepository){
        $project = $projectRepository->findAll();

        return $this->render('back/list.html.twig', [
            'projects' => $project
        ]);
    }

    /**
     * @Route("/admin/myCV", name="modify_cv")
     */
    public function modifyCv(){
        return $this->render('back/modifyCv.html.twig');
    }

    /**
     * @Route("/admin/myInfo", name="modify_infos")
     */
    public function myInfosCv(Request $request, EntityManagerInterface $em){
        $form = $this->createForm(MyInfoFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            /** @var MyInfo $myInfos */
            $myInfos = $form->getData();
            $em->persist($myInfos);
            $em->flush();

            $this->addFlash('success', 'Article created! Knowledge is power !');

            return $this->redirectToRoute('admin');
        }

        return $this->render('back/myInfosCv.html.twig', [
            'myInfoForm' => $form->createView()
        ]);

        }


    /**
     * @Route("/admin/myCompetence", name="modify_competence")
     */
    public function competenceCv(Request $request, EntityManagerInterface $em){
        $form = $this->createForm(CompetenceCvForm::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            /** @var CompetenceCv $competence */
            $competence = $form->getData();
            $em->persist($competence);
            $em->flush();

            $this->addFlash('success', 'Article created! Knowledge is power !');

            return $this->redirectToRoute('admin');
        }

        return $this->render('back/modifyCompetence.html.twig', [
            'competenceForm' => $form->createView()
        ]);

    }


    /**
     * @Route("/admin/myCourse", name="modify_course")
     */
    public function courseCv(Request $request, EntityManagerInterface $em){
        $form = $this->createForm(CourseCvForm::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            /** @var CourseCv $courseCv */
            $courseCv = $form->getData();
            $em->persist($courseCv);
            $em->flush();

            $this->addFlash('success', 'Article created! Knowledge is power !');

            return $this->redirectToRoute('admin');
        }

        return $this->render('back/modifyCourse.html.twig', [
            'courseCvForm' => $form->createView()
        ]);

    }

}
