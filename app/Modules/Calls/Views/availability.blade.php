<div class="col-lg-12">
    @switch($status)
        @case ('success')
            @component('Employees::components.employees', ['options' => $employees])
            @endcomponent

            <table class="table table-bordered m-table m-table--head-bg-pink m--margin-top-10">
                <thead>
                    <th style="width: 20px;">#</th>
                    <th>Sala</th>
                    <th>Duração</th>
                    <th>Fim</th>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td>
                                <input type="radio" name="room_id" value="{{$room->id}}">
                            </td>
                            <td>
                                {{$room->name}}
                            </td>
                            <td>
                                {{$duration}} minutos
                            </td>
                            <td>
                                {{$end}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @break
        @case ('employees')
            <div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-danger alert-dismissible fade show" role="alert">
                <div class="m-alert__icon">
                    <i class="la la-user"></i>
                </div>
                <div class="m-alert__text">
                    <strong>Indisponibilidade!</strong>
                    <br>
                    Nenhum terapeuta está disponível no horário informado.
                </div>
            </div>

            @break
        @case ('rooms')
            <div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-danger alert-dismissible fade show" role="alert">
                <div class="m-alert__icon">
                    <i class="flaticon-squares-4"></i>
                </div>
                <div class="m-alert__text">
                    <strong>Indisponibilidade!</strong>
                    <br>
                    Nenhuma sala está disponível no horário informado.
                </div>
            </div>
            @break
        @case('validation')
            <div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-danger alert-dismissible fade show" role="alert">
                <div class="m-alert__icon">
                    <i class="la la-warning"></i>
                </div>
                <div class="m-alert__text">
                    <strong>Atenção!</strong>
                    <br>
                    Preencher todas as informações para busca de disponibilidade.
                </div>
            </div>
            @break
        @default
            <div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-danger alert-dismissible fade show" role="alert">
                <div class="m-alert__icon">
                    <i class="la la-warning"></i>
                </div>
                <div class="m-alert__text">
                    <strong>Indisponibilidade!</strong>
                    <br>
                    Não foi possível verificar a disponibilidade do terapeuta/sala. Por favor, tente mais tarde.
                </div>
            </div>
            @break
    @endswitch
</div>