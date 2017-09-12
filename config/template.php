<?php return array (
    'welcome-email-customer' => array(
    	'category' => 'customer',
      'subject' => 'Welcome Email Customer | [COMPANY_NAME]',
      'fields' => 'NAME, USERNAME, EMAIL, PASSWORD, COMPANY_NAME, COMPANY_EMAIL, COMPANY_PHONE, COMPANY_WEBSITE, COMPANY_ADDRESS,CURRENT_DATE,CURRENT_DATE_TIME'
      ),
    'welcome-email-staff' => array(
    	'category' => 'staff',
      'subject' => 'Welcome Email Staff | [COMPANY_NAME]',
      'fields' => 'NAME, USERNAME, EMAIL, PASSWORD, DESIGNATION, DEPARTMENT, ADDRESS, COMPANY_NAME, COMPANY_EMAIL, COMPANY_PHONE, COMPANY_WEBSITE, COMPANY_ADDRESS,CURRENT_DATE,CURRENT_DATE_TIME'
      ),
    'birthday-email-customer' => array(
      'category' => 'customer',
      'subject' => 'Happy Birthday [NAME] | [COMPANY_NAME]'
      ),
    'anniversary-email-customer' => array(
      'category' => 'customer',
      'subject' => 'Wish You a Very Happy Anniversary [NAME] | [COMPANY_NAME]'
      ),
    'birthday-email-staff' => array(
      'category' => 'staff',
      'subject' => 'Happy Birthday [NAME] | [COMPANY_NAME]'
      ),
    'anniversary-email-staff' => array(
      'category' => 'staff',
      'subject' => 'Wish You a Very Happy Anniversary [NAME] | [COMPANY_NAME]'
      ),
    'send-invoice' => array(
    	'category' => 'invoice',
      'subject' => 'Send Invoice | [COMPANY_NAME]',
        'fields' => 'CUSTOMER_NAME, CUSTOMER_EMAIL, CUSTOMER_PHONE, INVOICE_NUMBER, REFERENCE_NUMBER, INVOICE_DATE, INVOICE_DUE_DATE, INVOICE_TOTAL, INVOICE_LINK,CURRENT_DATE,CURRENT_DATE_TIME'
      ),
    'invoice-payment-reminder' => array(
      'category' => 'invoice',
      'subject' => 'Invoice Payment Reminder | [COMPANY_NAME]',
        'fields' => 'CUSTOMER_NAME, CUSTOMER_EMAIL, CUSTOMER_PHONE, INVOICE_NUMBER, REFERENCE_NUMBER, INVOICE_DATE, INVOICE_DUE_DATE, INVOICE_TOTAL, INVOICE_LINK,CURRENT_DATE,CURRENT_DATE_TIME'
      ),
    'invoice-overdue' => array(
      'category' => 'invoice',
      'subject' => 'Invoice Overdue | [COMPANY_NAME]',
      'fields' => 'CUSTOMER_NAME, CUSTOMER_EMAIL, CUSTOMER_PHONE, INVOICE_NUMBER, REFERENCE_NUMBER, INVOICE_DATE, INVOICE_DUE_DATE, INVOICE_TOTAL, INVOICE_LINK,CURRENT_DATE,CURRENT_DATE_TIME'
      ),
    'invoice-payment-confirmation' => array(
      'category' => 'invoice-payment',
      'subject' => 'Invoice Payment Confirmation [COMPANY_NAME]',
      'fields' => 'CUSTOMER_NAME, CUSTOMER_EMAIL, CUSTOMER_PHONE, INVOICE_NUMBER, REFERENCE_NUMBER, INVOICE_DATE, INVOICE_DUE_DATE, INVOICE_TOTAL, INVOICE_LINK,CURRENT_DATE,CURRENT_DATE_TIME, PAYMENT_AMOUNT, PAYMENT_METHOD, PAYMENT_DATE, TRANSACTION_TOKEN'
      ),
    'send-quotation' => array(
      'category' => 'quotation',
      'subject' => 'Send Quotation | [COMPANY_NAME]',
      'fields' => 'CUSTOMER_NAME, CUSTOMER_EMAIL, CUSTOMER_PHONE, QUOTATION_NUMBER, REFERENCE_NUMBER, QUOTATION_DATE, QUOTATION_EXPIRY_DATE, QUOTATION_TOTAL, QUOTATION_LINK,CURRENT_DATE,CURRENT_DATE_TIME'
      ),
    'quotation-reminder' => array(
      'category' => 'quotation',
      'subject' => 'Quotation Reminder [COMPANY_NAME]',
      'fields' => 'CUSTOMER_NAME, CUSTOMER_EMAIL, CUSTOMER_PHONE, QUOTATION_NUMBER, REFERENCE_NUMBER, QUOTATION_DATE, QUOTATION_EXPIRY_DATE, QUOTATION_TOTAL, QUOTATION_LINK,CURRENT_DATE,CURRENT_DATE_TIME'
      ),
    'quotation-accepted' => array(
      'category' => 'quotation',
      'subject' => 'Quotation Accepted | [COMPANY_NAME]',
      'fields' => 'CUSTOMER_NAME, CUSTOMER_EMAIL, CUSTOMER_PHONE, QUOTATION_NUMBER, REFERENCE_NUMBER, QUOTATION_DATE, QUOTATION_EXPIRY_DATE, QUOTATION_TOTAL, QUOTATION_LINK,CURRENT_DATE,CURRENT_DATE_TIME'
      ),
    'quotation-rejected' => array(
      'category' => 'quotation',
      'subject' => 'Quotation Rejected | [COMPANY_NAME]',
      'fields' => 'CUSTOMER_NAME, CUSTOMER_EMAIL, CUSTOMER_PHONE, QUOTATION_NUMBER, REFERENCE_NUMBER, QUOTATION_DATE, QUOTATION_EXPIRY_DATE, QUOTATION_TOTAL, QUOTATION_LINK,CURRENT_DATE,CURRENT_DATE_TIME'
      ),
    'quotation-expired' => array(
      'category' => 'quotation',
      'subject' => 'Quotation Expired | [COMPANY_NAME]',
      'fields' => 'CUSTOMER_NAME, CUSTOMER_EMAIL, CUSTOMER_PHONE, QUOTATION_NUMBER, REFERENCE_NUMBER, QUOTATION_DATE, QUOTATION_EXPIRY_DATE, QUOTATION_TOTAL, QUOTATION_LINK,CURRENT_DATE,CURRENT_DATE_TIME'
      ),
    'invoice-payment-success' => array(
      'category' => 'invoice-payment',
      'subject' => 'Invoice Payment Success | [COMPANY_NAME]',
      'fields' => 'CUSTOMER_NAME, CUSTOMER_EMAIL, CUSTOMER_PHONE, INVOICE_NUMBER, REFERENCE_NUMBER, INVOICE_DATE, INVOICE_DUE_DATE, INVOICE_TOTAL, INVOICE_LINK, PAYMENT_AMOUNT, PAYMENT_SOURCE, TRANSACTION_TOKEN, TRANSACTION_DATE, CURRENT_DATE, CURRENT_DATE_TIME'
      ),
    'invoice-payment-failure' => array(
      'category' => 'invoice-payment',
      'subject' => 'Invoice Payment Failure | [COMPANY_NAME]',
      'fields' => 'CUSTOMER_NAME, CUSTOMER_EMAIL, CUSTOMER_PHONE, INVOICE_NUMBER, REFERENCE_NUMBER, INVOICE_DATE, INVOICE_DUE_DATE, INVOICE_TOTAL, INVOICE_LINK, PAYMENT_AMOUNT, PAYMENT_SOURCE, TRANSACTION_TOKEN, TRANSACTION_DATE, TRANSACTION_FAILURE_REASON, CURRENT_DATE, CURRENT_DATE_TIME'
      ),
  );