<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => [
        config('backpack.base.web_middleware', 'web'),
        config('backpack.base.middleware_key', 'admin'),
    ],
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

    Route::crud('user', 'UserCrudController');
    Route::crud('company', 'CompanyCrudController');
    Route::crud('member', 'MemberCrudController');
    Route::crud('role', 'RoleCrudController');
    Route::crud('projects', 'ProjectCrudController');
    Route::crud('systems', 'SystemCrudController');
    Route::crud('subfunctions', 'SubFunctionCrudController');
    Route::crud('requirements', 'RequirementCrudController');

    /* add system */
    Route::crud('/project/{projectId}/systems', 'SystemProjectController');

    /* store project-system */
    Route::post('/api/project/systems/{systemId}', 'SystemProjectController@requestHandle');

    /* add requirement */
    Route::crud('/project/{projectId}/systems/requirements', 'RequirementSystemController');

    /* store project-requirement */
    Route::post('/api/project/systems/requirements/{requirementId}', 'RequirementSystemController@requestHandle');

    /* add subFunction */
    Route::crud('project/{projectId}/systems/requirements/subfunctions', 'SubFunctionProjectController');

    /* store project-subFunction */
    Route::post('api/project/systems/requirements/subfunctions/{subFunctionId}', 'SubFunctionProjectController@storeSubFunction');

    /* Final View */
    Route::get('project/{projectId}/final', 'ProjectDetailController@finalIndex')->name('final');

    /*view project detail*/
    Route::crud('project/{projectId}/detail', 'ProjectDetailController');

    /*edit system*/
    Route::put('/api/project/system/{systemId}', 'ProjectDetailController@updateSystem');

    /*edit requirement*/
    Route::put('/api/project/requirement/{requirementId}', 'ProjectDetailController@updateRequirement');

    /*edit sub function*/
    Route::put('/api/project/subFunction/{subFunctionId}', 'ProjectDetailController@updateSubFunction');

}); // this should be the absolute last line of this file