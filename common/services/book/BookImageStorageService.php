<?php

namespace common\services\book;

use yii\web\UploadedFile;
use Yii;

class BookImageStorageService
{
    private const string STORAGE_DIR_ALIAS = '@frontend/web/uploads';
    private const string PUBLIC_URL_ALIAS = '@web/uploads';
    private const string PLACEHOLDER_IMAGE_NAME = 'img_not_found.png';

    /**
     * @throws \Exception
     */
    public function saveImage(UploadedFile $image): ?string
    {
        $name = uniqid(more_entropy: true) . '.' . $image->extension;
        $path = Yii::getAlias(self::STORAGE_DIR_ALIAS) . '/' . $name;

        if ($image->saveAs($path, false)) {
            return $name;
        }

        return null;
    }

    public function getImageUrl(?string $imageName): string
    {
        if (!$imageName || !$this->isImageExists($imageName)) {
            return $this->getPlaceholderImageUrl();
        }

        return Yii::getAlias(self::PUBLIC_URL_ALIAS) . '/' . $imageName;
    }

    public function getPlaceholderImageUrl(): string
    {
        return Yii::getAlias(self::PUBLIC_URL_ALIAS) . '/' . self::PLACEHOLDER_IMAGE_NAME;
    }

    public function isImageExists(string $imageName): bool
    {
        return file_exists(Yii::getAlias(self::STORAGE_DIR_ALIAS) . '/' . $imageName);
    }

    public function deleteImage(string $imageName): void
    {
        if (!$imageName || $imageName === self::PLACEHOLDER_IMAGE_NAME) {
            return;
        }

        $path = Yii::getAlias(self::STORAGE_DIR_ALIAS) . '/' . $imageName;

        if ($this->isImageExists($imageName)) {
            unlink($path);
        }
    }
}
