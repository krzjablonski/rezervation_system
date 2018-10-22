<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22.10.18
 * Time: 09:32
 */

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;


class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'error' => $this->resource,
        ];
    }
}
