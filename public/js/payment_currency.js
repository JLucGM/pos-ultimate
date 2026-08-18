/**
 * Audaz POS - Motor de Dualidad Multimoneda (Venezuela USD / Bs BCV)
 * Sincroniza precios duales, conversiones en tiempo real y opciones de pago rápidas.
 */
(function($) {
    'use strict';

    var rateCache = {};
    var baseCurrencyId = $('input#business_currency_id').val() || null;
    var globalBcvRate = parseFloat($('#bcv_exchange_rate_val').val()) || 1;

    /**
     * Formatear número a estilo moneda Bs venezolano (ej. 1.250,50)
     */
    function formatBs(amount) {
        if (isNaN(amount) || amount === null || amount === undefined) return '0,00';
        return parseFloat(amount).toLocaleString('es-VE', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    /**
     * Obtener tasa de cambio activa
     */
    function getActiveBcvRate(callback) {
        if (globalBcvRate && globalBcvRate > 1) {
            if (callback) callback(globalBcvRate);
            return;
        }

        $.ajax({
            url: '/exchange-rates/preview-api-rate',
            dataType: 'json',
            success: function(res) {
                if (res.success && res.oficial) {
                    globalBcvRate = parseFloat(res.oficial);
                    $('#bcv_exchange_rate_val').val(globalBcvRate);
                    if (callback) callback(globalBcvRate);
                } else {
                    if (callback) callback(1);
                }
            },
            error: function() {
                if (callback) callback(1);
            }
        });
    }

    /**
     * Actualizar visualización dual en barra inferior del POS
     */
    function updatePosDualPayable() {
        var rawTotal = $('#final_total_input').val() || '0';
        var totalUsd = parseFloat(rawTotal.replace(/,/g, '')) || 0;

        getActiveBcvRate(function(rate) {
            if (rate > 1) {
                var totalBs = totalUsd * rate;
                $('#total_payable_secondary').text('Bs. ' + formatBs(totalBs));
                $('#pos_secondary_currency_box').show();
            } else {
                $('#pos_secondary_currency_box').hide();
            }
        });
    }

    /**
     * Actualizar totales duales en modal de pago
     */
    function updatePaymentModalDualTotals() {
        var totalPayable = __read_number($('#total_payable_input')) || 0;
        var totalPaying = __read_number($('#total_paying_input')) || 0;
        var changeReturn = __read_number($('#change_return')) || 0;
        var balanceDue = __read_number($('#in_balance_due')) || 0;

        getActiveBcvRate(function(rate) {
            if (rate > 1) {
                $('.pos_dual_total_bs').text('≈ Bs. ' + formatBs(totalPayable * rate));
                $('.pos_dual_paying_bs').text('≈ Bs. ' + formatBs(totalPaying * rate));
                $('.pos_dual_change_bs').text('≈ Bs. ' + formatBs(changeReturn * rate));
                $('.pos_dual_balance_bs').text('≈ Bs. ' + formatBs(balanceDue * rate));
            }
        });
    }

    /**
     * Actualizar equivalencia debajo de cada fila de pago
     */
    function updateEquivalent(rowIndex) {
        var $currencySelect = $('#payment_currency_' + rowIndex);
        var $amountInput = $('#amount_' + rowIndex);
        var $equivDiv = $('#currency_equiv_' + rowIndex);
        var $rateInput = $('#payment_exchange_rate_' + rowIndex);

        if (!$currencySelect.length || !$amountInput.length) return;

        var selectedCurrencyId = $currencySelect.val();
        var selectedText = $currencySelect.find('option:selected').text();
        var amount = __read_number($amountInput) || 0;

        getActiveBcvRate(function(rate) {
            var isBs = selectedText.indexOf('VES') !== -1 || selectedText.indexOf('VEF') !== -1 || selectedText.indexOf('Bolívar') !== -1 || selectedText.indexOf('Bs') !== -1;

            if (isBs && rate > 1) {
                $rateInput.val(rate);
                if (amount > 0) {
                    var usdEquiv = amount / rate;
                    $equivDiv.find('.equiv-text').html(
                        'Equivale a <strong>$' + usdEquiv.toFixed(2) + ' USD</strong> (Tasa: ' + formatBs(rate) + ')'
                    );
                    $equivDiv.show();
                } else {
                    $equivDiv.hide();
                }
            } else {
                $rateInput.val(1);
                if (amount > 0 && rate > 1) {
                    var bsEquiv = amount * rate;
                    $equivDiv.find('.equiv-text').html(
                        'Equivale a <strong>Bs. ' + formatBs(bsEquiv) + '</strong> (Tasa: ' + formatBs(rate) + ')'
                    );
                    $equivDiv.show();
                } else {
                    $equivDiv.hide();
                }
            }

            updatePaymentModalDualTotals();
        });
    }

    // === EVENT LISTENERS ===

    // Observar cambios en el total a pagar del POS
    var observer = new MutationObserver(function() {
        updatePosDualPayable();
    });

    $(document).ready(function() {
        var target = document.getElementById('total_payable');
        if (target) {
            observer.observe(target, { childList: true, characterData: true, subtree: true });
        }

        // Consulta inicial de tasa
        getActiveBcvRate(function() {
            updatePosDualPayable();
        });

        // Eventos en campos de pago
        $(document).on('change', '.payment-currency-select', function() {
            var rowIndex = $(this).data('row');
            updateEquivalent(rowIndex);
        });

        $(document).on('input change keyup', '.payment-amount', function() {
            var $row = $(this).closest('.payment_row');
            var rowIndex = $row.find('.payment_row_index').val();
            updateEquivalent(rowIndex);
            setTimeout(updatePaymentModalDualTotals, 100);
        });

        // Botón Cobro Rápido en Dólares ($ USD)
        $(document).on('click', '#quick_pay_usd_btn', function() {
            var totalUsd = __read_number($('#total_payable_input')) || 0;
            var $firstAmount = $('#amount_0');
            var $firstCurrency = $('#payment_currency_0');

            if ($firstCurrency.length) {
                // Seleccionar USD si existe en el dropdown
                $firstCurrency.find('option').each(function() {
                    if ($(this).text().indexOf('USD') !== -1 || $(this).text().indexOf('Dólar') !== -1) {
                        $firstCurrency.val($(this).val()).trigger('change');
                        return false;
                    }
                });
            }

            if ($firstAmount.length) {
                __write_number($firstAmount, totalUsd);
                $firstAmount.trigger('change');
            }
        });

        // Botón Cobro Rápido en Bolívares (Bs VES)
        $(document).on('click', '#quick_pay_bs_btn', function() {
            var totalUsd = __read_number($('#total_payable_input')) || 0;
            var $firstAmount = $('#amount_0');
            var $firstCurrency = $('#payment_currency_0');

            getActiveBcvRate(function(rate) {
                var totalBs = totalUsd * (rate > 1 ? rate : 1);

                if ($firstCurrency.length) {
                    // Seleccionar VES/Bs en el dropdown
                    $firstCurrency.find('option').each(function() {
                        if ($(this).text().indexOf('VES') !== -1 || $(this).text().indexOf('VEF') !== -1 || $(this).text().indexOf('Bolívar') !== -1 || $(this).text().indexOf('Bs') !== -1) {
                            $firstCurrency.val($(this).val()).trigger('change');
                            return false;
                        }
                    });
                }

                if ($firstAmount.length) {
                    __write_number($firstAmount, totalBs);
                    $firstAmount.trigger('change');
                }
            });
        });

        // Al abrir modal de pago, actualizar totales duales
        $('#modal_payment').on('shown.bs.modal', function() {
            updatePaymentModalDualTotals();
            $('.payment-amount').each(function() {
                var $row = $(this).closest('.payment_row');
                var rowIndex = $row.find('.payment_row_index').val();
                updateEquivalent(rowIndex);
            });
        });
    });

})(jQuery);
