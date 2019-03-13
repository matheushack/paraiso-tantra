<div class="modal fade" id="new-call" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="la la-plus"></i> Novo atendimento
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-call">
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-success" disabled>
                        <i class="fa fa-save"></i> Salvar
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@include('Customers::search')


@push('scripts')
    <script>
        $(document).ready(function(){
            ParaisoTantra.masks();

            $("body").on("click", "#btn-availability", function(e){
                e.preventDefault();
                var form = $("#"+$(this).data('form'));

                $.ajax({
                    url: '{{route('calls.availability')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: form.serialize(),
                    beforeSend: function(xhr, type) {
                        mApp.blockPage({
                            overlayColor: "#000000",
                            type: "loader",
                            state: "danger",
                            message: "Buscanco disponibilidade"
                        });

                        if (!type.crossDomain) {
                            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                        }
                    },
                    success: function (data) {
                        mApp.unblockPage();

                        if(!data.success) {
                            $('.btn-success').attr('disabled', 'disabled');
                        }else {
                            $('.btn-success').removeAttr('disabled');
                        }

                        $('#availability-box').html(data.html);

                        if (!$('#employees').hasClass('select2-hidden-accessible')){
                            $('#employees').select2({
                                placeholder: "Selecionar os terapeutas para o atendimento"
                            });
                        }

                        if(typeof data.room_id != 'undefined' && data.room_id != '')
                            $('input[name="room_id"][value="'+data.room_id+'"]').prop('checked', true);

                        if(typeof data.employees_id_edit != 'undefined' && data.employees_id_edit != ''){
                            var $employees = data.employees_id_edit.split(",");

                            $("#employees").val($employees).trigger('change');
                        }
                    }
                });
            });

            $("#form-call").validate({
                invalidHandler: function(event, validator) {
                    mApp.scrollTo("#form-call");

                    swal({
                        title: "",
                        text: "Existem alguns erros do seu formulário. Por favor, corrija-os!",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    });
                },

                submitHandler: function (form) {
                    $.ajax({
                        url: '{{route('calls.store')}}',
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
                                    title: 'Atendimento',
                                    text: data.message,
                                    type: 'success'
                                }).then(results => {
                                    $('#atendimento').fullCalendar('refetchEvents');

                                    $('#new-call').modal('hide');
                                });
                            }else{
                                swal({
                                    title: 'Atendimento',
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