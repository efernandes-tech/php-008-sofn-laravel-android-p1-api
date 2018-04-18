<?php

namespace SON\Http\Controllers\Api;

use Illuminate\Http\Request;
use SON\Http\Controllers\Controller;
use SON\Http\Requests\CategoryRequest;
use SON\Repositories\CategoryRepository;

class CategoriesController extends Controller
{
    /**
     * @var mixed
     */
    protected $repository;

    /**
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->repository->all();
    }

    /**
     * @param CategoryRequest $request
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->repository->create($request->all());

        return response()->json($category, 201);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param CategoryRequest $request
     * @param $id
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = $this->repository->update($request->all(), $id);

        return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
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
