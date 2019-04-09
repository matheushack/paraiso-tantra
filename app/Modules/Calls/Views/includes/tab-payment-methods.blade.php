<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="form-edit-financial">
    <input type="hidden" name="call_id" value="{{$call->id}}">
    <div class="form-group m-form__group row">
        <div id="payment_methods">
            <div data-repeater-list="payments" >
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
