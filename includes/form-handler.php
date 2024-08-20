<?php

function my_contact_form_handle_submission() {
    if (isset($_POST['cf-submitted'])) {
        $email_to = get_option('my_contact_form_email', get_option('admin_email'));
        $subject = get_option('my_contact_form_subject', 'New Contact Form Message');
        $success_message = get_option('my_contact_form_success_message', 'Thank you for your message!');
        
        $fields = get_option('my_contact_form_fields', array());
        $message = '';

        foreach ($fields as $field) {
            $name = $field['name'];
            $label = $field['label'];
            $value = isset($_POST[$name]) ? sanitize_text_field($_POST[$name]) : '';
            $message .= "$label: $value\n";
        }

        wp_mail($email_to, $subject, $message);

        echo '<div class="contact-form-message">' . esc_html($success_message) . '</div>';
    }
}
add_action('wp', 'my_contact_form_handle_submission');
