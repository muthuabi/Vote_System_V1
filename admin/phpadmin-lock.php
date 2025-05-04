<!-- NOT IN USE -->
<?php 
header("HTTP/1.1 403 Access Forbidden");
exit; 
?>
<div class="lock_wrapper">
     <style>
        .lock_wrapper {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            bottom:-7rem;
            cursor: pointer;
            position: fixed;
            opacity: 70%;
            transition: bottom 0.5s,opacity 0.5s;

        }
        .lock_wrapper:hover
        {
            bottom: 0;
            opacity: 100%;
        }
        .lock_wrapper b
        {
            font-size: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin: 8px 0 12px;
            box-sizing: border-box;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            margin-right: 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-dark {
            background: #333;
            color: white;
        }
        .btn-light {
            background: #ddd;
        }
        .status {
            margin: 15px 0;
            font-weight: bold;
        }
        summary{
            margin: 5px;
        }
    </style>

        <?php
            function getPhpMyAdminPath($custom = ''): string {
                if (!empty($custom)) return rtrim($custom, "/\\") . '/.htaccess';
                $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
                return $isWindows ? "C:/xampp/phpMyAdmin/.htaccess" : "/opt/lampp/phpmyadmin/.htaccess";
            }

            function securePhpMyAdminAccess($customPath = ''): bool {
                $path = getPhpMyAdminPath($customPath);
                $content = <<<HTACCESS
            <IfModule mod_authz_core.c>
                Require all denied
            </IfModule>

            <IfModule !mod_authz_core.c>
                Deny from all
            </IfModule>
            HTACCESS;
                return file_put_contents($path, $content) !== false;
            }

        function releasePhpMyAdminAccess($customPath = ''): bool {
            $path = getPhpMyAdminPath($customPath);
            return file_exists($path) ? file_put_contents($path, '') !== false : true;
        }

        // Result message
        $msg = "";
        $customPath = trim($_POST['pma_path'] ?? '');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['secure_phpmyadmin'])) {
                $msg = securePhpMyAdminAccess($customPath) ? "phpMyAdmin Locked" : "Failed to Lock";
            } elseif (isset($_POST['release_phpmyadmin'])) {
                $msg = releasePhpMyAdminAccess($customPath) ? "phpMyAdmin Unlocked" : "Failed to Unlock";
            }
        }
        ?>
    <form action="" method="post" class="lock_form">
        <details>
        <summary><b>phpMyAdmin Access Control</b></summary>
        <div>
            <label for="pma_path">Custom phpMyAdmin Path (optional):</label>
            <input type="text" name="pma_path" placeholder="Eg: C:/xampp/phpMyAdmin" value="<?php echo htmlspecialchars($customPath); ?>">
        </div>
        </details>
        <div>
            <button type="submit" name="secure_phpmyadmin" class="btn btn-dark">Lock phpMyAdmin</button>
            <button type="submit" name="release_phpmyadmin" class="btn btn-light">Unlock phpMyAdmin</button>
        </div>
        <div class="status">
            <?php if (!empty($msg)) echo $msg; ?>
        </div>
    </form>
</div>

