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
                            Contas
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
                            @component('Accounts::components.accounts', ['account_id' => $account_id])
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

        <div class="m-portlet ">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-md-12 col-lg-6 col-xl-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item" id="accounts-recipe">
                                <h4 class="m-widget24__title">
                                    <i class="fa fa-plus-square"></i> Receitas
                                </h4><br>
                                <div class="m--space-10"></div>
                                <span class="m-widget24__stats m--font-success left">{{'R$ '.number_format($totalRecipe, 2, ',', '.')}}</span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-success" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item" id="accounts-expense">
                                <h4 class="m-widget24__title">
                                    <i class="fa fa-minus-square"></i> Despesas
                                </h4><br>
                                <div class="m--space-10"></div>
                                <span class="m-widget24__stats m--font-danger left">{{'R$ '.number_format($totalExpense, 2, ',', '.')}}</span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item" id="accounts-call">
                                <h4 class="m-widget24__title">
                                    <i class="fa fa-plus-square"></i> Atendimentos
                                </h4><br>
                                <div class="m--space-10"></div>
                                <span class="m-widget24__stats m--font-success left">{{'R$ '.number_format($totalCalls, 2, ',', '.')}}</span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-success" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item" id="accounts-total">
                                <h4 class="m-widget24__title">
                                    <i class="fa fa-money"></i> Total
                                </h4><br>
                                <div class="m--space-10"></div>
                                <span class="m-widget24__stats m--font-{{$total >= 0 ? 'success' : 'danger'}} left">{{'R$ '.number_format($total, 2, ',', '.')}}</span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-{{$total >= 0 ? 'success' : 'danger'}}" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="" data-url="{{route('reports.accounts.excel')}}" class="btn btn-dark m-btn m-btn--custom m-btn--icon m-btn--air" id="btn-excel">
                                <span>
                                    <i class="la la-file-excel-o"></i>
                                    <span>
                                        Exportar Excel
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="" data-url="{{route('reports.accounts.pdf')}}" class="btn btn-dark m-btn m-btn--custom m-btn--icon m-btn--air" id="btn-pdf">
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
                        <th>Conta</th>
                        <th style="width: 50%;">Descrição</th>
                        <th>Unidade</th>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>Valor</th>
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
                        url: '{{route('reports.accounts.filter')}}',
                        type: 'POST',
                        data: $(form).serialize(),
                        beforeSend: function(xhr, type) {
                            if (!type.crossDomain) {
                                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                            }
                        },
                        success: function (data) {
                            var recipe = $('#accounts-recipe');
                            var expense = $('#accounts-expense');
                            var call = $('#accounts-call');
                            var total = $('#accounts-total');

                            $('#table-report tbody').html(data.table);

                            recipe.find('.m-widget24__stats').html(data.totalRecipe);
                            expense.find('.m-widget24__stats').html(data.totalExpense);
                            call.find('.m-widget24__stats').html(data.totalCall);
                            total.find('.m-widget24__stats').html(data.total);

                            if(data.isPositive) {
                                total.find('.m-widget24__stats').removeClass('m--font-danger').addClass('m--font-success');
                                total.find('.progress-bar').removeClass('m--bg-danger').addClass('m--bg-success');
                            }else{
                                total.find('.m-widget24__stats').removeClass('m--font-success').addClass('m--font-danger');
                                total.find('.progress-bar').removeClass('m--bg-success').addClass('m--bg-danger');
                            }
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
