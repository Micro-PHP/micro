<?php

declare(strict_types=1);

namespace App\Blog\Controller;

use Micro\Plugin\Twig\TwigFacadeInterface;
use Symfony\Component\HttpFoundation\Response;

readonly class IndexController
{
    public function __construct(private TwigFacadeInterface $twigFacade)
    {
    }

    public function index(): Response
    {
        return new Response($this->twigFacade->render('@BlogPlugin/index.html.twig', []));
    }
}
