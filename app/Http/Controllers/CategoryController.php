<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categories;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return categories::get()->toArray();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(empty($request->input('name'))){
            return json_encode(array('title'=> 'É necessário informar o nome da categoria!', 'description'=>'','status'=>'error'),JSON_FORCE_OBJECT);
        }
        $categoria = categories::where('name',$request->input('name'))->get()->toArray();
        
        if(empty($categoria)){
            
            categories::insert(array('name'=>$request->input('name'),'created_at'=>date('Y-m-d H:i:s')));

            return json_encode(array('title'=> 'Categoria Cadastrada !', 'description'=>'','status'=>'success'),JSON_FORCE_OBJECT);
        }else{
            return json_encode(array('title'=> 'Categoria Existente !', 'description'=>'','status'=>'warning'),JSON_FORCE_OBJECT);
        }
            


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if(empty($request->input('name'))){
            return json_encode(array('title'=> 'É necessário informar o nome da categoria!', 'description'=>'','status'=>'error'),JSON_FORCE_OBJECT);
        }
        $categoria = categories::where('name',$request->input('name'))->where('id','<>',$id)->get()->toArray();
        if(empty($categoria)){

            categories::where('id',$id)->update(array('name'=>$request->input('name'),'updated_at'=>date('Y-m-d H:i:s')));

            return json_encode(array('title'=> 'Categoria Atualizada !', 'description'=>'','status'=>'success'),JSON_FORCE_OBJECT);
        }else{
            return json_encode(array('title'=> 'Categoria Existente !', 'description'=>'Por favor informe outro nome.','status'=>'warning'),JSON_FORCE_OBJECT);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        categories::where('id',$id)->
                    update(array(
                        'deleted_at'=> date('Y-m-d H:i:s')
                    ));
        return json_encode(array('title'=> 'Categoria Deletada !', 'description'=>'','status'=>'success'),JSON_FORCE_OBJECT);

    }
}
