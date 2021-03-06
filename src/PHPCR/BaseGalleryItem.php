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

namespace Sonata\MediaBundle\PHPCR;

use Sonata\MediaBundle\Model\GalleryItem;

abstract class BaseGalleryItem extends GalleryItem
{
    /**
     * @var string
     */
    protected $nodename;

    /**
     * Set node name.
     *
     * @param string $nodename
     */
    public function setNodename($nodename): void
    {
        $this->nodename = $nodename;
    }

    /**
     * Get node name.
     *
     * @return string
     */
    public function getNodename()
    {
        return $this->nodename;
    }

    public function prePersist(): void
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTime();
    }
}
