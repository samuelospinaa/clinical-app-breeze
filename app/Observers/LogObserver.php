<?php

namespace App\Observers;

use App\Models\Log;
use App\Traits\StorageImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LogObserver
{
   use StorageImages;

   /**
    * Handle the model "updated" event.
    *
    * @param Model $model
    * @return void
    */
   public function created($model)
   {
      $tableName = Str::plural($model->getTable());

      $data = [
         "action" => 'created',
         "table_name" => $tableName,
         "row_id" => $model->id,
         "user_id" => auth()->user()->id ?? 0,
         "old_data" => null,
         "new_data" => json_encode($model->getAttributes()),
      ];

      Log::create($data);
   }

   /**
    * Handle the model "updated" event.
    *
    * @param Model $model
    * @return void
    */
   public function updated(Model $model): void
   {
      $this->handleUpdateImages($model);

      $tableName = Str::plural($model->getTable());

      $data = [
         "action" => 'updated',
         "table_name" => $tableName,
         "row_id" => $model->id,
         "user_id" => auth()->user()->id ?? 0,
         "old_data" => json_encode($model->getOriginal()),
         "new_data" => json_encode($model->getChanges()),
      ];

      Log::create($data);
   }

   /**
    * Handle the model "deleted" event.
    *
    * @param Model $model
    * @return void
    */
   public function deleted(Model $model): void
   {

      $tableName = Str::plural($model->getTable());

      $data = [
         "action" => 'deleted',
         "table_name" => $tableName,
         "row_id" => $model->id,
         "user_id" => auth()->user()->id ?? 0,
         "old_data" => json_encode($model->getOriginal()),
         "new_data" => null,
      ];

      Log::create($data);
   }
}
