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
                            @component('Customers::components.customers', ['notSearch' => true])
                            @endcomponent
                        </div>
                        <div class="col-lg-3">
                            @component('Units::components.units', ['multiple' => true])
                            @endcomponent
                        </div>
                        <div class="col-lg-3">
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
                            @component('Calls::components.status_payment')
                            @endcomponent
                        </div>
                        <div class="col-lg-3">
                            @component('PaymentMethods::components.payments')
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
                            <a  href="" data-url="{{route('reports.calls.excel')}}" class="btn btn-dark m-btn m-btn--custom m-btn--icon m-btn--air" id="btn-excel">
                                <span>
                                    <i class="la la-file-excel-o"></i>
                                    <span>
                                        Exportar Excel
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a  href="" data-url="{{route('reports.calls.pdf')}}" class="btn btn-dark m-btn m-btn--custom m-btn--icon m-btn--air">
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
                <table class="table table-striped- table-bordered table-hover table-responsive" id="table-report">
                    <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Unidade</th>
                        <th>Sala</th>
                        <th>Terapeutas</th>
                        <th>Forma de pagamento</th>
                        <th>Serviço</th>
                        <th>Data inicial</th>
                        <th>Data final</th>
                        <th>Status</th>
                        <th>Data compensação</th>
                        <th>Valor atendimento</th>
                        <th>Valor cobrado</th>
                        <th>Alíquota</th>
                        <th>Desconto</th>
                    </tr>
                    </thead>
                    <tbody>
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
                                <td>{{!empty($report->date_in_account) ? \Carbon\Carbon::parse($report->date_in_account)->format('d/m/Y') : ''}}</td>
                                <td>{{'R$ '.number_format($report->total, 2, ',', '.')}}</td>
                                <td>{{'R$ '.number_format($report->amount, 2, ',', '.')}}</td>
                                <td>{{$report->aliquot > 0 ? number_format($report->aliquot, 2, ',', '.').'%' : '0,00%'}}</td>
                                <td>{{'R$ '.number_format($report->discount, 2, ',', '.')}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="13">Nenhum registro encontrado</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            ParaisoTantra.masks();

            $('body').on('click', '#btn-excel', function(e){
                var url = $(this).data('url');
                var form = $("#form-report-filter").serialize();

                $(this).attr('href', url+"?"+form);

                return true;
            });

            $('body').on('click', '#btn-pdf', function(e){
                var url = $(this).data('url');
                var form = $("#form-report-filter").serialize();

                $(this).attr('href', url+"?"+form);

                return true;
            });

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
                        url: '{{route('reports.calls.filter')}}',
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
