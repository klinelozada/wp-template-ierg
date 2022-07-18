<?php
/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/

//  tr_route()->get()->on('/calendar', function() {
//    // Will return... Hi, {url_segment}
//    return tr_view('calendar.index');
//  });


//  use App\Models\Company;

  tr_route()->get()->on('/companies', function() {
    $company = new \App\Models\Company();
    $companies = $company->findAll()->published()->get();
    return tr_view('companies.index', ['companies' => $companies, 'topbar' => 'Member Directory']);
  });

  tr_route()->get()->on('/companies/*', function($id) {
    $company = new \App\Models\Company();
    $company->findFirstWhereOrDie('id', $id);
    return tr_view('companies.view', ['company' => $company, 'topbar' => 'Member Directory']);
  });

  tr_route()->get()->on('/members', function() {


    $user = new \App\Models\User();
    $members = $user->findAll()->get();
    //$members = get_users();
    return tr_view('members.index', ['members' => $members, 'topbar' => 'Member Directory']);
  });

  tr_route()->get()->on('/members/*', function($id) {
    $member = get_user_by('id', $id);
    return tr_view('members.view', ['member' => $member, 'topbar' => 'Member Directory']);

//    $company = new \App\Models\Company();
//    $company->findFirstWhereOrDie('id', $id);
//    return tr_view('companies.view', ['company' => $company]);
  });

  tr_route()->get()->on('/profile/', function() {
    tr_frontend_enable();
    return tr_view('members.profile', ['topbar' => 'My Profile']);
  });