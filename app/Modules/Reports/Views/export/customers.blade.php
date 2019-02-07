<table class="table table-striped- table-bordered table-hover table-checkable" id="table-report">
    <thead>
        <tr>
            <th colspan="8" style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Relatório de clientes</th>
        </tr>
        <tr>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Cliente</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Telefone</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Celular</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Unidade</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Terapeutas</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Serviço</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Data inicial</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Data final</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($data))
            @foreach($data as $report)
                <tr>
                    <td>{{$report->name}}</td>
                    <td>{{$report->phone}}</td>
                    <td>{{$report->cell_phone}}</td>
                    <td>{{$report->unity}}</td>
                    <td>{{$report->employees}}</td>
                    <td>{{$report->service}}</td>
                    <td>{{\Carbon\Carbon::parse($report->start)->format('d/m/Y H:i:s')}}</td>
                    <td>{{\Carbon\Carbon::parse($report->end)->format('d/m/Y H:i:s')}}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8">Nenhum registro encontrado</td>
            </tr>
        @endif
    </tbody>
</table>