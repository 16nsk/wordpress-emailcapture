<?php // Make sure we don't expose any info if called directly (from Akistmet)
/**
 * If you edit this file, make sure you don't close/open php as it will fail!
 */

if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="captured_emails.csv"');
header('Pragma: no-cache');

global $wpdb;
$emailcapture_table = $wpdb->prefix . "emailcaptures";
$query = "SELECT * FROM {$emailcapture_table} ORDER BY created_at DESC";
$results = $wpdb->get_results($query);

echo "\"No\",\"Email\",\"Other fields\",\"Date in\"\n";

foreach ($results as $key => $values) {
	echo $key + 1 . ",";
	echo "\"{$values->email}\",\"{$values->other_fields}\",\"{$values->created_at}\"\n";
}
