<label>Status</label>
{!! Form::select('status', ['' => 'Selecione', 'AP' => 'Aguardando pagamento','AR' => 'Aguardando recebimento', 'P' => 'Pago','R' => 'Recebido'], (isset($status) ? $status : null), [
        'class' => 'form-control m-input m-bootstrap-select m_selectpicker',
        'id' => (isset($id) ? $id : 'status'),
        'required' => 'required',
        'data-live-search' => 'true'
]) !!}

@push('scripts')
    <script>
        $(document).ready(function(){
            $('.m_selectpicker').selectpicker();
        });
    </script>
@endpush