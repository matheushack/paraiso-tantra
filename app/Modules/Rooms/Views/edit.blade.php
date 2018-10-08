@extends('layouts.admin')

@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <i class="flaticon-squares-4"></i> Salas
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{route('dashboard')}}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('rooms')}}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Salas
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">
                                {{$room->name}}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon m--hide">
                            <i class="la la-gear"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            <i class="la la-pencil"></i> {{$room->name}}
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-room">
                <input type="hidden" name="id" value="{{$room->id}}">
                @csrf
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-6">
                            <label>
                                Nome
                            </label>
                            <input name="name" type="text" value="{{$room->name}}" class="form-control m-input" id="name" placeholder="" required>
                        </div>
                        <div class="col-lg-3">
                            @component('Units::components.units', ['unity_id' => $room->unity_id])
                            @endcomponent
                        </div>
                        <div class="col-lg-3">
                            <label for="">Em funcionamento?</label>
                            <div class="m-radio-inline">
                                <label class="m-radio">
                                    <input type="radio" name="is_active" value="1" {{$room->is_active == 1 ? 'checked="checked"' : ''}}> Sim
                                    <span></span>
                                </label>
                                <label class="m-radio">
                                    <input type="radio" name="is_active" value="0" {{$room->is_active == 0 ? 'checked="checked"' : ''}}> Não
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions--right">
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-8">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Salvar
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="window.location='{{route('rooms')}}'">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            ParaisoTantra.masks();

            $("#form-room").validate({
                invalidHandler: function(event, validator) {
                    mApp.scrollTo("#form-room");

                    swal({
                        title: "",
                        text: "Existem alguns erros do seu formulário. Por favor, corrija-os!",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    });
                },

                submitHandler: function (form) {
                    $.ajax({
                        url: '{{route('rooms.update')}}',
                        type: 'POST',
                        data: $(form).serialize(),
                        beforeSend: function(xhr, type) {
                            if (!type.crossDomain) {
                                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                            }
                        },
                        success: function (data) {
                            if(data.save){
                                swal({
                                    title: 'Sala',
                                    text: data.message,
                                    type: 'success'
                                }).then(results => {
                                    window.location = "{{route('rooms')}}";
                                });
                            }else{
                                swal({
                                    title: 'Sala',
                                    text: data.message,
                                    type: 'error'
                                });
                            }
                        }
                    });

                    return false;
                }
            });

            $('input[required],select[required]').each(function(key, item){
                $(item).rules('add', {required: true});
            });

        });
    </script>
@endpush