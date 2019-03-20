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
            <td>{{'R$ '.number_format($report->amount, 2, ',', '.')}}</td>
            <td>{{$report->aliquot > 0 ? number_format($report->aliquot, 2, ',', '.').'%' : '0,00%'}}</td>
            <td>{{'R$ '.number_format($report->discount, 2, ',', '.')}}</td>
            <td>{{'R$ '.number_format($report->total, 2, ',', '.')}}</td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="13">Nenhum registro encontrado</td>
    </tr>
@endif