<?php

use App\Models\User;
use App\Models\CallUser;
use Spatie\Permission\Models\Role;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('dashboard'));
});

// Home > Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Dashboard', route('dashboard'));
});

// Home > Dashboard > User Management
Breadcrumbs::for('user-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('User Management', route('user-management.users.index'));
});

// Home > Dashboard > User Management > Users
Breadcrumbs::for('user-management.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Company Users', route('user-management.users.index'));
});

// Home > Dashboard > User Management > Users > [User]
Breadcrumbs::for('user-management.users.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('user-management.users.index');
    $trail->push(ucwords($user->name), route('user-management.users.show', $user));
});

// Home > Dashboard > User Management > Call Users
Breadcrumbs::for('user-management.call-users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Call Users', route('user-management.call-users.index'));
});
// Home > Dashboard > User Management > Call Users > [User]
Breadcrumbs::for('user-management.call-users.show', function (BreadcrumbTrail $trail, CallUser $call_user) {
    $trail->parent('user-management.call-users.index');
    $trail->push(ucwords($call_user->name), route('user-management.call-users.show',$call_user ));
});

// Home > Dashboard > User Management > Roles
Breadcrumbs::for('user-management.roles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Roles', route('user-management.roles.index'));
});

// Home > Dashboard > User Management > Roles > [Role]
Breadcrumbs::for('user-management.roles.show', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('user-management.roles.index');
    $trail->push(ucwords($role->name), route('user-management.roles.show', $role));
});

// Home > Dashboard > User Management > Permission
Breadcrumbs::for('user-management.permissions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Permissions', route('user-management.permissions.index'));
});
// Home > Dashboard > Data Management 
Breadcrumbs::for('DataManagementMain', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Management', route('call-insights.f-audiocalls.index'));
});

// Home > Dashboard > User Management > Users
Breadcrumbs::for('f-audiocalls.create', function (BreadcrumbTrail $trail) {
    $trail->parent('DataManagementMain'); //add link of view
    $trail->push('Insert Record', route('call-insights.f-audiocalls.create'));
});
Breadcrumbs::for('f-audiocalls.index', function (BreadcrumbTrail $trail) {
    $trail->parent('DataManagementMain'); //add link of view
    $trail->push('View Record', route('call-insights.f-audiocalls.index'));
});
