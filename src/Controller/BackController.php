<?php

namespace App\Controller;


use App\Repository\AboutContentRepository;
use App\Repository\CompetenceCvRepository;
use App\Repository\CourseCvRepository;
use App\Repository\MyInfoRepository;
use App\Repository\ProjectRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/** @IsGranted("ROLE_ADMIN") */
class BackController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(ProjectRepository $projectRepository, MyInfoRepository $myInfoRepository, CompetenceCvRepository $competenceCvRepository, CourseCvRepository $courseCvRepository, AboutContentRepository $aboutContentRepository, ValidatorInterface $validator)
    {
        $about = $aboutContentRepository->findAll();
        $my_infos = $myInfoRepository->findAll();
        $myCompetences = $competenceCvRepository->findAll();
        $myCourse = $courseCvRepository->findAll();
        $projects = $projectRepository->findAll();
        return $this->render('back/index.html.twig', [
            'about_contents' => $about,
            'projects' => $projects,
            'my_infos' => $my_infos,
            'competence_cvs' => $myCompetences,
            'course_cvs' => $myCourse
        ]);
    }
}
