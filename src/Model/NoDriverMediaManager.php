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

namespace Sonata\MediaBundle\Model;

use Doctrine\DBAL\Connection;
use Sonata\DatagridBundle\Pager\PagerInterface;
use Sonata\MediaBundle\Exception\NoDriverException;

/**
 * @internal
 *
 * @author Andrey F. Mindubaev <covex.mobile@gmail.com>
 */
final class NoDriverMediaManager implements MediaManagerInterface
{
    public function getClass(): string
    {
        throw new NoDriverException();
    }

    public function findAll(): array
    {
        throw new NoDriverException();
    }

    /**
     * @return MediaInterface[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array
    {
        throw new NoDriverException();
    }

    public function findOneBy(array $criteria, ?array $orderBy = null): ?object
    {
        throw new NoDriverException();
    }

    /**
     * @return MediaInterface|null
     */
    public function find($id): ?object
    {
        throw new NoDriverException();
    }

    public function create(): object
    {
        throw new NoDriverException();
    }

    public function save($entity, $andFlush = true): void
    {
        throw new NoDriverException();
    }

    public function delete($entity, $andFlush = true): void
    {
        throw new NoDriverException();
    }

    public function getTableName(): string
    {
        throw new NoDriverException();
    }

    public function getConnection(): Connection
    {
        throw new NoDriverException();
    }

    public function getPager(array $criteria, int $page, int $limit = 10, array $sort = []): PagerInterface
    {
        throw new NoDriverException();
    }
}
