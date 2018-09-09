var Calendar = function() {
    var construct = function() {
        var calendar = $('#atendimento');
        calendar.fullCalendar({
            header: {
                left: "prev,next today",
                center: "title",
                right: "month,agendaDay,listDay"
            },
            defaultView: 'agendaDay',
            locale: 'pt-br',
            buttonText: {
                today:    'Hoje',
                month:    'Mês',
                week:     'Semana',
                day:      'Dia',
                list:     'Lista'
            },
            resources: {
                url: calendar.data('url'),
                type: 'GET'
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