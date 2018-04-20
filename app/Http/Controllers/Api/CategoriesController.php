<?php

namespace SON\Http\Controllers\Api;

use SON\Http\Controllers\Controller;
use SON\Http\Requests\CategoryRequest;
use SON\Repositories\CategoryRepository;


class CategoriesController extends Controller
{

    /**
     * @var CategoryRepository
     */
    protected $repository;


    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->applyMultitenancy();
    }


    /**
     * Display a listing of the resource.
     *
     * @Swagger\GET(
     *     path="/api/categories",
     *     description="Listar categorias",
     *     @Swagger\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @Swagger\Response(response="200", description="Coleção de categorias")
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->repository->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @Swagger\POST(
     *     path="/api/categories",
     *     description="Criar categoria",
     *     @Swagger\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @Swagger\Parameter(
     *          name="body", in="body", required=true,
     *       @Swagger\Schema(
     *          @Swagger\Property(
     *              property="name",
     *              type="string"
     *          ),
     *       )
     *          ),
     *     @Swagger\Response(response="201", description="Categoria criada")
     * )
     * @param  CategoryRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->repository->create($request->all());
        return response()->json($category, 201);
    }


    /**
     * Display the specified resource.
     *
     * @Swagger\GET(
     *     path="/api/categories/{id}",
     *     description="Listar uma categoria",
     *     @Swagger\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @Swagger\Parameter(
     *          name="id", in="path", required=true, type="integer"
     *          ),
     *     @Swagger\Response(response="200", description="Categoria encontrada")
     * )
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @Swagger\PUT(
     *     path="/api/categories/{id}",
     *     description="Atualizar categoria",
     *     @Swagger\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @Swagger\Parameter(
     *          name="id", in="path", required=true, type="integer"
     *     ),
     *     @Swagger\Parameter(
     *          name="body", in="body", required=true,
     *       @Swagger\Schema(
     *          @Swagger\Property(
     *              property="name",
     *              type="string"
     *          ),
     *       )
     *          ),
     *     @Swagger\Response(response="201", description="Categoria atualizada")
     * )
     * @param CategoryRequest $request
     * @param  string $id
     * @return Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = $this->repository->update($request->all(),$id);
        return response()->json($category, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @Swagger\DELETE(
     *     path="/api/categories/{id}",
     *     description="Excluir categoria",
     *     @Swagger\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @Swagger\Parameter(
     *          name="id", in="path", required=true, type="integer"
     *     ),
     *     @Swagger\Response(response="204", description="No content")
     * )
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if($deleted){
            return response()->json([], 204);
        }else{
            return response()->json([
                'error' => 'Resource can not be deleted'
            ], 500);
        }
    }
}
