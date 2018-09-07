@extends('layouts.admin')

@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <i class="flaticon-users"></i> Usuários
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{route('dashboard')}}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('users')}}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Usuários
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
                            <i class="la la-plus"></i> Novo usuário
                        </h3>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-user" enctype="multipart/form-data">
                @csrf
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-4">
                            <label>
                                Nome completo
                            </label>
                            <input name="name" type="text" class="form-control m-input" id="name" placeholder="">
                        </div>
                        <div class="col-lg-4">
                            <label class="">
                                Email
                            </label>
                            <input name="email" type="email" class="form-control m-input mask-email" id="email" placeholder="">
                        </div>
                        <div class="col-lg-2">
                            <label>
                                Telefone
                            </label>
                            <input name="phone" type="text" class="form-control m-input" id="phone" placeholder="">
                        </div>
                        <div class="col-lg-2">
                            <label>
                                Celular
                            </label>
                            <input name="cell_phone" type="text" class="form-control m-input" id="cell_phone" placeholder="">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-lg-4">
                            <label class="">
                                Senha
                            </label>
                            <input name="password" type="password" class="form-control m-input" id="password" placeholder="Enter contact number">
                        </div>
                        <div class="col-lg-4">
                            <label class="">
                                Confirmar senha
                            </label>
                            <input name="confirm_password" type="password" class="form-control m-input" id="confirm_password" placeholder="">
                        </div>
                        <div class="col-lg-4">
                            <label class="">
                                Perfil
                            </label>
                            <select name="profile" class="form-control m-bootstrap-select" id="profile">
                                <option value="">Selecione</option>
                                <option value="">Administrador</option>
                                <option value="">Funcionário</option>
                                <option value="">Financeiro</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-lg-12">
                            <label class="">
                                Foto perfil
                            </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="m-dropzone dropzone m-dropzone--success" action="{{route('users.upload.picture')}}" id="profile_picture">
                                    <div class="m-dropzone__msg dz-message needsclick">
                                        <h3 class="m-dropzone__msg-title">
                                            Arraste a imagem de perfil
                                        </h3>
                                        <span class="m-dropzone__msg-desc">
                                            Apenas arquivos de imagem são permitidos para upload
                                        </span>
                                    </div>
                                </div>
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
                                <button type="reset" class="btn btn-secondary">
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
            $('#profile').selectpicker();

            Dropzone.options.mDropzoneThree = {
                paramName: "file",
                maxFiles: 1,
                maxFilesize: 2, // MB
                addRemoveLinks: true,
                acceptedFiles: "image/*"
            };

            $("#form-user").validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    phone: {
                        required: true
                    },
                    cellPhone: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                    confirm_password: {
                        required: true
                    },
                    profile: {
                        required: true
                    },
                },

                invalidHandler: function(event, validator) {
                    mApp.scrollTo("#form-user");

                    swal({
                        title: "",
                        text: "Existem alguns erros do seu formulário. Por favor, corrija-os!",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    });
                },

                submitHandler: function (form) {
                    $.ajax({
                        url: '{{route('users.store')}}',
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
                                    title: 'Usuário',
                                    text: data.message,
                                    type: 'success'
                                }).then(results => {
                                    window.location = "{{route('users')}}";
                                });
                            }else{
                                swal({
                                    title: 'Usuário',
                                    text: data.message,
                                    type: 'error'
                                });
                            }
                        }
                    });

                    return false;
                }
            });

        });
    </script>
@endpush