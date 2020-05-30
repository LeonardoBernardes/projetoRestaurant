@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="row">
                

                <div class="col-md-4">
                    <h2 class="h2-style">Nova Categoria</h2>
                    <input type="text" class="form-control" id="name_category" name="name_category" placeholder="Nome da Categoria">
                    <br>
                    <button class="btn btn-sm btn-success" id="save_category" onclick="saveCategory()"><i class="fa fa-plus"></i> Salvar</button>
                </div>
                <div class="col-md-8">
                    <h2 class="h2-style">Lista de Categorias</h2>
                        
                    <table class="table table-secondary table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Created_at</th>
                                <th scope="col">Updated_at</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="list_category">
                            
                        </tbody>
                    </table>
                        

                </div>

            </div>
            <hr>
            <div class="row">

                <div class="col-md-4">
                    <h2 class="h2-style">Novo Restaurante</h2>
                    <input type="text" class="form-control" id="name_restaurant" placeholder="Nome">
                    <input type="text" class="form-control" id="description_restaurant" placeholder="Descrição">
                    <br>
                    <label for="" class="">Selecione a categoria abaixo:</label>
                    <select id="select_category" name="select_category" class="form-control" disabled>
                       
                    </select>
                    <br>
                    <button class="btn btn-sm btn-success" onclick="saveRestaurant()"><i class="fa fa-plus"></i> Salvar</button>
                </div>
                <div class="col-md-8">
                    <h2 class="h2-style">Lista de Restaurantes</h2>
                        
                    <table class="table table-secondary table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Category</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Created_at</th>
                                <th scope="col">Updated_at</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="list_restaurants">
                            
                        </tbody>
                    </table>
                        

                </div>

            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="My-Modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              <h4 class="modal-title">Editar Categoria</h4>
            </div>
            <div class="modal-body">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
              <button type="button" class="btn btn-primary">Atualizar</button>
            </div>
          </div> 
        </div>
    </div>
    <div class="modal fade" id="My-Modal2" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              <h4 class="modal-title">Editar Restaurante</h4>
            </div>
            <div class="modal-body">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
              <button type="button" class="btn btn-primary">Atualizar</button>
            </div>
          </div>
        </div>
    </div>
