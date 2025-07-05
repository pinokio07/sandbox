<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

//Main Routing
Route::get('/', [AuthController::class, 'index'])->name('login');// Welcome Page
Route::post('/', [AuthController::class, 'postlogin']);// Login

Route::middleware(['auth'])->group(function () {
  Route::get('/logout', [AuthController::class, 'logout'])->name('logout');//Logout
  Route::get('/profile', [AuthController::class, 'profile'])->name('profile');// Profile
  Route::get('/login-logs', [AuthController::class, 'logs'])
       ->name('get.login.logs');// Login Logs
  Route::get('/active-company', [AdminCompaniesUsersController::class, 'select'])
        ->name('active-company.select');// Select Active Compay
  Route::post('/active-company', [AdminCompaniesUsersController::class, 'set'])
        ->name('active-company.set');// Set Active Company
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');//Dashboard
  Route::get('/global-search', [DashboardController::class, 'search'])
       ->name('global.search');// Global Search
  //Select2 Branch
  Route::get('/select2/setup/admin/branch', [AdminCompaniesBranchesController::class, 'selectBranch'])
       ->name('select2.setup.admin.branch');

  //Super-Admin Routes
  Route::group(['middleware' => 'role:super-admin', 'as' => 'admin.'], function(){
    Route::get('/administrator', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/administrator/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/administrator/profile/{user}', [AuthController::class, 'update'])->name('profile.update');

    Route::get('/administrator/download', [AdminDownloadController::class, 'download'])
         ->name('download');
    Route::post('/administrator/upload', [AdminUploadController::class, 'upload'])
         ->name('upload');
    Route::get('/select2/administrator/companies/accounting', [AdminCompaniesController::class, 'select2accounting'])->name('select2.company.accounting');
    
    try {

      $menu = \App\Models\Menu::with(['parent_items' => function ($q) {
                                  $q->where('active', true)
                                    ->orderBy('order', 'asc');
                              }, 'parent_items.children' => function($c){
                                $c->where('active', true)
                                  ->orderBy('order', 'asc');
                              }])
                              ->where('name', 'admin')
                              ->first();
      if($menu){
        foreach($menu->parent_items as $main){
          $mainUrl = $main->link();
          $mainTitle = \Str::lower($main->title);
          //Get variable name for Route Binding
          $singular = ($main->var_name) 
                      ? $main->var_name 
                      : \Str::singular(\Str::replace(['-',' '],'_', $mainTitle));
          // Route Name
          $routeName = ($main->route) ? $main->route 
                                      : \Str::replace(' ', '_', $mainTitle);

          if($mainTitle != 'dashboard'){
            $ctNameSpace = 'App\\Http\\Controllers';
            $cekCtName = $main->controller ?? \Str::replace(' ', '', \Str::title($mainTitle));
            $ctName = $ctNameSpace.'\\'.$cekCtName;

            Route::get($mainUrl, [$ctName.'Controller'::class, 'index'])->name($routeName);
            Route::get($mainUrl.'/create', [$ctName.'Controller'::class, 'create'])->name($routeName.'.create');
            Route::post($mainUrl, [$ctName.'Controller'::class, 'store'])->name($routeName.'.store');
            Route::get($mainUrl.'/{'. $singular .'}', [$ctName.'Controller'::class, 'show'])->name($routeName.'.show');           
            Route::get($mainUrl.'/{'. $singular .'}/edit', [$ctName.'Controller'::class, 'edit'])->name($routeName.'.edit');
            Route::put($mainUrl.'/{'. $singular .'}', [$ctName.'Controller'::class, 'update'])->name($routeName.'.update');
            Route::delete($mainUrl.'/{'. $singular .'}', [$ctName.'Controller'::class, 'destroy'])->name($routeName.'.delete');
            
            if($mainTitle == 'users'){
              Route::get('/restore/{user}', [$ctName.'Controller'::class, 'restore'])->name('restore.user');
            }
            
            if($mainTitle == 'menus'){
              Route::get($mainUrl.'/{'. $singular .'}/builder', [AdminMenusBuilderController::class, 'index'])->name($routeName.'.builder');
              Route::post($mainUrl.'/{'. $singular .'}/builder', [AdminMenusBuilderController::class, 'store'])->name($routeName.'.builder.store');
              Route::put($mainUrl.'/{'. $singular .'}/builder/{id}', [AdminMenusBuilderController::class, 'update'])->name($routeName.'.builder.update');
              Route::delete($mainUrl.'/{'. $singular .'}/builder/{id}', [AdminMenusBuilderController::class, 'delete'])->name($routeName.'.builder.destroy');

              Route::post($mainUrl.'/order', [AdminMenusBuilderController::class, 'order_item'])->name($routeName.'.order');
            }
            
            if($mainTitle == 'companies'){
              Route::get($mainUrl .'/{'. $singular . '}/branches', [AdminCompaniesBranchesController::class, 'index'])
                   ->name($routeName.'.branches.index');
              Route::get($mainUrl .'/{'. $singular . '}/branches/create', [AdminCompaniesBranchesController::class, 'create'])
                   ->name($routeName.'.branches.create');
              Route::post($mainUrl.'/{'. $singular.'}/branches', [AdminCompaniesBranchesController::class, 'store'])
                   ->name($routeName.'.branches.store');
              Route::get($mainUrl.'/{'. $singular.'}/branches/{branch}', [AdminCompaniesBranchesController::class, 'show'])
                   ->name($routeName.'.branches.show');
              Route::get($mainUrl.'/{'. $singular.'}/branches/{branch}/edit', [AdminCompaniesBranchesController::class, 'edit'])
                   ->name($routeName.'.branches.edit');
              Route::put($mainUrl.'/{'. $singular.'}/branches/{branch}', [AdminCompaniesBranchesController::class, 'update'])
                   ->name($routeName.'.branches.update');
              Route::delete($mainUrl.'/{'. $singular.'}/branches/{branch}', [AdminCompaniesBranchesController::class, 'delete'])
                   ->name($routeName.'.branches.delete');              
            }
  
          }
        }
      }     
        
    } catch (\Throwable $th) {
      throw $th;
    }
  
  });
  //End Super-Admin Routes

  //Menu Routes
  try {
    
    $menus = \App\Models\MenuItem::where('menu_id', '<>', 1)
                                 ->where('active', true)
                                 ->orderBy('url', 'desc')
                                 ->get();

    if($menus){
      foreach($menus as $menu){
        $mainUrl = $menu->url; // Get menu url
        $mainTitle = \Str::lower($menu->title); // Get menu Title
        //Get variable name for Route Binding
        $singular = ($menu->var_name) 
                      ? $menu->var_name 
                      : \Str::singular(\Str::replace(['-',' '],'_', $mainTitle));
        // Get Route Name
        $routeName = \Str::replace('/','.',ltrim($mainUrl,'/')); // Route Name
        $permit = \Str::replace(['.', '-'], '_', $routeName); // Permissions
        // Get permission
        ($menu->permission != '' && $mainTitle != 'dashboard') 
              ? $middle = "can:$menu->permission" 
              : $middle = 'auth';        
        // If Main URL is not #
        if($mainUrl != '#' && $menu->controller != ''){
          $ctNameSpace = 'App\\Http\\Controllers';
          $cekCtName = $menu->controller; // Get Controller Name
          $ctName = $ctNameSpace.'\\'.$cekCtName;
          
          //Index Route
          Route::get($mainUrl, [$ctName.'Controller'::class, 'index'])
                ->name($routeName)
                ->middleware($middle);
          //Create Route
          Route::get($mainUrl.'/create', [$ctName.'Controller'::class, 'create'])
                ->name($routeName.'.create')
                ->middleware('can:create_'.$permit);
          //Store Route
          Route::post($mainUrl, [$ctName.'Controller'::class, 'store'])
                ->name($routeName.'.store')
                ->middleware('can:create_'.$permit);
          //Show Route
          Route::get($mainUrl.'/{'. $singular .'}', [$ctName.'Controller'::class, 'show'])
                ->name($routeName.'.show')
                ->middleware('can:view_'.$permit);
          //Edit Route
          Route::get($mainUrl.'/{'. $singular .'}/edit', [$ctName.'Controller'::class, 'edit'])
                ->name($routeName.'.edit')
                ->middleware('can:edit_'.$permit);
          //Update Route
          Route::put($mainUrl.'/{'. $singular .'}', [$ctName.'Controller'::class, 'update'])
                ->name($routeName.'.update')
                ->middleware('can:edit_'.$permit);
          //Destroy Route
          Route::delete($mainUrl.'/{'. $singular .'}', [$ctName.'Controller'::class, 'destroy'])
                ->name($routeName.'.delete')
                ->middleware('can:delete_'.$permit);
          //Select2 Route
          Route::get('/select2'.$mainUrl, [$ctName.'Controller'::class, 'select2'])
               ->name('select2.'.$routeName);
          //Download Route
          Route::get('/download'.$mainUrl, [$ctName.'Controller'::class, 'download'])
               ->name('download.'.$routeName);
          //Upload Route
          Route::post('/upload'.$mainUrl, [$ctName.'Controller'::class, 'upload'])
               ->name('upload.'.$routeName);

        } elseif($mainUrl != '#' && $menu->controller == ''){
          //Get index from folder (if exist)
          $page = getPage('pages.'.$mainTitle.'.index');

          Route::get($mainUrl, function() use ($page){
            return view($page);
          })->middleware($middle);

        }

      }
    }     
      
  } catch (\Throwable $th) {

    // throw $th;
    
  }
  //End Menu Routes  
});