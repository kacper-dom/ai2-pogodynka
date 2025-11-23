<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TextInputType;

final class TextInputController extends AbstractController
{
    #[Route('/text/input', name: 'app_text_input')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(TextInputType::class);

        $form->handleRequest($request);

        $submittedText = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $submittedText = $form->getData()['text'];
        }

        return $this->render('text_input/index.html.twig', [
            'controller_name' => 'TextInputController',
            'form' => $form->createView(),
            'submittedText' => $submittedText,
        ]);
    }
}
