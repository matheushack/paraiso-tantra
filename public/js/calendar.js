var Calendar = function() {
    var construct = function() {
        var calendar = $('#atendimento');

        calendar.fullCalendar({
            defaultView: 'agendaDay',
            locale: 'pt-br',
            nowIndicator: true,
            eventLimit: true,
            displayEventEnd: true,
            header: {
                left: "prev,next today",
                center: "title",
                right: "month,agendaDay,listDay"
            },
            buttonText: {
                today:    'Hoje',
                month:    'Mês',
                week:     'Semana',
                day:      'Dia',
                list:     'Lista'
            },
            views: {
                month: {
                    eventLimit: 3
                }
            },
            events: {
                url: calendar.data('url')+'?unity_id='+calendar.data('unity')
            },
            eventRender:function(e, t) {
                if(e.paid) {
                    t.find('.fc-content').addClass('call-paid');
                }

                t.css({'cursor': 'pointer'});
                t.find('.fc-time').css({'color': e.textColor});
                t.find('.fc-title').css({'color': e.textColor});
                t.hasClass("fc-day-grid-event")?(t.data("content", e.description), t.data("placement", "top"), mApp.initPopover(t)): t.hasClass("fc-time-grid-event")?t.find(".fc-title").append('<div class="fc-description">'+e.description+"</div>"): 0!==t.find(".fc-list-item-title").lenght&&t.find(".fc-list-item-title").append('<div class="fc-description">'+e.description+"</div>");
            },
            eventClick: function(calEvent, jsEvent, view) {
                $.ajax({
                    url: calendar.data('url-edit')+'/'+calEvent.id,
                    type: 'GET',
                    beforeSend: function(xhr, type) {
                        if (!type.crossDomain) {
                            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                        }
                    },
                    success: function (data) {
                        $('#edit-call .modal-body').html(data);
                        $('#edit-call').modal('show');
                    }
                });
            }
        });

        $('body').on('click', '#btn-new-call', function(){
            $.ajax({
                url: $(this).data('url'),
                data:{
                    unity_id: $('#filter_unity_id').val()
                },
                type: 'GET',
                beforeSend: function(xhr, type) {
                    if (!type.crossDomain) {
                        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                    }
                },
                success: function (data) {
                    $('#form-call > .modal-body').html(data);
                    $('#new-call').modal('show');
                }
            });
        });

        $('body').on('click','#save-edit-call', function(){
            var form = $('#tabs-call > .tab-pane.active').find('form');
            $(form).submit();
        });
    };

    var filter = function() {
        $('body').on('change', '#filter_unity_id', function(e){
            var unityId = $(this).val();
            var calendar = $('#atendimento');
            $('#new-call').find('#unity_id').val(unityId).trigger('change');

            calendar.fullCalendar('destroy');

            calendar.fullCalendar({
                defaultView: 'month',
                locale: 'pt-br',
                nowIndicator: true,
                eventLimit: true,
                displayEventEnd: true,
                header: {
                    left: "prev,next today",
                    center: "title",
                    right: "month,agendaDay,listDay"
                },
                buttonText: {
                    today:    'Hoje',
                    month:    'Mês',
                    week:     'Semana',
                    day:      'Dia',
                    list:     'Lista'
                },
                views: {
                    month: {
                        eventLimit: 3
                    }
                },
                events: {
                    url: calendar.data('url')+'?unity_id='+unityId
                },
                eventRender:function(e, t) {
                    t.css({'cursor': 'pointer'});
                    t.find('.fc-time').css({'color': e.textColor});
                    t.find('.fc-title').css({'color': e.textColor});
                    t.hasClass("fc-day-grid-event")?(t.data("content", e.description), t.data("placement", "top"), mApp.initPopover(t)): t.hasClass("fc-time-grid-event")?t.find(".fc-title").append('<div class="fc-description">'+e.description+"</div>"): 0!==t.find(".fc-list-item-title").lenght&&t.find(".fc-list-item-title").append('<div class="fc-description">'+e.description+"</div>")
                },
                eventClick: function(calEvent, jsEvent, view) {
                    $.ajax({
                        url: calendar.data('url-edit')+'/'+calEvent.id,
                        type: 'GET',
                        beforeSend: function(xhr, type) {
                            if (!type.crossDomain) {
                                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                            }
                        },
                        success: function (data) {
                            $('#edit-call .modal-body').html(data);
                            $('#edit-call').modal('show');
                        }
                    });
                }
            });
        });
    };

    return {
        init: function() {
            construct();
            filter();
        },

    };
}();

jQuery(document).ready(function() {
    Calendar.init();
});