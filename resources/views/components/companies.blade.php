<select class="form-control m-select2" id="company_id" name="company_id" data-target="{{isset($target) ? $target : ''}}"  data-url="{{isset($url) ? $url : ''}}" required>
    @if(isset($id))
        {{selectCompanies($id)}}
    @else
        {{selectCompanies()}}
    @endif
</select>

@push('scripts')
    <script>
        $(document).ready(function(){
            $("#company_id").select2({
                placeholder: 'Selecione'
            });

            $("#company_id").on('change', function(e){
                var target = $(this).data('target');
                var url = $(this).data('url')+'/'+$(this).val();

                if(typeof target != 'undefined' && target != ''){
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function(xhr, type) {
                            if (!type.crossDomain) {
                                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                            }
                        },
                        success: function (data) {
                            $('#'+target).select2("trigger", "select", {
                                data: { id: data.category_id }
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush