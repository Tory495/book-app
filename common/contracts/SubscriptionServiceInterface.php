<?php

namespace common\contracts;

use common\models\Book;

interface SubscriptionServiceInterface
{
    public function sendNewBookNotification(Book $book): void;
}