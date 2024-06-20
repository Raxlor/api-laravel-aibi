<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Route::get('/', function () {
    
    return view('welcome');
});
   

/// trainers start get
route::get('trainer', function (Request $request) {
    $trainer = DB::table('users')->where('Role', 'trainer')->get();
    return response()->json($trainer, 200);
});
Route::get('trainer/{id}', function ($id) {
    $trainer = DB::table('users')->where('Role', 'trainer')->where('Id', $id)->first();

    if (!$trainer) {
        return response()->json(['message' => 'Trainer no encontrado'], 404);
    }
    return response()->json($trainer, 200);
});
/// trainers end get
/// players start get
route::get('players', function (Request $request) {
    $players = DB::table('users')->where('Role', 'player')->get();
    return response()->json($players, 200);
});
Route::get('players/{id}', function ($id) {
    $player = DB::table('users')->where('Role', 'player')->where('Id', $id)->first();

    if (!$player) {
        return response()->json(['message' => 'Jugador no encontrado'], 404);
    }
    return response()->json($player, 200);
});
/// players end get

Route::put('users/{id}', function (Request $request, $id) {
    // Validar los datos del formulario (puedes agregar validaciones según tus necesidades)
    $validator = Validator::make($request->all(), [
        'FirstName' => 'required|string|max:255',
        'LastName' => 'required|string|max:255',
        'BirthDay' => 'nullable|date',
        'TeamId' => 'nullable|integer',
        'UserName' => 'required|string|max:255',
        'Email' => 'required|email|max:255|unique:users,Email,' . $id,
        'PhoneNumber' => 'nullable|string|max:20',
        'Password' => 'nullable|string|max:255',
        'Role' => 'required|in:player',
        'TrainerId' => 'nullable|integer',
    ]);
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422); // Código de estado 422 para errores de validación
    }
    // Actualizar el jugador ('player or Traineer') usando DB::
    $affected = DB::table('users')
        ->where('Id', $id)
        ->update([
            'FirstName' => $request->FirstName,
            'LastName' => $request->LastName,
            'BirthDay' => $request->BirthDay,
            'TeamId' => $request->TeamId,
            'UserName' => $request->UserName,
            'Email' => $request->Email,
            'PhoneNumber' => $request->PhoneNumber,
            'Password' => bcrypt($request->Password), // Asegúrate de encriptar la contraseña si es necesario
            'Role' => $request->Role,
            'TrainerId' => $request->TrainerId,

        ]);
    if ($affected) {
        // Si se actualizó correctamente, devolver los datos actualizados del jugador
        $player = DB::table('users')->where('Id', $id)->first();
        return response()->json($player, 200);
    } else {
        // Si no se encontró el jugador o no se pudo actualizar, devolver un mensaje de error
        return response()->json(['message' => 'Jugador no encontrado o no se pudo actualizar'], 404);
    }
})->middleware('protected');

Route::post('users', function (Request $request) {
    // Validar los datos del formulario (puedes agregar validaciones según tus necesidades)

    $validator = Validator::make($request->all(), [
        'FirstName' => 'required|string|max:255',
        'LastName' => 'required|string|max:255',
        'BirthDay' => 'nullable|date',
        'TeamId' => 'nullable|integer',
        'UserName' => 'required|string|max:255',
        'Email' => 'required|email|max:255|unique:users',
        'PhoneNumber' => 'nullable|string|max:20',
        'Password' => 'required|string|max:255',
        'Role' => 'required|in:player',
        'TrainerId' => 'nullable|integer',
    ]);

    // Verificar si la validación falla
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422); // Código de estado 422 para errores de validación
    }

    // Insertar el nuevo jugador ('player') usando DB::
    $playerId = DB::table('users')->insert([
        'FirstName' => $request->FirstName,
        'LastName' => $request->LastName,
        'BirthDay' => $request->BirthDay,
        'TeamId' => $request->TeamId,
        'UserName' => $request->UserName,
        'Email' => $request->Email,
        'PhoneNumber' => $request->PhoneNumber,
        'Password' => bcrypt($request->Password), // Asegúrate de encriptar la contraseña
        'Role' => $request->Role,
        'TrainerId' => $request->TrainerId,

    ]);

    // Verificar si se insertó correctamente
    if ($playerId) {
        // Obtener los datos del jugador recién insertado
        $player = DB::table('users')->where('Id', $playerId)->first();
        return response()->json($player, 201); // Devolver respuesta JSON con código de estado 201 (Created)
    } else {
        return response()->json(['message' => 'No se pudo crear el jugador'], 500); // Error interno del servidor
    }
})->middleware('protected');


