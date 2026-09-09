<script>
$(document).ready(function() {
    // Función para actualizar el estado visual de una tarjeta de permiso
    function updateCardState($card) {
        var $input = $card.find('input[type="checkbox"], input[type="radio"]');
        if ($input.is(':checked')) {
            $card.addClass('is-checked');
        } else {
            $card.removeClass('is-checked');
        }
    }

    // Actualizar conteos por módulo y global
    function updateAllCounts() {
        var totalGlobal = 0;
        var selectedGlobal = 0;

        $('.permission-module-card').each(function() {
            var $module = $(this);
            var $inputs = $module.find('input[type="checkbox"], input[type="radio"]');
            var totalModule = $inputs.length;
            var selectedModule = $inputs.filter(':checked').length;

            totalGlobal += totalModule;
            selectedGlobal += selectedModule;

            var $badge = $module.find('.permission-module-badge');
            $badge.text(selectedModule + ' / ' + totalModule);
            if (selectedModule > 0) {
                $badge.addClass('active');
            } else {
                $badge.removeClass('active');
            }

            var $toggleBtn = $module.find('.module-toggle-all-btn');
            if (selectedModule === totalModule && totalModule > 0) {
                $toggleBtn.text('Desmarcar Módulo').addClass('btn-primary').removeClass('btn-default');
            } else {
                $toggleBtn.text('Marcar Módulo').addClass('btn-default').removeClass('btn-primary');
            }
        });

        // Actualizar barra de progreso y badges globales
        var pct = totalGlobal > 0 ? Math.round((selectedGlobal / totalGlobal) * 100) : 0;
        $('#global_selected_count_badge').text(selectedGlobal + ' de ' + totalGlobal + ' (' + pct + '%)');
        $('#global_selected_progress_bar').css('width', pct + '%');
        $('#sticky_selected_count_display').text(selectedGlobal);
    }

    // Actualizar nombre del rol en barra sticky
    function updateStickyRoleName() {
        var name = $('input#name').val() || '--';
        $('#sticky_role_name_display').text(name);
    }

    $('input#name').on('input change', updateStickyRoleName);
    updateStickyRoleName();

    // Escuchar el evento change en los inputs (cubren toda la tarjeta con z-index 2)
    $(document).on('change', '.permission-item-card input[type="checkbox"]', function() {
        updateCardState($(this).closest('.permission-item-card'));
        updateAllCounts();
    });

    $(document).on('change', '.permission-item-card input[type="radio"]', function() {
        var radioName = $(this).attr('name');
        $('input[name="' + radioName + '"]').each(function() {
            updateCardState($(this).closest('.permission-item-card'));
        });
        updateAllCounts();
    });

    // Toggle para marcar/desmarcar todos los permisos de un módulo
    $(document).on('click', '.module-toggle-all-btn', function(e) {
        e.stopPropagation();
        var $module = $(this).closest('.permission-module-card');
        var $inputs = $module.find('input[type="checkbox"]');
        var allChecked = $inputs.length === $inputs.filter(':checked').length;

        $inputs.prop('checked', !allChecked);
        $module.find('.permission-item-card').each(function() {
            updateCardState($(this));
        });
        updateAllCounts();
    });

    // Colapsar / Expandir módulo al hacer click en el header
    $(document).on('click', '.permission-module-header', function(e) {
        if ($(e.target).closest('.module-toggle-all-btn').length > 0) return;
        var $body = $(this).next('.permission-module-body');
        var $icon = $(this).find('.toggle-collapse-icon');
        $body.slideToggle(180);
        $icon.toggleClass('fa-chevron-up fa-chevron-down');
    });

    // Botón Marcar Todos Global
    $('#btn_select_all_global').on('click', function() {
        $('.permission-module-card input[type="checkbox"]').prop('checked', true);
        $('.permission-item-card').each(function() {
            updateCardState($(this));
        });
        updateAllCounts();
    });

    // Botón Desmarcar Todos Global
    $('#btn_deselect_all_global').on('click', function() {
        $('.permission-module-card input[type="checkbox"]').prop('checked', false);
        $('.permission-item-card').each(function() {
            updateCardState($(this));
        });
        updateAllCounts();
    });

    // Expandir / Colapsar todos
    var allExpanded = true;
    $('#btn_toggle_expand_all').on('click', function() {
        if (allExpanded) {
            $('.permission-module-body').slideUp(180);
            $('.toggle-collapse-icon').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            allExpanded = false;
        } else {
            $('.permission-module-body').slideDown(180);
            $('.toggle-collapse-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            allExpanded = true;
        }
    });

    // Buscador en tiempo real
    $('#permission_search_input').on('keyup input', function() {
        var query = $(this).val().toLowerCase().trim();

        if (query === '') {
            $('.permission-module-card').show();
            $('.permission-item-card').show();
            $('.permission-subgroup-title').show();
            $('.permission-module-body').show();
            $('.toggle-collapse-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            allExpanded = true;
            return;
        }

        $('.permission-module-card').each(function() {
            var $module = $(this);
            var moduleKeywords = ($module.attr('data-module') || '') + ' ' + $module.find('.permission-module-name').text().toLowerCase();
            var moduleMatches = moduleKeywords.indexOf(query) !== -1;

            var matchingCardsCount = 0;
            $module.find('.permission-item-card').each(function() {
                var $card = $(this);
                var cardText = $card.text().toLowerCase();
                if (cardText.indexOf(query) !== -1 || moduleMatches) {
                    $card.show();
                    matchingCardsCount++;
                } else {
                    $card.hide();
                }
            });

            if (matchingCardsCount > 0) {
                $module.show();
                $module.find('.permission-module-body').show();
                $module.find('.toggle-collapse-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            } else {
                $module.hide();
            }
        });
    });

    // Inicialización inicial
    $('.permission-item-card').each(function() {
        updateCardState($(this));
    });
    updateAllCounts();
});
</script>
