<div class="audaz-profit-loss-container" style="display: flex; flex-direction: column; gap: 20px;">

    <!-- 1. TARJETAS KPI EJECUTIVAS PRINCIPALES (4 Cards) -->
    <div class="row">
        <!-- Ganancia Neta -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div style="background: linear-gradient(135deg, #0B0F1D 0%, #1E293B 100%); border-radius: 16px; padding: 20px; border: 1.5px solid rgba(16, 185, 129, 0.4); box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.15); color: #FFFFFF; position: relative; overflow: hidden;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #10B981;">
                        <i class="fas fa-trophy"></i> @lang('report.net_profit')
                    </span>
                    <span style="font-size: 10px; font-weight: 700; background: rgba(16, 185, 129, 0.2); color: #34D399; padding: 2px 8px; border-radius: 20px;">
                        Final
                    </span>
                </div>
                <div style="font-size: 26px; font-weight: 900; color: #10B981; font-family: ui-monospace, monospace; line-height: 1.2;">
                    <span class="display_currency" data-currency_symbol="true">{{$data['net_profit']}}</span>
                </div>
                <div style="font-size: 11px; color: #94A3B8; margin-top: 6px;">
                    Beneficio líquido después de gastos
                </div>
            </div>
        </div>

        <!-- Ganancia Bruta -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div style="background: #FFFFFF; border-radius: 16px; padding: 20px; border: 1px solid #E2E8F0; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B;">
                        <i class="fas fa-chart-line tw-text-blue-500"></i> @lang('lang_v1.gross_profit')
                    </span>
                    <span style="font-size: 10px; font-weight: 700; background: #EFF6FF; color: #2563EB; padding: 2px 8px; border-radius: 20px;">
                        Margen
                    </span>
                </div>
                <div style="font-size: 24px; font-weight: 800; color: #0F172A; font-family: ui-monospace, monospace; line-height: 1.2;">
                    <span class="display_currency" data-currency_symbol="true">{{$data['gross_profit']}}</span>
                </div>
                <div style="font-size: 11px; color: #64748B; margin-top: 6px;">
                    Ventas menos costo de compra
                </div>
            </div>
        </div>

        <!-- Ventas Totales -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div style="background: #FFFFFF; border-radius: 16px; padding: 20px; border: 1px solid #E2E8F0; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B;">
                        <i class="fas fa-shopping-cart tw-text-[#FB4C0A]"></i> @lang('home.total_sell')
                    </span>
                    <span style="font-size: 10px; font-weight: 700; background: rgba(251,76,10,0.1); color: #FB4C0A; padding: 2px 8px; border-radius: 20px;">
                        Ingresos
                    </span>
                </div>
                <div style="font-size: 24px; font-weight: 800; color: #0F172A; font-family: ui-monospace, monospace; line-height: 1.2;">
                    <span class="display_currency" data-currency_symbol="true">{{$data['total_sell']}}</span>
                </div>
                <div style="font-size: 11px; color: #64748B; margin-top: 6px;">
                    Total de ventas facturadas
                </div>
            </div>
        </div>

        <!-- Gastos Totales -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div style="background: #FFFFFF; border-radius: 16px; padding: 20px; border: 1px solid #E2E8F0; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B;">
                        <i class="fas fa-receipt tw-text-rose-500"></i> @lang('report.total_expense')
                    </span>
                    <span style="font-size: 10px; font-weight: 700; background: #FEF2F2; color: #DC2626; padding: 2px 8px; border-radius: 20px;">
                        Egresos
                    </span>
                </div>
                <div style="font-size: 24px; font-weight: 800; color: #DC2626; font-family: ui-monospace, monospace; line-height: 1.2;">
                    <span class="display_currency" data-currency_symbol="true">{{$data['total_expense']}}</span>
                </div>
                <div style="font-size: 11px; color: #64748B; margin-top: 6px;">
                    Gastos operativos del período
                </div>
            </div>
        </div>
    </div>

    <!-- 2. RESUMEN FINANCIERO PASO A PASO -->
    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 18px; padding: 20px 24px; box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);">
        <div style="font-size: 14px; font-weight: 800; color: #0F172A; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-calculator tw-text-[#FB4C0A]"></i> Desglose de Rendimiento Financiero
        </div>
        <div class="row" style="display: flex; flex-wrap: wrap; align-items: center; gap: 10px 0;">
            
            <div class="col-md-2 col-sm-4 col-xs-6" style="border-right: 1px dashed #E2E8F0;">
                <div style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase;">1. Ventas</div>
                <div style="font-size: 16px; font-weight: 800; color: #0F172A; margin-top: 4px;">
                    <span class="display_currency" data-currency_symbol="true">{{$data['total_sell']}}</span>
                </div>
            </div>

            <div class="col-md-3 col-sm-4 col-xs-6" style="border-right: 1px dashed #E2E8F0;">
                <div style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase;">2. Costo Mercancía (COGS)</div>
                <div style="font-size: 16px; font-weight: 800; color: #E11D48; margin-top: 4px;">
                    - <span class="display_currency" data-currency_symbol="true">{{ (($data['opening_stock'] + $data['total_purchase']) - $data['closing_stock']) }}</span>
                </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6" style="border-right: 1px dashed #E2E8F0;">
                <div style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase;">3. Margen Bruto</div>
                <div style="font-size: 16px; font-weight: 800; color: #2563EB; margin-top: 4px;">
                    = <span class="display_currency" data-currency_symbol="true">{{$data['gross_profit']}}</span>
                </div>
            </div>

            <div class="col-md-2 col-sm-6 col-xs-6" style="border-right: 1px dashed #E2E8F0;">
                <div style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase;">4. Gastos & Ajustes</div>
                <div style="font-size: 16px; font-weight: 800; color: #DC2626; margin-top: 4px;">
                    - <span class="display_currency" data-currency_symbol="true">{{$data['total_expense'] + $data['total_adjustment']}}</span>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div style="font-size: 11px; font-weight: 700; color: #059669; text-transform: uppercase;">5. Beneficio Neto</div>
                <div style="font-size: 18px; font-weight: 900; color: #10B981; margin-top: 4px;">
                    = <span class="display_currency" data-currency_symbol="true">{{$data['net_profit']}}</span>
                </div>
            </div>

        </div>
    </div>

    <!-- 3. DESGLOSE CONTABLE DETALLADO (Colapsable para no saturar la vista) -->
    <div style="margin-top: 5px;">
        <div style="text-align: center; margin-bottom: 12px;">
            <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseAuditDetails" aria-expanded="false" aria-controls="collapseAuditDetails" style="border-radius: 20px; padding: 8px 22px; font-size: 13px; font-weight: 700; background: #FFFFFF; border: 1.5px solid #CBD5E1; color: #334155; box-shadow: 0 2px 6px rgba(0,0,0,0.05); display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-layer-group tw-text-[#FB4C0A]"></i> Ver Desglose Contable Completo e Inventario
                <i class="fas fa-chevron-down tw-text-xs"></i>
            </button>
        </div>

        <div class="collapse" id="collapseAuditDetails">
            <div class="row" style="margin-top: 15px;">
                <div class="col-md-6">
                    <div style="background: #FFFFFF; border-radius: 16px; padding: 18px; border: 1px solid #E2E8F0; margin-bottom: 15px;">
                        <h4 style="font-size: 14px; font-weight: 800; color: #0F172A; margin-top: 0; margin-bottom: 14px; padding-bottom: 8px; border-bottom: 1px solid #F1F5F9;">
                            <i class="fas fa-boxes tw-text-[#FB4C0A]"></i> Entradas y Stock Inicial
                        </h4>
                        @include('report.partials.opening_stock_report_table')
                    </div>
                </div>

                <div class="col-md-6">
                    <div style="background: #FFFFFF; border-radius: 16px; padding: 18px; border: 1px solid #E2E8F0; margin-bottom: 15px;">
                        <h4 style="font-size: 14px; font-weight: 800; color: #0F172A; margin-top: 0; margin-bottom: 14px; padding-bottom: 8px; border-bottom: 1px solid #F1F5F9;">
                            <i class="fas fa-cash-register tw-text-emerald-500"></i> Salidas y Stock Final
                        </h4>
                        @include('report.partials.clossing_stock_report_table')
                    </div>
                </div>

                <div class="col-xs-12">
                    <div style="background: #FFFFFF; border-radius: 16px; padding: 18px; border: 1px solid #E2E8F0;">
                        <h4 style="font-size: 14px; font-weight: 800; color: #0F172A; margin-top: 0; margin-bottom: 14px; padding-bottom: 8px; border-bottom: 1px solid #F1F5F9;">
                            <i class="fas fa-file-invoice-dollar tw-text-blue-500"></i> Fórmulas de Cálculo Detalladas
                        </h4>
                        @include('report.partials.net_gross_profit_report_details')
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
