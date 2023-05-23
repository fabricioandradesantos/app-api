<?php

namespace App\Http\Controllers\API;

use App\Models\Lot;
use App\Models\User;
use App\Models\LotSaleType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;

class LotController extends BaseController
{

    public function index(Request $request)
    {
        $data = Lot::query()
            ->with('lotSaleType.saleType')
            ->get();

        return $this->sendResponse($data);
    }

    public function show($id)
    {
        $data = Lot::query()
            ->with('lotSaleType.saleType', 'images')
            ->findOrFail($id);

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

        $user = User::find($request->user()->id);

        DB::transaction(function () use ($request, $user) {
            $inputs = $request->all();
            $inputs['user_id'] = $user->id;

            $inputs['area'] = $request->width * $request->length;

            $lot = Lot::create($inputs);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $upload = $image->store('lots', 'public');
                    $lot->images()->create(['filename' => $upload]);
                }
            }

            if (isset($request->sale_types)) {

                foreach ($request->sale_types as $key => $mySaleType) {

                    $type = [
                        'lot_id' => $lot->id,
                        'sale_type_id' => $mySaleType['id'],
                    ];

                    LotSaleType::create($type);
                }

            }

        });

        return $this->sendResponse([], 'Registro criado com sucesso', 201);
    }

    public function update(Request $request, $id)
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

        DB::transaction(function () use ($request, $user, $id) {
            $inputs = $request->all();

            $inputs['user_id'] = $user->id;

            $inputs['area'] = $request->width * $request->length;

            $lot = Lot::find($id);

            $lot->fill($inputs)->save();

            $deletedImages = $lot->images()->pluck('filename')->toArray();
            $lot->images()->delete();

            // Excluir as imagens da pasta storage 
            foreach ($deletedImages as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $upload = $image->store('lots', 'public');
                    $lot->images()->create(['filename' => $upload]);
                }
            }

            $lot->lotSaleType()->delete();
            if (isset($request->sale_types)) {

                foreach ($request->sale_types as $key => $mySaleType) {

                    $type = [
                        'lot_id' => $lot->id,
                        'sale_type_id' => $mySaleType['id'],
                    ];

                    LotSaleType::create($type);
                }

            }

        });

        return $this->sendResponse([], "Registro atualizado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Lot::query()->findOrFail($id);

        try {
            DB::beginTransaction();
            $item->lotSaleType()->delete();
            $item->images()->delete();
            $item->delete();

            DB::commit();
            return $this->sendResponse([], "Registro deletado com sucesso", 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            ds($th->getMessage());
            return $this->sendError("Registro vinculado á outra tabela, somente poderá ser excluído se retirar o vinculo.", [], 403);
        }
    }

    private function rules(Request $request, $primaryKey = null, bool $changeMessages = false)
    {
        $rules = [
            'zip_code' => ['nullable', 'max:8', 'string'],
            'public_place' => ['required', 'max:30', 'string'],
            'number' => ['required', 'max:6', 'string'],
            'district' => ['required', 'max:40', 'string'],
            'city_id' => ['required', Rule::exists('cities', 'id')],
            'width' => ['required', 'min:0', 'numeric'],
            'length' => ['required', 'min:0', 'numeric'],
            'price' => ['nullable', 'min:0', 'numeric'],
            'type' => ['nullable'],
            'description' => ['nullable', 'max:300', 'string'],
        ];

        $messages = [];

        return !$changeMessages ? $rules : $messages;
    }
}
