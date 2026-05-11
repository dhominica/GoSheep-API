<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\BreedOptionResource;
use App\Http\Resources\CageOptionResource;
use App\Http\Resources\ParentSheepResource;
use App\Services\SheepFormService;
use Illuminate\Http\Request;

class SheepFormController extends BaseController
{
    public function __construct(
        protected SheepFormService $sheepFormService
    ) {}

    public function breeds()
    {
        $breedsOptions = $this->sheepFormService->getBreeds();

        return $this->success(
            BreedOptionResource::collection($breedsOptions),
            'Data ras berhasil diambil'
        );
    }

    public function cages()
    {
        $cageOptions = $this->sheepFormService->getCages();

        return $this->success(
            CageOptionResource::collection($cageOptions),
            'Data kandang berhasil diambil'
        );
    }

    public function sires(Request $request)
    {
        $result = $this->sheepFormService->getSires(
            lastId: $request->last_id,
            limit: $request->limit ?? 10,
            search: $request->search
        );

        return $this->successCursorPaginated(
            ParentSheepResource::collection($result['data']),
            $result['has_more'],
            $result['next_cursor'],
            'Data pejantan berhasil diambil'
        );
    }

    public function dams(Request $request)
    {
        $result = $this->sheepFormService->getDams(
            lastId: $request->last_id,
            limit: $request->limit ?? 10,
            search: $request->search
        );

        return $this->successCursorPaginated(
            ParentSheepResource::collection($result['data']),
            $result['has_more'],
            $result['next_cursor'],
            'Data indukan berhasil diambil'
        );
    }
}
