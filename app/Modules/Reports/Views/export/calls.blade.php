<table class="table table-striped- table-bordered table-hover table-checkable" id="table-report">
    <thead>
    <tr>
        <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;" colspan="13">
            Relatório de atendimentos
        </th>
    </tr>
    <tr>
        <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Cliente</th>
        <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Unidade</th>
        <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Sala</th>
        <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Terapeutas</th>
        <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Forma de pagamento</th>
        <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Serviço</th>
        <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Data inicial</th>
        <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Data final</th>
        <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Status</th>
        <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Valor</th>
        <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Alíquota</th>
        <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Desconto</th>
        <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Total</th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($data))
        @foreach($data as $report)
            <tr>
                <td>{{$report->customer}}</td>
                <td>{{$report->unity}}</td>
                <td>{{$report->room}}</td>
                <td>{{$report->employees}}</td>
                <td>{{$report->payment_method}}</td>
                <td>{{$report->service}}</td>
                <td>{{\Carbon\Carbon::parse($report->start)->format('d/m/Y H:i:s')}}</td>
                <td>{{\Carbon\Carbon::parse($report->end)->format('d/m/Y H:i:s')}}</td>
                <td>
                    @switch($report->status)
                        @case('A')
                        Aguardando pagamento
                        @break
                        @case('P')
                        Pago
                        @break
                    @endswitch
                </td>
                <td>{{$report->amount}}</td>
                <td>{{$report->aliquot}}</td>
                <td>{{$report->discount}}</td>
                <td>{{$report->total}}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="13">Nenhum registro encontrado</td>
        </tr>
    @endif
    </tbody>
</table>