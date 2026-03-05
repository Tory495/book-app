<?php

namespace common\repo\mysql\subscription;

use common\models\Subscription;
use common\contracts\SubscriptionRepoInterface;

final class SubscriptionRepo implements SubscriptionRepoInterface
{
    /**
     * @param int[] $authorIds
     * @return string[]
     */
    public function getPhonesByAuthorIds(array $authorIds): array
    {
        return Subscription::find()
            ->where(['author_id' => $authorIds])
            ->select('phone')
            ->distinct()
            ->column();
    }
}
