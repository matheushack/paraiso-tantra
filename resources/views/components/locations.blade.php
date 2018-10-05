<div class="form-group m-form__group row">
    <div class="col-lg-3">
        <label>
            CEP
        </label>
        <div class="input-group">
            <input name="cep" type="text" value="{{isset($unity) ? $unity->cep : ''}}" class="form-control m-input mask-cep" id="cep" placeholder="" required>
            <div class="input-group-append">
                <button class="btn btn-info" id="btn-cep" type="button">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <label>
            Endereço
        </label>
        <input name="address" type="text" value="{{isset($unity) ? $unity->address : ''}}" class="form-control m-input" id="address" placeholder="" disabled>
    </div>
    <div class="col-lg-2">
        <label>
            Número
        </label>
        <input name="number" type="text" value="{{isset($unity) ? $unity->number : ''}}" class="form-control m-input" id="number" placeholder="" required>
    </div>
    <div class="col-lg-3">
        <label>
            Complemento
        </label>
        <input name="complement" type="text" value="{{isset($unity) ? $unity->complement : ''}}" class="form-control m-input" id="complement" placeholder="">
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-lg-4">
        <label>
            Bairro
        </label>
        <input name="neighborhood" value="{{isset($unity) ? $unity->neighborhood : ''}}" type="text" class="form-control m-input" id="neighborhood" placeholder="" disabled>
    </div>
    <div class="col-lg-4">
        <label>
            Cidade
        </label>
        <input name="city" type="text" value="{{isset($unity) ? $unity->city : ''}}" class="form-control m-input" id="city" placeholder="" disabled>
    </div>
    <div class="col-lg-4">
        <label>
            Estado
        </label>
        {!! Form::select('state', array_merge(['' => 'Selecione'], array_map('strtoupper', \Canducci\ZipCode\ZipCodeUf::lists())), (isset($unity) ? $unity->state : null), [
                'class' => 'form-control m-input',
                'id' => 'state',
                'disabled' => 'disabled'
            ]) !!}
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function(){
            ParaisoTantra.masks();
            $('#state').selectpicker();

            $("body").on("click", "#btn-cep", function(){
                $.ajax({
                    url: '{{route('cep')}}',
                    type: 'POST',
                    data: {cep: $('input[name="cep"]').val()},
                    beforeSend: function(xhr, type) {
                        mApp.blockPage({
                            overlayColor: "#000000",
                            type: "loader",
                            state: "danger",
                            message: "Buscanco endereço"
                        });

                        if (!type.crossDomain) {
                            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                        }
                    },
                    success: function (data) {
                        mApp.unblockPage();

                        if(data.success){
                            $('input[name="address"]').val(data.cep.address);
                            $('input[name="neighborhood"]').val(data.cep.neighborhood);
                            $('input[name="city"]').val(data.cep.city);
                            $('select[name="state"]').val(data.cep.state).change();
                        }else{
                            $('input[name="cep"]').val('');
                        }
                    }
                });
            });
        });
    </script>
@endpush