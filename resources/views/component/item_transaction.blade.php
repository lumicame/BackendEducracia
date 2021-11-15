<table class="table table-sm">
        <thead >
          <tr>
            <th scope="col">id</th>
            <th scope="col">ID transacción</th>
            <th scope="col">De:</th>
            <th scope="col">Para:</th>
            <th scope="col">Total</th>
            <th scope="col">Estado</th>
            <th scope="col">Fecha</th>
          </tr>
        </thead>
        <tbody id="Content_Transaction">
          @foreach($transactions as $t)
          <tr id="tr_transaction_{{$t->id}}">
            <td scope="row">{{$t->id}}</td>
            <td>{{$t->transaction_id}}</td>
            <td>{{$t->user->name}}</td>
            <td>{{$t->project->user->name}}</td>
            <td>{{number_format($t->ammount)}}</td>
            <td><span class="badge bg-success">Aprobado</span></td>
            <td>{{$t->created_at_formatted}}</td>
          </tr>
          @endforeach

        </tbody>
        
      </table>
      {{ $transactions->links() }}
