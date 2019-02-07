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