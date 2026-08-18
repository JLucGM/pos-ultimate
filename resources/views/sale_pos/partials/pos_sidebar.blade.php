<!-- Selector de Modo de Vista POS: Catálogo Táctil vs. Búsqueda Inteligente Alto Volumen -->
<div class="tw-flex tw-items-center tw-justify-between tw-bg-slate-100 tw-p-1.5 tw-rounded-xl tw-mb-3 no-print">
    <button type="button" id="btn_pos_mode_catalog" class="pos-mode-btn active tw-flex-1 tw-py-2 tw-px-3 tw-rounded-lg tw-text-xs tw-font-extrabold tw-transition-all tw-flex tw-items-center tw-justify-center tw-gap-1.5 tw-bg-white tw-text-slate-800 tw-shadow-sm">
        <i class="fas fa-th-large tw-text-slate-600"></i> <span>📱 Catálogo Táctil</span>
    </button>
    <button type="button" id="btn_pos_mode_search" class="pos-mode-btn tw-flex-1 tw-py-2 tw-px-3 tw-rounded-lg tw-text-xs tw-font-extrabold tw-transition-all tw-flex tw-items-center tw-justify-center tw-gap-1.5 tw-text-slate-600 hover:tw-text-[#FB4C0A]">
        <i class="fas fa-bolt tw-text-amber-500"></i> <span>⚡ Búsqueda Rápida (+1000 SKU)</span>
    </button>
</div>

