@extends('layouts.admin')

@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <i class="flaticon-multimedia-2"></i> Tarefas
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
                                Tarefas
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet">
            <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-jobs" name="form-jobs" enctype="multipart/form-data">
                @csrf
                <div class="m-portlet__body">
                    <div id="jobs">
                        <div data-repeater-list="job" >
                            @if($tasks->count() > 0)
                                @foreach($tasks as $key => $task)
                                    <div data-repeater-item class="form-group m-form__group row align-items-center">
                                        <div class="col-lg-2">
                                            <label>
                                                Comando
                                            </label>
                                            <input type="text" class="form-control m-input" name="command" placeholder="" value="{{$task->command}}">
                                        </div>
                                        <div class="col-lg-2">
                                            <label>
                                                Horário
                                            </label>
                                            <input type="text" class="form-control m-input mask-time" name="schedule" placeholder="" value="{{$task->schedule}}">
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="m-radio-inline">
                                                <label class="m-checkbox">
                                                    <input type="checkbox" name="week" value="seg" {{!empty($task->week) && in_array('seg', json_decode($task->week)) ? 'checked' : ''}}>Seg<span></span>
                                                </label>
                                                <label class="m-checkbox">
                                                    <input type="checkbox" name="week" value="ter" {{!empty($task->week) && in_array('ter', json_decode($task->week)) ? 'checked' : ''}}>Ter<span></span>
                                                </label>
                                                <label class="m-checkbox">
                                                    <input type="checkbox" name="week" value="qua" {{!empty($task->week) && in_array('qua', json_decode($task->week)) ? 'checked' : ''}}>Qua<span></span>
                                                </label>
                                                <label class="m-checkbox">
                                                    <input type="checkbox" name="week" value="qui" {{!empty($task->week) && in_array('qui', json_decode($task->week)) ? 'checked' : ''}}>Qui<span></span>
                                                </label>
                                                <label class="m-checkbox">
                                                    <input type="checkbox" name="week" value="sex" {{!empty($task->week) && in_array('sex', json_decode($task->week)) ? 'checked' : ''}}>Sex<span></span>
                                                </label>
                                                <label class="m-checkbox">
                                                    <input type="checkbox" name="week" value="sab" {{!empty($task->week) && in_array('sab', json_decode($task->week)) ? 'checked' : ''}}>Sab<span></span>
                                                </label>
                                                <label class="m-checkbox">
                                                    <input type="checkbox" name="week" value="dom" {{!empty($task->week) && in_array('dom', json_decode($task->week)) ? 'checked' : ''}}>Dom<span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div data-repeater-delete="" class="btn btn-danger m-btn m-btn--custom m-btn--icon m-btn--air btn-delete-job" style="display: none;">
                                                <span>
                                                    <i class="la la-trash-o"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div data-repeater-item class="form-group m-form__group row align-items-center">
                                    <div class="col-lg-2">
                                        <label>
                                            Comando
                                        </label>
                                        <input type="text" class="form-control m-input" name="command" placeholder="">
                                    </div>
                                    <div class="col-lg-2">
                                        <label>
                                            Horário
                                        </label>
                                        <input type="text" class="form-control m-input mask-time" name="schedule" placeholder="">
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
                                        <div data-repeater-delete="" class="btn btn-danger m-btn m-btn--custom m-btn--icon m-btn--air btn-delete-job" style="display: none;">
                                                <span>
                                                    <i class="la la-trash-o"></i>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="form-group m-form__group row">
                            <div data-repeater-create="" class="btn btn-success">
                                <span>
                                    <i class="la la-plus"></i> Nova tarefa
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
                                <button type="button" class="btn btn-info" id="btn-backup-database">
                                    <i class="fa fa-database"></i> Backup banco de dados
                                </button>
                                <button type="submit" class="btn btn-success" id="btn-submit-job">
                                    <i class="fa fa-save"></i> Salvar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.mask-time').inputmask('99:99');

            $("#jobs").repeater({
                initEmpty: !1,
                show: function () {
                    $(this).slideDown();
                    $('.mask-time').inputmask('99:99');
                    $(this).find('.btn-delete-job').show();
                },
                hide: function (e) {
                    $(this).slideUp(e)
                }
            });

            $('input[required]').each(function(key, item){
                $(item).rules('add', {required: true});
            });

            $("#form-jobs").validate({
                invalidHandler: function(event, validator) {
                    mApp.scrollTo("#form-jobs");

                    swal({
                        title: "",
                        text: "Existem alguns erros do seu formulário. Por favor, corrija-os!",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    });
                },

                submitHandler: function (e) {
                    var form = $('form[name="form-jobs"]');
                    var formData = new FormData(form[0]);

                    $.ajax({
                        url: '{{route('tasks.store')}}',
                        type: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function(xhr, type) {
                            if (!type.crossDomain) {
                                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                            }
                        },
                        success: function (data) {
                            if(data.save){
                                swal({
                                    title: 'Backup',
                                    text: data.message,
                                    type: 'success'
                                });
                            }else{
                                swal({
                                    title: 'Backup',
                                    text: data.message,
                                    type: 'error'
                                });
                            }
                        }
                    });

                    return false;
                }
            });

            $('body').on('click', '#btn-backup-database', function () {
                swal({
                    type: 'info',
                    title: 'Backup',
                    text: 'Deseja efetuar o backup do banco de dados agora?',
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-database"></i> Sim',
                    cancelButtonText: 'Não',
                    confirmButtonClass: 'btn btn-success m-btn m-btn--icon m-btn--air',
                    cancelButtonClass: 'btn m-btn m-btn--icon m-btn--air',
                }).then((willDelete) => {
                        if (willDelete.value) {
                            $.ajax({
                                url: '{{route('tasks.database')}}',
                                type: 'POST',
                                cache: false,
                                contentType: false,
                                processData: false,
                                beforeSend: function(xhr, type) {
                                    mApp.blockPage({
                                        overlayColor: "#000000",
                                        type: "loader",
                                        state: "success",
                                        message: "Efetuando o backup"
                                    });

                                    if (!type.crossDomain) {
                                        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                                    }
                                },
                                success: function (data) {
                                    mApp.unblockPage();

                                    if(data.save){
                                        swal({
                                            title: 'Backup',
                                            text: data.message,
                                            type: 'success'
                                        });
                                    }else{
                                        swal({
                                            title: 'Backup',
                                            text: data.message,
                                            type: 'error'
                                        });
                                    }
                                }
                            });
                        }
                    }
                );
            });
        });
    </script>
@endpush