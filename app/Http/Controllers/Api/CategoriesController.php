<?php

namespace SON\Http\Controllers\Api;

use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;
use SON\Http\Requests\CategoryCreateRequest;
use SON\Http\Requests\CategoryUpdateRequest;
use SON\Repositories\CategoryRepository;
use SON\Http\Controllers\Controller;

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
     * Store a newly created resource in storage.
     *
     * @param  CategoryCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreateRequest $request)
    {

        try {
            $category = $this->repository->create($request->all());

            $response = [
                'message' => 'Category created.',
                'data'    => $category->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag(),
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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
     * Update the specified resource in storage.
     *
     * @param  CategoryUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {

        try {
            $category = $this->repository->update($id, $request->all());

            $response = [
                'message' => 'Category updated.',
                'data'    => $category->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag(),
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Category deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Category deleted.');
    }
}
