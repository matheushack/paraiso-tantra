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