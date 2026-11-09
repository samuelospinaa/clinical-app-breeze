<?php

namespace App\Traits;

trait ImagesTrait
{
   protected function imageToBase64($path, $type = null): string
   {
      $codedImage = base64_encode(file_get_contents($path));
      $type = $type ?? 'jpg';

      return "data:image/{$type};base64,$codedImage";
   }
}