<!-- ================= MODO 1: CATÁLOGO TÁCTIL (Restaurantes, Cafés, Boutiques) ================= -->
<div id="pos_catalog_view_container">
    <div class="row" id="featured_products_box" style="display: none;">
        @if (!empty($featured_products))
            @include('sale_pos.partials.featured_products')
        @endif
    </div>

    <!-- Filtros de Categoría y Marca con Alto Contraste y Texto Nítido -->
    <div class="row tw-mb-2">
        @if (!empty($categories))
            <div class="col-xs-6 !tw-px-1" id="product_category_div">
                <div class="tw-dw-drawer tw-dw-drawer-end">
                    <input id="my-drawer-4" type="checkbox" class="tw-dw-drawer-toggle">
                    <div class="tw-dw-drawer-content">
                        <label for="my-drawer-4"
                            style="background: #0B0F1D !important; color: #FFFFFF !important; border: 1.5px solid #334155 !important; border-radius: 12px !important; height: 42px !important; display: flex !important; align-items: center !important; justify-content: center !important; gap: 8px !important; font-size: 13px !important; font-weight: 800 !important; cursor: pointer !important; width: 100% !important; margin: 0 !important; box-shadow: 0 2px 6px rgba(0,0,0,0.15) !important;">
                            <i class="fas fa-th-large" style="color: #FB4C0A !important; font-size: 14px !important;"></i>
                            <span style="color: #FFFFFF !important; font-weight: 800 !important;">@lang('category.category')</span>
                        </label>
                    </div>
                    <div class="tw-dw-drawer-side" style="z-index: 4000">
                        <label for="my-drawer-4" aria-label="close sidebar" class="tw-dw-drawer-overlay overlay-category"></label>
                        <div class="tw-dw-menu tw-w-3/4 md:tw-w-2/4 tw-min-h-full tw-bg-white tw-p-6">
                            <div class="tw-flex tw-items-center tw-justify-between tw-mb-6">
                                <button type="button" class="category-back tw-bg-slate-100 hover:tw-bg-slate-200 tw-p-2 tw-rounded-lg" style="display: none">
                                    <i class="fas fa-arrow-left tw-text-slate-700"></i>
                                </button>
                                <h3 class="category_heading tw-font-extrabold tw-text-lg tw-text-slate-900 tw-m-0">
                                    <i class="fas fa-layer-group tw-text-[#FB4C0A] tw-mr-2"></i>@lang('category.category')
                                </h3>
                                <button type="button" class="close-side-bar-category tw-text-slate-400 hover:tw-text-slate-700 tw-p-2">
                                    <i class="fas fa-times-circle tw-text-2xl"></i>
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-xs-6 tw-mb-3 tw-cursor-pointer main-category-div main-category no-print" data-value="all" data-parent="0">
                                    <div class="tw-p-4 tw-rounded-xl tw-bg-slate-50 hover:tw-bg-orange-50 tw-border tw-border-slate-200 hover:tw-border-[#FB4C0A] tw-text-center tw-transition-all">
                                        <i class="fas fa-border-all tw-text-[#FB4C0A] tw-text-2xl tw-mb-2"></i>
                                        <span class="tw-block tw-font-bold tw-text-xs tw-text-slate-800">@lang('lang_v1.all_category')</span>
                                    </div>
                                </div>
                                @foreach ($categories as $category)
                                    <div class="col-md-4 col-xs-6 tw-mb-3 tw-cursor-pointer main-category-div no-print" data-value="{{ $category['id'] }}" data-name="{{ $category['name'] }}" data-parent="1">
                                        <div class="tw-p-4 tw-rounded-xl tw-bg-slate-50 hover:tw-bg-orange-50 tw-border tw-border-slate-200 hover:tw-border-[#FB4C0A] tw-text-center tw-transition-all">
                                            <i class="fas fa-box tw-text-[#FB4C0A] tw-text-2xl tw-mb-2"></i>
                                            <span class="tw-block tw-font-bold tw-text-xs tw-text-slate-800 tw-line-clamp-1">{{ $category['name'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                                @foreach ($categories as $category)
                                    @if (!empty($category['sub_categories']))
                                        <div class="{{ $category['id'] }} all-sub-category" style="display: none">
                                            @foreach ($category['sub_categories'] as $sc)
                                                @if ($sc['parent_id'] != 0)
                                                    <div class="col-md-4 col-xs-6 tw-mb-3 tw-cursor-pointer product_category no-print" data-value="{{ $sc['id'] }}">
                                                        <div class="tw-p-4 tw-rounded-xl tw-bg-slate-50 hover:tw-bg-orange-50 tw-border tw-border-slate-200 hover:tw-border-[#FB4C0A] tw-text-center tw-transition-all">
                                                            <i class="fas fa-tag tw-text-[#FB4C0A] tw-text-2xl tw-mb-2"></i>
                                                            <span class="tw-block tw-font-bold tw-text-xs tw-text-slate-800 tw-line-clamp-1">{{ $sc['name'] }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (!empty($brands))
            <div class="col-xs-6 !tw-px-1" id="product_brand_div">
                <div class="tw-dw-drawer tw-dw-drawer-end">
                    <input id="my-drawer-brand" type="checkbox" class="tw-dw-drawer-toggle">
                    <div class="tw-dw-drawer-content">
                        <label for="my-drawer-brand"
                            style="background: #0B0F1D !important; color: #FFFFFF !important; border: 1.5px solid #334155 !important; border-radius: 12px !important; height: 42px !important; display: flex !important; align-items: center !important; justify-content: center !important; gap: 8px !important; font-size: 13px !important; font-weight: 800 !important; cursor: pointer !important; width: 100% !important; margin: 0 !important; box-shadow: 0 2px 6px rgba(0,0,0,0.15) !important;">
                            <i class="fas fa-certificate" style="color: #F59E0B !important; font-size: 14px !important;"></i>
                            <span style="color: #FFFFFF !important; font-weight: 800 !important;">@lang('brand.brands')</span>
                        </label>
                    </div>
                    <div class="tw-dw-drawer-side" style="z-index: 4000">
                        <label for="my-drawer-brand" aria-label="close sidebar" class="tw-dw-drawer-overlay overlay-brand"></label>
                        <div class="tw-dw-menu tw-w-3/4 md:tw-w-2/4 tw-min-h-full tw-bg-white tw-p-6">
                            <div class="tw-flex tw-items-center tw-justify-between tw-mb-6">
                                <h3 class="tw-font-extrabold tw-text-lg tw-text-slate-900 tw-m-0">
                                    <i class="fas fa-crown tw-text-amber-500 tw-mr-2"></i>@lang('brand.brands')
                                </h3>
                                <button type="button" class="close-side-bar-brand tw-text-slate-400 hover:tw-text-slate-700 tw-p-2">
                                    <i class="fas fa-times-circle tw-text-2xl"></i>
                                </button>
                            </div>
                            <div class="row">
                                @foreach ($brands as $key => $brand)
                                    <div class="col-md-4 col-xs-6 tw-mb-3 tw-cursor-pointer product_brand no-print" data-value="{{ $key }}">
                                        <div class="tw-p-4 tw-rounded-xl tw-bg-slate-50 hover:tw-bg-amber-50 tw-border tw-border-slate-200 hover:tw-border-amber-400 tw-text-center tw-transition-all">
                                            <i class="fas fa-bookmark tw-text-amber-500 tw-text-2xl tw-mb-2"></i>
                                            <span class="tw-block tw-font-bold tw-text-xs tw-text-slate-800 tw-line-clamp-1">{{ $brand }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-6 hide" id="product_service_div">
            {!! Form::select(
                'is_enabled_stock',
                ['' => __('messages.all'), 'product' => __('sale.product'), 'service' => __('lang_v1.service')],
                null,
                ['id' => 'is_enabled_stock', 'class' => 'select2', 'name' => null, 'style' => 'width:100% !important'],
            ) !!}
        </div>

        <div class="col-sm-4 @if (empty($featured_products)) hide @endif" id="feature_product_div">
            <button type="button" class="btn btn-primary btn-flat" id="show_featured_products">@lang('lang_v1.featured_products')</button>
        </div>
    </div>

    <!-- Cuadrícula de Productos Táctiles -->
    <div class="row">
        <input type="hidden" id="suggestion_page" value="1">
        <div class="col-md-12">
            <div class="eq-height-row" id="product_list_body"></div>
        </div>
        <div class="col-md-12 text-center" id="suggestion_page_loader" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-2x tw-text-[#FB4C0A]"></i>
        </div>
    </div>
</div>

<!-- ================= MODO 2: BÚSQUEDA INTELIGENTE ALTO VOLUMEN (Supermercados, Ferreterías, Farmacias) ================= -->
<div id="pos_high_sku_search_container" style="display: none;">
    <!-- Buscador Superior Instantáneo -->
    <div class="tw-relative tw-mb-3">
        <div class="tw-flex tw-items-center tw-bg-white tw-border-2 tw-border-slate-200 focus-within:tw-border-[#FB4C0A] tw-rounded-xl tw-p-1 tw-shadow-sm tw-transition-all">
            <span class="tw-px-3 tw-text-slate-400">
                <i class="fas fa-search tw-text-[#FB4C0A]"></i>
            </span>
            <input type="text" id="high_sku_search_input" 
                class="tw-w-full tw-py-2 tw-pr-3 tw-text-sm tw-font-semibold tw-text-slate-800 tw-bg-transparent tw-outline-none" 
                placeholder="Escribe Nombre, Código, SKU o Código de Barras... (F2)"
                autocomplete="off">
            <button type="button" id="high_sku_clear_btn" class="tw-p-2 tw-text-slate-400 hover:tw-text-slate-600 tw-text-xs" style="display: none;">
                <i class="fas fa-times-circle"></i>
            </button>
            <span class="tw-text-[10px] tw-font-bold tw-bg-slate-100 tw-text-slate-500 tw-px-2 tw-py-1 tw-rounded-md tw-mr-2 tw-hidden sm:tw-inline-block">F2</span>
        </div>
    </div>

    <!-- Filtro de Categoría Rápida en Chips -->
    @if (!empty($categories))
    <div class="tw-flex tw-items-center tw-gap-1.5 tw-overflow-x-auto tw-pb-2 tw-mb-2 no-scrollbar" id="high_sku_category_chips">
        <button type="button" class="high-sku-cat-chip active tw-whitespace-nowrap tw-px-3 tw-py-1 tw-rounded-full tw-text-xs tw-font-bold tw-bg-[#0B0F1D] tw-text-white" data-category-id="all">
            Todos
        </button>
        @foreach ($categories as $cat)
            <button type="button" class="high-sku-cat-chip tw-whitespace-nowrap tw-px-3 tw-py-1 tw-rounded-full tw-text-xs tw-font-bold tw-bg-slate-100 hover:tw-bg-orange-50 hover:tw-text-[#FB4C0A] tw-text-slate-700 tw-transition-all" data-category-id="{{ $cat['id'] }}">
                {{ $cat['name'] }}
            </button>
        @endforeach
    </div>
    @endif

    <!-- Contenedor de Resultados en Lista Ultra Rápida -->
    <div class="high-sku-results-wrapper" style="max-height: 520px; overflow-y: auto;">
        <div id="high_sku_results_list">
            <div class="tw-text-center tw-py-12 tw-text-slate-400">
                <i class="fas fa-barcode tw-text-4xl tw-mb-2 tw-text-slate-300"></i>
                <p class="tw-text-xs tw-font-semibold">Escribe o escanea para buscar entre miles de productos al instante.</p>
            </div>
        </div>
        <div id="high_sku_loading" class="tw-text-center tw-py-8" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-2x tw-text-[#FB4C0A]"></i>
            <p class="tw-text-xs tw-font-bold tw-text-slate-500 tw-mt-2">Buscando productos...</p>
        </div>
    </div>
</div>
