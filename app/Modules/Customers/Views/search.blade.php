<div class="modal fade" id="search-customers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="la la-search"></i> Busca de cliente
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-customers">
                <div class="modal-body">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>
                                    Nome
                                </label>
                                <input name="name" type="text" class="form-control m-input" id="name" placeholder="" required>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    Email
                                </label>
                                <input name="email" type="text" class="form-control m-input" id="email" placeholder="">
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-3">
                                <label>
                                    Telefone
                                </label>
                                <input name="phone" type="text" class="form-control m-input mask-phone" id="phone" placeholder="">
                            </div>
                            <div class="col-lg-3">
                                <label>
                                    Celular
                                </label>
                                <input name="cell_phone" type="text" class="form-control m-input mask-cell-phone" id="cell_phone" placeholder="">
                            </div>
                            <div class="col-lg-3">
                                <label for="">Sexo</label>
                                <div class="m-radio-inline">
                                    <label class="m-radio">
                                        <input type="radio" name="gender" value="M"> M
                                        <span></span>
                                    </label>
                                    <label class="m-radio">
                                        <input type="radio" name="gender" value="F"> F
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label class="w-100">
                                    &nbsp;
                                </label>
                                <button class="btn btn-info" id="btn-customers">
                                    <i class="fa fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>

                        <div class="row" id="table-customers"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Fechar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function(){
            $("body").on("click", ".customer-select", function(e){
                var value = $(this).val();
                var name = $(this).data('name');
                $('#customer_id').val(value).trigger('change');
                $('#search-customers').find('.close').trigger('click');
            });

            $("body").on("click", "#btn-customers", function(e){
                e.preventDefault();
                var form = $('#form-customers');

                $.ajax({
                    url: '{{route('customers.search')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: form.serialize(),
                    beforeSend: function(xhr, type) {
                        mApp.blockPage({
                            overlayColor: "#000000",
                            type: "loader",
                            state: "danger",
                            message: "Buscanco clientes"
                        });

                        if (!type.crossDomain) {
                            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                        }
                    },
                    success: function (data) {
                        mApp.unblockPage();
                        $('#table-customers').html(data.html);
                    }
                });
            });
        });
    </script>
@endpush