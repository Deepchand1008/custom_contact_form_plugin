<section class="get-in-touch">
    <h1 class="title">Get in touch</h1>
    <form class="contact-form row" method="post" action="">
        <?php
        $fields = get_option('my_contact_form_fields', array(
            array('label' => 'Name', 'type' => 'text', 'name' => 'cf-name'),
            array('label' => 'E-mail', 'type' => 'email', 'name' => 'cf-email'),
            array('label' => 'Company Name', 'type' => 'text', 'name' => 'cf-company'),
            array('label' => 'Contact Number', 'type' => 'tel', 'name' => 'cf-contact'),
            array('label' => 'Message', 'type' => 'textarea', 'name' => 'cf-message'),
        ));
        foreach ($fields as $field) {
            $type = $field['type'];
            $name = esc_attr($field['name']);
            $label = esc_html($field['label']);
            ?>
            <div class="form-field col-lg-<?php echo $type === 'textarea' ? '12' : '6'; ?>">
                <?php if ($type === 'textarea'): ?>
                    <textarea id="<?php echo $name; ?>" class="input-text js-input" name="<?php echo $name; ?>" required></textarea>
                <?php else: ?>
                    <input id="<?php echo $name; ?>" class="input-text js-input" type="<?php echo $type; ?>" name="<?php echo $name; ?>" required>
                <?php endif; ?>
                <label class="label" for="<?php echo $name; ?>"><?php echo $label; ?></label>
            </div>
            <?php
        }
        ?>
        <div class="form-field col-lg-12">
            <input class="submit-btn" type="submit" name="cf-submitted" value="Submit">
        </div>
    </form>
</section>
