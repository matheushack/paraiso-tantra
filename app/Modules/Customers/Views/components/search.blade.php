@switch($status)
    @case ('success')
    <table class="table table-bordered m-table m-table--head-bg-pink">
        <thead>
        <th style="width: 20px;">#</th>
        <th>Nome</th>
        <th>Sexo</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>Celular</th>
        </thead>
        <tbody>
        @foreach($customers as $customer)
            <tr>
                <td>
                    <input type="radio" name="customer_id" class="customer-select" value="{{$customer->id}}">
                </td>
                <td>
                    {{$customer->name}}
                </td>
                <td>
                    {{$customer->gender}}
                </td>
                <td>
                    {{$customer->email}}
                </td>
                <td>
                    {{$customer->phone}}
                </td>
                <td>
                    {{$customer->cell_phone}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @break
    @case ('404')
    <div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-danger alert-dismissible fade show" role="alert">
        <div class="m-alert__icon">
            <i class="la la-user"></i>
        </div>
        <div class="m-alert__text">
            <strong>Não encontrado!</strong>
            <br>
            Nenhum cliente encontrado com os filtros acima
        </div>
    </div>
    @break
@endswitch
