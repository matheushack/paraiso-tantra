<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
<script>
    WebFont.load({
        google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>
<script src="{{url('assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{url('assets/massagem/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
<script src="{{url('js/custom.js')}}" type="text/javascript"></script>
@stack('scripts')