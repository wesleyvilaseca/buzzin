$(function () {
    new Helper();
});


Helper = function () {
    this.startTooltip()
}

Helper.prototype = {
    startTooltip: () => {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    },

    formatCurrency: (input, separator = '.', decimalSeparator = ',') => {
        let value = input.value.replace(separator, '').replace(decimalSeparator, '').replace(/\D/g, '');
        value = parseFloat(value) / 100;

        const options = {
            style: 'currency',
            currency: 'BRL',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
            useGrouping: true,
            groupingSeparator: separator,
            decimalSeparator: decimalSeparator
        };

        input.value = value.toLocaleString('pt-BR', options);
    },

    clearForm: (formid) => {
        document.getElementById(formid).reset();
    },

    showError: (msg) => {
        Swal.fire({
            title: 'Atenção!',
            html: msg,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ok',
            reverseButtons: true
        })
    }
}