<div class="modal fade" id="transfer-accounts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="la la-transfer"></i> Transferência entre contas
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-transfer">
                <div class="modal-body">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                @component('Accounts::components.accounts', ['label' => 'De', 'name' => 'account_out'])
                                @endcomponent
                            </div>
                            <div class="col-lg-6">
                                @component('Accounts::components.accounts', ['label' => 'Para', 'name' => 'account_in'])
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>Valor</label>
                                <input type="text" name="amount" class="form-control m-input mask-currency" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-exchange"></i> Transferir
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function(){
            ParaisoTantra.masks();

            $("#form-transfer").validate({
                invalidHandler: function(event, validator) {
                    mApp.scrollTo("#form-transfer");

                    swal({
                        title: "",
                        text: "Existem alguns erros do seu formulário. Por favor, corrija-os!",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    });
                },

                submitHandler: function (form) {
                    $.ajax({
                        url: '{{route('accounts.transfer')}}',
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
                                    title: 'Transferência',
                                    text: data.message,
                                    type: 'success'
                                }).then(results => {
                                    window.location = '/dashboard';
                                });
                            }else{
                                swal({
                                    title: 'Transferência',
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