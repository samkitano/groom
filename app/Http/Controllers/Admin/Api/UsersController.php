<?php

namespace App\Http\Controllers\Admin\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;

class UsersController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::all();

        return $this->respondOk(compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse

    {
        // TODO
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $user = User::findOrFail($id);

        return $this->respondOk(compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $data = array_except($request->toArray(), ['_method', '_token']);
        $key = array_keys($data)[0];
        $rule = $this->rules()[$key];

        $this->validate($request, $rule);

        if ($key === 'password') {
            $data['password'] = Hash::make($data['password']);
        }

        $user = User::findOrFail($id);
        $user->$key = $data[$key];
        $user->save();

        $message = ucfirst($key).' changed!';

        return $this->respondOk(['user' => $user, 'message' =>$message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        User::destroy($id);

        return $this->respondOk();
    }

    protected function rules(): array
    {
        return [
            'email' => ['email' => 'required|confirmed|email|string|max:150|unique:users'],
            'password' => ['password' => 'required|min:6|string|confirmed'],
            'name' => ['name' => 'required|min:3|string|max:150'],
        ];
    }
}
