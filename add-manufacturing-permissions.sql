-- Agregar permisos del módulo Manufacturing
-- Ejecutar en la base de datos de producción

-- Insertar permisos
INSERT INTO permissions (name, guard_name, created_at, updated_at) VALUES
('manufacturing.view', 'web', NOW(), NOW()),
('manufacturing.create', 'web', NOW(), NOW()),
('manufacturing.edit', 'web', NOW(), NOW()),
('manufacturing.delete', 'web', NOW(), NOW());

-- Asignar permisos al rol de Admin (role_id = 1)
-- Si tu rol de admin tiene otro ID, ajusta el número
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT id, 1 FROM permissions WHERE name LIKE 'manufacturing.%';

-- Verificar que se crearon correctamente
SELECT * FROM permissions WHERE name LIKE 'manufacturing.%';
