<?php

namespace App\Constants;

class Status {
    const ENABLE  = 1;
    const DISABLE = 0;

    const YES = 1;
    const NO  = 0;

    const VERIFIED   = 1;
    const UNVERIFIED = 0;

    const PAYMENT_INITIATE = 0;
    const PAYMENT_SUCCESS  = 1;
    const PAYMENT_PENDING  = 2;
    const PAYMENT_REJECT   = 3;

    const TICKET_OPEN   = 0;
    const TICKET_ANSWER = 1;
    const TICKET_REPLY  = 2;
    const TICKET_CLOSE  = 3;

    const PRIORITY_LOW    = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_HIGH   = 3;

    const USER_ACTIVE = 1;
    const USER_BAN    = 0;

    const GOOGLE_PAY = 5001;

    const CUR_BOTH = 1;
    const CUR_TEXT = 2;
    const CUR_SYM  = 3;

    const JOB_APPROVED   = 1;
    const JOB_REJECTED   = 2;
    const JOB_EXPIRED    = 3;
    const JOB_PENDING    = 4;
    const JOB_INCOMPLETE = 0;

    const SUBSCRIPTION_APPROVED = 1;
    const SUBSCRIPTION_PENDING  = 2;
    const SUBSCRIPTION_EXPIRED  = 3;

    const JOB_APPLY_PENDING  = 0;
    const JOB_APPLY_APPROVED = 1;
    const JOB_APPLY_REJECTED = 2;
    const JOB_APPLY_DRAFT    = 3;

    const EMPLOYER_ACTIVE = 1;
    const EMPLOYER_BAN    = 0;

    const MALE       = 1;
    const FEMALE     = 2;
    const OTHERS     = 3;
    const ANY_GENDER = 4;

    const SINGLE    = 1;
    const MARRIED   = 2;
    const DIVORCED  = 3;
    const SEPARATED = 4;

    const ONSITE = 1;
    const REMOTE = 2;
    const FIELD  = 3;
    const HYBRID = 4;

    const NEGOTIATION = 1;
    const RANGE       = 2;

    const WORK_STATUS_FRESHER    = 1;
    const WORK_STATUS_EXPERIENCE = 2;

    const IMMEDIATE           = 1;
    const ONE_MONTH           = 2;
    const TWO_MONTH           = 3;
    const MORE_THEN_TWO_MONTH = 4;

    const FULL_TIME  = 1;
    const PART_TIME  = 2;
    const INTERNSHIP = 3;

    const PROJECT_RUNNING   = 1;
    const PROJECT_COMPLETED = 2;

    const PATENT_ISSUED  = 1;
    const PATENT_PENDING = 2;

    const PERMANENT   = 1;
    const CONTRACTUAL = 2;

    const LANGUAGE_BEGINNER   = 1;
    const LANGUAGE_PROFICIENT = 2;
    const LANGUAGE_EXPERT     = 3;

    const JOB_STEP_BASIC       = 0;
    const JOB_STEP_INFORMATION = 1;
    const JOB_STEP_DETAILS     = 2;
}
