<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-edit-geral">
    <input type="hidden" name="call_id" value="{{$call->id}}">
    <input type="hidden" name="room_id_edit" value="{{$call->room_id}}">
    <input type="hidden" name="employees_id_edit" value="{{$employees}}">
    <input type="hidden" name="service_id" value="{{$call->service_id}}">

    <div class="form-group m-form__group row">
        <div class="col-lg-12">
            @component('Customers::components.customers', ['id' => $call->customer_id])
            @endcomponent
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-12">
            <label>Observações</label>
            <textarea name="description" id="description" class="form-control m-input" rows="3">{{$call->description}}</textarea>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-6">
            @component('Units::components.units', ['unity_id' => $call->unity_id])
            @endcomponent
        </div>
        <div class="col-lg-6">
            @component('Services::components.services', ['id' => $call->service_id])
            @endcomponent
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-4">
            <label for="">Primeiro atendimento?</label>
            <div class="m-radio-inline">
                <label class="m-radio">
                    <input type="radio" name="first_call" value="1" {{$call->first_call == 1 ? 'checked' : ''}}> Sim
                    <span></span>
                </label>
                <label class="m-radio">
                    <input type="radio" name="first_call" value="0" {{$call->first_call == 0 ? 'checked' : ''}}> Não
                    <span></span>
                </label>
            </div>
        </div>
        <div class="col-lg-3">
            <label>Início</label>
            <input type="text" name="start" id="start" class="form-control m-input mask-dateTime" value="{{\Carbon\Carbon::parse($call->start)->format('d/m/Y H:i')}}">
        </div>
        <div class="col-lg-3">
            <label class="w-100">&nbsp;</label>
            <button class="btn btn-info" id="btn-availability" data-form="form-edit-geral">
                <i class="fa fa-search"></i> Disponibilidade
            </button>
        </div>
    </div>

    <div class="form-group m-form__group row" id="availability-box"></div>
</form>