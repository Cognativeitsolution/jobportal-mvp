<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::get('cron', 'CronController@cron')->name('cron');

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{id}', 'replyTicket')->name('reply');
    Route::post('close/{id}', 'closeTicket')->name('close');
    Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
});

Route::controller('CompanyController')->group(function () {
    Route::get('company/job/{slug}', 'companyJobs')->name('company.jobs');
    Route::get('companies', 'companyList')->name('company.list');
    Route::get('companies/industry-type/{industryId}', 'companyIndustryTypeList')->name('company.list.industry');
    Route::get('companies/location/{city?}', 'companyLocationList')->name('company.list.location');
    Route::get('company/profile/{slug}', 'companyProfile')->name('company.profile');
    Route::get('featured/companies/{id?}', 'featuredCompanies')->name('featured.companies');
    Route::post('contact/with/company/{id}', 'contactWithCompany')->name('contact.with.company');
});

Route::controller('JobController')->group(function () {
    Route::get('/jobs', 'jobs')->name('job');
    Route::get('featured-jobs', 'featuredJobsList')->name('featured.jobs.list');
    Route::post('job-filter', 'jobFilter')->name('job.filter');
    Route::get('job/role/{id?}', 'jobRole')->name('job.role');
    Route::get('job/keyword/{keyword?}', 'jobKeyword')->name('job.keyword');
    Route::get('job-detail/{id}', 'jobDetails')->name('job.details');
    Route::get('category/hot-jobs/{id?}', 'categoryHotJobs')->name('category.hot.jobs');
    Route::get('featured/jobs/{id?}', 'featuredJobs')->name('featured.jobs');
    Route::get('job/category/{id?}', 'jobCategory')->name('job.category');
});

Route::controller('CandidateController')->group(function () {
    Route::get('candidate-profile/{id?}', 'candidateProfile')->name('candidate.profile');
    Route::get('resume-download/{id?}', 'resumeDownload')->name('resume.download');
});

Route::controller('SiteController')->group(function () {
    Route::post('/subscribe', 'addSubscriber')->name('subscribe');
    Route::get('categories', 'categories')->name('categories');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit')->name('contact.submit');
    Route::get('blog', 'blog')->name('blog');
    Route::get('blog/{slug}', 'blogDetails')->name('blog.details');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');
    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');
    Route::get('policy/{slug}', 'policyPages')->name('policy.pages');
    Route::get('placeholder-image/{size}', 'placeholderImage')->withoutMiddleware('maintenance')->name('placeholder.image');
    Route::get('maintenance-mode', 'maintenance')->withoutMiddleware('maintenance')->name('maintenance');
    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});
