<div class="m-portlet__body">
    <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
        <li class="nav-item m-tabs__item">
            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#tab-geral" role="tab">
                <i class="flaticon-cogwheel"></i> Geral
            </a>
        </li>
        <li class="nav-item m-tabs__item">
            <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab-financeiro" role="tab">
                <i class="flaticon-piggy-bank"></i> Financeiro
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="tab-geral" role="tabpanel">
            @include('Calls::includes.tab-geral')
        </div>
        <div class="tab-pane" id="tab-financeiro" role="tabpanel">
        </div>
    </div>


</div>

<script>
    $(document).ready(function(){

        $('.m_selectpicker').selectpicker();

        $('#customer_id').select2({
            tags: true,
            maximumSelectionLength: 1,
            language: "pt-BR",
            placeholder: "Selecionar os terapeutas para o atendimento"
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

        $('body').on('click', '#btn-delete-call', function(e){
            e.preventDefault();
            var name = '{{$call->customer()->name}}';
            var registerId = {{$call->id}};
            var deleteUrl = '{{url('atendimentos/deletar/'.$call->id)}}';
            var title = 'Deletar atendimento';
            var urlReturn = '{{route('calls')}}';

            swal({
                type: 'warning',
                title: 'Deletar atendimento',
                text: 'Deseja deletar o atendimento para o cliente '+name+'?',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-trash"></i> Sim',
                cancelButtonText: 'Não',
                confirmButtonClass: 'btn btn-danger m-btn m-btn--icon m-btn--air',
                cancelButtonClass: 'btn m-btn m-btn--icon m-btn--air',
            }).then((willDelete) => {
                    if (willDelete.value) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'POST',
                            data: {id: registerId},
                            dataType: 'json',
                            beforeSend: function(xhr, type) {
                                if (!type.crossDomain) {
                                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                                }
                            },
                            success: function (data) {
                                if(data.deleted){
                                    swal({
                                        title: 'Deletar registro',
                                        text: data.message,
                                        type: 'success'
                                    }).then(results => {
                                        window.location = urlReturn;
                                    });
                                }else{
                                    swal({
                                        title: title,
                                        text: data.message,
                                        type: 'error'
                                    })
                                }
                            },
                            error: function(request, status, error)
                            {
                                swal({
                                    title: title,
                                    text: 'Não foi possível deletar o registro. Por favor, tente mais tarde!',
                                    type: 'error'
                                })
                            }
                        });
                    }
                }
            );
        });
    });
</script>