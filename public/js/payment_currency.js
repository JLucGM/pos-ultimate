/**
 * Audaz POS - Pagos Multi-Moneda
 * Maneja la selección de moneda por cada línea de pago
 * y muestra la equivalencia en tiempo real.
 */
(function() {
    'use strict';

    // Cache de tasas para no hacer AJAX repetidos
    var rateCache = {};
    var baseCurrencyId = $('input#business_currency_id').val() || null;

    /**
     * Obtener tasa de cambio (con caché)
     */
    function getExchangeRate(fromCurrencyId, toCurrencyId, callback) {
        if (fromCurrencyId == toCurrencyId) {
            callback(1);
            return;
        }

        var cacheKey = fromCurrencyId + '_' + toCurrencyId;
        if (rateCache[cacheKey]) {
            callback(rateCache[cacheKey]);
            return;
        }

        $.ajax({
            url: '/get-exchange-rate',
            data: {
                from_currency_id: fromCurrencyId,
                to_currency_id: toCurrencyId
            },
            success: function(response) {
                if (response.success && response.rate) {
                    rateCache[cacheKey] = parseFloat(response.rate);
                    callback(parseFloat(response.rate));
                } else {
                    callback(null);
                }
            },
            error: function() {
                callback(null);
            }
        });
    }

    /**
     * Actualizar la equivalencia mostrada debajo del monto
     */
    function updateEquivalent(rowIndex) {
        var $currencySelect = $('#payment_currency_' + rowIndex);
        var $amountInput = $('#amount_' + rowIndex);
        var $equivDiv = $('#currency_equiv_' + rowIndex);
        var $rateInput = $('#payment_exchange_rate_' + rowIndex);

        if (!$currencySelect.length || !$amountInput.length) return;

        var selectedCurrencyId = $currencySelect.val();
        var amount = __read_number($amountInput);

        // Si es la moneda base, no mostrar equivalencia
        if (!baseCurrencyId || selectedCurrencyId == baseCurrencyId) {
            $equivDiv.hide();
            $rateInput.val(1);
            return;
        }

        if (!amount || amount <= 0) {
            $equivDiv.hide();
            return;
        }

        // Obtener tasa: de la moneda seleccionada a la moneda base
        // Si seleccionó Bs, necesitamos saber cuántos USD equivale
        getExchangeRate(baseCurrencyId, selectedCurrencyId, function(rate) {
            if (rate && rate > 0) {
                var amountInBase = amount / rate;
                $rateInput.val(rate);
                $equivDiv.find('.equiv-text').text(
                    'Equivale a $' + amountInBase.toFixed(2) + ' USD (Tasa: ' + rate.toFixed(2) + ')'
                );
                $equivDiv.show();
            } else {
                $equivDiv.find('.equiv-text').text('Sin tasa disponible');
                $equivDiv.show();
                $rateInput.val(1);
            }
        });
    }

    /**
     * Recalcular el balance pendiente considerando monedas
     */
    function recalculateMultiCurrencyBalance() {
        var totalPayableBase = __read_number($('#total_payable_input'));
        var totalPayingBase = 0;

        $('#payment_rows_div').find('.payment-amount').each(function() {
            var $row = $(this).closest('.payment_row');
            var amount = __read_number($(this));
            var $currencySelect = $row.find('.payment-currency-select');
            var $rateInput = $row.find('.payment-exchange-rate');

            if (!amount || amount <= 0) return;

            var selectedCurrencyId = $currencySelect.val();
            var rate = parseFloat($rateInput.val()) || 1;

            if (baseCurrencyId && selectedCurrencyId != baseCurrencyId && rate > 1) {
                // Convertir a moneda base
                totalPayingBase += amount / rate;
            } else {
                totalPayingBase += amount;
            }
        });

        var balance = totalPayableBase - totalPayingBase;

        // Actualizar el display de balance
        var $balanceDue = $('#balance_due');
        if ($balanceDue.length) {
            __write_number($balanceDue, balance);
            if (balance < 0) {
                $balanceDue.closest('.form-group').find('.change_return_span').text(
                    __currency_trans_from_en(Math.abs(balance), true)
                );
            }
        }
    }

    // === Event Listeners ===

    // Cuando cambia la moneda del pago
    $(document).on('change', '.payment-currency-select', function() {
        var rowIndex = $(this).data('row');
        updateEquivalent(rowIndex);
    });

    // Cuando cambia el monto del pago
    $(document).on('change keyup', '.payment-amount', function() {
        var $row = $(this).closest('.payment_row');
        var rowIndex = $row.find('.payment_row_index').val();
        updateEquivalent(rowIndex);
    });

    // Detectar la moneda base al cargar
    $(document).ready(function() {
        // Intentar obtener el currency_id del negocio
        if (!baseCurrencyId) {
            var $currencySelect = $('.payment-currency-select').first();
            if ($currencySelect.length) {
                baseCurrencyId = $currencySelect.val();
            }
        }
    });

})();
