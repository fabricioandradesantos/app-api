<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;

class UserController extends BaseController
{

    public function index(Request $request)
    {
        $data = User::query()
            ->get();

        return $this->sendResponse($data);
    }

    public function show($id)
    {
        $data = User::findOrFail($id);

        return $this->sendResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->rules($request)
        );

        if ($validator->fails()) {
            return $this->sendError('Erro de Validação.', $validator->errors()->toArray(), 422);
        }

        $inputs = $request->all();
        $inputs['password'] = bcrypt($request->input('password'));

        $user = User::create($inputs);

        return $this->sendResponse([], 'Registro criado com sucesso', 201);
    }

    public function update(Request $request)
    {
        $validator = $this->getValidationFactory()
            ->make(
                $request->all(),
                $this->rules($request, auth()->id())
            );

        if ($validator->fails()) {
            return $this->sendError('Erro de Validação.', $validator->errors()->toArray(), 422);
        }

        $user = User::find($request->user()->id);

        DB::transaction(function () use ($request, $user) {
            $inputs = $request->all();

            $user->fill($inputs)->save();
        });

        return $this->sendResponse([], "Registro atualizado com sucesso.");
    }

    private function rules(Request $request, $primaryKey = null, bool $changeMessages = false)
    {
        $rules = [];
        
        if (auth()->id()) {
            $rules = [
                'name' => ['required', 'max:40'],
                'phone' => ['required', 'max:15'],
                'email' => ['required', 'max:50', Rule::unique('users')->ignore($primaryKey)],
                'birthdate' => ['required'],
            ];
        }else{
            $rules = [
                'name' => ['required', 'max:40'],
                'nif' => ['required', 'max:11', Rule::unique('users')->ignore($primaryKey)],
                'phone' => ['required', 'max:15'],
                'email' => ['required', 'max:50', Rule::unique('users')->ignore($primaryKey)],
                'birthdate' => ['required'],
                'password' => ['required', 'min:8', 'max:16']
            ];
        }

        $messages = [];

        return !$changeMessages ? $rules : $messages;
    }
}
