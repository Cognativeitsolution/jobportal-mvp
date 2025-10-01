<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Employer\Auth')->middleware(['guest:employer'])->group(function () {
    Route::controller('LoginController')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('logout', 'logout')->withoutMiddleware(['guest:employer'])->name('logout');
    });

    Route::controller('RegisterController')->middleware(['guest:employer'])->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register');
        Route::post('check-mail', 'checkEmployer')->name('checkEmployer')->withoutMiddleware('guest:employer');
    });

    Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function () {
        Route::get('reset', 'showLinkRequestForm')->name('request');
        Route::post('email', 'sendResetCodeEmail')->name('email');
        Route::get('code-verify', 'codeVerify')->name('code.verify');
        Route::post('verify-code', 'verifyCode')->name('verify.code');
    });

    Route::controller('ResetPasswordController')->group(function () {
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });

    Route::controller('SocialiteController')->group(function () {
        Route::get('social-login/{provider}', 'socialLogin')->name('social.login');
        Route::get('social-login/callback/{provider}', 'callback')->name('social.login.callback');
    });
});

Route::middleware('employer')->group(function () {
    Route::get('user-data', 'Employer\EmployerController@userData')->name('data');
    Route::post('user-data-submit', 'Employer\EmployerController@userDataSubmit')->name('data.submit');

    Route::namespace('Employer')->middleware('registration.complete:employer')->controller('AuthorizationController')->group(function () {
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'emailVerification')->name('verify.email');
        Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify-g2fa', 'g2faVerification')->name('go2fa.verify');
    });

    Route::middleware(['check.status:employer', 'registration.complete:employer'])->namespace('Employer')->group(function () {
        Route::controller('EmployerController')->group(function () {
            Route::get('dashboard', 'home')->name('home');
            Route::get('visitor-chart', 'visitorChart')->name('chart.visitor');

            //2FA
            Route::get('twofactor', 'show2faForm')->name('twofactor');
            Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
            Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

            //Report
            Route::any('payment/history', 'depositHistory')->name('deposit.history');
            Route::get('transactions', 'transactions')->name('transactions');

            Route::get('attachment-download/{fil_hash}', 'attachmentDownload')->name('attachment.download');
            Route::get('view/resume', 'pdfViewer')->name('pdf.view');
            Route::post('upload/cv', 'uploadCv')->name('upload.cv');

            //Job Apply
            Route::post('apply/job', 'applyJob')->name('job.apply');
            Route::get('job/application/list', 'jobApplication')->name('job.application.list');

            //favorite Apply
            Route::get('favorite/item/{id}', 'favoriteItem')->name('favorite.item');
            Route::get('favorite/job/list', 'favoriteJob')->name('favorite.job.list');
            Route::post('favorite/job/delete/{id}', 'favoriteJobDelete')->name('favorite.job.delete');

            Route::post('add-device-token', 'addDeviceToken')->name('add.device.token');
            Route::get('cv/download/{id}', 'cvDownload')->name('cv.download');
            Route::get('applications', 'applications')->name('applications.list');
            Route::get('applicant-details/{id}', 'applicantDetails')->name('load.applicant.profile');
        });

        //Profile setting
        Route::controller('ProfileController')->group(function () {
            Route::get('profile-setting', 'profile')->name('profile.setting');
            Route::get('profile/check/slug', 'checkSlug')->name('profile.check.slug');
            Route::post('profile-setting', 'submitProfile')->name('profile.submit');
            Route::get('change-password', 'changePassword')->name('change.password');
            Route::post('change-password', 'submitPassword');
            Route::post('update/image', 'updateImage')->name('update.image');
        });

        Route::controller('PlanController')->name('plan.')->prefix('plan')->group(function () {
            Route::get('', 'index')->name('index');
        });

        Route::controller("JobController")->name('job.')->prefix('job')->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('create/{step?}/{slug?}/{jobId?}/{edit?}', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('store/{id?}', 'store')->name('store');

            Route::post('basic/{id?}', 'basic')->name('basic');
            Route::post('information/{id?}', 'information')->name('information');
            Route::post('details/{id?}', 'details')->name('details');

            Route::name('applicants.')->group(function () {
                Route::get('applicants/{id}/{userId?}', 'allApplicants')->name('all');
                Route::get('selected-applicants/{id}', 'selectedApplicants')->name('selected');
                Route::get('draft-applicants/{id}', 'draftApplicants')->name('draft');
                Route::get('applicant-details/{id}/{applicationId}', 'applicantDetails')->name('profile');
            });

            Route::post('application-approve/{id}', 'applicationApprove')->name('application.approve');
            Route::post('application-draft/{id}', 'applicationDraft')->name('application.draft');
            Route::get('export/{id}/{scope?}', 'exportJobApplicant')->name('export');
            Route::get('preview/{id}', 'jobPreview')->name('preview');
        });

        // Support Ticket
        Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
            Route::get('', 'supportTicket')->name('index');
            Route::get('new', 'openSupportTicket')->name('open');
            Route::post('create', 'storeSupportTicket')->name('store');
            Route::get('view/{ticket}', 'viewTicket')->name('view');
            Route::post('reply/{ticket}', 'replyTicket')->name('reply');
            Route::post('close/{ticket}', 'closeTicket')->name('close');
            Route::get('download/{ticket}', 'ticketDownload')->name('download');
        });
    });

    // Payment
    Route::middleware('registration.complete:employer')->prefix('payment')->name('deposit.')->controller('Gateway\PaymentController')->group(function () {
        Route::any('', 'deposit')->name('index');
        Route::post('insert/{id?}', 'depositInsert')->name('insert');
        Route::get('confirm', 'depositConfirm')->name('confirm');
        Route::get('manual', 'manualDepositConfirm')->name('manual.confirm');
        Route::post('manual', 'manualDepositUpdate')->name('manual.update');
    });
});
