/**
 * Audaz POS - Motor de Dualidad Multimoneda (Venezuela USD / Bs BCV)
 * Sincroniza precios duales, conversiones en tiempo real, tasas históricas por fecha y edición manual en pagos.
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
     * Actualizar visualización dual (POS, Crear Venta y Crear Pedido)
     */
    function updateDualPayable() {
        var totalUsd = 0;
        if ($('#final_total_input').length) {
            if (typeof __read_number !== 'undefined') {
                totalUsd = __read_number($('#final_total_input')) || 0;
            } else {
                var raw = $('#final_total_input').val() || '0';
                totalUsd = parseFloat(raw.replace(/,/g, '')) || 0;
            }
        } else if ($('#total_payable').length) {
            var txt = $('#total_payable').text() || '0';
            totalUsd = parseFloat(txt.replace(/[^0-9.-]+/g, '')) || 0;
        }

        getActiveBcvRate(function(rate) {
            var formattedUsd = parseFloat(totalUsd).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            if (rate > 1) {
                var totalBs = totalUsd * rate;
                $('#total_payable_secondary').text('Bs. ' + formatBs(totalBs));
                $('.sell_dual_total_bs').text('Bs. ' + formatBs(totalBs));
                $('#sticky_total_usd').text(formattedUsd);
                $('#sticky_total_bs').text('Bs. ' + formatBs(totalBs));
                $('.sell_dual_bcv_rate').text(formatBs(rate));
                $('#pos_secondary_currency_box, #sell_secondary_currency_box, .dual_currency_box, #dual_currency_sticky_bar').show();
            } else {
                $('#sticky_total_usd').text(formattedUsd);
                $('#pos_secondary_currency_box, #sell_secondary_currency_box, .dual_currency_box, #dual_currency_sticky_bar').hide();
            }
        });
    }

    /**
     * Actualizar totales duales en modal de pago POS
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
     * Actualizar equivalencia debajo de cada fila de pago POS
     */
    function updateEquivalent(rowIndex) {
        var $currencySelect = $('#payment_currency_' + rowIndex);
        var $amountInput = $('#amount_' + rowIndex);
        var $equivDiv = $('#currency_equiv_' + rowIndex);
        var $rateInput = $('#payment_exchange_rate_' + rowIndex);

        if (!$currencySelect.length || !$amountInput.length) return;

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

    /**
     * Actualizar equivalencia en tiempo real en modales de pagos de compras, ventas y proveedores
     */
    function updateInvoicePaymentModalEquiv($container) {
        if (!$container || !$container.length) $container = $(document);

        var $currencySelect = $container.find('.modal_payment_currency, #modal_payment_currency');
        var $amountInput = $container.find('.modal_payment_amount, #modal_payment_amount, .payment_amount');
        var $rateInput = $container.find('.modal_payment_exchange_rate, #modal_payment_exchange_rate');
        var $equivBox = $container.find('.modal_equiv_box');
        var $equivText = $container.find('.modal_equiv_text');

        if (!$amountInput.length || !$rateInput.length) return;

        var currencyText = $currencySelect.length ? ($currencySelect.find('option:selected').text() || '') : '';
        var isBs = /VES|VEF|Bolívar|Bs/i.test(currencyText);

        var amount = 0;
        if (typeof __read_number !== 'undefined') {
            amount = __read_number($amountInput) || 0;
        } else {
            var raw = $amountInput.val() || '0';
            amount = parseFloat(raw.replace(/,/g, '')) || 0;
        }

        var rate = 1;
        if (typeof __read_number !== 'undefined') {
            rate = __read_number($rateInput) || 0;
        } else {
            var rawRate = $rateInput.val() || '1';
            rate = parseFloat(rawRate.replace(/,/g, '')) || 1;
        }

        if (rate <= 0) rate = 1;

        if (isBs) {
            if (rate > 1 && amount > 0) {
                var usd = amount / rate;
                $equivText.html(
                    'Pago en Bolívares: <strong>Bs. ' + formatBs(amount) + '</strong> &nbsp;&bull;&nbsp; ' +
                    'Equivale a: <strong>$' + usd.toFixed(2) + ' USD</strong> &nbsp;&bull;&nbsp; ' +
                    '(Tasa aplicada: <strong>' + formatBs(rate) + ' Bs/$</strong>)'
                );
                $equivBox.removeClass('alert-info').addClass('alert-success').slideDown(150);
            } else {
                $equivBox.slideUp(150);
            }
        } else {
            if (rate > 1 && amount > 0) {
                var bs = amount * rate;
                $equivText.html(
                    'Pago en Dólares: <strong>$' + amount.toFixed(2) + ' USD</strong> &nbsp;&bull;&nbsp; ' +
                    'Equivale a: <strong>Bs. ' + formatBs(bs) + '</strong> &nbsp;&bull;&nbsp; ' +
                    '(Tasa de referencia: <strong>' + formatBs(rate) + ' Bs/$</strong>)'
                );
                $equivBox.removeClass('alert-success').addClass('alert-info').slideDown(150);
            } else {
                $equivBox.slideUp(150);
            }
        }
    }

    /**
     * Consultar tasa de cambio por fecha para el modal de pago
     */
    function fetchRateForPaymentDate($container, dateStr, callback) {
        if (!dateStr) {
            if (callback) callback(null);
            return;
        }

        var $rateInput = $container.find('.modal_payment_exchange_rate, #modal_payment_exchange_rate');
        var $dateLabel = $container.find('.modal_rate_date_label');
        var $refreshBtn = $container.find('.btn_refresh_modal_rate');

        $refreshBtn.find('i').addClass('fa-spin');

        $.ajax({
            url: '/get-exchange-rate',
            data: { date: dateStr },
            dataType: 'json',
            success: function(res) {
                $refreshBtn.find('i').removeClass('fa-spin');
                if (res.success && res.rate) {
                    var rateVal = parseFloat(res.rate);
                    if (typeof __write_number !== 'undefined') {
                        __write_number($rateInput, rateVal);
                    } else {
                        $rateInput.val(rateVal);
                    }
                    if ($dateLabel.length && res.date) {
                        $dateLabel.text(res.date);
                    }
                    updateInvoicePaymentModalEquiv($container);
                    if (callback) callback(rateVal);
                }
            },
            error: function() {
                $refreshBtn.find('i').removeClass('fa-spin');
                if (callback) callback(null);
            }
        });
    }

    // === EVENT LISTENERS ===

    // Observar cambios en el total a pagar
    var observer = new MutationObserver(function() {
        updateDualPayable();
    });

    $(document).ready(function() {
        var target = document.getElementById('total_payable');
        if (target) {
            observer.observe(target, { childList: true, characterData: true, subtree: true });
        }

        // Eventos en campos de productos y totales para recalcular al instante
        $(document).on('change keyup input', '#final_total_input, .pos_quantity, .pos_unit_price, .pos_unit_price_inc_tax, #discount_amount, #tax_rate_id, .sub_unit', function() {
            setTimeout(updateDualPayable, 80);
        });

        // Consulta inicial de tasa
        getActiveBcvRate(function() {
            updateDualPayable();
        });

        // Eventos en campos de pago POS
        $(document).on('change', '.payment-currency-select', function() {
            var rowIndex = $(this).data('row');
            updateEquivalent(rowIndex);
        });

        $(document).on('input change keyup', '.payment-amount', function() {
            var $row = $(this).closest('.payment_row');
            var rowIndex = $row.find('.payment_row_index').val();
            if (rowIndex !== undefined && rowIndex !== null) {
                updateEquivalent(rowIndex);
                setTimeout(updatePaymentModalDualTotals, 100);
            }
        });

        // Eventos en inputs de modales de pagos de transacciones (compras/ventas/proveedores)
        $(document).on('input change keyup', '.modal_payment_amount, #modal_payment_amount, .modal_payment_exchange_rate, #modal_payment_exchange_rate', function() {
            var $modal = $(this).closest('.modal, form');
            updateInvoicePaymentModalEquiv($modal);
        });

        $(document).on('change', '.modal_payment_currency, #modal_payment_currency', function() {
            var $modal = $(this).closest('.modal, form');
            updateInvoicePaymentModalEquiv($modal);
        });

        // Botón de refrescar tasa de la fecha seleccionada
        $(document).on('click', '.btn_refresh_modal_rate', function(e) {
            e.preventDefault();
            var $modal = $(this).closest('.modal, form');
            var $dateInput = $modal.find('.modal_paid_on, #paid_on, input[name="paid_on"]');
            var dateVal = $dateInput.val() || '';
            fetchRateForPaymentDate($modal, dateVal);
        });

        // Al cambiar la fecha del pago (bootstrap datetimepicker o input nativo)
        $(document).on('dp.change change', '.modal_paid_on, #paid_on, input[name="paid_on"]', function(e) {
            var $modal = $(this).closest('.modal, form');
            if ($modal.find('.modal_payment_exchange_rate, #modal_payment_exchange_rate').length) {
                var dateVal = $(this).val() || '';
                fetchRateForPaymentDate($modal, dateVal);
            }
        });

        // Botón Cobro Rápido en Dólares ($ USD) POS
        $(document).on('click', '#quick_pay_usd_btn', function() {
            var totalUsd = __read_number($('#total_payable_input')) || 0;
            var $firstAmount = $('#amount_0');
            var $firstCurrency = $('#payment_currency_0');

            if ($firstCurrency.length) {
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

        // Botón Cobro Rápido en Bolívares (Bs VES) POS
        $(document).on('click', '#quick_pay_bs_btn', function() {
            var totalUsd = __read_number($('#total_payable_input')) || 0;
            var $firstAmount = $('#amount_0');
            var $firstCurrency = $('#payment_currency_0');

            getActiveBcvRate(function(rate) {
                var totalBs = totalUsd * (rate > 1 ? rate : 1);

                if ($firstCurrency.length) {
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

        // Al abrir modal de pago POS, actualizar totales duales
        $('#modal_payment').on('shown.bs.modal', function() {
            updatePaymentModalDualTotals();
            $('.payment-amount').each(function() {
                var $row = $(this).closest('.payment_row');
                var rowIndex = $row.find('.payment_row_index').val();
                if (rowIndex !== undefined && rowIndex !== null) {
                    updateEquivalent(rowIndex);
                }
            });
        });

        // Al abrir cualquier modal de pago estándar
        $(document).on('shown.bs.modal', '.payment_modal, .edit_payment_modal, .pay_contact_due_modal', function() {
            var $modal = $(this);
            setTimeout(function() {
                updateInvoicePaymentModalEquiv($modal);
            }, 150);
        });
    });

})(jQuery);
