<?php

namespace common\services\book;

use common\models\Book;
use Yii;
use yii\web\UploadedFile;
use common\contracts\ImageStorageServiceInterface;
use common\contracts\SubscriptionServiceInterface;

final class BookService
{
    public function __construct(
        private ImageStorageServiceInterface $imageStorage,
        private SubscriptionServiceInterface $subscriptionService,
    ) {}

    public function save(Book $book, ?UploadedFile $image = null): bool
    {
        if ($image) {
            try {
                $imageName = $this->imageStorage->saveImage($image);

                if (!$imageName) {
                    $book->addError('image', Yii::t('app', 'Failed to save image file.'));
                    return false;
                }

                if (!$book->isNewRecord && $book->getOldAttribute('image')) {
                    $this->imageStorage->deleteImage($book->getOldAttribute('image'));
                }

                $book->image = $imageName;
            } catch (\Throwable $e) {
                Yii::error($e->getMessage(), __METHOD__);
                $book->addError('image', Yii::t('app', 'Failed to save image file.'));
                return false;
            }
        } elseif (!$book->isNewRecord) {
            $book->image = $book->getOldAttribute('image');
        }

        if (!$book->save()) {
            return false;
        }

        // TODO: вообще я бы реализовал очередь в случае падения сервиса, но тут это не так важно
        $this->subscriptionService->sendNewBookNotification($book);

        return true;
    }

    public function delete(Book $book): bool
    {
        if ($book->image) {
            $this->imageStorage->deleteImage($book->image);
        }

        return $book->delete();
    }

    public function getMainImageUrl(?string $imageName): string
    {
        return $this->imageStorage->getImageUrl($imageName);
    }
}