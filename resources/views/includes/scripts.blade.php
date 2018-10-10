<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
<script>
    WebFont.load({
        google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>
<script src="https://fullcalendar.io/releases/fullcalendar/3.9.0/lib/moment.min.js" type="text/javascript"></script>
<script src="https://fullcalendar.io/releases/fullcalendar/3.9.0/lib/jquery.min.js" type="text/javascript"></script>
<script src="https://fullcalendar.io/releases/fullcalendar/3.9.0/fullcalendar.min.js" type="text/javascript"></script>
<script src="https://fullcalendar.io/releases/fullcalendar-scheduler/1.9.4/scheduler.min.js" type="text/javascript"></script>
<script src="{{url('assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{url('assets/massagem/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
<script src="{{url('js/custom.js')}}" type="text/javascript"></script>
@stack('scripts')


<script>
    $(document).ready(function(){
        @stack('scripts-document-ready')
    });
</script>