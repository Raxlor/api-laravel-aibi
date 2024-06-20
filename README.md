<p align="center"><a href="https://dominicantechnology.com" target="_blank"><img src="https://iabi.dominicantechnology.com/images/PRESTASYSRas.png" width="400"></a></p>





# API Para gestionar entranadores y jugadores

Api creada para gestionar el crud de la aplicacion movil

## Requisitos

- PHP 8.1 o superior
- Laravel Framework 8.x

## Uso

### GET /trainer 

Recibe una lista en json de todos los usuarios registrador con el rol de `trainer`

### GET /trainer/{id} 

Recibe una lista en json de todos los usuarios registrador con el rol de `trainer` con filtrado por id
**Parámetros:**
- `id` (int, requerido): id del usuario debe ser `trainer`.
**Respuestas:**
- 200 OK: Envío exitoso. Retorna un objeto JSON con la siguiente estructura:
```json
{
  "Id": 2,
  "FirstName": "name",
  "LastName": "lastname",
  "BirthDay": "1990-01-01",
  "TeamId": 1,
  "UserName": "juanperez",
  "Email": "juanperez@exam2ple2.com",
  "PhoneNumber": "123456789",
  "Password": "$2y$10$W/L8Bx8DUHeRPQbY9mWkT.XcuTJhSYTWoqtBLwTcUPlqhn2MkG/me",
  "Update_at": "2024-06-19 23:19:32",
  "Created_at": "2024-06-19 21:10:40",
  "IsActive": null,
  "Role": "trainer",
  "TrainerId": 1
}
```
- 404 Not Found :
    ```json
        {
          "message":"Trainer no encontrado"
        }
    ```
 ### GET /player 

Recibe una lista en json de todos los usuarios registrador con el rol de `player`

### GET /players/{id} 

Recibe una lista en json de todos los usuarios registrador con el rol de `player` con filtrado por id
**Parámetros:**
- `id` (int, requerido): id del usuario debe ser `player`.
**Respuestas:**
- 200 OK: Envío exitoso. Retorna un objeto JSON con la siguiente estructura:
```json
{
  "Id": 2,
  "FirstName": "name",
  "LastName": "lastname",
  "BirthDay": "1990-01-01",
  "TeamId": 1,
  "UserName": "juanperez",
  "Email": "juanperez@exam2ple2.com",
  "PhoneNumber": "123456789",
  "Password": "$2y$10$W/L8Bx8DUHeRPQbY9mWkT.XcuTJhSYTWoqtBLwTcUPlqhn2MkG/me",
  "Update_at": "2024-06-19 23:19:32",
  "Created_at": "2024-06-19 21:10:40",
  "IsActive": null,
  "Role": "player",
  "TrainerId": 1
}
```
- 404 Not Found :
    ```json
        {
          "message":"Jugador no encontrado"
        }
    ```




  
## Rutas de API

| Ruta                | Método     | Descripción                       | Inputs Requeridos  | Tipo de Dato       | Longitud Máxima    | Autenticación      |
|---------------------|-------------|-----------------------------------|--------------------|--------------------|--------------------|--------------------|
| /user                | POST,PUT,DELET   | CRUD                     | "FirstName","LastName" ,"BirthDay", "TeamId" ,"UserName","Email","PhoneNumber","Password","Role","TrainerId"       | VARIABLE             | VARIABLE                | Bearer token      |
| /stadiums            | POST,PUT,DELET   | CRUD       | "Name", Location, isActive            | -                  | -                  | Bearer token      |




