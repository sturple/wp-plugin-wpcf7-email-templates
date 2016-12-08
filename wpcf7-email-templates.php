<?php
/**
 * Plugin Name: Contact Form 7 Email Templates (3rd Party)
 * Plugin URI: https://github.com/sturple/wpcf7-email-templates/
 * Description: This plugin adds Email Templates to Contact Form 7
 * Version: 0.0.7
 * Author: Shawn Turple
 * Author URI: http://turple.ca
 * License: GPL-3.0
 */

add_filter( 'wpcf7_mail_components',function($components,$form, $mail ){
    $submission = WPCF7_Submission::get_instance();
    $form_prop = $form->get_properties();
    $form_prop['title'] = $form->title();
    // do nothing, but will have its own template
    $body = $components['body'];
    if (class_exists('Timber')){
        $message = _('Twig Error %1$s Could not load %2$s template');
        $template = 'wpcf7-email-mail.twig';
        $data = array('posted'=>$submission->get_posted_data(), 'form'=>$form_prop,'body_message'=>$body);
      
        // adding filter hook to update variables.
        $data = apply_filters('wpcf7_fg_email_data',$data);
        
        if ($mail->name() == 'mail_2') {
            $template = 'wpcf7-email-mail-2.twig';
        }
        
        try {
            $body = Timber::compile($template, $data );
        }
        catch (\Twig_Error_Loader $e){
            if ( WP_DEBUG ) {
                //trigger_error( sprintf( $message, $e, $template ) );
            }            
        } 
    }
    
    // add logic for php file templates
    else {
        
    }
    $components['body'] = $body;    
    return $components;
    
},10,3);

// this could be used to setting the form, but need a way of calling template maybe shortcode
add_filter('wpcf7_contact_form_properties',function($properties){
    $properties['form']  = do_shortcode($properties['form']);
    return $properties;
});
// add new settings panel for template -- currently it is information
add_filter('wpcf7_editor_panels',function($panels){
    $panels['fg-template-panel'] = array(
        'title' => __('Template Plugin', 'fgms'),
        'callback' => 'wpcf7_editor_panel_fg_template'
        );    
    return $panels;
});

function wpcf7_editor_panel_fg_template (){
    ?>
    <h2 style="font-size: 1.5em; font-weight: bold;">Email Templates (Contact Form 7 Email Templates Plugin)</h2>
    <em style="font-size: 1.2em;">By Enabling the Contact Form 7 Email Templates Plugin, the email message areas are added to template variable body_message.</em>
    <h3>Timber (Twig) Templates</h3>
    <p>If <strong>Timber</strong> is installed add the following templates '<strong>wpcf7-email-mail.twig</strong>' and '<strong>wpcf7-email-mail-2.twig</strong>'.</p>
    <p>Twig variables: {{body_message}} {{posted.[name-of-field]}} ie if you use [your_email] then it would show up as {{posted.your_email}}</p>
    <p><strong>Important only use alpha numeric and underscores for post variables</strong></p>
    <h3>Php Template</h3>
    <p>If using <strong>PHP</strong> templates then add the following templates '<strong>includes/wpcf7/wpcf7-email-mail.php</strong>' and '<strong>includes/wpcf7/wpcf7-email-mail-2.php</strong>'</p>
    <p><strong>Php templates not implemented</strong></p>
    <h2>Form Fields</h2>
    <p>Form Fields can now contain shortcodes.  This is usefull for loading in a custom template ie [custom-template template="form-compact.twig"]</p>
    <h3>Examples</h3>
    <p>[custom-template template="form-compact.twig" class_label="sr-only" class_input="" ]</p>
    <p>[custom-template template="form-inquiry.twig" class_label="col-sm-3" class_input="col-sm-9"]</p>
    <?php
 
}
?>