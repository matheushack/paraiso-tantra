<div class="modal fade" id="edit-call" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="la la-pencil"></i> Editar atendimento
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-edit-call">
                <div class="modal-body" style="padding: 10px;">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" id="btn-delete-call">
                        <i class="fa fa-trash"></i> Deletar
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

            $("#form-edit-call").validate({
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
                        url: '{{route('calls.update')}}',
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
                                    window.location = "{{route('calls')}}";
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