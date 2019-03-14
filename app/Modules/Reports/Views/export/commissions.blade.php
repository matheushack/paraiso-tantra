<table class="table table-striped- table-bordered table-hover table-checkable" id="table-report">
    <thead>
        <tr>
            <th colspan="8" style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Relatório de comissões</th>
        </tr>
        <tr>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Unidade</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Serviço</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Data inicial</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Data final</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Terapeutas</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Status</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Forma pagamento</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Valor serviço</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Valor desconto</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Tipo desconto</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Tipo total</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Porcentagem comissão</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Valor comissão</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($data))
            @foreach($data as $report)
                <tr>
                    <td>{{$report->unity}}</td>
                    <td>{{$report->service}}</td>
                    <td>{{\Carbon\Carbon::parse($report->start)->format('d/m/Y H:i:s')}}</td>
                    <td>{{\Carbon\Carbon::parse($report->end)->format('d/m/Y H:i:s')}}</td>
                    <td>{{$report->employee}}</td>
                    <td>{{$report->status}}</td>
                    <td>{{$report->payment_method}}</td>
                    <td>{{$report->amount}}</td>
                    <td>{{$report->discount}}</td>
                    <td>{{$report->type_discount}}</td>
                    <td>{{$report->total}}</td>
                    <td>{{$report->commission}}</td>
                    <td>{{$report->amountCommission}}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6">Nenhum registro encontrado</td>
            </tr>
        @endif
    </tbody>
</table>