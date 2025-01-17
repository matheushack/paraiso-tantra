@extends('layouts.admin')

@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <i class="flaticon-cogwheel"></i> Unidades
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{route('dashboard')}}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('units')}}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Unidades
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Nova
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
                            <i class="la la-plus"></i> Nova unidade
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-unity">
                @csrf
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-3">
                            <label>
                                CNPJ
                            </label>
                            <input name="cnpj" type="text" class="form-control m-input mask-cnpj" id="cnpj" placeholder="" required>
                        </div>
                        <div class="col-lg-5">
                            <label>
                                Razão social
                            </label>
                            <input name="social_name" type="text" class="form-control m-input" id="social_name" placeholder="" required>
                        </div>
                        <div class="col-lg-4">
                            <label>
                                Nome fantasia
                            </label>
                            <input name="name" type="text" class="form-control m-input" id="name" placeholder="" required>
                        </div>
                    </div>

                    <div class="m-form__seperator m-form__seperator--dashed"></div>

                    @component('components.locations')
                    @endcomponent

                    <div class="m-form__seperator m-form__seperator--dashed"></div>

                    <div class="form-group m-form__group row">
                        <div class="col-lg-4">
                            <label>
                                Email
                            </label>
                            <input name="email" type="email" class="form-control m-input mask-email" id="email" placeholder="" required>
                        </div>
                        <div class="col-lg-4">
                            <label>
                                Telefone
                            </label>
                            <input name="phone" type="text" class="form-control m-input mask-phone" id="phone" placeholder="" required>
                        </div>
                        <div class="col-lg-4">
                            <label>
                                Celular
                            </label>
                            <input name="cell_phone" type="text" class="form-control m-input mask-cell-phone" id="cell_phone" placeholder="" required>
                        </div>
                    </div>

                    <div id="operating_hours">
                        <div data-repeater-list="operating" >
                            <div data-repeater-item class="form-group m-form__group row align-items-center">
                                <div class="col-lg-2">
                                    <label>
                                        Abertura
                                    </label>
                                    <input type="text" class="form-control m-input mask-time" name="open" placeholder="">
                                </div>
                                <div class="col-lg-2">
                                    <label>
                                        Fechamento
                                    </label>
                                    <input type="text" class="form-control m-input mask-time" name="close" placeholder="">
                                </div>
                                <div class="col-lg-7">
                                    <div class="m-radio-inline">
                                        <label class="m-checkbox">
                                            <input type="checkbox" name="week" value="seg">Seg<span></span>
                                        </label>
                                        <label class="m-checkbox">
                                            <input type="checkbox" name="week" value="ter">Ter<span></span>
                                        </label>
                                        <label class="m-checkbox">
                                            <input type="checkbox" name="week" value="qua">Qua<span></span>
                                        </label>
                                        <label class="m-checkbox">
                                            <input type="checkbox" name="week" value="qui">Qui<span></span>
                                        </label>
                                        <label class="m-checkbox">
                                            <input type="checkbox" name="week" value="sex">Sex<span></span>
                                        </label>
                                        <label class="m-checkbox">
                                            <input type="checkbox" name="week" value="sab">Sab<span></span>
                                        </label>
                                        <label class="m-checkbox">
                                            <input type="checkbox" name="week" value="dom">Dom<span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div data-repeater-delete="" class="btn btn-danger m-btn m-btn--custom m-btn--icon m-btn--air btn-delete-operating" style="display: none;">
                                        <span>
                                            <i class="la la-trash-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div data-repeater-create="" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-plus"></i> Novo horário
                                </span>
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
                                <button type="button" class="btn btn-secondary" onclick="window.location='{{route('units')}}'">
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

            $("#operating_hours").repeater({
                initEmpty: !1,
                show: function() {
                    $(this).slideDown();
                    $(this).find('.btn-delete-operating').show();
                    ParaisoTantra.masks();
                },
                hide: function(e) {
                    $(this).slideUp(e)
                }
            });

            $("#form-unity").validate({
                invalidHandler: function(event, validator) {
                    mApp.scrollTo("#form-unity");

                    swal({
                        title: "",
                        text: "Existem alguns erros do seu formulário. Por favor, corrija-os!",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    });
                },

                submitHandler: function (form) {
                    $.ajax({
                        url: '{{route('units.store')}}',
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
                                    title: 'Unidade',
                                    text: data.message,
                                    type: 'success'
                                }).then(results => {
                                    window.location = "{{route('units')}}";
                                });
                            }else{
                                swal({
                                    title: 'Unidade',
                                    text: data.message,
                                    type: 'error'
                                });
                            }
                        }
                    });

                    return false;
                }
            });

            $('input[required]').each(function(key, item){
                $(item).rules('add', {required: true});
            });

        });
    </script>
@endpush