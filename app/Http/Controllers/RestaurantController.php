<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\restaurants;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return restaurants::join('categories','restaurants.category_id','=','categories.id')->
                            select(
                                'restaurants.id as id',
                                'restaurants.name as name',
                                'restaurants.description as description',
                                'restaurants.created_at as created_at',
                                'restaurants.updated_at as updated_at',
                                'categories.name as category_name'
                                
                            )
                    ->get()->toArray();
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
            return json_encode(array('title'=> 'É necessário informar o nome do Restaurante!', 'description'=>'','status'=>'error'),JSON_FORCE_OBJECT);
        }
        if(empty($request->input('description'))){
            return json_encode(array('title'=> 'É necessário informar a descrição do Restaurante!', 'description'=>'','status'=>'error'),JSON_FORCE_OBJECT);
        }
        if(empty($request->input('category_id')) || $request->input('category_id') === '0'){

            return json_encode(array('title'=> 'É necessário selecionar a categoria do Restaurante!', 'description'=>'','status'=>'error'),JSON_FORCE_OBJECT);
        }

        restaurants::insert(
                                array(
                                    'name'=>$request->input('name'),
                                    'category_id'=>intval($request->input('category_id')),
                                    'description'=>$request->input('description'),
                                    'created_at'=>date('Y-m-d H:i:s')
                                )
                            );

        return json_encode(array('title'=> 'Restaurante Cadastrado !', 'description'=>'','status'=>'success'),JSON_FORCE_OBJECT);
           
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
        if(empty($request->input('name'))){
            return json_encode(array('title'=> 'É necessário informar o nome do Restaurante!', 'description'=>'','status'=>'error'),JSON_FORCE_OBJECT);
        }
        if(empty($request->input('description'))){
            return json_encode(array('title'=> 'É necessário informar a descrição do Restaurante!', 'description'=>'','status'=>'error'),JSON_FORCE_OBJECT);
        }

        restaurants::where('id',$id)->update(
                                                array(
                                                    'name'=>$request->input('name'),
                                                    'description'=>$request->input('description'),
                                                    'updated_at'=>date('Y-m-d H:i:s')
                                                )
                                            );

        return json_encode(array('title'=> 'Restaurante Atualizado !', 'description'=>'','status'=>'success'),JSON_FORCE_OBJECT);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        restaurants::where('id',$id)->update(
            array(
                'deleted_at'=>date('Y-m-d H:i:s')
            )
        );

        return json_encode(array('title'=> 'Restaurante Deletado !', 'description'=>'','status'=>'success'),JSON_FORCE_OBJECT);

    }
}
