@if($extract->count() > 0)
    @php
        $total = 0;
    @endphp
    @foreach($extract as $date => $items)
        @if($date == 'total')
            @continue
        @endif

        <div class="m-portlet m-portlet--creative m-portlet--bordered-semi m-0">
            <div class="m-portlet__head" style="height: 1px;">
                <div class="m-portlet__head-caption">
                    <h2 class="m-portlet__head-label m-portlet__head-label--info">
                        <span><i class="m-menu__link-icon flaticon-calendar"></i> {{\Carbon\Carbon::parse($date)->format('d/m/Y')}}</span>
                    </h2>
                </div>
            </div>
            <div class="m-portlet__body">
                <table class="table">
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $subtotal = 0;
                    @endphp
                    @foreach($items as $item)
                        @php
                            if($item->isNegative)
                               $subtotal = $subtotal - $item->amount;
                            else
                               $subtotal = $subtotal + $item->amount;
                        @endphp

                        <tr>
                            <td class="font-weight-bold">{{$item->name}}</td>
                            <td align="right" class="font-weight-bold {{$item->isNegative ? 'text-danger' : 'text-success'}}">{{$item->isNegative ? '-' : ''}} R$ {{number_format($item->amount, 2, ',', '.')}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfooter>
                        <tr style="background: #DDD;color: #333;">
                            <td class="font-weight-bold">Subtotal</td>
                            <td align="right" class="font-weight-bold {{$subtotal < 0 ? 'text-danger' : 'text-success'}}">R$ {{number_format($subtotal, 2, ',', '.')}}</td>
                        </tr>
                    </tfooter>
                </table>
            </div>
        </div>
        @php
            $total = $total + $subtotal;
        @endphp
    @endforeach

    <div class="m-portlet m-portlet--creative m-portlet--bordered-semi m-0">
        <div class="m-portlet__body">
            <table class="table">
                <tbody>
                <tr style="background: #343a40;color: #FFF; font-size: 18px;">
                    <td class="font-weight-bold">Total</td>
                    <td align="right" class="font-weight-bold {{$total < 0 ? 'text-danger' : 'text-success'}}">R$ {{number_format($total, 2, ',', '.')}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="m-portlet m-portlet--creative m-portlet--bordered-semi m-0">
        <div class="m-portlet__body">
            <p class="text-center">Nenhum registro encontrado</p>
        </div>
    </div>
@endif