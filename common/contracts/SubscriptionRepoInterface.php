<?php

namespace common\contracts;

interface SubscriptionRepoInterface
{
    /**
     * @param int[] $authorIds
     * @return string[]
     */
    public function getPhonesByAuthorIds(array $authorIds): array;
}
