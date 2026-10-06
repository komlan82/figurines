<?php

namespace App\Controller;

use App\Entity\Figurine;
use App\Entity\User;
use App\Form\FigurineType;
use App\Repository\FigurineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class FigurineController extends AbstractController
{
    #[Route('/figurine', name: 'app_figurine_index')]
    public function index(FigurineRepository $figurineRepository): Response
    {
        return $this->render('figurine/index.html.twig', [
            'figurines' => $figurineRepository->findAllWithUser(),
        ]);
    }

    
    #[Route('/figurine/create', name: 'app_figurine_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $figurine = new Figurine();
        /** @var User $user */
        $user = $this->getUser();
        $figurine->setUser($user);

        $form = $this->createForm(FigurineType::class, $figurine, ['image_required' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($figurine);
            $em->flush();

            $this->addFlash('success', 'Figurine créée avec succès !');

            return $this->redirectToRoute('app_figurine_show', ['id' => $figurine->getId()]);
        }

        return $this->render('figurine/create.html.twig', ['form' => $form]);
    }

    #[Route('/figurine/{id}', name: 'app_figurine_show', requirements: ['id' => '\d+'])]
    public function show(Figurine $figurine): Response
    {
        return $this->render('figurine/show.html.twig', ['figurine' => $figurine]);
    }

    #[Route('/figurine/{id}/edit', name: 'app_figurine_edit', requirements: ['id' => '\d+'])]
    public function edit(Figurine $figurine, Request $request, EntityManagerInterface $em): Response
    {
        if ($redirect = $this->denyIfNotOwner($figurine)) {
            return $redirect;
        }

        $form = $this->createForm(FigurineType::class, $figurine, ['image_required' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Figurine modifiée avec succès !');

            return $this->redirectToRoute('app_figurine_show', ['id' => $figurine->getId()]);
        }

        return $this->render('figurine/edit.html.twig', [
            'figurine' => $figurine,
            'form' => $form,
        ]);
    }

   
    #[Route('/figurine/{id}/delete', name: 'app_figurine_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Figurine $figurine, Request $request, EntityManagerInterface $em): Response
    {
        if ($redirect = $this->denyIfNotOwner($figurine)) {
            return $redirect;
        }

        if (!$this->isCsrfTokenValid('delete'.$figurine->getId(), (string) $request->getPayload()->get('_token'))) {
            $this->addFlash('danger', 'Jeton de sécurité invalide, suppression annulée.');

            return $this->redirectToRoute('app_figurine_show', ['id' => $figurine->getId()]);
        }

        $em->remove($figurine);
        $em->flush();

        $this->addFlash('danger', 'Figurine supprimée avec succès.');

        return $this->redirectToRoute('app_figurine_index');
    }

    /**
     * Un utilisateur ne peut modifier / supprimer que SES figurines.
     * Retourne une redirection (avec message rouge) si ce n'est pas le cas, sinon null.
     */
    private function denyIfNotOwner(Figurine $figurine): ?RedirectResponse
    {
        if ($figurine->getUser() !== $this->getUser()) {
            $this->addFlash('danger', 'Vous ne pouvez modifier ou supprimer que vos propres figurines.');

            return $this->redirectToRoute('app_figurine_show', ['id' => $figurine->getId()]);
        }

        return null;
    }
}
