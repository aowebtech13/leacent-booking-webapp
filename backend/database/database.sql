-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 25, 2026 at 10:25 AM
-- Server version: 11.4.9-MariaDB-cll-lve-log
-- PHP Version: 8.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mavekmav_rdsreghfnkr`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_reminders`
--

CREATE TABLE `case_reminders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `case_id` varchar(255) DEFAULT NULL,
  `case_name` varchar(255) NOT NULL,
  `recipient_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'scheduled',
  `scheduled_for` timestamp NULL DEFAULT NULL,
  `processing_started_at` timestamp NULL DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `last_error` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `case_reminders`
--

INSERT INTO `case_reminders` (`id`, `user_id`, `case_id`, `case_name`, `recipient_email`, `subject`, `body`, `payload`, `type`, `status`, `scheduled_for`, `processing_started_at`, `sent_at`, `last_error`, `created_at`, `updated_at`) VALUES
(2, 5, '2026-01-02T17:54:51.498Z', 'JOHN DOE VS JANE DOE', 'mgsincorporation@gmail.com', 'Task Reminders for Case: JOHN DOE VS JANE DOE', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: JOHN DOE VS JANE DOE.\n\n- File the amended Claim Form and Particulars of Claim with the court. (Due: 2026-01-07) \n- Serve the amended Claim Form and Particulars of Claim on the Defendant\'s Counsel. (Due: 2026-01-09) \n- Review the Defendant\'s previous Defence to identify potential responses to the amendments. (Due: 2026-01-08) \n- Prepare a comprehensive case summary and outline of key issues for the Case Management Conference (CMC). (Due: 2026-01-10) \n- Draft a proposed set of directions for the upcoming Case Management Conference (CMC). (Due: 2026-01-12) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'manual', 'sent', NULL, '2026-01-02 23:08:43', '2026-01-02 23:08:43', NULL, '2026-01-02 23:08:43', '2026-01-02 23:08:43'),
(3, 5, '2026-01-02T17:54:51.498Z', 'JOHN DOE VS JANE DOE', 'adebayoabayomio@yahoo.com', 'Case Update: JOHN DOE VS JANE DOE - Proceedings of 1/1/2026', 'Dear Client,\n\nThis report provides an update on today\'s court proceeding for your matter.\n\nThe court granted our application for amendment.\n\nThe case has been adjourned to 14th January 2026 for a Case Management Conference.\n\nWe will keep you informed of any further developments.\n\nSincerely,', NULL, 'manual', 'sent', NULL, '2026-01-02 23:09:17', '2026-01-02 23:09:17', NULL, '2026-01-02 23:09:17', '2026-01-02 23:09:17'),
(4, 5, '2026-01-12T16:19:20.148Z', 'JOH DOE VS JANE DOE', 'emmanuelmichael87@gmail.com', 'Task Reminders for Case: JOH DOE VS JANE DOE', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: JOH DOE VS JANE DOE.\n\n- Confirm availability of all key witnesses and ensure any necessary subpoenas have been served. (Due: 2026-01-15) \n- Finalize and print all exhibits, ensuring they are properly marked and organized for presentation at the hearing. (Due: 2026-01-15) \n- Prepare and finalize the draft opening statement for Claimant\'s Counsel. (Due: 2026-01-15) \n- Outline key points and arguments for the closing statement. (Due: 2026-01-15) \n- Conduct a final meeting with the Claimant to review hearing strategy, potential questions, and manage expectations. (Due: 2026-01-15) \n- Brief Claimant\'s Counsel on any last-minute developments, strategic adjustments, and ensure all materials are prepared for the hearing. (Due: 2026-01-15) \n- Confirm courtroom assignment, hearing time, and any other logistical details for the hearing on 2026-01-16. (Due: 2026-01-15) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'manual', 'sent', NULL, '2026-01-12 21:27:02', '2026-01-12 21:27:03', NULL, '2026-01-12 21:27:02', '2026-01-12 21:27:03'),
(5, 5, '2026-01-12T16:19:20.148Z', 'JOH DOE VS JANE DOE', 'emmanuelmichael87@gmail.com', 'Task Reminders for Case: JOH DOE VS JANE DOE', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: JOH DOE VS JANE DOE.\n\n- Confirm availability of all key witnesses and ensure any necessary subpoenas have been served. (Due: 2026-01-15) \n- Finalize and print all exhibits, ensuring they are properly marked and organized for presentation at the hearing. (Due: 2026-01-15) \n- Prepare and finalize the draft opening statement for Claimant\'s Counsel. (Due: 2026-01-15) \n- Outline key points and arguments for the closing statement. (Due: 2026-01-15) \n- Conduct a final meeting with the Claimant to review hearing strategy, potential questions, and manage expectations. (Due: 2026-01-15) \n- Brief Claimant\'s Counsel on any last-minute developments, strategic adjustments, and ensure all materials are prepared for the hearing. (Due: 2026-01-15) \n- Confirm courtroom assignment, hearing time, and any other logistical details for the hearing on 2026-01-16. (Due: 2026-01-15) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'manual', 'sent', NULL, '2026-01-12 21:27:02', '2026-01-12 21:27:03', NULL, '2026-01-12 21:27:02', '2026-01-12 21:27:03'),
(6, 5, '2026-01-12T16:19:20.148Z', 'JOH DOE VS JANE DOE', 'emmanuelmichael87@gmail.com', 'Task Reminders for Case: JOH DOE VS JANE DOE', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: JOH DOE VS JANE DOE.\n\n- Confirm availability of all key witnesses and ensure any necessary subpoenas have been served. (Due: 2026-01-15) \n- Finalize and print all exhibits, ensuring they are properly marked and organized for presentation at the hearing. (Due: 2026-01-15) \n- Prepare and finalize the draft opening statement for Claimant\'s Counsel. (Due: 2026-01-15) \n- Outline key points and arguments for the closing statement. (Due: 2026-01-15) \n- Conduct a final meeting with the Claimant to review hearing strategy, potential questions, and manage expectations. (Due: 2026-01-15) \n- Brief Claimant\'s Counsel on any last-minute developments, strategic adjustments, and ensure all materials are prepared for the hearing. (Due: 2026-01-15) \n- Confirm courtroom assignment, hearing time, and any other logistical details for the hearing on 2026-01-16. (Due: 2026-01-15) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'manual', 'failed', NULL, '2026-01-12 21:27:02', NULL, 'Too many requests. You can only make 2 requests per second. See rate limit response headers for more information. Or contact support to increase rate limit.', '2026-01-12 21:27:02', '2026-01-12 21:27:02'),
(7, 59, '2026-01-14T11:22:26.648Z', 'UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'oluwanifemi@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Oluwanifemi Adejuyigbe]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Oluwanifemi Adejuyigbe]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Oluwanifemi Adejuyigbe]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) \n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'manual', 'sent', NULL, '2026-01-14 16:30:49', '2026-01-14 16:30:50', NULL, '2026-01-14 16:30:49', '2026-01-14 16:30:50'),
(8, 59, '2026-01-14T11:22:26.648Z', 'UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'oluwanifemi@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Oluwanifemi Adejuyigbe]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Oluwanifemi Adejuyigbe]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Oluwanifemi Adejuyigbe]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) \n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'manual', 'failed', NULL, '2026-01-14 16:30:49', NULL, 'Too many requests. You can only make 2 requests per second. See rate limit response headers for more information. Or contact support to increase rate limit.', '2026-01-14 16:30:49', '2026-01-14 16:30:50'),
(9, 59, '2026-01-14T11:22:26.648Z', 'UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'oluwanifemi@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Oluwanifemi Adejuyigbe]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Oluwanifemi Adejuyigbe]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Oluwanifemi Adejuyigbe]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) \n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'manual', 'failed', NULL, '2026-01-14 16:30:49', NULL, 'Too many requests. You can only make 2 requests per second. See rate limit response headers for more information. Or contact support to increase rate limit.', '2026-01-14 16:30:49', '2026-01-14 16:30:50'),
(10, 59, '2026-01-14T11:22:26.648Z', 'UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'oluwanifemi@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Oluwanifemi Adejuyigbe]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Oluwanifemi Adejuyigbe]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Oluwanifemi Adejuyigbe]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) \n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'manual', 'sent', NULL, '2026-01-14 16:30:49', '2026-01-14 16:30:50', NULL, '2026-01-14 16:30:49', '2026-01-14 16:30:50'),
(11, 59, '2026-01-14T11:22:26.648Z', 'UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'oluwanifemi@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Oluwanifemi Adejuyigbe]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Oluwanifemi Adejuyigbe]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Oluwanifemi Adejuyigbe]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) \n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'manual', 'failed', NULL, '2026-01-14 16:30:50', NULL, 'Too many requests. You can only make 2 requests per second. See rate limit response headers for more information. Or contact support to increase rate limit.', '2026-01-14 16:30:50', '2026-01-14 16:30:50'),
(12, 59, '2026-01-14T11:22:26.648Z', 'UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'oluwanifemi@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Oluwanifemi Adejuyigbe]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Oluwanifemi Adejuyigbe]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Oluwanifemi Adejuyigbe]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) \n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'manual', 'failed', NULL, '2026-01-14 16:30:50', NULL, 'Too many requests. You can only make 2 requests per second. See rate limit response headers for more information. Or contact support to increase rate limit.', '2026-01-14 16:30:50', '2026-01-14 16:30:50'),
(13, 59, '2026-01-14T11:22:26.648Z', 'UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'oluwanifemi@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Oluwanifemi Adejuyigbe]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Oluwanifemi Adejuyigbe]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Oluwanifemi Adejuyigbe]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) \n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'manual', 'failed', NULL, '2026-01-14 16:30:50', NULL, 'Too many requests. You can only make 2 requests per second. See rate limit response headers for more information. Or contact support to increase rate limit.', '2026-01-14 16:30:50', '2026-01-14 16:30:50'),
(14, 59, '2026-01-14T11:22:26.648Z', 'UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'michael@aeclegal.com', 'Case Update: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS - Proceedings of 1/14/2026', 'AEC/CCT/MIDLANDS/OPA/025/012\n\n14th January 2025,\n\nMs. Vanessa Toyin Ebifemi, Midlands Court Estate, Chevron Drive, Lekki Phase 1, Lagos State.\nDear Sir,\n\nTENANCY OF PROPERTY AT MIDLANDS COURT ESTATE, CHEVRON DRIVE, LAGOS STATE.\nWe refer to the above subject and the telephone conversation of 14th January 2025 between your goodself and our Oluwanifemi Adejuyigbe.\nWe continue to act as solicitors to your Landlord, Mr. Fuad Akinsanya (“our client”) on whose behalf we write.\nKindly be informed that your tenancy in respect of the above-captioned property expired on the 8th of January 2024 and you are currently in default of your rental payment. Consequently, we ask that you kindly forward your cheque in the sum of N5,000,000.00 (Five Million Naira Only) being the renewal of rent for the tenancy period commencing on 9th of January 2025 and terminating on 8th January 2026 or in the alternative you may make payment into the account below:\nAccount Name: AEC Nominees Limited Bank: Guarantee Trust Bank Plc Account Number: 0002506040\nKindly be reminded that, pursuant to your commitment during your telephone conversation with our representative, Oluwanifemi Adejuyigbe, to make payment on or before the 17th of January 2025, we have received the Landlord’s firm instructions to initiate immediate recovery proceedings for the property should payment not be received by the agreed date of 17th January 2025.\n\nThank you in anticipation of your prompt response and action.\n\nYours faithfully,\n  \nMICHAEL EMMANUEL \nFOR: AEC LEGAL.', NULL, 'manual', 'sent', NULL, '2026-01-14 16:33:18', '2026-01-14 16:33:18', NULL, '2026-01-14 16:33:18', '2026-01-14 16:33:18'),
(15, 59, '2026-01-14T11:22:26.648Z', 'UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'oluwanifemi@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Oluwanifemi Adejuyigbe]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Oluwanifemi Adejuyigbe]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Oluwanifemi Adejuyigbe]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) \n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'manual', 'sent', NULL, '2026-01-14 16:34:02', '2026-01-14 16:34:02', NULL, '2026-01-14 16:34:02', '2026-01-14 16:34:02'),
(16, 59, '2026-01-14T11:22:26.648Z', 'UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'ccteam@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Michael Emmanuel]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Onyinyechi Ejimonye]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Onyinyechi Ejimonye]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Michael Emmanuel]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) [Assigned to: Michael Emmanuel]\n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) [Assigned to: Oluwanifemi Adejuyigbe]\n\nBest regards,\nMavericksAI Case Manager', NULL, 'manual', 'sent', NULL, '2026-01-14 16:47:19', '2026-01-14 16:47:19', NULL, '2026-01-14 16:47:19', '2026-01-14 16:47:19'),
(17, 59, '2026-01-14T11:22:26.648Z', 'UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'ccteam@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Michael Emmanuel]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Onyinyechi Ejimonye]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Onyinyechi Ejimonye]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Michael Emmanuel]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) [Assigned to: Michael Emmanuel]\n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) [Assigned to: Oluwanifemi Adejuyigbe]\n\nBest regards,\nMavericksAI Case Manager', NULL, 'manual', 'sent', NULL, '2026-01-14 16:48:40', '2026-01-14 16:48:40', NULL, '2026-01-14 16:48:40', '2026-01-14 16:48:40'),
(18, 59, '2026-01-14T11:22:26.648Z', 'UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'litigation@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Michael Emmanuel]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Onyinyechi Ejimonye]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Onyinyechi Ejimonye]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Michael Emmanuel]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) [Assigned to: Michael Emmanuel]\n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) [Assigned to: Oluwanifemi Adejuyigbe]\n\nBest regards,\nMavericksAI Case Manager', NULL, 'manual', 'sent', NULL, '2026-01-14 16:50:55', '2026-01-14 16:50:56', NULL, '2026-01-14 16:50:55', '2026-01-14 16:50:56');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `content` longtext NOT NULL,
  `agent_id` varchar(255) DEFAULT NULL,
  `type` enum('template','supporting','result') NOT NULL DEFAULT 'supporting',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_processing_results`
--

CREATE TABLE `document_processing_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` varchar(255) NOT NULL,
  `template_document_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supporting_document_id` bigint(20) UNSIGNED DEFAULT NULL,
  `instructions` longtext NOT NULL,
  `result_json` longtext NOT NULL,
  `result_type` varchar(255) NOT NULL,
  `status` enum('pending','processing','completed','failed') NOT NULL DEFAULT 'pending',
  `error_message` text DEFAULT NULL,
  `processing_time_ms` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_templates`
--

CREATE TABLE `document_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `template_type` varchar(255) NOT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 0,
  `usage_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `case_reminder_id` bigint(20) UNSIGNED NOT NULL,
  `to_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `from_email` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `resend_email_id` varchar(255) DEFAULT NULL,
  `resend_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`resend_response`)),
  `error_message` text DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `bounced_at` timestamp NULL DEFAULT NULL,
  `complained_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_logs`
--

INSERT INTO `email_logs` (`id`, `case_reminder_id`, `to_email`, `subject`, `body`, `from_email`, `status`, `resend_email_id`, `resend_response`, `error_message`, `sent_at`, `delivered_at`, `bounced_at`, `complained_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'adebayoabayomio@yahoo.com', 'Task Reminders for Case: ABC LTD V. DEF LTD', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: ABC LTD V. DEF LTD.\n\n- Review thoroughly all submissions made for and against the interlocutory injunction application. (Due: 2025-12-05) \n- Prepare a concise summary of the Claimant\'s arguments and supporting evidence for the interlocutory injunction. (Due: 2025-12-07) \n- Anticipate potential questions or clarifications the court might seek during the ruling and prepare brief answers. (Due: 2025-12-08) \n- Draft an internal memo outlining immediate next steps if the injunction is denied or partially granted. (Due: 2025-12-10) \n- Brief Claimant\'s Counsel on the importance of the ruling and potential implications for the overall case strategy. (Due: 2025-12-11) \n\nBest regards,\nMavericksAI Case Manager', 'support@mavericksai.tech', 'sent', '81ad1d72-6a08-4ef6-b1b2-9f59119f9c56', '{\"id\":\"81ad1d72-6a08-4ef6-b1b2-9f59119f9c56\",\"from\":\"support@mavericksai.tech\",\"to\":\"adebayoabayomio@yahoo.com\",\"created_at\":\"2025-12-03T02:19:52+00:00\",\"raw_response\":{\"\\u0000*\\u0000attributes\":{\"id\":\"81ad1d72-6a08-4ef6-b1b2-9f59119f9c56\"}}}', NULL, '2025-12-03 07:19:52', NULL, NULL, NULL, '2025-12-03 07:19:51', '2025-12-03 07:19:52'),
(2, 2, 'mgsincorporation@gmail.com', 'Task Reminders for Case: JOHN DOE VS JANE DOE', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: JOHN DOE VS JANE DOE.\n\n- File the amended Claim Form and Particulars of Claim with the court. (Due: 2026-01-07) \n- Serve the amended Claim Form and Particulars of Claim on the Defendant\'s Counsel. (Due: 2026-01-09) \n- Review the Defendant\'s previous Defence to identify potential responses to the amendments. (Due: 2026-01-08) \n- Prepare a comprehensive case summary and outline of key issues for the Case Management Conference (CMC). (Due: 2026-01-10) \n- Draft a proposed set of directions for the upcoming Case Management Conference (CMC). (Due: 2026-01-12) \n\nBest regards,\nMavericksAI Case Manager', 'support@mavericksai.tech', 'sent', 'be8941fe-a108-46a7-99cf-62770585392f', '{\"id\":\"be8941fe-a108-46a7-99cf-62770585392f\",\"from\":\"support@mavericksai.tech\",\"to\":\"mgsincorporation@gmail.com\",\"created_at\":\"2026-01-02T18:08:43+00:00\",\"raw_response\":{\"\\u0000*\\u0000attributes\":{\"id\":\"be8941fe-a108-46a7-99cf-62770585392f\"}}}', NULL, '2026-01-02 23:08:43', NULL, NULL, NULL, '2026-01-02 23:08:43', '2026-01-02 23:08:43'),
(3, 3, 'adebayoabayomio@yahoo.com', 'Case Update: JOHN DOE VS JANE DOE - Proceedings of 1/1/2026', 'Dear Client,\n\nThis report provides an update on today\'s court proceeding for your matter.\n\nThe court granted our application for amendment.\n\nThe case has been adjourned to 14th January 2026 for a Case Management Conference.\n\nWe will keep you informed of any further developments.\n\nSincerely,', 'support@mavericksai.tech', 'sent', 'f2199c28-3a99-4953-ac5f-6c4961b3d9e6', '{\"id\":\"f2199c28-3a99-4953-ac5f-6c4961b3d9e6\",\"from\":\"support@mavericksai.tech\",\"to\":\"adebayoabayomio@yahoo.com\",\"created_at\":\"2026-01-02T18:09:17+00:00\",\"raw_response\":{\"\\u0000*\\u0000attributes\":{\"id\":\"f2199c28-3a99-4953-ac5f-6c4961b3d9e6\"}}}', NULL, '2026-01-02 23:09:17', NULL, NULL, NULL, '2026-01-02 23:09:17', '2026-01-02 23:09:17'),
(4, 5, 'emmanuelmichael87@gmail.com', 'Task Reminders for Case: JOH DOE VS JANE DOE', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: JOH DOE VS JANE DOE.\n\n- Confirm availability of all key witnesses and ensure any necessary subpoenas have been served. (Due: 2026-01-15) \n- Finalize and print all exhibits, ensuring they are properly marked and organized for presentation at the hearing. (Due: 2026-01-15) \n- Prepare and finalize the draft opening statement for Claimant\'s Counsel. (Due: 2026-01-15) \n- Outline key points and arguments for the closing statement. (Due: 2026-01-15) \n- Conduct a final meeting with the Claimant to review hearing strategy, potential questions, and manage expectations. (Due: 2026-01-15) \n- Brief Claimant\'s Counsel on any last-minute developments, strategic adjustments, and ensure all materials are prepared for the hearing. (Due: 2026-01-15) \n- Confirm courtroom assignment, hearing time, and any other logistical details for the hearing on 2026-01-16. (Due: 2026-01-15) \n\nBest regards,\nMavericksAI Case Manager', 'support@mavericksai.tech', 'sent', 'da864f4d-a09d-4618-80cd-2dbab555b469', '{\"id\":\"da864f4d-a09d-4618-80cd-2dbab555b469\",\"from\":\"support@mavericksai.tech\",\"to\":\"emmanuelmichael87@gmail.com\",\"created_at\":\"2026-01-12T16:27:03+00:00\",\"raw_response\":{\"\\u0000*\\u0000attributes\":{\"id\":\"da864f4d-a09d-4618-80cd-2dbab555b469\"}}}', NULL, '2026-01-12 21:27:03', NULL, NULL, NULL, '2026-01-12 21:27:02', '2026-01-12 21:27:03'),
(5, 4, 'emmanuelmichael87@gmail.com', 'Task Reminders for Case: JOH DOE VS JANE DOE', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: JOH DOE VS JANE DOE.\n\n- Confirm availability of all key witnesses and ensure any necessary subpoenas have been served. (Due: 2026-01-15) \n- Finalize and print all exhibits, ensuring they are properly marked and organized for presentation at the hearing. (Due: 2026-01-15) \n- Prepare and finalize the draft opening statement for Claimant\'s Counsel. (Due: 2026-01-15) \n- Outline key points and arguments for the closing statement. (Due: 2026-01-15) \n- Conduct a final meeting with the Claimant to review hearing strategy, potential questions, and manage expectations. (Due: 2026-01-15) \n- Brief Claimant\'s Counsel on any last-minute developments, strategic adjustments, and ensure all materials are prepared for the hearing. (Due: 2026-01-15) \n- Confirm courtroom assignment, hearing time, and any other logistical details for the hearing on 2026-01-16. (Due: 2026-01-15) \n\nBest regards,\nMavericksAI Case Manager', 'support@mavericksai.tech', 'sent', '6bac8267-f30a-4927-9fa5-6b2badcaf096', '{\"id\":\"6bac8267-f30a-4927-9fa5-6b2badcaf096\",\"from\":\"support@mavericksai.tech\",\"to\":\"emmanuelmichael87@gmail.com\",\"created_at\":\"2026-01-12T16:27:03+00:00\",\"raw_response\":{\"\\u0000*\\u0000attributes\":{\"id\":\"6bac8267-f30a-4927-9fa5-6b2badcaf096\"}}}', NULL, '2026-01-12 21:27:03', NULL, NULL, NULL, '2026-01-12 21:27:02', '2026-01-12 21:27:03'),
(6, 6, 'emmanuelmichael87@gmail.com', 'Task Reminders for Case: JOH DOE VS JANE DOE', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: JOH DOE VS JANE DOE.\n\n- Confirm availability of all key witnesses and ensure any necessary subpoenas have been served. (Due: 2026-01-15) \n- Finalize and print all exhibits, ensuring they are properly marked and organized for presentation at the hearing. (Due: 2026-01-15) \n- Prepare and finalize the draft opening statement for Claimant\'s Counsel. (Due: 2026-01-15) \n- Outline key points and arguments for the closing statement. (Due: 2026-01-15) \n- Conduct a final meeting with the Claimant to review hearing strategy, potential questions, and manage expectations. (Due: 2026-01-15) \n- Brief Claimant\'s Counsel on any last-minute developments, strategic adjustments, and ensure all materials are prepared for the hearing. (Due: 2026-01-15) \n- Confirm courtroom assignment, hearing time, and any other logistical details for the hearing on 2026-01-16. (Due: 2026-01-15) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'failed', NULL, NULL, 'Too many requests. You can only make 2 requests per second. See rate limit response headers for more information. Or contact support to increase rate limit.', NULL, NULL, NULL, NULL, '2026-01-12 21:27:02', '2026-01-12 21:27:02'),
(7, 8, 'oluwanifemi@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Oluwanifemi Adejuyigbe]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Oluwanifemi Adejuyigbe]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Oluwanifemi Adejuyigbe]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) \n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'failed', NULL, NULL, 'Too many requests. You can only make 2 requests per second. See rate limit response headers for more information. Or contact support to increase rate limit.', NULL, NULL, NULL, NULL, '2026-01-14 16:30:49', '2026-01-14 16:30:50'),
(8, 7, 'oluwanifemi@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Oluwanifemi Adejuyigbe]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Oluwanifemi Adejuyigbe]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Oluwanifemi Adejuyigbe]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) \n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) \n\nBest regards,\nMavericksAI Case Manager', 'support@mavericksai.tech', 'sent', '923c7829-52b3-47b0-8885-955019a32e75', '{\"id\":\"923c7829-52b3-47b0-8885-955019a32e75\",\"from\":\"support@mavericksai.tech\",\"to\":\"oluwanifemi@aeclegal.com\",\"created_at\":\"2026-01-14T11:30:50+00:00\",\"raw_response\":{\"\\u0000*\\u0000attributes\":{\"id\":\"923c7829-52b3-47b0-8885-955019a32e75\"}}}', NULL, '2026-01-14 16:30:50', NULL, NULL, NULL, '2026-01-14 16:30:49', '2026-01-14 16:30:50'),
(9, 10, 'oluwanifemi@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Oluwanifemi Adejuyigbe]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Oluwanifemi Adejuyigbe]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Oluwanifemi Adejuyigbe]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) \n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) \n\nBest regards,\nMavericksAI Case Manager', 'support@mavericksai.tech', 'sent', '2bf5efd4-9dca-44aa-baef-7f5a2daee43f', '{\"id\":\"2bf5efd4-9dca-44aa-baef-7f5a2daee43f\",\"from\":\"support@mavericksai.tech\",\"to\":\"oluwanifemi@aeclegal.com\",\"created_at\":\"2026-01-14T11:30:50+00:00\",\"raw_response\":{\"\\u0000*\\u0000attributes\":{\"id\":\"2bf5efd4-9dca-44aa-baef-7f5a2daee43f\"}}}', NULL, '2026-01-14 16:30:50', NULL, NULL, NULL, '2026-01-14 16:30:49', '2026-01-14 16:30:50'),
(10, 9, 'oluwanifemi@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Oluwanifemi Adejuyigbe]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Oluwanifemi Adejuyigbe]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Oluwanifemi Adejuyigbe]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) \n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'failed', NULL, NULL, 'Too many requests. You can only make 2 requests per second. See rate limit response headers for more information. Or contact support to increase rate limit.', NULL, NULL, NULL, NULL, '2026-01-14 16:30:49', '2026-01-14 16:30:50'),
(11, 11, 'oluwanifemi@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Oluwanifemi Adejuyigbe]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Oluwanifemi Adejuyigbe]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Oluwanifemi Adejuyigbe]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) \n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'failed', NULL, NULL, 'Too many requests. You can only make 2 requests per second. See rate limit response headers for more information. Or contact support to increase rate limit.', NULL, NULL, NULL, NULL, '2026-01-14 16:30:50', '2026-01-14 16:30:50'),
(12, 12, 'oluwanifemi@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Oluwanifemi Adejuyigbe]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Oluwanifemi Adejuyigbe]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Oluwanifemi Adejuyigbe]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) \n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'failed', NULL, NULL, 'Too many requests. You can only make 2 requests per second. See rate limit response headers for more information. Or contact support to increase rate limit.', NULL, NULL, NULL, NULL, '2026-01-14 16:30:50', '2026-01-14 16:30:50'),
(13, 13, 'oluwanifemi@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Oluwanifemi Adejuyigbe]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Oluwanifemi Adejuyigbe]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Oluwanifemi Adejuyigbe]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) \n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) \n\nBest regards,\nMavericksAI Case Manager', NULL, 'failed', NULL, NULL, 'Too many requests. You can only make 2 requests per second. See rate limit response headers for more information. Or contact support to increase rate limit.', NULL, NULL, NULL, NULL, '2026-01-14 16:30:50', '2026-01-14 16:30:50'),
(14, 14, 'michael@aeclegal.com', 'Case Update: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS - Proceedings of 1/14/2026', 'AEC/CCT/MIDLANDS/OPA/025/012\n\n14th January 2025,\n\nMs. Vanessa Toyin Ebifemi, Midlands Court Estate, Chevron Drive, Lekki Phase 1, Lagos State.\nDear Sir,\n\nTENANCY OF PROPERTY AT MIDLANDS COURT ESTATE, CHEVRON DRIVE, LAGOS STATE.\nWe refer to the above subject and the telephone conversation of 14th January 2025 between your goodself and our Oluwanifemi Adejuyigbe.\nWe continue to act as solicitors to your Landlord, Mr. Fuad Akinsanya (“our client”) on whose behalf we write.\nKindly be informed that your tenancy in respect of the above-captioned property expired on the 8th of January 2024 and you are currently in default of your rental payment. Consequently, we ask that you kindly forward your cheque in the sum of N5,000,000.00 (Five Million Naira Only) being the renewal of rent for the tenancy period commencing on 9th of January 2025 and terminating on 8th January 2026 or in the alternative you may make payment into the account below:\nAccount Name: AEC Nominees Limited Bank: Guarantee Trust Bank Plc Account Number: 0002506040\nKindly be reminded that, pursuant to your commitment during your telephone conversation with our representative, Oluwanifemi Adejuyigbe, to make payment on or before the 17th of January 2025, we have received the Landlord’s firm instructions to initiate immediate recovery proceedings for the property should payment not be received by the agreed date of 17th January 2025.\n\nThank you in anticipation of your prompt response and action.\n\nYours faithfully,\n  \nMICHAEL EMMANUEL \nFOR: AEC LEGAL.', 'support@mavericksai.tech', 'sent', '4f97cd3b-2be1-485e-9748-46d6e062d272', '{\"id\":\"4f97cd3b-2be1-485e-9748-46d6e062d272\",\"from\":\"support@mavericksai.tech\",\"to\":\"michael@aeclegal.com\",\"created_at\":\"2026-01-14T11:33:18+00:00\",\"raw_response\":{\"\\u0000*\\u0000attributes\":{\"id\":\"4f97cd3b-2be1-485e-9748-46d6e062d272\"}}}', NULL, '2026-01-14 16:33:18', NULL, NULL, NULL, '2026-01-14 16:33:18', '2026-01-14 16:33:18'),
(15, 15, 'oluwanifemi@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Oluwanifemi Adejuyigbe]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Oluwanifemi Adejuyigbe]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Oluwanifemi Adejuyigbe]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) \n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) \n\nBest regards,\nMavericksAI Case Manager', 'support@mavericksai.tech', 'sent', '8e14401c-28cd-4fa1-9da5-d2867721a049', '{\"id\":\"8e14401c-28cd-4fa1-9da5-d2867721a049\",\"from\":\"support@mavericksai.tech\",\"to\":\"oluwanifemi@aeclegal.com\",\"created_at\":\"2026-01-14T11:34:02+00:00\",\"raw_response\":{\"\\u0000*\\u0000attributes\":{\"id\":\"8e14401c-28cd-4fa1-9da5-d2867721a049\"}}}', NULL, '2026-01-14 16:34:02', NULL, NULL, NULL, '2026-01-14 16:34:02', '2026-01-14 16:34:02'),
(16, 16, 'ccteam@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Michael Emmanuel]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Onyinyechi Ejimonye]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Onyinyechi Ejimonye]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Michael Emmanuel]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) [Assigned to: Michael Emmanuel]\n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) [Assigned to: Oluwanifemi Adejuyigbe]\n\nBest regards,\nMavericksAI Case Manager', 'support@mavericksai.tech', 'sent', '100c163a-f631-4113-a97d-c0ca25fc3972', '{\"id\":\"100c163a-f631-4113-a97d-c0ca25fc3972\",\"from\":\"support@mavericksai.tech\",\"to\":\"ccteam@aeclegal.com\",\"created_at\":\"2026-01-14T11:47:19+00:00\",\"raw_response\":{\"\\u0000*\\u0000attributes\":{\"id\":\"100c163a-f631-4113-a97d-c0ca25fc3972\"}}}', NULL, '2026-01-14 16:47:19', NULL, NULL, NULL, '2026-01-14 16:47:19', '2026-01-14 16:47:19'),
(17, 17, 'ccteam@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Michael Emmanuel]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Onyinyechi Ejimonye]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Onyinyechi Ejimonye]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Michael Emmanuel]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) [Assigned to: Michael Emmanuel]\n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) [Assigned to: Oluwanifemi Adejuyigbe]\n\nBest regards,\nMavericksAI Case Manager', 'support@mavericksai.tech', 'sent', 'ca5859c9-72a3-4935-94ce-f86ba677b7e3', '{\"id\":\"ca5859c9-72a3-4935-94ce-f86ba677b7e3\",\"from\":\"support@mavericksai.tech\",\"to\":\"ccteam@aeclegal.com\",\"created_at\":\"2026-01-14T11:48:40+00:00\",\"raw_response\":{\"\\u0000*\\u0000attributes\":{\"id\":\"ca5859c9-72a3-4935-94ce-f86ba677b7e3\"}}}', NULL, '2026-01-14 16:48:40', NULL, NULL, NULL, '2026-01-14 16:48:40', '2026-01-14 16:48:40'),
(18, 18, 'litigation@aeclegal.com', 'Task Reminders for Case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS', 'Hi Team,\n\nThis is a reminder for the upcoming tasks for case: UNIT 10 ADDRESS HOMES ESTATE, IKOYI, LAGOS.\n\n- Verify the payment status of N5,000,000.00 for the tenancy period of 2025-01-09 to 2026-01-08 by confirming with Mr. Fuad Akinsanya and AEC Nominees Limited. (Due: 2026-12-01) [Assigned to: Michael Emmanuel]\n- Calculate the total outstanding rent, including any unpaid amount for 2025-01-09 to 2026-01-08 and the rent due for the period 2026-01-09 to 2027-01-08 (assuming N5,000,000.00 annual rent). (Due: 2026-12-08) [Assigned to: Oluwanifemi Adejuyigbe]\n- Draft a formal rent demand letter to Ms. Vanessa Toyin Ebifemi, consolidating all outstanding amounts and specifying a strict payment deadline. (Due: 2026-12-12) [Assigned to: Onyinyechi Ejimonye]\n- Dispatch the formal rent demand letter to Ms. Vanessa Toyin Ebifemi via a traceable method (e.g., registered mail or courier) to ensure proof of delivery. (Due: 2026-12-18) [Assigned to: Onyinyechi Ejimonye]\n- Monitor the client\'s account for any payments received from Ms. Ebifemi and document any communication or response from her. (Due: 2027-01-08) [Assigned to: Michael Emmanuel]\n- Compile all relevant documentation for the court appearance, including the tenancy agreement, all demand letters sent (2025 and the new one), payment records (or lack thereof), and proof of delivery for all correspondence. (Due: 2027-01-10) [Assigned to: Michael Emmanuel]\n- Review the case strategy with Claimant\'s Counsel based on the tenant\'s response (or lack thereof) and prepare for the hearing, including potential applications for possession or rent arrears. (Due: 2027-01-12) [Assigned to: Oluwanifemi Adejuyigbe]\n\nBest regards,\nMavericksAI Case Manager', 'support@mavericksai.tech', 'sent', 'bd58cc30-5a87-48b2-97a6-9e72c0350cc8', '{\"id\":\"bd58cc30-5a87-48b2-97a6-9e72c0350cc8\",\"from\":\"support@mavericksai.tech\",\"to\":\"litigation@aeclegal.com\",\"created_at\":\"2026-01-14T11:50:56+00:00\",\"raw_response\":{\"\\u0000*\\u0000attributes\":{\"id\":\"bd58cc30-5a87-48b2-97a6-9e72c0350cc8\"}}}', NULL, '2026-01-14 16:50:56', NULL, NULL, NULL, '2026-01-14 16:50:55', '2026-01-14 16:50:56');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(8, '0001_01_01_000000_create_users_table', 1),
(9, '0001_01_01_000001_create_cache_table', 1),
(10, '0001_01_01_000002_create_jobs_table', 1),
(11, '2025_10_21_093525_create_personal_access_tokens_table', 1),
(12, '2025_10_21_093537_create_profiles_table', 1),
(13, '2025_10_21_093611_create_user_roles_table', 1),
(14, '2025_10_21_093625_create_subscriptions_table', 1),
(15, '2025_11_01_094224_add_profile_fields', 2),
(16, '2025_11_05_000001_add_otp_fields_to_users_table', 2),
(17, '2025_11_06_090236_add_billing_cycle_and_cancelled_at_to_subscriptions_table', 2),
(18, '2025_11_11_140500_create_case_reminders_table', 2),
(19, '2025_11_22_102600_create_documents_table', 3),
(20, '2025_11_22_102610_create_document_processing_results_table', 3),
(21, '2025_11_22_102620_create_document_templates_table', 3),
(22, '2025_11_29_000001_create_referrals_table', 3),
(23, '2025_11_29_073925_create_email_logs_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(8, 'App\\Models\\User', 3, 'auth_token', 'b58cc09c342de0a6e7c99c26149590b0c29d5fba11ed2df96214e2544204f050', '[\"*\"]', '2025-12-12 23:38:37', NULL, '2025-12-03 10:59:17', '2025-12-12 23:38:37'),
(9, 'App\\Models\\User', 6, 'auth_token', 'f1e415d34265bb94b582e353c36c8bccd1153fa5dcb03734eedf412841cffee5', '[\"*\"]', '2025-12-30 01:56:37', NULL, '2025-12-03 11:19:10', '2025-12-30 01:56:37'),
(10, 'App\\Models\\User', 7, 'auth_token', '3d61cc4db9d1d357ff25e3120d2022e43d75b515ca3aaa55842db5fd70924132', '[\"*\"]', '2025-12-10 17:41:47', NULL, '2025-12-03 15:01:03', '2025-12-10 17:41:47'),
(11, 'App\\Models\\User', 8, 'auth_token', '4879d6012212fd37a8280359118cedb2b58dd90883bace7c8be70cd5c9c7453c', '[\"*\"]', NULL, NULL, '2025-12-03 17:32:08', '2025-12-03 17:32:08'),
(12, 'App\\Models\\User', 9, 'auth_token', '6b0859d17bde1ae2634a052c84af302bfc060df40ec289b496ad24ce8a8ea078', '[\"*\"]', '2025-12-05 14:48:35', NULL, '2025-12-03 18:46:24', '2025-12-05 14:48:35'),
(13, 'App\\Models\\User', 10, 'auth_token', 'ff3ae147f8916c31c5783e2c846b63b3f038b193de8ea8b0522d4dceed0b1fee', '[\"*\"]', NULL, NULL, '2025-12-03 19:33:53', '2025-12-03 19:33:53'),
(14, 'App\\Models\\User', 11, 'auth_token', 'd03731b3233273ef79b5e4f4b26d1833f4a3cb087fb38823c5dc8c06412972c0', '[\"*\"]', NULL, NULL, '2025-12-03 20:43:27', '2025-12-03 20:43:27'),
(15, 'App\\Models\\User', 12, 'auth_token', 'c2fea541b54950694806190581060517cbdd8ce3bc7e0e579b7b551beded99fa', '[\"*\"]', '2026-01-08 15:20:12', NULL, '2025-12-03 21:34:08', '2026-01-08 15:20:12'),
(16, 'App\\Models\\User', 13, 'auth_token', 'b29a71012e2e5279e2863400ed40dfe29e6ebbb47779fd0b8208307725c103fc', '[\"*\"]', '2025-12-03 22:55:02', NULL, '2025-12-03 21:36:19', '2025-12-03 22:55:02'),
(17, 'App\\Models\\User', 3, 'auth_token', '4dfaf022a1021917081ff3ed6f29fa3285ae6b822fe114c95c8126b226ff2583', '[\"*\"]', '2025-12-05 01:37:49', NULL, '2025-12-03 22:23:14', '2025-12-05 01:37:49'),
(18, 'App\\Models\\User', 14, 'auth_token', '6f309b51605f3bbe89f1beff52ca4ca8d638ad3d2777f86165a2cfd64610e28b', '[\"*\"]', '2025-12-09 07:34:14', NULL, '2025-12-03 22:41:46', '2025-12-09 07:34:14'),
(19, 'App\\Models\\User', 15, 'auth_token', '37d21aaa4de5e4ee20da3022797c12cb20ed1818f0f78e60c513707d4ea959ef', '[\"*\"]', NULL, NULL, '2025-12-03 23:26:31', '2025-12-03 23:26:31'),
(20, 'App\\Models\\User', 16, 'auth_token', 'fd27d60bed6b2dee449750d4d91b8f2ce7958938e46e82776382ec56882bcff1', '[\"*\"]', '2026-01-13 16:33:00', NULL, '2025-12-04 00:22:50', '2026-01-13 16:33:00'),
(21, 'App\\Models\\User', 17, 'auth_token', '486337fe7c3dfac6e7b8df2ca10a3a8e2486f20ddfd74fb353ac701f06ea4c23', '[\"*\"]', NULL, NULL, '2025-12-04 00:49:57', '2025-12-04 00:49:57'),
(22, 'App\\Models\\User', 18, 'auth_token', 'fbeade369891dd6a1accfcc117496a7607a4743b1cc611460a13bed1413aae33', '[\"*\"]', NULL, NULL, '2025-12-04 01:24:01', '2025-12-04 01:24:01'),
(23, 'App\\Models\\User', 19, 'auth_token', 'c3863d0fd7381c14eccf031fb672d359be261c0a027d3e13e1a1db26b2dd2289', '[\"*\"]', '2025-12-15 17:01:52', NULL, '2025-12-04 01:31:07', '2025-12-15 17:01:52'),
(24, 'App\\Models\\User', 20, 'auth_token', '340ee2d2dae61c355d0d278fb6a8f1423791b5f00b925d6801c7839f94be2ca6', '[\"*\"]', '2025-12-24 18:18:54', NULL, '2025-12-04 01:53:46', '2025-12-24 18:18:54'),
(25, 'App\\Models\\User', 21, 'auth_token', '95ce0a436e3dea73205da9451004eda00ead90a57c529b508296e2c5ad0058e9', '[\"*\"]', NULL, NULL, '2025-12-04 02:21:52', '2025-12-04 02:21:52'),
(26, 'App\\Models\\User', 22, 'auth_token', 'bb278fe103f46b4bbddb80077284ba60e9a4c4ed4a85539e8fb8146e74d4d7a5', '[\"*\"]', '2025-12-04 15:57:53', NULL, '2025-12-04 02:34:02', '2025-12-04 15:57:53'),
(27, 'App\\Models\\User', 23, 'auth_token', '9321e34d1bde1a33408ef3770b25f2e45c5999590b015e2b07e47b4e9382ad43', '[\"*\"]', NULL, NULL, '2025-12-04 02:38:09', '2025-12-04 02:38:09'),
(30, 'App\\Models\\User', 26, 'auth_token', '42e24e84d4f6a48485ab7820dbe5e1746c00a16cad75a17b96e075b7a0289afd', '[\"*\"]', '2025-12-22 17:47:59', NULL, '2025-12-04 12:05:02', '2025-12-22 17:47:59'),
(31, 'App\\Models\\User', 27, 'auth_token', '6e67c3c7dcfe3dce050c49dea6ad5a0410f86da4b6a8cc2b7351b4be9a087d22', '[\"*\"]', '2026-01-20 21:48:05', NULL, '2025-12-04 12:14:16', '2026-01-20 21:48:05'),
(32, 'App\\Models\\User', 16, 'auth_token', 'f6b3361f604b4ed8f7c75e7b57790239158a3cb8e44e52ede0bbecb0ea39581d', '[\"*\"]', '2025-12-12 16:50:22', NULL, '2025-12-04 13:18:17', '2025-12-12 16:50:22'),
(33, 'App\\Models\\User', 26, 'auth_token', '7627214ce3b56d2cf123b8b3e1ce5ef666d1bd201b5f7b22506db6f373422d32', '[\"*\"]', NULL, NULL, '2025-12-04 13:23:38', '2025-12-04 13:23:38'),
(34, 'App\\Models\\User', 28, 'auth_token', '6cdd1eb9aceea20e2024ebc6661f3582f2de6d05788d9c6624b61d31451fbe49', '[\"*\"]', '2025-12-04 14:14:01', NULL, '2025-12-04 13:52:23', '2025-12-04 14:14:01'),
(36, 'App\\Models\\User', 29, 'auth_token', 'bb10afdafa5ebb28a14a152e6988c8f2b6acd46445efba6f7a3ed57ccbffc469', '[\"*\"]', NULL, NULL, '2025-12-04 18:41:18', '2025-12-04 18:41:18'),
(37, 'App\\Models\\User', 30, 'auth_token', '9893ebf730b140b0e6781b6794ce0c7dad4297ff3a5a688546b85b4f8808644f', '[\"*\"]', '2025-12-05 17:45:03', NULL, '2025-12-04 19:17:05', '2025-12-05 17:45:03'),
(38, 'App\\Models\\User', 31, 'auth_token', '0a95863c7b0d7937e8aea4dd7483704ffcf8afe6bf857429f8bee6e132030ac6', '[\"*\"]', NULL, NULL, '2025-12-04 19:39:34', '2025-12-04 19:39:34'),
(39, 'App\\Models\\User', 32, 'auth_token', '7d64404ff61c109d109260bdec80ac699b29e6f14a9e2fae7c3d687f2ce06352', '[\"*\"]', '2026-01-22 14:23:33', NULL, '2025-12-04 19:58:06', '2026-01-22 14:23:33'),
(40, 'App\\Models\\User', 33, 'auth_token', 'fafe07914d7695c0d8d4d6bcce335c86d74743e03af5620e674613a9922da600', '[\"*\"]', NULL, NULL, '2025-12-05 08:52:21', '2025-12-05 08:52:21'),
(41, 'App\\Models\\User', 34, 'auth_token', '5fbd81ae7baf4d6f1c2a90a04fd37592550c85e9e24bcf3388c1ad4f46054a92', '[\"*\"]', '2025-12-05 12:12:45', NULL, '2025-12-05 12:12:12', '2025-12-05 12:12:45'),
(43, 'App\\Models\\User', 35, 'auth_token', '7366795ec6fb57ce006d25e158b410a15e80bcc8d72769e28baf7b9cc30005c2', '[\"*\"]', NULL, NULL, '2025-12-05 17:33:51', '2025-12-05 17:33:51'),
(44, 'App\\Models\\User', 13, 'auth_token', '296bb0f751a6d9a684a9bf04142e4a2fa64a50c03276469dbf0ed2d423d135cc', '[\"*\"]', '2025-12-06 02:49:33', NULL, '2025-12-05 17:47:00', '2025-12-06 02:49:33'),
(45, 'App\\Models\\User', 37, 'auth_token', 'f4e50539039aab56f8d4c171ee10e61899687e757857c420760c5fe2a38a34e2', '[\"*\"]', '2025-12-27 16:22:32', NULL, '2025-12-06 02:19:40', '2025-12-27 16:22:32'),
(46, 'App\\Models\\User', 38, 'auth_token', 'e92ab6097edd7a1be38ac2191e88f2534a3d8e1b5c1e8ebc5ef32746dd45f7e4', '[\"*\"]', '2025-12-07 06:20:29', NULL, '2025-12-07 00:36:41', '2025-12-07 06:20:29'),
(47, 'App\\Models\\User', 39, 'auth_token', 'b841845c8817c6566a38ce56e0940db48b42f4295ceea7fe9a55f2bbd475590e', '[\"*\"]', '2025-12-07 01:00:59', NULL, '2025-12-07 00:42:13', '2025-12-07 01:00:59'),
(48, 'App\\Models\\User', 40, 'auth_token', 'bc5703c3d8a742f088b9a4251ebfdb4da636335936b75fbd569dd46934e84aa7', '[\"*\"]', '2025-12-26 20:56:41', NULL, '2025-12-07 00:42:24', '2025-12-26 20:56:41'),
(49, 'App\\Models\\User', 42, 'auth_token', 'b383da3efa23d20ed4843b5ea76126413f0cec7c7c774acb80248dd020b8b37c', '[\"*\"]', '2025-12-07 04:33:31', NULL, '2025-12-07 01:05:45', '2025-12-07 04:33:31'),
(50, 'App\\Models\\User', 43, 'auth_token', '58404a0775f32678e90d39cb02bef891a0173e32124a1034b5b69f4ce2a55db2', '[\"*\"]', NULL, NULL, '2025-12-07 01:07:16', '2025-12-07 01:07:16'),
(51, 'App\\Models\\User', 44, 'auth_token', '256f5b7dd1688214c291b2a9d8abb3b59ce7474bf38cb94ceedb8a7fd76ba16c', '[\"*\"]', NULL, NULL, '2025-12-07 01:11:57', '2025-12-07 01:11:57'),
(52, 'App\\Models\\User', 45, 'auth_token', '46324d840a976ed6f632b007998e04d914c1f931ba09be39aa082386089aa1c0', '[\"*\"]', NULL, NULL, '2025-12-07 01:50:04', '2025-12-07 01:50:04'),
(53, 'App\\Models\\User', 46, 'auth_token', '073aadb33a3f3b55b2cd9076904e155456b45416e54f08a94eeb7f23fbea4572', '[\"*\"]', NULL, NULL, '2025-12-07 02:18:25', '2025-12-07 02:18:25'),
(55, 'App\\Models\\User', 47, 'auth_token', '41993f5cc8f3bbfe0ffddb7a23ebf19e019803d0890ab5fde3d4e4146dd1226d', '[\"*\"]', NULL, NULL, '2025-12-07 15:17:29', '2025-12-07 15:17:29'),
(56, 'App\\Models\\User', 48, 'auth_token', 'f13b825f075b0b6bfca94068b836383f1e127cae0d17ebf8ed88bbad581cc5d2', '[\"*\"]', '2026-01-13 16:31:51', NULL, '2025-12-07 23:37:26', '2026-01-13 16:31:51'),
(57, 'App\\Models\\User', 49, 'auth_token', 'f19a1a27bb96c265f84bf85e98ad422fc1f9d0416dca799bb78c64c3b79c02a6', '[\"*\"]', '2025-12-19 18:55:30', NULL, '2025-12-08 00:55:25', '2025-12-19 18:55:30'),
(58, 'App\\Models\\User', 50, 'auth_token', '347640283c44ad28ddadf001234b4f8590da686ed8960497144696d996f918bf', '[\"*\"]', NULL, NULL, '2025-12-08 12:12:10', '2025-12-08 12:12:10'),
(59, 'App\\Models\\User', 51, 'auth_token', '1b0d4f0dddea7507b603eda668d7ace8f997041cdf8b0eb7886aaec7f8eea17b', '[\"*\"]', NULL, NULL, '2025-12-08 15:55:05', '2025-12-08 15:55:05'),
(60, 'App\\Models\\User', 52, 'auth_token', '4b0b4e672edbbce95e9496c202771d33da90e6552ad1d2998187ed798c0e6037', '[\"*\"]', '2025-12-09 13:33:25', NULL, '2025-12-08 16:06:06', '2025-12-09 13:33:25'),
(61, 'App\\Models\\User', 53, 'auth_token', '3d25791e1864160b3dbb08396bc95e3ffa910b19e8d4d2b7a79119afda646cd3', '[\"*\"]', '2025-12-09 01:36:01', NULL, '2025-12-09 01:33:53', '2025-12-09 01:36:01'),
(62, 'App\\Models\\User', 54, 'auth_token', 'fc9b3faa4342b26872fea0f5b0a75ca1c0d8777683d0132b761bc8e0a288f604', '[\"*\"]', '2025-12-15 00:00:33', NULL, '2025-12-09 01:35:05', '2025-12-15 00:00:33'),
(63, 'App\\Models\\User', 5, 'auth_token', 'aa8fa7098eab58c93e1cb3f93241b81418ed2da3e5b74940681fb6c93e1c6d3e', '[\"*\"]', '2025-12-18 20:48:23', NULL, '2025-12-09 10:31:22', '2025-12-18 20:48:23'),
(64, 'App\\Models\\User', 55, 'auth_token', 'c72a67c4a25af49ae3da410e3a27e8b4e92ec67fb28e30580dab2776e3f460b9', '[\"*\"]', '2025-12-09 16:25:58', NULL, '2025-12-09 10:39:31', '2025-12-09 16:25:58'),
(65, 'App\\Models\\User', 56, 'auth_token', 'e224062540f325113c42d1b09beeede72e7ce288433be89bb68ef1f261c20a21', '[\"*\"]', NULL, NULL, '2025-12-09 14:51:44', '2025-12-09 14:51:44'),
(66, 'App\\Models\\User', 57, 'auth_token', '281365e9383c0306f57da421d3e082173d119ed50ed352bc8103aa2a1038c134', '[\"*\"]', '2026-01-05 04:24:14', NULL, '2025-12-09 19:37:14', '2026-01-05 04:24:14'),
(67, 'App\\Models\\User', 59, 'auth_token', 'c47021b999e06a20179c9c2c2f13b61a74ed693abaee6237bfe6209654d0edb6', '[\"*\"]', '2026-01-07 00:24:21', NULL, '2025-12-10 01:21:48', '2026-01-07 00:24:21'),
(68, 'App\\Models\\User', 60, 'auth_token', '2b209a978215b5ad4e00b433568dad019d17060392f094d57dd1cb5f4e9aeac5', '[\"*\"]', '2025-12-17 17:42:16', NULL, '2025-12-10 09:54:31', '2025-12-17 17:42:16'),
(69, 'App\\Models\\User', 61, 'auth_token', '45a7e0fe77803c41a47863ef9cb2ce33560b015082efd2a1f083df21a76335f2', '[\"*\"]', '2025-12-10 11:17:35', NULL, '2025-12-10 11:13:41', '2025-12-10 11:17:35'),
(70, 'App\\Models\\User', 62, 'auth_token', 'a05cadfe4dc16b5174789772a689f7f84ff6fbc865168bfa68765eb69c8e85f0', '[\"*\"]', '2025-12-12 15:00:13', NULL, '2025-12-10 18:03:42', '2025-12-12 15:00:13'),
(71, 'App\\Models\\User', 63, 'auth_token', '366dd7e7c1f812ee60034a4900abc293d7a9bdb9c6132248d4ce54e3c8f9eef5', '[\"*\"]', '2025-12-11 17:19:42', NULL, '2025-12-10 23:45:22', '2025-12-11 17:19:42'),
(72, 'App\\Models\\User', 64, 'auth_token', '542bc2b8e01dbaa1208f0fc34d2d112a6e735b0c54dfe0a2d507ebdd4cc5d2eb', '[\"*\"]', NULL, NULL, '2025-12-11 02:04:40', '2025-12-11 02:04:40'),
(73, 'App\\Models\\User', 66, 'auth_token', '7a6b5bc18ed722e21cac2c298b48094a4d2149dd786e4c546db1cdf4d4de3506', '[\"*\"]', NULL, NULL, '2025-12-11 21:41:32', '2025-12-11 21:41:32'),
(74, 'App\\Models\\User', 67, 'auth_token', 'f1668d51a457c76daa830ba67ac8f6ab97761e2495122ac9633bec6d57c4808c', '[\"*\"]', NULL, NULL, '2025-12-12 01:56:55', '2025-12-12 01:56:55'),
(75, 'App\\Models\\User', 68, 'auth_token', 'b1f613dca5d586ee4da2840c14cb062a0f998743a8f49b2d1ef20c7519decd3a', '[\"*\"]', NULL, NULL, '2025-12-12 08:37:36', '2025-12-12 08:37:36'),
(77, 'App\\Models\\User', 69, 'auth_token', 'b950ed9dcab245d3a43e4689664b6c7e54cf6b0805ffe7e368a528296bd926d9', '[\"*\"]', '2025-12-25 07:08:17', NULL, '2025-12-12 12:17:56', '2025-12-25 07:08:17'),
(78, 'App\\Models\\User', 69, 'auth_token', '3ef046bf71dd2908a94a8c94d0a8cc80f31fa5d89ce146d6304c88105ca45024', '[\"*\"]', '2025-12-12 22:57:59', NULL, '2025-12-12 14:05:25', '2025-12-12 22:57:59'),
(79, 'App\\Models\\User', 70, 'auth_token', '61c9a43db21c0a4dbe732ca6eed66103e339cbd86f08327652ada3d41a1ab060', '[\"*\"]', '2026-01-01 09:32:08', NULL, '2025-12-12 18:55:50', '2026-01-01 09:32:08'),
(80, 'App\\Models\\User', 71, 'auth_token', 'acf3766e399bf88fbe9a273495689f5a0ebf8433d64dae1bf22db05b7fe37c9c', '[\"*\"]', '2025-12-15 18:12:56', NULL, '2025-12-13 17:15:38', '2025-12-15 18:12:56'),
(81, 'App\\Models\\User', 13, 'auth_token', '69f2831498b35acf8780a5b38565e5110c5790d13f32c831a48dbc1b057a5846', '[\"*\"]', NULL, NULL, '2025-12-13 17:30:39', '2025-12-13 17:30:39'),
(82, 'App\\Models\\User', 72, 'auth_token', 'c6fff6a457a0042fc125db1ab1015287089b128bd7acc96005e9e83b52e02f09', '[\"*\"]', '2025-12-19 09:17:01', NULL, '2025-12-14 01:14:01', '2025-12-19 09:17:01'),
(83, 'App\\Models\\User', 73, 'auth_token', '5eeb760636c24d0dbc9154bd449bce931be2b3b7d5658d6fd528dc0e4e9df938', '[\"*\"]', NULL, NULL, '2025-12-14 21:41:46', '2025-12-14 21:41:46'),
(84, 'App\\Models\\User', 74, 'auth_token', '54687cae1ff270890ff7f1ae30defa76b003fb74585c10e2ec1b4e3b488baf12', '[\"*\"]', '2025-12-15 03:41:40', NULL, '2025-12-14 21:56:56', '2025-12-15 03:41:40'),
(85, 'App\\Models\\User', 75, 'auth_token', '85982f566b8d661613e352ca6cdf8d752f55b1929bd559c6786922e8a6c39027', '[\"*\"]', NULL, NULL, '2025-12-14 22:20:20', '2025-12-14 22:20:20'),
(86, 'App\\Models\\User', 76, 'auth_token', 'e37fda583b80764b4f3f35dc338426d934b8260c8aa90bbd4cc91c820f313929', '[\"*\"]', NULL, NULL, '2025-12-14 22:30:24', '2025-12-14 22:30:24'),
(87, 'App\\Models\\User', 77, 'auth_token', '17fd1178d1d3ffee90886cd3619ea12183b683715eec39ccc9daf5c3ffbc5309', '[\"*\"]', NULL, NULL, '2025-12-14 23:06:26', '2025-12-14 23:06:26'),
(88, 'App\\Models\\User', 78, 'auth_token', '7a088a03ede515f8f018b0db0a454e28cf7a0f64b8fb0178111280b2ffc7bdf3', '[\"*\"]', '2025-12-14 23:18:03', NULL, '2025-12-14 23:17:20', '2025-12-14 23:18:03'),
(89, 'App\\Models\\User', 79, 'auth_token', '10848dfde32d07753c342e314ba27bf5ebfa7f55f6d25b5298885b5a4a401dd0', '[\"*\"]', NULL, NULL, '2025-12-15 00:49:40', '2025-12-15 00:49:40'),
(90, 'App\\Models\\User', 80, 'auth_token', '1d8cd46e277cabc19a125de9f050756fbb21c8581a46838aa59056b46d79346d', '[\"*\"]', '2025-12-15 13:51:53', NULL, '2025-12-15 13:51:34', '2025-12-15 13:51:53'),
(91, 'App\\Models\\User', 81, 'auth_token', '1a9c822f3c8de9dec71670154e0103dec6398e02e24e8a2e9c98eb351440d349', '[\"*\"]', '2025-12-21 20:51:01', NULL, '2025-12-15 16:40:44', '2025-12-21 20:51:01'),
(92, 'App\\Models\\User', 82, 'auth_token', '162657dd1a7b96b6d5a5874ecaa41607aac5dc0921dd7d476cb0578b0637df4b', '[\"*\"]', NULL, NULL, '2025-12-15 18:41:59', '2025-12-15 18:41:59'),
(93, 'App\\Models\\User', 19, 'auth_token', '92189e816ecfb976070665162122e304b696e8a353d6e2e9dbc2e0ae74c71274', '[\"*\"]', '2025-12-15 18:54:59', NULL, '2025-12-15 18:45:51', '2025-12-15 18:54:59'),
(94, 'App\\Models\\User', 84, 'auth_token', '2c5ef8e21bcc8524260d0b7c0f208b9a747786ce6e34b59dfd8bd69b349137b2', '[\"*\"]', NULL, NULL, '2025-12-15 19:57:09', '2025-12-15 19:57:09'),
(95, 'App\\Models\\User', 85, 'auth_token', '773cfff701d497bfae998feff699469c0a73ca639a9afbdcbfbef304fff5727c', '[\"*\"]', '2025-12-16 17:40:55', NULL, '2025-12-15 20:04:04', '2025-12-16 17:40:55'),
(96, 'App\\Models\\User', 86, 'auth_token', '36ed6e71573cc540121b1905eaded82ef8a80b81ef6f92057fe64d2d3a7a5ebe', '[\"*\"]', '2025-12-23 15:39:48', NULL, '2025-12-15 21:04:26', '2025-12-23 15:39:48'),
(97, 'App\\Models\\User', 19, 'auth_token', '7e56de123846f6c54db84fef14926e0e7a25b114969597f4892dffa3a1901fa4', '[\"*\"]', '2025-12-16 12:15:18', NULL, '2025-12-15 21:33:31', '2025-12-16 12:15:18'),
(98, 'App\\Models\\User', 87, 'auth_token', 'cd891656e901e6ffb097f2442f1a776abe78d507c40d1daae8b33739d7691352', '[\"*\"]', NULL, NULL, '2025-12-16 00:30:20', '2025-12-16 00:30:20'),
(99, 'App\\Models\\User', 88, 'auth_token', 'a255ead5929524fe210af2c9ff010fbdbcf4d6f94358ebd5719cb7b6b3747c6a', '[\"*\"]', '2025-12-16 00:31:03', NULL, '2025-12-16 00:30:23', '2025-12-16 00:31:03'),
(100, 'App\\Models\\User', 89, 'auth_token', '26f9d00c7986457758190b2b209a48162abf03b6955684fa2d911be120a29e33', '[\"*\"]', '2025-12-16 00:35:40', NULL, '2025-12-16 00:34:01', '2025-12-16 00:35:40'),
(101, 'App\\Models\\User', 91, 'auth_token', 'ac94df900b4ffdefadd9cf020c55873cf3fe48d46819706fa71902ad9e51a28a', '[\"*\"]', NULL, NULL, '2025-12-16 00:34:29', '2025-12-16 00:34:29'),
(102, 'App\\Models\\User', 90, 'auth_token', '291d0ec5dddd0b2b6637ddff61b3254098b7d506ea03d5968abeef3f92ec19dc', '[\"*\"]', NULL, NULL, '2025-12-16 00:38:09', '2025-12-16 00:38:09'),
(103, 'App\\Models\\User', 92, 'auth_token', '8556fe52aba25cfb3a87fdd608fc7dbbb93cc5f963e0f9568b7a5451cb48370d', '[\"*\"]', '2025-12-16 02:54:15', NULL, '2025-12-16 00:42:46', '2025-12-16 02:54:15'),
(104, 'App\\Models\\User', 93, 'auth_token', '1f58a099fbafb239ff4f10ffc0fee1de418673da9ca03591490c34f19602002d', '[\"*\"]', NULL, NULL, '2025-12-16 00:43:48', '2025-12-16 00:43:48'),
(105, 'App\\Models\\User', 95, 'auth_token', 'fe9ba303246d51e48a59c71eccb5b67c9ebe44c169530093862de5aafbdc954b', '[\"*\"]', NULL, NULL, '2025-12-16 00:49:05', '2025-12-16 00:49:05'),
(106, 'App\\Models\\User', 98, 'auth_token', '8b363643b9797ff2423f19cc3e46af5d79536990260cf012300d9f8ffb2d18d2', '[\"*\"]', '2025-12-16 02:38:52', NULL, '2025-12-16 00:54:06', '2025-12-16 02:38:52'),
(107, 'App\\Models\\User', 97, 'auth_token', '0c5183265f1596d2d610e330231cb035fae8ca258433b0a138ab09eed7b9023f', '[\"*\"]', '2025-12-16 04:07:21', NULL, '2025-12-16 00:54:52', '2025-12-16 04:07:21'),
(108, 'App\\Models\\User', 99, 'auth_token', '6f7dbc989d5037c1c316db5c6fbb0ed955ff2b84dbd1667889aeaa1dd006ecc0', '[\"*\"]', NULL, NULL, '2025-12-16 01:00:45', '2025-12-16 01:00:45'),
(109, 'App\\Models\\User', 100, 'auth_token', 'f00225ebd53a5ba5abf7007ee61a5f736d40d6356c33bb251f05c430c63f9917', '[\"*\"]', '2025-12-29 22:31:33', NULL, '2025-12-16 01:01:15', '2025-12-29 22:31:33'),
(110, 'App\\Models\\User', 101, 'auth_token', '629f6efc393bb9969de90c5aea1c070c7fb0c5311e322b9a416f027d41403399', '[\"*\"]', '2025-12-16 08:11:23', NULL, '2025-12-16 01:22:49', '2025-12-16 08:11:23'),
(111, 'App\\Models\\User', 103, 'auth_token', 'dfe81f6c9db2f054a8495c83549a30e18dacae3d6377dfdc4ce268e6ce247057', '[\"*\"]', '2025-12-17 21:10:19', NULL, '2025-12-16 02:07:53', '2025-12-17 21:10:19'),
(112, 'App\\Models\\User', 104, 'auth_token', 'd02a1d2c3229f2cc6a0fc1ccb8190be589a842c9977c3dfb4c5fcbc510b01d60', '[\"*\"]', NULL, NULL, '2025-12-16 02:14:30', '2025-12-16 02:14:30'),
(113, 'App\\Models\\User', 105, 'auth_token', '4231cfa22580155e2eaf875f3007c8c970f5e7908a6750bc7a9f42c2775c9da7', '[\"*\"]', '2025-12-16 06:48:35', NULL, '2025-12-16 06:47:52', '2025-12-16 06:48:35'),
(114, 'App\\Models\\User', 106, 'auth_token', '3d42c9bf548bc532fe0b60394212540bb78757ed5d40636773d27838aba0521b', '[\"*\"]', NULL, NULL, '2025-12-16 12:10:34', '2025-12-16 12:10:34'),
(115, 'App\\Models\\User', 87, 'auth_token', 'e175cad26c4260de32e8cd4478ec233be7b13cee14dcffeb35807866bf1c5ec9', '[\"*\"]', NULL, NULL, '2025-12-16 12:15:53', '2025-12-16 12:15:53'),
(116, 'App\\Models\\User', 107, 'auth_token', 'a8b5ddd240584548da330bdcf1081df5328922015bcca46feb8873dabea898fe', '[\"*\"]', NULL, NULL, '2025-12-16 12:30:10', '2025-12-16 12:30:10'),
(117, 'App\\Models\\User', 111, 'auth_token', 'e54b0118998b85909a01843391b385218369f6b3f563dc7745dfb748b86b6d28', '[\"*\"]', NULL, NULL, '2025-12-16 12:41:52', '2025-12-16 12:41:52'),
(118, 'App\\Models\\User', 112, 'auth_token', 'df723eddc2a661cadff78c206603ec456bd73bceaa41b72f3d69be6d0d03d13f', '[\"*\"]', '2025-12-18 23:45:20', NULL, '2025-12-16 12:42:02', '2025-12-18 23:45:20'),
(119, 'App\\Models\\User', 19, 'auth_token', '948e4d71826fb98c03bea24e548944feed87214707f89c4c989e145449dba9e7', '[\"*\"]', '2025-12-20 00:50:39', NULL, '2025-12-16 12:46:16', '2025-12-20 00:50:39'),
(120, 'App\\Models\\User', 113, 'auth_token', '0723af882703593340c2fc264f879ce83a1b99ca8add38d30288cf38da08f0da', '[\"*\"]', '2025-12-29 12:55:57', NULL, '2025-12-16 12:52:40', '2025-12-29 12:55:57'),
(121, 'App\\Models\\User', 114, 'auth_token', 'ecb3504c5599dbc151fcc66fb9a2778de028886a07b3ff4e37d8ead33397ab63', '[\"*\"]', NULL, NULL, '2025-12-16 12:58:40', '2025-12-16 12:58:40'),
(122, 'App\\Models\\User', 115, 'auth_token', '354b6a0b122f17321e2f433a8314c88c0219f670e6af401118e316ead8dd507f', '[\"*\"]', NULL, NULL, '2025-12-16 13:01:19', '2025-12-16 13:01:19'),
(123, 'App\\Models\\User', 116, 'auth_token', 'c577a08c08980380b0ee5653ba33e10ed4d49c75a2b64f5142f3d05c5ced8b26', '[\"*\"]', NULL, NULL, '2025-12-16 13:12:12', '2025-12-16 13:12:12'),
(124, 'App\\Models\\User', 117, 'auth_token', '7b4aa7b093fecd45e50fa6b0a63e42c68bd5fd257f9cbe767b87ce560c32ebe9', '[\"*\"]', NULL, NULL, '2025-12-16 13:28:29', '2025-12-16 13:28:29'),
(125, 'App\\Models\\User', 118, 'auth_token', 'f95daa1c0fef3e9a4d95041fae2108c559256647d39dbaa89b5914e5493093ad', '[\"*\"]', '2025-12-16 17:03:17', NULL, '2025-12-16 14:19:49', '2025-12-16 17:03:17'),
(126, 'App\\Models\\User', 120, 'auth_token', 'f813e2b591d36c22c1e45a6e1e8f6c9e0511819b344957c1d75eda965396b104', '[\"*\"]', '2025-12-16 17:38:08', NULL, '2025-12-16 14:23:21', '2025-12-16 17:38:08'),
(127, 'App\\Models\\User', 121, 'auth_token', 'ba0e9e8a4c16c2f92a5ea3427cee2eb6a2df7b945ac07e81ac7e804c877284cf', '[\"*\"]', '2025-12-18 13:49:19', NULL, '2025-12-16 14:31:27', '2025-12-18 13:49:19'),
(128, 'App\\Models\\User', 122, 'auth_token', '25d41f565dbee8ba9aa3b9fc7d6b221e282e750c460cc6858455f0eaf252cbd1', '[\"*\"]', NULL, NULL, '2025-12-16 14:44:11', '2025-12-16 14:44:11'),
(129, 'App\\Models\\User', 123, 'auth_token', 'c1b67f54a13ac1f4ddd8858fd8eaa0c7429eb77d7f4db24afc0a670b3c36356b', '[\"*\"]', '2025-12-16 15:05:13', NULL, '2025-12-16 15:04:53', '2025-12-16 15:05:13'),
(130, 'App\\Models\\User', 124, 'auth_token', '37681e2a121600e77574236a20b091b5d278430e7221cc77f5200ddf1f76ae0b', '[\"*\"]', NULL, NULL, '2025-12-16 15:13:49', '2025-12-16 15:13:49'),
(131, 'App\\Models\\User', 125, 'auth_token', '200abd51520d7fab526dd69682dce318120baa63a3a49cc241b955378d2d57c9', '[\"*\"]', NULL, NULL, '2025-12-16 15:21:27', '2025-12-16 15:21:27'),
(132, 'App\\Models\\User', 126, 'auth_token', 'dcb1bca50d6f2d06940d0228d3d8f1efc3594d0148c082ec534ea83074ba74b9', '[\"*\"]', '2025-12-20 15:37:22', NULL, '2025-12-16 15:30:45', '2025-12-20 15:37:22'),
(133, 'App\\Models\\User', 127, 'auth_token', '6ed9226c27e50afd93e2d7f5138057752c8c616b7bb4a8865b4ead8bb80a6fbe', '[\"*\"]', NULL, NULL, '2025-12-16 16:25:57', '2025-12-16 16:25:57'),
(134, 'App\\Models\\User', 130, 'auth_token', '1a78a157b92e8b26fcde60395077e379e2c88bce0ea2fe51ed1bc749eea5a384', '[\"*\"]', '2026-01-06 12:13:55', NULL, '2025-12-16 17:41:40', '2026-01-06 12:13:55'),
(136, 'App\\Models\\User', 131, 'auth_token', '4fd9ee9cd9a7f4ae96efc40167b5b7ab7feec52b2de318121cecf7de618acea2', '[\"*\"]', NULL, NULL, '2025-12-16 20:49:37', '2025-12-16 20:49:37'),
(137, 'App\\Models\\User', 132, 'password_reset', 'e4458213c370fed213952e50966f4714d79341f38e881a0375b0e021275b553c', '[\"password-reset\"]', NULL, '2025-12-16 22:13:39', '2025-12-16 21:43:39', '2025-12-16 21:43:39'),
(138, 'App\\Models\\User', 132, 'password_reset', '6176450704f66a788983a9b5f594d67a9461a39862c5c8c92d1d3562f443a190', '[\"password-reset\"]', NULL, '2025-12-16 22:14:40', '2025-12-16 21:44:40', '2025-12-16 21:44:40'),
(139, 'App\\Models\\User', 132, 'password_reset', '01794580233151783c30ec53c44f1912c9ebad47c7b9359d9031871614ddd0e7', '[\"password-reset\"]', NULL, '2025-12-16 22:14:54', '2025-12-16 21:44:54', '2025-12-16 21:44:54'),
(140, 'App\\Models\\User', 132, 'auth_token', '5848192980e0c565276968efe504bbbe65bb99a8fa1827506c1c7113122ad41a', '[\"*\"]', NULL, NULL, '2025-12-16 21:52:48', '2025-12-16 21:52:48'),
(141, 'App\\Models\\User', 133, 'auth_token', '40b2718c1ac4dce20702968582a7bab6fa453ea6d2a3741212c6efb518989b14', '[\"*\"]', NULL, NULL, '2025-12-16 22:24:28', '2025-12-16 22:24:28'),
(142, 'App\\Models\\User', 134, 'auth_token', '2d3f9071b14d1cfeb96dc88e9bb65b73196bca21321e133eaa6798e827cf251d', '[\"*\"]', '2025-12-16 22:40:03', NULL, '2025-12-16 22:32:34', '2025-12-16 22:40:03'),
(143, 'App\\Models\\User', 136, 'auth_token', '580e218593ef005468dd776c6b43aed0799a6bf845298000d086ce6e83248f83', '[\"*\"]', '2025-12-17 19:53:45', NULL, '2025-12-16 22:43:13', '2025-12-17 19:53:45'),
(144, 'App\\Models\\User', 138, 'auth_token', 'b88f4e7dea16b6c7fda5d59b57abfbc3fdbd005a102d0a000b99020b8eb49b2e', '[\"*\"]', '2025-12-16 23:07:09', NULL, '2025-12-16 23:02:09', '2025-12-16 23:07:09'),
(145, 'App\\Models\\User', 139, 'auth_token', 'b66f08f0529c8e7f76c692c629ae0a35e0cfbe5bb11ab2ee38d9c6ef7d2a3a47', '[\"*\"]', '2025-12-16 23:11:20', NULL, '2025-12-16 23:06:23', '2025-12-16 23:11:20'),
(146, 'App\\Models\\User', 140, 'auth_token', 'cbaabb1c4d2680f9114e05cc5240df459e8d72c01a94d92c83f3e41dabcc4c0b', '[\"*\"]', '2025-12-17 22:36:25', NULL, '2025-12-16 23:27:04', '2025-12-17 22:36:25'),
(147, 'App\\Models\\User', 141, 'auth_token', '7fb8309e6926cce073f29f7b36d127b2a4294b765b2c2e71d8c775c6b345d4fe', '[\"*\"]', NULL, NULL, '2025-12-16 23:33:31', '2025-12-16 23:33:31'),
(148, 'App\\Models\\User', 142, 'auth_token', '7af40539dbeabde175fadc170da6a90fcf69a4a5d84092f3932634931b94862c', '[\"*\"]', NULL, NULL, '2025-12-16 23:34:31', '2025-12-16 23:34:31'),
(149, 'App\\Models\\User', 144, 'auth_token', '057cb86006d3e71f3de47c060b9867253e4e06a6006c2f3ff3225e698d5bf891', '[\"*\"]', '2025-12-17 02:44:40', NULL, '2025-12-17 01:05:39', '2025-12-17 02:44:40'),
(150, 'App\\Models\\User', 145, 'auth_token', '236e4c0198482c7d8135fb2d7a57d5012d4ed174ac28957b067458fc72e840c7', '[\"*\"]', NULL, NULL, '2025-12-17 01:19:38', '2025-12-17 01:19:38'),
(151, 'App\\Models\\User', 135, 'auth_token', 'dc775db76cadf021cb27e521e1bcd71ef3e65022f0e64ca9db51d044a6e45b52', '[\"*\"]', '2025-12-17 01:59:35', NULL, '2025-12-17 01:56:21', '2025-12-17 01:59:35'),
(152, 'App\\Models\\User', 146, 'auth_token', '43f69e718f712c04f5ff00480bc6c2ac00054fba572bd911455bf2c208dab498', '[\"*\"]', '2025-12-17 17:49:56', NULL, '2025-12-17 02:03:09', '2025-12-17 17:49:56'),
(153, 'App\\Models\\User', 147, 'auth_token', '97597a947379f35103ca04698c0546dfffe6d8c48f2595609eee3089cd2f88db', '[\"*\"]', NULL, NULL, '2025-12-17 03:32:40', '2025-12-17 03:32:40'),
(154, 'App\\Models\\User', 148, 'auth_token', '662217edd7021a7324c4c82e014220aecab382eb64b730e202027c4e1174bf58', '[\"*\"]', NULL, NULL, '2025-12-17 08:18:11', '2025-12-17 08:18:11'),
(155, 'App\\Models\\User', 149, 'password_reset', '2b4ddb4e117aad36ef9abce18fff1e58673350c03491bd4ca63fb4230aff2b80', '[\"password-reset\"]', NULL, '2025-12-17 19:40:15', '2025-12-17 19:10:15', '2025-12-17 19:10:15'),
(157, 'App\\Models\\User', 149, 'password_reset', '5d3723ccdee75f44329a2cff250101ca2d5b78408097b518eb959d3b4f340672', '[\"password-reset\"]', NULL, '2025-12-17 19:40:25', '2025-12-17 19:10:25', '2025-12-17 19:10:25'),
(158, 'App\\Models\\User', 149, 'password_reset', 'fed63d28e849292a6be386f039008fd14abc2e8400bd8fd5e93f8e1e5f853f76', '[\"password-reset\"]', NULL, '2025-12-17 19:40:28', '2025-12-17 19:10:28', '2025-12-17 19:10:28'),
(159, 'App\\Models\\User', 150, 'auth_token', 'fb48b4d6a16f70a3a03cc9f629a60caa52e7413f241531b99d80a14fe8f1a8ee', '[\"*\"]', NULL, NULL, '2025-12-17 23:05:20', '2025-12-17 23:05:20'),
(160, 'App\\Models\\User', 151, 'auth_token', '2e76a9b17cfbb924de0bd1c73091408fef1ff192608d01d4a88a483ef1d7530c', '[\"*\"]', '2025-12-21 04:07:36', NULL, '2025-12-18 02:37:54', '2025-12-21 04:07:36'),
(161, 'App\\Models\\User', 152, 'auth_token', 'cfbceb4b6e7b14e248ce03494ffd8fe1ba37012e00fd2c19fb6cc0918c7dfc83', '[\"*\"]', '2025-12-23 15:19:30', NULL, '2025-12-18 19:32:18', '2025-12-23 15:19:30'),
(162, 'App\\Models\\User', 153, 'auth_token', '233129edfde6e8b671833878836c3429865ffec098ddf1e1898c8ce21d42d770', '[\"*\"]', '2025-12-24 12:58:56', NULL, '2025-12-18 20:00:23', '2025-12-24 12:58:56'),
(163, 'App\\Models\\User', 5, 'auth_token', 'bd4cc0724852d84cc8225fe6d944bb955988eddfaef6b25b5e313948200018f0', '[\"*\"]', '2026-01-13 16:32:05', NULL, '2025-12-19 15:50:49', '2026-01-13 16:32:05'),
(164, 'App\\Models\\User', 156, 'auth_token', 'bb702181e03b4dfea22ae0d010bf0a2066d326c6c65aee9009231573cd598c96', '[\"*\"]', NULL, NULL, '2025-12-20 13:49:01', '2025-12-20 13:49:01'),
(165, 'App\\Models\\User', 157, 'auth_token', '597b776bf1de9fa2611be603954cc496f18a03fc37d7ec721b0cbb698863a518', '[\"*\"]', NULL, NULL, '2025-12-20 14:56:47', '2025-12-20 14:56:47'),
(166, 'App\\Models\\User', 158, 'auth_token', '2b837f4897527aa224f3adae5f3a3f9a3145eac80d9b8c50ad40027331706c80', '[\"*\"]', '2026-01-04 04:41:06', NULL, '2025-12-20 17:08:41', '2026-01-04 04:41:06'),
(167, 'App\\Models\\User', 159, 'auth_token', '9120f4cef84f28d5846cec3713133e1d802653dad75b6b40e4685faf3c9d1023', '[\"*\"]', NULL, NULL, '2025-12-21 13:01:59', '2025-12-21 13:01:59'),
(168, 'App\\Models\\User', 69, 'auth_token', '6a1368aea2b3b003b073754b40a8ba9cf1954ed2baf8aa533352ed997bb3f74f', '[\"*\"]', '2026-01-24 16:02:39', NULL, '2025-12-21 15:18:26', '2026-01-24 16:02:39'),
(170, 'App\\Models\\User', 160, 'auth_token', '674de6c63cdb957c780d4ce18b89c3fbfe8bd59f81d0ebf0ff199bd96c33fb59', '[\"*\"]', NULL, NULL, '2025-12-22 13:36:23', '2025-12-22 13:36:23'),
(171, 'App\\Models\\User', 161, 'auth_token', '701cd97eae2913a46f5167fe6c1339a864170702b953afd32d6fa1a1e25edecc', '[\"*\"]', '2026-01-12 20:57:44', NULL, '2025-12-22 21:12:52', '2026-01-12 20:57:44'),
(172, 'App\\Models\\User', 162, 'auth_token', '425dbcc75c6466f212ed277a515f5f95d4cda1c0595178c62c9c3a29138c8da5', '[\"*\"]', '2025-12-26 03:39:36', NULL, '2025-12-23 01:26:51', '2025-12-26 03:39:36'),
(174, 'App\\Models\\User', 164, 'auth_token', '3f07c29e3f3fcaf60b0bf50614509ea4f4d09beaba1a8c2de7cd248ba3358e57', '[\"*\"]', '2025-12-27 03:31:41', NULL, '2025-12-23 17:05:14', '2025-12-27 03:31:41'),
(175, 'App\\Models\\User', 165, 'auth_token', 'a747296e5283221ddab3cf5a71ad9a130b278264cd38a30c87ccb4903ef2fc6f', '[\"*\"]', '2025-12-23 23:52:57', NULL, '2025-12-23 23:50:19', '2025-12-23 23:52:57'),
(176, 'App\\Models\\User', 152, 'auth_token', '9efd2c2f037c0751135220921630248493e0d97316354a5b4ee7b34195945312', '[\"*\"]', NULL, NULL, '2025-12-24 00:43:15', '2025-12-24 00:43:15'),
(177, 'App\\Models\\User', 166, 'auth_token', 'a9bcdcb13dd6940667f287ef7f19e8fa78acae919235368275b92882415920e5', '[\"*\"]', NULL, NULL, '2025-12-24 16:52:53', '2025-12-24 16:52:53'),
(178, 'App\\Models\\User', 167, 'auth_token', 'a53d778e6310bb2b527d1fe4f58ac611b24e2ccafbbee8d17464d0314b05005e', '[\"*\"]', '2026-01-23 15:15:05', NULL, '2025-12-25 00:36:43', '2026-01-23 15:15:05'),
(180, 'App\\Models\\User', 168, 'auth_token', 'b5b07e61f7c1eb31571f4d8e0f2a6d03d6d2cecf691cca2cc93030a1b1ed7b3e', '[\"*\"]', NULL, NULL, '2025-12-26 03:16:31', '2025-12-26 03:16:31'),
(181, 'App\\Models\\User', 169, 'auth_token', '82df4f382a165b45279e314cd76e7cf6113e299d3d66a4899209d9ceb53f3184', '[\"*\"]', '2025-12-26 14:18:40', NULL, '2025-12-26 12:30:37', '2025-12-26 14:18:40'),
(182, 'App\\Models\\User', 171, 'auth_token', '8b48c731a09dc3fb9c509de3add8ba23cdff0ed8ea881f3cf1cdc2be66b67ba5', '[\"*\"]', NULL, NULL, '2025-12-26 13:37:42', '2025-12-26 13:37:42'),
(183, 'App\\Models\\User', 172, 'auth_token', '5edfc823c8bcb7e1349d54ff70e6e028b73d4063adca729832a7f48e0bd94252', '[\"*\"]', NULL, NULL, '2025-12-26 13:38:17', '2025-12-26 13:38:17'),
(184, 'App\\Models\\User', 170, 'auth_token', '8918db8e9bf17f8d739372788fd6f2271a4f6be720c7ca846a5fb74562b59e07', '[\"*\"]', '2026-01-18 20:24:23', NULL, '2025-12-26 13:39:55', '2026-01-18 20:24:23'),
(185, 'App\\Models\\User', 174, 'auth_token', 'b65e78e25a555ccce58a294c34b833c28a62ff110011146fa362b06ed5eb916a', '[\"*\"]', '2025-12-26 13:42:58', NULL, '2025-12-26 13:40:28', '2025-12-26 13:42:58'),
(186, 'App\\Models\\User', 175, 'auth_token', '33bff095cca14e2834b585bbf244a98989cb594412e8f9f0b8e7cdd1d625fcd3', '[\"*\"]', '2026-01-10 18:20:37', NULL, '2025-12-26 13:42:03', '2026-01-10 18:20:37'),
(187, 'App\\Models\\User', 173, 'auth_token', '029a3902dbec55cb37f5019e0caecaa6a9fadf31ed8986aa3a75e0e5c0c9bcd8', '[\"*\"]', '2025-12-27 18:36:18', NULL, '2025-12-26 13:42:58', '2025-12-27 18:36:18'),
(188, 'App\\Models\\User', 176, 'auth_token', '634378737d2a0ff016c8d135185629079a0a218034ca851d464d606ee7354c79', '[\"*\"]', '2025-12-28 02:25:44', NULL, '2025-12-26 13:43:30', '2025-12-28 02:25:44'),
(189, 'App\\Models\\User', 177, 'auth_token', '357136f1996388ef7b959886ef1b5a76f99915f8a2b032ffc9a851be31f881cd', '[\"*\"]', NULL, NULL, '2025-12-26 13:45:24', '2025-12-26 13:45:24'),
(190, 'App\\Models\\User', 178, 'auth_token', 'fb5f916632aa9ff8d9f213d88865a31569cfca7cece06ddff588d80f776eea4b', '[\"*\"]', '2025-12-26 14:09:21', NULL, '2025-12-26 13:46:19', '2025-12-26 14:09:21'),
(191, 'App\\Models\\User', 179, 'auth_token', 'cf4af7d64488af66d6876f7808c49db4b73647b65f30e29fc982e1ed66815379', '[\"*\"]', '2026-01-03 14:13:32', NULL, '2025-12-26 13:46:25', '2026-01-03 14:13:32'),
(192, 'App\\Models\\User', 181, 'auth_token', 'c072c6a831f3f1a2f5b7cb69fbde0624d17102747b727dfecdc97124eab9a887', '[\"*\"]', '2026-01-13 16:10:33', NULL, '2025-12-26 13:46:52', '2026-01-13 16:10:33'),
(193, 'App\\Models\\User', 180, 'auth_token', 'bb0a66ac38fbc5ecef28850b42f8f5826a7c4d356f7648996a72070f23202cad', '[\"*\"]', '2026-01-21 02:29:11', NULL, '2025-12-26 13:46:57', '2026-01-21 02:29:11'),
(194, 'App\\Models\\User', 182, 'auth_token', '4a7d03a7edd0fa2ea1a8f62fed824869ace8dd2674c272565db9a67f7caeefec', '[\"*\"]', '2025-12-27 01:05:12', NULL, '2025-12-26 13:51:26', '2025-12-27 01:05:12'),
(195, 'App\\Models\\User', 183, 'auth_token', '61e22d67f9869a0e61c75bfd34095a0aa66a201bf0f734978faac7363a8e577f', '[\"*\"]', NULL, NULL, '2025-12-26 13:51:37', '2025-12-26 13:51:37'),
(196, 'App\\Models\\User', 184, 'auth_token', 'f676db95fa933c3208ed6e8bc6bbcbe7e15f20a8613f3be819e7c3e4af3cc4d9', '[\"*\"]', '2025-12-28 01:09:43', NULL, '2025-12-26 13:52:39', '2025-12-28 01:09:43'),
(197, 'App\\Models\\User', 185, 'auth_token', 'a1b4991b9fa9759939187fa9228a992edd725c6a40a4565c9d8e0105755e58b5', '[\"*\"]', NULL, NULL, '2025-12-26 13:55:26', '2025-12-26 13:55:26'),
(198, 'App\\Models\\User', 186, 'auth_token', 'b2f5299497ba5e1cd65d3f166e7afd37bcc3c3be2e91bfc9ece003895f30831a', '[\"*\"]', '2025-12-26 13:57:35', NULL, '2025-12-26 13:56:53', '2025-12-26 13:57:35'),
(199, 'App\\Models\\User', 188, 'auth_token', '8a5cee2d0ebbb49a852b8a3ceb078bcd46819014cb98f4670ef89633ee5f4023', '[\"*\"]', '2026-01-09 19:25:28', NULL, '2025-12-26 14:02:19', '2026-01-09 19:25:28'),
(200, 'App\\Models\\User', 189, 'auth_token', '5094ce75acdc4c0fb2421288ba3c6a627d7e676ba44c2442794f89f8ea21d7ee', '[\"*\"]', '2026-01-13 06:13:36', NULL, '2025-12-26 14:07:19', '2026-01-13 06:13:36'),
(201, 'App\\Models\\User', 190, 'auth_token', 'c45cc9784c9615717b8fec7bd461b8329ec4766b50810ec71b50c6880bf67e72', '[\"*\"]', NULL, NULL, '2025-12-26 14:13:56', '2025-12-26 14:13:56'),
(202, 'App\\Models\\User', 191, 'auth_token', 'cfe5bba992a16bc63a2844cf5d3322da672c3fd5eed66dca032e2f190774702d', '[\"*\"]', NULL, NULL, '2025-12-26 14:18:19', '2025-12-26 14:18:19'),
(203, 'App\\Models\\User', 192, 'auth_token', '33ca9988170ca55d1dd6a927574bdf7ee8f32b76ac987403e65e8ad1e4c80b41', '[\"*\"]', NULL, NULL, '2025-12-26 14:29:52', '2025-12-26 14:29:52'),
(204, 'App\\Models\\User', 193, 'auth_token', 'fcd9bb4d5cbe52e00a9c59cd131dc3833821c41fa23bb966acdfe466561c2b49', '[\"*\"]', NULL, NULL, '2025-12-26 14:33:18', '2025-12-26 14:33:18'),
(205, 'App\\Models\\User', 194, 'auth_token', '0ad6b7a7a1c0d38423c9272dd6444ee018bce1ca066dfd88be9b97d7e4016a88', '[\"*\"]', NULL, NULL, '2025-12-26 14:34:40', '2025-12-26 14:34:40'),
(206, 'App\\Models\\User', 195, 'auth_token', '53f57bb87519922db7d26873bfaf321493014f3cd04d9e3686b001d64e4ed580', '[\"*\"]', '2025-12-26 14:37:34', NULL, '2025-12-26 14:36:59', '2025-12-26 14:37:34'),
(207, 'App\\Models\\User', 196, 'auth_token', '19fc420f2b417e0794c2232a3f43cb312323e4167d33c1e54351a6c9d419d16a', '[\"*\"]', NULL, NULL, '2025-12-26 15:03:53', '2025-12-26 15:03:53'),
(208, 'App\\Models\\User', 168, 'auth_token', '8a3a78b90ac73da9f94ffd2f1a8c197cc2dbfbf61b80f7ba34ba9c0f5a132a6e', '[\"*\"]', NULL, NULL, '2025-12-26 15:16:13', '2025-12-26 15:16:13'),
(209, 'App\\Models\\User', 197, 'auth_token', '62b8d85f00f7d2736a272f140ac6245adad512ea1e6e24150103d864f3fbea7e', '[\"*\"]', '2025-12-27 18:20:35', NULL, '2025-12-26 15:17:18', '2025-12-27 18:20:35'),
(210, 'App\\Models\\User', 198, 'auth_token', '8f68aa78a4315b1179b4462846c645f913bce953c5c43d69819e2316255ff978', '[\"*\"]', '2026-01-08 14:31:44', NULL, '2025-12-26 15:20:28', '2026-01-08 14:31:44'),
(211, 'App\\Models\\User', 199, 'auth_token', '9900ea34d613bd49402316b68de8bb37d19d90fd8aac676507d62ab42a2381ec', '[\"*\"]', NULL, NULL, '2025-12-26 16:01:26', '2025-12-26 16:01:26'),
(212, 'App\\Models\\User', 168, 'auth_token', '0e59bfcb036ba40621c014318de34d2c26764fd94be54f83b3dde243b96e0d0c', '[\"*\"]', NULL, NULL, '2025-12-26 16:18:52', '2025-12-26 16:18:52'),
(213, 'App\\Models\\User', 200, 'auth_token', '67db93a969b0cf6da70690da4010a52392ddb5a25c94528e4b5369a05203a8d6', '[\"*\"]', '2025-12-26 16:58:16', NULL, '2025-12-26 16:53:22', '2025-12-26 16:58:16'),
(214, 'App\\Models\\User', 194, 'auth_token', '024edcd2b9f4c2f122665bac7935fe31d3780227554dbf71705217643442df06', '[\"*\"]', '2025-12-26 17:00:22', NULL, '2025-12-26 16:58:21', '2025-12-26 17:00:22'),
(215, 'App\\Models\\User', 201, 'auth_token', 'e2dceaeb5bfb0af2308aa50412f05cd35f3e997ea14fba48073ed169f20b4c46', '[\"*\"]', '2025-12-28 06:16:06', NULL, '2025-12-26 18:03:03', '2025-12-28 06:16:06'),
(216, 'App\\Models\\User', 202, 'auth_token', 'c23cf8aad7693fdc372cc17c5cf0402b0a1e3e3de819bf7aae75cedb6c671c16', '[\"*\"]', '2025-12-28 01:47:31', NULL, '2025-12-26 18:49:36', '2025-12-28 01:47:31'),
(217, 'App\\Models\\User', 203, 'auth_token', 'b0f1cd2f36a73d6d68a4559311019871975bc063a1bc71b169a76f88b0db650a', '[\"*\"]', '2026-01-23 05:01:53', NULL, '2025-12-26 19:11:30', '2026-01-23 05:01:53'),
(218, 'App\\Models\\User', 204, 'auth_token', 'e30cb05c2e8c1f3ec608c0f93bf25d618c1add50d50646fbc99f2208773f81ae', '[\"*\"]', NULL, NULL, '2025-12-26 19:11:32', '2025-12-26 19:11:32'),
(219, 'App\\Models\\User', 69, 'auth_token', 'b0f4e15929d0517deeb40e0417a0efa0594fb022d304bd6920715637787a55b5', '[\"*\"]', '2026-01-03 01:31:39', NULL, '2025-12-26 20:02:39', '2026-01-03 01:31:39'),
(220, 'App\\Models\\User', 168, 'auth_token', '13b70d9ed78592716c932cf71709983639250b6bf3b2014f3aaa876f7e26b5c4', '[\"*\"]', '2025-12-27 03:22:48', NULL, '2025-12-26 22:00:59', '2025-12-27 03:22:48'),
(221, 'App\\Models\\User', 206, 'auth_token', '97ad5c42be928d17da46f8903de6592ec842b2d78bfc9f9afeedd6c3a17ef0dc', '[\"*\"]', '2026-01-05 12:26:08', NULL, '2025-12-27 02:37:06', '2026-01-05 12:26:08'),
(222, 'App\\Models\\User', 207, 'auth_token', 'c17b2aed044d45428d4f04676f419fa08ebaf21f1624278bfd5745979fab5b78', '[\"*\"]', NULL, NULL, '2025-12-27 22:17:59', '2025-12-27 22:17:59'),
(223, 'App\\Models\\User', 168, 'auth_token', 'd7c497a5e7890648a16e8ffebdce21923f6405bd3953e7ecd2266d33e56c841f', '[\"*\"]', '2025-12-28 01:57:39', NULL, '2025-12-28 00:11:34', '2025-12-28 01:57:39'),
(224, 'App\\Models\\User', 184, 'auth_token', '70dbf9ac98f08982f54ba0051acf7f5c9b3210233ba1960d8ff6acf774a3cd56', '[\"*\"]', NULL, NULL, '2025-12-28 01:10:17', '2025-12-28 01:10:17'),
(225, 'App\\Models\\User', 208, 'auth_token', '43a4cb55700e05099e6ab8cd897e5c62903be74eb891baecd95459c619cf9f96', '[\"*\"]', '2025-12-28 02:12:17', NULL, '2025-12-28 01:36:15', '2025-12-28 02:12:17'),
(226, 'App\\Models\\User', 40, 'auth_token', '407abb822de52a410575aa4ead083f6ac6cdd20fa923cb5bb6d652db3cb76bec', '[\"*\"]', NULL, NULL, '2025-12-28 15:36:29', '2025-12-28 15:36:29'),
(227, 'App\\Models\\User', 163, 'auth_token', '2520178bff7dcdd9853d9897eddffee2457fa8eed19e995c20ed619604e967d2', '[\"*\"]', '2025-12-29 16:49:28', NULL, '2025-12-29 16:48:20', '2025-12-29 16:49:28'),
(228, 'App\\Models\\User', 209, 'auth_token', '32da597ca72b997092bf6e5ee7f926f7a9294afebcea02370b5d03efaaeddec6', '[\"*\"]', '2026-01-21 06:08:39', NULL, '2025-12-29 20:30:11', '2026-01-21 06:08:39'),
(229, 'App\\Models\\User', 6, 'password_reset', '2a717d825ed54e1ffe1c24d81cc9daad2ba28d5c6f9c9714e8c56feaee06214d', '[\"password-reset\"]', NULL, '2025-12-30 02:26:25', '2025-12-30 01:56:25', '2025-12-30 01:56:25'),
(230, 'App\\Models\\User', 19, 'auth_token', '11ad60494377de5ea31bd81fb736fdb0266d40f89f32aa1922f20a16932253db', '[\"*\"]', '2026-01-25 03:34:20', NULL, '2025-12-30 03:21:10', '2026-01-25 03:34:20'),
(232, 'App\\Models\\User', 162, 'auth_token', '3fd043df25683e33a95d9c968045b377ea99fda8dd5d6fa4c90284d3a9f310ed', '[\"*\"]', '2026-01-08 19:57:18', NULL, '2025-12-31 12:25:35', '2026-01-08 19:57:18'),
(233, 'App\\Models\\User', 210, 'auth_token', '76892f378c49920f91f94f3154f596d4702cb786b7b03eeedc89794c27d4baaf', '[\"*\"]', NULL, NULL, '2025-12-31 12:49:25', '2025-12-31 12:49:25'),
(234, 'App\\Models\\User', 211, 'auth_token', 'fc22f6449f5c8a72cb57bb0fc2a2a11200140a02c265211fcca658002e5e50c3', '[\"*\"]', NULL, NULL, '2025-12-31 21:47:58', '2025-12-31 21:47:58'),
(237, 'App\\Models\\User', 5, 'auth_token', 'ee6f9c9dde2d3ee492764924d417607ac1d436473c650c3ea40893189c2446a4', '[\"*\"]', '2026-01-03 12:20:46', NULL, '2026-01-01 01:03:19', '2026-01-03 12:20:46'),
(238, 'App\\Models\\User', 13, 'auth_token', 'e3b2d2e9be795ca8540637857781b0df20aa082532fcf01797a2fd6ce85e8424', '[\"*\"]', '2026-01-02 19:38:58', NULL, '2026-01-01 16:40:15', '2026-01-02 19:38:58'),
(239, 'App\\Models\\User', 13, 'auth_token', 'a061b543c36d24ba1eae4e9cf5ce8364a92a3a5963720afb61d5f35ecbb11cb0', '[\"*\"]', '2026-01-21 15:03:00', NULL, '2026-01-02 18:47:22', '2026-01-21 15:03:00'),
(240, 'App\\Models\\User', 210, 'auth_token', '7f4733e1cb0fc1ef34a65addc02f6c7e76d03af356284bc789a903fddb5f3213', '[\"*\"]', NULL, NULL, '2026-01-02 21:55:16', '2026-01-02 21:55:16'),
(241, 'App\\Models\\User', 5, 'auth_token', '5c7e41dc11505e4a7dfc16b6ef80be134d0dd0a94fb5c38ec01cc8d1cc5b43dd', '[\"*\"]', '2026-01-04 21:24:16', NULL, '2026-01-03 12:23:13', '2026-01-04 21:24:16'),
(242, 'App\\Models\\User', 212, 'auth_token', 'ec02ded372a9016facac88b81c757249b3b2bacc4f18d1974347e7dabf3e7a24', '[\"*\"]', '2026-01-03 13:48:35', NULL, '2026-01-03 13:46:20', '2026-01-03 13:48:35'),
(243, 'App\\Models\\User', 214, 'auth_token', 'f1afd4fb68f1062990f2b01edb5a861da0e96131a89fec3283739c04cdecbe09', '[\"*\"]', NULL, NULL, '2026-01-03 15:09:19', '2026-01-03 15:09:19'),
(245, 'App\\Models\\User', 216, 'auth_token', '7ecc2113782432fbd74b98c73917746686e280d3fbd694a947f1f41e3a5005b8', '[\"*\"]', '2026-01-18 23:16:56', NULL, '2026-01-05 11:59:43', '2026-01-18 23:16:56'),
(246, 'App\\Models\\User', 55, 'auth_token', '843a008d624f52fee1127c064c70593ad36ddc3ccae05456023f23a70c994110', '[\"*\"]', '2026-01-07 00:56:25', NULL, '2026-01-05 12:47:16', '2026-01-07 00:56:25'),
(247, 'App\\Models\\User', 152, 'auth_token', '623de6c0b2ee0e91683f0779d747896643657d27bba3eb6842b7dd4080b3887a', '[\"*\"]', '2026-01-22 19:43:02', NULL, '2026-01-05 13:14:00', '2026-01-22 19:43:02'),
(248, 'App\\Models\\User', 218, 'auth_token', '428cc139808998c0d1e7710dd3fdce09340ba3622f52d75e322a5d9315a5954e', '[\"*\"]', NULL, NULL, '2026-01-05 15:26:00', '2026-01-05 15:26:00'),
(249, 'App\\Models\\User', 168, 'auth_token', 'e0d12c5ca9df121460ce873b0f579dda551e17e716a8408c4442213b33d682b5', '[\"*\"]', '2026-01-05 16:11:34', NULL, '2026-01-05 15:42:24', '2026-01-05 16:11:34'),
(250, 'App\\Models\\User', 168, 'auth_token', 'ff2d5dd2936fa940ac120765b5a5330f1d80c5349e5b6dac5770f2635c90e05c', '[\"*\"]', '2026-01-05 20:28:42', NULL, '2026-01-05 19:20:59', '2026-01-05 20:28:42'),
(251, 'App\\Models\\User', 219, 'auth_token', '1a9652cfe4fc692302288f159d72333fa670e5814c3fe4598faccd087a9effa0', '[\"*\"]', NULL, NULL, '2026-01-05 20:03:17', '2026-01-05 20:03:17'),
(252, 'App\\Models\\User', 220, 'auth_token', '870d785ae51cd0183a8527a33854c96ec7d30661b12df50909d81b51c072accb', '[\"*\"]', '2026-01-20 22:42:20', NULL, '2026-01-06 01:10:58', '2026-01-20 22:42:20'),
(253, 'App\\Models\\User', 40, 'auth_token', '5e2c6b31625d99aaaba4c47f9cceadfb83309cedc1aaf31bd220bd1c36a6fa3e', '[\"*\"]', '2026-01-06 13:24:00', NULL, '2026-01-06 05:33:00', '2026-01-06 13:24:00'),
(254, 'App\\Models\\User', 5, 'auth_token', '760c84e74dd775f539e63f1b128575dc12817b60c2c82f65af8ed35f6d6c6cc6', '[\"*\"]', NULL, NULL, '2026-01-06 14:47:22', '2026-01-06 14:47:22'),
(255, 'App\\Models\\User', 130, 'auth_token', 'f2785819b9e84c0885f55159917866d4432815eb663b8d2616262bb22df36368', '[\"*\"]', '2026-01-13 04:00:24', NULL, '2026-01-06 15:30:43', '2026-01-13 04:00:24'),
(256, 'App\\Models\\User', 221, 'auth_token', 'c5ec89673d51f2b89e2b791de590724bc1f5c672798f1d00e5651da0e460d356', '[\"*\"]', '2026-01-06 16:51:30', NULL, '2026-01-06 15:59:37', '2026-01-06 16:51:30'),
(257, 'App\\Models\\User', 222, 'auth_token', 'f202a03c03701b004411b40ec7a6fcae71e23c9e3778a2cdef3f11916129a1be', '[\"*\"]', '2026-01-07 14:03:30', NULL, '2026-01-06 16:06:37', '2026-01-07 14:03:30'),
(258, 'App\\Models\\User', 223, 'auth_token', 'a6ccc60e647008d2b88b5adc9447c4f2383592f33b11ae65bce10a6a141de414', '[\"*\"]', '2026-01-09 06:13:02', NULL, '2026-01-06 16:19:07', '2026-01-09 06:13:02'),
(259, 'App\\Models\\User', 224, 'auth_token', 'e0c502024321ec2070c86bb3e853f2b26f66285e430a5afa759dfd0edf25afa9', '[\"*\"]', '2026-01-08 18:45:50', NULL, '2026-01-06 17:03:52', '2026-01-08 18:45:50'),
(260, 'App\\Models\\User', 225, 'auth_token', '3083709a5056c7a4237a0e2d184fd7fd963f744b5d6090599c779b6f13377df8', '[\"*\"]', '2026-01-07 02:06:25', NULL, '2026-01-06 17:09:23', '2026-01-07 02:06:25'),
(261, 'App\\Models\\User', 226, 'auth_token', '62f8551f4ff4d5034d2e43a50f706cb691d4d056087f36af56c6bc2a96fc452c', '[\"*\"]', NULL, NULL, '2026-01-06 17:13:01', '2026-01-06 17:13:01'),
(262, 'App\\Models\\User', 224, 'auth_token', 'e71fedafc1d5f0fcdb7848521d5075587f6c3772e5fd9686ad6ebb6407543d90', '[\"*\"]', '2026-01-15 18:01:12', NULL, '2026-01-06 17:30:08', '2026-01-15 18:01:12'),
(263, 'App\\Models\\User', 228, 'auth_token', '88c2f6de32c200adf907e39e2816cf0574ec8c3b9e7dd7c7e2ad0ed5a94cef80', '[\"*\"]', '2026-01-24 18:15:12', NULL, '2026-01-06 17:51:19', '2026-01-24 18:15:12'),
(264, 'App\\Models\\User', 229, 'auth_token', 'a1d5895eb0267c4839f2feb8b759de629eb3476775f1a2915913c792110c6324', '[\"*\"]', '2026-01-06 18:40:50', NULL, '2026-01-06 17:54:34', '2026-01-06 18:40:50'),
(265, 'App\\Models\\User', 229, 'auth_token', '0b94a7bd46f6ad427421207e89d8b225aee8db665b612b96831ac1a72910d1bd', '[\"*\"]', '2026-01-06 18:13:52', NULL, '2026-01-06 17:58:26', '2026-01-06 18:13:52'),
(266, 'App\\Models\\User', 230, 'auth_token', '466f1cc8e988495d03301f3356e80f53d05b8c6e572c8d64a849c2ee8deab62e', '[\"*\"]', '2026-01-13 21:14:27', NULL, '2026-01-06 19:00:59', '2026-01-13 21:14:27'),
(267, 'App\\Models\\User', 231, 'auth_token', '002ef75f1d9ab5cbc6cd266e82ae9756f245fe11061395854e018807aaa57234', '[\"*\"]', '2026-01-22 14:30:31', NULL, '2026-01-06 19:05:49', '2026-01-22 14:30:31'),
(269, 'App\\Models\\User', 232, 'auth_token', 'd8f5ed5d26cfdb54198cba394db629675e59f9cfd6003e226364fac34ab5b76b', '[\"*\"]', '2026-01-15 16:23:28', NULL, '2026-01-06 19:31:30', '2026-01-15 16:23:28'),
(270, 'App\\Models\\User', 233, 'auth_token', 'a6429951f8a5ea9b38751c43fff7d8ed392638f021d034c094e43d290874795b', '[\"*\"]', '2026-01-07 02:56:23', NULL, '2026-01-06 22:23:00', '2026-01-07 02:56:23'),
(271, 'App\\Models\\User', 234, 'auth_token', 'a5aeec8582aa4bcb8319b72f42e8641061e4efc6c642a8ac638373becfe4e6b5', '[\"*\"]', '2026-01-21 13:35:54', NULL, '2026-01-06 22:32:25', '2026-01-21 13:35:54'),
(272, 'App\\Models\\User', 235, 'auth_token', '5a8b520c7b3f28b1f14c073f322393aa4280d47aa3c84a94d4c847aa47bf3017', '[\"*\"]', '2026-01-22 19:54:11', NULL, '2026-01-07 02:30:23', '2026-01-22 19:54:11'),
(273, 'App\\Models\\User', 225, 'auth_token', 'be97e241349f7acbf0d1dbc4d4275dafdc0640add2736e3712b39f063b0a4954', '[\"*\"]', '2026-01-12 15:59:25', NULL, '2026-01-07 02:34:43', '2026-01-12 15:59:25'),
(276, 'App\\Models\\User', 16, 'auth_token', 'ed6583a5938c9e1032124ee227f3b4fee29fbe401fd3278551a6c00eba7f4bac', '[\"*\"]', '2026-01-23 13:50:45', NULL, '2026-01-07 06:30:07', '2026-01-23 13:50:45'),
(277, 'App\\Models\\User', 55, 'auth_token', 'c3625d221fd451b2814031b6c7d0ac93de62a05f2b30a62c623596e1130f04a7', '[\"*\"]', '2026-01-08 17:16:07', NULL, '2026-01-07 16:26:54', '2026-01-08 17:16:07'),
(279, 'App\\Models\\User', 5, 'auth_token', '8a3fec3dde4772815907981f61c39a901be4ff7fafbe31e36e4073f4690df409', '[\"*\"]', '2026-01-25 03:08:03', NULL, '2026-01-07 17:20:02', '2026-01-25 03:08:03'),
(280, 'App\\Models\\User', 236, 'auth_token', 'a258eecdc9fe789e8b0222bbc98d7c59b484dda712fae96053ed51a3623a5879', '[\"*\"]', '2026-01-22 20:14:14', NULL, '2026-01-07 17:23:23', '2026-01-22 20:14:14'),
(281, 'App\\Models\\User', 237, 'auth_token', '60e1d70532cd0877b4afd2c54546c668eeadd6fc4e82a10e33283e68310c71a5', '[\"*\"]', NULL, NULL, '2026-01-07 17:48:46', '2026-01-07 17:48:46'),
(282, 'App\\Models\\User', 236, 'auth_token', '95f1afce43ba9bbc916f9a34006d88c5870e3f8858af048c3c36c2b05d7620f2', '[\"*\"]', '2026-01-21 16:07:54', NULL, '2026-01-07 20:08:06', '2026-01-21 16:07:54'),
(283, 'App\\Models\\User', 225, 'auth_token', '3f619318b2880748b6a338f4b6e8261f981ccc9b55e42eb8e4e02d91f726f5d0', '[\"*\"]', NULL, NULL, '2026-01-07 22:09:34', '2026-01-07 22:09:34'),
(284, 'App\\Models\\User', 238, 'auth_token', '260e5f064c92b02a119c4edd1fe0b53fc70c9da55b531a8d32c8bd4f2c3b402e', '[\"*\"]', '2026-01-23 17:32:16', NULL, '2026-01-08 00:09:25', '2026-01-23 17:32:16'),
(285, 'App\\Models\\User', 168, 'auth_token', 'f7b3fa2363711008acbde62be6f02a3485151d32a4c773b9945df5242eb023b9', '[\"*\"]', '2026-01-08 16:50:05', NULL, '2026-01-08 14:05:19', '2026-01-08 16:50:05');
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(286, 'App\\Models\\User', 237, 'auth_token', 'b0f07ef2e24a3962aaa24213a8d9e3f1c3aca50954ae5d82dd5e1a9326bf4fcb', '[\"*\"]', NULL, NULL, '2026-01-08 14:25:10', '2026-01-08 14:25:10'),
(288, 'App\\Models\\User', 12, 'auth_token', 'f1b2c9c098cffe39a460217485f038c3579f964a40c3bfbba9a3ae16379ea7c2', '[\"*\"]', '2026-01-25 02:22:32', NULL, '2026-01-08 15:20:48', '2026-01-25 02:22:32'),
(290, 'App\\Models\\User', 219, 'auth_token', 'adff1f3961691b63bfc0539fddc5df97be7389a3445e668e36044f701256e57a', '[\"*\"]', '2026-01-22 20:19:46', NULL, '2026-01-08 18:10:12', '2026-01-22 20:19:46'),
(291, 'App\\Models\\User', 241, 'auth_token', '512186b7f67b72a049239075f7db1ab15ee462377c399cab8c1d69ddea9a1b61', '[\"*\"]', '2026-01-22 15:05:57', NULL, '2026-01-08 18:26:37', '2026-01-22 15:05:57'),
(292, 'App\\Models\\User', 55, 'auth_token', '8298e12b4798820032d0e913caf398cb223c531719c084c8170030d6135a2d57', '[\"*\"]', '2026-01-09 00:27:23', NULL, '2026-01-08 20:53:12', '2026-01-09 00:27:23'),
(293, 'App\\Models\\User', 168, 'auth_token', 'a6ea67e784cbe87a22177bfb025994cfd1cbf82e557580d66248e641f768f52a', '[\"*\"]', NULL, NULL, '2026-01-08 21:48:45', '2026-01-08 21:48:45'),
(294, 'App\\Models\\User', 242, 'auth_token', 'e7aadf48cfc033ec727828f9cb1875ae86ff78c4ad0a6463a45bbba63f9ec730', '[\"*\"]', NULL, NULL, '2026-01-08 23:55:49', '2026-01-08 23:55:49'),
(295, 'App\\Models\\User', 243, 'auth_token', '5d6e8c75873b537ff308620efcb9e61c562af53e42d62aed5d4d28c36f7ebfc9', '[\"*\"]', '2026-01-09 04:28:41', NULL, '2026-01-09 04:14:04', '2026-01-09 04:28:41'),
(296, 'App\\Models\\User', 243, 'auth_token', '79ba42d1e043fa0579d26d4b0bb97df59022d17b645b8d0dbfa9c8d72e1f1520', '[\"*\"]', '2026-01-22 22:41:17', NULL, '2026-01-09 10:44:46', '2026-01-22 22:41:17'),
(297, 'App\\Models\\User', 55, 'auth_token', '31a07769df8df4b79b5f0fa6926eca10952cc0dbb55254e48837248100cc023e', '[\"*\"]', '2026-01-15 13:55:55', NULL, '2026-01-09 12:59:38', '2026-01-15 13:55:55'),
(298, 'App\\Models\\User', 233, 'auth_token', '76aee1f2ffa9d9130c0d5cf5150b1c9e8c14e39f626b261508c1c5cc0239dcf9', '[\"*\"]', NULL, NULL, '2026-01-09 14:48:29', '2026-01-09 14:48:29'),
(299, 'App\\Models\\User', 168, 'auth_token', '792b05f3564bfeef725872466237a5be6efe26ad5bc72ad74bd8ffa039bfa427', '[\"*\"]', '2026-01-09 22:46:02', NULL, '2026-01-09 17:56:35', '2026-01-09 22:46:02'),
(300, 'App\\Models\\User', 244, 'auth_token', 'ca0e5c1414227e2bb08067e69afb3719131be52029fdfdf153199d84e95fce64', '[\"*\"]', '2026-01-09 22:45:34', NULL, '2026-01-09 20:48:07', '2026-01-09 22:45:34'),
(301, 'App\\Models\\User', 18, 'auth_token', 'fd968ac12299bd756e840df23852aa16ec79c183a78cad7164a2d01fbdd898c8', '[\"*\"]', NULL, NULL, '2026-01-10 22:00:47', '2026-01-10 22:00:47'),
(302, 'App\\Models\\User', 236, 'auth_token', 'a297ed53858f06a1d0997cfcf006e847efeab77a246b90d3e66515ce8f1766e3', '[\"*\"]', '2026-01-23 02:42:13', NULL, '2026-01-10 22:15:01', '2026-01-23 02:42:13'),
(303, 'App\\Models\\User', 40, 'auth_token', '643ceea830879b99f876fac313d7bcda10c29b7187f0bca5061c530761194683', '[\"*\"]', '2026-01-11 21:04:01', NULL, '2026-01-11 14:05:15', '2026-01-11 21:04:01'),
(304, 'App\\Models\\User', 245, 'auth_token', '5ec80627bb99cea3a3c1bca32403fb95da34c68dab0bab73a608e8c0c37efe23', '[\"*\"]', '2026-01-12 12:46:14', NULL, '2026-01-12 10:06:25', '2026-01-12 12:46:14'),
(305, 'App\\Models\\User', 246, 'auth_token', '0dfc370c7476a690524d0ebd7d8e537a33ec2b1802d81fb2ffa826ec615906ef', '[\"*\"]', NULL, NULL, '2026-01-12 11:02:04', '2026-01-12 11:02:04'),
(306, 'App\\Models\\User', 168, 'auth_token', '3682a9239d31276a7045d880b8b2011ae134ef32f11001c914a18230f134519c', '[\"*\"]', '2026-01-12 13:42:36', NULL, '2026-01-12 11:56:08', '2026-01-12 13:42:36'),
(307, 'App\\Models\\User', 247, 'auth_token', '269282d7c7ceea9dbe23d5763315703f1feb62da7e61952015f4ba149f565dcc', '[\"*\"]', '2026-01-19 18:33:40', NULL, '2026-01-12 14:24:27', '2026-01-19 18:33:40'),
(308, 'App\\Models\\User', 248, 'auth_token', '5c95ba1010dd117427d8c5f304cb3b5f68a20ce883685ee1f47fd83d76056c7b', '[\"*\"]', '2026-01-15 04:15:45', NULL, '2026-01-12 15:52:40', '2026-01-15 04:15:45'),
(309, 'App\\Models\\User', 5, 'auth_token', '003e1128785e40434a9c807de7cbf39b8eeeae1d9e01d74f3218e253f4978adc', '[\"*\"]', '2026-01-22 14:53:24', NULL, '2026-01-12 18:06:00', '2026-01-22 14:53:24'),
(311, 'App\\Models\\User', 249, 'auth_token', 'd9f58ff033955cea1ab30b3a5fccb3b920414e8686924bb092cfbb33b00de1d7', '[\"*\"]', '2026-01-12 20:20:58', NULL, '2026-01-12 19:57:49', '2026-01-12 20:20:58'),
(313, 'App\\Models\\User', 250, 'auth_token', '99d0b25259346841bd68c8856f88861a9c03589b837ac574a11b89a2690831a3', '[\"*\"]', '2026-01-23 18:32:44', NULL, '2026-01-12 20:18:22', '2026-01-23 18:32:44'),
(315, 'App\\Models\\User', 223, 'auth_token', 'fe80c2c5a40fef7386e511f265f29ad43bd73b6c1159901a7c7da94a22d1dc85', '[\"*\"]', '2026-01-22 22:14:58', NULL, '2026-01-13 05:33:28', '2026-01-22 22:14:58'),
(316, 'App\\Models\\User', 130, 'auth_token', '00ff95f32b70f4b14fab9c64e6c95c1c73fd5c3e548fa7d3ed8f046284b44733', '[\"*\"]', '2026-01-16 02:47:37', NULL, '2026-01-13 06:24:15', '2026-01-16 02:47:37'),
(317, 'App\\Models\\User', 3, 'auth_token', 'cb512521e88e15bf6e81297ec0a0352f83c5da9278edd9ac8cb2587bb9584aeb', '[\"*\"]', '2026-01-18 15:48:29', NULL, '2026-01-13 11:43:40', '2026-01-18 15:48:29'),
(318, 'App\\Models\\User', 168, 'auth_token', '2a17ea77e8e6f11362f538f3e26e9d26e6a484ec3a7eb9afcf89b166bfa54f2a', '[\"*\"]', NULL, NULL, '2026-01-13 13:02:58', '2026-01-13 13:02:58'),
(321, 'App\\Models\\User', 59, 'auth_token', '37e23c1ca697c7ecfb0a3f77fd8682b8e1d672c33fd2a106a403f675490569a9', '[\"*\"]', NULL, NULL, '2026-01-13 14:50:32', '2026-01-13 14:50:32'),
(322, 'App\\Models\\User', 59, 'auth_token', '4c36fcc64b2d888600b42abceeb6260980ac1391e8c25a5cc67c8f69de8a739a', '[\"*\"]', '2026-01-20 23:44:03', NULL, '2026-01-13 14:52:09', '2026-01-20 23:44:03'),
(323, 'App\\Models\\User', 59, 'auth_token', 'f4a1563acb4907079266aa0dc497cdacfe9041255018e0d058c506bf5e07f236', '[\"*\"]', NULL, NULL, '2026-01-13 14:53:25', '2026-01-13 14:53:25'),
(324, 'App\\Models\\User', 59, 'auth_token', '40380d026c01423261d15df0bc822538381f80adbf68150ebb56bb627a5d0073', '[\"*\"]', '2026-01-20 22:09:26', NULL, '2026-01-13 18:37:41', '2026-01-20 22:09:26'),
(325, 'App\\Models\\User', 236, 'auth_token', '76c598407c9ffc8b0c48469a3678f105f2cd09caacb545fc96c57932c5c7fc1e', '[\"*\"]', '2026-01-16 21:24:00', NULL, '2026-01-13 19:09:19', '2026-01-16 21:24:00'),
(326, 'App\\Models\\User', 230, 'auth_token', '43412e39e6f7b291529d524042e0c1d3c9ca8cf117a0580f5af2adc8a5a5156a', '[\"*\"]', '2026-01-23 21:51:44', NULL, '2026-01-13 21:28:27', '2026-01-23 21:51:44'),
(327, 'App\\Models\\User', 251, 'auth_token', '18b252e1e841f60357d210df54182fa6636014416b74ca3cd53e68e101736428', '[\"*\"]', '2026-01-14 02:13:55', NULL, '2026-01-13 23:16:57', '2026-01-14 02:13:55'),
(328, 'App\\Models\\User', 252, 'auth_token', '77bf10bf61cf63d44f7d51315bc8286fc726e94dfb945960152ed722c8c7c8cd', '[\"*\"]', '2026-01-14 21:24:25', NULL, '2026-01-14 02:49:50', '2026-01-14 21:24:25'),
(329, 'App\\Models\\User', 253, 'auth_token', 'e4d50c6f3fe73fb05187c78bd27d804656b1df1c131dc24655f8219c7737faf2', '[\"*\"]', '2026-01-14 13:03:03', NULL, '2026-01-14 13:00:00', '2026-01-14 13:03:03'),
(330, 'App\\Models\\User', 168, 'auth_token', 'f465ef6b3b959e51b8a8c63ca077a066502754d97040520bfff3979b88ebeaa7', '[\"*\"]', '2026-01-14 14:48:54', NULL, '2026-01-14 14:30:28', '2026-01-14 14:48:54'),
(331, 'App\\Models\\User', 236, 'auth_token', 'ff6a3e58961393ab4cd15c5425697e22e10f01be837804589819902d8856cb24', '[\"*\"]', '2026-01-23 19:29:42', NULL, '2026-01-14 14:53:34', '2026-01-23 19:29:42'),
(332, 'App\\Models\\User', 59, 'auth_token', 'd7110b1221f88bb35f9db4c98f7c6f490680bfbed229f0ba59ff8fe8f37c871f', '[\"*\"]', '2026-01-15 05:36:56', NULL, '2026-01-14 16:08:55', '2026-01-15 05:36:56'),
(333, 'App\\Models\\User', 59, 'auth_token', '3ff63f553eb0683ccf3dd46b8efd5de9cec607959e6cab7fb8cfa4bf9f4e54ac', '[\"*\"]', '2026-01-16 13:53:44', NULL, '2026-01-14 17:15:51', '2026-01-16 13:53:44'),
(334, 'App\\Models\\User', 59, 'auth_token', '768efb5552e045f1eac046593894c28d211426e6d1b15d3855b6626b3f5bbb63', '[\"*\"]', '2026-01-23 18:27:58', NULL, '2026-01-14 18:16:35', '2026-01-23 18:27:58'),
(335, 'App\\Models\\User', 203, 'auth_token', '04d82d8e790e3403eedf45fe185a99819fbda585ec43715cb6ccb9794c52087a', '[\"*\"]', '2026-01-22 16:38:04', NULL, '2026-01-14 22:28:47', '2026-01-22 16:38:04'),
(337, 'App\\Models\\User', 238, 'password_reset', '4995f496cfd0cd7513de9e6b6199e4fd81e66f98dcb158669c81a67ec9294f77', '[\"password-reset\"]', NULL, '2026-01-15 00:52:05', '2026-01-15 00:22:05', '2026-01-15 00:22:05'),
(338, 'App\\Models\\User', 238, 'password_reset', '69c24d0997614513b909a5e079b6e35f88c5af58b440539a49ff8914ddc9e52b', '[\"password-reset\"]', NULL, '2026-01-15 00:52:45', '2026-01-15 00:22:45', '2026-01-15 00:22:45'),
(339, 'App\\Models\\User', 238, 'password_reset', 'ddfd699cfc749d10d3b91f5d55d1c4d5e4b511dcfd8381c64bdb87dacea9379f', '[\"password-reset\"]', NULL, '2026-01-15 00:53:22', '2026-01-15 00:23:22', '2026-01-15 00:23:22'),
(340, 'App\\Models\\User', 238, 'password_reset', '9b16c7abcb4e3ee56f34cdad72c20de7a55a8adcf87b4c3156bd439a8c7f005f', '[\"password-reset\"]', NULL, '2026-01-15 00:55:07', '2026-01-15 00:25:07', '2026-01-15 00:25:07'),
(341, 'App\\Models\\User', 238, 'auth_token', 'd8b2bdc80cabb742fc616191d76527ce5f90b7efd5d02278673de3322cfefe84', '[\"*\"]', '2026-01-22 07:20:00', NULL, '2026-01-15 00:28:46', '2026-01-22 07:20:00'),
(342, 'App\\Models\\User', 227, 'auth_token', '05d29153242a1248ce592f28bd396c78c4b336b129d5f8d94ba0eec0a03cc7b2', '[\"*\"]', NULL, NULL, '2026-01-15 04:29:22', '2026-01-15 04:29:22'),
(343, 'App\\Models\\User', 254, 'auth_token', '5759f50e6d8600d848c3883dc76c1704ed6ebd7686796776634b90cd338ba86e', '[\"*\"]', NULL, NULL, '2026-01-15 09:48:17', '2026-01-15 09:48:17'),
(344, 'App\\Models\\User', 59, 'auth_token', '600c2759d62c9ac31a6eb13f92c7719d8f523e7c030f8ebbe252c9f38202bda0', '[\"*\"]', NULL, NULL, '2026-01-15 12:26:09', '2026-01-15 12:26:09'),
(345, 'App\\Models\\User', 255, 'auth_token', '28232b21f8c3407a9311bb4fbd02a94159faba80417b8b88cc665228e4ef966c', '[\"*\"]', '2026-01-18 16:11:54', NULL, '2026-01-15 12:45:28', '2026-01-18 16:11:54'),
(346, 'App\\Models\\User', 59, 'auth_token', '59d823eb3a0f14e2e5e2d0454874c0c1b27563dab4818446e74f61d8efe00352', '[\"*\"]', '2026-01-22 15:23:13', NULL, '2026-01-15 13:37:47', '2026-01-22 15:23:13'),
(347, 'App\\Models\\User', 55, 'auth_token', '94c67b3e0796966e18aa5126377920eb14e8c5c56363e2195e4062f3b1ed22f0', '[\"*\"]', '2026-01-16 13:35:23', NULL, '2026-01-15 17:03:04', '2026-01-16 13:35:23'),
(348, 'App\\Models\\User', 256, 'auth_token', '5787e4a06491671c54122a53ff5dffcf0892b7416a9cd4193fe565461dc2270b', '[\"*\"]', '2026-01-19 19:02:38', NULL, '2026-01-15 17:26:46', '2026-01-19 19:02:38'),
(349, 'App\\Models\\User', 257, 'auth_token', '7ff9def99f8f20f0cd91c55d8afdb9ebe2a2be47b8af3ab53b11ceb1c33085c4', '[\"*\"]', '2026-01-15 19:37:54', NULL, '2026-01-15 17:42:35', '2026-01-15 19:37:54'),
(350, 'App\\Models\\User', 236, 'auth_token', '5b019b7f99d0028259159efe5b6bfe9064743e9497750240d3aa5adc6277370c', '[\"*\"]', '2026-01-15 18:38:32', NULL, '2026-01-15 18:31:31', '2026-01-15 18:38:32'),
(351, 'App\\Models\\User', 224, 'auth_token', 'edd488fba08a067a7c88fd33ac646aec1fe231a6501924774cbadf941d6b8d0c', '[\"*\"]', '2026-01-25 16:27:55', NULL, '2026-01-15 19:04:45', '2026-01-25 16:27:55'),
(352, 'App\\Models\\User', 258, 'auth_token', '7c3e93598083c20158a205c2a00635f506772ec160095d303fabe776b7bd51a2', '[\"*\"]', NULL, NULL, '2026-01-15 20:48:46', '2026-01-15 20:48:46'),
(353, 'App\\Models\\User', 130, 'auth_token', '94f1921d8118f2a1a9f786e947fd7ef57c56ba191598cbb9ddb008cb6b0a6d2e', '[\"*\"]', '2026-01-22 06:05:41', NULL, '2026-01-16 03:17:28', '2026-01-22 06:05:41'),
(354, 'App\\Models\\User', 40, 'auth_token', '6c5d1ef7f83c07c458589f86bbfd1c4f0b2f8a4325c7c7807ea219de6cf5d52b', '[\"*\"]', '2026-01-16 15:17:10', NULL, '2026-01-16 05:31:30', '2026-01-16 15:17:10'),
(355, 'App\\Models\\User', 168, 'auth_token', 'be51a8cb8900b5c1232eaadcd41d13f83350b71371202d5e3af794811662359a', '[\"*\"]', '2026-01-16 15:24:03', NULL, '2026-01-16 13:06:53', '2026-01-16 15:24:03'),
(356, 'App\\Models\\User', 224, 'auth_token', '843b5c265eb027e7b6f571fa6c0cb700b74a41906df4d7ea98be0643eb3a6ca2', '[\"*\"]', '2026-01-23 19:34:51', NULL, '2026-01-16 14:56:14', '2026-01-23 19:34:51'),
(357, 'App\\Models\\User', 236, 'auth_token', '81caf5ec82a881faec42ad3bf074b31c3f08b49944b43febbf7716bcd825c382', '[\"*\"]', '2026-01-16 22:39:38', NULL, '2026-01-16 17:40:22', '2026-01-16 22:39:38'),
(358, 'App\\Models\\User', 236, 'auth_token', '7465d1d89ca081aff17644a12de4830cb28128711477afc94fe70de69938f629', '[\"*\"]', '2026-01-21 18:31:31', NULL, '2026-01-16 17:41:47', '2026-01-21 18:31:31'),
(359, 'App\\Models\\User', 168, 'auth_token', '06595574cbaaf00549d37f55c24e45214aa1a14afdc1a641c1982f5a5d60030e', '[\"*\"]', NULL, NULL, '2026-01-16 18:37:51', '2026-01-16 18:37:51'),
(360, 'App\\Models\\User', 236, 'auth_token', '9c218138a878661cedf56c516c19761c1f24aea026881297a39b5cc11452d7d5', '[\"*\"]', '2026-01-19 16:38:54', NULL, '2026-01-16 21:24:56', '2026-01-19 16:38:54'),
(361, 'App\\Models\\User', 259, 'auth_token', '898c13a9009ca3bafada357305fb4f92b42301f896f245a5de4b908f3482cab2', '[\"*\"]', NULL, NULL, '2026-01-16 22:21:21', '2026-01-16 22:21:21'),
(362, 'App\\Models\\User', 202, 'auth_token', 'debb43272707d41be9b3c2a9008675a22796877e5ef095d0ce94182fcadd69e5', '[\"*\"]', '2026-01-17 04:03:23', NULL, '2026-01-17 01:30:23', '2026-01-17 04:03:23'),
(363, 'App\\Models\\User', 260, 'auth_token', '07d865315e57332aa56c4da4ab9125fb4b49f7dc3ff82103ffe7e110d04d50ce', '[\"*\"]', NULL, NULL, '2026-01-18 11:28:22', '2026-01-18 11:28:22'),
(364, 'App\\Models\\User', 55, 'auth_token', '9b41513a59f1b61a7c21749b59b3daab6e00022e3deadc014dc87e607dc08b61', '[\"*\"]', '2026-01-19 21:37:25', NULL, '2026-01-18 14:38:29', '2026-01-19 21:37:25'),
(365, 'App\\Models\\User', 168, 'auth_token', '29e6c57c0a0d367c723ceac43db12817e5100a8048c84e1521402b519578ef97', '[\"*\"]', '2026-01-18 22:12:08', NULL, '2026-01-18 20:12:53', '2026-01-18 22:12:08'),
(366, 'App\\Models\\User', 261, 'auth_token', '7bee3db58588e787a6665418da08638da6f3eb21dee6336cb5a8ce30a2827722', '[\"*\"]', '2026-01-18 22:24:34', NULL, '2026-01-18 21:36:44', '2026-01-18 22:24:34'),
(367, 'App\\Models\\User', 236, 'auth_token', '4581dda743e3b04f6f2a59cae2e72ab5c49dafd8eef5b14a241c533f508b23ef', '[\"*\"]', '2026-01-25 19:35:41', NULL, '2026-01-19 16:43:23', '2026-01-25 19:35:41'),
(368, 'App\\Models\\User', 236, 'auth_token', '785aa7ef143b043881ad91c52177beb062985918cf9e0e740bdd952a44677b2b', '[\"*\"]', '2026-01-19 20:30:01', NULL, '2026-01-19 16:49:37', '2026-01-19 20:30:01'),
(369, 'App\\Models\\User', 38, 'auth_token', 'f166e8dbd19e9d68ded1f21d8a9bf99a7c21a57a4846995773f5196ad9d3630c', '[\"*\"]', '2026-01-24 16:57:33', NULL, '2026-01-19 18:35:20', '2026-01-24 16:57:33'),
(370, 'App\\Models\\User', 262, 'auth_token', '5a0120166149c10bc0687f126f79ad913d7ea05eb52522cd255a63aaf8f69283', '[\"*\"]', '2026-01-20 01:17:17', NULL, '2026-01-19 23:23:56', '2026-01-20 01:17:17'),
(371, 'App\\Models\\User', 168, 'auth_token', '34a0c0da445b723377ed6a3043a7d3a148ee195e53c2dc5055a2e65b7b99364d', '[\"*\"]', NULL, NULL, '2026-01-19 23:34:45', '2026-01-19 23:34:45'),
(372, 'App\\Models\\User', 263, 'auth_token', '0f4f5a6c1306b48161345e81e146f623a26dbc7d2ef629b1d2920551b024a1ea', '[\"*\"]', '2026-01-20 02:24:10', NULL, '2026-01-20 01:40:16', '2026-01-20 02:24:10'),
(373, 'App\\Models\\User', 55, 'auth_token', 'f523e7a53381d01b083b4dad032ad64a5c9b3c1f12a104a1553a7e79353efc27', '[\"*\"]', '2026-01-20 14:33:44', NULL, '2026-01-20 13:14:22', '2026-01-20 14:33:44'),
(374, 'App\\Models\\User', 167, 'auth_token', 'b48d656c4bcc6e84fe3bc459bf0a6f91785497375c7214c7cf69c23630a7554c', '[\"*\"]', NULL, NULL, '2026-01-20 14:52:04', '2026-01-20 14:52:04'),
(375, 'App\\Models\\User', 55, 'auth_token', '93c50dbd800bbb70e84f6bfd10e5b45bab95d71753ed0b9686627dad3c543c10', '[\"*\"]', NULL, NULL, '2026-01-20 15:30:56', '2026-01-20 15:30:56'),
(376, 'App\\Models\\User', 170, 'password_reset', 'be7c355a50feae9bd705e49d8e582dfa15cdbd8c2552d756aa7c3b403d476a65', '[\"password-reset\"]', NULL, '2026-01-20 16:34:35', '2026-01-20 16:04:35', '2026-01-20 16:04:35'),
(377, 'App\\Models\\User', 170, 'auth_token', '5a5776e3f3f5cd4e18b455dcbff5afb068f2e78f7b9bb6e74f4420e6c9f24551', '[\"*\"]', '2026-01-22 21:43:47', NULL, '2026-01-20 16:06:41', '2026-01-22 21:43:47'),
(378, 'App\\Models\\User', 168, 'auth_token', 'd94348808658811afeae33382e2c6725e8f444bbaff8165daec996e8e4a9f28c', '[\"*\"]', '2026-01-20 16:27:42', NULL, '2026-01-20 16:21:18', '2026-01-20 16:27:42'),
(379, 'App\\Models\\User', 59, 'auth_token', '1facb07e4383f75942fbf4f2f71d4efb0263b881a4c07cd7aa5d281f9238b1e1', '[\"*\"]', NULL, NULL, '2026-01-20 17:32:12', '2026-01-20 17:32:12'),
(380, 'App\\Models\\User', 38, 'auth_token', '49efbb82e86815216be3bbbfda249e5794e73a85f6b6e2557d2f583158fe47c3', '[\"*\"]', '2026-01-20 19:48:16', NULL, '2026-01-20 19:33:23', '2026-01-20 19:48:16'),
(381, 'App\\Models\\User', 168, 'auth_token', 'ab7cfa314c6de475173ea6183e953b3cc427680e3455d13a6887b4d6502f506e', '[\"*\"]', NULL, NULL, '2026-01-20 22:32:17', '2026-01-20 22:32:17'),
(382, 'App\\Models\\User', 265, 'auth_token', '2ab122af0a6a8b7db260844c02833254053cccfd0a8bfa5d745965333cae6756', '[\"*\"]', NULL, NULL, '2026-01-20 22:43:17', '2026-01-20 22:43:17'),
(383, 'App\\Models\\User', 168, 'auth_token', '26e016c9fb77da47e792ed452a64915132cc66715260674f15df8bc172f0d81b', '[\"*\"]', NULL, NULL, '2026-01-21 11:51:38', '2026-01-21 11:51:38'),
(384, 'App\\Models\\User', 168, 'auth_token', '3e5f589978ed3e9be52c66e1fbca14c4be5384f2e2db06745e3ba4605f82cb83', '[\"*\"]', NULL, NULL, '2026-01-21 11:52:09', '2026-01-21 11:52:09'),
(385, 'App\\Models\\User', 5, 'auth_token', '2e867ae42778978b1f58b3ba7afcfb59d6d1a60c10a18fe4dcfa008349c163f2', '[\"*\"]', '2026-01-22 14:35:54', NULL, '2026-01-21 14:24:16', '2026-01-22 14:35:54'),
(386, 'App\\Models\\User', 236, 'auth_token', '1e67403434c164add19cb6a471fcb5c6584dc1d22c483077171ba99ee80dd173', '[\"*\"]', NULL, NULL, '2026-01-21 16:08:26', '2026-01-21 16:08:26'),
(387, 'App\\Models\\User', 180, 'auth_token', 'd7e968c154eff6c6b6d4e0753e8a8941a6eb6c9e7bab18d9e2d674e9efdba46a', '[\"*\"]', '2026-01-24 17:33:54', NULL, '2026-01-21 18:48:23', '2026-01-24 17:33:54'),
(388, 'App\\Models\\User', 266, 'auth_token', 'd95b98c39ad6656fe2bbc60fe0edff75519d38fe4cec96afaebafcee87502964', '[\"*\"]', '2026-01-22 17:28:46', NULL, '2026-01-21 22:38:29', '2026-01-22 17:28:46'),
(389, 'App\\Models\\User', 180, 'auth_token', 'a9096470226574b4912a226172ce51206f49c4f0ccc0a36f905e5a30871129f9', '[\"*\"]', '2026-01-23 16:57:05', NULL, '2026-01-22 01:51:53', '2026-01-23 16:57:05'),
(390, 'App\\Models\\User', 168, 'auth_token', '4dd04280615627071a4642fb4a876a6e275419b6c966da7abfdceeba49fcbaed', '[\"*\"]', NULL, NULL, '2026-01-22 12:58:37', '2026-01-22 12:58:37'),
(391, 'App\\Models\\User', 32, 'auth_token', '1097614a99b7375f4d5dd78acc0e79d424d0963f9fab6adc509456cadf2e5c39', '[\"*\"]', NULL, NULL, '2026-01-22 14:24:59', '2026-01-22 14:24:59'),
(392, 'App\\Models\\User', 231, 'auth_token', 'c33c7d5baed932d092961a63f58b280fcd565fc7e7b054be49d083d6fb7c27aa', '[\"*\"]', '2026-01-24 02:49:02', NULL, '2026-01-22 14:31:09', '2026-01-24 02:49:02'),
(393, 'App\\Models\\User', 130, 'auth_token', 'ac21f3809a3ef1fa462e972ee7ed1a95ae8fa3ae5bb96be3200a9be23409b244', '[\"*\"]', '2026-01-25 06:34:41', NULL, '2026-01-22 15:35:46', '2026-01-25 06:34:41'),
(394, 'App\\Models\\User', 55, 'auth_token', '82c9e963618fee3412079fcae29b6678a479fd5759e1bb3252349345270f2e47', '[\"*\"]', '2026-01-22 17:41:49', NULL, '2026-01-22 16:56:51', '2026-01-22 17:41:49'),
(395, 'App\\Models\\User', 267, 'auth_token', '9f7a5508f849285d7e1d94c45cdb0ce3da544b25d01dadb39c10c1422acffb4b', '[\"*\"]', NULL, NULL, '2026-01-22 22:51:56', '2026-01-22 22:51:56'),
(396, 'App\\Models\\User', 59, 'auth_token', 'e3deeb7c81257460033c12c1c237a473695eeeeeededb3b1f18805d15459b554', '[\"*\"]', '2026-01-23 23:36:40', NULL, '2026-01-22 23:05:45', '2026-01-23 23:36:40'),
(397, 'App\\Models\\User', 268, 'auth_token', 'd6df9ddf8db3cc28a807b88c94f119241274cfda62fdbd24c852d070e8d0c24f', '[\"*\"]', NULL, NULL, '2026-01-23 16:42:59', '2026-01-23 16:42:59'),
(398, 'App\\Models\\User', 40, 'auth_token', 'f15e781b537e647371fee97457d3578d4c87c9ca5d6a889f859c6736a4bab079', '[\"*\"]', '2026-01-24 11:37:49', NULL, '2026-01-24 02:27:15', '2026-01-24 11:37:49'),
(399, 'App\\Models\\User', 69, 'auth_token', '9de5651ca68cddefd3be28258ccf7a78b168feeb42d42d5edf8e05c589187a07', '[\"*\"]', '2026-01-24 19:27:32', NULL, '2026-01-24 17:25:30', '2026-01-24 19:27:32'),
(400, 'App\\Models\\User', 130, 'auth_token', '9c6a67a187d8f90bb68171e7af5452088199a89f3941a6d24f2e4121398e7be5', '[\"*\"]', NULL, NULL, '2026-01-25 06:58:25', '2026-01-25 06:58:25');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `email`, `full_name`, `avatar_url`, `phone`, `company_name`, `phone_number`, `address`, `city`, `state`, `country`, `created_at`, `updated_at`) VALUES
(1, 1, 'demo@mavericksai.com', 'Demo User', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:45:13', '2025-10-22 01:45:13'),
(2, 2, 'Admin@mavericksai.tech', 'Admin Demo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-22 01:45:13', '2025-10-22 01:45:13'),
(3, 3, 'aowebtech13@gmail.com', 'aowebtech13', NULL, NULL, 'aowebtech13', NULL, NULL, NULL, NULL, NULL, '2025-12-03 02:49:56', '2025-12-03 02:49:56'),
(5, 5, 'mavericksandmages@gmail.com', 'Mavericks & Mages LP', NULL, NULL, 'Mavericks & Mages LP', NULL, NULL, NULL, NULL, NULL, '2025-12-03 07:37:32', '2025-12-03 07:37:32'),
(6, 6, 'omoobaadeyemi853@gmail.com', 'test', NULL, NULL, 'test', NULL, NULL, NULL, NULL, NULL, '2025-12-03 11:18:57', '2025-12-03 11:18:57'),
(7, 7, 'aribisala.adekunle@gmail.com', 'Adekunle Aribisala', NULL, NULL, 'Adekunle Aribisala', NULL, NULL, NULL, NULL, NULL, '2025-12-03 15:00:24', '2025-12-03 15:00:24'),
(8, 8, 'kolpnc@gmail.com', 'Kayode Ojo', NULL, NULL, 'Kayode Ojo', NULL, NULL, NULL, NULL, NULL, '2025-12-03 17:31:24', '2025-12-03 17:31:24'),
(9, 9, 'kayodeadeniyiesq@gmail.com', 'Kayode Adeniyi', NULL, NULL, 'Kayode Adeniyi', NULL, NULL, NULL, NULL, NULL, '2025-12-03 18:46:01', '2025-12-03 18:46:01'),
(10, 10, 'thesmartlawyerng@gmail.com', 'Oluwabusola O. Oluwaniyi', NULL, NULL, 'Oluwabusola O. Oluwaniyi', NULL, NULL, NULL, NULL, NULL, '2025-12-03 19:33:22', '2025-12-03 19:33:22'),
(11, 11, 'onyinajoke@gmail.com', 'Ajoke Onyinyechi Oseni', NULL, NULL, 'Ajoke Onyinyechi Oseni', NULL, NULL, NULL, NULL, NULL, '2025-12-03 20:42:54', '2025-12-03 20:42:54'),
(12, 12, 'bank4law@yahoo.com', 'Bamikole A.P. Folorunso & Co.', NULL, NULL, 'Bamikole A.P. Folorunso & Co.', NULL, NULL, NULL, NULL, NULL, '2025-12-03 21:14:14', '2025-12-03 21:14:14'),
(13, 13, 'toluwalopeomotola@gmail.com', 'Omotola', NULL, NULL, 'Omotola', NULL, NULL, NULL, NULL, NULL, '2025-12-03 21:35:19', '2025-12-03 21:35:19'),
(14, 14, 'kehinde@kenndleyattorneys.com.ng', 'KENNDLEY ATTORNEYS', NULL, NULL, 'KENNDLEY ATTORNEYS', NULL, NULL, NULL, NULL, NULL, '2025-12-03 22:41:14', '2025-12-03 22:41:14'),
(15, 15, 'pringy92@gmail.com', 'Shalom', NULL, NULL, 'Shalom', NULL, NULL, NULL, NULL, NULL, '2025-12-03 23:26:00', '2025-12-03 23:26:00'),
(16, 16, 'tomiikeadebayo@gmail.com', 'tomiikeadebayo@gmail.com', NULL, NULL, 'tomiikeadebayo@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-04 00:22:13', '2025-12-04 00:22:13'),
(17, 17, 'adlerdebexpressions@gmail.com', 'Adlerdeb', NULL, NULL, 'Adlerdeb', NULL, NULL, NULL, NULL, NULL, '2025-12-04 00:49:37', '2025-12-04 00:49:37'),
(18, 18, 'sholatteh@gmail.com', 'Folorunsho', NULL, NULL, 'Folorunsho', NULL, NULL, NULL, NULL, NULL, '2025-12-04 01:23:30', '2025-12-04 01:23:30'),
(19, 19, 'toperichard23@gmail.com', 'Richard', NULL, NULL, 'Richard', NULL, NULL, NULL, NULL, NULL, '2025-12-04 01:30:44', '2025-12-04 01:30:44'),
(20, 20, 'yemisiola4ril@yahoo.com', 'Oluwayemisi Enilolobo', NULL, NULL, 'Oluwayemisi Enilolobo', NULL, NULL, NULL, NULL, NULL, '2025-12-04 01:53:25', '2025-12-04 01:53:25'),
(21, 21, 'adebimpegbadegesin@gmail.com', 'Adebimpe Gbadegesin', NULL, NULL, 'Adebimpe Gbadegesin', NULL, NULL, NULL, NULL, NULL, '2025-12-04 02:21:19', '2025-12-04 02:21:19'),
(22, 22, 'estherayoyimika2@gmail.com', 'Olajide firm', NULL, NULL, 'Olajide firm', NULL, NULL, NULL, NULL, NULL, '2025-12-04 02:33:39', '2025-12-04 02:33:39'),
(23, 23, 'amaocaroline7@gmail.com', 'Caroline', NULL, NULL, 'Caroline', NULL, NULL, NULL, NULL, NULL, '2025-12-04 02:36:51', '2025-12-04 02:36:51'),
(24, 24, 'adedoyin.adesoji@yahoo.com', 'Adesoji Adedoyin', NULL, NULL, 'Adesoji Adedoyin', NULL, NULL, NULL, NULL, NULL, '2025-12-04 09:06:49', '2025-12-04 09:06:49'),
(25, 25, 'hakingbesote@gmail.com', 'Henry Akingbesote', NULL, NULL, 'Henry Akingbesote', NULL, NULL, NULL, NULL, NULL, '2025-12-04 11:22:45', '2025-12-04 11:22:45'),
(26, 26, 'imoleayomide.adesanya@gmail.com', 'Imoleayo', NULL, NULL, 'Imoleayo', NULL, NULL, NULL, NULL, NULL, '2025-12-04 12:04:27', '2025-12-04 12:04:27'),
(27, 27, 'oluwagbotemimerotohun@gmail.com', 'Merotohun Oluwagbotemi', NULL, NULL, 'Merotohun Oluwagbotemi', NULL, NULL, NULL, NULL, NULL, '2025-12-04 12:13:48', '2025-12-04 12:13:48'),
(28, 28, 'timothyadewale2002@gmail.com', 'Timothy Adewale', NULL, NULL, 'Timothy Adewale', NULL, NULL, NULL, NULL, NULL, '2025-12-04 13:51:47', '2025-12-04 13:51:47'),
(29, 29, 'bosabby@yahoo.com', 'Abosede Akinsola', NULL, NULL, 'Abosede Akinsola', NULL, NULL, NULL, NULL, NULL, '2025-12-04 18:40:59', '2025-12-04 18:40:59'),
(30, 30, 'o.t.babafemisolicitors@gmail.com', 'O.T Babafemi', NULL, NULL, 'O.T Babafemi', NULL, NULL, NULL, NULL, NULL, '2025-12-04 19:09:17', '2025-12-04 19:09:17'),
(31, 31, 'tlasunks@gmail.com', 'Temitope Soderu', NULL, NULL, 'Temitope Soderu', NULL, NULL, NULL, NULL, NULL, '2025-12-04 19:39:14', '2025-12-04 19:39:14'),
(32, 32, 'saydola75@gmail.com', 'Intelex Legal', NULL, NULL, 'Intelex Legal', NULL, NULL, NULL, NULL, NULL, '2025-12-04 19:57:09', '2025-12-04 19:57:09'),
(33, 33, 'oladoyinonanuga@yahoo.com', 'Oladoyin Onanuga', NULL, NULL, 'Oladoyin Onanuga', NULL, NULL, NULL, NULL, NULL, '2025-12-04 22:06:25', '2025-12-04 22:06:25'),
(34, 34, 'bluefieldattorneys@gmail.com', 'BUSINESS', NULL, NULL, 'BUSINESS', NULL, NULL, NULL, NULL, NULL, '2025-12-05 12:11:44', '2025-12-05 12:11:44'),
(35, 35, 'whywalex2002@yahoo.com', 'O.Y Arogundade & co', NULL, NULL, 'O.Y Arogundade & co', NULL, NULL, NULL, NULL, NULL, '2025-12-05 17:33:16', '2025-12-05 17:33:16'),
(36, 36, 'abodunrin.oluwatoyin@yahoo.com', 'AOA Jurist Consult', NULL, NULL, 'AOA Jurist Consult', NULL, NULL, NULL, NULL, NULL, '2025-12-05 19:36:04', '2025-12-05 19:36:04'),
(37, 37, 'ayoakande29@gmail.com', 'Ayoade Akande', NULL, NULL, 'Ayoade Akande', NULL, NULL, NULL, NULL, NULL, '2025-12-06 02:18:49', '2025-12-06 02:18:49'),
(38, 38, 'ibironkebolanle2@gmail.com', 'ibironkebolanle2@gmail.com', NULL, NULL, 'ibironkebolanle2@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-07 00:36:20', '2025-12-07 00:36:20'),
(39, 39, 'ibiloyeabisade337@gmail.com', 'ibiloyeabisade337@gmail.com', NULL, NULL, 'ibiloyeabisade337@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-07 00:41:49', '2025-12-07 00:41:49'),
(40, 40, 'jomilojufavour5@gmail.com', 'jomilojufavour5@gmail.com', NULL, NULL, 'jomilojufavour5@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-07 00:42:06', '2025-12-07 00:42:06'),
(41, 41, 'ayanbukolaayandeji@gmail.com', 'ayanbukolaayandeji@gmail.com', NULL, NULL, 'ayanbukolaayandeji@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-07 01:03:36', '2025-12-07 01:03:36'),
(42, 42, 'faridalabi7@gmail.com', 'faridalabi7@gmail.com', NULL, NULL, 'faridalabi7@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-07 01:05:06', '2025-12-07 01:05:06'),
(43, 43, 'ayanbukolaayandeji0@gmail.com', 'ayanbukolaayandeji0@gmail.com', NULL, NULL, 'ayanbukolaayandeji0@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-07 01:06:59', '2025-12-07 01:06:59'),
(44, 44, 'marvelogunleye8@gmail.com', 'marvelogunleye8@gmail.com', NULL, NULL, 'marvelogunleye8@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-07 01:11:33', '2025-12-07 01:11:33'),
(45, 45, 'idowubusayop@gmail.com', 'Busayo Idowu', NULL, NULL, 'Busayo Idowu', NULL, NULL, NULL, NULL, NULL, '2025-12-07 01:49:17', '2025-12-07 01:49:17'),
(46, 46, 'akinboladeomowumi24@gmail.com', 'akinboladeomowumi24@gmail.com', NULL, NULL, 'akinboladeomowumi24@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-07 02:17:57', '2025-12-07 02:17:57'),
(47, 47, 'rhodeeyahadetola@gmail.com', 'Rhadiat Balogun', NULL, NULL, 'Rhadiat Balogun', NULL, NULL, NULL, NULL, NULL, '2025-12-07 15:16:42', '2025-12-07 15:16:42'),
(48, 48, 'jojoley@yahoo.com', 'C. E. AFORGWU AND COMPANY', NULL, NULL, 'C. E. AFORGWU AND COMPANY', NULL, NULL, NULL, NULL, NULL, '2025-12-07 23:34:34', '2025-12-07 23:34:34'),
(49, 49, 'samuelorupabo@gmail.com', 'S. T. O. Amatonjie', NULL, NULL, 'S. T. O. Amatonjie', NULL, NULL, NULL, NULL, NULL, '2025-12-08 00:49:26', '2025-12-08 00:49:26'),
(50, 50, 'victorsammie13@gmail.com', 'Victor Samson', NULL, NULL, 'Victor Samson', NULL, NULL, NULL, NULL, NULL, '2025-12-08 12:11:17', '2025-12-08 12:11:17'),
(51, 51, 'lodestarpartners@gmail.com', 'Lodestar Partners', NULL, NULL, 'Lodestar Partners', NULL, NULL, NULL, NULL, NULL, '2025-12-08 15:54:10', '2025-12-08 15:54:10'),
(52, 52, 'olamilekan4196@gmail.com', 'olamilekan4196@gmail.com', NULL, NULL, 'olamilekan4196@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-08 16:05:02', '2025-12-08 16:05:02'),
(53, 53, 'eberevictorobuzor@gmail.com', 'Ebere Victor Obuzor & Co', NULL, NULL, 'Ebere Victor Obuzor & Co', NULL, NULL, NULL, NULL, NULL, '2025-12-09 01:32:50', '2025-12-09 01:32:50'),
(54, 54, 'akindeletunmise2003@gmail.com', 'akindeletunmise2003@gmail.com', NULL, NULL, 'akindeletunmise2003@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-09 01:34:36', '2025-12-09 01:34:36'),
(55, 55, 'tolufunkeakin@gmail.com', 'Toluwani', NULL, NULL, 'Toluwani', NULL, NULL, NULL, NULL, NULL, '2025-12-09 10:38:50', '2025-12-09 10:38:50'),
(56, 56, 'dapo@aetoslegal.com', 'Dapo Ogunmilade', NULL, NULL, 'Dapo Ogunmilade', NULL, NULL, NULL, NULL, NULL, '2025-12-09 14:48:23', '2025-12-09 14:48:23'),
(57, 57, 'babalolaoluwatoyin87@gmail.com', 'AOA Jurist Consult', NULL, NULL, 'AOA Jurist Consult', NULL, NULL, NULL, NULL, NULL, '2025-12-09 19:35:15', '2025-12-09 19:35:15'),
(58, 58, 'yennybimbo@gmail.com', 'Abimbola Adebanjo Fatunbi', NULL, NULL, 'Abimbola Adebanjo Fatunbi', NULL, NULL, NULL, NULL, NULL, '2025-12-09 19:54:03', '2025-12-09 19:54:03'),
(59, 59, 'segun@aeclegal.com', 'AEC LEGAL LAW PRACTICE LP', NULL, NULL, 'AEC LEGAL LAW PRACTICE LP', NULL, NULL, NULL, NULL, NULL, '2025-12-10 01:12:53', '2025-12-10 01:12:53'),
(60, 60, 'ayo_faith@yahoo.com', 'Ayokunle Adetula', NULL, NULL, 'Ayokunle Adetula', NULL, NULL, NULL, NULL, NULL, '2025-12-10 09:53:43', '2025-12-10 09:53:43'),
(61, 61, 'solicitousattorney@gmail.com', 'Solicitous Attorney', NULL, NULL, 'Solicitous Attorney', NULL, NULL, NULL, NULL, NULL, '2025-12-10 11:09:26', '2025-12-10 11:09:26'),
(62, 62, 'ogbgaso40@gmail.com', 'John Osaro', NULL, NULL, 'John Osaro', NULL, NULL, NULL, NULL, NULL, '2025-12-10 18:02:28', '2025-12-10 18:02:28'),
(63, 63, 'olatundeojeladun@gmail.com', 'The Cedar Associates', NULL, NULL, 'The Cedar Associates', NULL, NULL, NULL, NULL, NULL, '2025-12-10 23:45:00', '2025-12-10 23:45:00'),
(64, 64, 'ishayapeace47@gmail.com', 'Ishaya peace', NULL, NULL, 'Ishaya peace', NULL, NULL, NULL, NULL, NULL, '2025-12-11 02:03:09', '2025-12-11 02:03:09'),
(65, 65, 'megaliousr1ingp@gmail.com', 'Stella Fiade', NULL, NULL, 'Stella Fiade', NULL, NULL, NULL, NULL, NULL, '2025-12-11 04:16:55', '2025-12-11 04:16:55'),
(66, 66, 'ore670@yahoo.com', 'Oreoluwa Oduniyi', NULL, NULL, 'Oreoluwa Oduniyi', NULL, NULL, NULL, NULL, NULL, '2025-12-11 21:40:43', '2025-12-11 21:40:43'),
(67, 67, 'oshama2014@gmail.com', 'Oshama', NULL, NULL, 'Oshama', NULL, NULL, NULL, NULL, NULL, '2025-12-12 01:46:09', '2025-12-12 01:46:09'),
(68, 68, 'ajimoti.mercy@gmail.com', 'Mercy Amole-Ajimoti', NULL, NULL, 'Mercy Amole-Ajimoti', NULL, NULL, NULL, NULL, NULL, '2025-12-12 08:37:07', '2025-12-12 08:37:07'),
(69, 69, 'bellomohammed601@gmail.com', 'Mohammed Bello', NULL, NULL, 'Mohammed Bello', NULL, NULL, NULL, NULL, NULL, '2025-12-12 12:17:06', '2025-12-12 12:17:06'),
(70, 70, 'kollydlaw2018@gmail.com', 'kollydlaw', NULL, NULL, 'kollydlaw', NULL, NULL, NULL, NULL, NULL, '2025-12-12 18:55:21', '2025-12-12 18:55:21'),
(71, 71, 'sunkanmi.laplace@gmail.com', 'Ola Oluwadeyi', NULL, NULL, 'Ola Oluwadeyi', NULL, NULL, NULL, NULL, NULL, '2025-12-13 17:15:10', '2025-12-13 17:15:10'),
(72, 72, 'ayokunlebolu2@gmail.com', 'Ayokunle Emmanuel', NULL, NULL, 'Ayokunle Emmanuel', NULL, NULL, NULL, NULL, NULL, '2025-12-14 01:01:33', '2025-12-14 01:01:33'),
(73, 73, 'adeyemoimmanuella@gmail.com', 'Immanuella', NULL, NULL, 'Immanuella', NULL, NULL, NULL, NULL, NULL, '2025-12-14 21:41:10', '2025-12-14 21:41:10'),
(74, 74, 'yemisucks@gmail.com', 'A.E ADEYEMI', NULL, NULL, 'A.E ADEYEMI', NULL, NULL, NULL, NULL, NULL, '2025-12-14 21:55:54', '2025-12-14 21:55:54'),
(75, 75, 'emmanuelayomiposi101@gmail.com', 'Emmanuel Oluyemi', NULL, NULL, 'Emmanuel Oluyemi', NULL, NULL, NULL, NULL, NULL, '2025-12-14 22:19:49', '2025-12-14 22:19:49'),
(76, 76, 'favoratoyebi@gmail.com', 'Favour Atoyebi', NULL, NULL, 'Favour Atoyebi', NULL, NULL, NULL, NULL, NULL, '2025-12-14 22:28:17', '2025-12-14 22:28:17'),
(77, 77, 'japhetakinawoniran1@gmail.com', 'Japheth Akin - Awoniran', NULL, NULL, 'Japheth Akin - Awoniran', NULL, NULL, NULL, NULL, NULL, '2025-12-14 23:05:50', '2025-12-14 23:05:50'),
(78, 78, 'calebadebiyi27@gmail.com', 'Adebiyi Caleb', NULL, NULL, 'Adebiyi Caleb', NULL, NULL, NULL, NULL, NULL, '2025-12-14 23:16:55', '2025-12-14 23:16:55'),
(79, 79, 'adeogunblessing6@gmail.com', 'Adeogun Blessing Olanike', NULL, NULL, 'Adeogun Blessing Olanike', NULL, NULL, NULL, NULL, NULL, '2025-12-15 00:49:09', '2025-12-15 00:49:09'),
(80, 80, 'peacelisa123@gmail.com', 'Peace Amarachi Ogbu', NULL, NULL, 'Peace Amarachi Ogbu', NULL, NULL, NULL, NULL, NULL, '2025-12-15 13:50:53', '2025-12-15 13:50:53'),
(81, 81, 'gbohunmiakinribide@gmail.com', 'Akinribide Oluwagbohunmi Esther', NULL, NULL, 'Akinribide Oluwagbohunmi Esther', NULL, NULL, NULL, NULL, NULL, '2025-12-15 16:39:31', '2025-12-15 16:39:31'),
(82, 82, 'rezeugwuifeoma4real@gmail.com', 'rezeugwuifeoma4real@gmail.com', NULL, NULL, 'rezeugwuifeoma4real@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-15 18:41:28', '2025-12-15 18:41:28'),
(83, 83, 'tahrandy31@gmail.com', 'Tah Randy Jangha', NULL, NULL, 'Tah Randy Jangha', NULL, NULL, NULL, NULL, NULL, '2025-12-15 19:49:49', '2025-12-15 19:49:49'),
(84, 84, 'favouradelusi17@gmail.com', 'ADELUSI FAVOUR OLUWAFIFUNMI', NULL, NULL, 'ADELUSI FAVOUR OLUWAFIFUNMI', NULL, NULL, NULL, NULL, NULL, '2025-12-15 19:56:22', '2025-12-15 19:56:22'),
(85, 85, 'busolaotunaiya@gmail.com', 'Oluwabusola O. Oluwaniyi', NULL, NULL, 'Oluwabusola O. Oluwaniyi', NULL, NULL, NULL, NULL, NULL, '2025-12-15 20:03:44', '2025-12-15 20:03:44'),
(86, 86, 'sheunne141@gmail.com', 'Adeyemi Oluwaseun', NULL, NULL, 'Adeyemi Oluwaseun', NULL, NULL, NULL, NULL, NULL, '2025-12-15 21:03:54', '2025-12-15 21:03:54'),
(87, 87, 'ilemobayomoyinoluwa2005@gmail.com', 'Moyinoluwa', NULL, NULL, 'Moyinoluwa', NULL, NULL, NULL, NULL, NULL, '2025-12-16 00:29:48', '2025-12-16 00:29:48'),
(88, 88, 'ikotunmichael591@gmail.com', 'Ikotun Michael', NULL, NULL, 'Ikotun Michael', NULL, NULL, NULL, NULL, NULL, '2025-12-16 00:29:58', '2025-12-16 00:29:58'),
(89, 89, 'testimonyolajide09@gmail.com', 'testimonyolajide09@gmail.com', NULL, NULL, 'testimonyolajide09@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 00:32:22', '2025-12-16 00:32:22'),
(90, 90, 'maryadeshola10@gmail.com', 'Dada Mary Adesola', NULL, NULL, 'Dada Mary Adesola', NULL, NULL, NULL, NULL, NULL, '2025-12-16 00:33:45', '2025-12-16 00:33:45'),
(91, 91, 'akinniyirichard2022@gmail.com', 'Richard', NULL, NULL, 'Richard', NULL, NULL, NULL, NULL, NULL, '2025-12-16 00:34:04', '2025-12-16 00:34:04'),
(92, 92, 'ikotunzion1907@gmail.com', 'ikotunzion1907@gmail.com', NULL, NULL, 'ikotunzion1907@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 00:42:03', '2025-12-16 00:42:03'),
(93, 93, 'preciouslizzy643@gmail.com', 'Ahmed Gift zaniab', NULL, NULL, 'Ahmed Gift zaniab', NULL, NULL, NULL, NULL, NULL, '2025-12-16 00:42:54', '2025-12-16 00:42:54'),
(94, 94, 'ihppiness152@gmail.com', 'Moyinoluwa', NULL, NULL, 'Moyinoluwa', NULL, NULL, NULL, NULL, NULL, '2025-12-16 00:45:40', '2025-12-16 00:45:40'),
(95, 95, 'ifeoluwap931@gmail.com', 'ifeoluwap931@gmail.com', NULL, NULL, 'ifeoluwap931@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 00:48:27', '2025-12-16 00:48:27'),
(96, 96, 'okelolaoluwatitofunmi@gmail.com', 'okelolaoluwatitofunmi@gmail.com', NULL, NULL, 'okelolaoluwatitofunmi@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 00:51:37', '2025-12-16 00:51:37'),
(97, 97, 'olakunlejosh10@gmail.com', 'Olakunle', NULL, NULL, 'Olakunle', NULL, NULL, NULL, NULL, NULL, '2025-12-16 00:52:10', '2025-12-16 00:52:10'),
(98, 98, 'ayomidedocras@gmail.com', 'Ayomide', NULL, NULL, 'Ayomide', NULL, NULL, NULL, NULL, NULL, '2025-12-16 00:52:55', '2025-12-16 00:52:55'),
(99, 99, 'jegededebby71@gmail.com', 'Jegede Deborah', NULL, NULL, 'Jegede Deborah', NULL, NULL, NULL, NULL, NULL, '2025-12-16 01:00:10', '2025-12-16 01:00:10'),
(100, 100, 'favourashaolu22@gmail.com', 'Favour', NULL, NULL, 'Favour', NULL, NULL, NULL, NULL, NULL, '2025-12-16 01:00:40', '2025-12-16 01:00:40'),
(101, 101, 'michaelolawale640@gmail.com', 'michaelolawale640@gmail.com', NULL, NULL, 'michaelolawale640@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 01:21:39', '2025-12-16 01:21:39'),
(102, 102, 'sgttomiwa@gmail.com', 'Oreoluwa', NULL, NULL, 'Oreoluwa', NULL, NULL, NULL, NULL, NULL, '2025-12-16 02:06:28', '2025-12-16 02:06:28'),
(103, 103, 'obidareboluwatifeeniola@gmail.com', 'Obidare boluwatife', NULL, NULL, 'Obidare boluwatife', NULL, NULL, NULL, NULL, NULL, '2025-12-16 02:07:32', '2025-12-16 02:07:32'),
(104, 104, 'favourbenjamin92@gmail.com', 'Favour', NULL, NULL, 'Favour', NULL, NULL, NULL, NULL, NULL, '2025-12-16 02:13:28', '2025-12-16 02:13:28'),
(105, 105, 'estherajayi204@gmail.com', 'Law student', NULL, NULL, 'Law student', NULL, NULL, NULL, NULL, NULL, '2025-12-16 06:24:01', '2025-12-16 06:24:01'),
(106, 106, 'dideprecious@gmail.com', 'dideprecious@gmail.com', NULL, NULL, 'dideprecious@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 12:10:06', '2025-12-16 12:10:06'),
(107, 107, 'akinleyetomisin89@gmail.com', 'akinleyetomisin89@gmail.com', NULL, NULL, 'akinleyetomisin89@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 12:29:43', '2025-12-16 12:29:43'),
(108, 108, 'mercyoyindamola613@gmail.com', 'mercyoyindamola613@gmail.com', NULL, NULL, 'mercyoyindamola613@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 12:33:53', '2025-12-16 12:33:53'),
(109, 109, 'baruwafawaz5@gmail.com', 'baruwafawaz5@gmail.com', NULL, NULL, 'baruwafawaz5@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 12:34:22', '2025-12-16 12:34:22'),
(110, 110, 'fayemigrace4real@gmail.com', 'fayemigrace4real@gmail.com', NULL, NULL, 'fayemigrace4real@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 12:34:57', '2025-12-16 12:34:57'),
(111, 111, 'praisezionlight@gmail.com', 'praisezionlight@gmail.com', NULL, NULL, 'praisezionlight@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 12:41:11', '2025-12-16 12:41:11'),
(112, 112, 'aliyahadewale9@gmail.com', 'aliyahadewale9@gmail.com', NULL, NULL, 'aliyahadewale9@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 12:41:25', '2025-12-16 12:41:25'),
(113, 113, 'muwaliusofiyata@gmail.com', 'Muwaliu Sofiyat Asake', NULL, NULL, 'Muwaliu Sofiyat Asake', NULL, NULL, NULL, NULL, NULL, '2025-12-16 12:52:12', '2025-12-16 12:52:12'),
(114, 114, 'akerequeen2020@gmail.com', 'akerequeen2020@gmail.com', NULL, NULL, 'akerequeen2020@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 12:56:13', '2025-12-16 12:56:13'),
(115, 115, 'ajagbemotunrayo042@gmail.com', 'ajagbemotunrayo042@gmail.com', NULL, NULL, 'ajagbemotunrayo042@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 12:59:39', '2025-12-16 12:59:39'),
(116, 116, 'omotolaogunola@gmail.com', 'omotolaogunola@gmail.com', NULL, NULL, 'omotolaogunola@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 13:11:29', '2025-12-16 13:11:29'),
(117, 117, 'haywhy.com01@gmail.com', 'haywhy.com01@gmail.com', NULL, NULL, 'haywhy.com01@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 13:28:00', '2025-12-16 13:28:00'),
(118, 118, 'akejuquayumadebayo@gmail.com', 'Adebayo', NULL, NULL, 'Adebayo', NULL, NULL, NULL, NULL, NULL, '2025-12-16 14:18:12', '2025-12-16 14:18:12'),
(119, 119, 'iremidedawoodakerele@gmail.com', 'Iremide', NULL, NULL, 'Iremide', NULL, NULL, NULL, NULL, NULL, '2025-12-16 14:21:50', '2025-12-16 14:21:50'),
(120, 120, 'olanrewajuolanite5@gmail.com', 'olanrewajuolanite5@gmail.com', NULL, NULL, 'olanrewajuolanite5@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 14:23:01', '2025-12-16 14:23:01'),
(121, 121, 'graceadodoobehi21@gmail.com', 'Obehioya Adodo', NULL, NULL, 'Obehioya Adodo', NULL, NULL, NULL, NULL, NULL, '2025-12-16 14:29:23', '2025-12-16 14:29:23'),
(122, 122, 'ayodejiibrahimoladimeji@gmail.com', 'Oladimeji', NULL, NULL, 'Oladimeji', NULL, NULL, NULL, NULL, NULL, '2025-12-16 14:41:15', '2025-12-16 14:41:15'),
(123, 123, 'ibzamawac@gmail.com', 'Ibzama WAC', NULL, NULL, 'Ibzama WAC', NULL, NULL, NULL, NULL, NULL, '2025-12-16 14:57:32', '2025-12-16 14:57:32'),
(124, 124, 'adegboyeismail149@gmail.com', 'A.I.Adegboye', NULL, NULL, 'A.I.Adegboye', NULL, NULL, NULL, NULL, NULL, '2025-12-16 15:13:13', '2025-12-16 15:13:13'),
(125, 125, 'agbeyangioluwafikunayomi@gmail.com', 'agbeyangioluwafikunayomi@gmail.com', NULL, NULL, 'agbeyangioluwafikunayomi@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 15:20:39', '2025-12-16 15:20:39'),
(126, 126, 'abdullahabdulwasii03@gmail.com', 'Abdul-Wasii Abdullah Olawale', NULL, NULL, 'Abdul-Wasii Abdullah Olawale', NULL, NULL, NULL, NULL, NULL, '2025-12-16 15:30:08', '2025-12-16 15:30:08'),
(127, 127, 'victoriaonwukwe34@gmail.com', 'Victoria Onwukwe', NULL, NULL, 'Victoria Onwukwe', NULL, NULL, NULL, NULL, NULL, '2025-12-16 16:25:21', '2025-12-16 16:25:21'),
(128, 128, 'abiola260@gmail.com', 'abiola260@gmail.com', NULL, NULL, 'abiola260@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 17:19:23', '2025-12-16 17:19:23'),
(129, 129, 'praiseabiola260@gmail.com', 'praiseabiola260@gmail.com', NULL, NULL, 'praiseabiola260@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-16 17:24:07', '2025-12-16 17:24:07'),
(130, 130, 'akinpelugloria714@gmail.com', 'Gloria', NULL, NULL, 'Gloria', NULL, NULL, NULL, NULL, NULL, '2025-12-16 17:40:38', '2025-12-16 17:40:38'),
(131, 131, 'damlaughter@gmail.com', 'Ayeni Damilola Laughter', NULL, NULL, 'Ayeni Damilola Laughter', NULL, NULL, NULL, NULL, NULL, '2025-12-16 20:49:01', '2025-12-16 20:49:01'),
(132, 132, 'amasasuccess32@gmail.com', 'Amasa', NULL, NULL, 'Amasa', NULL, NULL, NULL, NULL, NULL, '2025-12-16 21:37:15', '2025-12-16 21:37:15'),
(133, 133, 'gabrieloluwatobiloba14@gmail.com', 'Gabriel', NULL, NULL, 'Gabriel', NULL, NULL, NULL, NULL, NULL, '2025-12-16 22:24:04', '2025-12-16 22:24:04'),
(134, 134, 'hephzibah904@gmail.com', 'Hephzyy', NULL, NULL, 'Hephzyy', NULL, NULL, NULL, NULL, NULL, '2025-12-16 22:27:49', '2025-12-16 22:27:49'),
(135, 135, 'faniranmarvellousboluwatife@gmail.com', 'Faniran marvellous Boluwatife', NULL, NULL, 'Faniran marvellous Boluwatife', NULL, NULL, NULL, NULL, NULL, '2025-12-16 22:29:40', '2025-12-16 22:29:40'),
(136, 136, 'olajidemichelle13@gmail.com', 'Michelle Olajide', NULL, NULL, 'Michelle Olajide', NULL, NULL, NULL, NULL, NULL, '2025-12-16 22:42:50', '2025-12-16 22:42:50'),
(137, 137, 'veronicaaraoye13@gmail.com', 'Uniosun integrity law chamber', NULL, NULL, 'Uniosun integrity law chamber', NULL, NULL, NULL, NULL, NULL, '2025-12-16 22:58:36', '2025-12-16 22:58:36'),
(138, 138, 'azeezdeborah12@gmail.com', 'Similoluwa', NULL, NULL, 'Similoluwa', NULL, NULL, NULL, NULL, NULL, '2025-12-16 23:01:36', '2025-12-16 23:01:36'),
(139, 139, 'ayomikungabriel0@gmail.com', 'Omole Ayomikun', NULL, NULL, 'Omole Ayomikun', NULL, NULL, NULL, NULL, NULL, '2025-12-16 23:05:15', '2025-12-16 23:05:15'),
(140, 140, 'ayomideamosu36@gmail.com', 'Amosu Ayomide mercy', NULL, NULL, 'Amosu Ayomide mercy', NULL, NULL, NULL, NULL, NULL, '2025-12-16 23:24:07', '2025-12-16 23:24:07'),
(141, 141, 'temilolaaloko@gmail.com', 'Vickee', NULL, NULL, 'Vickee', NULL, NULL, NULL, NULL, NULL, '2025-12-16 23:32:53', '2025-12-16 23:32:53'),
(142, 142, 'chrisnonso2007@gmail.com', 'TheDawnOfChris', NULL, NULL, 'TheDawnOfChris', NULL, NULL, NULL, NULL, NULL, '2025-12-16 23:33:44', '2025-12-16 23:33:44'),
(143, 143, 'adeolaadewumitope@gmail.com', 'Adewumi Adeola Temitope', NULL, NULL, 'Adewumi Adeola Temitope', NULL, NULL, NULL, NULL, NULL, '2025-12-16 23:37:06', '2025-12-16 23:37:06'),
(144, 144, 'peterfasiku1@gmail.com', 'Fasiku Peter', NULL, NULL, 'Fasiku Peter', NULL, NULL, NULL, NULL, NULL, '2025-12-17 01:02:05', '2025-12-17 01:02:05'),
(145, 145, 'nurotashabi012@gmail.com', 'Abdulkareem Nurot', NULL, NULL, 'Abdulkareem Nurot', NULL, NULL, NULL, NULL, NULL, '2025-12-17 01:18:46', '2025-12-17 01:18:46'),
(146, 146, 'bayokrus@gmail.com', 'Adebayo Oluwaferanmi esq', NULL, NULL, 'Adebayo Oluwaferanmi esq', NULL, NULL, NULL, NULL, NULL, '2025-12-17 02:02:49', '2025-12-17 02:02:49'),
(147, 147, 'oluwaseunfamuyibo185@gmail.com', 'LAWSUN', NULL, NULL, 'LAWSUN', NULL, NULL, NULL, NULL, NULL, '2025-12-17 03:31:54', '2025-12-17 03:31:54'),
(148, 148, 'omolara.palmer@students.jabu.edu.ng', 'omolara.palmer@students.jabu.edu.ng', NULL, NULL, 'omolara.palmer@students.jabu.edu.ng', NULL, NULL, NULL, NULL, NULL, '2025-12-17 08:17:39', '2025-12-17 08:17:39'),
(149, 149, 'oluwabukola.orisaleye@students.jabu.edu.ng', 'Orisaleye Grace Oluwabukola', NULL, NULL, 'Orisaleye Grace Oluwabukola', NULL, NULL, NULL, NULL, NULL, '2025-12-17 19:07:35', '2025-12-17 19:07:35'),
(150, 150, 'adewalep260@gmail.com', 'Adewale Peter', NULL, NULL, 'Adewale Peter', NULL, NULL, NULL, NULL, NULL, '2025-12-17 23:04:36', '2025-12-17 23:04:36'),
(151, 151, 'garycork26@gmail.com', 'oscar sandoval', NULL, NULL, 'oscar sandoval', NULL, NULL, NULL, NULL, NULL, '2025-12-18 02:36:36', '2025-12-18 02:36:36'),
(152, 152, 'osbornecj79@yahoo.com', 'Chinedu Ossai', NULL, NULL, 'Chinedu Ossai', NULL, NULL, NULL, NULL, NULL, '2025-12-18 19:28:06', '2025-12-18 19:28:06'),
(153, 153, 'ilerioluwa.ogunyemi@students.jabu.edu.ng', 'Ilerioluwa Ogunyemi', NULL, NULL, 'Ilerioluwa Ogunyemi', NULL, NULL, NULL, NULL, NULL, '2025-12-18 19:59:54', '2025-12-18 19:59:54'),
(154, 154, 'adeniyitosin120@gmail.com', 'Adeniyi Tosin Gloria', NULL, NULL, 'Adeniyi Tosin Gloria', NULL, NULL, NULL, NULL, NULL, '2025-12-19 14:29:34', '2025-12-19 14:29:34'),
(155, 155, 'enenchefavour4@gmail.com', 'Enenche Favour', NULL, NULL, 'Enenche Favour', NULL, NULL, NULL, NULL, NULL, '2025-12-19 15:25:21', '2025-12-19 15:25:21'),
(156, 156, 'k80376196@gmail.com', 'Khaleelat', NULL, NULL, 'Khaleelat', NULL, NULL, NULL, NULL, NULL, '2025-12-20 13:48:10', '2025-12-20 13:48:10'),
(157, 157, 'excelsiorlegalconsult@gmail.com', 'Excelsior Legal Consult', NULL, NULL, 'Excelsior Legal Consult', NULL, NULL, NULL, NULL, NULL, '2025-12-20 14:55:52', '2025-12-20 14:55:52'),
(158, 158, 'sunmisolabukola9@gmail.com', 'Sunmisola Akintayo', NULL, NULL, 'Sunmisola Akintayo', NULL, NULL, NULL, NULL, NULL, '2025-12-20 17:06:22', '2025-12-20 17:06:22'),
(159, 159, 'molayoayofagbe@gmail.com', 'Ayo-Fagbe Molayo', NULL, NULL, 'Ayo-Fagbe Molayo', NULL, NULL, NULL, NULL, NULL, '2025-12-21 13:01:37', '2025-12-21 13:01:37'),
(160, 160, 'adejotimothy090@gmail.com', 'Jabu', NULL, NULL, 'Jabu', NULL, NULL, NULL, NULL, NULL, '2025-12-22 13:35:35', '2025-12-22 13:35:35'),
(161, 161, 'afolakeadewumi1@gmail.com', 'FOLAKE E. ADEWUMI', NULL, NULL, 'FOLAKE E. ADEWUMI', NULL, NULL, NULL, NULL, NULL, '2025-12-22 21:12:04', '2025-12-22 21:12:04'),
(162, 162, 'adenikesarah88@gmail.com', 'Adenike', NULL, NULL, 'Adenike', NULL, NULL, NULL, NULL, NULL, '2025-12-23 01:26:32', '2025-12-23 01:26:32'),
(163, 163, 'missoyinposolami@gmail.com', 'OLUFUNKE OYINPOSOLA OLOWOOKERE ESQ.', NULL, NULL, 'OLUFUNKE OYINPOSOLA OLOWOOKERE ESQ.', NULL, NULL, NULL, NULL, NULL, '2025-12-23 15:36:49', '2025-12-29 16:47:44'),
(164, 164, 'chekwubeella@yahoo.com', 'Chekwube Udubor', NULL, NULL, 'Chekwube Udubor', NULL, NULL, NULL, NULL, NULL, '2025-12-23 17:04:52', '2025-12-23 17:04:52'),
(165, 165, 'ajayimoyinoluwa290@gmail.com', 'Ajayi Moyinoluwalogo', NULL, NULL, 'Ajayi Moyinoluwalogo', NULL, NULL, NULL, NULL, NULL, '2025-12-23 23:49:36', '2025-12-23 23:49:36'),
(166, 166, 'elsieakpabio@yahoo.co.uk', 'Elsie Akpabio', NULL, NULL, 'Elsie Akpabio', NULL, NULL, NULL, NULL, NULL, '2025-12-24 16:52:15', '2025-12-24 16:52:15'),
(167, 167, 'ademoladeborah44@gmail.com', 'Deborah Diya', NULL, NULL, 'Deborah Diya', NULL, NULL, NULL, NULL, NULL, '2025-12-25 00:36:14', '2025-12-25 00:36:14'),
(168, 168, 'ainasusamson02@gmail.com', 'Ainasu Samson', NULL, NULL, 'Ainasu Samson', NULL, NULL, NULL, NULL, NULL, '2025-12-26 02:58:32', '2025-12-26 02:58:32'),
(169, 169, 'olutayodamidade@gmail.com', 'Olutayo Babadamidade', NULL, NULL, 'Olutayo Babadamidade', NULL, NULL, NULL, NULL, NULL, '2025-12-26 12:30:10', '2025-12-26 12:30:10'),
(170, 170, 'lawalmustaphaoladipupo@gmail.com', 'Verdict', NULL, NULL, 'Verdict', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:36:31', '2025-12-26 13:36:31'),
(171, 171, 'ritannajiofor3@gmail.com', 'Nnajiofor Rita', NULL, NULL, 'Nnajiofor Rita', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:37:15', '2025-12-26 13:37:15'),
(172, 172, 'pearlenwerem@gmail.com', 'Enwerem Pearl', NULL, NULL, 'Enwerem Pearl', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:37:40', '2025-12-26 13:37:40'),
(173, 173, 'okemoyo01@gmail.com', 'okemoyo01@gmail.com', NULL, NULL, 'okemoyo01@gmail.com', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:39:46', '2025-12-26 13:39:46'),
(174, 174, 'arogundadelatifah62@gmail.com', 'Latifah', NULL, NULL, 'Latifah', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:39:54', '2025-12-26 13:42:57'),
(175, 175, 'rifqahakorede@gmail.com', 'Rifqah Bakare', NULL, NULL, 'Rifqah Bakare', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:41:32', '2025-12-26 13:41:32'),
(176, 176, 'joyakinsola046@gmail.com', 'Akinsola Joy Deborah', NULL, NULL, 'Akinsola Joy Deborah', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:43:00', '2025-12-26 13:43:00'),
(177, 177, 'ademijusharon@gmail.com', 'Ademiju Sharon', NULL, NULL, 'Ademiju Sharon', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:45:01', '2025-12-26 13:45:01'),
(178, 178, 'danielakins2022@gmail.com', 'Daniel Akinkuowo', NULL, NULL, 'Daniel Akinkuowo', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:45:02', '2025-12-26 13:45:02'),
(179, 179, 'mubarakseriki56@gmail.com', 'Mubarak seriki', NULL, NULL, 'Mubarak seriki', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:45:35', '2025-12-26 13:45:35'),
(180, 180, 'okekechidera108@gmail.com', 'Okeke Chidera', NULL, NULL, 'Okeke Chidera', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:46:18', '2025-12-26 13:46:18'),
(181, 181, 'aishaakanni123@gmail.com', 'Aisha Akanni', NULL, NULL, 'Aisha Akanni', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:46:32', '2025-12-26 13:46:32'),
(182, 182, 'ryatlogistics@gmail.com', 'Rodiat', NULL, NULL, 'Rodiat', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:50:57', '2025-12-26 13:50:57'),
(183, 183, 'koladewonderful@gmail.com', 'Kolade', NULL, NULL, 'Kolade', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:51:04', '2025-12-26 13:51:04'),
(184, 184, 'they.call.me.kevwe@gmail.com', 'Rukevwe', NULL, NULL, 'Rukevwe', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:52:16', '2025-12-26 13:52:16'),
(185, 185, 'kcngele27@gmail.com', 'KC Ngele', NULL, NULL, 'KC Ngele', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:54:35', '2025-12-26 13:54:35'),
(186, 186, 'oaomotoro@gmail.com', 'Olaide Omotoro', NULL, NULL, 'Olaide Omotoro', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:55:26', '2025-12-26 13:55:26'),
(187, 187, 'queensleyamiandamen@gmail.com', 'University of Lagos', NULL, NULL, 'University of Lagos', NULL, NULL, NULL, NULL, NULL, '2025-12-26 13:59:07', '2025-12-26 13:59:07'),
(188, 188, 'bigmamaandpapa061@gmail.com', 'Amiandamen Queensley', NULL, NULL, 'Amiandamen Queensley', NULL, NULL, NULL, NULL, NULL, '2025-12-26 14:00:46', '2025-12-26 14:00:46'),
(189, 189, 'teniolamustapha5@gmail.com', 'Oluwateniola Mustapha', NULL, NULL, 'Oluwateniola Mustapha', NULL, NULL, NULL, NULL, NULL, '2025-12-26 14:06:40', '2025-12-26 14:06:40'),
(190, 190, 'confidenceamarachi78@gmail.com', 'Unilag', NULL, NULL, 'Unilag', NULL, NULL, NULL, NULL, NULL, '2025-12-26 14:13:26', '2025-12-26 14:13:26'),
(191, 191, 'ayodeleoluwatobiloba2008@gmail.com', 'Oluwatobiloba', NULL, NULL, 'Oluwatobiloba', NULL, NULL, NULL, NULL, NULL, '2025-12-26 14:16:52', '2025-12-26 14:16:52'),
(192, 192, 'obasiloveth714@gmail.com', 'Uka Loveth obasi', NULL, NULL, 'Uka Loveth obasi', NULL, NULL, NULL, NULL, NULL, '2025-12-26 14:29:00', '2025-12-26 14:29:00'),
(193, 193, 'rofiateniola482@gmail.com', 'Rofiat Ifedayo', NULL, NULL, 'Rofiat Ifedayo', NULL, NULL, NULL, NULL, NULL, '2025-12-26 14:32:52', '2025-12-26 14:32:52'),
(194, 194, 'blvck99sapphire@gmail.com', 'Black Sapphire', NULL, NULL, 'Black Sapphire', NULL, NULL, NULL, NULL, NULL, '2025-12-26 14:34:09', '2025-12-26 14:34:09'),
(195, 195, 'garbamartha01@gmail.com', 'Garba Martha', NULL, NULL, 'Garba Martha', NULL, NULL, NULL, NULL, NULL, '2025-12-26 14:36:22', '2025-12-26 14:36:22'),
(196, 196, 'wurabewaji@gmail.com', 'Wurami Bewaji', NULL, NULL, 'Wurami Bewaji', NULL, NULL, NULL, NULL, NULL, '2025-12-26 15:02:47', '2025-12-26 15:02:47'),
(197, 197, 'sanniolayinkaa@gmail.com', 'Olayinka', NULL, NULL, 'Olayinka', NULL, NULL, NULL, NULL, NULL, '2025-12-26 15:16:50', '2025-12-26 15:16:50'),
(198, 198, 'preciousomorose97@gmail.com', 'Precious Omorose', NULL, NULL, 'Precious Omorose', NULL, NULL, NULL, NULL, NULL, '2025-12-26 15:19:28', '2025-12-26 15:19:28'),
(199, 199, 'egberanmwenesther8@gmail.com', 'Ranmwen E. Uwadiae', NULL, NULL, 'Ranmwen E. Uwadiae', NULL, NULL, NULL, NULL, NULL, '2025-12-26 16:01:02', '2025-12-26 16:01:02'),
(200, 200, 'oyekunbiaraoluwa8@gmail.com', 'Oyekunbi Araoluwa Clement-Praise', NULL, NULL, 'Oyekunbi Araoluwa Clement-Praise', NULL, NULL, NULL, NULL, NULL, '2025-12-26 16:52:40', '2025-12-26 16:52:40'),
(201, 201, 'fadairooluwaseun04@gmail.com', 'Fadairo Oluwaseun Elizabeth', NULL, NULL, 'Fadairo Oluwaseun Elizabeth', NULL, NULL, NULL, NULL, NULL, '2025-12-26 18:02:35', '2025-12-26 18:02:35'),
(202, 202, 'ananefavour7@gmail.com', 'Divine favour', NULL, NULL, 'Divine favour', NULL, NULL, NULL, NULL, NULL, '2025-12-26 18:49:15', '2025-12-26 18:49:15'),
(203, 203, 'fikayob09@gmail.com', 'Babalola OluwaFikayomi', NULL, NULL, 'Babalola OluwaFikayomi', NULL, NULL, NULL, NULL, NULL, '2025-12-26 19:10:35', '2025-12-26 19:10:35'),
(204, 204, 'akintolavictoria518@gmail.com', 'Akintola Victoria', NULL, NULL, 'Akintola Victoria', NULL, NULL, NULL, NULL, NULL, '2025-12-26 19:10:59', '2025-12-26 19:10:59'),
(205, 205, 'melvintochukwu1@gmail.com', 'Tochi', NULL, NULL, 'Tochi', NULL, NULL, NULL, NULL, NULL, '2025-12-26 21:08:21', '2025-12-26 21:08:21'),
(206, 206, 'aroworaomotoyosi87@gmail.com', 'Omotoyosi', NULL, NULL, 'Omotoyosi', NULL, NULL, NULL, NULL, NULL, '2025-12-27 02:36:25', '2025-12-27 02:36:25'),
(207, 207, 'lunashane236@gmail.com', 'Luna', NULL, NULL, 'Luna', NULL, NULL, NULL, NULL, NULL, '2025-12-27 22:17:36', '2025-12-27 22:17:36'),
(208, 208, 'zainabayandare123@gmail.com', 'Zainab', NULL, NULL, 'Zainab', NULL, NULL, NULL, NULL, NULL, '2025-12-28 01:35:21', '2025-12-28 01:35:21'),
(209, 209, 'ogunomowunmi8@gmail.com', 'Omowunmi Ogun', NULL, NULL, 'Omowunmi Ogun', NULL, NULL, NULL, NULL, NULL, '2025-12-29 20:29:48', '2025-12-29 20:29:48'),
(210, 210, 'damilolaojopagogo@gmail.com', 'DAMILOLA OJOPAGOGO', NULL, NULL, 'DAMILOLA OJOPAGOGO', NULL, NULL, NULL, NULL, NULL, '2025-12-31 12:47:50', '2025-12-31 12:47:50'),
(211, 211, 'olawoyeoluwajomiloju@gmail.com', 'Jomiloju', NULL, NULL, 'Jomiloju', NULL, NULL, NULL, NULL, NULL, '2025-12-31 21:47:27', '2025-12-31 21:47:27'),
(212, 212, 'danielrebecca91@yahoo.com', 'Solicitous Attorney', NULL, NULL, 'Solicitous Attorney', NULL, NULL, NULL, NULL, NULL, '2026-01-03 13:45:44', '2026-01-03 13:45:44'),
(213, 213, 'obadina.lp@yahoo.com', 'Olanrewaju Obadina', NULL, NULL, 'Olanrewaju Obadina', NULL, NULL, NULL, NULL, NULL, '2026-01-03 13:50:27', '2026-01-03 13:50:27'),
(214, 214, 'kaythelaw@nigerianbar.ng', 'Kayode Oyelade and Co', NULL, NULL, 'Kayode Oyelade and Co', NULL, NULL, NULL, NULL, NULL, '2026-01-03 15:06:36', '2026-01-03 15:06:36'),
(215, 215, 'deborahphilip139@yahoo.com', 'Philip Deborah Ibukunoluwa', NULL, NULL, 'Philip Deborah Ibukunoluwa', NULL, NULL, NULL, NULL, NULL, '2026-01-05 10:38:27', '2026-01-05 10:38:27'),
(216, 216, 'reeny1515@yahoo.com', 'Njideka Irene Ihionu', NULL, NULL, 'Njideka Irene Ihionu', NULL, NULL, NULL, NULL, NULL, '2026-01-05 11:58:53', '2026-01-05 11:58:53'),
(217, 217, 'tolufunkeakin@gamil.com', 'Toluwani Akinola', NULL, NULL, 'Toluwani Akinola', NULL, NULL, NULL, NULL, NULL, '2026-01-05 12:40:28', '2026-01-05 12:40:28'),
(218, 218, 'capexdeisolicitor@gmail.com', 'Capex Dei Solicitors', NULL, NULL, 'Capex Dei Solicitors', NULL, NULL, NULL, NULL, NULL, '2026-01-05 15:23:19', '2026-01-05 15:23:19'),
(219, 219, 'akandesekinat2004@gmail.com', 'akandesekinat2004@gmail.com', NULL, NULL, 'akandesekinat2004@gmail.com', NULL, NULL, NULL, NULL, NULL, '2026-01-05 20:02:46', '2026-01-05 20:02:46'),
(220, 220, 'egbey2k1@yahoo.com', 'Egbe Osikhena', NULL, NULL, 'Egbe Osikhena', NULL, NULL, NULL, NULL, NULL, '2026-01-06 01:10:15', '2026-01-06 01:10:15'),
(221, 221, 'samdlaw101@gmail.com', 'Unilag', NULL, NULL, 'Unilag', NULL, NULL, NULL, NULL, NULL, '2026-01-06 15:58:48', '2026-01-06 15:58:48'),
(222, 222, 'oladimejialiyah2@gmail.com', 'Oladimeji Aliyah', NULL, NULL, 'Oladimeji Aliyah', NULL, NULL, NULL, NULL, NULL, '2026-01-06 16:06:08', '2026-01-06 16:06:08'),
(223, 223, 'emmanuellaidakpo@gmail.com', 'Emmanuella', NULL, NULL, 'Emmanuella', NULL, NULL, NULL, NULL, NULL, '2026-01-06 16:18:22', '2026-01-06 16:18:22'),
(224, 224, 'marinalawchambers@hotmail.com', 'MARINA LAW CHAMBERS', NULL, NULL, 'MARINA LAW CHAMBERS', NULL, NULL, NULL, NULL, NULL, '2026-01-06 17:02:05', '2026-01-06 17:02:05'),
(225, 225, 'anikeoluwa05@gmail.com', 'Anoghena', NULL, NULL, 'Anoghena', NULL, NULL, NULL, NULL, NULL, '2026-01-06 17:08:50', '2026-01-06 17:08:50'),
(226, 226, 'ridwanbak3@gmail.com', 'Ridwan', NULL, NULL, 'Ridwan', NULL, NULL, NULL, NULL, NULL, '2026-01-06 17:12:16', '2026-01-06 17:12:16'),
(227, 227, 'divinelyfavoured20@gmail.com', 'Divine-favour', NULL, NULL, 'Divine-favour', NULL, NULL, NULL, NULL, NULL, '2026-01-06 17:40:25', '2026-01-06 17:40:25'),
(228, 228, 'aniolaanifowose@gmail.com', 'Adeola', NULL, NULL, 'Adeola', NULL, NULL, NULL, NULL, NULL, '2026-01-06 17:50:48', '2026-01-06 17:50:48'),
(229, 229, 'owolabiibrahim03@gmail.com', 'Destinyandlawlords', NULL, NULL, 'Destinyandlawlords', NULL, NULL, NULL, NULL, NULL, '2026-01-06 17:54:13', '2026-01-06 17:54:13'),
(230, 230, 'ololadeogunleye14@gmail.com', 'Unilag', NULL, NULL, 'Unilag', NULL, NULL, NULL, NULL, NULL, '2026-01-06 19:00:09', '2026-01-06 19:00:09'),
(231, 231, 'chiomajoe2023@gmail.com', 'Chioma', NULL, NULL, 'Chioma', NULL, NULL, NULL, NULL, NULL, '2026-01-06 19:05:10', '2026-01-06 19:05:10'),
(232, 232, 'abisolafavour77@gmail.com', 'Abisola Favour Omolayo', NULL, NULL, 'Abisola Favour Omolayo', NULL, NULL, NULL, NULL, NULL, '2026-01-06 19:30:37', '2026-01-06 19:30:37'),
(233, 233, 'bellozechariah058@gmail.com', 'Zechariah', NULL, NULL, 'Zechariah', NULL, NULL, NULL, NULL, NULL, '2026-01-06 22:22:24', '2026-01-06 22:22:24'),
(234, 234, 'olamilekanwilliams3@gmail.com', 'Williams Olamilekan', NULL, NULL, 'Williams Olamilekan', NULL, NULL, NULL, NULL, NULL, '2026-01-06 22:32:03', '2026-01-06 22:32:03'),
(235, 235, 'barakatullah148@gmail.com', 'Barakatullah', NULL, NULL, 'Barakatullah', NULL, NULL, NULL, NULL, NULL, '2026-01-07 02:29:24', '2026-01-07 02:29:24'),
(236, 236, 'wkshittuandco@yahoo.com', 'W. K. Shittu & Co.', NULL, NULL, 'W. K. Shittu & Co.', NULL, NULL, NULL, NULL, NULL, '2026-01-07 17:21:53', '2026-01-07 17:21:53'),
(237, 237, 'mejolagbeaduragbemi@gmail.com', 'Mejolagbe Aduragbemi', NULL, NULL, 'Mejolagbe Aduragbemi', NULL, NULL, NULL, NULL, NULL, '2026-01-07 17:48:23', '2026-01-07 17:48:23'),
(238, 238, 'officialtwinkletoes002@gmail.com', 'Twinkle', NULL, NULL, 'Twinkle', NULL, NULL, NULL, NULL, NULL, '2026-01-08 00:08:35', '2026-01-08 00:08:35'),
(239, 239, 'oluwaferanmitemiloluwa37@gmail.com', 'Oluwaferanmi Temiloluwa Matilda', NULL, NULL, 'Oluwaferanmi Temiloluwa Matilda', NULL, NULL, NULL, NULL, NULL, '2026-01-08 17:27:25', '2026-01-08 17:27:25'),
(240, 240, 'temiloluwaoluwaferanmi8@gmail.com', 'Oluwaferanmi Temiloluwa Matilda', NULL, NULL, 'Oluwaferanmi Temiloluwa Matilda', NULL, NULL, NULL, NULL, NULL, '2026-01-08 17:28:35', '2026-01-08 17:28:35'),
(241, 241, 'oteikwu4@gmail.com', 'Capitalfield', NULL, NULL, 'Capitalfield', NULL, NULL, NULL, NULL, NULL, '2026-01-08 18:26:12', '2026-01-08 18:26:12'),
(242, 242, 'okanlawonmausi@gmail.com', 'Asokere mausi', NULL, NULL, 'Asokere mausi', NULL, NULL, NULL, NULL, NULL, '2026-01-08 23:54:44', '2026-01-08 23:54:44'),
(243, 243, 'oluwagbotemilawrence1@gmail.com', 'Oluwagbotemi Lawrence', NULL, NULL, 'Oluwagbotemi Lawrence', NULL, NULL, NULL, NULL, NULL, '2026-01-09 04:13:19', '2026-01-09 04:13:19'),
(244, 244, 'ayanfejesuniyi@gmail.com', 'Favour', NULL, NULL, 'Favour', NULL, NULL, NULL, NULL, NULL, '2026-01-09 20:47:37', '2026-01-09 20:47:37'),
(245, 245, 'opeyemiadebanjo7@gmail.com', 'Opeyemi Adebanjo', NULL, NULL, 'Opeyemi Adebanjo', NULL, NULL, NULL, NULL, NULL, '2026-01-12 10:05:52', '2026-01-12 10:05:52'),
(246, 246, 'senorbrian01@gmail.com', 'B.C Okoye & Co', NULL, NULL, 'B.C Okoye & Co', NULL, NULL, NULL, NULL, NULL, '2026-01-12 11:01:42', '2026-01-12 11:01:42'),
(247, 247, 'demiladeadegoke417@gmail.com', 'Cyrus', NULL, NULL, 'Cyrus', NULL, NULL, NULL, NULL, NULL, '2026-01-12 14:23:58', '2026-01-12 14:23:58'),
(248, 248, 'bolababatunde@gmail.com', 'BB', NULL, NULL, 'BB', NULL, NULL, NULL, NULL, NULL, '2026-01-12 15:51:51', '2026-01-12 15:51:51'),
(249, 249, 'oferanmi03@gmail.com', 'Oluwaferanmi Temiloluwa Matilda', NULL, NULL, 'Oluwaferanmi Temiloluwa Matilda', NULL, NULL, NULL, NULL, NULL, '2026-01-12 19:57:31', '2026-01-12 19:57:31'),
(250, 250, 'adebayofawaz362@gmail.com', 'Fawaz', NULL, NULL, 'Fawaz', NULL, NULL, NULL, NULL, NULL, '2026-01-12 20:16:53', '2026-01-12 20:16:53'),
(251, 251, 'afoke.richmond@gmail.com', 'afoke.richmond@gmail.com', NULL, NULL, 'afoke.richmond@gmail.com', NULL, NULL, NULL, NULL, NULL, '2026-01-13 23:16:27', '2026-01-13 23:16:27'),
(252, 252, 'kamsiagwu@gmail.com', 'Kamsi Agwu', NULL, NULL, 'Kamsi Agwu', NULL, NULL, NULL, NULL, NULL, '2026-01-14 02:48:53', '2026-01-14 02:48:53'),
(253, 253, 'preciousolufemi604@gmail.com', 'Lina', NULL, NULL, 'Lina', NULL, NULL, NULL, NULL, NULL, '2026-01-14 12:54:55', '2026-01-14 12:54:55'),
(254, 254, 'mmasinachisandra34@gmail.com', 'Hyackings law firm', NULL, NULL, 'Hyackings law firm', NULL, NULL, NULL, NULL, NULL, '2026-01-15 09:47:28', '2026-01-15 09:47:28'),
(255, 255, 'similoluwaige@gmail.com', 'Similoluwa Ige', NULL, NULL, 'Similoluwa Ige', NULL, NULL, NULL, NULL, NULL, '2026-01-15 12:44:59', '2026-01-15 12:44:59'),
(256, 256, 'akano.fatima@gmail.com', 'Fatima Akano', NULL, NULL, 'Fatima Akano', NULL, NULL, NULL, NULL, NULL, '2026-01-15 17:26:25', '2026-01-15 17:26:25'),
(257, 257, 'oluwashindaraadejoro@gmail.com', 'shindara', NULL, NULL, 'shindara', NULL, NULL, NULL, NULL, NULL, '2026-01-15 17:41:26', '2026-01-15 17:41:26'),
(258, 258, 'francisdiamond08@gmail.com', 'Diamond', NULL, NULL, 'Diamond', NULL, NULL, NULL, NULL, NULL, '2026-01-15 20:47:35', '2026-01-15 20:47:35'),
(259, 259, 'ezechipeter2018@gmail.com', 'Chukwuma', NULL, NULL, 'Chukwuma', NULL, NULL, NULL, NULL, NULL, '2026-01-16 22:16:41', '2026-01-16 22:16:41'),
(260, 260, 'adebayoadekoya1@gmail.com', 'FULFILMENT CHAMBERS  -LAW FIRM', NULL, NULL, 'FULFILMENT CHAMBERS  -LAW FIRM', NULL, NULL, NULL, NULL, NULL, '2026-01-18 11:27:42', '2026-01-18 11:27:42'),
(261, 261, 'hadeezahafolabi@gmail.com', 'Hadeezah', NULL, NULL, 'Hadeezah', NULL, NULL, NULL, NULL, NULL, '2026-01-18 21:36:06', '2026-01-18 21:36:06'),
(262, 262, 'globalpointattorneys@gmail.com', 'Globalpoint Attorneys', NULL, NULL, 'Globalpoint Attorneys', NULL, NULL, NULL, NULL, NULL, '2026-01-19 23:19:55', '2026-01-19 23:19:55'),
(263, 263, 'sdstorage98@gmail.com', 'Paul', NULL, NULL, 'Paul', NULL, NULL, NULL, NULL, NULL, '2026-01-20 01:39:37', '2026-01-20 01:39:37'),
(264, 264, 'oluwatoyin.obe@panafricancapitalholdings.com', 'Oluwatoyin', NULL, NULL, 'Oluwatoyin', NULL, NULL, NULL, NULL, NULL, '2026-01-20 21:51:57', '2026-01-20 21:51:57'),
(265, 265, 'obanoit@gmail.com', 'Obano Itohan', NULL, NULL, 'Obano Itohan', NULL, NULL, NULL, NULL, NULL, '2026-01-20 22:42:43', '2026-01-20 22:42:43'),
(266, 266, 'pearlistico@yahoo.com', 'Oluwatoyin', NULL, NULL, 'Oluwatoyin', NULL, NULL, NULL, NULL, NULL, '2026-01-21 22:37:09', '2026-01-21 22:37:09'),
(267, 267, 'funmiadeyemi2511@gmail.com', 'funmiadeyemi2511@gmail.com', NULL, NULL, 'funmiadeyemi2511@gmail.com', NULL, NULL, NULL, NULL, NULL, '2026-01-22 22:51:33', '2026-01-22 22:51:33'),
(268, 268, 'dotunayodeji5@gmail.com', 'Ayodeji Dotun', NULL, NULL, 'Ayodeji Dotun', NULL, NULL, NULL, NULL, NULL, '2026-01-23 16:42:28', '2026-01-23 16:42:28'),
(269, 269, 'anuadesuyi@icloud.com', 'Adesuyi', NULL, NULL, 'Adesuyi', NULL, NULL, NULL, NULL, NULL, '2026-01-25 19:03:32', '2026-01-25 19:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `referrer_id` bigint(20) UNSIGNED NOT NULL,
  `referred_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `referral_code` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `clicks` int(11) NOT NULL DEFAULT 0,
  `first_clicked_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referrals`
--

INSERT INTO `referrals` (`id`, `referrer_id`, `referred_user_id`, `referral_code`, `status`, `clicks`, `first_clicked_at`, `completed_at`, `notes`, `created_at`, `updated_at`) VALUES
(2, 5, NULL, 'OWEUZ2VK', 'active', 0, NULL, NULL, NULL, '2025-12-03 07:38:10', '2025-12-03 07:38:10'),
(3, 6, NULL, '4GM3BJZW', 'active', 11, '2025-12-03 06:19:42', NULL, NULL, '2025-12-03 11:19:33', '2025-12-10 09:20:35'),
(4, 9, NULL, 'CQYODXNN', 'active', 0, NULL, NULL, NULL, '2025-12-03 19:26:54', '2025-12-03 19:26:54'),
(5, 3, NULL, 'CTO8IA9L', 'active', 0, NULL, NULL, NULL, '2025-12-03 22:23:21', '2025-12-03 22:23:21'),
(6, 19, 269, 'I9FYZ5QM', 'completed', 362, '2025-12-06 19:35:31', '2026-01-25 14:03:32', NULL, '2025-12-07 00:32:15', '2026-01-25 19:03:32'),
(7, 52, NULL, '8XUMXPZZ', 'active', 0, NULL, NULL, NULL, '2025-12-08 16:06:12', '2025-12-08 16:06:12'),
(8, 78, NULL, 'QPWNB6PW', 'active', 0, NULL, NULL, NULL, '2025-12-14 23:18:03', '2025-12-14 23:18:03'),
(9, 80, NULL, 'QNKEVXG2', 'active', 0, NULL, NULL, NULL, '2025-12-15 13:51:53', '2025-12-15 13:51:53'),
(10, 138, NULL, '533SEJRF', 'active', 0, NULL, NULL, NULL, '2025-12-16 23:07:09', '2025-12-16 23:07:09'),
(11, 72, NULL, '7AEI3A7N', 'active', 0, NULL, NULL, NULL, '2025-12-19 09:17:01', '2025-12-19 09:17:01'),
(12, 174, NULL, 'XLHDMHXF', 'active', 0, NULL, NULL, NULL, '2025-12-26 13:42:25', '2025-12-26 13:42:25'),
(13, 180, NULL, 'WMCKW1UM', 'active', 0, NULL, NULL, NULL, '2025-12-26 13:47:53', '2025-12-26 13:47:53'),
(14, 195, NULL, 'GZWH800M', 'active', 0, NULL, NULL, NULL, '2025-12-26 14:37:34', '2025-12-26 14:37:34'),
(15, 163, NULL, 'NSCO7FSA', 'active', 0, NULL, NULL, NULL, '2025-12-29 16:47:15', '2025-12-29 16:47:15'),
(16, 69, NULL, 'JMY6ABEZ', 'active', 0, NULL, NULL, NULL, '2026-01-03 01:31:39', '2026-01-03 01:31:39'),
(17, 55, NULL, 'F691VAQN', 'active', 0, NULL, NULL, NULL, '2026-01-05 12:51:12', '2026-01-05 12:51:12'),
(18, 223, NULL, 'Z7KODU20', 'active', 0, NULL, NULL, NULL, '2026-01-06 16:19:53', '2026-01-06 16:19:53'),
(19, 224, NULL, 'LDDDCSDN', 'active', 0, NULL, NULL, NULL, '2026-01-06 17:25:12', '2026-01-06 17:25:12'),
(20, 12, NULL, 'R9QM0CSZ', 'active', 0, NULL, NULL, NULL, '2026-01-08 15:20:12', '2026-01-08 15:20:12'),
(21, 236, NULL, 'PK7ZQWEY', 'active', 0, NULL, NULL, NULL, '2026-01-08 18:09:35', '2026-01-08 18:09:35'),
(22, 243, NULL, 'ELIJ2KXS', 'active', 0, NULL, NULL, NULL, '2026-01-09 04:28:41', '2026-01-09 04:28:41'),
(23, 59, NULL, 'E4J0VTU9', 'active', 0, NULL, NULL, NULL, '2026-01-13 14:47:18', '2026-01-13 14:47:18'),
(24, 231, NULL, 'AVFH3E9D', 'active', 0, NULL, NULL, NULL, '2026-01-18 19:52:06', '2026-01-18 19:52:06');

-- --------------------------------------------------------

--
-- Table structure for table `referral_clicks`
--

CREATE TABLE `referral_clicks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `referral_id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referral_clicks`
--

INSERT INTO `referral_clicks` (`id`, `referral_id`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 3, '13.245.234.132', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0', '2025-12-03 11:19:42', '2025-12-03 11:19:42'),
(2, 3, '13.247.95.85', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0', '2025-12-03 23:59:52', '2025-12-03 23:59:52'),
(3, 3, '13.247.250.7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0', '2025-12-04 10:57:38', '2025-12-04 10:57:38'),
(4, 3, '13.247.97.93', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0', '2025-12-04 18:33:33', '2025-12-04 18:33:33'),
(5, 3, '13.245.234.101', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0', '2025-12-05 18:13:42', '2025-12-05 18:13:42'),
(6, 3, '13.244.142.175', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0', '2025-12-06 00:29:35', '2025-12-06 00:29:35'),
(7, 3, '13.246.45.88', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0', '2025-12-07 00:00:24', '2025-12-07 00:00:24'),
(8, 6, '13.246.12.171', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-07 00:35:31', '2025-12-07 00:35:31'),
(9, 6, '3.148.214.136', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_1_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/143.0.7499.92 Mobile/15E148 Safari/604.1', '2025-12-07 00:40:52', '2025-12-07 00:40:52'),
(10, 6, '13.247.97.93', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-07 00:41:45', '2025-12-07 00:41:45'),
(11, 6, '3.138.170.214', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_1_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/143.0.7499.92 Mobile/15E148 Safari/604.1', '2025-12-07 01:00:59', '2025-12-07 01:00:59'),
(12, 6, '16.28.47.181', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-07 01:01:28', '2025-12-07 01:01:28'),
(13, 6, '13.244.119.63', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-07 01:03:13', '2025-12-07 01:03:13'),
(14, 6, '13.246.45.88', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.7 Mobile/15E148 Safari/604.1', '2025-12-07 01:11:14', '2025-12-07 01:11:14'),
(15, 6, '13.246.45.88', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-07 02:10:01', '2025-12-07 02:10:01'),
(16, 6, '13.246.45.88', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-07 04:33:31', '2025-12-07 04:33:31'),
(17, 6, '13.245.5.127', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-07 06:20:29', '2025-12-07 06:20:29'),
(18, 6, '13.245.5.127', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-07 11:58:16', '2025-12-07 11:58:16'),
(19, 6, '16.28.95.178', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-07 12:56:11', '2025-12-07 12:56:11'),
(20, 6, '51.44.85.118', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', '2025-12-07 12:56:15', '2025-12-07 12:56:15'),
(21, 6, '13.246.45.88', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-07 21:22:46', '2025-12-07 21:22:46'),
(22, 3, '13.246.11.231', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0', '2025-12-07 23:52:08', '2025-12-07 23:52:08'),
(23, 6, '13.246.36.73', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-08 01:38:46', '2025-12-08 01:38:46'),
(24, 6, '13.246.36.73', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-08 10:53:45', '2025-12-08 10:53:45'),
(25, 6, '13.246.45.88', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-08 10:57:29', '2025-12-08 10:57:29'),
(26, 6, '13.246.11.231', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-08 16:04:10', '2025-12-08 16:04:10'),
(27, 6, '13.244.107.147', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-08 19:14:58', '2025-12-08 19:14:58'),
(28, 6, '13.246.11.231', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '2025-12-09 01:34:16', '2025-12-09 01:34:16'),
(29, 3, '13.244.107.147', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0', '2025-12-09 11:12:37', '2025-12-09 11:12:37'),
(30, 6, '13.245.111.240', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-09 13:33:25', '2025-12-09 13:33:25'),
(31, 6, '13.245.111.240', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-09 19:06:35', '2025-12-09 19:06:35'),
(32, 6, '13.246.11.231', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-09 19:06:36', '2025-12-09 19:06:36'),
(33, 3, '13.245.111.240', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0', '2025-12-09 22:45:17', '2025-12-09 22:45:17'),
(34, 3, '13.244.107.147', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0', '2025-12-10 09:20:35', '2025-12-10 09:20:35'),
(35, 6, '13.247.59.50', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-11 01:59:32', '2025-12-11 01:59:32'),
(36, 6, '13.244.104.128', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-14 21:40:09', '2025-12-14 21:40:09'),
(37, 6, '15.237.247.48', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', '2025-12-14 21:40:12', '2025-12-14 21:40:12'),
(38, 6, '13.245.5.75', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-14 21:40:17', '2025-12-14 21:40:17'),
(39, 6, '16.28.29.207', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', '2025-12-14 21:40:59', '2025-12-14 21:40:59'),
(40, 6, '3.15.14.222', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '2025-12-14 21:41:31', '2025-12-14 21:41:31'),
(41, 6, '13.244.104.128', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-14 21:41:47', '2025-12-14 21:41:47'),
(42, 6, '13.245.5.75', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3.1 Mobile/15E148 Safari/604.1', '2025-12-14 21:41:53', '2025-12-14 21:41:53'),
(43, 6, '13.245.5.75', 'Mozilla/5.0 (Android 16; Mobile; rv:146.0) Gecko/146.0 Firefox/146.0', '2025-12-14 21:48:33', '2025-12-14 21:48:33'),
(44, 6, '16.28.29.207', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', '2025-12-14 21:50:30', '2025-12-14 21:50:30'),
(45, 6, '13.245.5.75', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '2025-12-14 21:51:41', '2025-12-14 21:51:41'),
(46, 6, '13.245.5.75', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', '2025-12-14 21:54:30', '2025-12-14 21:54:30'),
(47, 6, '13.244.104.128', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-14 22:19:33', '2025-12-14 22:19:33'),
(48, 6, '16.28.29.207', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-14 22:27:04', '2025-12-14 22:27:04'),
(49, 6, '13.245.5.75', 'Mozilla/5.0 (Linux; U; Android 9; en-us; itel W6004P Build/PPR1.180610.011) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.116 Mobile Safari/537.36 PHX/19.9', '2025-12-14 22:46:54', '2025-12-14 22:46:54'),
(50, 6, '13.244.104.128', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-14 22:47:03', '2025-12-14 22:47:03'),
(51, 6, '13.244.104.128', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-14 23:05:08', '2025-12-14 23:05:08'),
(52, 6, '16.28.29.207', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-14 23:14:38', '2025-12-14 23:14:38'),
(53, 6, '13.244.104.128', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-14 23:16:03', '2025-12-14 23:16:03'),
(54, 6, '13.244.104.128', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '2025-12-14 23:59:55', '2025-12-14 23:59:55'),
(55, 6, '16.28.29.207', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-15 00:48:43', '2025-12-15 00:48:43'),
(56, 6, '16.28.29.207', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_8_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6.7 Mobile/15E148 Safari/604.1', '2025-12-15 02:08:21', '2025-12-15 02:08:21'),
(57, 6, '13.244.104.128', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-15 03:29:26', '2025-12-15 03:29:26'),
(58, 6, '16.28.29.207', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '2025-12-15 03:41:40', '2025-12-15 03:41:40'),
(59, 6, '13.247.231.125', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-15 13:17:29', '2025-12-15 13:17:29'),
(60, 6, '16.28.29.207', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-15 14:46:59', '2025-12-15 14:46:59'),
(61, 6, '16.28.29.207', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-15 16:30:06', '2025-12-15 16:30:06'),
(62, 6, '16.28.29.207', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-15 16:39:12', '2025-12-15 16:39:12'),
(63, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-15 18:38:51', '2025-12-15 18:38:51'),
(64, 6, '16.28.29.207', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.7.2 Mobile/15E148 Safari/604.1', '2025-12-15 18:39:25', '2025-12-15 18:39:25'),
(65, 6, '16.28.29.207', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/137.0.7151.51 Mobile/15E148 Safari/604.1', '2025-12-15 18:56:02', '2025-12-15 18:56:02'),
(66, 6, '16.28.29.207', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-15 19:48:36', '2025-12-15 19:48:36'),
(67, 6, '13.247.231.125', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-15 19:55:54', '2025-12-15 19:55:54'),
(68, 6, '16.28.29.207', 'Mozilla/5.0 (Linux; Android 12; SM-G975F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36', '2025-12-15 21:03:17', '2025-12-15 21:03:17'),
(69, 6, '13.247.231.125', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-15 21:03:45', '2025-12-15 21:03:45'),
(70, 6, '16.28.29.207', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/137.0.7151.51 Mobile/15E148 Safari/604.1', '2025-12-15 22:09:10', '2025-12-15 22:09:10'),
(71, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; U; Android 12; en-us; Infinix X6819 Build/SP1A.210812.016) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.5195.136 Mobile Safari/537.36 PHX/18.7', '2025-12-15 22:13:21', '2025-12-15 22:13:21'),
(72, 6, '13.246.40.62', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.7.2 Mobile/15E148 Safari/604.1', '2025-12-16 00:29:14', '2025-12-16 00:29:14'),
(73, 6, '13.246.39.11', 'Mozilla/5.0 (Linux; U; Android 14; en-us; 23129RN51X Build/UP1A.231005.007) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/61.0.3163.128 Mobile Safari/537.36 Lite Browser/4.10', '2025-12-16 00:29:22', '2025-12-16 00:29:22'),
(74, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; U; Android 14; en-us; 23129RN51X Build/UP1A.231005.007) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/61.0.3163.128 Mobile Safari/537.36 Lite Browser/4.10', '2025-12-16 00:31:03', '2025-12-16 00:31:03'),
(75, 6, '13.246.40.62', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.0.1 Mobile/15E148 Safari/604.1', '2025-12-16 00:31:37', '2025-12-16 00:31:37'),
(76, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 00:32:00', '2025-12-16 00:32:00'),
(77, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 00:33:17', '2025-12-16 00:33:17'),
(78, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', '2025-12-16 00:35:22', '2025-12-16 00:35:22'),
(79, 6, '13.246.40.62', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.0.1 Mobile/15E148 Safari/604.1', '2025-12-16 00:35:40', '2025-12-16 00:35:40'),
(80, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-12-16 00:39:46', '2025-12-16 00:39:46'),
(81, 6, '13.246.39.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-12-16 00:40:28', '2025-12-16 00:40:28'),
(82, 6, '13.246.39.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-12-16 00:41:21', '2025-12-16 00:41:21'),
(83, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 00:42:20', '2025-12-16 00:42:20'),
(84, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 00:44:50', '2025-12-16 00:44:50'),
(85, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 00:45:58', '2025-12-16 00:45:58'),
(86, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 00:47:29', '2025-12-16 00:47:29'),
(87, 6, '13.246.40.62', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_8_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6.7 Mobile/15E148 Safari/604.1', '2025-12-16 00:47:54', '2025-12-16 00:47:54'),
(88, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 00:50:38', '2025-12-16 00:50:38'),
(89, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 00:52:16', '2025-12-16 00:52:16'),
(90, 6, '13.246.39.11', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_1_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.1 Mobile/15E148 Safari/604.1', '2025-12-16 00:56:56', '2025-12-16 00:56:56'),
(91, 6, '13.246.39.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 00:59:27', '2025-12-16 00:59:27'),
(92, 6, '13.246.39.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 00:59:36', '2025-12-16 00:59:36'),
(93, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 01:19:47', '2025-12-16 01:19:47'),
(94, 6, '13.246.40.62', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.7.2 Mobile/15E148 Safari/604.1', '2025-12-16 02:06:05', '2025-12-16 02:06:05'),
(95, 6, '13.246.40.62', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_0_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/143.0.7499.108 Mobile/15E148 Safari/604.1', '2025-12-16 02:06:31', '2025-12-16 02:06:31'),
(96, 6, '13.246.40.62', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_7_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.8 Mobile/15E148 Safari/604.1', '2025-12-16 02:13:09', '2025-12-16 02:13:09'),
(97, 6, '13.246.39.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 02:38:52', '2025-12-16 02:38:52'),
(98, 6, '13.246.39.11', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_0_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/143.0.7499.108 Mobile/15E148 Safari/604.1', '2025-12-16 02:53:39', '2025-12-16 02:53:39'),
(99, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-12-16 02:54:15', '2025-12-16 02:54:15'),
(100, 6, '13.246.39.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-12-16 02:54:15', '2025-12-16 02:54:15'),
(101, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 03:01:31', '2025-12-16 03:01:31'),
(102, 6, '13.246.40.62', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_8_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6.7 Mobile/15E148 Safari/604.1', '2025-12-16 03:30:42', '2025-12-16 03:30:42'),
(103, 6, '13.246.40.62', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_1_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.1 Mobile/15E148 Safari/604.1', '2025-12-16 04:01:17', '2025-12-16 04:01:17'),
(104, 6, '13.246.40.62', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_8_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6.7 Mobile/15E148 Safari/604.1', '2025-12-16 04:07:21', '2025-12-16 04:07:21'),
(105, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 06:23:11', '2025-12-16 06:23:11'),
(106, 6, '13.246.39.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 06:48:35', '2025-12-16 06:48:35'),
(107, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 08:11:23', '2025-12-16 08:11:23'),
(108, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 12:09:24', '2025-12-16 12:09:24'),
(109, 6, '13.246.40.62', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.7.2 Mobile/15E148 Safari/604.1', '2025-12-16 12:15:05', '2025-12-16 12:15:05'),
(110, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36', '2025-12-16 12:29:22', '2025-12-16 12:29:22'),
(111, 6, '13.246.39.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 12:30:02', '2025-12-16 12:30:02'),
(112, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 12:30:20', '2025-12-16 12:30:20'),
(113, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', '2025-12-16 12:32:39', '2025-12-16 12:32:39'),
(114, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Mobile Safari/537.36', '2025-12-16 12:32:56', '2025-12-16 12:32:56'),
(115, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 12:33:16', '2025-12-16 12:33:16'),
(116, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36', '2025-12-16 12:34:30', '2025-12-16 12:34:30'),
(117, 6, '13.247.97.200', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-16 12:34:59', '2025-12-16 12:34:59'),
(118, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 12:35:29', '2025-12-16 12:35:29'),
(119, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', '2025-12-16 12:35:34', '2025-12-16 12:35:34'),
(120, 6, '13.246.39.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36', '2025-12-16 12:35:50', '2025-12-16 12:35:50'),
(121, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Mobile Safari/537.36', '2025-12-16 12:35:53', '2025-12-16 12:35:53'),
(122, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', '2025-12-16 12:38:09', '2025-12-16 12:38:09'),
(123, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', '2025-12-16 12:39:43', '2025-12-16 12:39:43'),
(124, 6, '18.192.119.108', 'Mozilla/5.0 (Linux; U; Android 13; Infinix X6525 Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/142.0.7444.174 Mobile Safari/537.36 OPR/93.0.2254.78504', '2025-12-16 12:40:10', '2025-12-16 12:40:10'),
(125, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-16 12:40:31', '2025-12-16 12:40:31'),
(126, 6, '13.246.39.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 12:40:47', '2025-12-16 12:40:47'),
(127, 6, '13.246.39.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 12:42:01', '2025-12-16 12:42:01'),
(128, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 12:43:12', '2025-12-16 12:43:12'),
(129, 6, '13.246.39.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', '2025-12-16 12:43:55', '2025-12-16 12:43:55'),
(130, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 12:51:02', '2025-12-16 12:51:02'),
(131, 6, '13.246.39.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 12:52:53', '2025-12-16 12:52:53'),
(132, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 12:55:40', '2025-12-16 12:55:40'),
(133, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/28.0 Chrome/130.0.0.0 Mobile Safari/537.36', '2025-12-16 12:56:53', '2025-12-16 12:56:53'),
(134, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 12:57:16', '2025-12-16 12:57:16'),
(135, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; U; Android 11; en-us; TECNO KF6i Build/RP1A.200720.011) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.7049.99 Mobile Safari/537.36 PHX/20.0', '2025-12-16 12:58:49', '2025-12-16 12:58:49'),
(136, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 12:59:52', '2025-12-16 12:59:52'),
(137, 6, '13.246.39.11', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', '2025-12-16 13:10:42', '2025-12-16 13:10:42'),
(138, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 13:27:22', '2025-12-16 13:27:22'),
(139, 6, '63.176.102.222', 'Mozilla/5.0 (Linux; U; Android 11; TECNO CE7j Build/RP1A.200720.011; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/143.0.7499.34 Mobile Safari/537.36 OPR/96.1.2254.80015', '2025-12-16 13:51:42', '2025-12-16 13:51:42'),
(140, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 14:17:32', '2025-12-16 14:17:32'),
(141, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 14:20:06', '2025-12-16 14:20:06'),
(142, 6, '13.246.40.62', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.0.1 Mobile/15E148 Safari/604.1', '2025-12-16 14:22:18', '2025-12-16 14:22:18'),
(143, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 14:28:40', '2025-12-16 14:28:40'),
(144, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 14:40:13', '2025-12-16 14:40:13'),
(145, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 14:55:57', '2025-12-16 14:55:57'),
(146, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 15:01:41', '2025-12-16 15:01:41'),
(147, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 15:05:13', '2025-12-16 15:05:13'),
(148, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 15:11:11', '2025-12-16 15:11:11'),
(149, 6, '13.247.97.200', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', '2025-12-16 15:19:54', '2025-12-16 15:19:54'),
(150, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', '2025-12-16 15:29:24', '2025-12-16 15:29:24'),
(151, 6, '13.247.177.186', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2025-12-16 15:45:02', '2025-12-16 15:45:02'),
(152, 6, '13.247.177.186', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.0.1 Mobile/15E148 Safari/604.1', '2025-12-16 16:00:32', '2025-12-16 16:00:32'),
(153, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; U; Android 11; TECNO PR651H Build/RP1A.201005.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/142.0.7444.171 Mobile Safari/537.36 OPR/94.0.2254.78762', '2025-12-16 16:23:08', '2025-12-16 16:23:08'),
(154, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; U; Android 11; TECNO PR651H Build/RP1A.201005.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/142.0.7444.171 Mobile Safari/537.36 OPR/94.0.2254.78762', '2025-12-16 16:23:12', '2025-12-16 16:23:12'),
(155, 6, '13.245.157.229', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 16:56:20', '2025-12-16 16:56:20'),
(156, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 17:03:17', '2025-12-16 17:03:17'),
(157, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36', '2025-12-16 17:18:08', '2025-12-16 17:18:08'),
(158, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36', '2025-12-16 17:25:25', '2025-12-16 17:25:25'),
(159, 6, '13.246.242.112', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.0.1 Mobile/15E148 Safari/604.1', '2025-12-16 17:38:08', '2025-12-16 17:38:08'),
(160, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 17:39:01', '2025-12-16 17:39:01'),
(161, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 17:40:26', '2025-12-16 17:40:26'),
(162, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 19:28:26', '2025-12-16 19:28:26'),
(163, 6, '13.246.242.112', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 20:48:44', '2025-12-16 20:48:44'),
(164, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 21:35:17', '2025-12-16 21:35:17'),
(165, 6, '13.246.40.62', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_0_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/143.0.7499.108 Mobile/15E148 Safari/604.1', '2025-12-16 22:03:47', '2025-12-16 22:03:47'),
(166, 6, '13.247.177.186', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.1 Mobile/15E148 Safari/604.1', '2025-12-16 22:21:54', '2025-12-16 22:21:54'),
(167, 6, '13.247.177.186', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.2 Mobile/15E148 Safari/604.1', '2025-12-16 22:22:13', '2025-12-16 22:22:13'),
(168, 6, '13.246.242.112', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 22:22:47', '2025-12-16 22:22:47'),
(169, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 22:26:58', '2025-12-16 22:26:58'),
(170, 6, '13.246.242.112', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 22:27:02', '2025-12-16 22:27:02'),
(171, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 22:29:01', '2025-12-16 22:29:01'),
(172, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 22:29:30', '2025-12-16 22:29:30'),
(173, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 22:30:19', '2025-12-16 22:30:19'),
(174, 6, '13.246.242.112', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 22:30:55', '2025-12-16 22:30:55'),
(175, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 22:38:25', '2025-12-16 22:38:25'),
(176, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 22:40:03', '2025-12-16 22:40:03'),
(177, 6, '13.246.242.112', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 22:42:30', '2025-12-16 22:42:30'),
(178, 6, '13.246.242.112', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.2 Mobile/15E148 Safari/604.1', '2025-12-16 22:46:33', '2025-12-16 22:46:33'),
(179, 6, '13.247.177.186', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.0.1 Mobile/15E148 Safari/604.1', '2025-12-16 22:56:38', '2025-12-16 22:56:38'),
(180, 6, '13.246.40.62', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.2 Mobile/15E148 Safari/604.1', '2025-12-16 22:57:06', '2025-12-16 22:57:06'),
(181, 6, '13.246.242.112', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.2 Mobile/15E148 Safari/604.1', '2025-12-16 23:01:00', '2025-12-16 23:01:00'),
(182, 6, '13.246.242.112', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', '2025-12-16 23:04:32', '2025-12-16 23:04:32'),
(183, 6, '13.246.242.112', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', '2025-12-16 23:11:20', '2025-12-16 23:11:20'),
(184, 6, '13.246.242.112', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.2 Mobile/15E148 Safari/604.1', '2025-12-16 23:21:31', '2025-12-16 23:21:31'),
(185, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-16 23:30:32', '2025-12-16 23:30:32'),
(186, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', '2025-12-16 23:31:03', '2025-12-16 23:31:03'),
(187, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 23:33:12', '2025-12-16 23:33:12'),
(188, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 23:33:13', '2025-12-16 23:33:13'),
(189, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', '2025-12-16 23:37:49', '2025-12-16 23:37:49'),
(190, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 23:52:06', '2025-12-16 23:52:06'),
(191, 6, '13.246.12.230', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-16 23:54:34', '2025-12-16 23:54:34'),
(192, 6, '13.247.177.186', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.1 Mobile/15E148 Safari/604.1', '2025-12-16 23:58:41', '2025-12-16 23:58:41'),
(193, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-17 01:01:25', '2025-12-17 01:01:25'),
(194, 6, '100.30.255.76', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', '2025-12-17 01:01:29', '2025-12-17 01:01:29'),
(195, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/27.0 Chrome/125.0.0.0 Mobile Safari/537.36', '2025-12-17 01:18:06', '2025-12-17 01:18:06'),
(196, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-17 01:59:35', '2025-12-17 01:59:35'),
(197, 6, '13.247.177.186', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/142.0.7444.148 Mobile/15E148 Safari/604.1', '2025-12-17 02:02:10', '2025-12-17 02:02:10'),
(198, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-17 02:44:40', '2025-12-17 02:44:40'),
(199, 6, '13.247.223.240', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-17 03:31:33', '2025-12-17 03:31:33'),
(200, 6, '13.247.223.240', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_0_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/143.0.7499.108 Mobile/15E148 Safari/604.1', '2025-12-17 04:29:31', '2025-12-17 04:29:31'),
(201, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-17 04:41:53', '2025-12-17 04:41:53'),
(202, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-17 08:17:02', '2025-12-17 08:17:02'),
(203, 6, '63.176.102.222', 'Mozilla/5.0 (Linux; U; Android 11; TECNO PR651H Build/RP1A.201005.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/142.0.7444.171 Mobile Safari/537.36 OPR/94.0.2254.78762', '2025-12-17 13:43:55', '2025-12-17 13:43:55'),
(204, 6, '18.192.119.108', 'Mozilla/5.0 (Linux; U; Android 11; TECNO PR651H Build/RP1A.201005.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/142.0.7444.171 Mobile Safari/537.36 OPR/94.0.2254.78762', '2025-12-17 13:52:12', '2025-12-17 13:52:12'),
(205, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-17 14:24:36', '2025-12-17 14:24:36'),
(206, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-17 14:47:35', '2025-12-17 14:47:35'),
(207, 6, '13.245.5.109', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/142.0.7444.148 Mobile/15E148 Safari/604.1', '2025-12-17 17:49:56', '2025-12-17 17:49:56'),
(208, 6, '13.245.5.109', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-17 19:06:27', '2025-12-17 19:06:27'),
(209, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-17 19:06:49', '2025-12-17 19:06:49'),
(210, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-17 19:08:43', '2025-12-17 19:08:43'),
(211, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-17 19:08:53', '2025-12-17 19:08:53'),
(212, 6, '13.245.5.109', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-17 19:39:29', '2025-12-17 19:39:29'),
(213, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-17 19:53:45', '2025-12-17 19:53:45'),
(214, 6, '13.245.5.109', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_0_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/143.0.7499.108 Mobile/15E148 Safari/604.1', '2025-12-17 21:10:19', '2025-12-17 21:10:19'),
(215, 6, '13.247.177.186', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.2 Mobile/15E148 Safari/604.1', '2025-12-17 22:36:25', '2025-12-17 22:36:25'),
(216, 6, '13.245.5.109', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-17 23:00:36', '2025-12-17 23:00:36'),
(217, 6, '13.247.62.179', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-18 02:00:51', '2025-12-18 02:00:51'),
(218, 6, '13.246.40.62', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-18 13:49:19', '2025-12-18 13:49:19'),
(219, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-18 16:08:03', '2025-12-18 16:08:03'),
(220, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', '2025-12-18 19:59:15', '2025-12-18 19:59:15'),
(221, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', '2025-12-18 20:06:31', '2025-12-18 20:06:31'),
(222, 6, '16.28.32.67', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-18 21:31:51', '2025-12-18 21:31:51'),
(223, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-18 22:32:00', '2025-12-18 22:32:00'),
(224, 6, '16.28.32.67', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-18 23:29:05', '2025-12-18 23:29:05'),
(225, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-18 23:45:20', '2025-12-18 23:45:20'),
(226, 6, '16.28.32.67', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', '2025-12-19 01:49:19', '2025-12-19 01:49:19'),
(227, 6, '16.28.4.153', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36', '2025-12-19 14:28:29', '2025-12-19 14:28:29'),
(228, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-19 14:29:32', '2025-12-19 14:29:32'),
(229, 6, '13.247.65.20', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36', '2025-12-19 14:34:10', '2025-12-19 14:34:10'),
(230, 6, '16.28.4.153', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36', '2025-12-19 14:34:53', '2025-12-19 14:34:53'),
(231, 6, '16.28.4.153', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', '2025-12-19 15:23:36', '2025-12-19 15:23:36'),
(232, 6, '3.95.214.80', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', '2025-12-19 15:23:40', '2025-12-19 15:23:40'),
(233, 6, '16.28.4.153', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', '2025-12-19 15:28:37', '2025-12-19 15:28:37'),
(234, 6, '13.247.177.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', '2025-12-19 15:31:18', '2025-12-19 15:31:18'),
(235, 6, '16.28.31.240', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', '2025-12-19 20:18:54', '2025-12-19 20:18:54'),
(236, 6, '16.28.31.240', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-20 12:42:05', '2025-12-20 12:42:05'),
(237, 6, '16.28.31.240', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', '2025-12-20 13:01:08', '2025-12-20 13:01:08'),
(238, 6, '16.28.4.153', 'Mozilla/5.0 (Linux; Android 9;) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Mobile Safari/537.36', '2025-12-20 13:47:28', '2025-12-20 13:47:28'),
(239, 6, '16.28.4.153', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-20 14:44:49', '2025-12-20 14:44:49'),
(240, 6, '13.247.65.20', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', '2025-12-20 15:37:22', '2025-12-20 15:37:22'),
(241, 6, '16.28.4.153', 'Mozilla/5.0 (Linux; Android 12; Nokia G21) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.88 Mobile Safari/537.36', '2025-12-20 17:05:36', '2025-12-20 17:05:36'),
(242, 6, '16.28.31.240', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-20 22:00:34', '2025-12-20 22:00:34'),
(243, 6, '16.28.31.240', 'Mozilla/5.0 (Linux; Android 12; Nokia G21) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.88 Mobile Safari/537.36', '2025-12-20 23:00:49', '2025-12-20 23:00:49'),
(244, 6, '13.247.65.20', 'Mozilla/5.0 (Linux; Android 12; Nokia G21) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.88 Mobile Safari/537.36', '2025-12-20 23:03:00', '2025-12-20 23:03:00'),
(245, 6, '13.247.65.20', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-21 12:56:46', '2025-12-21 12:56:46'),
(246, 6, '16.28.31.240', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-21 12:58:24', '2025-12-21 12:58:24'),
(247, 6, '16.28.31.240', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-21 12:58:24', '2025-12-21 12:58:24'),
(248, 6, '16.28.31.240', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '2025-12-21 19:12:19', '2025-12-21 19:12:19'),
(249, 6, '16.28.31.240', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-21 20:28:27', '2025-12-21 20:28:27'),
(250, 6, '16.28.4.153', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-21 20:51:01', '2025-12-21 20:51:01'),
(251, 6, '13.247.65.20', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-22 03:02:11', '2025-12-22 03:02:11'),
(252, 6, '16.28.4.153', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Mobile Safari/537.36', '2025-12-22 13:35:11', '2025-12-22 13:35:11');
INSERT INTO `referral_clicks` (`id`, `referral_id`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(253, 6, '13.247.65.20', 'Mozilla/5.0 (Linux; Android 12; Nokia G21) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.88 Mobile Safari/537.36', '2025-12-22 16:17:59', '2025-12-22 16:17:59'),
(254, 6, '13.247.65.20', 'Mozilla/5.0 (Linux; Android 12; Nokia G21) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.88 Mobile Safari/537.36', '2025-12-22 17:01:56', '2025-12-22 17:01:56'),
(255, 6, '13.247.65.20', 'Mozilla/5.0 (Linux; Android 12; SM-G975F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36', '2025-12-23 15:39:48', '2025-12-23 15:39:48'),
(256, 6, '16.28.31.240', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', '2025-12-24 12:58:56', '2025-12-24 12:58:56'),
(257, 6, '16.28.31.240', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-26 19:56:15', '2025-12-26 19:56:15'),
(258, 6, '16.28.18.101', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-26 20:35:09', '2025-12-26 20:35:09'),
(259, 6, '16.28.18.101', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-26 20:56:41', '2025-12-26 20:56:41'),
(260, 6, '16.28.31.240', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2025-12-28 01:06:21', '2025-12-28 01:06:21'),
(261, 6, '16.28.95.58', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2025-12-28 15:36:02', '2025-12-28 15:36:02'),
(262, 6, '16.28.95.58', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-29 12:32:40', '2025-12-29 12:32:40'),
(263, 6, '16.28.31.240', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-29 17:17:38', '2025-12-29 17:17:38'),
(264, 6, '16.28.31.240', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-29 18:39:22', '2025-12-29 18:39:22'),
(265, 6, '13.244.66.7', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-29 22:21:08', '2025-12-29 22:21:08'),
(266, 6, '13.244.66.7', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-29 22:24:24', '2025-12-29 22:24:24'),
(267, 6, '13.244.66.7', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-29 22:31:33', '2025-12-29 22:31:33'),
(268, 6, '16.28.31.240', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-29 22:33:56', '2025-12-29 22:33:56'),
(269, 6, '16.28.18.101', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-30 23:27:42', '2025-12-30 23:27:42'),
(270, 6, '16.28.18.101', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-31 02:01:34', '2025-12-31 02:01:34'),
(271, 6, '13.244.66.7', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-31 02:21:00', '2025-12-31 02:21:00'),
(272, 6, '13.244.66.7', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-31 15:36:30', '2025-12-31 15:36:30'),
(273, 6, '16.28.18.101', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-31 15:41:19', '2025-12-31 15:41:19'),
(274, 6, '13.244.66.7', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-31 15:41:31', '2025-12-31 15:41:31'),
(275, 6, '16.28.18.101', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-31 15:41:46', '2025-12-31 15:41:46'),
(276, 6, '16.28.31.240', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-31 16:05:34', '2025-12-31 16:05:34'),
(277, 6, '16.28.18.101', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2025-12-31 16:17:32', '2025-12-31 16:17:32'),
(278, 6, '13.244.66.7', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.7.2 Mobile/15E148 Safari/604.1', '2025-12-31 21:46:28', '2025-12-31 21:46:28'),
(279, 6, '13.244.66.7', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-01 21:04:08', '2026-01-01 21:04:08'),
(280, 6, '13.244.66.7', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-01 21:09:20', '2026-01-01 21:09:20'),
(281, 6, '16.28.108.248', 'Mozilla/5.0 (Linux; Android 12; Nokia G21) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.88 Mobile Safari/537.36', '2026-01-04 03:33:30', '2026-01-04 03:33:30'),
(282, 6, '13.247.90.53', 'Mozilla/5.0 (Linux; Android 12; Nokia G21) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.88 Mobile Safari/537.36', '2026-01-04 04:41:06', '2026-01-04 04:41:06'),
(283, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-05 16:26:18', '2026-01-05 16:26:18'),
(284, 6, '13.244.66.7', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', '2026-01-05 23:48:31', '2026-01-05 23:48:31'),
(285, 6, '13.244.66.7', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2026-01-06 05:32:45', '2026-01-06 05:32:45'),
(286, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-06 12:13:55', '2026-01-06 12:13:55'),
(287, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-06 12:25:10', '2026-01-06 12:25:10'),
(288, 6, '13.244.66.7', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2026-01-06 13:24:00', '2026-01-06 13:24:00'),
(289, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-07 06:38:59', '2026-01-07 06:38:59'),
(290, 6, '13.245.4.251', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-07 16:41:36', '2026-01-07 16:41:36'),
(291, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-09 13:41:03', '2026-01-09 13:41:03'),
(292, 6, '13.245.30.152', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-09 13:59:32', '2026-01-09 13:59:32'),
(293, 6, '16.28.28.14', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-10 15:03:44', '2026-01-10 15:03:44'),
(294, 6, '16.28.28.14', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-10 15:25:00', '2026-01-10 15:25:00'),
(295, 6, '13.245.30.152', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-10 16:19:13', '2026-01-10 16:19:13'),
(296, 6, '13.245.30.152', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-10 16:24:31', '2026-01-10 16:24:31'),
(297, 6, '13.245.30.152', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-10 16:32:02', '2026-01-10 16:32:02'),
(298, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-10 17:49:22', '2026-01-10 17:49:22'),
(299, 6, '16.28.28.14', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-10 18:19:57', '2026-01-10 18:19:57'),
(300, 6, '13.245.30.152', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-10 18:22:40', '2026-01-10 18:22:40'),
(301, 6, '13.245.30.152', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-10 18:25:30', '2026-01-10 18:25:30'),
(302, 6, '13.245.30.152', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-10 19:00:46', '2026-01-10 19:00:46'),
(303, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-10 19:14:01', '2026-01-10 19:14:01'),
(304, 6, '13.245.30.152', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-10 20:05:33', '2026-01-10 20:05:33'),
(305, 6, '13.247.174.137', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2026-01-11 14:04:58', '2026-01-11 14:04:58'),
(306, 6, '13.245.30.152', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2026-01-11 18:59:58', '2026-01-11 18:59:58'),
(307, 6, '13.247.229.242', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2026-01-11 21:03:23', '2026-01-11 21:03:23'),
(308, 6, '13.245.30.152', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-12 03:15:18', '2026-01-12 03:15:18'),
(309, 6, '13.245.30.152', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-12 04:01:21', '2026-01-12 04:01:21'),
(310, 6, '13.247.62.9', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-13 04:00:24', '2026-01-13 04:00:24'),
(311, 6, '13.247.62.9', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-13 06:24:03', '2026-01-13 06:24:03'),
(312, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-13 18:05:08', '2026-01-13 18:05:08'),
(313, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-14 12:53:02', '2026-01-14 12:53:02'),
(314, 6, '35.172.186.167', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', '2026-01-14 12:53:05', '2026-01-14 12:53:05'),
(315, 6, '13.245.30.111', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-14 12:55:10', '2026-01-14 12:55:10'),
(316, 6, '13.247.229.21', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-15 05:50:54', '2026-01-15 05:50:54'),
(317, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-15 06:35:18', '2026-01-15 06:35:18'),
(318, 6, '13.247.229.21', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-15 06:49:43', '2026-01-15 06:49:43'),
(319, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-15 09:30:58', '2026-01-15 09:30:58'),
(320, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-15 12:27:15', '2026-01-15 12:27:15'),
(321, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-16 01:38:51', '2026-01-16 01:38:51'),
(322, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-16 01:39:04', '2026-01-16 01:39:04'),
(323, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-16 02:00:49', '2026-01-16 02:00:49'),
(324, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-16 02:05:36', '2026-01-16 02:05:36'),
(325, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-16 02:15:17', '2026-01-16 02:15:17'),
(326, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-16 02:45:45', '2026-01-16 02:45:45'),
(327, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-16 02:45:52', '2026-01-16 02:45:52'),
(328, 6, '13.247.229.21', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-16 02:47:37', '2026-01-16 02:47:37'),
(329, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-16 03:07:54', '2026-01-16 03:07:54'),
(330, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-16 03:17:06', '2026-01-16 03:17:06'),
(331, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-16 03:50:27', '2026-01-16 03:50:27'),
(332, 6, '13.247.229.242', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-16 03:50:27', '2026-01-16 03:50:27'),
(333, 6, '13.247.229.242', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2026-01-16 05:31:12', '2026-01-16 05:31:12'),
(334, 6, '13.247.229.21', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Mobile/15E148 Safari/604.1', '2026-01-16 15:17:10', '2026-01-16 15:17:10'),
(335, 6, '16.28.64.220', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-17 05:41:47', '2026-01-17 05:41:47'),
(336, 6, '13.246.197.189', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-18 23:01:11', '2026-01-18 23:01:11'),
(337, 6, '13.246.194.189', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-18 23:02:50', '2026-01-18 23:02:50'),
(338, 6, '13.247.183.163', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '2026-01-19 18:34:26', '2026-01-19 18:34:26'),
(339, 6, '13.246.194.189', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '2026-01-19 18:36:24', '2026-01-19 18:36:24'),
(340, 6, '13.246.198.24', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-20 16:25:54', '2026-01-20 16:25:54'),
(341, 6, '13.246.194.189', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-20 16:50:22', '2026-01-20 16:50:22'),
(342, 6, '13.246.194.189', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-20 17:14:21', '2026-01-20 17:14:21'),
(343, 6, '13.246.198.24', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '2026-01-20 19:32:39', '2026-01-20 19:32:39'),
(344, 6, '13.246.198.24', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '2026-01-20 19:48:55', '2026-01-20 19:48:55'),
(345, 6, '13.245.164.8', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-20 19:57:12', '2026-01-20 19:57:12'),
(346, 6, '13.246.194.189', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-21 02:13:09', '2026-01-21 02:13:09'),
(347, 6, '13.245.8.88', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-21 05:28:08', '2026-01-21 05:28:08'),
(348, 6, '13.247.181.40', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-21 09:34:49', '2026-01-21 09:34:49'),
(349, 6, '13.247.181.40', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-21 09:56:00', '2026-01-21 09:56:00'),
(350, 6, '13.245.8.88', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-21 09:56:46', '2026-01-21 09:56:46'),
(351, 6, '13.247.231.98', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-22 05:30:05', '2026-01-22 05:30:05'),
(352, 6, '13.246.2.12', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-22 05:44:13', '2026-01-22 05:44:13'),
(353, 6, '13.246.2.12', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-22 06:05:41', '2026-01-22 06:05:41'),
(354, 6, '13.245.164.114', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-22 13:58:20', '2026-01-22 13:58:20'),
(355, 6, '13.245.164.114', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-22 15:35:36', '2026-01-22 15:35:36'),
(356, 6, '13.244.59.177', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.3 Mobile/15E148 Safari/604.1', '2026-01-22 22:50:55', '2026-01-22 22:50:55'),
(357, 6, '13.244.87.97', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-23 00:31:43', '2026-01-23 00:31:43'),
(358, 6, '13.245.8.88', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-23 05:54:53', '2026-01-23 05:54:53'),
(359, 6, '16.28.4.10', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-23 06:42:19', '2026-01-23 06:42:19'),
(360, 6, '16.28.4.10', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-23 06:51:25', '2026-01-23 06:51:25'),
(361, 6, '16.28.4.10', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-23 07:21:51', '2026-01-23 07:21:51'),
(362, 6, '13.244.157.61', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-23 12:51:57', '2026-01-23 12:51:57'),
(363, 6, '13.245.8.88', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-23 13:56:56', '2026-01-23 13:56:56'),
(364, 6, '13.244.98.90', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '2026-01-24 02:27:01', '2026-01-24 02:27:01'),
(365, 6, '13.244.98.90', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-24 04:31:22', '2026-01-24 04:31:22'),
(366, 6, '13.244.157.61', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-24 05:43:27', '2026-01-24 05:43:27'),
(367, 6, '13.244.62.128', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '2026-01-24 11:37:49', '2026-01-24 11:37:49'),
(368, 6, '13.244.157.61', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '2026-01-24 16:57:33', '2026-01-24 16:57:33'),
(369, 6, '13.244.98.90', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-24 17:01:46', '2026-01-24 17:01:46'),
(370, 6, '13.244.157.61', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-24 18:19:40', '2026-01-24 18:19:40'),
(371, 6, '13.244.157.61', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-25 06:34:41', '2026-01-25 06:34:41'),
(372, 6, '13.244.98.90', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Mobile Safari/537.36', '2026-01-25 06:58:25', '2026-01-25 06:58:25'),
(373, 6, '13.244.98.90', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.2 Mobile/15E148 Safari/604.1', '2026-01-25 19:02:53', '2026-01-25 19:02:53');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('14rZHB6YM6q4NCTtvFLVBgc1DhBLwztQdcfno7oq', 2, '160.152.24.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS01FV1JZZ0UycHVzemQ2elZhd0xqeFkxUk5kdGQ4QU1KWTFwMFlRNyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NToiaHR0cHM6Ly9hcGkubWF2ZXJpY2tzYWkudGVjaC9wdWJsaWMvYWRtaW5fbWF2Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769211264),
('DgLEJ13gnKUbzxVuD36Vs4i7IngsFR3ZcjeC7v5j', 2, '160.152.24.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQlJZa21hWDVmbExJWUMxTDFBYmRZV3JlR05UaW1yRWlnNldQUkxiSCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NToiaHR0cHM6Ly9hcGkubWF2ZXJpY2tzYWkudGVjaC9wdWJsaWMvYWRtaW5fbWF2Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769190509),
('I1CTEIfrSIGRZ0FtrMGXcdjLYKvuNfewedKL14dD', 2, '160.152.10.116', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUU03RzZWSVV1dFlDaExXU3N6WElIT0tMcWx2WU94NmNNa2VhTVhoTSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NToiaHR0cHM6Ly9hcGkubWF2ZXJpY2tzYWkudGVjaC9wdWJsaWMvYWRtaW5fbWF2Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769288361),
('md2ex8BX8zOw8Lp5pQcCySUz3tINZzX7dByUV3Ym', 2, '102.88.108.120', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaTJXQ1BwNFZ2Rk1PVmJYdUgzRHRWTlZYR0p2bXNNYmd5V0tHSXh2eiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NToiaHR0cHM6Ly9hcGkubWF2ZXJpY2tzYWkudGVjaC9wdWJsaWMvYWRtaW5fbWF2Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769236378),
('QcE5SevmWruPAG3zEjKUwHM1o1I9CBvwpfj6oEg8', 2, '160.152.24.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMjFNbEZkUlFYQmo3MGxBZ2lYVDRTTVZMbTdET3BXSU9LMkFyZldTYiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NToiaHR0cHM6Ly9hcGkubWF2ZXJpY2tzYWkudGVjaC9wdWJsaWMvYWRtaW5fbWF2Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769155424),
('Vi7Ci1XB6xCOk3GNDN2TsYqINVb0siZ7Jz43PHWA', 2, '160.152.24.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRnBHNmFackRtNWRRa2dTUHVGZ2MydFBvYzZPYmdHc1R3b211R2hCNCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NToiaHR0cHM6Ly9hcGkubWF2ZXJpY2tzYWkudGVjaC9wdWJsaWMvYWRtaW5fbWF2Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769163182);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `plan` varchar(255) NOT NULL DEFAULT 'free',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `billing_cycle` enum('monthly','yearly') NOT NULL DEFAULT 'monthly',
  `flutterwave_transaction_id` varchar(255) DEFAULT NULL,
  `flutterwave_tx_ref` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'NGN',
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `auto_renew` tinyint(1) NOT NULL DEFAULT 0,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `plan`, `status`, `billing_cycle`, `flutterwave_transaction_id`, `flutterwave_tx_ref`, `amount`, `currency`, `start_date`, `end_date`, `auto_renew`, `cancelled_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-10-22 01:45:13', NULL, 0, NULL, '2025-10-22 01:45:13', '2025-10-22 01:45:13'),
(2, 2, 'premium', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-10-22 01:45:13', NULL, 0, NULL, '2025-10-22 01:45:13', '2025-10-22 01:45:13'),
(3, 3, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-03 02:49:56', NULL, 0, NULL, '2025-12-03 02:49:56', '2025-12-03 02:49:56'),
(4, 3, 'premium', 'pending', 'monthly', NULL, 'sub_3_1764712259', 21000.00, 'NGN', NULL, NULL, 0, NULL, '2025-12-03 02:50:59', '2025-12-03 02:50:59'),
(9, 5, 'free', 'expired', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-03 07:37:32', NULL, 0, NULL, '2025-12-03 07:37:32', '2025-12-03 07:41:33'),
(10, 5, 'basic', 'active', 'monthly', '1930763224', 'sub_5_1764729503', 15000.00, 'NGN', '2025-12-03 07:41:33', '2026-01-03 07:41:33', 1, NULL, '2025-12-03 07:38:24', '2025-12-03 07:41:33'),
(11, 3, 'basic', 'pending', 'monthly', NULL, 'sub_3_1764741563', 15000.00, 'NGN', NULL, NULL, 0, NULL, '2025-12-03 10:59:23', '2025-12-03 10:59:23'),
(12, 6, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-03 11:18:57', NULL, 0, NULL, '2025-12-03 11:18:57', '2025-12-03 11:18:57'),
(13, 6, 'basic', 'pending', 'monthly', NULL, 'sub_6_1764742755', 15000.00, 'NGN', NULL, NULL, 0, NULL, '2025-12-03 11:19:16', '2025-12-03 11:19:16'),
(14, 7, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-03 15:00:24', NULL, 0, NULL, '2025-12-03 15:00:24', '2025-12-03 15:00:24'),
(15, 8, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-03 17:31:24', NULL, 0, NULL, '2025-12-03 17:31:24', '2025-12-03 17:31:24'),
(16, 9, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-03 18:46:01', NULL, 0, NULL, '2025-12-03 18:46:01', '2025-12-03 18:46:01'),
(17, 10, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-03 19:33:22', NULL, 0, NULL, '2025-12-03 19:33:22', '2025-12-03 19:33:22'),
(18, 11, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-03 20:42:54', NULL, 0, NULL, '2025-12-03 20:42:54', '2025-12-03 20:42:54'),
(19, 12, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-03 21:14:14', NULL, 0, NULL, '2025-12-03 21:14:14', '2025-12-03 21:14:14'),
(20, 13, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-03 21:35:19', NULL, 0, NULL, '2025-12-03 21:35:19', '2025-12-03 21:35:19'),
(21, 14, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-03 22:41:14', NULL, 0, NULL, '2025-12-03 22:41:14', '2025-12-03 22:41:14'),
(22, 15, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-03 23:26:00', NULL, 0, NULL, '2025-12-03 23:26:00', '2025-12-03 23:26:00'),
(23, 16, 'free', 'expired', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 00:22:13', NULL, 0, NULL, '2025-12-04 00:22:13', '2025-12-06 08:52:04'),
(24, 17, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 00:49:37', NULL, 0, NULL, '2025-12-04 00:49:37', '2025-12-04 00:49:37'),
(25, 18, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 01:23:30', NULL, 0, NULL, '2025-12-04 01:23:30', '2025-12-04 01:23:30'),
(26, 19, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 01:30:44', NULL, 0, NULL, '2025-12-04 01:30:44', '2025-12-04 01:30:44'),
(27, 20, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 01:53:25', NULL, 0, NULL, '2025-12-04 01:53:25', '2025-12-04 01:53:25'),
(28, 21, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 02:21:19', NULL, 0, NULL, '2025-12-04 02:21:19', '2025-12-04 02:21:19'),
(29, 22, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 02:33:40', NULL, 0, NULL, '2025-12-04 02:33:40', '2025-12-04 02:33:40'),
(30, 23, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 02:36:51', NULL, 0, NULL, '2025-12-04 02:36:51', '2025-12-04 02:36:51'),
(31, 24, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 09:06:49', NULL, 0, NULL, '2025-12-04 09:06:49', '2025-12-04 09:06:49'),
(32, 25, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 11:22:45', NULL, 0, NULL, '2025-12-04 11:22:45', '2025-12-04 11:22:45'),
(33, 26, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 12:04:27', NULL, 0, NULL, '2025-12-04 12:04:27', '2025-12-04 12:04:27'),
(34, 27, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 12:13:48', NULL, 0, NULL, '2025-12-04 12:13:48', '2025-12-04 12:13:48'),
(35, 28, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 13:51:47', NULL, 0, NULL, '2025-12-04 13:51:47', '2025-12-04 13:51:47'),
(36, 29, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 18:40:59', NULL, 0, NULL, '2025-12-04 18:40:59', '2025-12-04 18:40:59'),
(37, 30, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 19:09:17', NULL, 0, NULL, '2025-12-04 19:09:17', '2025-12-04 19:09:17'),
(38, 31, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 19:39:14', NULL, 0, NULL, '2025-12-04 19:39:14', '2025-12-04 19:39:14'),
(39, 32, 'free', 'expired', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 19:57:09', NULL, 0, NULL, '2025-12-04 19:57:09', '2026-01-22 14:23:34'),
(40, 33, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-04 22:06:25', NULL, 0, NULL, '2025-12-04 22:06:25', '2025-12-04 22:06:25'),
(41, 34, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-05 12:11:44', NULL, 0, NULL, '2025-12-05 12:11:44', '2025-12-05 12:11:44'),
(42, 34, 'basic', 'pending', 'monthly', NULL, 'sub_34_1764918765', 15000.00, 'NGN', NULL, NULL, 0, NULL, '2025-12-05 12:12:45', '2025-12-05 12:12:45'),
(43, 16, 'basic', 'pending', 'monthly', NULL, 'sub_16_1764926593', 15000.00, 'NGN', NULL, NULL, 0, NULL, '2025-12-05 14:23:13', '2025-12-05 14:23:13'),
(44, 35, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-05 17:33:16', NULL, 0, NULL, '2025-12-05 17:33:16', '2025-12-05 17:33:16'),
(45, 5, 'premium', 'pending', 'monthly', NULL, 'sub_5_1764939287', 21000.00, 'NGN', NULL, NULL, 0, NULL, '2025-12-05 17:54:47', '2025-12-07 11:42:51'),
(46, 5, 'enterprise', 'pending', 'monthly', NULL, 'sub_5_1764939312', 37500.00, 'NGN', NULL, NULL, 0, NULL, '2025-12-05 17:55:13', '2025-12-07 11:42:27'),
(47, 36, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-05 19:36:04', NULL, 0, NULL, '2025-12-05 19:36:04', '2025-12-05 19:36:04'),
(48, 37, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-06 02:18:49', NULL, 0, NULL, '2025-12-06 02:18:49', '2025-12-06 02:18:49'),
(49, 16, 'basic', 'active', 'monthly', '1932883732', 'sub_16_1764992386', 15000.00, 'NGN', '2025-12-06 08:52:04', '2026-01-06 08:52:04', 1, NULL, '2025-12-06 08:39:46', '2025-12-06 08:52:04'),
(50, 38, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-07 00:36:20', NULL, 0, NULL, '2025-12-07 00:36:20', '2025-12-07 00:36:20'),
(51, 39, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-07 00:41:49', NULL, 0, NULL, '2025-12-07 00:41:49', '2025-12-07 00:41:49'),
(52, 40, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-07 00:42:06', NULL, 0, NULL, '2025-12-07 00:42:06', '2025-12-07 00:42:06'),
(53, 41, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-07 01:03:36', NULL, 0, NULL, '2025-12-07 01:03:36', '2025-12-07 01:03:36'),
(54, 42, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-07 01:05:06', NULL, 0, NULL, '2025-12-07 01:05:06', '2025-12-07 01:05:06'),
(55, 43, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-07 01:06:59', NULL, 0, NULL, '2025-12-07 01:06:59', '2025-12-07 01:06:59'),
(56, 44, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-07 01:11:33', NULL, 0, NULL, '2025-12-07 01:11:33', '2025-12-07 01:11:33'),
(57, 45, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-07 01:49:17', NULL, 0, NULL, '2025-12-07 01:49:17', '2025-12-07 01:49:17'),
(58, 46, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-07 02:17:57', NULL, 0, NULL, '2025-12-07 02:17:57', '2025-12-07 02:17:57'),
(59, 47, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-07 15:16:42', NULL, 0, NULL, '2025-12-07 15:16:42', '2025-12-07 15:16:42'),
(60, 48, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-07 23:34:34', NULL, 0, NULL, '2025-12-07 23:34:34', '2025-12-07 23:34:34'),
(61, 49, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-08 00:49:26', NULL, 0, NULL, '2025-12-08 00:49:26', '2025-12-08 00:49:26'),
(62, 50, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-08 12:11:17', NULL, 0, NULL, '2025-12-08 12:11:17', '2025-12-08 12:11:17'),
(63, 51, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-08 15:54:10', NULL, 0, NULL, '2025-12-08 15:54:10', '2025-12-08 15:54:10'),
(64, 52, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-08 16:05:02', NULL, 0, NULL, '2025-12-08 16:05:02', '2025-12-08 16:05:02'),
(65, 53, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-09 01:32:50', NULL, 0, NULL, '2025-12-09 01:32:50', '2025-12-09 01:32:50'),
(66, 54, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-09 01:34:36', NULL, 0, NULL, '2025-12-09 01:34:36', '2025-12-09 01:34:36'),
(67, 55, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-09 10:38:50', NULL, 0, NULL, '2025-12-09 10:38:50', '2025-12-09 10:38:50'),
(68, 56, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-09 14:48:23', NULL, 0, NULL, '2025-12-09 14:48:23', '2025-12-09 14:48:23'),
(69, 57, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-09 19:35:15', NULL, 0, NULL, '2025-12-09 19:35:15', '2025-12-09 19:35:15'),
(70, 58, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-09 19:54:03', NULL, 0, NULL, '2025-12-09 19:54:03', '2025-12-09 19:54:03'),
(71, 59, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-10 01:12:53', NULL, 0, NULL, '2025-12-10 01:12:53', '2025-12-10 01:12:53'),
(72, 60, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-10 09:53:43', NULL, 0, NULL, '2025-12-10 09:53:43', '2025-12-10 09:53:43'),
(73, 61, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-10 11:09:26', NULL, 0, NULL, '2025-12-10 11:09:26', '2025-12-10 11:09:26'),
(74, 62, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-10 18:02:28', NULL, 0, NULL, '2025-12-10 18:02:28', '2025-12-10 18:02:28'),
(75, 63, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-10 23:45:00', NULL, 0, NULL, '2025-12-10 23:45:00', '2025-12-10 23:45:00'),
(76, 64, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-11 02:03:09', NULL, 0, NULL, '2025-12-11 02:03:09', '2025-12-11 02:03:09'),
(77, 65, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-11 04:16:55', NULL, 0, NULL, '2025-12-11 04:16:55', '2025-12-11 04:16:55'),
(78, 66, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-11 21:40:43', NULL, 0, NULL, '2025-12-11 21:40:43', '2025-12-11 21:40:43'),
(79, 67, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-12 01:46:09', NULL, 0, NULL, '2025-12-12 01:46:09', '2025-12-12 01:46:09'),
(80, 68, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-12 08:37:07', NULL, 0, NULL, '2025-12-12 08:37:07', '2025-12-12 08:37:07'),
(81, 69, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-12 12:17:06', NULL, 0, NULL, '2025-12-12 12:17:06', '2025-12-12 12:17:06'),
(82, 70, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-12 18:55:22', NULL, 0, NULL, '2025-12-12 18:55:22', '2025-12-12 18:55:22'),
(83, 71, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-13 17:15:10', NULL, 0, NULL, '2025-12-13 17:15:10', '2025-12-13 17:15:10'),
(84, 72, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-14 01:01:33', NULL, 0, NULL, '2025-12-14 01:01:33', '2025-12-14 01:01:33'),
(85, 73, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-14 21:41:10', NULL, 0, NULL, '2025-12-14 21:41:10', '2025-12-14 21:41:10'),
(86, 74, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-14 21:55:54', NULL, 0, NULL, '2025-12-14 21:55:54', '2025-12-14 21:55:54'),
(87, 75, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-14 22:19:49', NULL, 0, NULL, '2025-12-14 22:19:49', '2025-12-14 22:19:49'),
(88, 76, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-14 22:28:17', NULL, 0, NULL, '2025-12-14 22:28:17', '2025-12-14 22:28:17'),
(89, 77, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-14 23:05:50', NULL, 0, NULL, '2025-12-14 23:05:50', '2025-12-14 23:05:50'),
(90, 78, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-14 23:16:55', NULL, 0, NULL, '2025-12-14 23:16:55', '2025-12-14 23:16:55'),
(91, 79, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-15 00:49:09', NULL, 0, NULL, '2025-12-15 00:49:09', '2025-12-15 00:49:09'),
(92, 80, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-15 13:50:53', NULL, 0, NULL, '2025-12-15 13:50:53', '2025-12-15 13:50:53'),
(93, 81, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-15 16:39:31', NULL, 0, NULL, '2025-12-15 16:39:31', '2025-12-15 16:39:31'),
(94, 82, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-15 18:41:28', NULL, 0, NULL, '2025-12-15 18:41:28', '2025-12-15 18:41:28'),
(95, 83, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-15 19:49:49', NULL, 0, NULL, '2025-12-15 19:49:49', '2025-12-15 19:49:49'),
(96, 84, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-15 19:56:22', NULL, 0, NULL, '2025-12-15 19:56:22', '2025-12-15 19:56:22'),
(97, 85, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-15 20:03:44', NULL, 0, NULL, '2025-12-15 20:03:44', '2025-12-15 20:03:44'),
(98, 86, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-15 21:03:54', NULL, 0, NULL, '2025-12-15 21:03:54', '2025-12-15 21:03:54'),
(99, 87, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 00:29:48', NULL, 0, NULL, '2025-12-16 00:29:48', '2025-12-16 00:29:48'),
(100, 88, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 00:29:58', NULL, 0, NULL, '2025-12-16 00:29:58', '2025-12-16 00:29:58'),
(101, 89, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 00:32:22', NULL, 0, NULL, '2025-12-16 00:32:22', '2025-12-16 00:32:22'),
(102, 90, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 00:33:45', NULL, 0, NULL, '2025-12-16 00:33:45', '2025-12-16 00:33:45'),
(103, 91, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 00:34:04', NULL, 0, NULL, '2025-12-16 00:34:04', '2025-12-16 00:34:04'),
(104, 92, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 00:42:03', NULL, 0, NULL, '2025-12-16 00:42:03', '2025-12-16 00:42:03'),
(105, 93, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 00:42:54', NULL, 0, NULL, '2025-12-16 00:42:54', '2025-12-16 00:42:54'),
(106, 94, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 00:45:40', NULL, 0, NULL, '2025-12-16 00:45:40', '2025-12-16 00:45:40'),
(107, 95, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 00:48:27', NULL, 0, NULL, '2025-12-16 00:48:27', '2025-12-16 00:48:27'),
(108, 96, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 00:51:37', NULL, 0, NULL, '2025-12-16 00:51:37', '2025-12-16 00:51:37'),
(109, 97, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 00:52:10', NULL, 0, NULL, '2025-12-16 00:52:10', '2025-12-16 00:52:10'),
(110, 98, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 00:52:55', NULL, 0, NULL, '2025-12-16 00:52:55', '2025-12-16 00:52:55'),
(111, 99, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 01:00:10', NULL, 0, NULL, '2025-12-16 01:00:10', '2025-12-16 01:00:10'),
(112, 100, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 01:00:40', NULL, 0, NULL, '2025-12-16 01:00:40', '2025-12-16 01:00:40'),
(113, 101, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 01:21:39', NULL, 0, NULL, '2025-12-16 01:21:39', '2025-12-16 01:21:39'),
(114, 102, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 02:06:28', NULL, 0, NULL, '2025-12-16 02:06:28', '2025-12-16 02:06:28'),
(115, 103, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 02:07:32', NULL, 0, NULL, '2025-12-16 02:07:32', '2025-12-16 02:07:32'),
(116, 104, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 02:13:28', NULL, 0, NULL, '2025-12-16 02:13:28', '2025-12-16 02:13:28'),
(117, 105, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 06:24:01', NULL, 0, NULL, '2025-12-16 06:24:01', '2025-12-16 06:24:01'),
(118, 106, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 12:10:06', NULL, 0, NULL, '2025-12-16 12:10:06', '2025-12-16 12:10:06'),
(119, 107, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 12:29:43', NULL, 0, NULL, '2025-12-16 12:29:43', '2025-12-16 12:29:43'),
(120, 108, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 12:33:53', NULL, 0, NULL, '2025-12-16 12:33:53', '2025-12-16 12:33:53'),
(121, 109, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 12:34:22', NULL, 0, NULL, '2025-12-16 12:34:22', '2025-12-16 12:34:22'),
(122, 110, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 12:34:57', NULL, 0, NULL, '2025-12-16 12:34:57', '2025-12-16 12:34:57'),
(123, 111, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 12:41:11', NULL, 0, NULL, '2025-12-16 12:41:11', '2025-12-16 12:41:11'),
(124, 112, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 12:41:25', NULL, 0, NULL, '2025-12-16 12:41:25', '2025-12-16 12:41:25'),
(125, 113, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 12:52:12', NULL, 0, NULL, '2025-12-16 12:52:12', '2025-12-16 12:52:12'),
(126, 114, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 12:56:13', NULL, 0, NULL, '2025-12-16 12:56:13', '2025-12-16 12:56:13'),
(127, 115, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 12:59:39', NULL, 0, NULL, '2025-12-16 12:59:39', '2025-12-16 12:59:39'),
(128, 116, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 13:11:29', NULL, 0, NULL, '2025-12-16 13:11:29', '2025-12-16 13:11:29'),
(129, 117, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 13:28:00', NULL, 0, NULL, '2025-12-16 13:28:00', '2025-12-16 13:28:00'),
(130, 118, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 14:18:12', NULL, 0, NULL, '2025-12-16 14:18:12', '2025-12-16 14:18:12'),
(131, 119, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 14:21:50', NULL, 0, NULL, '2025-12-16 14:21:50', '2025-12-16 14:21:50'),
(132, 120, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 14:23:01', NULL, 0, NULL, '2025-12-16 14:23:01', '2025-12-16 14:23:01'),
(133, 121, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 14:29:23', NULL, 0, NULL, '2025-12-16 14:29:23', '2025-12-16 14:29:23'),
(134, 122, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 14:41:15', NULL, 0, NULL, '2025-12-16 14:41:15', '2025-12-16 14:41:15'),
(135, 123, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 14:57:32', NULL, 0, NULL, '2025-12-16 14:57:32', '2025-12-16 14:57:32'),
(136, 124, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 15:13:14', NULL, 0, NULL, '2025-12-16 15:13:14', '2025-12-16 15:13:14'),
(137, 125, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 15:20:40', NULL, 0, NULL, '2025-12-16 15:20:40', '2025-12-16 15:20:40'),
(138, 126, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 15:30:08', NULL, 0, NULL, '2025-12-16 15:30:08', '2025-12-16 15:30:08'),
(139, 127, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 16:25:21', NULL, 0, NULL, '2025-12-16 16:25:21', '2025-12-16 16:25:21'),
(140, 128, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 17:19:23', NULL, 0, NULL, '2025-12-16 17:19:23', '2025-12-16 17:19:23'),
(141, 129, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 17:24:07', NULL, 0, NULL, '2025-12-16 17:24:07', '2025-12-16 17:24:07'),
(142, 130, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 17:40:38', NULL, 0, NULL, '2025-12-16 17:40:38', '2025-12-16 17:40:38'),
(143, 131, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 20:49:01', NULL, 0, NULL, '2025-12-16 20:49:01', '2025-12-16 20:49:01'),
(144, 132, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 21:37:15', NULL, 0, NULL, '2025-12-16 21:37:15', '2025-12-16 21:37:15'),
(145, 133, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 22:24:04', NULL, 0, NULL, '2025-12-16 22:24:04', '2025-12-16 22:24:04'),
(146, 134, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 22:27:49', NULL, 0, NULL, '2025-12-16 22:27:49', '2025-12-16 22:27:49'),
(147, 135, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 22:29:40', NULL, 0, NULL, '2025-12-16 22:29:40', '2025-12-16 22:29:40'),
(148, 136, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 22:42:50', NULL, 0, NULL, '2025-12-16 22:42:50', '2025-12-16 22:42:50'),
(149, 137, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 22:58:36', NULL, 0, NULL, '2025-12-16 22:58:36', '2025-12-16 22:58:36'),
(150, 138, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 23:01:36', NULL, 0, NULL, '2025-12-16 23:01:36', '2025-12-16 23:01:36'),
(151, 139, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 23:05:15', NULL, 0, NULL, '2025-12-16 23:05:15', '2025-12-16 23:05:15'),
(152, 140, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 23:24:07', NULL, 0, NULL, '2025-12-16 23:24:07', '2025-12-16 23:24:07'),
(153, 141, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 23:32:53', NULL, 0, NULL, '2025-12-16 23:32:53', '2025-12-16 23:32:53'),
(154, 142, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 23:33:44', NULL, 0, NULL, '2025-12-16 23:33:44', '2025-12-16 23:33:44'),
(155, 143, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-16 23:37:06', NULL, 0, NULL, '2025-12-16 23:37:06', '2025-12-16 23:37:06'),
(156, 144, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-17 01:02:05', NULL, 0, NULL, '2025-12-17 01:02:05', '2025-12-17 01:02:05'),
(157, 145, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-17 01:18:46', NULL, 0, NULL, '2025-12-17 01:18:46', '2025-12-17 01:18:46'),
(158, 146, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-17 02:02:49', NULL, 0, NULL, '2025-12-17 02:02:49', '2025-12-17 02:02:49'),
(159, 147, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-17 03:31:54', NULL, 0, NULL, '2025-12-17 03:31:54', '2025-12-17 03:31:54'),
(160, 148, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-17 08:17:39', NULL, 0, NULL, '2025-12-17 08:17:39', '2025-12-17 08:17:39'),
(161, 149, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-17 19:07:35', NULL, 0, NULL, '2025-12-17 19:07:35', '2025-12-17 19:07:35'),
(162, 150, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-17 23:04:36', NULL, 0, NULL, '2025-12-17 23:04:36', '2025-12-17 23:04:36'),
(163, 151, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-18 02:36:36', NULL, 0, NULL, '2025-12-18 02:36:36', '2025-12-18 02:36:36'),
(164, 152, 'free', 'expired', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-18 19:28:06', NULL, 0, NULL, '2025-12-18 19:28:06', '2026-01-05 13:24:48'),
(165, 152, 'basic', 'pending', 'monthly', NULL, 'sub_152_1766068449', 15000.00, 'NGN', NULL, NULL, 0, NULL, '2025-12-18 19:34:10', '2025-12-18 19:34:10'),
(166, 153, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-18 19:59:54', NULL, 0, NULL, '2025-12-18 19:59:54', '2025-12-18 19:59:54'),
(167, 154, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-19 14:29:34', NULL, 0, NULL, '2025-12-19 14:29:34', '2025-12-19 14:29:34'),
(168, 155, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-19 15:25:21', NULL, 0, NULL, '2025-12-19 15:25:21', '2025-12-19 15:25:21'),
(169, 156, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-20 13:48:10', NULL, 0, NULL, '2025-12-20 13:48:10', '2025-12-20 13:48:10'),
(170, 157, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-20 14:55:52', NULL, 0, NULL, '2025-12-20 14:55:52', '2025-12-20 14:55:52'),
(171, 158, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-20 17:06:22', NULL, 0, NULL, '2025-12-20 17:06:22', '2025-12-20 17:06:22'),
(172, 159, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-21 13:01:37', NULL, 0, NULL, '2025-12-21 13:01:37', '2025-12-21 13:01:37'),
(173, 160, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-22 13:35:35', NULL, 0, NULL, '2025-12-22 13:35:35', '2025-12-22 13:35:35'),
(174, 161, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-22 21:12:04', NULL, 0, NULL, '2025-12-22 21:12:04', '2025-12-22 21:12:04'),
(175, 162, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-23 01:26:32', NULL, 0, NULL, '2025-12-23 01:26:32', '2025-12-23 01:26:32'),
(176, 163, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-23 15:36:49', NULL, 0, NULL, '2025-12-23 15:36:49', '2025-12-23 15:36:49'),
(177, 164, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-23 17:04:52', NULL, 0, NULL, '2025-12-23 17:04:52', '2025-12-23 17:04:52'),
(178, 165, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-23 23:49:36', NULL, 0, NULL, '2025-12-23 23:49:36', '2025-12-23 23:49:36'),
(179, 166, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-24 16:52:15', NULL, 0, NULL, '2025-12-24 16:52:15', '2025-12-24 16:52:15'),
(180, 167, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-25 00:36:14', NULL, 0, NULL, '2025-12-25 00:36:14', '2025-12-25 00:36:14'),
(181, 168, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 02:58:32', NULL, 0, NULL, '2025-12-26 02:58:32', '2025-12-26 02:58:32'),
(182, 169, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 12:30:10', NULL, 0, NULL, '2025-12-26 12:30:10', '2025-12-26 12:30:10'),
(183, 170, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:36:31', NULL, 0, NULL, '2025-12-26 13:36:31', '2025-12-26 13:36:31'),
(184, 171, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:37:15', NULL, 0, NULL, '2025-12-26 13:37:15', '2025-12-26 13:37:15'),
(185, 172, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:37:40', NULL, 0, NULL, '2025-12-26 13:37:40', '2025-12-26 13:37:40'),
(186, 173, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:39:46', NULL, 0, NULL, '2025-12-26 13:39:46', '2025-12-26 13:39:46'),
(187, 174, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:39:54', NULL, 0, NULL, '2025-12-26 13:39:54', '2025-12-26 13:39:54'),
(188, 175, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:41:32', NULL, 0, NULL, '2025-12-26 13:41:32', '2025-12-26 13:41:32'),
(189, 176, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:43:00', NULL, 0, NULL, '2025-12-26 13:43:00', '2025-12-26 13:43:00'),
(190, 177, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:45:01', NULL, 0, NULL, '2025-12-26 13:45:01', '2025-12-26 13:45:01'),
(191, 178, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:45:02', NULL, 0, NULL, '2025-12-26 13:45:02', '2025-12-26 13:45:02'),
(192, 179, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:45:35', NULL, 0, NULL, '2025-12-26 13:45:35', '2025-12-26 13:45:35'),
(193, 180, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:46:18', NULL, 0, NULL, '2025-12-26 13:46:18', '2025-12-26 13:46:18'),
(194, 181, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:46:32', NULL, 0, NULL, '2025-12-26 13:46:32', '2025-12-26 13:46:32'),
(195, 182, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:50:57', NULL, 0, NULL, '2025-12-26 13:50:57', '2025-12-26 13:50:57'),
(196, 183, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:51:04', NULL, 0, NULL, '2025-12-26 13:51:04', '2025-12-26 13:51:04'),
(197, 184, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:52:16', NULL, 0, NULL, '2025-12-26 13:52:16', '2025-12-26 13:52:16'),
(198, 185, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:54:35', NULL, 0, NULL, '2025-12-26 13:54:35', '2025-12-26 13:54:35'),
(199, 186, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:55:26', NULL, 0, NULL, '2025-12-26 13:55:26', '2025-12-26 13:55:26'),
(200, 187, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 13:59:07', NULL, 0, NULL, '2025-12-26 13:59:07', '2025-12-26 13:59:07'),
(201, 188, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 14:00:46', NULL, 0, NULL, '2025-12-26 14:00:46', '2025-12-26 14:00:46'),
(202, 189, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 14:06:40', NULL, 0, NULL, '2025-12-26 14:06:40', '2025-12-26 14:06:40'),
(203, 190, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 14:13:26', NULL, 0, NULL, '2025-12-26 14:13:26', '2025-12-26 14:13:26'),
(204, 191, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 14:16:52', NULL, 0, NULL, '2025-12-26 14:16:52', '2025-12-26 14:16:52'),
(205, 192, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 14:29:00', NULL, 0, NULL, '2025-12-26 14:29:00', '2025-12-26 14:29:00'),
(206, 193, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 14:32:52', NULL, 0, NULL, '2025-12-26 14:32:52', '2025-12-26 14:32:52'),
(207, 194, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 14:34:09', NULL, 0, NULL, '2025-12-26 14:34:09', '2025-12-26 14:34:09'),
(208, 195, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 14:36:22', NULL, 0, NULL, '2025-12-26 14:36:22', '2025-12-26 14:36:22'),
(209, 196, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 15:02:47', NULL, 0, NULL, '2025-12-26 15:02:47', '2025-12-26 15:02:47'),
(210, 197, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 15:16:50', NULL, 0, NULL, '2025-12-26 15:16:50', '2025-12-26 15:16:50'),
(211, 198, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 15:19:28', NULL, 0, NULL, '2025-12-26 15:19:28', '2025-12-26 15:19:28'),
(212, 199, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 16:01:02', NULL, 0, NULL, '2025-12-26 16:01:02', '2025-12-26 16:01:02'),
(213, 200, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 16:52:40', NULL, 0, NULL, '2025-12-26 16:52:40', '2025-12-26 16:52:40'),
(214, 201, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 18:02:35', NULL, 0, NULL, '2025-12-26 18:02:35', '2025-12-26 18:02:35'),
(215, 202, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 18:49:15', NULL, 0, NULL, '2025-12-26 18:49:15', '2025-12-26 18:49:15'),
(216, 203, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 19:10:35', NULL, 0, NULL, '2025-12-26 19:10:35', '2025-12-26 19:10:35'),
(217, 204, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 19:10:59', NULL, 0, NULL, '2025-12-26 19:10:59', '2025-12-26 19:10:59'),
(218, 205, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-26 21:08:21', NULL, 0, NULL, '2025-12-26 21:08:21', '2025-12-26 21:08:21'),
(219, 206, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-27 02:36:25', NULL, 0, NULL, '2025-12-27 02:36:25', '2025-12-27 02:36:25'),
(220, 207, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-27 22:17:36', NULL, 0, NULL, '2025-12-27 22:17:36', '2025-12-27 22:17:36'),
(221, 208, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-28 01:35:21', NULL, 0, NULL, '2025-12-28 01:35:21', '2025-12-28 01:35:21'),
(222, 163, 'basic', 'pending', 'monthly', NULL, 'sub_163_1767008964', 15000.00, 'NGN', NULL, NULL, 0, NULL, '2025-12-29 16:49:24', '2025-12-29 16:49:24'),
(223, 163, 'basic', 'pending', 'monthly', NULL, 'sub_163_1767008968', 15000.00, 'NGN', NULL, NULL, 0, NULL, '2025-12-29 16:49:28', '2025-12-29 16:49:28'),
(224, 209, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-29 20:29:48', NULL, 0, NULL, '2025-12-29 20:29:48', '2025-12-29 20:29:48'),
(225, 210, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-31 12:47:50', '2026-01-03 12:47:50', 0, NULL, '2025-12-31 12:47:50', '2025-12-31 12:47:50'),
(226, 211, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2025-12-31 21:47:27', '2026-01-03 21:47:27', 0, NULL, '2025-12-31 21:47:27', '2025-12-31 21:47:27'),
(227, 5, 'premium', 'pending', 'monthly', NULL, 'sub_5_1767376121', 21000.00, 'NGN', NULL, NULL, 0, NULL, '2026-01-02 22:48:42', '2026-01-02 22:48:42'),
(228, 5, 'premium', 'pending', 'monthly', NULL, 'sub_5_1767425006', 21000.00, 'NGN', NULL, NULL, 0, NULL, '2026-01-03 12:23:26', '2026-01-03 12:23:26'),
(229, 212, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-03 13:45:44', NULL, 0, NULL, '2026-01-03 13:45:44', '2026-01-03 13:45:44'),
(230, 213, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-03 13:50:27', NULL, 0, NULL, '2026-01-03 13:50:27', '2026-01-03 13:50:27'),
(231, 214, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-03 15:06:36', NULL, 0, NULL, '2026-01-03 15:06:36', '2026-01-03 15:06:36'),
(232, 215, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-05 10:38:27', NULL, 0, NULL, '2026-01-05 10:38:27', '2026-01-05 10:38:27'),
(233, 216, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-05 11:58:53', NULL, 0, NULL, '2026-01-05 11:58:53', '2026-01-05 11:58:53'),
(234, 217, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-05 12:40:28', NULL, 0, NULL, '2026-01-05 12:40:28', '2026-01-05 12:40:28'),
(235, 152, 'premium', 'active', 'monthly', '1953161127', 'sub_152_1767601359', 21000.00, 'NGN', '2026-01-05 13:24:48', '2026-02-05 13:24:48', 1, NULL, '2026-01-05 13:22:39', '2026-01-05 13:24:48'),
(236, 218, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-05 15:23:19', NULL, 0, NULL, '2026-01-05 15:23:19', '2026-01-05 15:23:19'),
(237, 219, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-05 20:02:46', NULL, 0, NULL, '2026-01-05 20:02:46', '2026-01-05 20:02:46'),
(238, 220, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-06 01:10:15', NULL, 0, NULL, '2026-01-06 01:10:15', '2026-01-06 01:10:15'),
(239, 221, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-06 15:58:48', NULL, 0, NULL, '2026-01-06 15:58:48', '2026-01-06 15:58:48'),
(240, 222, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-06 16:06:08', NULL, 0, NULL, '2026-01-06 16:06:08', '2026-01-06 16:06:08'),
(241, 223, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-06 16:18:22', NULL, 0, NULL, '2026-01-06 16:18:22', '2026-01-06 16:18:22'),
(242, 224, 'free', 'expired', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-06 17:02:05', NULL, 0, NULL, '2026-01-06 17:02:05', '2026-01-16 15:01:20'),
(243, 225, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-06 17:08:50', NULL, 0, NULL, '2026-01-06 17:08:50', '2026-01-06 17:08:50'),
(244, 226, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-06 17:12:16', NULL, 0, NULL, '2026-01-06 17:12:16', '2026-01-06 17:12:16'),
(245, 227, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-06 17:40:25', NULL, 0, NULL, '2026-01-06 17:40:25', '2026-01-06 17:40:25'),
(246, 228, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-06 17:50:48', NULL, 0, NULL, '2026-01-06 17:50:48', '2026-01-06 17:50:48'),
(247, 229, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-06 17:54:13', NULL, 0, NULL, '2026-01-06 17:54:13', '2026-01-06 17:54:13'),
(248, 230, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-06 19:00:09', NULL, 0, NULL, '2026-01-06 19:00:09', '2026-01-06 19:00:09'),
(249, 231, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-06 19:05:10', NULL, 0, NULL, '2026-01-06 19:05:10', '2026-01-06 19:05:10'),
(250, 232, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-06 19:30:37', NULL, 0, NULL, '2026-01-06 19:30:37', '2026-01-06 19:30:37'),
(251, 5, 'enterprise', 'pending', 'yearly', NULL, 'sub_5_1767710828', 412500.00, 'NGN', NULL, NULL, 0, NULL, '2026-01-06 19:47:09', '2026-01-06 19:47:09'),
(252, 5, 'enterprise', 'pending', 'monthly', NULL, 'sub_5_1767710968', 37500.00, 'NGN', NULL, NULL, 0, NULL, '2026-01-06 19:49:28', '2026-01-06 19:49:28'),
(253, 5, 'enterprise', 'pending', 'monthly', NULL, 'sub_5_1767711048', 37500.00, 'NGN', NULL, NULL, 0, NULL, '2026-01-06 19:50:48', '2026-01-06 19:50:48'),
(254, 5, 'enterprise', 'pending', 'yearly', NULL, 'sub_5_1767711102', 412500.00, 'NGN', NULL, NULL, 0, NULL, '2026-01-06 19:51:50', '2026-01-06 19:51:50'),
(255, 233, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-06 22:22:24', NULL, 0, NULL, '2026-01-06 22:22:24', '2026-01-06 22:22:24'),
(256, 234, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-06 22:32:03', NULL, 0, NULL, '2026-01-06 22:32:03', '2026-01-06 22:32:03'),
(257, 235, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-07 02:29:24', NULL, 0, NULL, '2026-01-07 02:29:24', '2026-01-07 02:29:24'),
(258, 236, 'enterprise', 'cancelled', 'monthly', NULL, NULL, 50000.00, 'NGN', '2026-01-07 22:05:51', NULL, 0, '2026-01-07 22:07:54', '2026-01-07 17:21:53', '2026-01-07 22:07:54'),
(259, 236, 'enterprise', 'active', 'yearly', NULL, 'sub_236_1767788956', 412500.00, 'NGN', NULL, NULL, 0, NULL, '2026-01-07 17:29:18', '2026-01-07 22:07:04'),
(260, 237, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-07 17:48:23', NULL, 0, NULL, '2026-01-07 17:48:23', '2026-01-07 17:48:23'),
(261, 238, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-08 00:08:35', NULL, 0, NULL, '2026-01-08 00:08:35', '2026-01-08 00:08:35'),
(262, 239, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-08 17:27:25', NULL, 0, NULL, '2026-01-08 17:27:25', '2026-01-08 17:27:25'),
(263, 240, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-08 17:28:35', NULL, 0, NULL, '2026-01-08 17:28:35', '2026-01-08 17:28:35'),
(264, 241, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-08 18:26:12', NULL, 0, NULL, '2026-01-08 18:26:12', '2026-01-08 18:26:12'),
(265, 242, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-08 23:54:44', NULL, 0, NULL, '2026-01-08 23:54:44', '2026-01-08 23:54:44'),
(266, 243, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-09 04:13:19', NULL, 0, NULL, '2026-01-09 04:13:19', '2026-01-09 04:13:19'),
(267, 244, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-09 20:47:37', NULL, 0, NULL, '2026-01-09 20:47:37', '2026-01-09 20:47:37'),
(268, 245, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-12 10:05:52', NULL, 0, NULL, '2026-01-12 10:05:52', '2026-01-12 10:05:52'),
(269, 246, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-12 11:01:42', NULL, 0, NULL, '2026-01-12 11:01:42', '2026-01-12 11:01:42'),
(270, 247, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-12 14:23:58', NULL, 0, NULL, '2026-01-12 14:23:58', '2026-01-12 14:23:58'),
(271, 248, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-12 15:51:51', NULL, 0, NULL, '2026-01-12 15:51:51', '2026-01-12 15:51:51'),
(272, 249, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-12 19:57:32', NULL, 0, NULL, '2026-01-12 19:57:32', '2026-01-12 19:57:32'),
(273, 250, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-12 20:16:53', NULL, 0, NULL, '2026-01-12 20:16:53', '2026-01-12 20:16:53'),
(274, 251, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-13 23:16:27', NULL, 0, NULL, '2026-01-13 23:16:27', '2026-01-13 23:16:27'),
(275, 252, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-14 02:48:53', NULL, 0, NULL, '2026-01-14 02:48:53', '2026-01-14 02:48:53'),
(276, 253, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-14 12:54:55', NULL, 0, NULL, '2026-01-14 12:54:55', '2026-01-14 12:54:55'),
(277, 254, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-15 09:47:28', NULL, 0, NULL, '2026-01-15 09:47:28', '2026-01-15 09:47:28'),
(278, 255, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-15 12:44:59', NULL, 0, NULL, '2026-01-15 12:44:59', '2026-01-15 12:44:59'),
(279, 256, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-15 17:26:25', NULL, 0, NULL, '2026-01-15 17:26:25', '2026-01-15 17:26:25'),
(280, 257, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-15 17:41:26', NULL, 0, NULL, '2026-01-15 17:41:26', '2026-01-15 17:41:26'),
(281, 258, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-15 20:47:35', NULL, 0, NULL, '2026-01-15 20:47:35', '2026-01-15 20:47:35'),
(282, 224, 'premium', 'pending', 'monthly', NULL, 'sub_224_1768557449', 21000.00, 'NGN', NULL, NULL, 0, NULL, '2026-01-16 14:57:29', '2026-01-16 14:57:29'),
(283, 224, 'premium', 'active', 'monthly', '1961071746', 'sub_224_1768557476', 21000.00, 'NGN', '2026-01-16 15:01:20', '2026-02-16 15:01:20', 1, NULL, '2026-01-16 14:57:57', '2026-01-16 15:01:20'),
(284, 259, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-16 22:16:41', NULL, 0, NULL, '2026-01-16 22:16:41', '2026-01-16 22:16:41'),
(285, 3, 'basic', 'pending', 'yearly', NULL, 'sub_3_1768639945', 165000.00, 'NGN', NULL, NULL, 0, NULL, '2026-01-17 13:52:25', '2026-01-17 13:52:25'),
(286, 260, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-18 11:27:42', NULL, 0, NULL, '2026-01-18 11:27:42', '2026-01-18 11:27:42'),
(287, 261, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-18 21:36:06', NULL, 0, NULL, '2026-01-18 21:36:06', '2026-01-18 21:36:06'),
(288, 262, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-19 23:19:55', NULL, 0, NULL, '2026-01-19 23:19:55', '2026-01-19 23:19:55'),
(289, 263, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-20 01:39:37', NULL, 0, NULL, '2026-01-20 01:39:37', '2026-01-20 01:39:37'),
(290, 264, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-20 21:51:57', NULL, 0, NULL, '2026-01-20 21:51:57', '2026-01-20 21:51:57'),
(291, 265, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-20 22:42:43', NULL, 0, NULL, '2026-01-20 22:42:43', '2026-01-20 22:42:43'),
(292, 266, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-21 22:37:09', NULL, 0, NULL, '2026-01-21 22:37:09', '2026-01-21 22:37:09'),
(293, 32, 'basic', 'active', 'monthly', '1965310003', 'sub_32_1769073631', 15000.00, 'NGN', '2026-01-22 14:23:34', '2026-02-22 14:23:34', 1, NULL, '2026-01-22 14:20:32', '2026-01-22 14:23:34'),
(294, 267, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-22 22:51:33', NULL, 0, NULL, '2026-01-22 22:51:33', '2026-01-22 22:51:33'),
(295, 268, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-23 16:42:28', NULL, 0, NULL, '2026-01-23 16:42:28', '2026-01-23 16:42:28'),
(296, 269, 'free', 'active', 'monthly', NULL, NULL, NULL, 'NGN', '2026-01-25 19:03:32', NULL, 0, NULL, '2026-01-25 19:03:32', '2026-01-25 19:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `otp_code` varchar(255) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `otp_attempts` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `otp_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `otp_code`, `otp_expires_at`, `otp_attempts`, `otp_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Demo User', 'demo@mavericksai.com', '2025-10-22 01:45:13', '$2y$12$gwDdAHAXto4zTJRW3PDuUO9w6AMfecxnfd1kYDyhBHQX490w5k.22', NULL, NULL, 0, NULL, NULL, '2025-10-22 01:45:13', '2025-10-22 01:45:13'),
(2, 'Admin Demo', 'Admin@mavericksai.tech', '2025-10-22 01:45:13', '$2y$12$bo/C4GWsgMPqfXKs0QapdOjf1fbsWaHwTglq1vmZPWkyy/6F0XkEK', NULL, NULL, 0, NULL, 'OpVx9EWmUEiKQZc2y9NcVSmDGAro06iwKY6Rlnba4mHgoW7WvMmFldhI98kh', '2025-10-22 01:45:13', '2025-10-22 01:45:13'),
(3, 'aowebtech13', 'aowebtech13@gmail.com', '2025-12-03 02:50:54', '$2y$12$BU.R5y/4qFdDfSfklVUnVub1Z0uFLmhqlkNlMr65/E0xP4w3WLhx6', NULL, NULL, 0, '2025-12-03 02:50:54', NULL, '2025-12-03 02:49:56', '2025-12-03 02:50:54'),
(5, 'Mavericks & Mages LP', 'mavericksandmages@gmail.com', '2025-12-03 07:38:03', '$2y$12$i4SlIGJEBDOnFjg9iOH6.eXu8hvTuw/q3o00yE.rIX/f9pszGdncW', NULL, NULL, 0, '2025-12-03 07:38:03', NULL, '2025-12-03 07:37:32', '2025-12-03 07:38:03'),
(6, 'test', 'omoobaadeyemi853@gmail.com', '2025-12-03 11:19:10', '$2y$12$edcjUSAOcMT5xegpiiHo5em.xazFnhVQY5TuDCJle5X/xPqWegel.', NULL, NULL, 0, '2025-12-03 11:19:10', NULL, '2025-12-03 11:18:57', '2025-12-03 11:19:10'),
(7, 'Adekunle Aribisala', 'aribisala.adekunle@gmail.com', '2025-12-03 15:01:03', '$2y$12$9ClpCv8WX8568DvWPNceWeK1gIS9gTZtckv6XHdAxf1nrzWayMS6a', NULL, NULL, 0, '2025-12-03 15:01:03', NULL, '2025-12-03 15:00:24', '2025-12-03 15:01:03'),
(8, 'Kayode Ojo', 'kolpnc@gmail.com', '2025-12-03 17:32:08', '$2y$12$215sF8gyZbWOBNSmYwwwheUwtyD.NuuULW.EDU1k4Rw0P3VDiFFSy', NULL, NULL, 0, '2025-12-03 17:32:08', NULL, '2025-12-03 17:31:24', '2025-12-03 17:32:08'),
(9, 'Kayode Adeniyi', 'kayodeadeniyiesq@gmail.com', '2025-12-03 18:46:24', '$2y$12$gAmaEBvapFIc73R0EPt7le7gNxQwVNNxPh3h90gO0JQ7cSyG5hw6i', NULL, NULL, 0, '2025-12-03 18:46:24', NULL, '2025-12-03 18:46:01', '2025-12-03 18:46:24'),
(10, 'Oluwabusola O. Oluwaniyi', 'thesmartlawyerng@gmail.com', '2025-12-03 19:33:53', '$2y$12$4.KgWGxq7Uq90u30kCEGsuVXmMLgARNrbLvz7dZIZy5o2TWQPnity', NULL, NULL, 0, '2025-12-03 19:33:53', NULL, '2025-12-03 19:33:22', '2025-12-03 19:33:53'),
(11, 'Ajoke Onyinyechi Oseni', 'onyinajoke@gmail.com', '2025-12-03 20:43:27', '$2y$12$QPGJ0oL3A7Cvomy9Jtsjv.y1.wMZJli6JDgH3EBDCy3zkEoTwnoRW', NULL, NULL, 0, '2025-12-03 20:43:27', NULL, '2025-12-03 20:42:54', '2025-12-03 20:43:27'),
(12, 'Bamikole A.P. Folorunso & Co.', 'bank4law@yahoo.com', '2025-12-03 21:34:08', '$2y$12$IODimHrcmqqG0SJb.PoIGuwhHWarNVLpVw1/lXaXtcMp6WV9s.3IO', NULL, NULL, 0, '2025-12-03 21:34:08', NULL, '2025-12-03 21:14:14', '2025-12-03 21:34:08'),
(13, 'Omotola', 'toluwalopeomotola@gmail.com', '2025-12-03 21:36:19', '$2y$12$bvTZCc/9pgDuK8RZZXUQru/QgY.Jp3mDarYsuXwoTZYqz43Lcn9nS', NULL, NULL, 0, '2025-12-03 21:36:19', NULL, '2025-12-03 21:35:19', '2025-12-03 21:36:19'),
(14, 'KENNDLEY ATTORNEYS', 'kehinde@kenndleyattorneys.com.ng', '2025-12-03 22:41:46', '$2y$12$jfq0yfhJVUt4c82IzfFS1effLDt4IixVciRv.J9Xx0AAnOKdm1cpa', NULL, NULL, 0, '2025-12-03 22:41:46', NULL, '2025-12-03 22:41:14', '2025-12-03 22:41:46'),
(15, 'Shalom', 'pringy92@gmail.com', '2025-12-03 23:26:31', '$2y$12$vwI322r4nY3B5TDb33ND7OyVZjG9ziXsG1oCcDQCOU1RVOPpIxI0u', NULL, NULL, 0, '2025-12-03 23:26:31', NULL, '2025-12-03 23:26:00', '2025-12-03 23:26:31'),
(16, 'tomiikeadebayo@gmail.com', 'tomiikeadebayo@gmail.com', '2025-12-04 00:22:50', '$2y$12$Tg1A8UcLAqG6xaSvvJUgzeTUKpLlSFeEptY1MxU1bq6SgFNSXIZPe', NULL, NULL, 0, '2025-12-04 00:22:50', NULL, '2025-12-04 00:22:13', '2026-01-07 06:30:04'),
(17, 'Adlerdeb', 'adlerdebexpressions@gmail.com', '2025-12-04 00:49:57', '$2y$12$MQSMq8pgGBD4v2JmpwYSHOrk6On2XDA4wI1dzQe5ufpVZcd8bWej2', NULL, NULL, 0, '2025-12-04 00:49:57', NULL, '2025-12-04 00:49:37', '2025-12-04 00:49:57'),
(18, 'Folorunsho', 'sholatteh@gmail.com', '2025-12-04 01:24:01', '$2y$12$6qIsSYnThT.CiPpGeCn/Q.oJwvE6vPXm6gsQAFFp3yx0UXToq0N5C', NULL, NULL, 0, '2025-12-04 01:24:01', NULL, '2025-12-04 01:23:30', '2025-12-04 01:24:01'),
(19, 'Richard', 'toperichard23@gmail.com', '2025-12-04 01:31:07', '$2y$12$TkpTsx3qAyzrtu5YBOCMveUVGfzswsJF5ZEk1OiiDi6lTdLFyLjP6', NULL, NULL, 0, '2025-12-04 01:31:07', NULL, '2025-12-04 01:30:44', '2025-12-04 01:31:07'),
(20, 'Oluwayemisi Enilolobo', 'yemisiola4ril@yahoo.com', '2025-12-04 01:53:46', '$2y$12$/LRT634nJl2I9M/X4YWkYOSxQRaMNVoJMOBQ4FSNs1TFnDcKGn3Sy', NULL, NULL, 0, '2025-12-04 01:53:46', NULL, '2025-12-04 01:53:25', '2025-12-04 01:53:46'),
(21, 'Adebimpe Gbadegesin', 'adebimpegbadegesin@gmail.com', '2025-12-04 02:21:52', '$2y$12$lX79xrvZT.F.i.yA3b3Q3uTMcWE2h9LJTY03Lz2k5TfOkG8TEgVGG', NULL, NULL, 0, '2025-12-04 02:21:52', NULL, '2025-12-04 02:21:19', '2025-12-04 02:21:52'),
(22, 'Olajide firm', 'estherayoyimika2@gmail.com', '2025-12-04 02:34:02', '$2y$12$xTbQP.NCY08JOLe/apLly.Lw/.IzMTKSHzwJ2N9SX2XKI5BA..536', NULL, NULL, 0, '2025-12-04 02:34:02', NULL, '2025-12-04 02:33:39', '2025-12-04 02:34:02'),
(23, 'Caroline', 'amaocaroline7@gmail.com', '2025-12-04 02:38:09', '$2y$12$/LPP6h0BF3Z9738f0O0rxeK5YTOt.zURckAAPiZD0tHwtdPlBkBFm', NULL, NULL, 0, '2025-12-04 02:38:09', NULL, '2025-12-04 02:36:51', '2025-12-04 02:38:09'),
(24, 'Adesoji Adedoyin', 'adedoyin.adesoji@yahoo.com', NULL, '$2y$12$2RgtGV7JbJW41Cc2d4VvBOP3c2EZ4NMtFhMeD1Iqj2lc4.KAbduKG', '$2y$12$pZ/uLNIG9/tQR8dvfoKU7upuAe.JUKFYBUXhAlRPFB/oZFQwRxaOm', '2025-12-04 09:16:49', 0, NULL, NULL, '2025-12-04 09:06:49', '2025-12-04 09:06:49'),
(25, 'Henry Akingbesote', 'hakingbesote@gmail.com', NULL, '$2y$12$wmoAwyRqoWluVPy/1tzOr.lveoKeIRe3gnahLVbNJrwryXtbbinKi', '$2y$12$kl83xOQjfIaCBalQqw2CwealDjh5.QqT5pzzFCFEGGpvhAyjoyrey', '2025-12-04 11:32:45', 0, NULL, NULL, '2025-12-04 11:22:45', '2025-12-04 11:22:45'),
(26, 'Imoleayo', 'imoleayomide.adesanya@gmail.com', '2025-12-04 12:05:02', '$2y$12$FSdZQb/mOBqV9zpCl5vykezUSfBlzkMm7yjALnxvxajlB0IZ45Jkm', NULL, NULL, 0, '2025-12-04 12:05:02', NULL, '2025-12-04 12:04:27', '2025-12-04 12:05:02'),
(27, 'Merotohun Oluwagbotemi', 'oluwagbotemimerotohun@gmail.com', '2025-12-04 12:14:16', '$2y$12$B8ubfkHqzNEa7iUY3/p5FeshWXk1f8nHNNaUNHSFII2ULi5WijHaO', NULL, NULL, 0, '2025-12-04 12:14:16', NULL, '2025-12-04 12:13:48', '2025-12-04 12:14:16'),
(28, 'Timothy Adewale', 'timothyadewale2002@gmail.com', '2025-12-04 13:52:23', '$2y$12$oCRnGXabWQRo10.9NOcZ0elSNmRPxXSDh3WrAYZk4zW35ji/aJtTS', NULL, NULL, 0, '2025-12-04 13:52:23', NULL, '2025-12-04 13:51:47', '2025-12-04 13:52:23'),
(29, 'Abosede Akinsola', 'bosabby@yahoo.com', '2025-12-04 18:41:18', '$2y$12$C/QKz/EzMO6v9p0Qn.1JfOgQvF8z4qneAtY7AOxundd2nJWenMY.S', NULL, NULL, 0, '2025-12-04 18:41:18', NULL, '2025-12-04 18:40:59', '2025-12-04 18:41:18'),
(30, 'O.T Babafemi', 'o.t.babafemisolicitors@gmail.com', '2025-12-04 19:17:05', '$2y$12$fC0B8JPcaAh4Yxdn8cWMDOCVtrYzN/i2dh4QuYGG7JDZjr6RvAqja', NULL, NULL, 0, '2025-12-04 19:17:05', NULL, '2025-12-04 19:09:17', '2025-12-04 19:17:05'),
(31, 'Temitope Soderu', 'tlasunks@gmail.com', '2025-12-04 19:39:34', '$2y$12$Ozdx8oySRVCeQVueqYT24eFv29xqw5rhAbga9kX3fo3gnbZ3ydJau', NULL, NULL, 0, '2025-12-04 19:39:34', NULL, '2025-12-04 19:39:14', '2025-12-04 19:39:34'),
(32, 'Intelex Legal', 'saydola75@gmail.com', '2025-12-04 19:58:06', '$2y$12$bvQzLJXgjOs0uk3qNE3BGOfX7ijrhqiF/VIvqFtYYMHKHvHVR3t3u', NULL, NULL, 0, '2025-12-04 19:58:06', NULL, '2025-12-04 19:57:09', '2025-12-04 19:58:06'),
(33, 'Oladoyin Onanuga', 'oladoyinonanuga@yahoo.com', '2025-12-05 08:52:21', '$2y$12$UBxmnpbJs9/luDYyV82imeEDqi0TIIkoVJ9nDWK3KKivka1KGyfRa', NULL, NULL, 0, '2025-12-05 08:52:21', NULL, '2025-12-04 22:06:25', '2025-12-05 08:52:21'),
(34, 'BUSINESS', 'bluefieldattorneys@gmail.com', '2025-12-05 12:12:12', '$2y$12$cbAzpNJtjVbNkkaNSGCzzOUkqyNo2RZ4fTjHcn6kKow2lT.OI7ok.', NULL, NULL, 0, '2025-12-05 12:12:12', NULL, '2025-12-05 12:11:44', '2025-12-05 12:12:12'),
(35, 'O.Y Arogundade & co', 'whywalex2002@yahoo.com', '2025-12-05 17:33:51', '$2y$12$IMUulYSPP1jAN3Nu0FwKrOfekehfE8yrRyPYiw/mnvUfE0ZYUKDWy', NULL, NULL, 0, '2025-12-05 17:33:51', NULL, '2025-12-05 17:33:16', '2025-12-05 17:33:51'),
(36, 'AOA Jurist Consult', 'abodunrin.oluwatoyin@yahoo.com', NULL, '$2y$12$GwB/7NK8zW/ebTnV8f6KcOy4dRL2pAHWMK4MU4hKRZ8Mf13k2PL7u', '$2y$12$kD1WEQ9E3IS2z9vJndth0exWU3KIpFDbt73Q4KlnOBJxc1O644nMC', '2025-12-05 19:46:04', 0, NULL, NULL, '2025-12-05 19:36:04', '2025-12-05 19:36:04'),
(37, 'Ayoade Akande', 'ayoakande29@gmail.com', '2025-12-06 02:19:40', '$2y$12$aM3e2fQJuAnJVeYia4LG9elegqJtq/J2CwcVcxmq6rlTMUcRXNSzq', NULL, NULL, 0, '2025-12-06 02:19:40', NULL, '2025-12-06 02:18:49', '2025-12-06 02:19:40'),
(38, 'ibironkebolanle2@gmail.com', 'ibironkebolanle2@gmail.com', '2025-12-07 00:36:41', '$2y$12$E5Vei4FfpUh2jKd2Et501uvK.5dB2syJIW8l8hFGd0n1dUtqPhple', NULL, NULL, 0, '2025-12-07 00:36:41', NULL, '2025-12-07 00:36:20', '2025-12-07 00:36:41'),
(39, 'ibiloyeabisade337@gmail.com', 'ibiloyeabisade337@gmail.com', '2025-12-07 00:42:13', '$2y$12$OqQtQbQyo25ld8Wt6RdmrOv3yqmdiKbSXekalUjx9RiPP9wCBEyhS', NULL, NULL, 0, '2025-12-07 00:42:13', NULL, '2025-12-07 00:41:49', '2025-12-07 00:42:13'),
(40, 'jomilojufavour5@gmail.com', 'jomilojufavour5@gmail.com', '2025-12-07 00:42:24', '$2y$12$ACGs1osfRySkOuUjZkaBgOxDv1efa032QVPE8cds1A1H00jXhuium', NULL, NULL, 0, '2025-12-07 00:42:24', NULL, '2025-12-07 00:42:06', '2025-12-07 00:42:24'),
(41, 'ayanbukolaayandeji@gmail.com', 'ayanbukolaayandeji@gmail.com', NULL, '$2y$12$WZoDnAZ/5rYxONQ7.t.wYuWDC.BIFwdn1gkOjqNLv4V7mgajY/67q', '$2y$12$Pu.0JP7w1ZrSU8ug96slkuhKNlI651n1mYLdHGbhz97aXo//vCv/O', '2025-12-07 01:13:37', 0, NULL, NULL, '2025-12-07 01:03:36', '2025-12-07 01:03:37'),
(42, 'faridalabi7@gmail.com', 'faridalabi7@gmail.com', '2025-12-07 01:05:45', '$2y$12$tMhtROfwiyGZ2GJTBzGZu.ANyftanOxnEFKWL/c5aljrFx3RXjWFG', NULL, NULL, 0, '2025-12-07 01:05:45', NULL, '2025-12-07 01:05:06', '2025-12-07 01:05:45'),
(43, 'ayanbukolaayandeji0@gmail.com', 'ayanbukolaayandeji0@gmail.com', '2025-12-07 01:07:16', '$2y$12$/XUveXIjpgm/6nfUHqhihu7Z9TnaJ3M6YWvFyHh1oSyrq.4yZj/Mq', NULL, NULL, 0, '2025-12-07 01:07:16', NULL, '2025-12-07 01:06:59', '2025-12-07 01:07:16'),
(44, 'marvelogunleye8@gmail.com', 'marvelogunleye8@gmail.com', '2025-12-07 01:11:57', '$2y$12$BS5EoavwusmiSrTmqOiJoOI330tNNSH2v8kWJN11NSCkx/O9GwgYS', NULL, NULL, 0, '2025-12-07 01:11:57', NULL, '2025-12-07 01:11:33', '2025-12-07 01:11:57'),
(45, 'Busayo Idowu', 'idowubusayop@gmail.com', '2025-12-07 01:50:04', '$2y$12$.aOUQesO3Dzmv78KtUht7eB8PbdKVGZzVH7eaOLlAV8LZgkX0m66i', NULL, NULL, 0, '2025-12-07 01:50:04', NULL, '2025-12-07 01:49:17', '2025-12-07 01:50:04'),
(46, 'akinboladeomowumi24@gmail.com', 'akinboladeomowumi24@gmail.com', '2025-12-07 02:18:25', '$2y$12$dbGd7J/mI9p7pAhK2aM8AeWgCnh7KbdkZuNKELl9CnA7jXkEwL5da', NULL, NULL, 0, '2025-12-07 02:18:25', NULL, '2025-12-07 02:17:57', '2025-12-07 02:18:25'),
(47, 'Rhadiat Balogun', 'rhodeeyahadetola@gmail.com', '2025-12-07 15:17:29', '$2y$12$U.QNxm8A2sFO8yIxYBTKIeXIw8aHhL.fqC7fBlz2RJZItiHYw/Tv6', NULL, NULL, 0, '2025-12-07 15:17:29', NULL, '2025-12-07 15:16:42', '2025-12-07 15:17:29'),
(48, 'C. E. AFORGWU AND COMPANY', 'jojoley@yahoo.com', '2025-12-07 23:37:26', '$2y$12$VKtk.jDpHmr5nlaGLCjVi.lDHSKuNNtiQpI533.SNZKzDftVUnDY6', NULL, NULL, 0, '2025-12-07 23:37:26', NULL, '2025-12-07 23:34:34', '2025-12-07 23:37:26'),
(49, 'S. T. O. Amatonjie', 'samuelorupabo@gmail.com', '2025-12-08 00:55:25', '$2y$12$UyBnm/o0ZTN0B76DpzrtxOdRYuQlGRqrvT3jjemF8ji4430CuOfsS', NULL, NULL, 0, '2025-12-08 00:55:25', NULL, '2025-12-08 00:49:26', '2025-12-08 00:55:25'),
(50, 'Victor Samson', 'victorsammie13@gmail.com', '2025-12-08 12:12:10', '$2y$12$/3EgrZFuevR24pkduxJ4UeqSBzoxVjEQ5OaT.HkYqqf/M5fWlT8VC', NULL, NULL, 0, '2025-12-08 12:12:10', NULL, '2025-12-08 12:11:17', '2025-12-08 12:12:10'),
(51, 'Lodestar Partners', 'lodestarpartners@gmail.com', '2025-12-08 15:55:05', '$2y$12$nAR0eC/MW8oEfojDobm65OkxZ75mC3vlAh9GunBVaiL2JsU.uXiyK', NULL, NULL, 0, '2025-12-08 15:55:05', NULL, '2025-12-08 15:54:10', '2025-12-08 15:55:05'),
(52, 'olamilekan4196@gmail.com', 'olamilekan4196@gmail.com', '2025-12-08 16:06:06', '$2y$12$XFuQiZJus/AcqXUiZPKh9elSAS6Z.C9n7rLl8tCcvHhY2M0eUxgZu', NULL, NULL, 0, '2025-12-08 16:06:06', NULL, '2025-12-08 16:05:02', '2025-12-08 16:06:06'),
(53, 'Ebere Victor Obuzor & Co', 'eberevictorobuzor@gmail.com', '2025-12-09 01:33:53', '$2y$12$Zx2Grpv1tjm8.UvCNrpKCejchSN03gkAmfa9pkQf6trDZqroGWzJq', NULL, NULL, 0, '2025-12-09 01:33:53', NULL, '2025-12-09 01:32:50', '2025-12-09 01:33:53'),
(54, 'akindeletunmise2003@gmail.com', 'akindeletunmise2003@gmail.com', '2025-12-09 01:35:05', '$2y$12$BRc/WSZ3NRzcc.UbOI9MEuCmYSujvmgEIIh8pImS0QpH9agAWNAPq', NULL, NULL, 0, '2025-12-09 01:35:05', NULL, '2025-12-09 01:34:36', '2025-12-09 01:35:05'),
(55, 'Toluwani', 'tolufunkeakin@gmail.com', '2025-12-09 10:39:31', '$2y$12$ARJTg52s37zd3g/d.9bV9eAz2GKNRqyHGyhHSYu1TlFK2Mxg8LIdu', NULL, NULL, 0, '2025-12-09 10:39:31', NULL, '2025-12-09 10:38:50', '2025-12-09 10:39:31'),
(56, 'Dapo Ogunmilade', 'dapo@aetoslegal.com', '2025-12-09 14:51:44', '$2y$12$7eqp67a7xp5t56mrdan5w.JLDlZi0fuY7vaQ5gX6NcoIdcGGjN5XW', NULL, NULL, 0, '2025-12-09 14:51:44', NULL, '2025-12-09 14:48:23', '2025-12-09 14:51:44'),
(57, 'AOA Jurist Consult', 'babalolaoluwatoyin87@gmail.com', '2025-12-09 19:37:14', '$2y$12$dEXw/KWtVwGv7UN88J16hO.pSitbHEI/AT9G4mzmsJIcxlpASUy6C', NULL, NULL, 0, '2025-12-09 19:37:14', NULL, '2025-12-09 19:35:15', '2025-12-09 19:37:14'),
(58, 'Abimbola Adebanjo Fatunbi', 'yennybimbo@gmail.com', NULL, '$2y$12$xYECkHEMWiVYkwSc8tP5RecETGsCw8IR94swkAQ0/IbvTx/BgXWY2', '$2y$12$cxgqttzooxXADv.kVME4s.exVEX2.R7S3zbMdN6S7/DEdBYyHZy0u', '2025-12-09 20:09:22', 0, NULL, NULL, '2025-12-09 19:54:03', '2025-12-09 19:59:22'),
(59, 'AEC LEGAL LAW PRACTICE LP', 'segun@aeclegal.com', '2025-12-10 01:21:48', '$2y$12$BUzK7OA5nid9cSD5OtY20eEWpGhOrPcD2S3sg4lQO4S18sleUB.d2', NULL, NULL, 0, '2025-12-10 01:21:48', NULL, '2025-12-10 01:12:53', '2026-01-13 14:50:21'),
(60, 'Ayokunle Adetula', 'ayo_faith@yahoo.com', '2025-12-10 09:54:31', '$2y$12$c7qaXIKQ6y0UtBckBNv9wOaWNKo1HTqda4AuuDbPbkQcJ/XKnixaW', NULL, NULL, 0, '2025-12-10 09:54:31', NULL, '2025-12-10 09:53:43', '2025-12-10 09:54:31'),
(61, 'Solicitous Attorney', 'solicitousattorney@gmail.com', '2025-12-10 11:13:41', '$2y$12$PQny5XDLdVwNx3hPhANqnOkwnzqNEXssrcjKjc/6cMjO2ukgyqZ0C', NULL, NULL, 0, '2025-12-10 11:13:41', NULL, '2025-12-10 11:09:26', '2025-12-10 11:13:41'),
(62, 'John Osaro', 'ogbgaso40@gmail.com', '2025-12-10 18:03:42', '$2y$12$Hp7oxGp2pB3KWNvxtU3JWe0p6JdDu0Hhzf2r5xRaiJm9LstRRkxcG', NULL, NULL, 0, '2025-12-10 18:03:42', NULL, '2025-12-10 18:02:28', '2025-12-10 18:03:42'),
(63, 'The Cedar Associates', 'olatundeojeladun@gmail.com', '2025-12-10 23:45:22', '$2y$12$VZ0ri8YDofzOcjGVc2KkIesJ0mSHdvW5r0AHrB1M5vEaCKSGZahG2', NULL, NULL, 0, '2025-12-10 23:45:22', NULL, '2025-12-10 23:45:00', '2025-12-10 23:45:22'),
(64, 'Ishaya peace', 'ishayapeace47@gmail.com', '2025-12-11 02:04:40', '$2y$12$EvFZBOBjQ5bRBQua9MEyyu/yRRKHfcGjvae/tRqbez2BPaoZnB1bK', NULL, NULL, 0, '2025-12-11 02:04:40', NULL, '2025-12-11 02:03:09', '2025-12-11 02:04:40'),
(65, 'Stella Fiade', 'megaliousr1ingp@gmail.com', NULL, '$2y$12$Dbhu1wcKHIKiaZx2O8URHeY420NmCy79l5FNikZHTPmrNMxhaBZ1m', '$2y$12$1s2ueevgqUZADGPtLO1GjOBA8sZwfGq0vUeNeoW3WOqybf1nz6B.G', '2025-12-11 04:26:56', 0, NULL, NULL, '2025-12-11 04:16:55', '2025-12-11 04:16:56'),
(66, 'Oreoluwa Oduniyi', 'ore670@yahoo.com', '2025-12-11 21:41:32', '$2y$12$TpSFZYBuUwYUxg.3s77Py.xBa8EScP73MXISzM3BlaAAA8cj36HNW', NULL, NULL, 0, '2025-12-11 21:41:32', NULL, '2025-12-11 21:40:43', '2025-12-11 21:41:32'),
(67, 'Oshama', 'oshama2014@gmail.com', '2025-12-12 01:56:55', '$2y$12$kXmDPosbXOf70pGTLmUaeurZesi7/yf1Pm5HOS5AIT/oHzdROo7oK', NULL, NULL, 0, '2025-12-12 01:56:55', NULL, '2025-12-12 01:46:09', '2025-12-12 01:56:55'),
(68, 'Mercy Amole-Ajimoti', 'ajimoti.mercy@gmail.com', '2025-12-12 08:37:36', '$2y$12$4vIQMKsVPVAYhKKT30sU3uO8pDKRIq/QETn8ZnaLcmUis0UGxIy0m', NULL, NULL, 0, '2025-12-12 08:37:36', NULL, '2025-12-12 08:37:07', '2025-12-12 08:37:36'),
(69, 'Mohammed Bello', 'bellomohammed601@gmail.com', '2025-12-12 12:17:56', '$2y$12$rSTVGMDOT9qU/PZesAOKnOmzgRhtDRgZdoF4aYE6ZOy9jOgHFMhZq', NULL, NULL, 0, '2025-12-12 12:17:56', NULL, '2025-12-12 12:17:06', '2025-12-12 12:17:56'),
(70, 'kollydlaw', 'kollydlaw2018@gmail.com', '2025-12-12 18:55:50', '$2y$12$0R.fsSV/eHbFhTJL94kG/uYL2LDyLRtn5cEpR1O91kCMFwRFs6opG', NULL, NULL, 0, '2025-12-12 18:55:50', NULL, '2025-12-12 18:55:21', '2025-12-12 18:55:50'),
(71, 'Ola Oluwadeyi', 'sunkanmi.laplace@gmail.com', '2025-12-13 17:15:38', '$2y$12$NYL89LRU34.iIhvs2RiQ3OtlMghX0cNnUVR1E2L6cvxSQ.xjGn6Kq', NULL, NULL, 0, '2025-12-13 17:15:38', NULL, '2025-12-13 17:15:10', '2025-12-13 17:15:38'),
(72, 'Ayokunle Emmanuel', 'ayokunlebolu2@gmail.com', '2025-12-14 01:14:01', '$2y$12$/WM8coMhbp2cuyrDbKuA2.WNoZZg7UPrteykLjbJLjOCOaDrQhL5G', NULL, NULL, 0, '2025-12-14 01:14:01', NULL, '2025-12-14 01:01:33', '2025-12-14 01:14:01'),
(73, 'Immanuella', 'adeyemoimmanuella@gmail.com', '2025-12-14 21:41:46', '$2y$12$OMP0cuG9eyNUosDIDOfbiOVcwncL44BxWAe4ixrIrV.CkNynMcM0u', NULL, NULL, 0, '2025-12-14 21:41:46', NULL, '2025-12-14 21:41:10', '2025-12-14 21:41:46'),
(74, 'A.E ADEYEMI', 'yemisucks@gmail.com', '2025-12-14 21:56:56', '$2y$12$FON76kOz.kkn5ZpuwtRUvecvYn75MVVb3LzNcCgshAtS2iuDM/rxS', NULL, NULL, 0, '2025-12-14 21:56:56', NULL, '2025-12-14 21:55:54', '2025-12-14 21:56:56'),
(75, 'Emmanuel Oluyemi', 'emmanuelayomiposi101@gmail.com', '2025-12-14 22:20:20', '$2y$12$sLGGqZVtfZnQFcjgYKTxrO2uepZpIAsWOak7/5CC2jH8O9/OS/ItG', NULL, NULL, 0, '2025-12-14 22:20:20', NULL, '2025-12-14 22:19:49', '2025-12-14 22:20:20'),
(76, 'Favour Atoyebi', 'favoratoyebi@gmail.com', '2025-12-14 22:30:24', '$2y$12$KOSqZOOG1wggRMdGsGIlwuQcj7dtdEdpz2uyIHtMkBAe8igJzkSQa', NULL, NULL, 0, '2025-12-14 22:30:24', NULL, '2025-12-14 22:28:17', '2025-12-14 22:30:24'),
(77, 'Japheth Akin - Awoniran', 'japhetakinawoniran1@gmail.com', '2025-12-14 23:06:26', '$2y$12$qlu1Gx8xNWcFzKqaXHV/TeY0yIvZS6STgErIDH7sFYkTJEkkb08Cm', NULL, NULL, 0, '2025-12-14 23:06:26', NULL, '2025-12-14 23:05:50', '2025-12-14 23:06:26'),
(78, 'Adebiyi Caleb', 'calebadebiyi27@gmail.com', '2025-12-14 23:17:20', '$2y$12$k8ED80iiS2MvkpX6nlv2aO/yjGjhpyNNJmqQjFt7.FzdmHe7DvFpq', NULL, NULL, 0, '2025-12-14 23:17:20', NULL, '2025-12-14 23:16:55', '2025-12-14 23:17:20'),
(79, 'Adeogun Blessing Olanike', 'adeogunblessing6@gmail.com', '2025-12-15 00:49:40', '$2y$12$h/gDQTi4l1z3MbqdhgNXdOoVHD9TZ/pmfb559uP7Rq8SC1fHm9QVq', NULL, NULL, 0, '2025-12-15 00:49:40', NULL, '2025-12-15 00:49:09', '2025-12-15 00:49:40'),
(80, 'Peace Amarachi Ogbu', 'peacelisa123@gmail.com', '2025-12-15 13:51:34', '$2y$12$67prOMEhGgL1.8llMO1UcO7tfThpX9g/N0hYOwiCUF5d6Fv3boutu', NULL, NULL, 0, '2025-12-15 13:51:34', NULL, '2025-12-15 13:50:53', '2025-12-15 13:51:34'),
(81, 'Akinribide Oluwagbohunmi Esther', 'gbohunmiakinribide@gmail.com', '2025-12-15 16:40:44', '$2y$12$fxm1bw3fvMhgOpcC5ZdTIOet1YzDL9YEui0yq9fEixQWM32ewNnE2', NULL, NULL, 0, '2025-12-15 16:40:44', NULL, '2025-12-15 16:39:31', '2025-12-15 16:40:44'),
(82, 'rezeugwuifeoma4real@gmail.com', 'rezeugwuifeoma4real@gmail.com', '2025-12-15 18:41:59', '$2y$12$tCiUghP3NkdoaSYu6ukEJuz1sJe7cW.sv/5oE74K7PJnIlnS41lD.', NULL, NULL, 0, '2025-12-15 18:41:59', NULL, '2025-12-15 18:41:28', '2025-12-15 18:41:59'),
(83, 'Tah Randy Jangha', 'tahrandy31@gmail.com', NULL, '$2y$12$.AGX4iDIWUUOC2c0sOMqTuXOMp0loKhLuRpkCxDiJlE8.cLdFOrhq', '$2y$12$zuASGh/6rK9.hVEsSUqoJ.ynEim6redzFvhCj6SwsPnHiAWCA3N4y', '2025-12-15 19:59:50', 0, NULL, NULL, '2025-12-15 19:49:49', '2025-12-15 19:49:50'),
(84, 'ADELUSI FAVOUR OLUWAFIFUNMI', 'favouradelusi17@gmail.com', '2025-12-15 19:57:09', '$2y$12$VKhFDTNS8NGnr1jlXh2GSeoLFsiRDLjGflVa5bTezY.nb2eZ657aq', NULL, NULL, 0, '2025-12-15 19:57:09', NULL, '2025-12-15 19:56:22', '2025-12-15 19:57:09'),
(85, 'Oluwabusola O. Oluwaniyi', 'busolaotunaiya@gmail.com', '2025-12-15 20:04:04', '$2y$12$CxF4CnhwKdghhhAucV8AeO90EMqS5qs13SKmgL/FtW31.JXPsoS3S', NULL, NULL, 0, '2025-12-15 20:04:04', NULL, '2025-12-15 20:03:44', '2025-12-15 20:04:04'),
(86, 'Adeyemi Oluwaseun', 'sheunne141@gmail.com', '2025-12-15 21:04:26', '$2y$12$.1dABCLD56pN4qjWg.e0TOervKa3IWrnJb7N4NU9FdQHZ3Aos/Nay', NULL, NULL, 0, '2025-12-15 21:04:26', NULL, '2025-12-15 21:03:54', '2025-12-15 21:04:26'),
(87, 'Moyinoluwa', 'ilemobayomoyinoluwa2005@gmail.com', '2025-12-16 00:30:20', '$2y$12$patG2ug5Lu/7HLR.dSVAw.Cl4fMDgqTuWwmAjklWODWCx2P3SbAjK', NULL, NULL, 0, '2025-12-16 00:30:20', NULL, '2025-12-16 00:29:48', '2025-12-16 00:30:20'),
(88, 'Ikotun Michael', 'ikotunmichael591@gmail.com', '2025-12-16 00:30:23', '$2y$12$shvjLX8SKrXY9XgWrQyPROjhH1tex0a9B43FES59sgCNeXrra/DGi', NULL, NULL, 0, '2025-12-16 00:30:23', NULL, '2025-12-16 00:29:58', '2025-12-16 00:30:23'),
(89, 'testimonyolajide09@gmail.com', 'testimonyolajide09@gmail.com', '2025-12-16 00:34:01', '$2y$12$ZK.wJgnskUTFTd6IZb9X8eChQotcjPfbVkDxZjf1HIwDH0QeiDYRu', NULL, NULL, 0, '2025-12-16 00:34:01', NULL, '2025-12-16 00:32:22', '2025-12-16 00:34:01'),
(90, 'Dada Mary Adesola', 'maryadeshola10@gmail.com', '2025-12-16 00:38:09', '$2y$12$xYYu.Dirmx1JXTDv2ynveOxxH.15T4uoEsquUAqHW7IviCDXcQ0hm', NULL, NULL, 0, '2025-12-16 00:38:09', NULL, '2025-12-16 00:33:45', '2025-12-16 00:38:09'),
(91, 'Richard', 'akinniyirichard2022@gmail.com', '2025-12-16 00:34:29', '$2y$12$4AfUCw1pD.v19nM9hN02c.RRSL75eGe216zG3c3f1ZwSIk4tCuFwi', NULL, NULL, 0, '2025-12-16 00:34:29', NULL, '2025-12-16 00:34:04', '2025-12-16 00:34:29'),
(92, 'ikotunzion1907@gmail.com', 'ikotunzion1907@gmail.com', '2025-12-16 00:42:46', '$2y$12$BAhLywcjYbyrDy4u4PjnWuPecm7wahm1o8zRcwp/hQV2L06HIJPQe', NULL, NULL, 0, '2025-12-16 00:42:46', NULL, '2025-12-16 00:42:03', '2025-12-16 00:42:46'),
(93, 'Ahmed Gift zaniab', 'preciouslizzy643@gmail.com', '2025-12-16 00:43:48', '$2y$12$lxkbFen0AbJ4l9q5WBf5TOwSIL/gzQXgnhetm.24t6pijZ4Hl3vKe', NULL, NULL, 0, '2025-12-16 00:43:48', NULL, '2025-12-16 00:42:54', '2025-12-16 00:43:48'),
(94, 'Moyinoluwa', 'ihppiness152@gmail.com', NULL, '$2y$12$o5QyjxfEQ5vXwChMuRHuLemFyb0RwHyll7CRn3KWVhdtvlJCnU5Q.', '$2y$12$A.WbB09TPCBtAfoY/T5K..bCnjJ6MFW5lYoeyJBh1KigINTEuvnIG', '2025-12-16 00:55:40', 0, NULL, NULL, '2025-12-16 00:45:40', '2025-12-16 00:45:40'),
(95, 'ifeoluwap931@gmail.com', 'ifeoluwap931@gmail.com', '2025-12-16 00:49:05', '$2y$12$5XDF605h/veru7HloRyq0uBRcahGTJ3w12gfuz5Sc/bNYkBRwC2De', NULL, NULL, 0, '2025-12-16 00:49:05', NULL, '2025-12-16 00:48:27', '2025-12-16 00:49:05'),
(96, 'okelolaoluwatitofunmi@gmail.com', 'okelolaoluwatitofunmi@gmail.com', NULL, '$2y$12$eEPwNJp9QJrJzrOQoyRtx.i7GBL8JXrd8tbZZeK7BiOW8sbg20u5y', '$2y$12$CIixDtzMn9ty6uaQl0lDK.Lw5ua/YWW.qv22r1nyJGzCnrqx1bsPC', '2025-12-16 01:01:55', 3, NULL, NULL, '2025-12-16 00:51:37', '2025-12-16 00:52:57'),
(97, 'Olakunle', 'olakunlejosh10@gmail.com', '2025-12-16 00:54:52', '$2y$12$FR18LN.C4Vk0N3vkbXdqp.hYT2LodDXRV3V8XLd/0hlUZug/syBiC', NULL, NULL, 0, '2025-12-16 00:54:52', NULL, '2025-12-16 00:52:10', '2025-12-16 00:54:52'),
(98, 'Ayomide', 'ayomidedocras@gmail.com', '2025-12-16 00:54:06', '$2y$12$W5tKbCYl2vs25zgqMxuBn.3uI49n..ZbBIQHuU9Lx9RWvcvQbWmNe', NULL, NULL, 0, '2025-12-16 00:54:06', NULL, '2025-12-16 00:52:55', '2025-12-16 00:54:06'),
(99, 'Jegede Deborah', 'jegededebby71@gmail.com', '2025-12-16 01:00:45', '$2y$12$UxIwIzyTYiV1xI5T0KCtEuxwgBLhJuTUhnNXZPHyW0./spjjWRgRC', NULL, NULL, 0, '2025-12-16 01:00:45', NULL, '2025-12-16 01:00:10', '2025-12-16 01:00:45'),
(100, 'Favour', 'favourashaolu22@gmail.com', '2025-12-16 01:01:15', '$2y$12$38bibgmc/gmhaA7T7jWtauco.VYgfUB.FY/WMrC1x8OKj6rKS1gSK', NULL, NULL, 0, '2025-12-16 01:01:15', NULL, '2025-12-16 01:00:40', '2025-12-16 01:01:15'),
(101, 'michaelolawale640@gmail.com', 'michaelolawale640@gmail.com', '2025-12-16 01:22:49', '$2y$12$t1Lld2CZ9uMVTodLKVrU6eV7A7VnMAJ/sdlZm0laOjQMMNpixL8lO', NULL, NULL, 0, '2025-12-16 01:22:49', NULL, '2025-12-16 01:21:39', '2025-12-16 01:22:49'),
(102, 'Oreoluwa', 'sgttomiwa@gmail.com', NULL, '$2y$12$U/F/U/dSxz6Ddf9bYBA9Puno72LvLC1dYdqp9vdXEL9KBM/HpkdjG', '$2y$12$trPMz5xF9dgZ2geeXMec3OQfGNebM9dqN31wyUR0w3VB2JREVNuXO', '2025-12-16 02:16:45', 0, NULL, NULL, '2025-12-16 02:06:28', '2025-12-16 02:06:45'),
(103, 'Obidare boluwatife', 'obidareboluwatifeeniola@gmail.com', '2025-12-16 02:07:53', '$2y$12$.g0goeUS7Hd8B8CDWkrIJ./Poj9JxfBrLqiqp/q4sh2Fpk02rEuv2', NULL, NULL, 0, '2025-12-16 02:07:53', NULL, '2025-12-16 02:07:32', '2025-12-16 02:07:53'),
(104, 'Favour', 'favourbenjamin92@gmail.com', '2025-12-16 02:14:30', '$2y$12$UVZfLijdd5a9gN0gig3fluW8iOpOuRW.YxtuSls9./MjF4KOtX2se', NULL, NULL, 0, '2025-12-16 02:14:30', NULL, '2025-12-16 02:13:28', '2025-12-16 02:14:30'),
(105, 'Law student', 'estherajayi204@gmail.com', '2025-12-16 06:47:52', '$2y$12$D.OHdbTHaZoAf4pyLIrdBudRwCc.HE0S5t/yGdo8G24ZD0ccLR98m', NULL, NULL, 0, '2025-12-16 06:47:52', NULL, '2025-12-16 06:24:01', '2025-12-16 06:47:52'),
(106, 'dideprecious@gmail.com', 'dideprecious@gmail.com', '2025-12-16 12:10:34', '$2y$12$PwU0Q6zeDA/JQaWOI0coXebmfV9POownk9.FIGdqBAngu5CHsmm3G', NULL, NULL, 0, '2025-12-16 12:10:34', NULL, '2025-12-16 12:10:06', '2025-12-16 12:10:34'),
(107, 'akinleyetomisin89@gmail.com', 'akinleyetomisin89@gmail.com', '2025-12-16 12:30:10', '$2y$12$NARxmUjMV3cXcX427sNwu.URA0.dkqalWHqvih.eNajV9d/HNsD2i', NULL, NULL, 0, '2025-12-16 12:30:10', NULL, '2025-12-16 12:29:43', '2025-12-16 12:30:10'),
(108, 'mercyoyindamola613@gmail.com', 'mercyoyindamola613@gmail.com', NULL, '$2y$12$03La5XJGlcrjfoJvPfgl7ev7MOq7v1mTJm5FsbvTyWTpizZFurKWq', '$2y$12$ExgGkUCFVpuiGyHZGbZz/OR386IeJBJGg.2ieEcNpfFwJRBx.040S', '2025-12-16 12:43:53', 0, NULL, NULL, '2025-12-16 12:33:53', '2025-12-16 12:33:53'),
(109, 'baruwafawaz5@gmail.com', 'baruwafawaz5@gmail.com', NULL, '$2y$12$i7gMsQc6ffHR81zFwkza7.an6lAzsEG/KlWavxquGm70lEEp0Cw0u', '$2y$12$u4CNSHRIlBXeYkVZl9BplOc6qsaSy/7QA6RiGUT6.R1h8A7ywnu9W', '2025-12-16 12:46:50', 2, NULL, NULL, '2025-12-16 12:34:22', '2025-12-16 12:37:16'),
(110, 'fayemigrace4real@gmail.com', 'fayemigrace4real@gmail.com', NULL, '$2y$12$KD74Q.869B.g5DpSKSwzIe7u0TU0BgSNfVibvMOxc9HLhGztmq0tC', '$2y$12$PIJ7qSdH4wFqChiLVJgPRumN9aPIGmfVfj0eTM8hENPkesjN3xAw.', '2025-12-16 12:44:58', 0, NULL, NULL, '2025-12-16 12:34:57', '2025-12-16 12:34:58'),
(111, 'praisezionlight@gmail.com', 'praisezionlight@gmail.com', '2025-12-16 12:41:52', '$2y$12$u2CyS.325lLC2OSqoH.GF.QlNPYtD5HyroONXA810b08ruzJtBHZK', NULL, NULL, 0, '2025-12-16 12:41:52', NULL, '2025-12-16 12:41:11', '2025-12-16 12:41:52'),
(112, 'aliyahadewale9@gmail.com', 'aliyahadewale9@gmail.com', '2025-12-16 12:42:02', '$2y$12$jeurnlKSUYHKud09cuZgKeKcV84.LKc8IjTCFRQFc8BbVENgOCW3S', NULL, NULL, 0, '2025-12-16 12:42:02', NULL, '2025-12-16 12:41:25', '2025-12-16 12:42:02'),
(113, 'Muwaliu Sofiyat Asake', 'muwaliusofiyata@gmail.com', '2025-12-16 12:52:40', '$2y$12$ZQLMXCDFiC3FcNFZO.BV8.fitVnXNWohw/DL.yIhw3CYrWToLFRE2', NULL, NULL, 0, '2025-12-16 12:52:40', NULL, '2025-12-16 12:52:12', '2025-12-16 12:52:40'),
(114, 'akerequeen2020@gmail.com', 'akerequeen2020@gmail.com', '2025-12-16 12:58:40', '$2y$12$emDTqW4IM/QZ06Rrpx2toOMVnWPOsnHGU/vQquMDMkC8rbZe19F1y', NULL, NULL, 0, '2025-12-16 12:58:40', NULL, '2025-12-16 12:56:13', '2025-12-16 12:58:40'),
(115, 'ajagbemotunrayo042@gmail.com', 'ajagbemotunrayo042@gmail.com', '2025-12-16 13:01:19', '$2y$12$fC2G7J6L3Mh4DpuoJ1jLt.eyKEqeJCbby4WLgBqtfqutuR3uLgO7W', NULL, NULL, 0, '2025-12-16 13:01:19', NULL, '2025-12-16 12:59:39', '2025-12-16 13:01:19'),
(116, 'omotolaogunola@gmail.com', 'omotolaogunola@gmail.com', '2025-12-16 13:12:12', '$2y$12$Q4mCWVXpqIabMh.eJbFG0upDs1h7gEW3X5H3Sr.yt2yIorWHM9XPy', NULL, NULL, 0, '2025-12-16 13:12:12', NULL, '2025-12-16 13:11:29', '2025-12-16 13:12:12'),
(117, 'haywhy.com01@gmail.com', 'haywhy.com01@gmail.com', '2025-12-16 13:28:29', '$2y$12$iO.i1B9r7h9jr3hjOfNmDuXOI78RnKCSqPQddyPFJ8krgNjq8vDTa', NULL, NULL, 0, '2025-12-16 13:28:29', NULL, '2025-12-16 13:28:00', '2025-12-16 13:28:29'),
(118, 'Adebayo', 'akejuquayumadebayo@gmail.com', '2025-12-16 14:19:49', '$2y$12$ZLse9loiXvzC30z0atYmg.CsrEgTR6pGgX8WXquMphytoNM3aPCbW', NULL, NULL, 0, '2025-12-16 14:19:49', NULL, '2025-12-16 14:18:12', '2025-12-16 14:19:49'),
(119, 'Iremide', 'iremidedawoodakerele@gmail.com', NULL, '$2y$12$xtEss8EEyBqLRo2HENTVTug/Ye6comBbw9K3OjqGr3j9I83fI8FgK', '$2y$12$d37ECRKjAoewoOxGrpXpqeIrN/F1oCGFe7IUOYf5.KYZ8vDwTYswG', '2025-12-16 14:33:45', 0, NULL, NULL, '2025-12-16 14:21:50', '2025-12-16 14:23:45'),
(120, 'olanrewajuolanite5@gmail.com', 'olanrewajuolanite5@gmail.com', '2025-12-16 14:23:21', '$2y$12$esF0XxUReiT6pFoQ9xtn..6KG8hvlugj7LMz7CYv8nYHSdlOQKlXi', NULL, NULL, 0, '2025-12-16 14:23:21', NULL, '2025-12-16 14:23:01', '2025-12-16 14:23:21'),
(121, 'Obehioya Adodo', 'graceadodoobehi21@gmail.com', '2025-12-16 14:31:27', '$2y$12$ETwbmCstgTVI5IPvhcC0t.xX7THRzHKjx1jQeaS8K6wLscE6SxMh2', NULL, NULL, 0, '2025-12-16 14:31:27', NULL, '2025-12-16 14:29:23', '2025-12-16 14:31:27'),
(122, 'Oladimeji', 'ayodejiibrahimoladimeji@gmail.com', '2025-12-16 14:44:11', '$2y$12$bsukzAcbPijTgQ5LdUMeXOOuRrFUsToH73/xAn0q6tWOysRTO08TO', NULL, NULL, 0, '2025-12-16 14:44:11', NULL, '2025-12-16 14:41:15', '2025-12-16 14:44:11'),
(123, 'Ibzama WAC', 'ibzamawac@gmail.com', '2025-12-16 15:04:53', '$2y$12$hvEgpw0GpPazIdv7808CauoBCHHGC4AJJ9462apCioFjAq4yiLWv2', NULL, NULL, 0, '2025-12-16 15:04:53', NULL, '2025-12-16 14:57:32', '2025-12-16 15:04:53'),
(124, 'A.I.Adegboye', 'adegboyeismail149@gmail.com', '2025-12-16 15:13:49', '$2y$12$xCFgU54huapxifmO3jb6JO9AUuFWVnwotJ45VBlLbWAWNYbl/UUdW', NULL, NULL, 0, '2025-12-16 15:13:49', NULL, '2025-12-16 15:13:13', '2025-12-16 15:13:49'),
(125, 'agbeyangioluwafikunayomi@gmail.com', 'agbeyangioluwafikunayomi@gmail.com', '2025-12-16 15:21:27', '$2y$12$hdb6bE2hDHUDqJs6LGqLSuau2U3damPp3e7UB3nkRUZNeTVtwCWIa', NULL, NULL, 0, '2025-12-16 15:21:27', NULL, '2025-12-16 15:20:39', '2025-12-16 15:21:27'),
(126, 'Abdul-Wasii Abdullah Olawale', 'abdullahabdulwasii03@gmail.com', '2025-12-16 15:30:44', '$2y$12$wH45/M6m9Q3BWlFOixiE.e8d/FGjrfJh.8bXlLYdLTahWaH6AsrzO', NULL, NULL, 0, '2025-12-16 15:30:44', NULL, '2025-12-16 15:30:08', '2025-12-16 15:30:44'),
(127, 'Victoria Onwukwe', 'victoriaonwukwe34@gmail.com', '2025-12-16 16:25:57', '$2y$12$yWSl80gq7uvg9bGpmhnDd.nhU/mIU/aLjSLMrYn2Xb3n8UEbPg/ym', NULL, NULL, 0, '2025-12-16 16:25:57', NULL, '2025-12-16 16:25:21', '2025-12-16 16:25:57'),
(128, 'abiola260@gmail.com', 'abiola260@gmail.com', NULL, '$2y$12$Dv6vh.bkNLAaOS4BUJqGIeLLt7XMcwdNZB5yWfSwSAWP/3Vlpk4qu', '$2y$12$xfTV76IMe84eAVrquqeavejPB7o.3RxH...Z8e4LLfluGvQvqxwWa', '2025-12-16 17:30:38', 0, NULL, NULL, '2025-12-16 17:19:23', '2025-12-16 17:20:38'),
(129, 'praiseabiola260@gmail.com', 'praiseabiola260@gmail.com', NULL, '$2y$12$YFRVTnCDlFV5X/t1WbKlFuRrLIqlor2iLbRwgXVdoRTddghnGKp0K', '$2y$12$pfoG/XMYVQEfTRFkel8h6u4XUkpxlWml8zKB/VglumDbQaj7DrDpK', '2025-12-16 17:34:08', 0, NULL, NULL, '2025-12-16 17:24:07', '2025-12-16 17:24:08'),
(130, 'Gloria', 'akinpelugloria714@gmail.com', '2025-12-16 17:41:40', '$2y$12$dk9YDAfG4DlYo9FACDWk3eJMyIWPA9YT2tpJzrTFe5ctH5qYeyjaO', NULL, NULL, 0, '2025-12-16 17:41:40', NULL, '2025-12-16 17:40:38', '2025-12-16 17:41:40'),
(131, 'Ayeni Damilola Laughter', 'damlaughter@gmail.com', '2025-12-16 20:49:37', '$2y$12$Dk9/M4QAA3.PsDdr7D0C5.PGK2gYWMwAcOrG5/Jx5UvSSHz1lbqJG', NULL, NULL, 0, '2025-12-16 20:49:37', NULL, '2025-12-16 20:49:01', '2025-12-16 20:49:37'),
(132, 'Amasa', 'amasasuccess32@gmail.com', '2025-12-16 21:52:48', '$2y$12$DMcOArr9W5SoBIPPzvqNnuSwK0908yF/UTitBBPHwn.tGfpZHmKKK', NULL, NULL, 0, '2025-12-16 21:52:48', NULL, '2025-12-16 21:37:15', '2025-12-16 21:52:48'),
(133, 'Gabriel', 'gabrieloluwatobiloba14@gmail.com', '2025-12-16 22:24:28', '$2y$12$/oRDDZi64BqWluFjlBQcKuBI9uwla51wDi0eojjNyEmqycEIkmO5O', NULL, NULL, 0, '2025-12-16 22:24:28', NULL, '2025-12-16 22:24:04', '2025-12-16 22:24:28'),
(134, 'Hephzyy', 'hephzibah904@gmail.com', '2025-12-16 22:32:34', '$2y$12$ZhAR2ThrFABH0tOvoz.oJO6MwPceS1VEy57FtDH6HpCRtbRtmQ9Gy', NULL, NULL, 0, '2025-12-16 22:32:34', NULL, '2025-12-16 22:27:49', '2025-12-16 22:32:34'),
(135, 'Faniran marvellous Boluwatife', 'faniranmarvellousboluwatife@gmail.com', '2025-12-17 01:56:21', '$2y$12$/.UbG9o/PvoYen8Je8I8dOdfQmT8/8lj3K6XO1A/0vi5649yJFbui', NULL, NULL, 0, '2025-12-17 01:56:21', NULL, '2025-12-16 22:29:40', '2025-12-17 01:56:21'),
(136, 'Michelle Olajide', 'olajidemichelle13@gmail.com', '2025-12-16 22:43:13', '$2y$12$zgZBQ3I./PQedKviSYL5m.bhQgPEVr4soxWpKxKjqdPZw2COAIn2C', NULL, NULL, 0, '2025-12-16 22:43:13', NULL, '2025-12-16 22:42:50', '2025-12-16 22:43:13'),
(137, 'Uniosun integrity law chamber', 'veronicaaraoye13@gmail.com', NULL, '$2y$12$coru48vaxksis3W7B1juk.EoSVEOYmm47MBKwIyVpTA9c3iyX8GfS', '$2y$12$dmAwMHOLZPz7V8Itvz2H5OmJ/hDP959.lxie3086ne3iL6Nk9lKQq', '2025-12-16 23:08:36', 0, NULL, NULL, '2025-12-16 22:58:36', '2025-12-16 22:58:36'),
(138, 'Similoluwa', 'azeezdeborah12@gmail.com', '2025-12-16 23:02:09', '$2y$12$G6D3c2D4/9ewXu/b2t0D6eGv0vCHE.BpcZcSYW45nXB7WCn/05D6K', NULL, NULL, 0, '2025-12-16 23:02:09', NULL, '2025-12-16 23:01:36', '2025-12-16 23:02:09'),
(139, 'Omole Ayomikun', 'ayomikungabriel0@gmail.com', '2025-12-16 23:06:23', '$2y$12$rEDTuOFqun1KMmhENf.M6e5dc6ZXsB8bj6T1WE2G09A5x9/1MV0jm', NULL, NULL, 0, '2025-12-16 23:06:23', NULL, '2025-12-16 23:05:15', '2025-12-16 23:06:23'),
(140, 'Amosu Ayomide mercy', 'ayomideamosu36@gmail.com', '2025-12-16 23:27:04', '$2y$12$TBlOAUdwLm7dxCZR7vrVIu3nDsE9ld.D8tYApba1flbd4/ulFbeuu', NULL, NULL, 0, '2025-12-16 23:27:04', NULL, '2025-12-16 23:24:07', '2025-12-16 23:27:04'),
(141, 'Vickee', 'temilolaaloko@gmail.com', '2025-12-16 23:33:31', '$2y$12$lIDKoJekmSVehVwUgfl94u7rsnbvMqXNRslRw9/RvdUlCJ6TGNFNW', NULL, NULL, 0, '2025-12-16 23:33:31', NULL, '2025-12-16 23:32:53', '2025-12-16 23:33:31'),
(142, 'TheDawnOfChris', 'chrisnonso2007@gmail.com', '2025-12-16 23:34:31', '$2y$12$V4sNFTfNOv.8npwnjR64u.09JFOcn2tYSQNYvWcY8YmwTyxK3kZ2m', NULL, NULL, 0, '2025-12-16 23:34:31', NULL, '2025-12-16 23:33:44', '2025-12-16 23:34:31'),
(143, 'Adewumi Adeola Temitope', 'adeolaadewumitope@gmail.com', NULL, '$2y$12$CSrEyPi8goZ0ZBqjgzEeMeMQ2WqOs2xXG93mZtfeMjfGcc4P2.03i', '$2y$12$BJJVTmGqJfvSDn8Cd4DYh.cVVbVYJqxBBS64EX3UTlDUeWF4judnK', '2025-12-16 23:47:06', 0, NULL, NULL, '2025-12-16 23:37:06', '2025-12-16 23:37:06'),
(144, 'Fasiku Peter', 'peterfasiku1@gmail.com', '2025-12-17 01:05:39', '$2y$12$4X7mfHgaZ0oSSgXr0d/SjOx68Y8mCcASAH86Jr3hLkoa0TtTyW2UO', NULL, NULL, 0, '2025-12-17 01:05:39', NULL, '2025-12-17 01:02:05', '2025-12-17 01:05:39'),
(145, 'Abdulkareem Nurot', 'nurotashabi012@gmail.com', '2025-12-17 01:19:38', '$2y$12$gMhyJV20Ip2KgZbFyxRLe.68DcKIcLDsr6lUGLFmZ.tVnA6q8pK5y', NULL, NULL, 0, '2025-12-17 01:19:38', NULL, '2025-12-17 01:18:46', '2025-12-17 01:19:38'),
(146, 'Adebayo Oluwaferanmi esq', 'bayokrus@gmail.com', '2025-12-17 02:03:09', '$2y$12$B17zmOIL/XtYJpMCMAd00uB5gDoEi9OkXbQq7FZ5Qy33MK10hlmXi', NULL, NULL, 0, '2025-12-17 02:03:09', NULL, '2025-12-17 02:02:49', '2025-12-17 02:03:09'),
(147, 'LAWSUN', 'oluwaseunfamuyibo185@gmail.com', '2025-12-17 03:32:40', '$2y$12$0ZCjkY3WzWN/BdxvEUhFPOlbJeTlIFgDf783GlHWCYF7uaF1.hIna', NULL, NULL, 0, '2025-12-17 03:32:40', NULL, '2025-12-17 03:31:54', '2025-12-17 03:32:40'),
(148, 'omolara.palmer@students.jabu.edu.ng', 'omolara.palmer@students.jabu.edu.ng', '2025-12-17 08:18:11', '$2y$12$SGRcKZHhOeK06M5Mzr6hN.VbRSaqWhepiBU6OhxYtTqiKFLJTjDzy', NULL, NULL, 0, '2025-12-17 08:18:11', NULL, '2025-12-17 08:17:39', '2025-12-17 08:18:11'),
(149, 'Orisaleye Grace Oluwabukola', 'oluwabukola.orisaleye@students.jabu.edu.ng', NULL, '$2y$12$sgR8ZesbXgu8jDwuWo/lkeJr4TbCkTODXZi6QZa8GuHdSmb3TjVrG', '$2y$12$eh16qiufzy/wxuDNoWoUxO6qcT9tzZkK3ST4xKR5yp2qe5PCTsdvC', '2025-12-17 19:17:35', 0, NULL, NULL, '2025-12-17 19:07:35', '2025-12-17 19:16:17'),
(150, 'Adewale Peter', 'adewalep260@gmail.com', '2025-12-17 23:05:20', '$2y$12$YCspfWRT5jNOLTANa/npGuHMUJ3STJIpHZwad/lPRgUxwnmGUZKVK', NULL, NULL, 0, '2025-12-17 23:05:20', NULL, '2025-12-17 23:04:36', '2025-12-17 23:05:20'),
(151, 'oscar sandoval', 'garycork26@gmail.com', '2025-12-18 02:37:54', '$2y$12$UDWq5AScmS993Ls00UJqDOkyWO5UqyJhxSCpHMcNbYaf1UMAMpVJq', NULL, NULL, 0, '2025-12-18 02:37:54', NULL, '2025-12-18 02:36:36', '2025-12-18 02:37:54'),
(152, 'Chinedu Ossai', 'osbornecj79@yahoo.com', '2025-12-18 19:32:18', '$2y$12$bUij35r8qSs36XKLW2UjUuSuzvM2nY2GGSyJa4ZgBqL1UuFI9lpKq', NULL, NULL, 0, '2025-12-18 19:32:18', NULL, '2025-12-18 19:28:06', '2025-12-18 19:32:18'),
(153, 'Ilerioluwa Ogunyemi', 'ilerioluwa.ogunyemi@students.jabu.edu.ng', '2025-12-18 20:00:23', '$2y$12$5hP0iNltOBn/Dfns2HzdS.1vemwNmnzmXrsrwOhWnqLj6yFkCDytS', NULL, NULL, 0, '2025-12-18 20:00:23', NULL, '2025-12-18 19:59:54', '2025-12-18 20:00:23'),
(154, 'Adeniyi Tosin Gloria', 'adeniyitosin120@gmail.com', NULL, '$2y$12$ykBQRuZh/6IS8M19f7YhTeEpy/jUOJBafwJtvDc6okkug9esUKYMG', '$2y$12$el/gHm9HM07ZHT3rKRLObOjBMSYHcLilBxQlPhiWGw8FBXAOR2wYC', '2025-12-19 14:45:47', 0, NULL, NULL, '2025-12-19 14:29:34', '2025-12-19 14:35:47'),
(155, 'Enenche Favour', 'enenchefavour4@gmail.com', NULL, '$2y$12$PYeG0NTFz9WOxTF/PUeBBey6ImIU8YMQ8cfgXoM15mXvsA1huqmie', '$2y$12$.FNWwSKSCzPksb.KJ.Qx1O/JJfNsEmj2tLiN51CAfi3tUKgURorW2', '2025-12-19 15:42:04', 1, NULL, NULL, '2025-12-19 15:25:21', '2025-12-19 15:32:23'),
(156, 'Khaleelat', 'k80376196@gmail.com', '2025-12-20 13:49:01', '$2y$12$5Sx6vuk1At1rUiz3zvk4VeoT.7iiRbmpEeMVw35H9OBYnGhxk8tvq', NULL, NULL, 0, '2025-12-20 13:49:01', NULL, '2025-12-20 13:48:10', '2025-12-20 13:49:01'),
(157, 'Excelsior Legal Consult', 'excelsiorlegalconsult@gmail.com', '2025-12-20 14:56:47', '$2y$12$PnAoOVrPtq8T4j9gH4cSZuRTowgtIOk4c3fpWftTOajmAMQ8PlJHu', NULL, NULL, 0, '2025-12-20 14:56:47', NULL, '2025-12-20 14:55:52', '2025-12-20 14:56:47'),
(158, 'Sunmisola Akintayo', 'sunmisolabukola9@gmail.com', '2025-12-20 17:08:41', '$2y$12$1A1IamHmueBtJ6XqI4//QeqW4G7GwpXOf/l9cQiKb2L3UH/K9A6zW', NULL, NULL, 0, '2025-12-20 17:08:41', NULL, '2025-12-20 17:06:22', '2025-12-20 17:08:41'),
(159, 'Ayo-Fagbe Molayo', 'molayoayofagbe@gmail.com', '2025-12-21 13:01:59', '$2y$12$VaF7I0ZDO/NURsmY2Le.beT7bcPHL/XpPDfjZWwlV3A9AFxAfZgai', NULL, NULL, 0, '2025-12-21 13:01:59', NULL, '2025-12-21 13:01:37', '2025-12-21 13:01:59'),
(160, 'Jabu', 'adejotimothy090@gmail.com', '2025-12-22 13:36:23', '$2y$12$XBH6ma2Q2JVYqapd1kpgd.0BgHdbpUfCHjDN4kCfoVmuXbG5I5uqW', NULL, NULL, 0, '2025-12-22 13:36:23', NULL, '2025-12-22 13:35:35', '2025-12-22 13:36:23'),
(161, 'FOLAKE E. ADEWUMI', 'afolakeadewumi1@gmail.com', '2025-12-22 21:12:52', '$2y$12$2hFJx8n/WWLZsDCzHguICu2yjkabbhVB2KooiZXyTJLKMQSqW3f8S', NULL, NULL, 0, '2025-12-22 21:12:52', NULL, '2025-12-22 21:12:04', '2025-12-22 21:12:52'),
(162, 'Adenike', 'adenikesarah88@gmail.com', '2025-12-23 01:26:51', '$2y$12$Oy9kmx7/jZBWtnf1iC411uWtNXkWKgHO4PFQPsUjVhynVPaRL4B46', NULL, NULL, 0, '2025-12-23 01:26:51', NULL, '2025-12-23 01:26:32', '2025-12-23 01:26:51'),
(163, 'O. OYINPOSOLA OLOWOOKERE ESQ.', 'missoyinposolami@gmail.com', '2025-12-23 15:37:35', '$2y$12$9pOgA1SxnAdWnFBlsxF6nuzNsUCi/UH81ETh3694NUe5LFx6Q/ieO', NULL, NULL, 0, '2025-12-23 15:37:35', NULL, '2025-12-23 15:36:49', '2025-12-23 15:37:35'),
(164, 'Chekwube Udubor', 'chekwubeella@yahoo.com', '2025-12-23 17:05:14', '$2y$12$86gwP5XWzLbcz.Yw0GFRWe5XeHg/IQ6.VaQmj67r35CS..AXzRqsq', NULL, NULL, 0, '2025-12-23 17:05:14', NULL, '2025-12-23 17:04:52', '2025-12-23 17:05:14'),
(165, 'Ajayi Moyinoluwalogo', 'ajayimoyinoluwa290@gmail.com', '2025-12-23 23:50:19', '$2y$12$l7oB02nsmAo8W3NwdytE5OfG/cSAUwUwXdgpLiq2eicCfKJ8iFnse', NULL, NULL, 0, '2025-12-23 23:50:19', NULL, '2025-12-23 23:49:36', '2025-12-23 23:50:19'),
(166, 'Elsie Akpabio', 'elsieakpabio@yahoo.co.uk', '2025-12-24 16:52:53', '$2y$12$cc8s5fnBYAjyocaRI0/X9ewUNCxJD2HB7uXfBvv92V34Etl56SPua', NULL, NULL, 0, '2025-12-24 16:52:53', NULL, '2025-12-24 16:52:15', '2025-12-24 16:52:53'),
(167, 'Deborah Diya', 'ademoladeborah44@gmail.com', '2025-12-25 00:36:43', '$2y$12$GWjlL2WFC8eg5jh9xgS3D..w5K0ivMdePBGnkd5EZj.zKVI0I8mrG', NULL, NULL, 0, '2025-12-25 00:36:43', NULL, '2025-12-25 00:36:14', '2025-12-25 00:36:43'),
(168, 'Ainasu Samson', 'ainasusamson02@gmail.com', '2025-12-26 02:59:08', '$2y$12$d2grD5AI4jXp0VkPKrH6GObL0YZjQcVMOF3QEbljz6fPsdAayqgZy', NULL, NULL, 0, '2025-12-26 02:59:08', NULL, '2025-12-26 02:58:32', '2025-12-26 02:59:08'),
(169, 'Olutayo Babadamidade', 'olutayodamidade@gmail.com', '2025-12-26 12:30:37', '$2y$12$9vmHl1.NjKJKiUxxbRny8u1t36tZOvCv51BuupNIvI2eQlF7Of3ay', NULL, NULL, 0, '2025-12-26 12:30:37', NULL, '2025-12-26 12:30:10', '2025-12-26 12:30:37'),
(170, 'Verdict', 'lawalmustaphaoladipupo@gmail.com', '2025-12-26 13:39:55', '$2y$12$RgmQM4OQ66tjzrL4bZrfvuacDVrXrfrKdiBTIqDoiw3v8fKEX5juy', NULL, NULL, 0, '2025-12-26 13:39:55', NULL, '2025-12-26 13:36:31', '2025-12-26 13:39:55'),
(171, 'Nnajiofor Rita', 'ritannajiofor3@gmail.com', '2025-12-26 13:37:42', '$2y$12$YUUFNuW5LAcFwcI3e2pBXOXYvQF9m8faJXYXHJytvZQKgvrBqUhGG', NULL, NULL, 0, '2025-12-26 13:37:42', NULL, '2025-12-26 13:37:15', '2025-12-26 13:37:42'),
(172, 'Enwerem Pearl', 'pearlenwerem@gmail.com', '2025-12-26 13:38:17', '$2y$12$EIDQDJVcQI04PzlBwoOP5OWE8EHtHZU3kRjeHxel.Zno0dmiG/PRa', NULL, NULL, 0, '2025-12-26 13:38:17', NULL, '2025-12-26 13:37:40', '2025-12-26 13:38:17'),
(173, 'okemoyo01@gmail.com', 'okemoyo01@gmail.com', '2025-12-26 13:42:58', '$2y$12$/utVePNqJhpPukeX7bqlk.NGRSVagjqmis14msbNyxBGjcIIUtI.2', NULL, NULL, 0, '2025-12-26 13:42:58', NULL, '2025-12-26 13:39:46', '2025-12-26 13:42:58'),
(174, 'arogundadelatifah62@gmail.com', 'arogundadelatifah62@gmail.com', '2025-12-26 13:40:28', '$2y$12$paSc4nrDPRnoCmejUFKgUecmXcH0Ndjh3u2E43oTmes9bjyGwmNWm', NULL, NULL, 0, '2025-12-26 13:40:28', NULL, '2025-12-26 13:39:54', '2025-12-26 13:40:28'),
(175, 'Rifqah Bakare', 'rifqahakorede@gmail.com', '2025-12-26 13:42:03', '$2y$12$JF452oJ1JLU1CqeThI.Yoeoja/DiCmROt3VaxR9gbOplktO7Wxt3S', NULL, NULL, 0, '2025-12-26 13:42:03', NULL, '2025-12-26 13:41:32', '2025-12-26 13:42:03'),
(176, 'Akinsola Joy Deborah', 'joyakinsola046@gmail.com', '2025-12-26 13:43:30', '$2y$12$x9Fdo7Loc.1WFv3Dq8Ctdu88CDTP6VQR.fIFwBUrO3Hqhl.WoU7FK', NULL, NULL, 0, '2025-12-26 13:43:30', NULL, '2025-12-26 13:43:00', '2025-12-26 13:43:30'),
(177, 'Ademiju Sharon', 'ademijusharon@gmail.com', '2025-12-26 13:45:24', '$2y$12$Hc0ebstvHcZtHIQRT3o2dOe18UMnjV4apCId9FPiUooeV84210k2u', NULL, NULL, 0, '2025-12-26 13:45:24', NULL, '2025-12-26 13:45:01', '2025-12-26 13:45:24'),
(178, 'Daniel Akinkuowo', 'danielakins2022@gmail.com', '2025-12-26 13:46:19', '$2y$12$S7G4jZRnokSnqycIkYIy4OGOC6cLJXzxaICF.AuhJ8VJkq5IGU/o2', NULL, NULL, 0, '2025-12-26 13:46:19', NULL, '2025-12-26 13:45:02', '2025-12-26 13:46:19'),
(179, 'Mubarak seriki', 'mubarakseriki56@gmail.com', '2025-12-26 13:46:25', '$2y$12$.7QcRvUDPNcdXoZPZeW1t.9lGHpXjfy6n/Hnjm2Rj./rrbQnRydFK', NULL, NULL, 0, '2025-12-26 13:46:25', NULL, '2025-12-26 13:45:35', '2025-12-26 13:46:25'),
(180, 'Okeke Chidera', 'okekechidera108@gmail.com', '2025-12-26 13:46:57', '$2y$12$w8P4EIbDBDq4f.SohjjAceDiD1KVF73ByQuS4is26uGVXZ6Vd.oDu', NULL, NULL, 0, '2025-12-26 13:46:57', NULL, '2025-12-26 13:46:18', '2025-12-26 13:46:57'),
(181, 'Aisha Akanni', 'aishaakanni123@gmail.com', '2025-12-26 13:46:52', '$2y$12$Y8kT.4uoPGR78uS8tvoShemkDxuaugyw90T8zIS2zZHFhj7TkvoaO', NULL, NULL, 0, '2025-12-26 13:46:52', NULL, '2025-12-26 13:46:32', '2025-12-26 13:46:52'),
(182, 'Rodiat', 'ryatlogistics@gmail.com', '2025-12-26 13:51:26', '$2y$12$ki1gDMn7VEPc9ykVgvasDueSuTMdR/KHopNeZB9XT.Altep2Ht0bW', NULL, NULL, 0, '2025-12-26 13:51:26', NULL, '2025-12-26 13:50:57', '2025-12-26 13:51:26'),
(183, 'Kolade', 'koladewonderful@gmail.com', '2025-12-26 13:51:37', '$2y$12$ILii7DP32.MaGNHe6gkPKejcV0/0uR9pQfgoYug6WgV9SzOiwUnjK', NULL, NULL, 0, '2025-12-26 13:51:37', NULL, '2025-12-26 13:51:04', '2025-12-26 13:51:37'),
(184, 'Rukevwe', 'they.call.me.kevwe@gmail.com', '2025-12-26 13:52:39', '$2y$12$402ml717du9eMwmzq0ZMZ.WhRNzGHd60g2ZnSVr7etnC9YeBUQOcK', NULL, NULL, 0, '2025-12-26 13:52:39', NULL, '2025-12-26 13:52:16', '2025-12-26 13:52:39'),
(185, 'KC Ngele', 'kcngele27@gmail.com', '2025-12-26 13:55:26', '$2y$12$9lg8Di8TagWWh5W83o651eRFUmzDAppMjdjMorEqc/UzCrxYJzaF2', NULL, NULL, 0, '2025-12-26 13:55:26', NULL, '2025-12-26 13:54:35', '2025-12-26 13:55:26'),
(186, 'Olaide Omotoro', 'oaomotoro@gmail.com', '2025-12-26 13:56:53', '$2y$12$lCHeUZQ3.RlNWJWtJbEdQONPYDzqJ8HER6zbOrJPpl7syDUl8q4QC', NULL, NULL, 0, '2025-12-26 13:56:53', NULL, '2025-12-26 13:55:26', '2025-12-26 13:56:53'),
(187, 'University of Lagos', 'queensleyamiandamen@gmail.com', NULL, '$2y$12$68I.XLINBkwxTi08axBBy.ebU73wX.JePHaxmJaN.syeZ9geCW/o.', '$2y$12$f5zoXdNf.i4iNc5zaCTUx.U8IQrkwPYE6ETNxhSLtSMJCRf4Is57e', '2025-12-26 14:09:08', 0, NULL, NULL, '2025-12-26 13:59:07', '2025-12-26 13:59:08'),
(188, 'Amiandamen Queensley', 'bigmamaandpapa061@gmail.com', '2025-12-26 14:02:19', '$2y$12$TsxXeAihl/Ub2YghwR2d5e9iZemJ/Vtb7r5n6jjKy52.24FDwblB2', NULL, NULL, 0, '2025-12-26 14:02:19', NULL, '2025-12-26 14:00:46', '2025-12-26 14:02:19'),
(189, 'Oluwateniola Mustapha', 'teniolamustapha5@gmail.com', '2025-12-26 14:07:19', '$2y$12$XOK938JydZ30YFix.wpMQ.5tBeXTj9zAww2C8UMV/7pfN3CXpeOx2', NULL, NULL, 0, '2025-12-26 14:07:19', NULL, '2025-12-26 14:06:40', '2025-12-26 14:07:19'),
(190, 'Unilag', 'confidenceamarachi78@gmail.com', '2025-12-26 14:13:56', '$2y$12$aUmu2NNVym0hSS7j9WMV4ujTASZiSEctgGRGDrFYdtow9SqZ5oYKq', NULL, NULL, 0, '2025-12-26 14:13:56', NULL, '2025-12-26 14:13:26', '2025-12-26 14:13:56'),
(191, 'Oluwatobiloba', 'ayodeleoluwatobiloba2008@gmail.com', '2025-12-26 14:18:19', '$2y$12$h5g0bxc88Z9zzxQ3RetDxemDSuMqiE7dNXCYQ.XbysjESeyEY9jva', NULL, NULL, 0, '2025-12-26 14:18:19', NULL, '2025-12-26 14:16:52', '2025-12-26 14:18:19'),
(192, 'Uka Loveth obasi', 'obasiloveth714@gmail.com', '2025-12-26 14:29:52', '$2y$12$ed.OORsvmvk1zIEDu4rhV.LBDqSXL7cOl4wgAGeDNWknx4MSN9aU6', NULL, NULL, 0, '2025-12-26 14:29:52', NULL, '2025-12-26 14:29:00', '2025-12-26 14:29:52'),
(193, 'Rofiat Ifedayo', 'rofiateniola482@gmail.com', '2025-12-26 14:33:18', '$2y$12$JWl4fPElvwSY0XWBmFe4dupdxF67c/iPeIVOg6LV.w.TiX1OFaopC', NULL, NULL, 0, '2025-12-26 14:33:18', NULL, '2025-12-26 14:32:52', '2025-12-26 14:33:18'),
(194, 'Black Sapphire', 'blvck99sapphire@gmail.com', '2025-12-26 14:34:40', '$2y$12$.eLxRIwaSiUUE6jrFMqyOOY7Y8YKcd4Jux05a5I3KpyAoHebkz16u', NULL, NULL, 0, '2025-12-26 14:34:40', NULL, '2025-12-26 14:34:09', '2025-12-26 14:34:40'),
(195, 'Garba Martha', 'garbamartha01@gmail.com', '2025-12-26 14:36:59', '$2y$12$QuXHbNR8W2hkiW3OH/.Q6.2NbTsLUcpeYcCTEchydgTdsB/WczXLe', NULL, NULL, 0, '2025-12-26 14:36:59', NULL, '2025-12-26 14:36:22', '2025-12-26 14:36:59'),
(196, 'Wurami Bewaji', 'wurabewaji@gmail.com', '2025-12-26 15:03:53', '$2y$12$yfy7Vi2igtlAL.COtHiWDeZO9aNGv4UnkxyxYYiWYhx96b0rsrzMa', NULL, NULL, 0, '2025-12-26 15:03:53', NULL, '2025-12-26 15:02:47', '2025-12-26 15:03:53'),
(197, 'Olayinka', 'sanniolayinkaa@gmail.com', '2025-12-26 15:17:18', '$2y$12$P6Ocpog94GESRirj4Jzmk.dKXl74yrVsTW83ZqKd3P2ZAJPaerfFG', NULL, NULL, 0, '2025-12-26 15:17:18', NULL, '2025-12-26 15:16:50', '2025-12-26 15:17:18'),
(198, 'Precious Omorose', 'preciousomorose97@gmail.com', '2025-12-26 15:20:28', '$2y$12$gk71qiBrJbNV0/AaM6q9VurreMmjkZ2YcocNcclmlBO8PyeYasSV6', NULL, NULL, 0, '2025-12-26 15:20:28', NULL, '2025-12-26 15:19:28', '2025-12-26 15:20:28'),
(199, 'Ranmwen E. Uwadiae', 'egberanmwenesther8@gmail.com', '2025-12-26 16:01:26', '$2y$12$1AHI06xZsDYTug7GusVqauyz5gIcfUxcJjRy.SfDxd2j/3xWlukwe', NULL, NULL, 0, '2025-12-26 16:01:26', NULL, '2025-12-26 16:01:02', '2025-12-26 16:01:26'),
(200, 'Oyekunbi Araoluwa Clement-Praise', 'oyekunbiaraoluwa8@gmail.com', '2025-12-26 16:53:22', '$2y$12$2.g/qePGT4GeWQc/jYilverQ7MmL2frYyoaItjh5oMuA68EjI8.HG', NULL, NULL, 0, '2025-12-26 16:53:22', NULL, '2025-12-26 16:52:40', '2025-12-26 16:53:22'),
(201, 'Fadairo Oluwaseun Elizabeth', 'fadairooluwaseun04@gmail.com', '2025-12-26 18:03:03', '$2y$12$7KD5SCPrD5icJCaQplbP2.RDdLdMp5l.ENX5zBaUhanVrY0UhORcW', NULL, NULL, 0, '2025-12-26 18:03:03', NULL, '2025-12-26 18:02:35', '2025-12-26 18:03:03'),
(202, 'Divine favour', 'ananefavour7@gmail.com', '2025-12-26 18:49:35', '$2y$12$kZVpeC45hez/f/8pBsH7DeLyOpOtfu4EvC12HmX0FVBLuxveeGBdi', NULL, NULL, 0, '2025-12-26 18:49:35', NULL, '2025-12-26 18:49:15', '2025-12-26 18:49:35'),
(203, 'Babalola OluwaFikayomi', 'fikayob09@gmail.com', '2025-12-26 19:11:30', '$2y$12$mif8uk6E1d4Ve1B5zPYHA.oVkxwA8hWgOPfCCTGuuxagV5TP//Az.', NULL, NULL, 0, '2025-12-26 19:11:30', NULL, '2025-12-26 19:10:35', '2025-12-26 19:11:30'),
(204, 'Akintola Victoria', 'akintolavictoria518@gmail.com', '2025-12-26 19:11:32', '$2y$12$6bI1//qnm3xPMX6OmIPc6.TDTYIF62/l3yDkUe2jkkM0Qay7GEP8a', NULL, NULL, 0, '2025-12-26 19:11:32', NULL, '2025-12-26 19:10:59', '2025-12-26 19:11:32'),
(205, 'Tochi', 'melvintochukwu1@gmail.com', NULL, '$2y$12$xv2mY1qTmBJrB18EtsmvTedYdO6WHeYIckZSiTWhDflSZVKb3zEN2', '$2y$12$2lQZhoWaub66EMnwfl30OOc7yulkB/rsbgQ/UBwopPWTB.3kFHhvK', '2025-12-26 21:18:21', 0, NULL, NULL, '2025-12-26 21:08:21', '2025-12-26 21:08:21'),
(206, 'Omotoyosi', 'aroworaomotoyosi87@gmail.com', '2025-12-27 02:37:06', '$2y$12$VwQkwhidKq6hnIa7FZ/ob.y.YNoY2MR1tS2yQJhqseFXpiPHMc2Ju', NULL, NULL, 0, '2025-12-27 02:37:06', NULL, '2025-12-27 02:36:25', '2025-12-27 02:37:06'),
(207, 'Luna', 'lunashane236@gmail.com', '2025-12-27 22:17:59', '$2y$12$q5Q9b5AOTKVGhCDyfy32xOD12D9h9gVW0/eRX4a0tiUFSGwPRnGuq', NULL, NULL, 0, '2025-12-27 22:17:59', NULL, '2025-12-27 22:17:36', '2025-12-27 22:17:59'),
(208, 'Zainab', 'zainabayandare123@gmail.com', '2025-12-28 01:36:15', '$2y$12$6OVps59vNQYkLg4b..MZhee7n5YZtmDkhE1YPkkpkkb6ykeezN0tq', NULL, NULL, 0, '2025-12-28 01:36:15', NULL, '2025-12-28 01:35:21', '2025-12-28 01:36:15'),
(209, 'Omowunmi Ogun', 'ogunomowunmi8@gmail.com', '2025-12-29 20:30:11', '$2y$12$HIet7PhKskWHfIli1A0XIeiPVaiuqeCD1AzV4DQnEpY/fnjwUN0sK', NULL, NULL, 0, '2025-12-29 20:30:11', NULL, '2025-12-29 20:29:48', '2025-12-29 20:30:11'),
(210, 'DAMILOLA OJOPAGOGO', 'damilolaojopagogo@gmail.com', '2025-12-31 12:49:25', '$2y$12$PuDLqRcERSJPvKtu39oFOOp3dFm9gYSQGQfZ7pu51uW/9m369EuiK', NULL, NULL, 0, '2025-12-31 12:49:25', NULL, '2025-12-31 12:47:50', '2025-12-31 12:49:25'),
(211, 'Jomiloju', 'olawoyeoluwajomiloju@gmail.com', '2025-12-31 21:47:58', '$2y$12$Ig5nGM0hfRU1ksrpmoFMUeouF8FKFMbw7WbjKNCXbyytKlmXUQYcO', NULL, NULL, 0, '2025-12-31 21:47:58', NULL, '2025-12-31 21:47:27', '2025-12-31 21:47:58'),
(212, 'Solicitous Attorney', 'danielrebecca91@yahoo.com', '2026-01-03 13:46:20', '$2y$12$VXjPjRLF/0hkFVObvppF4O8S9c5KL2/jflBek/cF3GK6PxFELDG4m', NULL, NULL, 0, '2026-01-03 13:46:20', NULL, '2026-01-03 13:45:44', '2026-01-03 13:46:20');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `otp_code`, `otp_expires_at`, `otp_attempts`, `otp_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(213, 'Olanrewaju Obadina', 'obadina.lp@yahoo.com', NULL, '$2y$12$ZKRzlfVPTM37BWM/KAcf4ez699PKnN6VTOmOFFKbN9BddnS6FgXxG', '$2y$12$eyG/vn.Gc2OH1yP5BeqkMeOtD8zUG6K5Z8VTegc35F.MFQZMnrpru', '2026-01-03 14:00:27', 0, NULL, NULL, '2026-01-03 13:50:27', '2026-01-03 13:50:27'),
(214, 'Kayode Oyelade and Co', 'kaythelaw@nigerianbar.ng', '2026-01-03 15:09:19', '$2y$12$7H9JF8C7utWUJrEfe1RJkuP7nLn7rjyKzHaSwABbuuPLJ4gb8u982', NULL, NULL, 0, '2026-01-03 15:09:19', NULL, '2026-01-03 15:06:36', '2026-01-03 15:09:19'),
(215, 'Philip Deborah Ibukunoluwa', 'deborahphilip139@yahoo.com', NULL, '$2y$12$MtV.gYR03X46uWTqz6z.reGphk9jUaM7sIyOC3CGyDzlkL/00GRJC', '$2y$12$5bxTOLU3rXG.hikZmnCIluL8.ZuwxxgMcqLyrujndZuxoaF7M/U0K', '2026-01-05 10:48:28', 0, NULL, NULL, '2026-01-05 10:38:27', '2026-01-05 10:38:28'),
(216, 'Njideka Irene Ihionu', 'reeny1515@yahoo.com', '2026-01-05 11:59:43', '$2y$12$JswEMP81OkgsTsJR/42OCugM4iukidDCd7/yo16llyB7.t2jGiale', NULL, NULL, 0, '2026-01-05 11:59:43', NULL, '2026-01-05 11:58:53', '2026-01-05 11:59:43'),
(217, 'Toluwani Akinola', 'tolufunkeakin@gamil.com', NULL, '$2y$12$YBFmG.mD5yLlzdXsfU2f4.qLUMMhVwcluexbFfXaBE0dUaNNsJYe2', '$2y$12$5NEslJjAsw04g3zkKU9w4.yOJF8LCsUYtWXORI0NzNJYQw20VgDry', '2026-01-05 12:51:52', 0, NULL, NULL, '2026-01-05 12:40:28', '2026-01-05 12:41:52'),
(218, 'Capex Dei Solicitors', 'capexdeisolicitor@gmail.com', '2026-01-05 15:26:00', '$2y$12$xrac6VCUIY/XhRyLc7cwburFY6Fken7Ni1n.uIvj7967AyspO33Tm', NULL, NULL, 0, '2026-01-05 15:26:00', NULL, '2026-01-05 15:23:19', '2026-01-05 15:26:00'),
(219, 'akandesekinat2004@gmail.com', 'akandesekinat2004@gmail.com', '2026-01-05 20:03:17', '$2y$12$d8FR79Dmpo.l2m3hayRtHOBZGIVcPiw2SuF6SgF0HTaorNHKD8VfK', NULL, NULL, 0, '2026-01-05 20:03:17', NULL, '2026-01-05 20:02:46', '2026-01-08 18:09:00'),
(220, 'Egbe Osikhena', 'egbey2k1@yahoo.com', '2026-01-06 01:10:58', '$2y$12$1ZEPVjjV5I/wrmMVftZjxOJ1GfnfAk9XvfADxpCbjieqwYrm9wj8m', NULL, NULL, 0, '2026-01-06 01:10:58', NULL, '2026-01-06 01:10:15', '2026-01-06 01:10:58'),
(221, 'Unilag', 'samdlaw101@gmail.com', '2026-01-06 15:59:37', '$2y$12$M9Cf.r1sJEJqwGlNGgI9fekPt3drSK1M2iAgy613DIcnZOEPnrP3i', NULL, NULL, 0, '2026-01-06 15:59:37', NULL, '2026-01-06 15:58:48', '2026-01-06 15:59:37'),
(222, 'Oladimeji Aliyah', 'oladimejialiyah2@gmail.com', '2026-01-06 16:06:37', '$2y$12$4xSznbYU7WfrhDFb5LsDruWKwX2yhqaPDGnYIWuzWEJzRoYhUqpIe', NULL, NULL, 0, '2026-01-06 16:06:37', NULL, '2026-01-06 16:06:08', '2026-01-06 16:06:37'),
(223, 'Emmanuella', 'emmanuellaidakpo@gmail.com', '2026-01-06 16:19:07', '$2y$12$MD4ynG451l9N406SW1oMketcXseWkIlAGHma3gaOBaM2JRzzwbKXi', NULL, NULL, 0, '2026-01-06 16:19:07', NULL, '2026-01-06 16:18:22', '2026-01-13 05:32:49'),
(224, 'MARINA LAW CHAMBERS', 'marinalawchambers@hotmail.com', '2026-01-06 17:03:52', '$2y$12$vgBDnT9BDDSocZwdjNigEuAqcKyDCHkb7NZIO6Ss900v58nIYjHcy', NULL, NULL, 0, '2026-01-06 17:03:52', NULL, '2026-01-06 17:02:05', '2026-01-06 17:37:59'),
(225, 'Anoghena', 'anikeoluwa05@gmail.com', '2026-01-06 17:09:22', '$2y$12$XL0Zdob0HRsSdPoY3X77Fe1txWIsRoW.fGH1kzwaS0RS72ZoCep9u', NULL, NULL, 0, '2026-01-06 17:09:22', NULL, '2026-01-06 17:08:50', '2026-01-06 17:09:22'),
(226, 'Ridwan', 'ridwanbak3@gmail.com', '2026-01-06 17:13:01', '$2y$12$.8RTi6cnaRTXsBVZK0WXGuOAN267UHi3pjOVFtKbB6ISiYOzl.n9m', NULL, NULL, 0, '2026-01-06 17:13:01', NULL, '2026-01-06 17:12:16', '2026-01-06 17:13:01'),
(227, 'Divine-favour', 'divinelyfavoured20@gmail.com', '2026-01-15 04:29:22', '$2y$12$VYs.2QdK3F9IKcr4Tbdkn.oDl1UnyQd9NYrWoGhlA.esdsbe2iBfK', NULL, NULL, 0, '2026-01-15 04:29:22', NULL, '2026-01-06 17:40:25', '2026-01-15 04:29:22'),
(228, 'Adeola', 'aniolaanifowose@gmail.com', '2026-01-06 17:51:19', '$2y$12$5b8lqQ0bQCVXw0MSnW0hSOHXj1mHN01kmsU1KM54sit.Kpaksw3Cy', NULL, NULL, 0, '2026-01-06 17:51:19', NULL, '2026-01-06 17:50:48', '2026-01-06 17:51:19'),
(229, 'Destinyandlawlords', 'owolabiibrahim03@gmail.com', '2026-01-06 17:54:34', '$2y$12$2ZsDWmyand/0UAJwHJjWcuunbHNcl0GGhUa6Swvz2vaHzp6Qa4o1K', NULL, NULL, 0, '2026-01-06 17:54:34', NULL, '2026-01-06 17:54:13', '2026-01-06 17:54:34'),
(230, 'Unilag', 'ololadeogunleye14@gmail.com', '2026-01-06 19:00:59', '$2y$12$n/Rs9ndqhKGmvedrSmWnpOt4i2ZgShLC00EimcKU2tGT71wu567tq', NULL, NULL, 0, '2026-01-06 19:00:59', NULL, '2026-01-06 19:00:09', '2026-01-06 19:00:59'),
(231, 'Chioma', 'chiomajoe2023@gmail.com', '2026-01-06 19:05:49', '$2y$12$b33NuIilNX12d5AlKrm5JuHxzEOTibcP.0aoGM6/odJn84C2KbiV.', NULL, NULL, 0, '2026-01-06 19:05:49', NULL, '2026-01-06 19:05:10', '2026-01-06 19:05:49'),
(232, 'Abisola Favour Omolayo', 'abisolafavour77@gmail.com', '2026-01-06 19:31:30', '$2y$12$g5CnhvYiXTsDwxGIcIxakezglRrkhpS3MfXr4NooK9WJGHcZ/3AF2', NULL, NULL, 0, '2026-01-06 19:31:30', NULL, '2026-01-06 19:30:37', '2026-01-06 19:31:30'),
(233, 'Zechariah', 'bellozechariah058@gmail.com', '2026-01-06 22:23:00', '$2y$12$ze/nrSW9r/e7nxOgRn0x0uR6aldpZUnxQPtmufGrj2CH8//P0RVwO', NULL, NULL, 0, '2026-01-06 22:23:00', NULL, '2026-01-06 22:22:24', '2026-01-06 22:23:00'),
(234, 'Williams Olamilekan', 'olamilekanwilliams3@gmail.com', '2026-01-06 22:32:25', '$2y$12$JdaRPraqnXqKZMEQn.3vSeEPEoMrh9Yh2mXnqiiJWLkNCD6bQ3MRq', NULL, NULL, 0, '2026-01-06 22:32:25', NULL, '2026-01-06 22:32:03', '2026-01-06 22:32:25'),
(235, 'Barakatullah', 'barakatullah148@gmail.com', '2026-01-07 02:30:23', '$2y$12$5g45IbKerhp4OX/ax0eKA.lJaI2UWng0Z/Xwk8po.MJ..g4ubMECy', NULL, NULL, 0, '2026-01-07 02:30:23', NULL, '2026-01-07 02:29:24', '2026-01-07 02:30:23'),
(236, 'W. K. Shittu & Co.', 'wkshittuandco@yahoo.com', '2026-01-07 17:23:23', '$2y$12$JOdJVcWTtZb9q5oHQzv5a.RXw7kpjziP6gwd4WkGf1eUmzU77Lzay', NULL, NULL, 0, '2026-01-07 17:23:23', NULL, '2026-01-07 17:21:53', '2026-01-07 17:23:23'),
(237, 'Mejolagbe Aduragbemi', 'mejolagbeaduragbemi@gmail.com', '2026-01-07 17:48:46', '$2y$12$qmLZdY8uEUy0s.HAudI9F.kiKEWWlCb7kUw3ni0aaXVZcmMP/VULu', NULL, NULL, 0, '2026-01-07 17:48:46', NULL, '2026-01-07 17:48:23', '2026-01-07 17:48:46'),
(238, 'Twinkle', 'officialtwinkletoes002@gmail.com', '2026-01-08 00:09:25', '$2y$12$RfTIvEk96h44IlDkbYVduer/8DzXLyEX.J0B8e3oLg1Ap1XxUyZ2G', NULL, NULL, 0, '2026-01-08 00:09:25', NULL, '2026-01-08 00:08:35', '2026-01-15 00:28:18'),
(239, 'Oluwaferanmi Temiloluwa Matilda', 'oluwaferanmitemiloluwa37@gmail.com', NULL, '$2y$12$3tdtaWlcgeTP/xxgaL3ehesNGdYE.xTt/qGaQNjJd.NzGtQ3As3ii', '$2y$12$H6O/RzI22Y6LNVcZr/txm.IsFpxV.JgbY8wANMlK6XcPeIZ.HEzoK', '2026-01-08 17:37:25', 0, NULL, NULL, '2026-01-08 17:27:25', '2026-01-08 17:27:25'),
(240, 'Oluwaferanmi Temiloluwa Matilda', 'temiloluwaoluwaferanmi8@gmail.com', NULL, '$2y$12$.CRmRmTQm3MPce35gHf.uu8Mmra3M/dLqJjg201BT.Wl6OIiIjlri', '$2y$12$Dn6SpBdOd2AQAIiSXPSvcOlQx3dR.yMBPAtdGIYUQU4WZZUSDjpTq', '2026-01-08 17:48:28', 1, NULL, NULL, '2026-01-08 17:28:35', '2026-01-08 17:38:33'),
(241, 'Capitalfield', 'oteikwu4@gmail.com', '2026-01-08 18:26:37', '$2y$12$Uuuv1RLcyC.p.C1ulkC58.o8ATeWs4PqhXWOQ8maW5l/P9WesI/vG', NULL, NULL, 0, '2026-01-08 18:26:37', NULL, '2026-01-08 18:26:12', '2026-01-08 18:26:37'),
(242, 'Asokere mausi', 'okanlawonmausi@gmail.com', '2026-01-08 23:55:49', '$2y$12$3WX4qJt2ySFpwqs5bwMt7.ftTHOWkUgj7v4nqe/BR.JstxZAVUiyG', NULL, NULL, 0, '2026-01-08 23:55:49', NULL, '2026-01-08 23:54:44', '2026-01-08 23:55:49'),
(243, 'Oluwagbotemi Lawrence', 'oluwagbotemilawrence1@gmail.com', '2026-01-09 04:14:04', '$2y$12$NvAjgjiP4667BUEJSMql7OwKRS.xDn.63xetN8SNmq6po3D0EqH2S', NULL, NULL, 0, '2026-01-09 04:14:04', NULL, '2026-01-09 04:13:19', '2026-01-09 04:14:04'),
(244, 'Favour', 'ayanfejesuniyi@gmail.com', '2026-01-09 20:48:07', '$2y$12$z5uQAGqX1VFB7mNn6iC4g.YE78XBJ0tzMGo6.ZF7CJMryZeqUV8AK', NULL, NULL, 0, '2026-01-09 20:48:07', NULL, '2026-01-09 20:47:37', '2026-01-09 20:48:07'),
(245, 'Opeyemi Adebanjo', 'opeyemiadebanjo7@gmail.com', '2026-01-12 10:06:25', '$2y$12$yQR0z5HoHKjghAuJEzcNkOBr.VRo9AT4cUnFmjPRYuhDid/a8zxc.', NULL, NULL, 0, '2026-01-12 10:06:25', NULL, '2026-01-12 10:05:52', '2026-01-12 10:06:25'),
(246, 'B.C Okoye & Co', 'senorbrian01@gmail.com', '2026-01-12 11:02:04', '$2y$12$Wlge2/9L7YGZ73CgTWhXv..g81SLPeh18hQRoJPM5sEqfn/z8yYIO', NULL, NULL, 0, '2026-01-12 11:02:04', NULL, '2026-01-12 11:01:42', '2026-01-12 11:02:04'),
(247, 'Cyrus', 'demiladeadegoke417@gmail.com', '2026-01-12 14:24:27', '$2y$12$fQHdVjzE8TgqPt3Ujl7aKe56EJzQTbtYFDmSvRA5dy/pCZTwTamOC', NULL, NULL, 0, '2026-01-12 14:24:27', NULL, '2026-01-12 14:23:58', '2026-01-12 14:24:27'),
(248, 'BB', 'bolababatunde@gmail.com', '2026-01-12 15:52:40', '$2y$12$88OuxiJGyCGITKVZt7uA3ORP.DyuoN2u0GFKEgbThAxyB08Dx/XUe', NULL, NULL, 0, '2026-01-12 15:52:40', NULL, '2026-01-12 15:51:51', '2026-01-12 15:52:40'),
(249, 'Oluwaferanmi Temiloluwa Matilda', 'oferanmi03@gmail.com', '2026-01-12 19:57:49', '$2y$12$z3vbDPhVzgUMtMs6l/hSpO/4xEC.CSglaKSu4odJ/6zUVBv2oRTXq', NULL, NULL, 0, '2026-01-12 19:57:49', NULL, '2026-01-12 19:57:31', '2026-01-12 19:57:49'),
(250, 'Fawaz', 'adebayofawaz362@gmail.com', '2026-01-12 20:18:22', '$2y$12$lWn1G7hjJAXdwj32P2I4GOHBCYevxwzP0MeI92xCBL8JCb5bG7bT6', NULL, NULL, 0, '2026-01-12 20:18:22', NULL, '2026-01-12 20:16:53', '2026-01-12 20:18:22'),
(251, 'afoke.richmond@gmail.com', 'afoke.richmond@gmail.com', '2026-01-13 23:16:57', '$2y$12$Vqg/WerzX9BxrkJ2aAwcLe3gaF8noCX7BjL27J/RJe4YEEIGGZ7vu', NULL, NULL, 0, '2026-01-13 23:16:57', NULL, '2026-01-13 23:16:27', '2026-01-13 23:16:57'),
(252, 'Kamsi Agwu', 'kamsiagwu@gmail.com', '2026-01-14 02:49:50', '$2y$12$XgMm2dSBZfzzmJBAKsV/tORkG9xKwcGcgag9sqKvGIvmCRLLUsfDu', NULL, NULL, 0, '2026-01-14 02:49:50', NULL, '2026-01-14 02:48:53', '2026-01-14 02:49:50'),
(253, 'Lina', 'preciousolufemi604@gmail.com', '2026-01-14 13:00:00', '$2y$12$mKBHN/99/hxz.L.9N9WtzugzQSG7TDMlI1qGhXzl8rjREd.VkvgG6', NULL, NULL, 0, '2026-01-14 13:00:00', NULL, '2026-01-14 12:54:55', '2026-01-14 13:00:00'),
(254, 'Hyackings law firm', 'mmasinachisandra34@gmail.com', '2026-01-15 09:48:17', '$2y$12$HbHjYwMI2e/ZEZed.9KXze26crBh622bxsWBrIhe/zktCiH2AhZ2u', NULL, NULL, 0, '2026-01-15 09:48:17', NULL, '2026-01-15 09:47:28', '2026-01-15 09:48:17'),
(255, 'Similoluwa Ige', 'similoluwaige@gmail.com', '2026-01-15 12:45:28', '$2y$12$mXa6TPUiDuf7p1uXjy1.QO4/w2LBDQwjZ2/MhP6n4ny0ZrjhcXGBW', NULL, NULL, 0, '2026-01-15 12:45:28', NULL, '2026-01-15 12:44:59', '2026-01-15 12:45:28'),
(256, 'Fatima Akano', 'akano.fatima@gmail.com', '2026-01-15 17:26:46', '$2y$12$ddX8P0.txXEr/xIS0i3eVermadZNrz4Be.ZK8YKiQIQ/b1YXSLs5.', NULL, NULL, 0, '2026-01-15 17:26:46', NULL, '2026-01-15 17:26:25', '2026-01-15 17:26:46'),
(257, 'shindara', 'oluwashindaraadejoro@gmail.com', '2026-01-15 17:42:35', '$2y$12$RJ5Pq.EJ.aSA3ioZxm4lReC.TxeghFvNzV3hK.TMHSk38B57wOP6S', NULL, NULL, 0, '2026-01-15 17:42:35', NULL, '2026-01-15 17:41:26', '2026-01-15 17:42:35'),
(258, 'Diamond', 'francisdiamond08@gmail.com', '2026-01-15 20:48:46', '$2y$12$xalr4hcW64VLEFK9NCRiPOMY8AaOCgr4SJWoI7soS5Awp89n52ve6', NULL, NULL, 0, '2026-01-15 20:48:46', NULL, '2026-01-15 20:47:35', '2026-01-15 20:48:46'),
(259, 'Chukwuma', 'ezechipeter2018@gmail.com', '2026-01-16 22:21:21', '$2y$12$5NrLW8QYGxpL2Y0/z7Q93.CSr1vIYl6YtH0gjy2HGvyOdiZGjYU32', NULL, NULL, 0, '2026-01-16 22:21:21', NULL, '2026-01-16 22:16:41', '2026-01-16 22:21:21'),
(260, 'FULFILMENT CHAMBERS  -LAW FIRM', 'adebayoadekoya1@gmail.com', '2026-01-18 11:28:22', '$2y$12$g38ZvT1QA33wo7iCD5J5CunlHBAz08qsuXnt/FvJlW7guBgZhLbLK', NULL, NULL, 0, '2026-01-18 11:28:22', NULL, '2026-01-18 11:27:42', '2026-01-18 11:28:22'),
(261, 'Hadeezah', 'hadeezahafolabi@gmail.com', '2026-01-18 21:36:44', '$2y$12$O1LQFN/laNuxhlc6fAwY6.PGAS33Hmtz9MZIgZdcxJ2jdjlvDA6bS', NULL, NULL, 0, '2026-01-18 21:36:44', NULL, '2026-01-18 21:36:06', '2026-01-18 21:36:44'),
(262, 'Globalpoint Attorneys', 'globalpointattorneys@gmail.com', '2026-01-19 23:23:56', '$2y$12$pKgf/6CDTJQ/XcysJD7Uc.biMS0i8yrFRqxhO/ws5VQTRajnI/b6S', NULL, NULL, 0, '2026-01-19 23:23:56', NULL, '2026-01-19 23:19:55', '2026-01-19 23:23:56'),
(263, 'Paul', 'sdstorage98@gmail.com', '2026-01-20 01:40:15', '$2y$12$XuRI2CP/m2v7Uzjq6NE/aOlIgFPavv.Tusu0WtOZGH2TLUZBYkjUu', NULL, NULL, 0, '2026-01-20 01:40:15', NULL, '2026-01-20 01:39:37', '2026-01-20 01:40:15'),
(264, 'Oluwatoyin', 'oluwatoyin.obe@panafricancapitalholdings.com', NULL, '$2y$12$V1PtDT3dZOTWOFSfMFA2NuVR1jEcOfRw7ty8jdeSRNPXOG5BL8UFm', '$2y$12$QZVJ/IwsO.w1BQi1IJa1Te6DSXe2AhAvOzmFTNKtXcISXEx0wFVEa', '2026-01-21 16:03:39', 0, NULL, NULL, '2026-01-20 21:51:57', '2026-01-21 15:53:39'),
(265, 'Obano Itohan', 'obanoit@gmail.com', '2026-01-20 22:43:17', '$2y$12$EgQr03moNR9fMWZXSbP4Vu4hWidTDn4rmHqTZPNaCjOoYOsoRoLBy', NULL, NULL, 0, '2026-01-20 22:43:17', NULL, '2026-01-20 22:42:43', '2026-01-20 22:43:17'),
(266, 'Oluwatoyin', 'pearlistico@yahoo.com', '2026-01-21 22:38:29', '$2y$12$d1fQ.0wbwqR8V53adrgIhO5y4Gz.yJhos.wIK5JSMjTdXgAHJe0bu', NULL, NULL, 0, '2026-01-21 22:38:29', NULL, '2026-01-21 22:37:09', '2026-01-21 22:38:29'),
(267, 'funmiadeyemi2511@gmail.com', 'funmiadeyemi2511@gmail.com', '2026-01-22 22:51:56', '$2y$12$QSjxBleF4zs8cihrchnhyO1joqGyxmSpm8og3j/yzy/WZVmsnFZI6', NULL, NULL, 0, '2026-01-22 22:51:56', NULL, '2026-01-22 22:51:33', '2026-01-22 22:51:56'),
(268, 'Ayodeji Dotun', 'dotunayodeji5@gmail.com', '2026-01-23 16:42:59', '$2y$12$/KWm6bLNofkFYbMyXQEKou0ciFXO7V58m4yieTUyYLkcpP/YOyxZe', NULL, NULL, 0, '2026-01-23 16:42:59', NULL, '2026-01-23 16:42:28', '2026-01-23 16:42:59'),
(269, 'Adesuyi', 'anuadesuyi@icloud.com', NULL, '$2y$12$/QFPACLasYt8LiDBtyxmIe28/aRykVTp7h4F99nvu8rQnM44ljXt6', '$2y$12$bY.qVqaquafQmgYcyqcofO0igS37IQAXDiixYqwr/T2KjY.vTuvAu', '2026-01-25 19:16:23', 0, NULL, NULL, '2026-01-25 19:03:32', '2026-01-25 19:06:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role`, `created_at`, `updated_at`) VALUES
(1, 1, 'user', '2025-10-22 01:45:13', '2025-10-22 01:45:13'),
(2, 2, 'admin', '2025-10-22 01:45:13', '2025-10-22 01:45:13'),
(3, 3, 'user', '2025-12-03 02:49:56', '2025-12-03 02:49:56'),
(5, 5, 'user', '2025-12-03 07:37:32', '2025-12-03 07:37:32'),
(6, 6, 'user', '2025-12-03 11:18:57', '2025-12-03 11:18:57'),
(7, 7, 'user', '2025-12-03 15:00:24', '2025-12-03 15:00:24'),
(8, 8, 'user', '2025-12-03 17:31:24', '2025-12-03 17:31:24'),
(9, 9, 'user', '2025-12-03 18:46:01', '2025-12-03 18:46:01'),
(10, 10, 'user', '2025-12-03 19:33:22', '2025-12-03 19:33:22'),
(11, 11, 'user', '2025-12-03 20:42:54', '2025-12-03 20:42:54'),
(12, 12, 'user', '2025-12-03 21:14:14', '2025-12-03 21:14:14'),
(13, 13, 'user', '2025-12-03 21:35:19', '2025-12-03 21:35:19'),
(14, 14, 'user', '2025-12-03 22:41:14', '2025-12-03 22:41:14'),
(15, 15, 'user', '2025-12-03 23:26:00', '2025-12-03 23:26:00'),
(16, 16, 'user', '2025-12-04 00:22:13', '2025-12-04 00:22:13'),
(17, 17, 'user', '2025-12-04 00:49:37', '2025-12-04 00:49:37'),
(18, 18, 'user', '2025-12-04 01:23:30', '2025-12-04 01:23:30'),
(19, 19, 'user', '2025-12-04 01:30:44', '2025-12-04 01:30:44'),
(20, 20, 'user', '2025-12-04 01:53:25', '2025-12-04 01:53:25'),
(21, 21, 'user', '2025-12-04 02:21:19', '2025-12-04 02:21:19'),
(22, 22, 'user', '2025-12-04 02:33:39', '2025-12-04 02:33:39'),
(23, 23, 'user', '2025-12-04 02:36:51', '2025-12-04 02:36:51'),
(24, 24, 'user', '2025-12-04 09:06:49', '2025-12-04 09:06:49'),
(25, 25, 'user', '2025-12-04 11:22:45', '2025-12-04 11:22:45'),
(26, 26, 'user', '2025-12-04 12:04:27', '2025-12-04 12:04:27'),
(27, 27, 'user', '2025-12-04 12:13:48', '2025-12-04 12:13:48'),
(28, 28, 'user', '2025-12-04 13:51:47', '2025-12-04 13:51:47'),
(29, 29, 'user', '2025-12-04 18:40:59', '2025-12-04 18:40:59'),
(30, 30, 'user', '2025-12-04 19:09:17', '2025-12-04 19:09:17'),
(31, 31, 'user', '2025-12-04 19:39:14', '2025-12-04 19:39:14'),
(32, 32, 'user', '2025-12-04 19:57:09', '2025-12-04 19:57:09'),
(33, 33, 'user', '2025-12-04 22:06:25', '2025-12-04 22:06:25'),
(34, 34, 'user', '2025-12-05 12:11:44', '2025-12-05 12:11:44'),
(35, 35, 'user', '2025-12-05 17:33:16', '2025-12-05 17:33:16'),
(36, 36, 'user', '2025-12-05 19:36:04', '2025-12-05 19:36:04'),
(37, 37, 'user', '2025-12-06 02:18:49', '2025-12-06 02:18:49'),
(38, 38, 'user', '2025-12-07 00:36:20', '2025-12-07 00:36:20'),
(39, 39, 'user', '2025-12-07 00:41:49', '2025-12-07 00:41:49'),
(40, 40, 'user', '2025-12-07 00:42:06', '2025-12-07 00:42:06'),
(41, 41, 'user', '2025-12-07 01:03:36', '2025-12-07 01:03:36'),
(42, 42, 'user', '2025-12-07 01:05:06', '2025-12-07 01:05:06'),
(43, 43, 'user', '2025-12-07 01:06:59', '2025-12-07 01:06:59'),
(44, 44, 'user', '2025-12-07 01:11:33', '2025-12-07 01:11:33'),
(45, 45, 'user', '2025-12-07 01:49:17', '2025-12-07 01:49:17'),
(46, 46, 'user', '2025-12-07 02:17:57', '2025-12-07 02:17:57'),
(47, 47, 'user', '2025-12-07 15:16:42', '2025-12-07 15:16:42'),
(48, 48, 'user', '2025-12-07 23:34:34', '2025-12-07 23:34:34'),
(49, 49, 'user', '2025-12-08 00:49:26', '2025-12-08 00:49:26'),
(50, 50, 'user', '2025-12-08 12:11:17', '2025-12-08 12:11:17'),
(51, 51, 'user', '2025-12-08 15:54:10', '2025-12-08 15:54:10'),
(52, 52, 'user', '2025-12-08 16:05:02', '2025-12-08 16:05:02'),
(53, 53, 'user', '2025-12-09 01:32:50', '2025-12-09 01:32:50'),
(54, 54, 'user', '2025-12-09 01:34:36', '2025-12-09 01:34:36'),
(55, 55, 'user', '2025-12-09 10:38:50', '2025-12-09 10:38:50'),
(56, 56, 'user', '2025-12-09 14:48:23', '2025-12-09 14:48:23'),
(57, 57, 'user', '2025-12-09 19:35:15', '2025-12-09 19:35:15'),
(58, 58, 'user', '2025-12-09 19:54:03', '2025-12-09 19:54:03'),
(59, 59, 'user', '2025-12-10 01:12:53', '2025-12-10 01:12:53'),
(60, 60, 'user', '2025-12-10 09:53:43', '2025-12-10 09:53:43'),
(61, 61, 'user', '2025-12-10 11:09:26', '2025-12-10 11:09:26'),
(62, 62, 'user', '2025-12-10 18:02:28', '2025-12-10 18:02:28'),
(63, 63, 'user', '2025-12-10 23:45:00', '2025-12-10 23:45:00'),
(64, 64, 'user', '2025-12-11 02:03:09', '2025-12-11 02:03:09'),
(65, 65, 'user', '2025-12-11 04:16:55', '2025-12-11 04:16:55'),
(66, 66, 'user', '2025-12-11 21:40:43', '2025-12-11 21:40:43'),
(67, 67, 'user', '2025-12-12 01:46:09', '2025-12-12 01:46:09'),
(68, 68, 'user', '2025-12-12 08:37:07', '2025-12-12 08:37:07'),
(69, 69, 'user', '2025-12-12 12:17:06', '2025-12-12 12:17:06'),
(70, 70, 'user', '2025-12-12 18:55:21', '2025-12-12 18:55:21'),
(71, 71, 'user', '2025-12-13 17:15:10', '2025-12-13 17:15:10'),
(72, 72, 'user', '2025-12-14 01:01:33', '2025-12-14 01:01:33'),
(73, 73, 'user', '2025-12-14 21:41:10', '2025-12-14 21:41:10'),
(74, 74, 'user', '2025-12-14 21:55:54', '2025-12-14 21:55:54'),
(75, 75, 'user', '2025-12-14 22:19:49', '2025-12-14 22:19:49'),
(76, 76, 'user', '2025-12-14 22:28:17', '2025-12-14 22:28:17'),
(77, 77, 'user', '2025-12-14 23:05:50', '2025-12-14 23:05:50'),
(78, 78, 'user', '2025-12-14 23:16:55', '2025-12-14 23:16:55'),
(79, 79, 'user', '2025-12-15 00:49:09', '2025-12-15 00:49:09'),
(80, 80, 'user', '2025-12-15 13:50:53', '2025-12-15 13:50:53'),
(81, 81, 'user', '2025-12-15 16:39:31', '2025-12-15 16:39:31'),
(82, 82, 'user', '2025-12-15 18:41:28', '2025-12-15 18:41:28'),
(83, 83, 'user', '2025-12-15 19:49:49', '2025-12-15 19:49:49'),
(84, 84, 'user', '2025-12-15 19:56:22', '2025-12-15 19:56:22'),
(85, 85, 'user', '2025-12-15 20:03:44', '2025-12-15 20:03:44'),
(86, 86, 'user', '2025-12-15 21:03:54', '2025-12-15 21:03:54'),
(87, 87, 'user', '2025-12-16 00:29:48', '2025-12-16 00:29:48'),
(88, 88, 'user', '2025-12-16 00:29:58', '2025-12-16 00:29:58'),
(89, 89, 'user', '2025-12-16 00:32:22', '2025-12-16 00:32:22'),
(90, 90, 'user', '2025-12-16 00:33:45', '2025-12-16 00:33:45'),
(91, 91, 'user', '2025-12-16 00:34:04', '2025-12-16 00:34:04'),
(92, 92, 'user', '2025-12-16 00:42:03', '2025-12-16 00:42:03'),
(93, 93, 'user', '2025-12-16 00:42:54', '2025-12-16 00:42:54'),
(94, 94, 'user', '2025-12-16 00:45:40', '2025-12-16 00:45:40'),
(95, 95, 'user', '2025-12-16 00:48:27', '2025-12-16 00:48:27'),
(96, 96, 'user', '2025-12-16 00:51:37', '2025-12-16 00:51:37'),
(97, 97, 'user', '2025-12-16 00:52:10', '2025-12-16 00:52:10'),
(98, 98, 'user', '2025-12-16 00:52:55', '2025-12-16 00:52:55'),
(99, 99, 'user', '2025-12-16 01:00:10', '2025-12-16 01:00:10'),
(100, 100, 'user', '2025-12-16 01:00:40', '2025-12-16 01:00:40'),
(101, 101, 'user', '2025-12-16 01:21:39', '2025-12-16 01:21:39'),
(102, 102, 'user', '2025-12-16 02:06:28', '2025-12-16 02:06:28'),
(103, 103, 'user', '2025-12-16 02:07:32', '2025-12-16 02:07:32'),
(104, 104, 'user', '2025-12-16 02:13:28', '2025-12-16 02:13:28'),
(105, 105, 'user', '2025-12-16 06:24:01', '2025-12-16 06:24:01'),
(106, 106, 'user', '2025-12-16 12:10:06', '2025-12-16 12:10:06'),
(107, 107, 'user', '2025-12-16 12:29:43', '2025-12-16 12:29:43'),
(108, 108, 'user', '2025-12-16 12:33:53', '2025-12-16 12:33:53'),
(109, 109, 'user', '2025-12-16 12:34:22', '2025-12-16 12:34:22'),
(110, 110, 'user', '2025-12-16 12:34:57', '2025-12-16 12:34:57'),
(111, 111, 'user', '2025-12-16 12:41:11', '2025-12-16 12:41:11'),
(112, 112, 'user', '2025-12-16 12:41:25', '2025-12-16 12:41:25'),
(113, 113, 'user', '2025-12-16 12:52:12', '2025-12-16 12:52:12'),
(114, 114, 'user', '2025-12-16 12:56:13', '2025-12-16 12:56:13'),
(115, 115, 'user', '2025-12-16 12:59:39', '2025-12-16 12:59:39'),
(116, 116, 'user', '2025-12-16 13:11:29', '2025-12-16 13:11:29'),
(117, 117, 'user', '2025-12-16 13:28:00', '2025-12-16 13:28:00'),
(118, 118, 'user', '2025-12-16 14:18:12', '2025-12-16 14:18:12'),
(119, 119, 'user', '2025-12-16 14:21:50', '2025-12-16 14:21:50'),
(120, 120, 'user', '2025-12-16 14:23:01', '2025-12-16 14:23:01'),
(121, 121, 'user', '2025-12-16 14:29:23', '2025-12-16 14:29:23'),
(122, 122, 'user', '2025-12-16 14:41:15', '2025-12-16 14:41:15'),
(123, 123, 'user', '2025-12-16 14:57:32', '2025-12-16 14:57:32'),
(124, 124, 'user', '2025-12-16 15:13:14', '2025-12-16 15:13:14'),
(125, 125, 'user', '2025-12-16 15:20:39', '2025-12-16 15:20:39'),
(126, 126, 'user', '2025-12-16 15:30:08', '2025-12-16 15:30:08'),
(127, 127, 'user', '2025-12-16 16:25:21', '2025-12-16 16:25:21'),
(128, 128, 'user', '2025-12-16 17:19:23', '2025-12-16 17:19:23'),
(129, 129, 'user', '2025-12-16 17:24:07', '2025-12-16 17:24:07'),
(130, 130, 'user', '2025-12-16 17:40:38', '2025-12-16 17:40:38'),
(131, 131, 'user', '2025-12-16 20:49:01', '2025-12-16 20:49:01'),
(132, 132, 'user', '2025-12-16 21:37:15', '2025-12-16 21:37:15'),
(133, 133, 'user', '2025-12-16 22:24:04', '2025-12-16 22:24:04'),
(134, 134, 'user', '2025-12-16 22:27:49', '2025-12-16 22:27:49'),
(135, 135, 'user', '2025-12-16 22:29:40', '2025-12-16 22:29:40'),
(136, 136, 'user', '2025-12-16 22:42:50', '2025-12-16 22:42:50'),
(137, 137, 'user', '2025-12-16 22:58:36', '2025-12-16 22:58:36'),
(138, 138, 'user', '2025-12-16 23:01:36', '2025-12-16 23:01:36'),
(139, 139, 'user', '2025-12-16 23:05:15', '2025-12-16 23:05:15'),
(140, 140, 'user', '2025-12-16 23:24:07', '2025-12-16 23:24:07'),
(141, 141, 'user', '2025-12-16 23:32:53', '2025-12-16 23:32:53'),
(142, 142, 'user', '2025-12-16 23:33:44', '2025-12-16 23:33:44'),
(143, 143, 'user', '2025-12-16 23:37:06', '2025-12-16 23:37:06'),
(144, 144, 'user', '2025-12-17 01:02:05', '2025-12-17 01:02:05'),
(145, 145, 'user', '2025-12-17 01:18:46', '2025-12-17 01:18:46'),
(146, 146, 'user', '2025-12-17 02:02:49', '2025-12-17 02:02:49'),
(147, 147, 'user', '2025-12-17 03:31:54', '2025-12-17 03:31:54'),
(148, 148, 'user', '2025-12-17 08:17:39', '2025-12-17 08:17:39'),
(149, 149, 'user', '2025-12-17 19:07:35', '2025-12-17 19:07:35'),
(150, 150, 'user', '2025-12-17 23:04:36', '2025-12-17 23:04:36'),
(151, 151, 'user', '2025-12-18 02:36:36', '2025-12-18 02:36:36'),
(152, 152, 'user', '2025-12-18 19:28:06', '2025-12-18 19:28:06'),
(153, 153, 'user', '2025-12-18 19:59:54', '2025-12-18 19:59:54'),
(154, 154, 'user', '2025-12-19 14:29:34', '2025-12-19 14:29:34'),
(155, 155, 'user', '2025-12-19 15:25:21', '2025-12-19 15:25:21'),
(156, 156, 'user', '2025-12-20 13:48:10', '2025-12-20 13:48:10'),
(157, 157, 'user', '2025-12-20 14:55:52', '2025-12-20 14:55:52'),
(158, 158, 'user', '2025-12-20 17:06:22', '2025-12-20 17:06:22'),
(159, 159, 'user', '2025-12-21 13:01:37', '2025-12-21 13:01:37'),
(160, 160, 'user', '2025-12-22 13:35:35', '2025-12-22 13:35:35'),
(161, 161, 'user', '2025-12-22 21:12:04', '2025-12-22 21:12:04'),
(162, 162, 'user', '2025-12-23 01:26:32', '2025-12-23 01:26:32'),
(163, 163, 'user', '2025-12-23 15:36:49', '2025-12-23 15:36:49'),
(164, 164, 'user', '2025-12-23 17:04:52', '2025-12-23 17:04:52'),
(165, 165, 'user', '2025-12-23 23:49:36', '2025-12-23 23:49:36'),
(166, 166, 'user', '2025-12-24 16:52:15', '2025-12-24 16:52:15'),
(167, 167, 'user', '2025-12-25 00:36:14', '2025-12-25 00:36:14'),
(168, 168, 'user', '2025-12-26 02:58:32', '2025-12-26 02:58:32'),
(169, 169, 'user', '2025-12-26 12:30:10', '2025-12-26 12:30:10'),
(170, 170, 'user', '2025-12-26 13:36:31', '2025-12-26 13:36:31'),
(171, 171, 'user', '2025-12-26 13:37:15', '2025-12-26 13:37:15'),
(172, 172, 'user', '2025-12-26 13:37:40', '2025-12-26 13:37:40'),
(173, 173, 'user', '2025-12-26 13:39:46', '2025-12-26 13:39:46'),
(174, 174, 'user', '2025-12-26 13:39:54', '2025-12-26 13:39:54'),
(175, 175, 'user', '2025-12-26 13:41:32', '2025-12-26 13:41:32'),
(176, 176, 'user', '2025-12-26 13:43:00', '2025-12-26 13:43:00'),
(177, 177, 'user', '2025-12-26 13:45:01', '2025-12-26 13:45:01'),
(178, 178, 'user', '2025-12-26 13:45:02', '2025-12-26 13:45:02'),
(179, 179, 'user', '2025-12-26 13:45:35', '2025-12-26 13:45:35'),
(180, 180, 'user', '2025-12-26 13:46:18', '2025-12-26 13:46:18'),
(181, 181, 'user', '2025-12-26 13:46:32', '2025-12-26 13:46:32'),
(182, 182, 'user', '2025-12-26 13:50:57', '2025-12-26 13:50:57'),
(183, 183, 'user', '2025-12-26 13:51:04', '2025-12-26 13:51:04'),
(184, 184, 'user', '2025-12-26 13:52:16', '2025-12-26 13:52:16'),
(185, 185, 'user', '2025-12-26 13:54:35', '2025-12-26 13:54:35'),
(186, 186, 'user', '2025-12-26 13:55:26', '2025-12-26 13:55:26'),
(187, 187, 'user', '2025-12-26 13:59:07', '2025-12-26 13:59:07'),
(188, 188, 'user', '2025-12-26 14:00:46', '2025-12-26 14:00:46'),
(189, 189, 'user', '2025-12-26 14:06:40', '2025-12-26 14:06:40'),
(190, 190, 'user', '2025-12-26 14:13:26', '2025-12-26 14:13:26'),
(191, 191, 'user', '2025-12-26 14:16:52', '2025-12-26 14:16:52'),
(192, 192, 'user', '2025-12-26 14:29:00', '2025-12-26 14:29:00'),
(193, 193, 'user', '2025-12-26 14:32:52', '2025-12-26 14:32:52'),
(194, 194, 'user', '2025-12-26 14:34:09', '2025-12-26 14:34:09'),
(195, 195, 'user', '2025-12-26 14:36:22', '2025-12-26 14:36:22'),
(196, 196, 'user', '2025-12-26 15:02:47', '2025-12-26 15:02:47'),
(197, 197, 'user', '2025-12-26 15:16:50', '2025-12-26 15:16:50'),
(198, 198, 'user', '2025-12-26 15:19:28', '2025-12-26 15:19:28'),
(199, 199, 'user', '2025-12-26 16:01:02', '2025-12-26 16:01:02'),
(200, 200, 'user', '2025-12-26 16:52:40', '2025-12-26 16:52:40'),
(201, 201, 'user', '2025-12-26 18:02:35', '2025-12-26 18:02:35'),
(202, 202, 'user', '2025-12-26 18:49:15', '2025-12-26 18:49:15'),
(203, 203, 'user', '2025-12-26 19:10:35', '2025-12-26 19:10:35'),
(204, 204, 'user', '2025-12-26 19:10:59', '2025-12-26 19:10:59'),
(205, 205, 'user', '2025-12-26 21:08:21', '2025-12-26 21:08:21'),
(206, 206, 'user', '2025-12-27 02:36:25', '2025-12-27 02:36:25'),
(207, 207, 'user', '2025-12-27 22:17:36', '2025-12-27 22:17:36'),
(208, 208, 'user', '2025-12-28 01:35:21', '2025-12-28 01:35:21'),
(209, 209, 'user', '2025-12-29 20:29:48', '2025-12-29 20:29:48'),
(210, 210, 'user', '2025-12-31 12:47:50', '2025-12-31 12:47:50'),
(211, 211, 'user', '2025-12-31 21:47:27', '2025-12-31 21:47:27'),
(212, 212, 'user', '2026-01-03 13:45:44', '2026-01-03 13:45:44'),
(213, 213, 'user', '2026-01-03 13:50:27', '2026-01-03 13:50:27'),
(214, 214, 'user', '2026-01-03 15:06:36', '2026-01-03 15:06:36'),
(215, 215, 'user', '2026-01-05 10:38:27', '2026-01-05 10:38:27'),
(216, 216, 'user', '2026-01-05 11:58:53', '2026-01-05 11:58:53'),
(217, 217, 'user', '2026-01-05 12:40:28', '2026-01-05 12:40:28'),
(218, 218, 'user', '2026-01-05 15:23:19', '2026-01-05 15:23:19'),
(219, 219, 'user', '2026-01-05 20:02:46', '2026-01-05 20:02:46'),
(220, 220, 'user', '2026-01-06 01:10:15', '2026-01-06 01:10:15'),
(221, 221, 'user', '2026-01-06 15:58:48', '2026-01-06 15:58:48'),
(222, 222, 'user', '2026-01-06 16:06:08', '2026-01-06 16:06:08'),
(223, 223, 'user', '2026-01-06 16:18:22', '2026-01-06 16:18:22'),
(224, 224, 'user', '2026-01-06 17:02:05', '2026-01-06 17:02:05'),
(225, 225, 'user', '2026-01-06 17:08:50', '2026-01-06 17:08:50'),
(226, 226, 'user', '2026-01-06 17:12:16', '2026-01-06 17:12:16'),
(227, 227, 'user', '2026-01-06 17:40:25', '2026-01-06 17:40:25'),
(228, 228, 'user', '2026-01-06 17:50:48', '2026-01-06 17:50:48'),
(229, 229, 'user', '2026-01-06 17:54:13', '2026-01-06 17:54:13'),
(230, 230, 'user', '2026-01-06 19:00:09', '2026-01-06 19:00:09'),
(231, 231, 'user', '2026-01-06 19:05:10', '2026-01-06 19:05:10'),
(232, 232, 'user', '2026-01-06 19:30:37', '2026-01-06 19:30:37'),
(233, 233, 'user', '2026-01-06 22:22:24', '2026-01-06 22:22:24'),
(234, 234, 'user', '2026-01-06 22:32:03', '2026-01-06 22:32:03'),
(235, 235, 'user', '2026-01-07 02:29:24', '2026-01-07 02:29:24'),
(236, 236, 'user', '2026-01-07 17:21:53', '2026-01-07 17:21:53'),
(237, 237, 'user', '2026-01-07 17:48:23', '2026-01-07 17:48:23'),
(238, 238, 'user', '2026-01-08 00:08:35', '2026-01-08 00:08:35'),
(239, 239, 'user', '2026-01-08 17:27:25', '2026-01-08 17:27:25'),
(240, 240, 'user', '2026-01-08 17:28:35', '2026-01-08 17:28:35'),
(241, 241, 'user', '2026-01-08 18:26:12', '2026-01-08 18:26:12'),
(242, 242, 'user', '2026-01-08 23:54:44', '2026-01-08 23:54:44'),
(243, 243, 'user', '2026-01-09 04:13:19', '2026-01-09 04:13:19'),
(244, 244, 'user', '2026-01-09 20:47:37', '2026-01-09 20:47:37'),
(245, 245, 'user', '2026-01-12 10:05:52', '2026-01-12 10:05:52'),
(246, 246, 'user', '2026-01-12 11:01:42', '2026-01-12 11:01:42'),
(247, 247, 'user', '2026-01-12 14:23:58', '2026-01-12 14:23:58'),
(248, 248, 'user', '2026-01-12 15:51:51', '2026-01-12 15:51:51'),
(249, 249, 'user', '2026-01-12 19:57:32', '2026-01-12 19:57:32'),
(250, 250, 'user', '2026-01-12 20:16:53', '2026-01-12 20:16:53'),
(251, 251, 'user', '2026-01-13 23:16:27', '2026-01-13 23:16:27'),
(252, 252, 'user', '2026-01-14 02:48:53', '2026-01-14 02:48:53'),
(253, 253, 'user', '2026-01-14 12:54:55', '2026-01-14 12:54:55'),
(254, 254, 'user', '2026-01-15 09:47:28', '2026-01-15 09:47:28'),
(255, 255, 'user', '2026-01-15 12:44:59', '2026-01-15 12:44:59'),
(256, 256, 'user', '2026-01-15 17:26:25', '2026-01-15 17:26:25'),
(257, 257, 'user', '2026-01-15 17:41:26', '2026-01-15 17:41:26'),
(258, 258, 'user', '2026-01-15 20:47:35', '2026-01-15 20:47:35'),
(259, 259, 'user', '2026-01-16 22:16:41', '2026-01-16 22:16:41'),
(260, 260, 'user', '2026-01-18 11:27:42', '2026-01-18 11:27:42'),
(261, 261, 'user', '2026-01-18 21:36:06', '2026-01-18 21:36:06'),
(262, 262, 'user', '2026-01-19 23:19:55', '2026-01-19 23:19:55'),
(263, 263, 'user', '2026-01-20 01:39:37', '2026-01-20 01:39:37'),
(264, 264, 'user', '2026-01-20 21:51:57', '2026-01-20 21:51:57'),
(265, 265, 'user', '2026-01-20 22:42:43', '2026-01-20 22:42:43'),
(266, 266, 'user', '2026-01-21 22:37:09', '2026-01-21 22:37:09'),
(267, 267, 'user', '2026-01-22 22:51:33', '2026-01-22 22:51:33'),
(268, 268, 'user', '2026-01-23 16:42:28', '2026-01-23 16:42:28'),
(269, 269, 'user', '2026-01-25 19:03:32', '2026-01-25 19:03:32');


-- --------------------------------------------------------

--
-- Table structure for table `usages`
--

CREATE TABLE `usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` varchar(255) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `reset_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compliance_reports`
--

CREATE TABLE `compliance_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jurisdiction` varchar(255) NOT NULL,
  `industries` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`industries`)),
  `frequency` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `sources` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sources`)),
  `recipient_email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `case_reminders`
--
ALTER TABLE `case_reminders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_reminders_user_id_foreign` (`user_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_user_id_index` (`user_id`),
  ADD KEY `documents_agent_id_index` (`agent_id`(250)),
  ADD KEY `documents_type_index` (`type`);

--
-- Indexes for table `document_processing_results`
--
ALTER TABLE `document_processing_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_processing_results_template_document_id_foreign` (`template_document_id`),
  ADD KEY `document_processing_results_supporting_document_id_foreign` (`supporting_document_id`),
  ADD KEY `document_processing_results_user_id_index` (`user_id`),
  ADD KEY `document_processing_results_agent_id_index` (`agent_id`(250)),
  ADD KEY `document_processing_results_status_index` (`status`);

--
-- Indexes for table `document_templates`
--
ALTER TABLE `document_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `document_templates_user_id_name_deleted_at_unique` (`user_id`,`name`,`deleted_at`) USING HASH,
  ADD KEY `document_templates_user_id_index` (`user_id`),
  ADD KEY `document_templates_agent_id_index` (`agent_id`(250)),
  ADD KEY `document_templates_is_public_index` (`is_public`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_logs_case_reminder_id_foreign` (`case_reminder_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `referrals_referral_code_unique` (`referral_code`) USING HASH,
  ADD KEY `referrals_referrer_id_foreign` (`referrer_id`),
  ADD KEY `referrals_referred_user_id_foreign` (`referred_user_id`);

--
-- Indexes for table `referral_clicks`
--
ALTER TABLE `referral_clicks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `referral_clicks_referral_id_foreign` (`referral_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscriptions_flutterwave_tx_ref_unique` (`flutterwave_tx_ref`),
  ADD KEY `subscriptions_user_id_foreign` (`user_id`);


--
-- Indexes for table `usages`
--
ALTER TABLE `usages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usages_user_id_agent_id_unique` (`user_id`,`agent_id`);

--
-- Indexes for table `compliance_reports`
--
ALTER TABLE `compliance_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compliance_reports_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_roles_user_id_role_unique` (`user_id`,`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `case_reminders`
--
ALTER TABLE `case_reminders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_processing_results`
--
ALTER TABLE `document_processing_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_templates`
--
ALTER TABLE `document_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=401;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `referral_clicks`
--
ALTER TABLE `referral_clicks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=374;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=297;


--
-- AUTO_INCREMENT for table `usages`
--
ALTER TABLE `usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compliance_reports`
--
ALTER TABLE `compliance_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `case_reminders`
--
ALTER TABLE `case_reminders`
  ADD CONSTRAINT `case_reminders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;


--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `referrals`
--
ALTER TABLE `referrals`
  ADD CONSTRAINT `referrals_referred_user_id_foreign` FOREIGN KEY (`referred_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `referrals_referrer_id_foreign` FOREIGN KEY (`referrer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `referral_clicks`
--
ALTER TABLE `referral_clicks`
  ADD CONSTRAINT `referral_clicks_referral_id_foreign` FOREIGN KEY (`referral_id`) REFERENCES `referrals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usages`
--
ALTER TABLE `usages`
  ADD CONSTRAINT `usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `compliance_reports`
--
ALTER TABLE `compliance_reports`
  ADD CONSTRAINT `compliance_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

-- --------------------------------------------------------
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
