<?php

declare(strict_types=1);

namespace App\Blog;

use App\Blog\Controller\IndexController;
use Micro\Plugin\Http\Facade\HttpFacadeInterface;
use Micro\Plugin\Http\Plugin\RouteProviderPluginInterface;
use Micro\Plugin\Twig\Plugin\TwigTemplatePluginInterface;
use Micro\Plugin\Twig\Plugin\TwigTemplatePluginTrait;

class BlogPlugin implements RouteProviderPluginInterface, TwigTemplatePluginInterface
{
    use TwigTemplatePluginTrait;

    public function provideRoutes(HttpFacadeInterface $httpFacade): iterable
    {
        yield $httpFacade
            ->createRouteBuilder()
            ->setName('index')
            ->setUri('/')
            ->setController(IndexController::class)
            ->build();
    }
}
