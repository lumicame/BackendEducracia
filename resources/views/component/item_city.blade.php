<tr id="tr_city_{{$d->id}}">
            <th scope="row">{{$d->id}}</th>
            <td>{{$d->name}}</td>
            <td><div class="btn-group" role="group" aria-label="Basic example">
              <button type="button" class="btn btn-primary btn-sm btn_city_edit" data-bs-toggle="modal" data-bs-target="#CityEditModal" data-id="{{$d->id}} " data-name="{{$d->name}} ">Editar</button>
              <!-- <button type="button" class="btn btn-danger btn-sm btn_city_delete" data-id="{{$d->id}} ">Eliminar</button> -->
            </div></td>
          </tr>