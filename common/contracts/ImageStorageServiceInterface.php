<?php

namespace common\contracts;

use yii\web\UploadedFile;

interface ImageStorageServiceInterface
{
    public function saveImage(UploadedFile $image): ?string;
    public function deleteImage(string $imageName): void;
    public function getImageUrl(?string $imageName): string;
}