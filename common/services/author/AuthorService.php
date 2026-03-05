<?php

namespace common\services\author;

use common\models\Author;
use common\contracts\AuthorRepoInterface;
use common\contracts\AuthorServiceInterface;

final class AuthorService implements AuthorServiceInterface
{
    public function __construct(
        private AuthorRepoInterface $authorRepo,
    ) {}

    /**
     * @return Author[]
     */
    public function getTopAuthors(?int $year = null): array
    {
        return $this->authorRepo->getTopAuthors($year);
    }

    /**
     * @return Author[]
     */
    public function getAll(): array
    {
        return $this->authorRepo->getAll();
    }

    /**
     * @param int[] $ids
     * @return Author[]
     */
    public function getByIds(array $ids): array
    {
        return $this->authorRepo->getByIds($ids);
    }
}
