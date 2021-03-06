<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use \App\User;


//routes pour l'export des données en excel




Route::get('/', function(){
    return redirect()->route(session('dashboardUrl'));
})->middleware('auth')->name('home');

Route::name('admin.')->group(function(){

    Route::get('admin/dashboard', 'admin\DashboardController@home')->name('dash');


    Route::get('admin/visites/medicals', 'admin\VisiteController@index_med')->name('visitemed');
    Route::get('admin/visites/medicals/show/{id}', 'admin\VisiteController@show_visite_med')->name('visitemed_show');
    Route::get('admin/visites/medicals/results', 'admin\VisiteController@visitesMed')->name('visitemed_results');

    Route::get('admin/visites/pharma', 'admin\VisiteController@index_ph')->name('visiteph');
    Route::get('admin/visites/pharma/show/{id}', 'admin\VisiteController@show_visite_ph')->name('visiteph_show');
    Route::get('admin/visites/pharma/results', 'admin\VisiteController@visitesPh')->name('visiteph_results');
    Route::resource('admin/medecins','admin\MedecinController');
    Route::resource('admin/pharmacies','admin\PharmacieController');
    Route::resource('admin/bc', 'admin\BcController');

    Route::resource('admin/users', 'UserController');
    Route::put('admin/users/{user_id}/password', 'UserController@changePassword')->name('change-password');
    Route::resource('admin/products', 'admin\ProduitController');
    Route::resource('admin/gammes', 'admin\GammeController');
    Route::resource('admin/villes', 'admin\VilleController');
    Route::resource('admin/secteurs', 'admin\SecteurController');
    Route::resource('admin/specialites', 'admin\SpecialiteController');

    Route::resource('admin/feedbacks', 'admin\FeedbackController');

    /** Product Specialist Dash **/

    Route::get('admin/dash/visites/delegues','admin\DashboardController@visiteByDelegue');
    Route::get('admin/dash/visites/villes','admin\DashboardController@visiteByVilles');
    Route::get('admin/dash/visites/specialities','admin\DashboardController@visiteBySpec');

});

/* Product specialist routes */
Route::get('/dashboard', 'HomeController@home')->name('ps.dash');

Route::resource('bcs', 'BcController');

Route::resource('medecins','MedecinController');
Route::get('/searchmedecins','MedecinController@search_medecin')->name('searchmed');

Route::resource('phvisites','VisitePharmacieController');
Route::get('/searchpharma','PharmacieController@search_pharma')->name('searchph');
Route::resource('pharmacies','PharmacieController');

Route::resource('medvisites','VisiteMedicalController');
Route::get('medecins/visites/validation','VisiteMedicalController@validation_index')->name('medvisites.validation');
Route::post('medecins/visites/validation/{id}','VisiteMedicalController@validation_update')->name('medvisites.validation.update');


/*************************************************/


/*  Authentification Route */
Auth::routes();


/** Product Specialist Dash **/

Route::get('dash/visites/specialites','HomeController@visiteBySpecialite');

Route::get('dash/visites/ville','HomeController@visiteByVille');

/*  Import Excel File Route Rapport Med */

Route::post('/import_rapportMed','RapportMedController@import')->name('import_rapportMed');
Route::get('/file_import_rapportMed','RapportMedController@index')->name('file_import_rapportMed');
Route::get('/show_rapport_med','RapportMedController@show')->name('show_rapport_med');
Route::get('/dataRapportMed', 'RapportMedController@getRapportMed')->name('dataRapportMed');
Route::get('/export_rapport_med', 'RapportMedController@export')->name('export_rapport_med');

/*  Import Excel File Route Rapport Ph */

Route::post('/import_rapportPh','RapportPhController@import')->name('import_rapportPh');
Route::get('/file_import_rapportPh','RapportPhController@index')->name('file_import_rapportPh');
Route::get('/show_rapport_ph','RapportPhController@show')->name('show_rapport_ph');
Route::get('/dataRapportPh', 'RapportPhController@getRapportPh')->name('dataRapportPh');
Route::get('/export_rapport_ph', 'RapportPhController@export')->name('export_rapport_ph');
