<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Form\MeasurementType;
use App\Repository\MeasurementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/measurement')]
final class MeasurementController extends AbstractController
{
    #[Route(name: 'app_measurement_index', methods: ['GET'])]
    public function index(MeasurementRepository $repository): Response
    {
        return $this->render('measurement/index.html.twig', [
            'measurements' => $repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_measurement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $measurement = new Measurement();
        $form = $this->createForm(MeasurementType::class, $measurement, [
            'validation_groups' => 'Default',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($measurement);
            $em->flush();

            return $this->redirectToRoute('app_measurement_index');
        }

        return $this->render('measurement/new.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_measurement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Measurement $measurement, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(MeasurementType::class, $measurement, [
            'validation_groups' => ['Default'],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_measurement_index');
        }

        return $this->render('measurement/edit.html.twig', [
            'form' => $form,
            'measurement' => $measurement,
        ]);
    }


    #[Route('/{id}', name: 'app_measurement_show', methods: ['GET'])]
    public function show(Measurement $measurement): Response
    {
        return $this->render('measurement/show.html.twig', [
            'measurement' => $measurement,
        ]);
    }


    #[Route('/{id}/delete', name: 'app_measurement_delete', methods: ['POST'])]
    public function delete(Request $request, Measurement $measurement, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$measurement->getId(), $request->getPayload()->getString('_token'))) {
            $em->remove($measurement);
            $em->flush();
        }

        return $this->redirectToRoute('app_measurement_index');
    }
}
