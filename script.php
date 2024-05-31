<?php
//update your java path
$javaPath = '/home/melcylif/public_html/d/jdk1.8.0_151/bin/java';
$jarFile = 'jasper.jar';

$hdid = isset($_GET['hdid']) ? $_GET['hdid'] : null;
$reportFileName = isset($_GET['reportFileName']) ? $_GET['reportFileName'] : null;

if ($hdid === null || $reportFileName === null) {
    die("Both hdid and reportFileName parameters are required.");
}
//update your mysql db details
$dbUrl = "jdbc:mysql://localhost:3306/databasename";
$dbUsername = "dbuser";
$dbPassword = "password";


$reportFilePath = 'report.pdf';
if (file_exists($reportFilePath)) {
    unlink($reportFilePath);
}

$command = $javaPath . " -jar " . escapeshellarg($jarFile) . " " . escapeshellarg($hdid) . " " . escapeshellarg($reportFileName) . " " . escapeshellarg($dbUrl) . " " . escapeshellarg($dbUsername) . " " . escapeshellarg($dbPassword) . " 2>&1";

$output = shell_exec($command);

if (file_exists($reportFilePath)) {
    $pdfUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/d/' . $reportFilePath . '?cache=' . time();

    header("Cache-Control: no-cache, no-store, must-revalidate"); 
    header("Pragma: no-cache");
    header("Expires: 0");

    echo "<script>window.open('$pdfUrl', '_blank');</script>";
} else {
    echo "<pre>Report generation failed. Please check the logs for details.</pre>";
    echo "<pre>$output</pre>";
}
?>
