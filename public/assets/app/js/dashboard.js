var account = new Chartist.Pie(".entradas_saidas", {
        series: [
            {
                value: $('.entradas_saidas').data('percentage-in'),
                className: "custom",
                meta: {
                    color: mApp.getColor("success")
                }
            },
            {
                value: $('.entradas_saidas').data('percentage-out'),
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

function updateChart(chart, percentageIn, percentageOut){
    var showLabel = true;

    if(percentageIn == 0 && percentageOut == 0)
        showLabel = false;

    account = new Chartist.Pie(".entradas_saidas", {
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

    $('#month,#year').change(function (e) {
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
                $('#account-total').removeClass().addClass(data.classTotal);
                $('#account-total').html(data.total_in_out);
                $('#entradas_saidas').attr('data-percentage-in', data.percentage_account_in);
                $('#entradas_saidas').attr('data-percentage-out', data.percentage_account_out);

                $('#detail-account-in > strong').html(data.accounts_in);
                $('#detail-account-out > strong').html(data.accounts_out);

                updateChart(account, data.percentage_account_in, data.percentage_account_out);
                $('#dataTable').DataTable().ajax.reload();

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