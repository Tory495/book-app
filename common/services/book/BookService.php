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
        $isNewRecord = $book->isNewRecord;
        $oldImage = $book->getOldAttribute('image');
        $newImage = null;

        if ($image) {
            try {
                $newImage = $this->imageStorage->saveImage($image);

                if (!$newImage) {
                    $book->addError('image', Yii::t('app', 'Failed to save image file.'));
                    return false;
                }

                $book->image = $newImage;
            } catch (\Throwable $e) {
                Yii::error($e->getMessage(), __METHOD__);
                $book->addError('image', Yii::t('app', 'Failed to save image file.'));
                return false;
            }
        } elseif (!$isNewRecord) {
            $book->image = $oldImage;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (!$book->save()) {
                $transaction->rollBack();

                if ($newImage) {
                    $this->imageStorage->deleteImage($newImage);
                }
                
                return false;
            }

            $transaction->commit();
        } catch (\Throwable $th) {
            if ($transaction->isActive) {
                $transaction->rollBack();
            }

            if ($newImage) {
                $this->imageStorage->deleteImage($newImage);
            }

            Yii::error($th->getMessage(), __METHOD__);
            $book->addError('image', Yii::t('app', 'Failed to save book.'));
            return false;
        }

        if ($newImage && !$isNewRecord && $oldImage) {
            $this->imageStorage->deleteImage($oldImage);
        }

        // TODO: Вообще я бы реализовал очередь в случае падения сервиса, но тут это не так важно
        if ($isNewRecord) {
            $this->subscriptionService->sendNewBookNotification($book);
        }

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