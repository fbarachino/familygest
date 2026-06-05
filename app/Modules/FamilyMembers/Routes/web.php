<?php

use App\Modules\FamilyMembers\Controllers\FamilyMemberController;
use Illuminate\Support\Facades\Route;

Route::resource('family-members', FamilyMemberController::class)
    ->names('family-members');
