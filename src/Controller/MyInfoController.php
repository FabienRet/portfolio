<?php

namespace App\Controller;

use App\Entity\MyInfo;
use App\Form\MyInfoType;
use App\Repository\MyInfoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *@Route("/admin/my/info")
 *@IsGranted("ROLE_ADMIN")
 */
class MyInfoController extends AbstractController
{
    /**
     * @Route("/{id}/edit", name="my_info_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MyInfo $myInfo): Response
    {
        $form = $this->createForm(MyInfoType::class, $myInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('modify_cv');
        }

        return $this->render('my_info/edit.html.twig', [
            'my_info' => $myInfo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="my_info_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MyInfo $myInfo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$myInfo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($myInfo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('my_info_index');
    }
}
