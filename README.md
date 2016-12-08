# Wordpress Form 7 Email Templates

By Enabling the Contact Form 7 Email Templates Plugin, the email message areas are added to template variable body_message.
    
## Timber (Twig) Templates

If **Timber** is installed add the following templates '**wpcf7-email-mail.twig**' and '**wpcf7-email-mail-2.twig**'.

### Twig variables:
* {{body_message}} - content area of email message (custom text)
* {{posted.[name-of-field]}} ie if you use [your_email] then it would show up as {{posted.your_email}}

***Important only use alpha numeric and underscores for post variables***

## Php Template

If using **PHP** templates then add the following templates '**includes/wpcf7/wpcf7-email-mail.php**' and '**includes/wpcf7/wpcf7-email-mail-2.php**'

```    
    Php templates not implemented
   
```

## Form Fields

Form Fields can now contain shortcodes.  This is usefull for loading in a custom template ie 

```
[custom-template template="form-compact.twig" class_label="sr-only" class_input="" ]
[custom-template template="form-inquiry.twig" class_label="col-sm-3" class_input="col-sm-9"]
```