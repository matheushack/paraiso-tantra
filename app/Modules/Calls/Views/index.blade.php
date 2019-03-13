@extends('layouts.admin')

@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <i class="flaticon-event-calendar-symbol"></i> Atendimentos
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{route('dashboard')}}" class="m-nav__link m-nav__link--icon">
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
        <div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30" role="alert">
            <div class="m-alert__icon m-alert__icon--top">
            </div>
            <div class="m-alert__text">
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-account" name="form-account">
                    @csrf
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                @component('Units::components.units', ['unity_id' => $unity_id, 'id' => 'filter_unity_id'])
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet" id="m_portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="javascript:void(0);" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air" id="btn-new-call" data-url="{{route('calls.create')}}">
                                        <span>
                                            <i class="la la-plus"></i>
                                            <span>
                                                Novo atendimento
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div id="atendimento" data-url="{{route('calls.calendar')}}" data-unity="{{isset($unity_id) ? $unity_id : ''}}" data-url-edit="{{url('atendimentos/editar/')}}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('Calls::includes.create')
    @include('Calls::includes.edit')
@endsection

@push('css')
    <link href="{{url('assets/vendors/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{url('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/vendors/custom/fullcalendar/locale-all.js')}}" type="text/javascript"></script>
    <script src="{{url('js/calendar.js').'?'.date('YmdHi')}}" type="text/javascript"></script>
@endpush