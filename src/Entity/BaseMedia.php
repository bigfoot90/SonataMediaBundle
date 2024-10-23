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

namespace Sonata\MediaBundle\Entity;

use Domain\Model\ValueObject\MediaMetadata;
use Sonata\MediaBundle\Model\Media;

abstract class BaseMedia extends Media
{
    public function prePersist(): void
    {
        $this->createdAt = $this->updatedAt = new \DateTimeImmutable();
    }

    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function setContext($context): void
    {
        //        throw new \Exception('This property is not updatable');
    }

    public function setProviderName($providerName): void
    {
        //        throw new \Exception('This property is not updatable');
    }

    public function getProviderName(): string
    {
        return 'sonata.media.provider.'.$this->providerName;
    }

    public function isImage(): bool
    {
        return str_starts_with($this->contentType, 'image/');
    }

    public function isVideo(): bool
    {
        return str_starts_with($this->contentType, 'video/');
    }

    public function getTarget(): object
    {
        return $this->{$this->context};
    }

    public function getPosizione(): int
    {
        return $this->posizione;
    }

    public function setPosizione(int $posizione): void
    {
        $this->posizione = $posizione;
    }

    public function getCdnIsFlushable(): bool
    {
        return (bool) $this->cdnIsFlushable;
    }
}
