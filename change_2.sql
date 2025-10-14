/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80403 (8.4.3)
 Source Host           : localhost:3306
 Source Schema         : aijoborbit

 Target Server Type    : MySQL
 Target Server Version : 80403 (8.4.3)
 File Encoding         : 65001

 Date: 14/10/2025 10:42:36
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for faqs
-- ----------------------------
DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `faqable_id` bigint UNSIGNED NOT NULL,
  `faqable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `question` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of faqs
-- ----------------------------
INSERT INTO `faqs` VALUES (1, 82, 'App\\Models\\Frontend', 'Does AI Job Orbit track my IP address?', 'AI Job Orbit gathers some technical pieces of information, like your IP address, your browser type, and additional device-related information. The data is used to enhance the security of the platform, combat fraud, and boost performance, thus giving the users one of the best online job portals\' safe and smooth experiences.', 1, '2025-10-10 12:58:11', '2025-10-14 10:41:34');
INSERT INTO `faqs` VALUES (2, 82, 'App\\Models\\Frontend', 'Can employers or other users see my personal information on AI Job Orbit?', 'No. Your personal information is always protected. AI Job Orbit does not share your data with recruiters, employers, or other users unless you choose to apply for a job or make your profile visible. You stay in complete control of what details are shared through your account.', 1, '2025-10-10 12:58:11', '2025-10-14 10:41:34');
INSERT INTO `faqs` VALUES (3, 82, 'App\\Models\\Frontend', 'Can I delete my AI Job Orbit account or personal data?', 'At this time, AI Job Orbit does not offer users the ability to remove their accounts or data on their own. This is to guarantee transparency and integrity with our platform\'s records. Nonetheless, you can contact our support team at support@aijoborbit.com for assistance if you want to deactivate your profile or stop using our services.', 1, '2025-10-10 12:58:11', '2025-10-14 10:41:34');
INSERT INTO `faqs` VALUES (4, 82, 'App\\Models\\Frontend', 'How does AI Job Orbit protect my data?', 'Data shared on the platform is safeguarded through encryption, access controls, and constant system monitoring by us. Your profile information, job applications, and communications with employers are all protected with the best available security measures, which are constantly updated.', 1, '2025-10-10 12:58:11', '2025-10-14 10:41:34');
INSERT INTO `faqs` VALUES (5, 1, 'App\\Models\\Page', 'What is a AI Job Orbit job?', 'AI Job Orbit is a platform where job seekers search for jobs and explore company profiles to find their perfect role. We help people find jobs as well as positions from various fields, such as IT jobs, healthcare, fashion, and finance jobs, through a secure and easy-to-use online job portal.', 1, '2025-10-10 12:58:11', '2025-10-14 10:42:14');
INSERT INTO `faqs` VALUES (6, 1, 'App\\Models\\Page', 'Is AI Job Orbit a reliable website?', 'It sure is. AI Job Orbit is one of the most reliable job search career portals, designed and developed with user data protection in mind, as well as safeguards against false job postings. Moreover, by employing sophisticated verification, encryption, and privacy measures, we can ensure the legitimacy and security of every job posting and communication with employers via our job portal.', 1, '2025-10-10 12:58:11', '2025-10-14 10:42:14');
INSERT INTO `faqs` VALUES (7, 1, 'App\\Models\\Page', 'Which is the best site for job search?', 'There are so many excellent job portal websites around. But AI Job Orbit, which offers verified job listings, a wide range of search options, and a secure platform for applying for jobs across numerous industries, is among the best job portals for both employers and job seekers.', 1, '2025-10-10 12:58:11', '2025-10-14 10:42:14');
INSERT INTO `faqs` VALUES (8, 1, 'App\\Models\\Page', 'What is the purpose of AI Job Orbit?', 'AI Job Orbit\'s belief is centred around the idea of streamlining the job application and job search process by connecting both the employers and the professionals in one secure and trustworthy space. Our platform enables users to post jobs, apply for openings, and control their careers effectively by using a modern and secure online job portal.', 1, '2025-10-10 12:58:11', '2025-10-14 10:42:14');
INSERT INTO `faqs` VALUES (9, 42, 'App\\Models\\Frontend', 'What type of personal data does AI Job Orbit collect?', 'When you sign up, apply for a position, or post a job, AI Job Orbit keeps all the data that you provide. This may be your user name, email, phone number, resume, and data about your activity on the platform.', 1, '2025-10-10 12:58:11', '2025-10-14 10:41:00');
INSERT INTO `faqs` VALUES (10, 42, 'App\\Models\\Frontend', 'How does AI Job Orbit use my personal information?', 'Our main goals with your data are to introduce you to the right employers, match you with the most suitable job postings, and give you the best user experience. For the sake of security and speed, we deal with minor technical information.', 1, '2025-10-10 12:58:11', '2025-10-14 10:41:00');
INSERT INTO `faqs` VALUES (11, 42, 'App\\Models\\Frontend', 'Does AI Job Orbit share my data with third parties?', 'In no circumstance is your data being sold or shared by AI Job Orbit. Information is only accessible by trustworthy service providers, those who help us maintain the platform and all of them are required to follow the strictest guidelines of confidentiality and data protection.', 1, '2025-10-10 12:58:11', '2025-10-14 10:41:00');
INSERT INTO `faqs` VALUES (12, 42, 'App\\Models\\Frontend', 'How long does AI Job Orbit keep my personal data?', 'We will keep your details during the active time of your account or until it is requested by a regulation that we follow.', 1, '2025-10-10 12:58:11', '2025-10-14 10:41:00');
INSERT INTO `faqs` VALUES (13, 43, 'App\\Models\\Frontend', 'What are the terms of service of AI Job Orbit?', 'Our terms of service explain the rules of using our job platform, including job posting, account creation, and communication between employers and job seekers.', 1, '2025-10-10 12:58:11', '2025-10-10 15:36:55');
INSERT INTO `faqs` VALUES (14, 43, 'App\\Models\\Frontend', 'Is AI Job Orbit free to use?', 'Yes, AI Job Orbit offers free access to job listings and profile creation. However, employers may choose paid options for premium visibility or featured job postings.', 1, '2025-10-10 12:58:11', '2025-10-10 15:36:59');
INSERT INTO `faqs` VALUES (15, 43, 'App\\Models\\Frontend', 'Why my account is suspended?', 'We have the right to suspend or delete accounts that break our terms of service, which comprises of spam, fraudulent postings, and improper use of personal data.', 1, '2025-10-10 12:58:11', '2025-10-10 15:37:02');
INSERT INTO `faqs` VALUES (16, 43, 'App\\Models\\Frontend', 'Can I apply for IT jobs through AI Job Orbit?', 'Yes. AI Job Orbit links job searchers with openings in a variety of sectors, such as marketing, finance, healthcare, education, and IT Jobs. Our online job portal, which is made to make every application safe and effective, allows you to apply for full-time, part-time, or remote jobs.', 1, '2025-10-10 12:58:11', '2025-10-10 15:37:19');

SET FOREIGN_KEY_CHECKS = 1;
