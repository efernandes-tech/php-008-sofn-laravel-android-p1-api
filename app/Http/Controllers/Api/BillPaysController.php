<?php

namespace SON\Http\Controllers\Api;

use Illuminate\Http\Request;
use SON\Http\Controllers\Controller;
use SON\Http\Requests\BillPayRequest;
use SON\Repositories\BillPayRepository;

class BillPaysController extends Controller
{
    protected $repository;

    public function __construct(BillPayRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->all();
    }

    public function store(BillPayRequest $request)
    {
        $data = $request->except('done');

        $billPay = $this->repository->create($data);

        return response()->json($billPay, 201);
    }

    public function show($id)
    {
        return $this->repository->find($id);
    }

    public function update(BillPayRequest $request, $id)
    {
        $billPay = $this->repository->update($request->all(), $id);

        return response()->json($billPay, 200);
    }

    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if ($deleted) {
            return response()->json([], 204);
        } else {
            return response()->json([
                'error' => 'Resource can not be deleted',
            ], 500);
        }
    }
}
