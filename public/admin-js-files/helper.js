$(function () {
    new Helper();
});


Helper = function () {
    this.startTooltip()
}

Helper.prototype = {
    isJson: (str) => {
        try {
            return (JSON.parse(str) && !!str);
        } catch (e) {
            return false;
        }
    },
    startTooltip: () => {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
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
    },

    moneyMask: (value) => {
        if (typeof value !== "number") {
            return value;
        }
        var formatter = new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });
        return formatter.format(value);
    },

    slugfy: (string) => {
        // Remove espaços em branco no início e no final da string
        string = string.trim().toLowerCase();
      
        // Substitui espaços por hífens
        string = string.replace(/\s+/g, '-');
      
        // Remove caracteres especiais usando uma expressão regular
        string = string.replace(/[^a-z0-9-]/g, '');
      
        // Remove múltiplos hífens consecutivos
        string = string.replace(/-+/g, '-');
      
        return string;
      }
}