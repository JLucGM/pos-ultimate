$permissions = ['consultorio.view', 'consultorio.create', 'consultorio.edit', 'consultorio.delete'];
foreach ($permissions as $p) { \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']); echo "✅ Permiso: $p\n"; }
$admin = \Spatie\Permission\Models\Role::where('name', 'like', 'Admin#%')->first();
if ($admin) { $admin->givePermissionTo($permissions); echo "✅ Asignados al rol: {$admin->name}\n"; } else { echo "⚠️ Rol Admin no encontrado\n"; }
echo "✅ COMPLETADO\n";
exit
