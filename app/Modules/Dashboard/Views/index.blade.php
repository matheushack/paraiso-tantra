@extends('layouts.admin')

@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">
                    Dashboard
                </h3>
            </div>
        </div>
    </div>

    <div class="m-content"></div>
@endsection

@push('scripts')
<script src="{{url('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
<script src="{{url('assets/app/js/dashboard.js')}}" type="text/javascript"></script>
@endpush