-- main Staging done

ALTER TABLE `admins`
ADD `role` VARCHAR(100) NULL DEFAULT 'user' AFTER `username`;

TRUNCATE `admins`;

INSERT INTO
    `admins` (
        `id`,
        `name`,
        `email`,
        `username`,
        `role`,
        `email_verified_at`,
        `image`,
        `password`,
        `remember_token`,
        `created_at`,
        `updated_at`
    )
VALUES (
        1,
        'Super Admin',
        'shehry@site.com',
        'shehry',
        'superadmin',
        NULL,
        '67f0c4dd2ce931743832285.png',
        '$2y$12$0uzhbda0zATzTIrUr5vhbODjNvA0uzB4Dexbl67VufgYtidwJ/k4u',
        'WW8tWjBS47P5hy8Ra1kCUFf9Zj6Ab94SAbIHfMeV7IngSIeqmrZFFP8oR40q',
        NULL,
        '2025-04-05 05:51:26'
    ),
    (
        2,
        'Admin',
        'admin@site.com',
        'admin',
        'admin',
        NULL,
        '67f0c4dd2ce931743832285.png',
        '$2y$12$0uzhbda0zATzTIrUr5vhbODjNvA0uzB4Dexbl67VufgYtidwJ/k4u',
        'WW8tWjBS47P5hy8Ra1kCUFf9Zj6Ab94SAbIHfMeV7IngSIeqmrZFFP8oR40q',
        NULL,
        '2025-04-05 05:51:26'
    );

-- local done

ALTER TABLE `pages` ADD `seo_content` TEXT NULL AFTER `slug`;