// Ruta para eliminar un jugador ('player') por su id
Route::delete('user/{id}', function ($id) {
    // Buscar y eliminar el jugador usando DB::
    $deleted = DB::table('users')
        ->where('Id', $id)
        ->delete();

    if ($deleted) {
        // Si se eliminó correctamente, devolver una respuesta con un mensaje
        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    } else {
        // Si no se encontró el jugador, devolver un mensaje de error
        return response()->json(['message' => 'Usuario no encontrado'], 404);
    }
})->middleware('protected');


/// fin crud usuarios
route::get('stadiums', function (Request $request) {
    $stadiums = DB::table('stadiums')->get();
    return response()->json($stadiums, 200);
});
route::get('stadiums/{id}', function ($id) {
    $stadiums = DB::table('stadiums')->where('Id', $id)->get();
    return response()->json($stadiums, 200);
});



Route::put('stadiums/{id}', function (Request $request, $id) {
    // Validar los datos del formulario
    $request->validate([
        'Name' => 'required|string|max:255',
        'Location' => 'required|string|max:255',
        'isActive' => 'required|boolean',
        // Puedes añadir más validaciones según tus necesidades
    ]);

    // Actualizar el estadio usando DB::
    $affected = DB::table('stadiums')
        ->where('Id', $id)
        ->update([
            'Name' => $request->Name,
            'Location' => $request->Location,
            'isActive' => $request->isActive,
            'Updated_at' => now(),
        ]);

    // Verificar si se actualizó correctamente
    if ($affected > 0) {
        // Obtener los datos del estadio actualizado
        $stadium = DB::table('stadiums')->where('Id', $id)->first();
        return response()->json($stadium, 200); // Devolver respuesta JSON con código de estado 200 (OK)
    } else {
        return response()->json(['message' => 'Estadio no encontrado o no se pudo actualizar'], 404); // No encontrado
    }
});

Route::post('stadiums', function (Request $request) {
    // Validar los datos del formulario
    $validator = Validator::make($request->all(), [
        'Name' => 'required|string|max:255',
        'Location' => 'required|string|max:255',
        'isActive' => 'required|boolean',
    ]);
    // Verificar si la validación falla
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422); // Código de estado 422 para errores de validación
    }
    // Insertar el nuevo estadio usando DB::
    $stadiumId = DB::table('stadiums')->insertGetId([
        'Name' => $request->Name,
        'Location' => $request->Location,
        'isActive' => $request->isActive,
        'Created_at' => now(),
        'Updated_at' => now(),
    ]);

    // Verificar si se insertó correctamente
    if ($stadiumId) {
        // Obtener los datos del estadio recién insertado
        $stadium = DB::table('stadiums')->where('Id', $stadiumId)->first();
        return response()->json($stadium, 201); // Devolver respuesta JSON con código de estado 201 (Created)
    } else {
        return response()->json(['message' => 'No se pudo crear el estadio'], 500); // Error interno del servidor
    }
})->middleware('protected');

Route::put('stadiums/{id}', function (Request $request, $id) {
    $validator = Validator::make($request->all(), [
        'Name' => 'required|string|max:255',
        'Location' => 'required|string|max:255',
        'isActive' => 'required|boolean',
    ]);

    // Verificar si la validación falla
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422); // Código de estado 422 para errores de validación
    }

    // Actualizar el estadio usando DB::
    $affected = DB::table('stadiums')
        ->where('Id', $id)
        ->update([
            'Name' => $request->Name,
            'Location' => $request->Location,
            'isActive' => $request->isActive,
            'Updated_at' => now(),
        ]);

    // Verificar si se actualizó correctamente
    if ($affected > 0) {
        // Obtener los datos del estadio actualizado
        $stadium = DB::table('stadiums')->where('Id', $id)->first();
        return response()->json($stadium, 200); // Devolver respuesta JSON con código de estado 200 (OK)
    } else {
        return response()->json(['message' => 'Estadio no encontrado o no se pudo actualizar'], 404); // No encontrado
    }
})->middleware('protected');


Route::delete('stadiums/{id}', function ($id) {
    // Buscar y eliminar el estadio usando DB::
    $deleted = DB::table('stadiums')
        ->where('Id', $id)
        ->delete();

    if ($deleted) {
        // Si se eliminó correctamente, devolver una respuesta con un mensaje
        return response()->json(['message' => 'Estadio eliminado correctamente'], 200);
    } else {
        // Si no se encontró el estadio, devolver un mensaje de error
        return response()->json(['message' => 'Estadio no encontrado'], 404);
    }
})->middleware('protected');
