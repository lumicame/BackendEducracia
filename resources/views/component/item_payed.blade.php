<table class="table table-sm">
        <thead >
          <tr>
             <th scope="col">id</th>
            <th scope="col">Para:</th>
            <th scope="col">Banco</th>
            <th scope="col">Tipo de cuenta</th>
            <th scope="col"># Cuenta</th>
            <th scope="col">Total</th>
            <th scope="col">Estado</th>
            <th scope="col">Fecha</th>
          </tr>
        </thead>
        <tbody id="Content_Payed">
          @foreach($payeds as $t)
          <tr id="tr_payed_{{$t->id}}">
            <td scope="row">{{$t->id}}</td>
            <td>{{$t->user->name}}</td>
            <td>{{$t->banco}}</td>
            <td>{{$t->account_type}}</td>
            <td>{{$t->account_id}}</td>
            <td>{{number_format($t->ammount)}}</td>
            <td><span class="badge bg-success">Pagado</span></td>
            <td>{{$t->updated_at_formatted}}</td>
          </tr>
          @endforeach

        </tbody>
        
      </table>
      {{ $payeds->links() }}