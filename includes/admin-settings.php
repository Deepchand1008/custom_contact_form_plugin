<?php

// Register settings
function my_contact_form_register_settings() {
    register_setting('my_contact_form_options_group', 'my_contact_form_email');
    register_setting('my_contact_form_options_group', 'my_contact_form_subject');
    register_setting('my_contact_form_options_group', 'my_contact_form_success_message');
    register_setting('my_contact_form_options_group', 'my_contact_form_fields');
}
add_action('admin_init', 'my_contact_form_register_settings');

// Add settings page
function my_contact_form_menu() {
    add_options_page(
        'Contact Form Settings',
        'Contact Form',
        'manage_options',
        'my-contact-form',
        'my_contact_form_settings_page'
    );
}
add_action('admin_menu', 'my_contact_form_menu');

// Render settings page
function my_contact_form_settings_page() {
    $fields = get_option('my_contact_form_fields', array(
        array('label' => 'Name', 'type' => 'text', 'name' => 'cf-name'),
        array('label' => 'E-mail', 'type' => 'email', 'name' => 'cf-email'),
        array('label' => 'Company Name', 'type' => 'text', 'name' => 'cf-company'),
        array('label' => 'Contact Number', 'type' => 'tel', 'name' => 'cf-contact'),
        array('label' => 'Message', 'type' => 'textarea', 'name' => 'cf-message'),
    ));
?>
    <div class="wrap">
        <h1>Contact Form Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('my_contact_form_options_group');
            do_settings_sections('my_contact_form_options_group');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Recipient Email</th>
                    <td><input type="email" name="my_contact_form_email" value="<?php echo esc_attr(get_option('my_contact_form_email', get_option('admin_email'))); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Email Subject</th>
                    <td><input type="text" name="my_contact_form_subject" value="<?php echo esc_attr(get_option('my_contact_form_subject', 'New Contact Form Message')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Success Message</th>
                    <td><input type="text" name="my_contact_form_success_message" value="<?php echo esc_attr(get_option('my_contact_form_success_message', 'Thank you for your message!')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Form Fields</th>
                    <td>
                        <div id="form-fields-container">
                            <?php foreach ($fields as $index => $field): ?>
                                <div class="form-field-row">
                                    <input type="text" name="my_contact_form_fields[<?php echo $index; ?>][label]" value="<?php echo esc_attr($field['label']); ?>" placeholder="Label" />
                                    <input type="text" name="my_contact_form_fields[<?php echo $index; ?>][name]" value="<?php echo esc_attr($field['name']); ?>" placeholder="Field Name" />
                                    <select name="my_contact_form_fields[<?php echo $index; ?>][type]">
                                        <option value="text" <?php selected($field['type'], 'text'); ?>>Text</option>
                                        <option value="email" <?php selected($field['type'], 'email'); ?>>Email</option>
                                        <option value="tel" <?php selected($field['type'], 'tel'); ?>>Telephone</option>
                                        <option value="textarea" <?php selected($field['type'], 'textarea'); ?>>Textarea</option>
                                    </select>
                                    <button type="button" class="remove-field-button">Remove</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id="add-field-button">Add Field</button>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <script type="text/javascript">
        document.getElementById('add-field-button').addEventListener('click', function() {
            var container = document.getElementById('form-fields-container');
            var index = container.children.length;
            var newField = '<div class="form-field-row">' +
                '<input type="text" name="my_contact_form_fields[' + index + '][label]" placeholder="Label" />' +
                '<input type="text" name="my_contact_form_fields[' + index + '][name]" placeholder="Field Name" />' +
                '<select name="my_contact_form_fields[' + index + '][type]">' +
                '<option value="text">Text</option>' +
                '<option value="email">Email</option>' +
                '<option value="tel">Telephone</option>' +
                '<option value="textarea">Textarea</option>' +
                '</select>' +
                '<button type="button" class="remove-field-button">Remove</button>' +
                '</div>';
            container.insertAdjacentHTML('beforeend', newField);
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-field-button')) {
                e.target.parentElement.remove();
            }
        });
    </script>
<?php
}
