<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <div class="col-lg-12">
                @component('Customers::components.customers')
                @endcomponent
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-12">
            <label>Observações</label>
            <textarea name="description" id="description" class="form-control m-input" rows="3"></textarea>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-6">
            @component('Units::components.units', ['unity_id' => $unity_id])
            @endcomponent
        </div>
        <div class="col-lg-6">
            @component('Services::components.services')
            @endcomponent
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-4">
            <label for="">Primeiro atendimento?</label>
            <div class="m-radio-inline">
                <label class="m-radio">
                    <input type="radio" name="first_call" value="1"> Sim
                    <span></span>
                </label>
                <label class="m-radio">
                    <input type="radio" name="first_call" value="0" checked> Não
                    <span></span>
                </label>
            </div>
        </div>
        <div class="col-lg-3">
            <label>Início</label>
            <input type="text" name="start" id="start" class="form-control m-input mask-dateTime" value="{{\Carbon\Carbon::now()->format('d/m/Y H:i')}}">
        </div>
        <div class="col-lg-3">
            <label class="w-100">&nbsp;</label>
            <button class="btn btn-info" id="btn-availability" data-form="form-call">
                <i class="fa fa-search"></i> Disponibilidade
            </button>
        </div>
    </div>

    <div class="form-group m-form__group row" id="availability-box"></div>
</div>

<script>
    $(document).ready(function(){
        ParaisoTantra.masks();

        $('.m_selectpicker').selectpicker();

        $('#customer_id').select2({
            tags: true,
            maximumSelectionLength: 1,
            language: "pt-BR",
            placeholder: "Selecionar um cliente",
            ajax: {
                url: '{{route('customers.search')}}',
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr, type) {
                    if (!type.crossDomain) {
                        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                    }
                },
                data: function (params) {
                    return {
                        autocomplete: params.term,
                        json: true
                    };
                },
                processResults: function (response) {
                    if(response.success) {
                        return {
                            results: response.data
                        };
                    }

                    return {
                        results: []
                    };
                }
            }
        }).on('select2:select', function (e) {
            e.preventDefault();
            var data = e.params.data;

            if (isNaN(data.id)) {
                swal({
                    type: 'info',
                    title: 'Novo cliente',
                    text: 'Cliente não cadastrado, deseja cadastrar o cliente '+data.text+'?',
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-save"></i> Sim',
                    cancelButtonText: 'Não',
                    confirmButtonClass: 'btn btn-success m-btn m-btn--icon m-btn--air',
                    cancelButtonClass: 'btn m-btn m-btn--icon m-btn--air',
                }).then((willSave) => {
                        if (willSave.value) {
                            $.ajax({
                                url: '{{route('customers.store')}}',
                                type: 'POST',
                                data: {name: data.text, select2: true},
                                dataType: 'json',
                                beforeSend: function(xhr, type) {
                                    if (!type.crossDomain) {
                                        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                                    }
                                },
                                success: function (result) {
                                    if(result.save){
                                        swal({
                                            title: 'Novo cliente',
                                            text: result.message,
                                            type: 'success'
                                        }).then(results => {
                                            var newOption = new Option(result.text, result.id, true, true);
                                            $('#customer_id').append(newOption).val(result.id).trigger('change');
                                        });
                                    }else{
                                        swal({
                                            title: 'Novo cliente',
                                            text: result.message,
                                            type: 'error'
                                        });

                                        $('#customer_id').val(null).trigger('change');
                                    }
                                },
                                error: function(request, status, error)
                                {
                                    swal({
                                        title: 'Novo cliente',
                                        text: 'Não foi cadastrar o novo cliente. Por favor, tente mais tarde!',
                                        type: 'error'
                                    });

                                    $('#customer_id').val(null).trigger('change');
                                }
                            });
                        }else{
                            $('#customer_id').val(null).trigger('change');
                        }
                    }
                );
            }
        });
    });
</script>