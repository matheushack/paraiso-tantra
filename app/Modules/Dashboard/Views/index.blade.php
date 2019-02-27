@extends('layouts.admin')

@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">
                    Dashboard
                </h3>
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="row">
            @if(!empty($dashboard['accounts']))
                @foreach($dashboard['accounts'] as $account => $data)
                    <div class="col-xl-6">
                        <div class="m-subheader" style="padding: 0;">
                            <div class="d-flex">
                                <div class="mr-auto">
                                    <h3 class="m-subheader__title ">
                                        <i class="flaticon-pie-chart"></i> {{$account}}
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <div class="m-portlet m-portlet--head-overlay m-portlet--full-height">
                            <div class="m-portlet__head m-portlet__head--fit-">
                                <div class="m-portlet__head-tools">
                                    <div class="btn-group float-right m--padding-10">
                                        @component('components.months', ['months' => $dashboard['months'], 'selected' => $dashboard['monthSelected'], 'dashboard' => true])
                                        @endcomponent
                                        @component('components.years', ['years' => $dashboard['years'], 'selected' => $dashboard['yearSelected'], 'dashboard' => true])
                                        @endcomponent
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__body">
                                <div class="m-widget27 m-portlet-fit--sides">
                                    <div class="m-widget27__pic dashboard">
                                        <div class="text-center" style="width: 100%;height: 286px;background: #CCC;">
                                            <i class="flaticon-pie-chart" style="font-size: 14em;color: #FFF;opacity: 0.2"></i>
                                        </div>
                                        <h3 class="m-widget27__title m--font-light">
                                            <span class="display-4 text-center" style="display: block">
                                                <span class="font-weight-bold">Total</span>
                                            </span>
                                            <span>
                                                <span id="account-total" class="{{$data['classTotal']}}">{{$data['total_in_out']}}</span>
                                            </span>
                                        </h3>
                                        <div class="m-widget27__btn">
                                            <button type="button" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--bolder">
                                                Detalhes
                                            </button>
                                        </div>
                                    </div>
                                    <div class="m-widget27__container">
                                        <div class="m-widget27__tab tab-content m-widget27--no-padding">
                                            <div id="m_personal_income_quater_1" class="tab-pane active">
                                                <div class="row  align-items-center">
                                                    <div class="col">
                                                        <div class="m-widget27__chart entradas_saidas" style="height: 180px" data-percentage-in="{{$data['percentage_account_in']}}" data-percentage-out="{{$data['percentage_account_out']}}">
                                                            <div class="m-widget27__stat">
                                                                <i class="flaticon-more" style="font-size: 2em;"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="m-widget27__legends">
                                                            <div class="m-widget27__legend">
                                                                <span class="m-widget27__legend-bullet m--bg-success"></span>
                                                                <span class="m-widget27__legend-text" id="detail-account-in">
                                                                    <strong>{{$data['accounts_in']}}</strong> de receitas
                                                                </span>
                                                            </div>
                                                            <div class="m-widget27__legend">
                                                                <span class="m-widget27__legend-bullet m--bg-danger"></span>
                                                                <span class="m-widget27__legend-text" id="detail-account-out">
                                                                    <strong>{{$data['accounts_out']}}</strong> de despesas
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{url('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
<script src="{{url('assets/app/js/dashboard.js')}}" type="text/javascript"></script>
@endpush