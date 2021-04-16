<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->get('/room/(:num)', 'Room::index/$1');
$routes->get('/api-sessions/get-token/(:alphanum)', 'ApiSession::get_token/$1');
$routes->get('/api-sessions/create_tokens/(:num)', 'ApiSession::create_tokens/$1');
$routes->get('/api-sessions/get_users_score/', 'ApiSession::get_users_score');
$routes->post('/api-sessions/set_user_score/', 'ApiSession::set_user_score');

$routes->get('/api-sessions/get_user_state/', 'ApiSession::get_user_state');
$routes->post('/api-sessions/set_user_state/', 'ApiSession::set_user_state');

$routes->get('/api-sessions/get_current_game_data/', 'ApiSession::get_current_game_data');
$routes->post('/api-sessions/set_current_game_data/', 'ApiSession::set_current_game_data');


$routes->get('/api-sessions/get_teams_data/', 'ApiSession::get_teams_data');

$routes->get('/api-sessions/get_teams_name/', 'ApiSession::get_teams_name');
$routes->post('/api-sessions/update_user_team/', 'ApiSession::update_user_team');


// Admin Routes
$routes->get('/admin/room/(:num)', 'AdminRoom::index/$1');
$routes->get('/admin/teams/(:num)', 'AdminRoom::teams/$1');

$routes->get('/adminroom/ishost/', 'AdminRoom::isHost');
$routes->post('/adminroom/get_game_session_data/', 'AdminRoom::get_game_session_data');

$routes->get('/admin/dashboard/', 'AdminDashboard::index/$1');
$routes->get('/admin/dashboard/games', 'AdminDashboard::games');
$routes->get('/admin/dashboard/questions', 'AdminDashboard::questions');
$routes->get('/admin/dashboard/add_question', 'AdminDashboard::add_question');

$routes->get('/admin/dashboard/add_question', 'AdminDashboard::add_question');

// Jeopardy
$routes->get('/admin/dashboard/add_jeopardy', 'AdminDashboard::add_jeopardy');
$routes->get('/admin/dashboard/update_jeopard/(:num)', 'AdminDashboard::update_jeopardy/$1');

$routes->post('/admin/dashboard/add_jeopardy_form', 'AdminDashboard::add_jeopardy_form');
$routes->get('/admin/dashboard/get_category_questions/(:num)', 'AdminDashboard::get_category_questions/$1');

//// Categories
$routes->get('/admin/dashboard/add_category', 'AdminDashboard::add_category');
$routes->post('/admin/dashboard/add_category_form', 'AdminDashboard::add_category_form');

$routes->get('/admin/dashboard/delete_category/(:num)', 'AdminDashboard::delete_category/$1');

$routes->get('/admin/dashboard/update_category/(:num)', 'AdminDashboard::update_category/$1');
$routes->post('/admin/dashboard/update_category_form', 'AdminDashboard::update_category_form');
$routes->get('/admin/dashboard/test', 'AdminDashboard::test');

$routes->get('/admin/dashboard/categories', 'AdminDashboard::categories');
$routes->get('/admin/dashboard/category/(:num)', 'AdminDashboard::update_category/$1');


// End of Jeopardy

$routes->get('/admin/dashboard/update_question/(:num)', 'AdminDashboard::update_question/$1');

$routes->post('/admin/dashboard/questions/update/', 'AdminDashboard::update_question_form');
$routes->get('/admin/dashboard/questions/delete/(:num)', 'AdminDashboard::delete_question/$1');

$routes->post('/admin/dashboard/add_question', 'AdminDashboard::add_question_form');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
