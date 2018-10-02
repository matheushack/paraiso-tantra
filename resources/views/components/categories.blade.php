<select class="form-control m-select2" id="category_id" name="category_id" data-target="{{isset($target) ? $target : ''}}" required>
    @if(isset($id))
        {{selectCategory($id)}}
    @else
        {{selectCategory()}}
    @endif
</select>

@push('scripts')
    <script>
        $(document).ready(function(){
            $("#category_id").select2({
                placeholder:"Selecione"
            });
        });
    </script>
@endpush