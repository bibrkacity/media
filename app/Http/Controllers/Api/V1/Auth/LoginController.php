<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends ApiController
{
    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Authorization",
     *     description="Authorization and return API-token",
     *     tags={"Auth"},
     *     @OA\Parameter(
     *          name="email",
     *          description="E-mail for login",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="User and API-token",
     *     )
     * )
     */
    public function login( Request $request ): \Illuminate\Http\JsonResponse
    {
        try{
            $http_code = 200;
            $rules = [
                'email' => 'required|email',
                'password' => 'required|string|min:8',
            ];

            $validator = Validator::make($request->all(), $rules );

            if($validator->fails())            {
                throw new ValidationException($validator);
            }

            $credential = [
                'email'     => $request->email,
                'password'  => $request->password
            ];

            if(Auth::attempt( $credential, false )){
                $user =Auth::user();
                $token = $user->createToken('api');

                $result= ['token' => $token->plainTextToken];
            }
            else{
                $result= ['error' => 'Invalid login or password'];
            }
        } catch(ValidationException $e){
            $result= ['error' => $e->getMessage()];
            $http_code = 423;
        } catch(\Exception $e){
            $result= ['error' => $e->getMessage()];
            $http_code = 400;
        }

        return response()->json($result,$http_code);
    }
}
