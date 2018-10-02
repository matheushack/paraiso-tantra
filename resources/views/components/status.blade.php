<select class="form-control m-bootstrap-select" id="status" name="status" required>
    <option value="">Selecione</option>
    <option value="AP" {{isset($id) && $id == 'AP' ? 'selected' : ''}}>Aguardando pagamento</option>
    <option value="AR" {{isset($id) && $id == 'AR' ? 'selected' : ''}}>Aguardando recebimento</option>
    <option value="P" {{isset($id) && $id == 'P' ? 'selected' : ''}}>Pago</option>
    <option value="R" {{isset($id) && $id == 'R' ? 'selected' : ''}}>Recebido</option>
</select>

@push('scripts')
    <script>
        $(document).ready(function(){
            $("#status").selectpicker();
        });
    </script>
@endpush