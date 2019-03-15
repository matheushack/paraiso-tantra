@if(!empty($data))
    @foreach($data as $report)
        <tr>
            <td>{{$report->account}}</td>
            <td>{{$report->description}}</td>
            <td>{{$report->unity}}</td>
            <td>
                @switch($report->type)
                    @case('A')
                        Atendimento
                    @break
                    @case('D')
                        Despesa
                    @break
                    @case('R')
                        Receita
                    @break
                @endswitch
            </td>
            <td>{{\Carbon\Carbon::parse($report->date)->format('d/m/Y')}}</td>
            <td>{{'R$ '.number_format($report->amount, 2, ',', '.')}}</td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="8">Nenhum registro encontrado</td>
    </tr>
@endif