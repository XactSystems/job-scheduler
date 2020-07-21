<?php

namespace Xact\CommandScheduler\Tests;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class TestKernel extends Kernel
{
    use MicroKernelTrait;

    /**
     * @inheritDoc
     */
    public function registerBundles()
    {
        $bundles = [
            \Symfony\Bundle\FrameworkBundle\FrameworkBundle::class,
            \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class,
            \Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle::class,
            \Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class,
        ];

        foreach ($bundles as $class) {
            yield new $class();
        }
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $confDir = $this->getProjectDir().'/Resources/config';
        $routes->import($confDir.'/routing.yaml', '/', 'glob');
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        dump("configureContainer\n");
        //$c->setParameter('kernel.secret', '0034otj3nt9-43oj%');

        $confDir = $this->getProjectDir().'/Resources/config';
        $loader->load($confDir . '/{test}/*.yaml', 'glob');
        //$loader->load($confDir . '/test/framework.yaml');
        //$loader->load($confDir . '/test/doctrine.yaml');
        $loader->load($confDir . '/services.yaml');
        //dump($c->getParameterBag());
        dump($c->getServiceIds());
    }
}
