<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterController extends ApiController
{
    /**
     * @OA\Post(
     *     path="/register",
     *     summary="Registration of new user",
     *     description="Registration of new user and return API-token",
     *     tags={"Auth"},
     *     @OA\Parameter(
     *          name="name",
     *          description="Name of user",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
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
     *     @OA\Parameter(
     *          name="password_confirmation",
     *          description="Password Confirmation",
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
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        try {

            $rules = [
                'name'      =>'required|unique:App\Models\User,name',
                'email'     =>'required|unique:App\Models\User,email',
                'password'  =>'required|confirmed|min:8',
            ];

            $validator = Validator::make($request->all() , $rules);

            if( $validator->fails() )
                throw new ValidationException($validator);


            $data = [
                'data' => [],
            ];

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $data['data'] = [
                "access_token" => $user->createToken('api')->plainTextToken,
                "user" => $user,
            ];

            $httpStatus = 200;
        } catch(ValidationException $e) {
            $data['errors'] = $e->getMessage();
            $httpStatus = 422;
        } catch(\Exception $e) {
            $data['errors'] = $this->catchException($e);
            $httpStatus = 400;
        }

        return response()->json($data, $httpStatus);
    }




}
