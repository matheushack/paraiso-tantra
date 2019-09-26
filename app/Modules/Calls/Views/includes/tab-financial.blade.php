<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-edit-financial">
    <input type="hidden" name="call_id" value="{{$call->id}}">

    <div class="form-group m-form__group row">
        <div class="col-lg-6">
            @component('Calls::components.status_payment', ['status' => $call->status])
            @endcomponent
        </div>
        <div class="col-lg-6">
            <label>Tipo desconto</label>
            <div class="m-radio-inline">
                <label class="m-radio">
                    <input type="radio" name="type_discount" value="C" {{$call->type_discount == \App\Modules\Calls\Constants\DiscountTypes::COMPANY ? 'checked="checked"' : ''}} {{$call->discount > 0 ? 'required="required"' : ''}}> Empresa
                    <span></span>
                </label>
                <label class="m-radio">
                    <input type="radio" name="type_discount" value="T" {{$call->type_discount == \App\Modules\Calls\Constants\DiscountTypes::THERAPEUTICS ? 'checked="checked"' : ''}} {{$call->discount > 0 ? 'required="required"' : ''}}> Terapeutas
                    <span></span>
                </label>
                <label class="m-radio">
                    <input type="radio" name="type_discount" value="B" {{$call->type_discount == \App\Modules\Calls\Constants\DiscountTypes::BOTH ? 'checked="checked"' : ''}} {{$call->discount > 0 ? 'required="required"' : ''}}> Ambos
                    <span></span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-4">
            <label>Valor</label>
            <input type="text" name="amount" id="amount" class="form-control m-input mask-currency" value="{{number_format($call->amount, 2, ',', '.')}}">
        </div>
        <div class="col-lg-4">
            <label>Desconto</label>
            <input type="text" name="discount" id="discount" class="form-control m-input mask-currency" value="{{$call->discount > 0 ? number_format($call->discount, 2, ',', '.') : ''}}">
        </div>
        <div class="col-lg-3">
            <label>Total</label>
            <input type="text" name="total" id="total" class="form-control m-input" value="R$ {{number_format($call->total, 2, ',', '.')}}" disabled="">
        </div>
    </div>

    <div class="form-group m-form__group row">
        <div id="payment_methods">
            <div data-repeater-list="payments" >
                @if(!empty($payments))
                    @foreach($payments as $key => $item)
                        <div data-repeater-item class="form-group m-form__group row align-items-center">
                            <div class="col-lg-6">
                                @component('PaymentMethods::components.payments', ['payment_id' => $item['payment_id']])
                                @endcomponent
                            </div>
                            <div class="col-lg-5">
                                <label>Valor</label>
                                <input type="text" name="amount" class="form-control m-input mask-currency payment_amount" value="{{$item['amount']}}">
                            </div>
                            <div class="col-md-1">
                                <div data-repeater-delete="" class="btn btn-danger m-btn m-btn--custom m-btn--icon m-btn--air btn-delete-payment" style="{{$key == 0 ? 'display: none;' : ''}}">
                                    <span>
                                        <i class="la la-trash-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div data-repeater-item class="form-group m-form__group row align-items-center">
                        <div class="col-lg-6">
                            @component('PaymentMethods::components.payments')
                            @endcomponent
                        </div>
                        <div class="col-lg-5">
                            <label>Valor</label>
                            <input type="text" name="amount" class="form-control m-input mask-currency payment_amount" value="">
                        </div>
                        <div class="col-md-1">
                            <div data-repeater-delete="" class="btn btn-danger m-btn m-btn--custom m-btn--icon m-btn--air btn-delete-payment" style="display: none;">
                                <span>
                                    <i class="la la-trash-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group row">
                <div data-repeater-create="" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air">
                    <span>
                        <i class="la la-plus"></i> Nova forma de pagamento
                    </span>
                </div>
            </div>
        </div>
    </div>
</form>
