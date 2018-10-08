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
            <div class="modal-body">
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-call">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                @component('Units::components.units')
                                @endcomponent
                            </div>
                            <div class="col-lg-6">
                                @component('Services::components.services')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-12">
                                @component('Employees::components.employees')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-3">
                                <label>Início</label>
                                <input type="text" name="start" id="start" class="form-control m-input" readonly value="{{\Carbon\Carbon::now()->format('d/m/Y H:i')}}">
                            </div>
                            <div class="col-lg-3">
                                <label class="w-100">&nbsp;</label>
                                <button class="btn btn-info" id="btn-availability">
                                    <i class="fa fa-search"></i> Disponibilidade
                                </button>
                            </div>
                        </div>
                        <div class="form-group m-form__group row" id="availability-box"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn btn-success" disabled>
                    <i class="fa fa-save"></i> Salvar
                </button>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function(){
            $("body").on("click", "#btn-availability", function(e){
                e.preventDefault();
                var form = $('#form-call');

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

                        if(!data.success)
                            $('.btn-success').attr('disabled', 'disabled');

                        $('#availability-box').html(data.html);
                    }
                });
            });
        });
    </script>
@endpush