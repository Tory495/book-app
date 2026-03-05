<?php

namespace common\services\subscription;

use common\contracts\SubscriptionRepoInterface;
use common\contracts\SubscriptionServiceInterface;
use common\models\Book;

final class SubscriptionService implements SubscriptionServiceInterface
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
        $authors = $book->getAuthors()->all();
        $phones = $this->getPhonesByAuthorIds(array_map(fn($a) => $a->id, $authors));
        $authorNames = implode(', ', array_map(fn($a) => $a->full_name, $authors));

        foreach ($phones as $phone) {
            \Yii::$app->sms->send($phone, \Yii::t('app', 'New book: {title} by {author}', [
                'title' => $book->title,
                'author' => $authorNames,
            ]));
        }
    }
}
