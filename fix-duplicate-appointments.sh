#!/bin/bash

echo "=========================================="
echo "FIX: Duplicate Appointment Number"
echo "=========================================="

echo ""
echo "1. Verificando citas duplicadas..."
php artisan tinker --execute="
\$appointments = DB::table('appointments')
    ->where('appointment_number', 'LIKE', 'APT202601%')
    ->orderBy('id', 'desc')
    ->get(['id', 'appointment_number', 'status', 'appointment_datetime', 'created_at']);

echo 'Total citas encontradas: ' . \$appointments->count() . PHP_EOL;
echo '---' . PHP_EOL;

foreach (\$appointments as \$apt) {
    echo 'ID: ' . \$apt->id . ' | Número: ' . \$apt->appointment_number . ' | Status: ' . \$apt->status . ' | Fecha Cita: ' . \$apt->appointment_datetime . ' | Creada: ' . \$apt->created_at . PHP_EOL;
}
"

echo ""
echo "2. Eliminando cita duplicada APT2026010001..."
php artisan tinker --execute="
\$deleted = DB::table('appointments')
    ->where('appointment_number', 'APT2026010001')
    ->where('status', 'reserved')
    ->delete();
echo 'Citas eliminadas: ' . \$deleted . PHP_EOL;
"

echo ""
echo "3. Limpiando caché..."
php artisan cache:clear
php artisan config:clear

echo ""
echo "=========================================="
echo "✅ COMPLETADO"
echo "=========================================="
echo ""
echo "Ahora puedes intentar crear la cita nuevamente."
echo ""
