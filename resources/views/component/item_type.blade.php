<tr id="tr_type_{{$t->id}}">
            <th scope="row">{{$t->id}}</th>
            <td>{{$t->name}}</td>
            <td><div class="btn-group" role="group" aria-label="Basic example">
              <button type="button" class="btn btn-primary btn-sm btn_type_edit" data-bs-toggle="modal" data-bs-target="#TypeEditModal" data-id="{{$t->id}} " data-name="{{$t->name}} ">Editar</button>
              <!-- <button type="button" class="btn btn-danger btn-sm btn_city_delete" data-id="{{$t->id}} ">Eliminar</button> -->
            </div></td>
          </tr>