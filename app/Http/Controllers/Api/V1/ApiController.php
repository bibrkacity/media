<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Throwable;

/**
 * @OA\Info(title="Citations API", version="1")
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   name="Bearer authorization",
 *   scheme="bearer",
 *   in="header"
 * )
 * @OA\Server(
 *     url="/api/v1",
 * ),
 */
class ApiController extends Controller
{

     protected function catchException(Throwable $e):string
     {
         \Log::info( $e->getMessage() ."\nfile".$e->getFile()."\nline".$e->getLine());
         return $e->getMessage();
     }

}
