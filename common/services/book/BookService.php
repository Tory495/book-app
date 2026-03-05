<?php

namespace common\services\book;

use common\models\Book;
use Yii;
use yii\web\UploadedFile;
use common\contracts\ImageStorageServiceInterface;
use common\contracts\SubscriptionServiceInterface;
use common\contracts\AuthorServiceInterface;
use common\models\BookAuthor;

final class BookService
{
    public function __construct(
        private ImageStorageServiceInterface $imageStorage,
        private SubscriptionServiceInterface $subscriptionService,
        private AuthorServiceInterface $authorService,
    ) {}

    public function save(Book $book, ?UploadedFile $image = null): bool
    {
        $book->addError('', Yii::t('app', 'Failed to save book.'));
        return false;
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

            $this->syncAuthors($book);

            $transaction->commit();
        } catch (\Throwable $e) {
            if ($transaction->isActive) {
                $transaction->rollBack();
            }

            if ($e instanceof \DomainException) {
                $book->addError('author_ids', $e->getMessage());
            } else {
                $book->addError('', Yii::t('app', 'Failed to save book.'));
            }

            if ($newImage) {
                $this->imageStorage->deleteImage($newImage);
            }

            Yii::error($e->getMessage(), __METHOD__);
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

    private function syncAuthors(Book $book): void
    {
        $targetIds = array_values(array_unique(array_map('intval', (array)$book->author_ids)));
        $currentIds = array_map('intval', $book->getAuthors()->select('id')->column());

        $toDelete = array_diff($currentIds, $targetIds);
        $toAdd = array_diff($targetIds, $currentIds);

        if ($toDelete) {
            BookAuthor::deleteAll([
                'book_id' => $book->id,
                'author_id' => $toDelete,
            ]);
        }

        if ($toAdd) {
            $authors = $this->authorService->getByIds($toAdd);

            if (count($authors) !== count($toAdd)) {
                throw new \DomainException(Yii::t('app', 'Some authors not found.'));
            }

            foreach ($authors as $author) {
                $book->link('authors', $author);
            }
        }
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