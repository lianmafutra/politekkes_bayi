<?php

use App\Http\Controllers\API\BalitaController;
use App\Http\Controllers\API\JawabanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;

use App\Http\Controllers\API\PerkembanganController;
use App\Http\Controllers\API\RekapController;
use App\Http\Controllers\API\SliderController;

use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/debug-sentry', function () {
//     throw new Exception('My first Sentry error 1!');
// });

Route::prefix('user')->group(function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);   
    Route::post('password/reset', [UserController::class, 'resetPassword']);      
});

// Route::get('/foo', function () {
//     Artisan::call('storage:link');
// });

Route::post('/token-check', [UserController::class, 'login'])->name('login');
Route::get('rekap/harian/{tgl}', [RekapController::class, 'getRekapHari']);   
  
Route::middleware('auth:api')->group( function () {
   
    Route::prefix('user')->group(function () {
       
        Route::prefix('password')->group(function () {
            Route::post('ubah', [UserController::class, 'ubahPassword']);    
            
        });

        Route::prefix('jawaban')->group(function () {
            Route::post('kirim', [JawabanController::class, 'kirimJawaban']); 
            Route::get('histori', [JawabanController::class, 'getHistoriJawabanByUser']);
            Route::get('histori/admin', [JawabanController::class, 'getHistoriJawabanByAdmin']); 
            Route::get('histori/detail/{id}', [JawabanController::class, 'getHistoriJawabanDetail']);  
          
        });

        Route::post('logout', [UserController::class, 'logout']);
       
    });


    Route::prefix('balita')->group(function () {
        Route::get('umur/{tgl_lahir}', [BalitaController::class, 'getUmurBalita']);
        Route::post('pertumbuhan', [BalitaController::class, 'getPertumbuhan']);
       
        Route::get('perkembangan/{tgl_lahir}', [PerkembanganController::class, 'getPertanyaan']);
        Route::post('perkembangan/hasil', [PerkembanganController::class, 'getHasilPerkembangan']);
    });

   
    Route::get('sliders', [SliderController::class, 'index']);

    
});

