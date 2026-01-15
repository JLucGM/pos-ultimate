# 🛡️ Guía Segura: Git y Deployment del Módulo Manufacturing

## 📋 Tabla de Contenidos
1. [Verificación Inicial](#verificación-inicial)
2. [Guardar en Git (Local)](#guardar-en-git-local)
3. [Trabajar en Equipo](#trabajar-en-equipo)
4. [Deployment a Producción](#deployment-a-producción)
5. [Rollback en Caso de Problemas](#rollback-en-caso-de-problemas)
6. [Checklist de Seguridad](#checklist-de-seguridad)

---

## 1️⃣ Verificación Inicial

### Antes de hacer CUALQUIER cosa, verifica:

```bash
# 1. Verifica que estás en la rama correcta
git branch
# Debe mostrar: * main (o la rama que uses)

# 2. Verifica que no tienes cambios sin guardar importantes
git status
# Revisa la lista de archivos modificados

# 3. Haz un backup de seguridad
cp -r Modules/Manufacturing /tmp/Manufacturing_backup_$(date +%Y%m%d)
cp app/Http/Middleware/AdminSidebarMenu.php /tmp/AdminSidebarMenu_backup_$(date +%Y%m%d).php
```

**✅ REGLA DE ORO:** Siempre haz backup antes de hacer cambios importantes.

---

## 2️⃣ Guardar en Git (Local)

### Paso 1: Verificar Archivos Nuevos

```bash
# Ver todos los archivos nuevos y modificados
git status

# Deberías ver:
# - Modules/Manufacturing/ (nuevo directorio)
# - app/Http/Middleware/AdminSidebarMenu.php (modificado)
# - Varios archivos .md, .sh, .sql (nuevos)
```

### Paso 2: Revisar Cambios Importantes

```bash
# Ver QUÉ cambió en AdminSidebarMenu.php
git diff app/Http/Middleware/AdminSidebarMenu.php

# Deberías ver el bloque del menú Manufacturing agregado
# Si ves cambios extraños, DETENTE y revisa
```

### Paso 3: Agregar Archivos de Forma Segura

```bash
# Opción A: Agregar todo el módulo de una vez (RECOMENDADO)
git add Modules/Manufacturing/

# Opción B: Agregar archivo por archivo (MÁS SEGURO pero más lento)
git add Modules/Manufacturing/module.json
git add Modules/Manufacturing/composer.json
git add Modules/Manufacturing/Config/
git add Modules/Manufacturing/Database/
git add Modules/Manufacturing/Entities/
git add Modules/Manufacturing/Http/
git add Modules/Manufacturing/Providers/
git add Modules/Manufacturing/Resources/
git add Modules/Manufacturing/Routes/

# Agregar archivo modificado del sistema
git add app/Http/Middleware/AdminSidebarMenu.php

# Agregar documentación (OPCIONAL pero recomendado)
git add PLAN_MODULO_MANUFACTURA.md
git add INSTALACION_MODULO_MANUFACTURING.md
git add MODULO_MANUFACTURING_COMPLETADO.md
git add DEPLOYMENT_MANUFACTURING_EXITOSO.md
git add ARCHIVOS_MODULO_MANUFACTURING.md
git add GUIA_SEGURA_GIT_MANUFACTURING.md
git add deploy-manufacturing.sh
git add add-manufacturing-permissions.sql
```

### Paso 4: Verificar Antes de Commit

```bash
# Ver qué archivos están staged (listos para commit)
git status

# Deberías ver en verde:
# - Modules/Manufacturing/
# - app/Http/Middleware/AdminSidebarMenu.php
# - Archivos de documentación

# ⚠️ SI VES ALGO RARO, puedes quitar archivos con:
git reset HEAD <archivo-que-no-quieres>
```

### Paso 5: Hacer Commit

```bash
# Commit con mensaje descriptivo
git commit -m "feat: Agregar módulo Manufacturing completo

- Sistema de recetas (BOM) con ingredientes
- Órdenes de producción con control de inventario
- 3 tablas: mfg_recipes, mfg_recipe_ingredients, mfg_production_orders
- CRUD completo de recetas
- Integración con inventario multimoneda
- Menú agregado al sidebar
- Permisos: manufacturing.view, create, edit, delete
- Documentación y scripts de deployment incluidos

Archivos modificados:
- app/Http/Middleware/AdminSidebarMenu.php (agregado menú Manufacturing)

Archivos nuevos:
- Modules/Manufacturing/ (módulo completo)
- Documentación y scripts de deployment"
```

### Paso 6: Verificar el Commit

```bash
# Ver el último commit
git log -1

# Ver los archivos incluidos en el commit
git show --name-only

# Si todo se ve bien, continúa al siguiente paso
```

### Paso 7: Push al Repositorio (CON CUIDADO)

```bash
# ANTES de hacer push, verifica:
# 1. ¿Estás en la rama correcta?
git branch

# 2. ¿Hay cambios en el remoto que no tienes?
git fetch
git status

# Si dice "Your branch is behind", haz pull primero:
git pull origin main

# 3. Si hay conflictos, resuélvelos ANTES de continuar

# 4. Cuando todo esté limpio, haz push:
git push origin main

# 5. Verifica en GitHub/GitLab que los archivos se subieron
```

---

## 3️⃣ Trabajar en Equipo

### ⚠️ ARCHIVO CRÍTICO: AdminSidebarMenu.php

Este archivo fue modificado y puede causar conflictos si alguien más lo modifica.

### Antes de Modificar AdminSidebarMenu.php:

```bash
# 1. Siempre haz pull primero
git pull origin main

# 2. Si hay conflictos en AdminSidebarMenu.php:
git status
# Verás: "both modified: app/Http/Middleware/AdminSidebarMenu.php"

# 3. Abre el archivo y busca los marcadores de conflicto:
# <<<<<<< HEAD
# Tu código
# =======
# Código del otro desarrollador
# >>>>>>> branch-name

# 4. Resuelve manualmente:
# - Mantén AMBOS cambios si son independientes
# - El menú Manufacturing debe estar ANTES del cierre de Menu::create
# - Busca la línea: });  (cierre de Menu::create)
# - El menú Manufacturing debe estar ANTES de esa línea
```

### Comunicación con el Equipo:

```
📢 AVISO AL EQUIPO:

He modificado el archivo app/Http/Middleware/AdminSidebarMenu.php
para agregar el menú del módulo Manufacturing.

Por favor:
1. Hagan git pull antes de modificar ese archivo
2. Si necesitan agregar menús, coordinen conmigo
3. El menú Manufacturing está en las líneas ~893-915

Gracias!
```

---

## 4️⃣ Deployment a Producción

### Opción A: Desde Repositorio Git (RECOMENDADO)

```bash
# 1. Conectar al servidor
ssh root@audaz.site

# 2. Ir al directorio del proyecto
cd /home/audaz.site/public_html

# 3. Hacer backup ANTES de pull
cp -r Modules /tmp/Modules_backup_$(date +%Y%m%d_%H%M%S)
cp app/Http/Middleware/AdminSidebarMenu.php /tmp/AdminSidebarMenu_backup_$(date +%Y%m%d_%H%M%S).php

# 4. Hacer pull del repositorio
git pull origin main

# 5. Si hay conflictos, resuélvelos
# Si no sabes cómo, usa el backup para restaurar

# 6. Regenerar autoload
composer dump-autoload

# 7. Ejecutar migraciones (solo si es primera vez)
php artisan migrate --force

# 8. Limpiar caché
php artisan optimize:clear

# 9. Verificar permisos
chmod -R 777 storage bootstrap/cache

# 10. Probar el sitio
# Abre https://audaz.site/ en el navegador
```

### Opción B: Deployment Manual (SI GIT FALLA)

```bash
# Desde tu máquina local:

# 1. Subir módulo
scp -r Modules/Manufacturing root@audaz.site:/home/audaz.site/public_html/Modules/

# 2. Subir archivo modificado
scp app/Http/Middleware/AdminSidebarMenu.php root@audaz.site:/home/audaz.site/public_html/app/Http/Middleware/

# 3. Conectar al servidor y limpiar caché
ssh root@audaz.site "cd /home/audaz.site/public_html && php artisan optimize:clear && composer dump-autoload"
```

---

## 5️⃣ Rollback en Caso de Problemas

### Si algo sale mal en PRODUCCIÓN:

```bash
# 1. Conectar al servidor
ssh root@audaz.site
cd /home/audaz.site/public_html

# 2. Restaurar desde backup
cp -r /tmp/Modules_backup_[fecha]/* Modules/
cp /tmp/AdminSidebarMenu_backup_[fecha].php app/Http/Middleware/AdminSidebarMenu.php

# 3. Limpiar caché
php artisan optimize:clear

# 4. Verificar que el sitio funciona
```

### Si algo sale mal en GIT:

```bash
# Deshacer el último commit (SIN perder cambios)
git reset --soft HEAD~1

# Deshacer el último commit (PERDIENDO cambios) - ¡CUIDADO!
git reset --hard HEAD~1

# Deshacer cambios en un archivo específico
git checkout HEAD -- app/Http/Middleware/AdminSidebarMenu.php

# Ver el historial para volver a un commit anterior
git log
git checkout <commit-hash>
```

---

## 6️⃣ Checklist de Seguridad

### ✅ Antes de Hacer Commit:

- [ ] Hice backup de archivos importantes
- [ ] Verifiqué que estoy en la rama correcta
- [ ] Revisé los cambios con `git diff`
- [ ] Solo agregué archivos relacionados con Manufacturing
- [ ] El mensaje de commit es descriptivo
- [ ] No incluí archivos sensibles (.env, contraseñas, etc.)

### ✅ Antes de Hacer Push:

- [ ] Hice `git pull` para traer cambios remotos
- [ ] Resolví conflictos si los había
- [ ] Verifiqué el commit con `git log -1`
- [ ] Estoy seguro de que no romperé el código de otros
- [ ] Avisé al equipo sobre cambios en AdminSidebarMenu.php

### ✅ Antes de Deployment a Producción:

- [ ] Hice backup del servidor
- [ ] Probé los cambios en local
- [ ] El sitio funciona correctamente en local
- [ ] Tengo acceso SSH al servidor
- [ ] Sé cómo hacer rollback si algo falla
- [ ] Es un horario de bajo tráfico (opcional pero recomendado)

### ✅ Después de Deployment:

- [ ] El sitio carga correctamente
- [ ] El menú Manufacturing aparece
- [ ] Puedo crear recetas
- [ ] Puedo crear órdenes de producción
- [ ] No hay errores en los logs
- [ ] Otros módulos siguen funcionando

---

## 🚨 Errores Comunes y Soluciones

### Error: "Your branch is behind"
```bash
# Solución:
git pull origin main
# Luego resuelve conflictos si los hay
```

### Error: "Merge conflict in AdminSidebarMenu.php"
```bash
# Solución:
# 1. Abre el archivo
# 2. Busca <<<<<<< HEAD
# 3. Mantén ambos cambios si son independientes
# 4. Guarda el archivo
git add app/Http/Middleware/AdminSidebarMenu.php
git commit -m "fix: Resolver conflicto en AdminSidebarMenu"
```

### Error: "Permission denied" en servidor
```bash
# Solución:
ssh root@audaz.site
cd /home/audaz.site/public_html
chmod -R 777 storage bootstrap/cache
```

### Error: "Class not found" después de deployment
```bash
# Solución:
ssh root@audaz.site
cd /home/audaz.site/public_html
composer dump-autoload
php artisan optimize:clear
```

---

## 📞 En Caso de Emergencia

### Si el sitio se cae en producción:

1. **NO ENTRES EN PÁNICO** 🧘
2. Conecta al servidor: `ssh root@audaz.site`
3. Restaura el backup: `cp -r /tmp/Modules_backup_* Modules/`
4. Limpia caché: `php artisan optimize:clear`
5. Si sigue sin funcionar, contacta al equipo

### Si perdiste cambios en Git:

1. Revisa el reflog: `git reflog`
2. Encuentra el commit perdido
3. Restaura: `git checkout <commit-hash>`
4. Crea una nueva rama: `git checkout -b recovery`

---

## 🎯 Resumen de Comandos Seguros

```bash
# SIEMPRE SEGURO:
git status          # Ver estado
git diff            # Ver cambios
git log             # Ver historial
git branch          # Ver ramas

# SEGURO CON PRECAUCIÓN:
git add             # Agregar archivos
git commit          # Guardar cambios
git pull            # Traer cambios

# USAR CON CUIDADO:
git push            # Subir cambios
git reset           # Deshacer cambios
git checkout        # Cambiar de rama/commit

# PELIGROSO (solo si sabes lo que haces):
git reset --hard    # Perder cambios permanentemente
git push --force    # Sobrescribir historial remoto
```

---

## ✅ Conclusión

**Reglas de Oro:**
1. 🔒 Siempre haz backup antes de cambios importantes
2. 🔍 Verifica antes de hacer commit/push
3. 💬 Comunica cambios al equipo
4. 🧪 Prueba en local antes de producción
5. 📝 Documenta lo que haces
6. 🚨 Ten un plan de rollback

**Si sigues esta guía, minimizarás riesgos y podrás trabajar con confianza.**

---

**Creado:** 15 de Enero 2026  
**Para:** Módulo Manufacturing - AudazPOS
