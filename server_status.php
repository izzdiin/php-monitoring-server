<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="3">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Server Status</title>
</head>
<body class="bg-gray-100 p-4">

    <div class="max-w-xl mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Server Status</h1>

        <?php
        function getServerStatus() {
            $cpuUsage = shell_exec('top -b -n1 | grep "Cpu(s)" | awk \'{print $2 + $4}\'');
            $ramUsage = shell_exec('free | grep Mem | awk \'{print $3/$2 * 100.0}\'');
            $memoryUsage = shell_exec('df -h / | grep -v Filesystem | awk \'{print $5}\'');
            
            $runningProcesses = shell_exec('ps aux');
            
            return [
                'cpuUsage' => floatval($cpuUsage),
                'ramUsage' => floatval($ramUsage),
                'memoryUsage' => floatval($memoryUsage),
                'runningProcesses' => $runningProcesses,
            ];
        }

        $serverStatus = getServerStatus();
        ?>

        <div class="mb-4">
            <p><strong>CPU Usage:</strong> <?= $serverStatus['cpuUsage'] ?>%</p>
            <p><strong>RAM Usage:</strong> <?= $serverStatus['ramUsage'] ?>%</p>
            <p><strong>Memory Usage:</strong> <?= $serverStatus['memoryUsage'] ?></p>
        </div>

        <hr class="my-4">

        <h2 class="text-xl font-bold mb-2">Running Processes</h2>
        <pre class="whitespace-pre-line"><?= htmlspecialchars($serverStatus['runningProcesses']) ?></pre>
    </div>

</body>
</html>
