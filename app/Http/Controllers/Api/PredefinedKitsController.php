<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\PredefinedKitsTransformer;
use App\Models\PredefinedKit;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Transformers\SelectlistTransformer;

/**
 *  @author [D. Minaev.] [<dmitriy.minaev.v@gmail.com>]
 */
class PredefinedKitsController extends Controller
{
    /**
     * List Kits
     *
     * @group Predefined Kits
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) : JsonResponse | array
    {
        $this->authorize('view', PredefinedKit::class);

        $kits = PredefinedKit::query()->with('adminuser');

        if ($request->filled('search')) {
            $kits = $kits->TextSearch($request->input('search'));
        }

        // Make sure the offset and limit are actually integers and do not exceed system limits
        $offset = ($request->input('offset') > $kits->count()) ? $kits->count() : app('api_offset_value');
        $limit = app('api_limit_value');

        $order = $request->input('order') === 'desc' ? 'desc' : 'asc';

        switch ($request->input('sort')) {
            case 'created_by':
                $kits = $kits->OrderByCreatedBy($order);
                break;
            default:
                // This array is what determines which fields should be allowed to be sorted on ON the table itself.
                // These must match a column on the consumables table directly.
                $allowed_columns = [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                ];

                $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
                $kits = $kits->orderBy($sort, $order);
                break;
        }

        $total = $kits->count();
        $kits = $kits->skip($offset)->take($limit)->get();

        return (new PredefinedKitsTransformer)->transformPredefinedKits($kits, $total);
    }

    /**
     * Create Kit
     *
     * @group Predefined Kits
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request) : JsonResponse
    {
        $this->authorize('create', PredefinedKit::class);
        $kit = new PredefinedKit;
        $kit->fill($request->all());

        if ($kit->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.create_success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $kit->getErrors()));
    }

    /**
     * Show Kit
     *
     * @group Predefined Kits
     * @urlParam $id int  required The ID of the kit. Example: 1
     */
    public function show($id) :  array
    {
        $this->authorize('view', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($id);

        return (new PredefinedKitsTransformer)->transformPredefinedKit($kit);
    }

    /**
     * Update Kit
     *
     * @group Predefined Kits
     * @urlParam $id int  required The ID of the kit. Example: 1
     */
    public function update(Request $request, $id) : JsonResponse
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($id);
        $kit->fill($request->all());

        if ($kit->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.update_success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $kit->getErrors()));
    }

    /**
     * Delete Kit
     *
     * @group Predefined Kits
     * @urlParam $id int  required The ID of the kit. Example: 1
     */
    public function destroy($id) : JsonResponse
    {
        $this->authorize('delete', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($id);

        // Delete childs
        $kit->models()->detach();
        $kit->licenses()->detach();
        $kit->consumables()->detach();
        $kit->accessories()->detach();

        $kit->delete();

        return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/kits/general.delete_success')));
    }

    /**
     * Selectlist
     *
     * @group Predefined Kits
     * @see \App\Http\Transformers\SelectlistTransformer
     */
    public function selectlist(Request $request) : array
    {
        $kits = PredefinedKit::select([
            'id',
            'name',
        ]);

        if ($request->filled('search')) {
            $kits = $kits->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $kits = $kits->orderBy('name', 'ASC')->paginate(50);

        return (new SelectlistTransformer)->transformSelectlist($kits);
    }

    /**
     * List Licenses in Kit
     *
     * @group Predefined Kits
     * @urlParam $kit_id int  required The ID of the kit. Example: 1
     * @return \Illuminate\Http\Response
     */
    public function indexLicenses($kit_id) : array
    {
        $this->authorize('view', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $licenses = $kit->licenses;

        return (new PredefinedKitsTransformer)->transformElements($licenses, $licenses->count());
    }

    /**
     * Add License to Kit
     *
     * @group Predefined Kits
     * @urlParam $kit_id int  required The ID of the kit. Example: 1
     * @bodyParam license int required The ID of the license. Example: 1
     * @bodyParam quantity int The quantity of the license. Example: 1
     * @return \Illuminate\Http\Response
     */
    public function storeLicense(Request $request, $kit_id) : JsonResponse
    {
        $this->authorize('update', PredefinedKit::class);

        $kit = PredefinedKit::findOrFail($kit_id);
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $license_id = $request->get('license');
        $relation = $kit->licenses();
        if ($relation->find($license_id)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, ['license' => trans('admin/kits/general.license_error')]));
        }

        $relation->attach($license_id, ['quantity' => $quantity]);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.license_added_success')));
    }

    /**
     * Update License in Kit
     *
     * @group Predefined Kits
     * @urlParam $kit_id int required The ID of the kit. Example: 1
     * @urlParam $license_id int required The ID of the license. Example: 1
     */
    public function updateLicense(Request $request, $kit_id, $license_id) : JsonResponse
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }
        $kit->licenses()->syncWithoutDetaching([$license_id => ['quantity' =>  $quantity]]);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.license_updated')));
    }

    /**
     * Remove License from Kit
     *
     * @group Predefined Kits
     * @urlParam $kit_id int required The ID of the kit. Example: 1
     * @urlParam $license_id int required The ID of the license. Example: 1
     */
    public function detachLicense($kit_id, $license_id) : JsonResponse
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);

        $kit->licenses()->detach($license_id);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.delete_success')));
    }

    /**
     * List Models in Kit
     *
     * @group Predefined Kits
     * @urlParam $kit_id int required The ID of the kit. Example: 1
     */
    public function indexModels($kit_id) : array
    {
        $this->authorize('view', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $models = $kit->models;

        return (new PredefinedKitsTransformer)->transformElements($models, $models->count());
    }

    /**
     * Add Model to Kit
     *
     * @group Predefined Kits
     * @urlParam $kit_id int required The ID of the kit. Example: 1
     * @bodyParam model int required The ID of the model. Example: 1
     */
    public function storeModel(Request $request, $kit_id) : JsonResponse
    {
        $this->authorize('update', PredefinedKit::class);

        $kit = PredefinedKit::findOrFail($kit_id);

        $model_id = $request->get('model');
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $relation = $kit->models();
        if ($relation->find($model_id)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, ['model' => trans('admin/kits/general.model_already_attached')]));
        }
        $relation->attach($model_id, ['quantity' => $quantity]);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, 'Model added successfull'));
    }

    /**
     * Update Model in Kit
     *
     * @group Predefined Kits
     * @urlParam $kit_id int required The ID of the kit. Example: 1
     * @bodyParam quantity int required The quantity of the model. Example: 1
     */
    public function updateModel(Request $request, $kit_id, $model_id) : JsonResponse
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }
        $kit->models()->syncWithoutDetaching([$model_id => ['quantity' =>  $quantity]]);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.license_updated')));
    }

    /**
     * Delete Model from Kit
     *
     * @group Predefined Kits
     * @urlParam $kit_id int required The ID of the kit. Example: 1
     * @urlParam $model_id int required The ID of the model. Example: 1
     */
    public function detachModel($kit_id, $model_id) : JsonResponse
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);

        $kit->models()->detach($model_id);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.model_removed_success')));
    }

    /**
     * List Consumables in Kit
     *
     * @group Predefined Kits
     * @urlParam $kit_id int required The ID of the kit. Example: 1
     */
    public function indexConsumables($kit_id) : array
    {
        $this->authorize('view', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $consumables = $kit->consumables;

        return (new PredefinedKitsTransformer)->transformElements($consumables, $consumables->count());
    }

    /**
     * Add Consumable to Kit
     *
     * @group Predefined Kits
     * @urlParam $kit_id int required The ID of the kit. Example: 1
     * @bodyParam consumable int required The ID of the consumable. Example: 1
     * @bodyParam quantity int The quantity of the consumable. Example: 1
     */
    public function storeConsumable(Request $request, $kit_id) : JsonResponse
    {
        $this->authorize('update', PredefinedKit::class);

        $kit = PredefinedKit::findOrFail($kit_id);
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $consumable_id = $request->get('consumable');
        $relation = $kit->consumables();
        if ($relation->find($consumable_id)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, ['consumable' => trans('admin/kits/general.consumable_error')]));
        }

        $relation->attach($consumable_id, ['quantity' => $quantity]);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.consumable_added_success')));
    }

    /**
     * Update Consumable in Kit
     *
     * @group Predefined Kits
     * @urlParam $kit_id int required The ID of the kit. Example: 1
     * @urlParam $consumable_id int required The ID of the consumable. Example: 1
     * @bodyParam quantity int The quantity of the consumable. Example: 1
     */
    public function updateConsumable(Request $request, $kit_id, $consumable_id) : JsonResponse
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }
        $kit->consumables()->syncWithoutDetaching([$consumable_id => ['quantity' =>  $quantity]]);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.consumable_updated')));
    }

    /**
     * Remove Consumable from Kit
     *
     * @group Predefined Kits
     * @urlParam $kit_id int required The ID of the kit. Example: 1
     * @urlParam $consumable_id int required The ID of the consumable. Example: 1
     */
    public function detachConsumable($kit_id, $consumable_id) : JsonResponse
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);

        $kit->consumables()->detach($consumable_id);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.consumable_deleted')));
    }

    /**
     * List Accessories in Kit
     *
     * @group Predefined Kits
     * @urlParam $kit_id int required The ID of the kit. Example: 1
     */
    public function indexAccessories($kit_id) : array
    {
        $this->authorize('view', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $accessories = $kit->accessories;

        return (new PredefinedKitsTransformer)->transformElements($accessories, $accessories->count());
    }

    /**
     * Add Accessory to Kit
     *
     * @group Predefined Kits
     * @urlParam $kit_id int required The ID of the kit. Example: 1
     * @bodyParam accessory int required The ID of the accessory. Example: 1
     * @bodyParam quantity int The quantity of the accessory. Example: 1
     */
    public function storeAccessory(Request $request, $kit_id) : JsonResponse
    {
        $this->authorize('update', PredefinedKit::class);

        $kit = PredefinedKit::findOrFail($kit_id);
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $accessory_id = $request->get('accessory');
        $relation = $kit->accessories();
        if ($relation->find($accessory_id)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, ['accessory' => trans('admin/kits/general.accessory_error')]));
        }

        $relation->attach($accessory_id, ['quantity' => $quantity]);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.accessory_added_success')));
    }

    /**
     * Update Accessory in Kit
     *
     * @group Predefined Kits
     * @urlParam $kit_id int required The ID of the kit. Example: 1
     * @urlParam $accessory_id int required The ID of the accessory. Example: 1
     * @bodyParam quantity int The quantity of the accessory. Example: 1
     */
    public function updateAccessory(Request $request, $kit_id, $accessory_id) : JsonResponse
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);
        $quantity = $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }
        $kit->accessories()->syncWithoutDetaching([$accessory_id => ['quantity' =>  $quantity]]);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.accessory_updated')));
    }

    /**
     * Remove Accessory from Kit
     *
     * @group Predefined Kits
     * @urlParam $kit_id int required The ID of the kit. Example: 1
     * @urlParam $accessory_id int required The ID of the accessory. Example: 1
     */
    public function detachAccessory($kit_id, $accessory_id) : JsonResponse
    {
        $this->authorize('update', PredefinedKit::class);
        $kit = PredefinedKit::findOrFail($kit_id);

        $kit->accessories()->detach($accessory_id);

        return response()->json(Helper::formatStandardApiResponse('success', $kit, trans('admin/kits/general.accessory_deleted')));
    }
}
