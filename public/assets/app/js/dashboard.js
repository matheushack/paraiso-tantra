$('.entradas_saidas').each(function(key, item){
    var id = "#"+$(item).attr('id');

    var account = new Chartist.Pie(id, {
            series: [
                {
                    value: $(id).data('percentage-in'),
                    className: "custom",
                    meta: {
                        color: mApp.getColor("success")
                    }
                },
                {
                    value: $(id).data('percentage-out'),
                    className: "custom",
                    meta: {
                        color: mApp.getColor("danger")
                    }
                }
            ],
            labels: ['Receita', 'Despesa'],
        },
        {
            donut: true,
            donutWidth: 30,
            showLabel: true
        }
    );

    account.on("draw", function (e) {
        if ("slice" === e.type) {
            var t = e.element._node.getTotalLength();

            e.element.attr({
                "stroke-dasharray": t + "px " + t + "px"
            });

            var a = {
                    "stroke-dashoffset": {
                        id: "anim" + e.index,
                        dur: 1e3,
                        from: -t + "px",
                        to: "0px",
                        easing: Chartist.Svg.Easing.easeOutQuint,
                        fill: "freeze",
                        stroke: e.meta.color
                    }
                }
            ;
            0 !== e.index && (a["stroke-dashoffset"].begin = "anim" + (e.index - 1) + ".end"), e.element.attr({
                    "stroke-dashoffset": -t + "px", stroke: e.meta.color
                }
            ), e.element.animate(a, !1)
        }
    });

    account.on("created", function () {
        window.__anim212789071241111 && (clearTimeout(window.__anim212789071241111), window.__anim212789071241111 = null), window.__anim212789071241111 = setTimeout(account.update.bind(account), 15e3)
    });
});


function updateChart(id, percentageIn, percentageOut){
    var showLabel = true;

    if(percentageIn == 0 && percentageOut == 0)
        showLabel = false;

    id = "#".id;

    var account = new Chartist.Pie(id, {
            series: [
                {
                    value: percentageIn,
                    className: "custom",
                    meta: {
                        color: mApp.getColor("success")
                    }
                },
                {
                    value: percentageOut,
                    className: "custom",
                    meta: {
                        color: mApp.getColor("danger")
                    }
                }
            ],
            labels: ['Receita', 'Despesa'],
        },
        {
            donut: true,
            donutWidth: 30,
            showLabel: showLabel
        }
    );

    account.on("draw", function (e) {
        if ("slice" === e.type) {
            var t = e.element._node.getTotalLength();

            e.element.attr({
                "stroke-dasharray": t + "px " + t + "px"
            });

            var a = {
                    "stroke-dashoffset": {
                        id: "anim" + e.index,
                        dur: 1e3,
                        from: -t + "px",
                        to: "0px",
                        easing: Chartist.Svg.Easing.easeOutQuint,
                        fill: "freeze",
                        stroke: e.meta.color
                    }
                }
            ;
            0 !== e.index && (a["stroke-dashoffset"].begin = "anim" + (e.index - 1) + ".end"), e.element.attr({
                    "stroke-dashoffset": -t + "px", stroke: e.meta.color
                }
            ), e.element.animate(a, !1)
        }
    });

    account.on("created", function () {
        window.__anim212789071241111 && (clearTimeout(window.__anim212789071241111), window.__anim212789071241111 = null), window.__anim212789071241111 = setTimeout(account.update.bind(account), 15e3)
    });
}


$(document).ready(function() {

    $('#btn-transfer-accounts').click(function () {
        $('#transfer-accounts').modal('show');
    });

    $('.btn-detail').click(function(){
        var id = $(this).data('id');
        var url = $(this).data('url');
        window.location = url+'?account_id='+id;
    });

    $('#month,#year').change(function (e) {
        var wrapperAccount = $(this).closest('.wrapper-account');
        var wrapperAccountId = wrapperAccount.attr('id').split('-');
        var id = wrapperAccountId[1];

        $.ajax({
            url: 'dashboard/data',
            type: 'POST',
            data: {
                month: $('#month').val(),
                year: $('#year').val()
            },
            dataType: 'json',
            beforeSend: function (xhr, type) {
                if (!type.crossDomain) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                }
            },
            success: function (data) {
                wrapperAccount.find('.account-total').removeClass().addClass(data.classTotal);
                wrapperAccount.find('.account-total').html(data.total_in_out);
                $('#'+id).attr('data-percentage-in', data.percentage_account_in);
                $('#'+id).attr('data-percentage-out', data.percentage_account_out);

                wrapperAccount.find('.detail-account-in > strong').html(data.accounts_in);
                wrapperAccount.find('.detail-account-out > strong').html(data.accounts_out);

                updateChart(id, data.percentage_account_in, data.percentage_account_out);

            },
            error: function (request, status, error) {
                swal({
                    title: 'Dashboard',
                    text: 'Houve um problema ao carregar as informações. Por favor, tente mais tarde',
                    type: 'error'
                })
            }
        });
    });
});