<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Sonata\MediaBundle\Controller\Api\GalleryController;
use Sonata\MediaBundle\Controller\Api\MediaController;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // Use "service" function for creating references to services when dropping support for Symfony 4.4
    $containerConfigurator->services()

        ->set('sonata.media.controller.api.gallery', GalleryController::class)
            ->public()
            ->args([
                new ReferenceConfigurator('sonata.media.manager.gallery'),
                new ReferenceConfigurator('sonata.media.manager.media'),
                new ReferenceConfigurator('form.factory'),
            ])

        ->set('sonata.media.controller.api.media', MediaController::class)
            ->public()
            ->args([
                new ReferenceConfigurator('sonata.media.manager.media'),
                new ReferenceConfigurator('sonata.media.pool'),
                new ReferenceConfigurator('form.factory'),
            ]);
};
