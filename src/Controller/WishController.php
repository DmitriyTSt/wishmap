<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wish")
 */
class WishController extends AbstractController
{
    /**
     * @Route("/", name="wish_index", methods={"GET"})
     */
    public function index(WishRepository $wishRepository): Response
    {
        return $this->render('wish/index.html.twig', [
            'wishes' => $wishRepository->findByUser($this->getUser()),
        ]);
    }

    /**
     * @Route("/new", name="wish_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $wish = new Wish();
        $wish->setUser($this->getUser());
        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($wish);
            $entityManager->flush();

            return $this->redirectToRoute('wish_index');
        }

        return $this->render('wish/new.html.twig', [
            'wish' => $wish,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wish_show", methods={"GET"})
     */
    public function show(Wish $wish): Response
    {
        return $this->render('wish/show.html.twig', [
            'wish' => $wish,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="wish_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Wish $wish): Response
    {
        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wish_index');
        }

        return $this->render('wish/edit.html.twig', [
            'wish' => $wish,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wish_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Wish $wish): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wish->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($wish);
            $entityManager->flush();
        }

        return $this->redirectToRoute('wish_index');
    }
}
