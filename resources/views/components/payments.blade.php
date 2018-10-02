<select class="form-control m-select2" id="payment_id" name="payment_id" data-target="{{isset($target) ? $target : ''}}" required>
    @if(isset($id))
        {{selectPayment($id)}}
    @else
        {{selectPayment()}}
    @endif
</select>

@push('scripts')
    <script>
        $(document).ready(function(){
            $("#payment_id").select2({
                placeholder:"Selecione"
            });
        });
    </script>
@endpush