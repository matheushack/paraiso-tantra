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

    <div class="tab-content" id="tabs-call">
        <div class="tab-pane active" id="tab-geral" role="tabpanel">
            @include('Calls::includes.tab-geral')
        </div>
        <div class="tab-pane" id="tab-financeiro" role="tabpanel">
            @include('Calls::includes.tab-financial')
        </div>
    </div>


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
            data: [
                { // Each of these gets processed by fnRenderResults.
                    id: $('#customer_id').data('customer-id'),
                    text: $('#customer_id').data('customer-name'),
                    selected: true // Causes the selection to actually get selected.
                }
            ],
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
                                        $('#atendimento').fullCalendar('removeEvents',registerId);
                                        $('#edit-call').modal('hide');
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

        $('#btn-availability').trigger('click');

        $('#amount, #discount').on('blur', function(){
            var total = 0;
            var amount = $("#amount").val().replace(/\D/g,'')/100;
            var discount = $("#discount").val().replace(/\D/g,'')/100;

            total = amount - discount;

            $('#total').val(numberToReal(total));
        });

        $("#form-edit-geral").validate({
            invalidHandler: function(event, validator) {
                mApp.scrollTo("#form-edit-geral");

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
                                if(data.paid)
                                    $('#call_content_'+data.callId).addClass('call-paid');
                                else
                                    $('#call_content_'+data.callId).removeClass('call-paid');

                                $('#atendimento').fullCalendar('refetchEvents');

                                $('#edit-call').modal('hide');
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

        $("#form-edit-financial").validate({
            invalidHandler: function(event, validator) {
                mApp.scrollTo("#form-edit-financial");

                swal({
                    title: "",
                    text: "Existem alguns erros do seu formulário. Por favor, corrija-os!",
                    type: "error",
                    confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                });
            },

            submitHandler: function (form) {
                $.ajax({
                    url: '{{route('calls.update.financial')}}',
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
                                if(data.paid)
                                    $('#call_content_'+data.callId).addClass('call-paid');
                                else
                                    $('#call_content_'+data.callId).removeClass('call-paid');

                                $('#atendimento').fullCalendar('refetchEvents');

                                $('#edit-call').modal('hide');
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

        $("#payment_methods").repeater({
            initEmpty: !1,
            show: function() {
                var total = $("#total").val().replace(/\D/g,'')/100;
                var paymentTotal = 0 ;

                $('.payment_amount').each(function(key, item){
                    var paymentAmount = $(item).val().replace(/\D/g,'')/100;
                    paymentTotal =  paymentAmount + paymentTotal;
                });

                if(paymentTotal > total) {
                    $(this).find('.payment_amount').val('');
                    swal({
                        title: 'Atendimento',
                        text: 'Valores dos pagamentos devem ser menor ou igual ao valor total do atendimento!',
                        type: 'warning'
                    });
                    return false;
                }

                $(this).slideDown();
                $(this).find('.btn-delete-payment').show();
                $(this).find(".mask-currency").inputmask("R$ 999.999,99",{numericInput:!0});
                $('.m-bootstrap-select').selectpicker();
                $('[data-repeater-item]:last > div').find('button:eq(1)').remove();
            },
            hide: function(e) {
                $(this).slideUp(e)
            }
        });

        $('input[required]').each(function(key, item){
            $(item).rules('add', {required: true});
        });
    });

    function numberToReal(numero) {
        var numero = numero.toFixed(2).split('.');
        numero[0] = "R$ " + numero[0].split(/(?=(?:...)*$)/).join('.');
        return numero.join(',');
    }
</script>
