@extends('layouts.admin')

@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <i class="flaticon-diagram"></i> Relatório
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{route('reports')}}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Atendimentos
                        </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">Filtro</h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body" style="margin-top: 0; padding-top: 0;">
                <form class="m-form m-form--fit m-form--label-align-right" id="form-report-filter" name="form-report-filter">
                    @csrf
                    <div class="form-group m-form__group row">
                        <div class="col-lg-3">
                            @component('Units::components.units', ['multiple' => true])
                            @endcomponent
                        </div>
                        <div class="col-lg-3">
                            <label>
                                Data inicial
                            </label>
                            <input name="start" type="text" class="form-control m-input mask-date" id="start" placeholder="">
                        </div>
                        <div class="col-lg-3">
                            <label>
                                Data final
                            </label>
                            <input name="end" type="text" class="form-control m-input mask-date" id="end" placeholder="">
                        </div>
                    </div>
                    <div class="m-form__actions m-form__actions--right">
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-8">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-search"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="{{route('reports.extract.excel')}}" class="btn btn-dark m-btn m-btn--custom m-btn--icon m-btn--air" id="btn-excel">
                                <span>
                                    <i class="la la-file-excel-o"></i>
                                    <span>
                                        Exportar Excel
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="{{route('reports.extract.pdf')}}" class="btn btn-dark m-btn m-btn--custom m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-file-pdf-o"></i>
                                    <span>
                                        Exportar PDF
                                    </span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12" id="extract">
                @if($extract->count() > 1)
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
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            ParaisoTantra.masks();

            $("#form-report-filter").validate({
                invalidHandler: function(event, validator) {
                    mApp.scrollTo("#form-report-filter");

                    swal({
                        title: "",
                        text: "Existem alguns erros do seu formulário. Por favor, corrija-os!",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    });
                },

                submitHandler: function (form) {
                    $.ajax({
                        url: '{{route('reports.extract.filter')}}',
                        type: 'POST',
                        data: $(form).serialize(),
                        beforeSend: function(xhr, type) {
                            if (!type.crossDomain) {
                                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                            }
                        },
                        success: function (data) {
                            $('#extract').html(data.table);
                        }
                    });

                    return false;
                }
            });

            $('input[required],select[required]').each(function(key, item){
                $(this).removeAttr('required');
            });
        });
    </script>
@endpush
