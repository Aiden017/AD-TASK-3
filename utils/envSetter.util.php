<?php
// Do NOT include autoload or Dotenv again — already handled in bootstrap

function env($key, $default = null)
{
    return $_ENV[$key] ?? $_SERVER[$key] ?? $default;
}
