@if(isset($dashboard))
    <div class="dropdown bootstrap-select form-control m-bootstrap-select m--margin-right-10" style="width: 140px">
        @endif
        <select name="month" class="form-control m-bootstrap-select" id="month">
            @if(isset($months) && !empty($months))
                @foreach($months as $key => $month)
                    <option value="{{$key}}" {{$selected == $key ? 'selected' : ''}}>{{$month}}</option>
                @endforeach
            @endif
        </select>
        @if(isset($dashboard))
    </div>
@endif

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#month').selectpicker();
        });
    </script>
@endpush