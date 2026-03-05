<?php

namespace common\services\subscription;

use common\contracts\SubscriptionRepoInterface;
use common\models\Book;

final class SubscriptionService
{
    public function __construct(
        private SubscriptionRepoInterface $subscriptionRepo,
    ) {}

    /**
     * @param int[] $authorIds
     */
    public function getPhonesByAuthorIds(array $authorIds): array
    {
        return $this->subscriptionRepo->getPhonesByAuthorIds($authorIds);
    }

    public function sendNewBookNotification(Book $book): void
    {
        $authorIds = $book->getAuthorIds();
        $phones = $this->getPhonesByAuthorIds($authorIds);

        foreach ($phones as $phone) {
            \Yii::$app->sms->send($phone, "Новая книга: {$book->title} от {$book->author->full_name}");
        }
    }
}
