<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait StorageImages
{
    protected function getStorageUrl($value): ?string
    {
        return $value ? Storage::url($value) : null;
    }

    protected static function parseNameByImage(string $name): string
    {
        $nowDate = new \DateTime();

        return (string)str(Str::slug($name))
            ->append("-{$nowDate->getTimestamp()}.png");
    }

    protected function handleUpdateImages(Model $model): void
    {
        $image = $model->getOriginal('image');

        if ($model->isDirty('image') && $image) {
            Storage::delete($image);
        }
    }

    protected function handleDeleteImages(Model $model): void
    {
        if (!$model->image || !Storage::has($model->image)) {
            return;
        }

        Storage::delete($model->image);
    }
}
