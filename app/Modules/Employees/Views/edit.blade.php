@extends('layouts.admin')

@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <i class="flaticon-profile-1"></i> Funcionários
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{route('dashboard')}}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('employees')}}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Funcionários
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">
                                {{$employee->name}}
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
                            <i class="la la-pencil"></i> {{$employee->name}}
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-employee">
                <input type="hidden" name="id" value="{{$employee->id}}">
                @csrf
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-5">
                            <label>
                                Nome
                            </label>
                            <input name="name" type="text" value="{{$employee->name}}" class="form-control m-input" id="name" placeholder="" required>
                        </div>
                        <div class="col-lg-2">
                            <label>
                                CPF
                            </label>
                            <input name="cpf" type="text" value="{{$employee->cpf}}" class="form-control m-input mask-cpf" id="cpf" placeholder="" required>
                        </div>
                        <div class="col-lg-2">
                            <label for="">Sexo</label>
                            <div class="m-radio-inline">
                                <label class="m-radio">
                                    <input type="radio" name="gender" value="M" {{$employee->gender == 'M' ? 'checked="checked"' : ''}}> M
                                    <span></span>
                                </label>
                                <label class="m-radio">
                                    <input type="radio" name="gender" value="F" {{$employee->gender == 'F' ? 'checked="checked"' : ''}}> F
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label>Data de nascimento</label>
                            <input name="birth_date" type="text" value="{{\Carbon\Carbon::parse($employee->birth_date)->format('d/m/Y')}}" class="form-control m-input mask-date" id="birth_date" required>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-lg-4">
                            <label>
                                Email
                            </label>
                            <input name="email" type="email" value="{{$employee->email}}" class="form-control m-input mask-email" id="email" placeholder="" required>
                        </div>
                        <div class="col-lg-4">
                            <label>
                                Telefone
                            </label>
                            <input name="phone" type="text" value="{{$employee->phone}}" class="form-control m-input mask-phone" id="phone" placeholder="">
                        </div>
                        <div class="col-lg-4">
                            <label>
                                Celular
                            </label>
                            <input name="cell_phone" type="text" value="{{$employee->cell_phone}}" class="form-control m-input mask-cell-phone" id="cell_phone" placeholder="" required>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-lg-4">
                            <label>Cor</label>
                            <div class="input-group colorpicker-component" id="color">
                                <input name="color" type="text" value="{{$employee->color}}" class="form-control m-input" required>
                                <span class="input-group-addon"><i></i></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label>Comissão</label>
                            <div class="m-bootstrap-touchspin-brand">
                                <input name="commission" type="text" value="{{$employee->commission}}" class="form-control m-input" id="commission" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label></label>
                            <div class="m-radio-inline">
                                <label class="m-checkbox">
                                    <input type="checkbox" name="is_access_system" value="1" {{$employee->is_access_system == 1 ? 'checked="checked"' : ''}}>Acesso ao sistema<span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-lg-12">
                            <label>Observações</label>
                            <textarea name="observation" id="observation" class="form-control" rows="5">{{$employee->observation}}</textarea>
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
                                <button type="button" class="btn btn-secondary" onclick="window.location='{{route('employees')}}'">
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

@push('css')
    <link href="{{url('js/bootstrap-colorpicker-2.5.2/dist/css/bootstrap-colorpicker.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .colorpicker-2x .colorpicker-saturation {
            width: 200px;
            height: 200px;
        }

        .colorpicker-2x .colorpicker-hue,
        .colorpicker-2x .colorpicker-alpha {
            width: 30px;
            height: 200px;
        }

        .colorpicker-2x .colorpicker-color,
        .colorpicker-2x .colorpicker-color div {
            height: 30px;
        }

        .colorpicker-component .input-group-addon{
            padding: 11px 8px 4px 8px;
            border-right: 1px solid #ebedf2;
            border-top: 1px solid #ebedf2;
            border-bottom: 1px solid #ebedf2;
            background-color: white;
            border-radius: .25rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{url('js/bootstrap-colorpicker-2.5.2/dist/js/bootstrap-colorpicker.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function(){
            ParaisoTantra.masks();

            $('#commission').TouchSpin({
                buttondown_class: 'btn btn-secondary',
                buttonup_class: 'btn btn-secondary',

                min: 0,
                max: 100,
                stepinterval: 1,
                maxboostedstep: 100,
                postfix: '%'
            });

            $('#color').colorpicker({
                customClass: 'colorpicker-2x',
                format: 'hex',
                sliders: {
                    saturation: {
                        maxLeft: 200,
                        maxTop: 200
                    },
                    hue: {
                        maxTop: 200
                    },
                    alpha: {
                        maxTop: 200
                    }
                }
            });

            $("#form-employee").validate({
                invalidHandler: function(event, validator) {
                    mApp.scrollTo("#form-employee");

                    swal({
                        title: "",
                        text: "Existem alguns erros do seu formulário. Por favor, corrija-os!",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    });
                },

                submitHandler: function (form) {
                    $.ajax({
                        url: '{{route('employees.update')}}',
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
                                    title: 'Funcionário',
                                    text: data.message,
                                    type: 'success'
                                }).then(results => {
                                    window.location = "{{route('employees')}}";
                                });
                            }else{
                                swal({
                                    title: 'Funcionário',
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