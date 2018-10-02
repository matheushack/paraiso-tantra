@if(isset($dashboard))
<div class="dropdown bootstrap-select form-control m-bootstrap-select" style="width: 100px">
@endif
    <select name="year" class="form-control m-bootstrap-select" id="year">
        @if(isset($years) && !empty($years))
            @foreach($years as $year)
                <option value="{{$year}}" {{$selected == $year ? 'selected' : ''}}>{{$year}}</option>
            @endforeach
        @endif
    </select>
@if(isset($dashboard))
</div>
@endif

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#year').selectpicker();
        });
    </script>
@endpush