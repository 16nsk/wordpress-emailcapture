<?php // Make sure we don't expose any info if called directly (from Akistmet)
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
?>
<div class="instruction-text" style="
background: #FCF8E3;
border: 1px solid #FBEED5;
border-radius: 4px 4px 4px 4px;
margin: 20px 0px;
padding: 8px 14px;
color: #C09853;
">
<h1>Captured emails</h1>
<p>
    <br>Enter the following shortcode text inside an article:
    <br>[ec email="Email" visitor_name="Name" phone="Phone"]
    <br>You can place your hidden content here (add a file link using ADD MEDIA)
    <br>[/ec]</p>

    <p>You can have multiple fields, such as visitor_name, email, phone number. The word inside "quotation marks" represents the label of the field shown on the page.
        <br>Please be aware that the field: 'name' cannot be used as the word name is reserved by the system.
        <br>
    </p>
</div>

<?php
global $wpdb;
$emailcapture_table = $wpdb->prefix . "emailcaptures";
$query = "SELECT * FROM {$emailcapture_table} ORDER BY created_at DESC";
$results = $wpdb->get_results($query);
?>

<?php if (!empty($results)) : ?>

<a href="<?php echo admin_url('admin-post.php?action=emailcaptures_export'); ?>">Export CSV</a>

    <div class="table-wrapper" style="padding-right: 20px;">        
        <table class="wp-list-table widefat fixed striped pages">
            <colgroup>
                <col span="1" style="width: 5%;">
                <col span="1" style="width: 20%;">
                <col span="1" style="width: 40%;">
                <col span="1" style="width: 10%;">
            </colgroup>
        <thead>
            <tr>
                <th>No.</th>
                <th>Email</th>
                <th>Other fields</th>
                <th>Date captured</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $value) : ?>
                <tr>
                    <td><?php echo $value->id; ?></td>
                    <td><?php echo '<a href="mailto:'.$value->email.'">'.$value->email.'</a>'; ?></td>
                    <td><?php echo $value->other_fields; ?></td>
                    <td><?php echo $value->created_at; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php else: ?>
<h2>No entries yet...</h2>
<p>Try a submission yourself or wait a bit longer...</p>
<?php endif; ?>
