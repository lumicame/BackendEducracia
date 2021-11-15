<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <style type="text/css">
              body {
      background-color: #f9f9fa
    }

    .flex {
      -webkit-box-flex: 1;
      -ms-flex: 1 1 auto;
      flex: 1 1 auto
    }

    @media (max-width:991.98px) {
      .padding {
          padding: 1.5rem
      }
    }

    @media (max-width:767.98px) {
      .padding {
          padding: 1rem
      }
    }

    .padding {
      padding: 5rem
    }

    .card {
      background: #fff;
      border-width: 0;
      border-radius: .25rem;
      box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
      margin-bottom: 1.5rem
    }

    .card-header {
      background-color: transparent;
      border-color: rgba(160, 175, 185, .15);
      background-clip: padding-box
    }

    .card-body p:last-child {
      margin-bottom: 0
    }

    .card-hide-body .card-body {
      display: none
    }

    .form-check-input.is-invalid~.form-check-label,
    .was-validated .form-check-input:invalid~.form-check-label {
      color: #f54394
    }
  </style>
    </head>
    <body >
      <nav class="navbar navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="{{asset('logo.jpeg')}}" alt="" width="30" height="24">Educracia
    </a>
    <form method="POST" id="form" action="{{route('logout')}}">
                           @csrf
                           <button type="submit" class="nav-item" >Cerrar Sesión</a>
                      </form>
  </div>
</nav>
<div class="container">
  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="pills-city-tab" data-bs-toggle="pill" data-bs-target="#pills-city" type="button" role="tab" aria-controls="pills-city" aria-selected="true">Ciudades</button>
    </li>

    <li class="nav-item" role="presentation">
      <button class="nav-link" id="pills-type-tab" data-bs-toggle="pill" data-bs-target="#pills-type" type="button" role="tab" aria-controls="pills-type" aria-selected="false">Categorias</button>
    </li>

    <li class="nav-item" role="presentation">
      <button class="nav-link" id="pills-transaction-tab" data-bs-toggle="pill" data-bs-target="#pills-transaction" type="button" role="tab" aria-controls="pills-transaction" aria-selected="false">Transacciones</button>
    </li>

    <li class="nav-item" role="presentation">
      <button class="nav-link" id="pills-retiro-tab" data-bs-toggle="pill" data-bs-target="#pills-retiro" type="button" role="tab" aria-controls="pills-retiro" aria-selected="false">Peticiones de retiros</button>
    </li>

    <li class="nav-item" role="presentation">
      <button class="nav-link" id="pills-payed-tab" data-bs-toggle="pill" data-bs-target="#pills-payed" type="button" role="tab" aria-controls="pills-payed" aria-selected="false">Pagos Realizados</button>
    </li>
  </ul>
</div>
<div class="container">
  <div class="tab-content" id="pills-tabContent">

    <div class="tab-pane fade show active" id="pills-city" role="tabpanel" aria-labelledby="pills-city-tab">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">Ciudad</th>
            <th scope="col">Opciones</th>
            <th scope="col"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#CityAddModal">Agregar ciudad</button></th>
          </tr>
        </thead>
        <tbody id="Content_City">
          @foreach($departments as $d)
          @include('component.item_city')
          @endforeach

        </tbody>
      </table>
    </div>

    <div class="tab-pane fade" id="pills-type" role="tabpanel" aria-labelledby="pills-type-tab">
      <table class="table">
        <thead >
          <tr>
            <th scope="col">id</th>
            <th scope="col">Nombre</th>
            <th scope="col">Opciones</th>
            <th scope="col"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#TypeAddModal">Agregar categoria</button></th>
          </tr>
        </thead>
        <tbody id="Content_Type">
          @foreach($types as $t)
          @include('component.item_type')
          @endforeach

        </tbody>
      </table>
    </div>

    <div class="tab-pane fade" id="pills-transaction" role="tabpanel" aria-labelledby="pills-transaction-tab">
      <div id="content_transaction">
        @include('component.item_transaction')
      </div>
      <div class="row">
        
        <center>
          <?php
            $trans=App\Models\Transaction::where('state','APPROVED')->get();
            $total=$trans->sum('ammount');
            $pagado=$trans->where('payed',1)->sum('ammount');
            $pendiente=$total-$pagado;
           ?>
          <span># transacciones: {{$trans->count()}}</span>
          <br>
          <span>Total Transacciones: {{number_format($total)}}</span>
          <br>
          <span>Total Pagado: {{number_format($pagado)}}</span>
          <br>
          <span>Total Pendiente: @if($pendiente>0)
          {{number_format($pendiente)}} @else 0 @endif</span>
        </center>
      </div>
    </div>

    <div class="tab-pane fade" id="pills-retiro" role="tabpanel" aria-labelledby="pills-retiro-tab">
      
          @include('component.item_retiro')
          

    </div>
<div class="tab-pane fade" id="pills-payed" role="tabpanel" aria-labelledby="pills-payed-tab">
          @include('component.item_payed')
    </div>
  </div>
</div>
<!-- Modal ADD CIUDAD-->
<div class="modal fade" id="CityAddModal" tabindex="-1" aria-labelledby="CityAddModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Ciudad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formCityAdd">
        @csrf
        <div class="modal-body">

          <div class="form-group">
            <label for="inputName">Nombre Ciudad</label>
            <input type="text" class="form-control" name="name" id="inputAddCityName" placeholder="Armenia, Quindío" required="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" id="btn_save" class="btn btn-primary">Guardar</button>
        </div>
      </form>
      
    </div>
  </div>
</div>
<!-- END Modal ADD CIUDAD-->

<!-- Modal EDIT CIUDAD-->
<div class="modal fade" id="CityEditModal" tabindex="-1" aria-labelledby="CityEditModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Ciudad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formCityEdit">
        @csrf
        <div class="modal-body">

          <div class="form-group">
            <label for="inputName">Nombre Ciudad</label>
            <input type="text" class="form-control" name="name" id="inputEditCityName" placeholder="Armenia, Quindío" required="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" id="btn_save" class="btn btn-primary">Guardar</button>
        </div>
      </form>
      
    </div>
  </div>
</div>
<!-- END Modal EDIT CIUDAD-->

<!-- Modal ADD TYPE-->
<div class="modal fade" id="TypeAddModal" tabindex="-1" aria-labelledby="TypeAddModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Categoria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formTypeAdd">
        @csrf
        <div class="modal-body">

          <div class="form-group">
            <label for="inputName">Nombre Categoria</label>
            <input type="text" class="form-control" name="name" id="inputAddTypeName" placeholder="Educación" required="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" id="btn_save" class="btn btn-primary">Guardar</button>
        </div>
      </form>
      
    </div>
  </div>
</div>
<!-- END Modal ADD TYPE-->

<!-- Modal EDIT TYPE-->
<div class="modal fade" id="TypeEditModal" tabindex="-1" aria-labelledby="TypeEditModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Categoria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <form id="formTypeEdit">
        @csrf
      <div class="modal-body">
       
  <div class="form-group">
    <label for="inputName">Nombre Ciudad</label>
    <input type="text" class="form-control" name="name" id="inputEditTypeName" placeholder="Educación" required="">
  </div>
</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" id="btn_save" class="btn btn-primary">Guardar</button>
      </div>
</form>
      
    </div>
  </div>
</div>
<!-- END Modal EDIT TYPE-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('js/educracia.js')}}"></script>
</body>
</html>