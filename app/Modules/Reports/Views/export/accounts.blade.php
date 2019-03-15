<table class="table table-striped- table-bordered table-hover table-checkable" id="table-report">
    <thead>
        <tr>
            <th colspan="8" style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Relatório de contas</th>
        </tr>
        <tr>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Conta</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Descrição</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Unidade</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Tipo</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Data</th>
            <th style="text-align: center; background-color: #c6007d; color: #FFFFFF;">Valor</th>
        </tr>
    </thead>
    <tbody>
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
                <td colspan="6">Nenhum registro encontrado</td>
            </tr>
        @endif
    </tbody>
</table>