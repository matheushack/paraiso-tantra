@extends('layouts.admin')

@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <i class="flaticon-piggy-bank"></i> Contas
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{route('dashboard')}}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('accounts')}}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Contas
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
                            <i class="la la-plus"></i> Nova conta
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-account">
                @csrf
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-9">
                            <label>
                                Nome
                            </label>
                            <input name="name" type="text" class="form-control m-input" id="name" placeholder="" required>
                        </div>
                        <div class="col-lg-3">
                            <label>
                                Tipo
                            </label>
                            <div class="m-radio-inline">
                                <label class="m-radio">
                                    <input type="radio" name="type" value="{{\App\Modules\Accounts\Constants\Types::INTERNAL}}" checked> Interna
                                    <span></span>
                                </label>
                                <label class="m-radio">
                                    <input type="radio" name="type" value="{{\App\Modules\Accounts\Constants\Types::BANK}}"> Banco
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="box-type-bank" style="display:none;">
                        @component('Accounts::components.bank')
                        @endcomponent
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
                                <button type="button" class="btn btn-secondary" onclick="window.location='{{route('accounts')}}'">
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

            {{--$('body').on('change', 'input[name="type"]', function(){--}}
                {{--var value = $(this).val();--}}

                {{--if(value == '{{\App\Modules\Accounts\Constants\Types::BANK}}') {--}}
                    {{--$('#box-type-bank').fadeIn();--}}
                    {{--$('#box-type-bank').find('input').attr('required', 'required');--}}
                {{--}else {--}}
                    {{--$('#box-type-bank').fadeOut();--}}
                    {{--$('#box-type-bank').find('input').removeAttr('required');--}}
                {{--}--}}
            {{--});--}}

            $("#form-account").validate({
                invalidHandler: function(event, validator) {
                    mApp.scrollTo("#form-account");

                    swal({
                        title: "",
                        text: "Existem alguns erros do seu formulário. Por favor, corrija-os!",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    });
                },

                submitHandler: function (form) {
                    $.ajax({
                        url: '{{route('accounts.store')}}',
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
                                    title: 'Conta',
                                    text: data.message,
                                    type: 'success'
                                }).then(results => {
                                    window.location = "{{route('accounts')}}";
                                });
                            }else{
                                swal({
                                    title: 'Conta',
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