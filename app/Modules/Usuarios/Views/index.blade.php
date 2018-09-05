@extends('layouts.admin')

@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">
                    Usuários
                </h3>
            </div>
        </div>
    </div>

    <div class="m-content">
        <div id="usuarios"></div>
    </div>
@endsection

@push('scripts')
<script>
    var options = {

    }
    var datatable = $('#usuarios').mDatatable(options);
</script>
@endpush
