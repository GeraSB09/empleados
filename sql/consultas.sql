/* 1. Cuantos empleados tiene el departamento de: xxxx */
CREATE VIEW num_empleados_depto AS
SELECT COUNT(empleado.nombre)
FROM empleados, puesto, departamento
WHERE empleados.fk_puesto = puesto.pk_puesto 
AND puesto.fk_departamento = departamento.pk_departamento

/* 2. Mostrar el jefe de determinado departamento */
/* 3. ¿Quiwnres son los gerentes de departamento? */
/* 4. ¿Cuántos empleados hay en cada departamento? */
/* 5. ¿Cuántos empleados hay en cada genero? */
/* 6. Mostrar un listado de los empleados de departamento xxxx con sus respectivos salarios */
/* 7. Mostrar un listado general de todos los empleados ordenados por mayor antiguedad */
