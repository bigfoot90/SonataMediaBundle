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

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sonata\Doctrine\Model\ManagerInterface;
use Sonata\MediaBundle\Model\Media;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Sonata\MediaBundle\Provider\Pool;
use Sonata\MediaBundle\Twig\Extension\MediaExtension;
use Twig\Environment;
use Twig\Template;
use Twig\TemplateWrapper;

/**
 * @author Geza Buza <bghome@gmail.com>
 */
class MediaExtensionTest extends TestCase
{
    /**
     * @var MockObject&MediaProviderInterface
     */
    private $provider;

    /**
     * @var MockObject&Template
     */
    private $template;

    /**
     * @var TemplateWrapper
     */
    private $templateWrapper;

    /**
     * @var MockObject&Environment
     */
    private $environment;

    /**
     * @var MockObject&Media
     */
    private $media;

    public function testThumbnailHasAllNecessaryAttributes(): void
    {
        $mediaExtension = new MediaExtension($this->getMediaPool(), $this->getMediaManager(), $this->getEnvironment());

        $media = $this->getMedia();
        $format = 'png';
        $options = [
            'title' => 'Test title',
            'alt' => 'Test title',
        ];

        $provider = $this->getProvider();
        $provider->method('getTemplate')->with('helper_thumbnail')->willReturn('template');
        $provider->expects(self::once())->method('generatePublicUrl')->with($media, $format)
            ->willReturn('http://some.url.com');

        $template = $this->getTemplate();
        $template->expects(self::once())
            ->method('render')
            ->with(
                [
                    'media' => $media,
                    'options' => [
                        'title' => 'Test title',
                        'alt' => 'Test title',
                        'src' => 'http://some.url.com',
                    ],
                ]
            )
            ->willReturn('rendered thumbnail');

        $mediaExtension->thumbnail($media, $format, $options);
    }

    /**
     * @return Pool
     */
    public function getMediaPool(): object
    {
        $mediaPool = new Pool('default');
        $mediaPool->addProvider('provider', $this->getProvider());

        return $mediaPool;
    }

    /**
     * @return MockObject&ManagerInterface<MediaInterface>
     */
    public function getMediaManager(): object
    {
        return $this->createMock(ManagerInterface::class);
    }

    /**
     * @return MockObject&MediaProviderInterface
     */
    public function getProvider(): object
    {
        if (null === $this->provider) {
            $this->provider = $this->createMock(MediaProviderInterface::class);
            $this->provider->method('getFormatName')->willReturnArgument(1);
            $this->provider->method('getFormat')->willReturn(false);
        }

        return $this->provider;
    }

    /**
     * @return MockObject&Template
     */
    public function getTemplate(): object
    {
        if (null === $this->template) {
            $this->template = $this->createMock(Template::class);
        }

        return $this->template;
    }

    /**
     * @psalm-suppress InternalMethod
     *
     * @see this class is not suposed to be created by hand but we are mocking twig here.
     */
    public function getTemplateWrapper(): TemplateWrapper
    {
        if (null === $this->templateWrapper) {
            $this->templateWrapper = new TemplateWrapper($this->getEnvironment(), $this->getTemplate());
        }

        return $this->templateWrapper;
    }

    /**
     * @return MockObject&Environment
     */
    public function getEnvironment(): object
    {
        if (null === $this->environment) {
            $this->environment = $this->createMock(Environment::class);
            $this->environment->method('load')->willReturn($this->getTemplateWrapper());
        }

        return $this->environment;
    }

    public function getMedia(): Media
    {
        if (null === $this->media) {
            $this->media = $this->createMock(Media::class);
            $this->media->method('getProviderName')->willReturn('provider');
            $this->media->method('getProviderStatus')->willReturn(MediaInterface::STATUS_OK);
        }

        return $this->media;
    }
}
