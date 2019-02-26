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
                            Comissão
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
                        <div class="col-lg-">
                            @component('Units::components.units', ['multiple' => true])
                            @endcomponent
                        </div>
                        <div class="col-lg-6">
                            @component('Employees::components.employees', ['placeholder' => 'Selecionar os terapeutas'])
                            @endcomponent
                        </div>
                        <div class="col-lg-3">
                            @component('Services::components.services', ['multiple' => 'multiple'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-lg-3">
                            <label>
                                Data inicial
                            </label>
                            <input name="start" type="text" class="form-control m-input mask-dateTime" id="start" placeholder="">
                        </div>
                        <div class="col-lg-3">
                            <label>
                                Data final
                            </label>
                            <input name="end" type="text" class="form-control m-input mask-dateTime" id="end" placeholder="">
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
                            <a href="{{route('reports.commissions.excel')}}" class="btn btn-dark m-btn m-btn--custom m-btn--icon m-btn--air" id="btn-excel">
                                <span>
                                    <i class="la la-file-excel-o"></i>
                                    <span>
                                        Exportar Excel
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="{{route('reports.commissions.pdf')}}" class="btn btn-dark m-btn m-btn--custom m-btn--icon m-btn--air">
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
            <div class="m-portlet__body">
                <table class="table table-striped- table-bordered table-hover table-checkable table-responsive" id="table-report">
                    <thead>
                    <tr>
                        <th>Unidade</th>
                        <th>Serviço</th>
                        <th>Data inicial</th>
                        <th>Data final</th>
                        <th>Terapeuta</th>
                        <th>Valor serviço</th>
                        <th>Valor desconto</th>
                        <th>Tipo desconto</th>
                        <th>Valor total</th>
                        <th>Porcentagem comissão</th>
                        <th>Valor comissão</th>
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
                            <td colspan="6">Nenhum registro encontrado</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div id="report-customer" style="height: 500px;"></div>
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
                        url: '{{route('reports.commissions.filter')}}',
                        type: 'POST',
                        data: $(form).serialize(),
                        beforeSend: function(xhr, type) {
                            if (!type.crossDomain) {
                                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                            }
                        },
                        success: function (data) {
                            $('#table-report tbody').html(data.table);
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
