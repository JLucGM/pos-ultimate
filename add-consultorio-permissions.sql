-- Agregar permisos del módulo Consultorio
-- Ejecutar después de las migraciones

-- Insertar permisos
INSERT INTO `permissions` (`name`, `guard_name`, `created_at`, `updated_at`) VALUES
('consultorio.view', 'web', NOW(), NOW()),
('consultorio.create', 'web', NOW(), NOW()),
('consultorio.edit', 'web', NOW(), NOW()),
('consultorio.delete', 'web', NOW(), NOW());

-- Asignar permisos al rol Admin (ajusta el role_id según tu base de datos)
-- Primero obtén el ID del rol Admin con: SELECT id, name FROM roles WHERE name LIKE 'Admin#%';
-- Luego reemplaza {ADMIN_ROLE_ID} con el ID correcto

-- INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) 
-- SELECT p.id, {ADMIN_ROLE_ID}
-- FROM permissions p
-- WHERE p.name IN ('consultorio.view', 'consultorio.create', 'consultorio.edit', 'consultorio.delete');
