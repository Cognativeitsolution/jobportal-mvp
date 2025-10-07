<?php

use Illuminate\Support\Facades\Route;

Route::namespace('User\Auth')->name('user.')->middleware('guest')->group(function () {
    Route::controller('LoginController')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('logout', 'logout')->middleware('auth')->withoutMiddleware('guest')->name('logout');
    });

    Route::controller('RegisterController')->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register');
        Route::post('check-user', 'checkUser')->name('checkUser')->withoutMiddleware('guest');
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

Route::middleware('auth')->name('user.')->group(function () {
    Route::get('user-data', 'User\UserController@userData')->name('data');
    Route::post('user-data-submit', 'User\UserController@userDataSubmit')->name('data.submit');

    //authorization
    Route::middleware('registration.complete')->namespace('User')->controller('AuthorizationController')->group(function () {
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'emailVerification')->name('verify.email');
        Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify-g2fa', 'g2faVerification')->name('2fa.verify');
    });

    Route::middleware(['check.status', 'registration.complete'])->group(function () {
        Route::namespace('User')->group(function () {
            Route::controller('UserController')->group(function () {
                Route::get('dashboard', 'home')->name('home');
                Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');

                //2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                //Report
                Route::any('deposit/history', 'depositHistory')->name('deposit.history');
                Route::get('transactions', 'transactions')->name('transactions');

                Route::post('add-device-token', 'addDeviceToken')->name('add.device.token');

                Route::get('attachment-download/{fil_hash}', 'attachmentDownload')->name('attachment.download');

                //Job Apply
                Route::post('apply/job/{id}', 'applyJob')->name('job.apply');
                Route::get('application', 'jobApplication')->name('job.application');
                Route::get('application-details', 'jobApplicationDetails')->name('job.application.details');

                Route::get('favorite/item/{id}', 'addToFavorite')->name('favorite.item');
                Route::get('favorite-jobs', 'favoriteJobs')->name('favorite.jobs');
                Route::post('favorite-job/delete/{id}', 'favoriteJobDelete')->name('favorite.job.delete');
            });

            //Profile setting
            Route::controller('ProfileController')->group(function () {
                Route::get('profile-setting', 'profileSetting')->name('profile.setting');
                Route::post('basic-details-update', 'basicDetailsUpdate')->name('basic.details.update');
                Route::post('resume-headline-update', 'resumeHeadlineUpdate')->name('resume.headline.update');
                Route::post('skill-update/{id?}', 'skillUpdate')->name('skill.update');
                Route::post('skill-delete/{id}', 'skillDelete')->name('skill.delete');
                Route::post('it-skill-update/{id?}', 'itSkillUpdate')->name('it.skill.update');
                Route::post('it-skill-delete/{id}', 'itSkillDelete')->name('it.skill.delete');
                Route::post('project-store/{id?}', 'projectStore')->name('project.store');
                Route::post('project-delete/{id}', 'projectDelete')->name('project.delete');
                Route::post('summary-update', 'summaryStore')->name('summary.update');
                Route::post('online-profile-store/{id?}', 'onlineProfileStore')->name('online.profile.store');
                Route::post('online-profile-delete/{id}', 'onlineProfileDelete')->name('online.profile.delete');
                Route::post('publication-store/{id?}', 'publicationStore')->name('publication.store');
                Route::post('publication-delete/{id}', 'publicationDelete')->name('publication.delete');
                Route::post('presentation-store/{id?}', 'presentationStore')->name('presentation.store');
                Route::post('presentation-delete/{id}', 'presentationDelete')->name('presentation.delete');
                Route::post('patent-store/{id?}', 'patentStore')->name('patent.store');
                Route::post('patent-delete/{id}', 'patentDelete')->name('patent.delete');
                Route::post('certification-store/{id?}', 'certificationStore')->name('certification.store');
                Route::post('certification-delete/{id}', 'certificationDelete')->name('certification.delete');
                Route::post('career-profile-update', 'careerProfileUpdate')->name('career.profile.update');
                Route::post('permanent-address-update', 'permanentAddressUpdate')->name('permanent.address.update');
                Route::post('present-address-update', 'presentAddressUpdate')->name('present.address.update');
                Route::post('language-store/{id?}', 'languageStore')->name('language.store');
                Route::post('language-delete/{id}', 'languageDelete')->name('language.delete');
                Route::post('personal-details-update', 'personalDetailsUpdate')->name('personal.details.update');
                Route::post('resume-update', 'resumeUpdate')->name('resume.update');
                Route::get('resume-download', 'resumeDownload')->name('resume.download');
                Route::post('resume-delete', 'resumeDelete')->name('resume.delete');
                Route::post('image-store', 'imageStore')->name('image.store');

                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
                Route::post('update/image', 'updateImage')->name('update.image');
            });

            //user education route
            Route::name('education.')->prefix('education')->controller('EducationController')->group(function () {
                Route::get('index', 'index')->name('index');
                Route::post('store/{id?}', 'store')->name('store');
                Route::post('delete/{id}', 'delete')->name('delete');
            });

            //Employment History
            Route::prefix('employment')->name('employment.')->controller("EmploymentController")->group(function () {
                Route::get('history', 'index')->name('index');
                Route::post('store/{id?}', 'save')->name('store');
                Route::post('delete/{id}', 'delete')->name('delete');
            });
        });
    });
});
