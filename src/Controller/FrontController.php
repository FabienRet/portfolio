<?php

namespace App\Controller;

use App\Entity\Email;
use App\Form\EmailFormType;
use App\Repository\AboutContentRepository;
use App\Repository\CompetenceCvRepository;
use App\Repository\CourseCvRepository;
use App\Repository\MyInfoRepository;
use App\Repository\ProjectRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front")
     */
    public function index(ProjectRepository $projectRepository, Request $request, \Swift_Mailer $mailer, AboutContentRepository $aboutContentRepository, PaginatorInterface $paginator)
    {
        $myProject = $projectRepository->findAll();
        $pagination = $paginator->paginate(
            $myProject,
            $request->query->getInt('page', 1), 6
        );
        $email = new Email();
        $form = $this->createForm(EmailFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $message = (new \Swift_Message($data->getTitle()))
                ->setFrom($data->getEmail())
                ->setTo('fabienretailleau@hotmail.fr')
                ->setBody(
                    $this->renderView('back/email.html.twig',[
                        'title'=> $data->getTitle(),
                        'name' => $data->getName(),
                        'content' => $data->getContent(),
                        'emails' => $data->getEmail()
                    ]),
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('success', 'Votre mesage a bien été envoyé !');

            return $this->redirectToRoute('front');
        }

        $about = $aboutContentRepository->findAll();
        //
        return $this->render('front/index.html.twig', [
            'myProjects' => $pagination,
            'emails' => $email,
            'about_contents' => $about,
            'form' =>$form->createView()
        ]);
    }

    /**
     * @Route("/cv", name="cv")
     */
    public function cv(MyInfoRepository $myInfoRepository, CourseCvRepository $courseCvRepository, CompetenceCvRepository $competenceCvRepository){

        $myCompetences = $competenceCvRepository->findAll();
        $myInfos = $myInfoRepository->findAll();
        $myCourses = $courseCvRepository->findBy(array(), array('date_end' => 'DESC'));
        return $this->render('front/cv.html.twig', [
            'myInfos' => $myInfos,
            'myCourses' => $myCourses,
            'myCompetences' => $myCompetences
        ]);
    }
}
