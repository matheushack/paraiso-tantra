<div class="modal fade" id="invoices-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-file"></i> Nota fiscal - Upload de arquivos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-account-modal" name="form-account-modal" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="">
                    @csrf
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row" id="content-invoice-upload">
                            <div class="col-lg-12">
                                <label>
                                    Arquivos
                                </label>

                                <div class="m-dropzone dropzone m-dropzone--success" action="{{route('accounts.upload')}}" id="invoice">
                                    <div class="m-dropzone__msg dz-message needsclick">
                                        <h3 class="m-dropzone__msg-title">
                                            Arraste os arquivos para efetuar upload
                                        </h3>
                                        <span class="m-dropzone__msg-desc">
                                            Permitido apenas arquivos de imagem e PDF
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        Dropzone.autoDiscover = false;
        Dropzone.options.invoice = {
            paramName: "invoices",
            maxFiles: 10,
            maxFilesize: 10,
            addRemoveLinks: true,
            autoProcessQueue: true,
            dictRemoveFile: 'Remover arquivo',
            acceptedFiles: "image/*,application/pdf",
            init: function () {
                var thisDropzone = this;

                thisDropzone.on("removedfile", function (file) {
                    $.post({
                        url: 'contas/upload/remover',
                        data: {
                            id: $('form[name="form-account-modal"]').find('#id').val(),
                            file: file.name,
                            _token: $('[name="_token"]').val()
                        },
                        dataType: 'json',
                        success: function (data) {
                            swal({
                                title: 'Nota fiscal',
                                text: 'Arquivo removido com sucesso',
                                type: 'success'
                            });
                            $('#dataTable').DataTable().ajax.reload();
                        }
                    });
                });
            },
            sending: function(file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("flg_invoice", $('form[name="form-account-modal"]').find('#flg_invoice').is(':checked'));
                formData.append("id", $('form[name="form-account-modal"]').find('#id').val());
            },
            success: function (file, done) {
                var thisDropzone = this;
            },
            queuecomplete: function(e){
                swal({
                    title: 'Nota fiscal',
                    text: 'Upload realizado com sucesso',
                    type: 'success'
                });

                $('#dataTable').DataTable().ajax.reload();
            }
        };

        $(document).ready(function(){
            var invoiceDropzone = new Dropzone("#invoice", {
                paramName: "invoices",
                maxFiles: 10,
                maxFilesize: 10,
                addRemoveLinks: true,
                autoProcessQueue: true,
                dictRemoveFile: 'Remover arquivo',
                acceptedFiles: "image/*,application/pdf",
                init: function () {
                    var thisDropzone = this;

                    thisDropzone.on("removedfile", function (file) {
                        $.post({
                            url: 'contas/upload/remover',
                            data: {
                                id: $('form[name="form-account-modal"]').find('#id').val(),
                                file: file.name,
                                _token: $('[name="_token"]').val()
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({
                                    title: 'Nota fiscal',
                                    text: 'Arquivo removido com sucesso',
                                    type: 'success'
                                });

                                if(data.reloadDataTable)
                                    $('#dataTable').DataTable().ajax.reload();
                            }
                        });
                    });

                    thisDropzone.on('resetFiles', function() {
                        $('.dz-preview').remove();
                    });
                },
                sending: function(file, xhr, formData) {
                    formData.append("_token", "{{ csrf_token() }}");
                    formData.append("flg_invoice", $('form[name="form-account-modal"]').find('#flg_invoice').is(':checked'));
                    formData.append("id", $('form[name="form-account-modal"]').find('#id').val());
                },
                success: function (file, done) {
                    var thisDropzone = this;
                },
                queuecomplete: function(e){
                    swal({
                        title: 'Nota fiscal',
                        text: 'Upload realizado com sucesso',
                        type: 'success'
                    });

                    $('#dataTable').DataTable().ajax.reload();
                }
            });

            $('body').on('click', '.modal-invoice', function(e){
                e.preventDefault();
                invoiceDropzone.emit("resetFiles");
                $('form[name="form-account-modal"]').find('#id').val($(this).data('account-id'));

                $.getJSON('contas/upload/'+$(this).data('account-id'), function(data) {
                    $.each(data, function(key,value){
                        var mockFile = {
                            name: value.name,
                            size: value.size
                        };

                        invoiceDropzone.options.addedfile.call(invoiceDropzone, mockFile);
                        invoiceDropzone.options.thumbnail.call(invoiceDropzone, mockFile, "invoices/"+value.name);
                    });
                });
            });
        });
    </script>
@endpush
