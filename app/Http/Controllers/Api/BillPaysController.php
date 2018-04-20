<?php

namespace SON\Http\Controllers\Api;

use SON\Http\Controllers\Controller;
use SON\Http\Requests\BillPayRequest;
use SON\Repositories\BillPayRepository;


class BillPaysController extends Controller
{

    /**
     * @var BillPayRepository
     */
    protected $repository;

    public function __construct(BillPayRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->applyMultitenancy();
    }


    /**
     * Display a listing of the resource.
     *
     * @Swagger\GET(
     *     path="/api/bill_pays",
     *     description="Listar contas a pagar",
     *     @Swagger\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @Swagger\Response(response="200", description="Coleção de contas a pagar")
     * )
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
     *     path="/api/bill_pays",
     *     description="Criar conta a pagar",
     *     @Swagger\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @Swagger\Parameter(
     *          name="body", in="body", required=true,
     *       @Swagger\Schema(
     *          @Swagger\Property( property="name", type="string" ),
     *          @Swagger\Property( property="date_due", type="string", format="date"),
     *          @Swagger\Property( property="value", type="number"),
     *          @Swagger\Property( property="category_id", type="integer"),
     *       )
     *          ),
     *     @Swagger\Response(response="201", description="Conta a pagar criada")
     * )
     * @param  BillPayRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BillPayRequest $request)
    {
        $data = $request->except('done');
        $billPay = $this->repository->create($data);
        return response()->json($billPay,201);
    }


    /**
     * Display the specified resource.
     *
     * @Swagger\GET(
     *     path="/api/bill_pays/{id}",
     *     description="Listar uma conta a pagar",
     *     @Swagger\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @Swagger\Parameter(
     *          name="id", in="path", required=true, type="integer"
     *          ),
     *     @Swagger\Response(response="200", description="Conta a pagar encontrada")
     * )
     *
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
     * * @Swagger\PUT(
     *     path="/api/bill_pays/{id}",
     *     description="Atualizar conta a pagar",
     *     @Swagger\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @Swagger\Parameter(
     *          name="id", in="path", required=true, type="integer"
     *          ),
     *     @Swagger\Parameter(
     *          name="body", in="body", required=true,
     *       @Swagger\Schema(
     *          @Swagger\Property( property="name", type="string" ),
     *          @Swagger\Property( property="date_due", type="string", format="date"),
     *          @Swagger\Property( property="value", type="number"),
     *          @Swagger\Property( property="category_id", type="integer"),
     *          @Swagger\Property( property="done", type="boolean"),
     *       )
     *          ),
     *     @Swagger\Response(response="201", description="Conta a pagar atualizada")
     * )
     * @param  BillPayRequest $request
     * @param  string $id
     *
     * @return Response
     */
    public function update(BillPayRequest $request, $id)
    {
        $billPay = $this->repository->update($request->all(),$id);
        return response()->json($billPay,200);
    }


    /**
     * Remove the specified resource from storage.
     *
     *  @Swagger\DELETE(
     *     path="/api/bill_pays/{id}",
     *     description="Excluir conta a pagar",
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

    public function calculateTotal(){
        return $this->repository->calculateTotal();
    }
}