</div>
<script src="{{ asset('/assets/jquery/dist/jquery.min.js') }}"></script>
<script>
    
    loadCategories();
    loadRestaurants();
    var select_category ='';
    function saveCategory(){

        const name = document.getElementById("name_category").value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({

            url: `{{route('category.store')}}`,
            type: 'POST',
            dataType: 'json',
            data: {'name':name},

        }).then(function(data) {

            // console.log(data.title)
            if(data.status === 'success'){
                Swal.fire(
                    data.title,
                    '',
                    data.status
                ).then((result) => {

                    loadCategories();
                })
                document.getElementById("name_category").value = '';

            }else{
                Swal.fire(
                    data.title,
                    '',
                    data.status
                )
                document.getElementById("name_category").value = '';
            }
            
        });
    }
    function loadCategories(){
     
        $.ajax({

            url: `{{route('category.index')}}`,
            type: 'GET',
            dataType: 'json',

        }).then(function(data) {

            var table = ``;
            select_category = `<option value="0">Selecione</option>`;
            document.getElementById('list_category').innerHTML = '';
            document.getElementById('select_category').innerHTML = '';
            
            if(data != ''){
                $('#select_category').attr('disabled',false);
            }

            $.each(data,function(key,value){
                table +=`   <tr>
                                <th scope="row">${value.id}</th>
                                <td>
                                    <input type="text" id="name_category_edit_${value.id}" class="form-control" value="${value.name}" disabled>
                                </td>
                                <td>${(value.created_at !== null) ? value.created_at : ''}</td>
                                <td>${(value.updated_at !== null) ? value.updated_at : ''}</td>
                                <td>
                                    <div class="row">

                                        <button id="btn_save_category_${value.id}" class="btn btn-sm btn-success hidden" style="margin-right: 4%"  onclick="saveEditCategory(${value.id})">
                                            <i class="fa fa-check"></i>
                                        </button>

                                        <button id="btn_edit_category_${value.id}" class="btn btn-sm btn-primary" style="margin-right: 4%" onclick="editCategory(${value.id})">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>

                                        <button class="btn btn-sm btn-danger" onclick="deleteCategory(${value.id})">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>`;
                
                var option = document.createElement('option');
                option.setAttribute('value',value.id);
                option.appendChild(document.createTextNode(value.name));
                select_category = document.getElementById('select_category');
                select_category.appendChild(option);
                
            });

            document.getElementById('list_category').innerHTML = table;
           
        });
    }

    function editCategory(id){
        $('#name_category_edit_'+id).attr('disabled',false);
        $('#btn_save_category_'+id).removeClass('hidden');
        $('#btn_edit_category_'+id).addClass('hidden');
    }
    function saveEditCategory(id){

        const name = document.getElementById("name_category_edit_"+id).value;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({

            url: `category/${id}`,
            type: 'PUT',
            dataType: 'json',
            data: {'name':name},

        }).then(function(data) {

            if(data.status === 'success'){
                Swal.fire(
                    data.title,
                    '',
                    data.status
                ).then((result) => {

                    loadCategories();
                    $('#name_category_edit_'+id).attr('disabled',true);
                    $('#btn_save_category_'+id).addClass('hidden');
                    $('#btn_edit_category_'+id).removeClass('hidden');
                })

            }else{
                Swal.fire(
                    data.title,
                    data.description,
                    data.status
                )
            }

        });

    }
    function deleteCategory(id){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({

            url: `category/${id}`,
            type: 'DELETE',
            dataType: 'json',
        }).then(function(data) {

            if(data.status === 'success'){
                Swal.fire(
                    data.title,
                    '',
                    data.status
                ).then((result) => {

                    loadCategories();
                    $('#name_category_edit_'+id).attr('disabled',true);
                    $('#btn_save_category_'+id).addClass('hidden');
                    $('#btn_edit_category_'+id).removeClass('hidden');
                })

            }else{
                Swal.fire(
                    data.title,
                    data.description,
                    data.status
                )
            }

        });
    }

    function saveRestaurant(){
        const name = document.getElementById("name_restaurant").value;
        const description = document.getElementById("description_restaurant").value;

        var select = document.getElementById('select_category');
        var category;
        if(select.options[select.selectedIndex] === undefined){
            Swal.fire(
                'Atenção !',
                'É necessário cadastrar uma categoria primeiro.',
                'warning'
            );
        }else{

            category = select.options[select.selectedIndex].value;
        }

       

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({

            url: `{{route('restaurant.store')}}`,
            type: 'POST',
            dataType: 'json',
            data: {
                'name':name,
                'description':description,
                'category_id':category,
            },

        }).then(function(data) {

            if(data.status === 'success'){
                Swal.fire(
                    data.title,
                    '',
                    data.status
                ).then((result) => {

                    loadRestaurants();
                })
                document.getElementById("name_restaurant").value = '';
                document.getElementById("description_restaurant").value = '';

            }else{
                Swal.fire(
                    data.title,
                    '',
                    data.status
                )
            }
            
        });
    }
    function loadRestaurants(){
     
        $.ajax({

            url: `{{route('restaurant.index')}}`,
            type: 'GET',
            dataType: 'json',

        }).then(function(data) {

            var table = ``;
            document.getElementById('list_restaurants').innerHTML = '';

            $.each(data,function(key,value){
                table +=`   <tr>
                                <th scope="row">${value.id}</th>
                                <td>
                                    ${value.category_name}
                                </td>
                                <td>
                                    <input type="text" id="name_restaurant_edit_${value.id}" class="form-control" value="${value.name}" disabled>
                                </td>
                                <td>
                                    <input type="text" id="description_restaurant_edit_${value.id}" class="form-control" value="${value.description}" disabled>
                                </td>
                                <td>${(value.created_at !== null) ? value.created_at : ''}</td>
                                <td>${(value.updated_at !== null) ? value.updated_at : ''}</td>
                                <td>
                                    <div class="row">
                                        <button id="btn_save_restaurant_${value.id}" class="btn btn-sm btn-success hidden" style="margin-right: 4%"  onclick="saveEditRestaurant(${value.id})">
                                            <i class="fa fa-check"></i>
                                        </button>

                                        <button id="btn_edit_restaurant_${value.id}" class="btn btn-sm btn-primary" style="margin-right: 4%" onclick="editRestaurant(${value.id})">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteRestaurant(${value.id})">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>`;

                            
            });

            document.getElementById('list_restaurants').innerHTML = table;
        });
    }
    function editRestaurant(id){
        $('#name_restaurant_edit_'+id).attr('disabled',false);
        $('#description_restaurant_edit_'+id).attr('disabled',false);
        $('#btn_save_restaurant_'+id).removeClass('hidden');
        $('#btn_edit_restaurant_'+id).addClass('hidden');
    }
    function saveEditRestaurant(id){

        const name = document.getElementById("name_restaurant_edit_"+id).value;
        const description = document.getElementById("description_restaurant_edit_"+id).value;
        var select = document.getElementById('select_category');
        const category = select.options[select.selectedIndex].value;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({

            url: `restaurant/${id}`,
            type: 'PUT',
            dataType: 'json',
            data: {
                'name':name,
                'description':description
            },

        }).then(function(data) {

            if(data.status === 'success'){
                Swal.fire(
                    data.title,
                    '',
                    data.status
                ).then((result) => {

                    loadRestaurants();
                    $('#name_restaurant_edit_'+id).attr('disabled',true);
                    $('#btn_save_restaurant_'+id).addClass('hidden');
                    $('#btn_edit_restaurant_'+id).removeClass('hidden');
                })

            }else{
                Swal.fire(
                    data.title,
                    data.description,
                    data.status
                )
            }

        });

    }
    function deleteRestaurant(id){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({

            url: `restaurant/${id}`,
            type: 'DELETE',
            dataType: 'json',
        }).then(function(data) {

            if(data.status === 'success'){
                Swal.fire(
                    data.title,
                    '',
                    data.status
                ).then((result) => {

                    loadRestaurants();
                    $('#name_restaurant_edit_'+id).attr('disabled',true);
                    $('#btn_save_restaurant_'+id).addClass('hidden');
                    $('#btn_edit_restaurant_'+id).removeClass('hidden');
                })

            }else{
                Swal.fire(
                    data.title,
                    data.description,
                    data.status
                )
            }

        });
    }

</script>
@endsection
