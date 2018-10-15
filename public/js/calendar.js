var Calendar = function() {
    var construct = function() {
        var calendar = $('#atendimento');

        calendar.fullCalendar({
            defaultView: 'listDay',
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
                t.css({'cursor': 'pointer'});
                t.find('.fc-time').css({'color': e.textColor});
                t.find('.fc-title').css({'color': e.textColor});
                t.hasClass("fc-day-grid-event")?(t.data("content", e.description), t.data("placement", "top"), mApp.initPopover(t)): t.hasClass("fc-time-grid-event")?t.find(".fc-title").append('<div class="fc-description">'+e.description+"</div>"): 0!==t.find(".fc-list-item-title").lenght&&t.find(".fc-list-item-title").append('<div class="fc-description">'+e.description+"</div>")
            },
            eventClick: function(calEvent, jsEvent, view) {
                $('#m-wrapper .modal-body').load(calendar.data('url-edit')+'/'+calEvent.id,function(){
                    $('#new-call').modal({show:true});
                });
            }
        });
    };

    return {
        init: function() {
            construct();
        },

    };
}();

jQuery(document).ready(function() {
    Calendar.init();
});