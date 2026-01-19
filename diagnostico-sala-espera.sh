#!/bin/bash

echo "=========================================="
echo "DIAGNÓSTICO: Sala de Espera - Consultorio"
echo "=========================================="

echo ""
echo "1. Verificando citas del día actual..."
php artisan tinker --execute="
\$today = now()->startOfDay();
\$tomorrow = now()->addDay()->startOfDay();

echo 'Fecha actual: ' . now()->format('Y-m-d H:i:s') . PHP_EOL;
echo 'Rango de búsqueda: ' . \$today->format('Y-m-d H:i:s') . ' a ' . \$tomorrow->format('Y-m-d H:i:s') . PHP_EOL;
echo '---' . PHP_EOL;

\$appointments = DB::table('appointments')
    ->whereBetween('appointment_datetime', [\$today, \$tomorrow])
    ->get(['id', 'appointment_number', 'status', 'appointment_datetime', 'created_at']);

echo 'Total citas del día: ' . \$appointments->count() . PHP_EOL;
echo '---' . PHP_EOL;

foreach (\$appointments as \$apt) {
    echo 'ID: ' . \$apt->id . ' | Número: ' . \$apt->appointment_number . ' | Status: ' . \$apt->status . ' | Fecha Cita: ' . \$apt->appointment_datetime . PHP_EOL;
}
"

echo ""
echo "2. Verificando citas en estado 'waiting'..."
php artisan tinker --execute="
\$waiting = DB::table('appointments')
    ->where('status', 'waiting')
    ->get(['id', 'appointment_number', 'appointment_datetime', 'created_at']);

echo 'Total citas en espera: ' . \$waiting->count() . PHP_EOL;
echo '---' . PHP_EOL;

foreach (\$waiting as \$apt) {
    echo 'ID: ' . \$apt->id . ' | Número: ' . \$apt->appointment_number . ' | Fecha Cita: ' . \$apt->appointment_datetime . PHP_EOL;
}
"

echo ""
echo "3. Verificando todas las citas (últimas 10)..."
php artisan tinker --execute="
\$all = DB::table('appointments')
    ->orderBy('id', 'desc')
    ->limit(10)
    ->get(['id', 'appointment_number', 'status', 'appointment_datetime']);

echo 'Últimas 10 citas:' . PHP_EOL;
echo '---' . PHP_EOL;

foreach (\$all as \$apt) {
    echo 'ID: ' . \$apt->id . ' | Número: ' . \$apt->appointment_number . ' | Status: ' . \$apt->status . ' | Fecha: ' . \$apt->appointment_datetime . PHP_EOL;
}
"

echo ""
echo "=========================================="
echo "DIAGNÓSTICO COMPLETADO"
echo "=========================================="
echo ""
echo "ANÁLISIS:"
echo ""
echo "1. Si no hay citas del día actual, la cita puede estar programada para otro día"
echo "2. Si la cita está en 'waiting' pero no aparece en el día actual, verifica la fecha"
echo "3. La sala de espera solo muestra citas del día actual (desde 00:00 hasta 23:59)"
echo ""
echo "SOLUCIÓN:"
echo "- Si la cita está en otro día, cámbiala a hoy"
echo "- Si la cita está en 'reserved', cámbiala a 'waiting'"
echo "- Refresca la página de sala de espera"
echo ""
