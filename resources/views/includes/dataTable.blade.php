<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    {{isset($dTitle) ? $dTitle : 'Listagem'}}
                </h3>
            </div>
        </div>
        @if(isset($dBtnNew))
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="{{$dBtnNew}}" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air">
                            <span>
                                <i class="la la-plus"></i>
                                <span>
                                    Novo
                                </span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        @endif
    </div>
    <div class="m-portlet__body">
        <!--begin: Datatable -->
        <table class="table table-striped- table-bordered table-hover table-checkable" id="dataTable" data-url="{{isset($dUrl) ? $dUrl : '#'}}">
            <thead>
            <tr id="columns-dataTable">
                @if(isset($dColumns))
                    @foreach($dColumns as $column)
                        <th data-field="{{$column['field']}}" data-width="{{isset($column['width']) ? $column['width'] : ''}}" data-class="{{isset($column['class']) ? $column['class'] : ''}}" class="{{isset($column['class']) ? $column['class'] : ''}}">
                            {{$column['label']}}
                        </th>
                    @endforeach
                @endif
            </tr>
            </thead>
        </table>
    </div>
</div>

@push('css')
    <link href="{{url('assets/vendors/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{url('assets/vendors/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/massagem/default/custom/crud/datatables/extensions/buttons.js')}}" type="text/javascript"></script>
    <script src="{{url('js/dataTable.js')}}" type="text/javascript"></script>
@endpush