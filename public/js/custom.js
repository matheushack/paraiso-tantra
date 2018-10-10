var ParaisoTantra = function() {
    var masks = function() {
        $(".mask-email").inputmask({
            mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
            greedy: false,
            onBeforePaste: function (pastedValue, opts) {
                pastedValue = pastedValue.toLowerCase();
                return pastedValue.replace("mailto:", "");
            },
            definitions: {
                '*': {
                    validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                    cardinality: 1,
                    casing: "lower"
                }
            }
        });

        $(".mask-cnpj").inputmask({
            mask: ['99.999.999/9999-99'],
            keepStatic: true
        });

        $(".mask-cpf").inputmask({
            mask: ['999.999.999-99'],
            keepStatic: true
        });

        $(".mask-date").inputmask("dd/mm/yyyy");
        $(".mask-dateTime").inputmask("99/99/9999 99:99");
        $(".mask-currency").inputmask("R$ 999.999,99",{numericInput:!0});
        $('.mask-time').inputmask('99:99');
        $('.mask-cep').inputmask('99999-999');
        $('.mask-phone').inputmask('(99)9999-9999');
        $('.mask-cell-phone').inputmask('(99)9999[9]-9999');
    };

    return {
        masks: function() {
            masks();
        },

    };
}();
