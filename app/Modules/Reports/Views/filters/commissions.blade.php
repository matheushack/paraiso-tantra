@if(!empty($data))
    @foreach($data as $report)
        <tr>
            <td>{{$report->unity}}</td>
            <td>{{$report->service}}</td>
            <td>{{\Carbon\Carbon::parse($report->start)->format('d/m/Y H:i:s')}}</td>
            <td>{{\Carbon\Carbon::parse($report->end)->format('d/m/Y H:i:s')}}</td>
            <td>{{$report->employee}}</td>
            <td>{{'R$ '.number_format($report->amount, 2, ',', '.')}}</td>
            <td>{{'R$ '.number_format($report->discount, 2, ',', '.')}}</td>
            <td>{{$report->type_discount}}</td>
            <td>{{'R$ '.number_format($report->total, 2, ',', '.')}}</td>
            <td>{{$report->commission > 0 ? number_format($report->commission, 2, ',', '.').'%' : '0,00%'}}</td>
            <td>{{'R$ '.number_format($report->amountCommission, 2, ',', '.')}}</td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="8">Nenhum registro encontrado</td>
    </tr>
@endif