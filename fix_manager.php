<?php
$file = 'app/Http/Controllers/HomeController.php';
$content = file_get_contents($file);

// Fix 1: Change requested_by to department_id in manager query
$content = preg_replace(
    "/->where\(\'requested_by\', \$user->id\)/",
    "->where('department_id', \$user->department_id)",
    $content
);

// Fix 2: Remove redundant && $user->department_id check
$content = preg_replace(
    "/elseif \(\$isManager && \$user->department_id\) \{\n\s+\$statusQuery->where\('department_id', \$user->department_id\);\n\s+\s+\}/s",
    "elseif (\$isManager) {\n            \$statusQuery->where('department_id', \$user->department_id);\n        }",
    $content
);

file_put_contents($file, $content);
echo "Fixed";
