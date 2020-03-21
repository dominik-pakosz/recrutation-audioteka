<?php

namespace App\Shared\Infrastructure\Service\Pagination;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Routing\RouterInterface;

class PaginationFactory
{
    public const PAGE = 'page';
    public const DEFAULT_PAGE = 1;
    private const DEFAULT_MAX_PER_PAGE = 3;

    /** @var RouterInterface */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function createPaginator(QueryBuilder $queryBuilder, int $page, int $maxPerPage = self::DEFAULT_MAX_PER_PAGE): Pagerfanta
    {
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfantaPaginator = new Pagerfanta($adapter);

        $pagerfantaPaginator->setMaxPerPage($maxPerPage);
        $pagerfantaPaginator->setCurrentPage($page);

        return $pagerfantaPaginator;
    }
}