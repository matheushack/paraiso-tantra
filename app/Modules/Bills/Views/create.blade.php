@extends('layouts.admin')

@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <i class="fa fa-money"></i> Contas a pagar
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{route('dashboard')}}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('bills')}}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Contas a pagar
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Novo
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
                            <i class="la la-plus"></i> Nova entrada/saída
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-bill">
                @csrf
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-5">
                            @component('Bills::components.providers')
                            @endcomponent
                        </div>
                        <div class="col-lg-4">
                            @component('Units::components.units', ['multiple' => true])
                            @endcomponent
                        </div>
                        <div class="col-lg-3">
                            <label>
                                Tipo
                            </label>
                            <div class="m-radio-inline">
                                <label class="m-radio">
                                    <input type="radio" name="type" value="R" checked> Receita
                                    <span></span>
                                </label>
                                <label class="m-radio">
                                    <input type="radio" name="type" value="D"> Despesa
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">

                        <div class="col-lg-3">
                            <label>
                                Data de vencimento
                            </label>
                            <input name="expiration_date" type="text" class="form-control m-input mask-date" id="expiration_date" placeholder="" required>
                        </div>
                        <div class="col-lg-3">
                            <label>
                                Valor
                            </label>
                            <input name="amount" type="text" class="form-control m-input mask-currency" id="amount" placeholder="" required>
                        </div>
                        <div class="col-lg-3">
                            @component('Bills::components.status')
                            @endcomponent
                        </div>
                        <div class="col-lg-3">
                            @component('PaymentMethods::components.payments')
                            @endcomponent
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-lg-3">
                            <label>
                                Conta recorrente?
                            </label>
                            <div class="m-radio-inline">
                                <label class="m-radio">
                                    <input type="radio" name="recurrent" value="S"> Sim
                                    <span></span>
                                </label>
                                <label class="m-radio">
                                    <input type="radio" name="recurrent" value="N" checked> Não
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-3" id="input-months" style="display: none;">
                            <label>
                                Quantidade de meses
                            </label>
                            <input name="months" type="number" class="form-control m-input" id="months" placeholder="">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-lg-12">
                            <label>
                                Descrição
                            </label>
                            <textarea name="description" id="description" class="form-control" rows="5" style="resize: none;" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions--right">
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-8">
                                <button type="submit" class="btn btn-success" id="btn-submit-account">
                                    <i class="fa fa-save"></i> Salvar
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="window.location='{{route('bills')}}'">
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
        $(document).ready(function() {
            ParaisoTantra.masks();

            $('body').on('click', 'input[name="recurrent"]', function(){
                if($(this).val() == 'S'){
                    $('#input-months').show();
                }else{
                    $('#input-months').hide();
                    $('input[name="months"]').val('');
                }
            });

            $("#form-bill").validate({
                invalidHandler: function(event, validator) {
                    mApp.scrollTo("#form-bill");

                    swal({
                        title: "",
                        text: "Existem alguns erros do seu formulário. Por favor, corrija-os!",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    });
                },

                submitHandler: function (form) {
                    $.ajax({
                        url: '{{route('bills.store')}}',
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
                                    window.location = "{{route('bills')}}";
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