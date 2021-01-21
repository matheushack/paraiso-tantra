<label>Cliente</label>
<div class="input-group">
    {!! Form::select('customer_id', [], (isset($id) ? $id : null), [
            'class' => 'form-control m-input m-select2',
            'id' => 'customer_id',
            'required' => 'required',
            'multiple' => 'multiple',
            'style' => 'width: 93%',
            'data-customer-id' => (isset($id) ? $id : null),
            'data-customer-name' => (isset($id) ? \App\Modules\Customers\Models\Customers::find($id)->name : null)
    ]) !!}

    @if(empty($notSearch))
        <div class="input-group-append">
            <button class="btn btn-info" id="btn-search" type="button" data-toggle="modal" data-target="#search-customers">
                <i class="fa fa-search"></i>
            </button>
        </div>
    @endif
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/pt-BR.js"></script>
    <script>
        $(document).ready(function(){
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
@endpush